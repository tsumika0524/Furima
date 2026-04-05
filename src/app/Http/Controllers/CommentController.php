<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;


class CommentController extends Controller
{
        public function store(CommentRequest $request, Product $product)
    {
    $user = auth()->user();

    $product->comments()->create([
        'user_id' => $user->id,
        'content' => $request->content,
    ]);

    return redirect()->route('products.show', $product);
    }
}