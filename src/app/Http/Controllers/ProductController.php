<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $tab = $request->input('tab', 'recommend'); // recommend | mylist

        $query = Product::query();

        // 🔍 商品名の部分一致検索
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        // 🔒 自分の出品商品は除外（ログイン時のみ）
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if ($tab === 'mylist') {
            // 未認証は何も表示しない
            if (!Auth::check()) {
                $items = collect();
            } else {
                $items = $query
                    ->whereHas('likes', function ($q) {
                        $q->where('user_id', Auth::id());
                    })
                    ->get();
            }
        } else {
            // おすすめ（全商品）
            $items = $query->get();
        }

        return view('products.index', compact('items', 'keyword', 'tab'));
    }

    public function show($id)
    {
    $product = Product::with([
        'likes',
        'comments.user',
        'categories'
    ])->findOrFail($id);

    return view('products.show', compact('product'));
    }

    public function comment(Request $request, $id)
{
    $request->validate([
        'content' => 'required|max:255'
    ]);

    Comment::create([
        'user_id' => auth()->id(),
        'product_id' => $id,
        'content' => $request->content
    ]);

    return back();
}

}


