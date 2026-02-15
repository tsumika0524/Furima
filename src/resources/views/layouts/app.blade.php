<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
</head>
<body>

    @include('layouts.header.auth')

    <main>
        @yield('content')
    </main>

</body>
</html>
