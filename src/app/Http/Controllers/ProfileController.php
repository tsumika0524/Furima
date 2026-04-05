<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // 編集画面
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // 更新処理
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        // 画像アップロード
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles','public');
            $user->profile_image = $path;
        }

        // 更新
        $user->name        = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address     = $request->address;
        $user->building    = $request->building;

        $user->is_profile_completed = true;

        $user->save();

        // プロフィール更新後はトップ or マイページへ
        return redirect('/')->with('success','プロフィールを更新しました');
    }
}
