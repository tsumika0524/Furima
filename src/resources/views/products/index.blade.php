@extends('layouts.app')

@section('title','商品一覧')

@section('content')

<div class="tabs">
    <a href="{{ route('products.index', ['tab' => 'recommend', 'keyword' => $keyword]) }}"
       class="{{ $tab === 'recommend' ? 'active' : '' }}">
        おすすめ
    </a>

    <a href="{{ route('products.index', ['tab' => 'mylist', 'keyword' => $keyword]) }}"
       class="{{ $tab === 'mylist' ? 'active mylist' : 'mylist' }}">
        マイリスト
    </a>
</div>

<div class="items">
    @forelse ($items as $item)
        <div class="item-card">
            <div class="image-box">
                <img src="{{ $item->image_path ?? asset('images/noimage.png') }}" alt="">
                @if ($item->is_sold)
                    <span class="sold">Sold</span>
                @endif
            </div>
            <p class="item-name">{{ $item->name }}</p>
        </div>
    @empty
        <p class="empty">商品がありません</p>
    @endforelse
</div>

@endsection
