<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Http\Responses\RegisterResponse;
use App\Http\Responses\ProfileInformationUpdatedResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /*
        | ログイン画面
        | 独自 LoginController を使う場合、ここでは画面だけ指定
        */
        Fortify::loginView(function () {
            return view('auth.login');
        });

        /*
        | 会員登録画面
        */
        Fortify::registerView(function () {
            return view('auth.register');
        });

        /*
        | 会員登録処理
        */
        Fortify::createUsersUsing(
            \App\Actions\Fortify\CreateNewUser::class
        );

        /*
        | Fortifyのレスポンスクラスを置き換え
        */
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            RegisterResponse::class
        );

        $this->app->singleton(
            \Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse::class,
            ProfileInformationUpdatedResponse::class
        );

        

    }
}
