<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<header class="header">
    <h1 class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
    </h1>
</header>

<main class="container">
    @yield('content')
</main>

</body>
</html>
