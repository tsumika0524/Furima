@extends('layouts.app')

@section('title','マイページ')

@section('content')

@if(session('success'))
    <div class="flash-success">
        {{ session('success') }}
    </div>
@endif

<div class="mypage">

    {{-- プロフィール上部 --}}
    <div class="profile-header">

        <div class="profile-left">
            <img class="avatar"
                 src="{{ auth()->user()->profile_image
                        ? asset('storage/'.auth()->user()->profile_image)
                        : asset('images/noimage.png') }}">
            <h2 class="username">{{ auth()->user()->name }}</h2>
        </div>

        <a href="{{ route('profile.edit') }}" class="edit-btn">
            プロフィールを編集
        </a>

    </div>


    {{-- タブ --}}
    <div class="tabs">
        <a href="{{ route('mypage',['tab'=>'sell']) }}"
           class="tab {{ request('tab','sell')==='sell' ? 'active':'' }}">
           出品した商品
        </a>

        <a href="{{ route('mypage',['tab'=>'buy']) }}"
           class="tab {{ request('tab')==='buy' ? 'active':'' }}">
           購入した商品
        </a>
    </div>


    {{-- 商品一覧 --}}
  
    <div class="product-grid">

     @php use Illuminate\Support\Str; @endphp

     @forelse($products as $item)
    <a href="{{ route('products.show', $item->id) }}" class="card">
        <img src="{{ $item->image
            ? (Str::startsWith($item->image,'http')
                ? $item->image
                : asset('storage/'.$item->image))
            : asset('images/noimage.png') }}">

        <p class="item-name">{{ $item->name }}</p>
    </a>
@empty
    <p>商品がありません</p>
@endforelse

</div>

</div>

@endsection