@extends('layouts.guest')

@section('title','ログイン')

@section('content')

<h2 class="title">ログイン</h2>

<form method="POST" action="{{ route('login') }}" class="form">
    @csrf

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

    @if ($errors->has('auth'))
        <p class="error">{{ $errors->first('auth') }}</p>
    @endif

    <button type="submit" class="btn">
        ログインする
    </button>
</form>

<div class="link">
    <a href="{{ route('register') }}">会員登録はこちら</a>
</div>

@endsection
