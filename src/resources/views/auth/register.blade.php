@extends('layouts.guest')

@section('title','会員登録')

@section('content')

<h2 class="title">会員登録</h2>

<form method="POST" action="{{ route('register') }}" class="form">
    @csrf

    <label>ユーザー名</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <p class="error">{{ $message }}</p>
    @enderror

    <label>メールアドレス</label>
    <input type="text" name="email" value="{{ old('email') }}">
    @error('email')
        <p class="error">{{ $message }}</p>
    @enderror

    <label>パスワード</label>
    <input type="password" name="password">
    @error('password')
        <p class="error">{{ $message }}</p>
    @enderror

    <label>確認用パスワード</label>
    <input type="password" name="password_confirmation">
    @error('password_confirmation')
        <p class="error">{{ $message }}</p>
    @enderror

    <button type="submit" class="btn">
        登録する
    </button>
</form>

<div class="link">
    <a href="{{ route('login') }}">ログインはこちら</a>
</div>

@endsection
