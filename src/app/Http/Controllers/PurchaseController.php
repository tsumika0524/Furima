<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class PurchaseController extends Controller
{
    public function show(Product $product)
{
    if ($product->is_sold) {
        return redirect()
            ->route('products.index')
            ->with('error','この商品はすでに購入されています');
    }

    $user = auth()->user();

    return view('purchase.create', [
        'product'  => $product,
        'postal'   => $user->postal_code,
        'address'  => $user->address,
        'building' => $user->building,
    ]);
}

    public function store(PurchaseRequest $request, Product $product)
{
    if ($product->is_sold) {
        return redirect()
            ->route('products.index')
            ->with('error','この商品はすでに購入されています');
    }

    if (Purchase::where('product_id', $product->id)->exists()) {
        return redirect()
            ->route('products.index')
            ->with('error','この商品はすでに購入されています');
    }

    // Stripe設定
    Stripe::setApiKey(config('services.stripe.secret'));

    // 支払い方法
    $paymentMethod = $request->payment_method;

    $methods = [];

    if ($paymentMethod === 'card') {
        $methods = ['card'];
    }

    if ($paymentMethod === 'konbini') {
        $methods = ['konbini'];
    }

    // Stripeセッション作成
    $session = Session::create([
        'payment_method_types' => $methods,
        'line_items' => [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => $product->price,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',

        // 決済後
        'success_url' => route('purchase.success', $product),

        // キャンセル時
        'cancel_url' => route('purchase.show', $product),
    ]);

    return redirect($session->url);
    }

    
    public function editAddress(Product $product)
    {
    $user = auth()->user();

    // User に保存されている値をフォームに渡す
    return view('purchase.address', [
        'product'  => $product,
        'postal'   => old('postal_code', $user->postal_code),
        'address'  => old('address', $user->address),
        'building' => old('building', $user->building),
    ]);
    }

    public function updateAddress(AddressRequest $request, Product $product)
    {
    $user = auth()->user();

    $data = $request->validated();

    // 空文字を null に変換（建物名削除用）
    $data['building'] = trim($data['building'] ?? '') === '' ? null : $data['building'];

    // User テーブルに保存
    $user->update($data);

    return redirect()
        ->route('purchase.show', $product)
        ->with('success', '住所を更新しました');
    }

    public function success(Product $product)
{
    $user = auth()->user();

    if (Purchase::where('product_id', $product->id)->exists()) {
        return redirect()->route('products.index');
    }

    Purchase::create([
        'user_id'        => $user->id,
        'product_id'     => $product->id,
        'payment_method' => 'stripe',
        'total_price'    => $product->price,
        'postal_code'    => $user->postal_code,
        'address'        => $user->address,
        'building'       => $user->building,
    ]);

    $product->update([
        'is_sold' => true
    ]);

    return redirect()
        ->route('products.index')
        ->with('success','購入が完了しました');
    }

    public function payment(Request $request, Product $product)
    {
    // バリデーション
    $request->validate([
        'payment_method' => 'required|in:card,convenience,konbini',
    ]);

    // マッピング（テストに完全一致させる）
    $map = [
        'card' => 'credit_card',
        'convenience' => 'convenience',
        'konbini' => 'convenience',
    ];

    $method = $map[$request->payment_method];

    // セッション保存
    session([
        'payment_method' => $method
    ]);

    return back();
    }
}