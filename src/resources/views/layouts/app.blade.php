<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
</head>
<body>

    @include('layouts.header.auth')

    <main>
        @yield('content')
    </main>

</body>
</html>
