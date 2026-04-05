<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        // ✅ バリデーション済
        $data = $request->validated();

        // ⭐ categories を退避（重要）
        $categoryIds = $data['categories'];
        unset($data['categories']);

        // ✅ カラム名変換
        $data['item_condition'] = $data['condition'];
        unset($data['condition']);

        // ✅ 画像保存
        if ($request->hasFile('image')) {
            $data['image'] =
                $request->file('image')->store('products', 'public');
        }

        // ✅ user_id
        $data['user_id'] = auth()->id();

        // ✅ 商品保存
        $product = Product::create($data);

        // ✅ pivot保存（IDのみ）
        $product->categories()->sync($categoryIds);

        return redirect()
            ->route('mypage')
            ->with('success', '出品しました');
    }
}