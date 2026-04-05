@extends('layouts.app')

@section('title','商品一覧')

@section('content')

@if(session('success'))
    <div class="alert success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert error">
        {{ session('error') }}
    </div>
@endif

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

@php use Illuminate\Support\Str; @endphp

<div class="items">
    @forelse ($items as $item)
        <div class="item-card">

            <a href="{{ route('products.show',$item->id) }}">

                <div class="image-box">
                    <img
                        src="{{ $item->image
                            ? (Str::startsWith($item->image,'http')
                                ? $item->image
                                : asset('storage/'.$item->image))
                            : asset('images/noimage.png') }}"
                        alt="{{ $item->name }}"
                    >

                    @if ($item->is_sold)
                        <span class="sold">Sold</span>
                    @endif
                </div>

                <p class="item-name">{{ $item->name }}</p>

            </a>

        </div>
    @empty
        <p class="empty">商品がありません</p>
    @endforelse
</div>

@endsection
