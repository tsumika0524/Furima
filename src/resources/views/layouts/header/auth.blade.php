<header class="header">

    {{-- ロゴ --}}
    <div class="logo">
        <a href="{{ route('products.index') }}">
            <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
        </a>
    </div>

    {{-- 検索 --}}
    <form action="{{ route('products.index') }}" method="GET" class="search-form">
        <input type="text" name="keyword" placeholder="なにをお探しですか？">
    </form>

    {{-- ナビ --}}
    <nav class="nav">

        {{-- ログアウト --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">ログアウト</button>
        </form>

        <a href="#">マイページ</a>

        <a href="#" class="sell-btn">出品</a>

    </nav>

</header>
