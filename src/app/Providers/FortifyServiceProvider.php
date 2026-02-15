<?php

namespace App\Providers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ログイン画面
        |--------------------------------------------------------------------------
        */
        Fortify::loginView(function () {
            return view('auth.login');
        });

        /*
        |--------------------------------------------------------------------------
        | 会員登録画面
        |--------------------------------------------------------------------------
        */
        Fortify::registerView(function () {
            return view('auth.register');
        });

        /*
        |--------------------------------------------------------------------------
        | 会員登録処理（Actionクラス）
        |--------------------------------------------------------------------------
        */
        Fortify::createUsersUsing(
            \App\Actions\Fortify\CreateNewUser::class
        );

        /*
        |--------------------------------------------------------------------------
        | ログイン認証処理
        |--------------------------------------------------------------------------
        */
        Fortify::authenticateUsing(function (LoginRequest $request) {
            if (
                Auth::attempt([
                    'email'    => $request->email,
                    'password' => $request->password,
                ])
            ) {
                return Auth::user();
            }

            // 要件指定メッセージ（完全一致）
            throw ValidationException::withMessages([
                'auth' => 'ログイン情報が登録されていません',
            ]);
        });
    }
}
