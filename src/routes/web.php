<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use Illuminate\Http\Request;

// 認証メール再送
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', '認証メールを再送しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

use Illuminate\Support\Facades\Auth;
Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/products/{product}', [ProductController::class,'show'])
    ->name('products.show');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Auth Required
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::get('/purchase/cancel/{product}', function () {return "キャンセルされました";})
        ->name('purchase.cancel');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/products/{product}/like',
        [LikeController::class,'toggle'])
        ->name('products.like');

    Route::post('/products/{product}/comment',
        [CommentController::class,'store'])
        ->name('products.comment');

    Route::get('/mypage',[MypageController::class,'index'])
        ->name('mypage');

    Route::get('/purchase/{product}', [PurchaseController::class,'show'])
        ->name('purchase.show');

    Route::post('/purchase/{product}/payment', [PurchaseController::class, 'payment'])
        ->name('purchase.payment');

    Route::post('/purchase/{product}', [PurchaseController::class,'store'])
        ->name('purchase.store');

    Route::get('/purchase/address/{product}',[PurchaseController::class,'editAddress'])
        ->name('purchase.address.edit');

    Route::post('/purchase/address/{product}',[PurchaseController::class,'updateAddress'])
        ->name('purchase.address.update');

    Route::get('/purchase/success/{product}', [PurchaseController::class, 'success'])
        ->name('purchase.success');
    
    Route::get('/sell', [SellController::class,'create'])
        ->name('sell');

    Route::post('/sell', [SellController::class,'store'])
        ->name('sell.store');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

