<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Like; // ← これ追加
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();

        // 既にいいねしているか
        $like = Like::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();

        if ($like) {
            // いいね解除
            $like->delete();
        } else {
            // いいね追加
            Like::create([
                'user_id' => $user->id,
                'product_id' => $product->id, // ← 超重要
            ]);
        }

        return back();
    }
}