<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab','sell');

        if($tab === 'buy'){
            $products = auth()->user()->purchasedProducts; // 購入
        }else{
            $products = auth()->user()->products; // 出品
        }

        return view('mypage', compact('products','tab'));
    }
}