<header class="header">

    {{-- ロゴ --}}
    <div class="logo">
        <a href="{{ route('products.index') }}">
            <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
        </a>
    </div>

    {{-- 検索 --}}
    <form action="{{ route('products.index') }}" method="GET" class="search-form">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
    </form>

    {{-- ナビ --}}
    <nav class="nav">

        {{-- ✅ ログイン中だけ表示 --}}
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">ログアウト</button>
            </form>
        @endauth


        {{-- ✅ 未ログイン時だけ表示 --}}
        @guest
            <a href="{{ route('login') }}" class="login-btn">ログイン</a>
        @endguest


        {{-- 出品（どちらでも表示したいなら外に置く） --}}
         <a href="{{ route('mypage') }}">マイページ</a>
        <a href="{{ route('sell') }}" class="sell-btn">出品</a>

    </nav>

</header>