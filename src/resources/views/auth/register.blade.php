@extends('layouts.guest')

@section('title','会員登録')

@section('content')

<h2 class="title">会員登録</h2>

<form method="POST" action="{{ route('register') }}" class="form">
    @csrf

    <div class="form-group">
    <label>ユーザー名</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <p class="error">{{ $message }}</p>
    @enderror
    </div>

    <div class="form-group">
    <label>メールアドレス</label>
    <input type="text" name="email" value="{{ old('email') }}">
    @error('email')
        <p class="error">{{ $message }}</p>
    @enderror
    </div>

    <div class="form-group">
    <label>パスワード</label>
    <input type="password" name="password">
    @error('password')
        <p class="error">{{ $message }}</p>
    @enderror
    </div>

    <div class="form-group">
    <label>確認用パスワード</label>
    <input type="password" name="password_confirmation">
    </div>

    <div class="form-group">
    <button type="submit" class="btn">
        登録する
    </button>
    </div>
</form>

<div class="link">
    <a href="{{ route('login') }}">ログインはこちら</a>
</div>

@endsection
