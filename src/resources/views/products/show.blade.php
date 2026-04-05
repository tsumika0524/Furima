@extends('layouts.app')

@section('title','商品詳細')

@section('content')

<div class="item-detail">

    {{-- 左：画像 --}}
    <div class="item-left">

        @php use Illuminate\Support\Str; @endphp

        <img class="item-image"
          src="{{ $product->image
              ? (Str::startsWith($product->image,'http')
            ? $product->image
               : asset('storage/'.$product->image))
               : asset('images/noimage.png') }}">
    </div> 

    {{-- 右：情報 --}}
    <div class="item-right">

        <h1 class="item-name">{{ $product->name }}</h1>

        <p class="brand">{{ $product->brand }}</p>

        <p class="price">¥{{ number_format($product->price) }} <span>(税込)</span></p>

        {{-- いいね・コメント --}}
        <div class="icon-row">
           {{-- いいね --}}
    <form method="POST" action="{{ route('products.like',$product->id) }}">
         @csrf
         <button class="icon-btn {{ $product->isLikedBy(auth()->user()) ? 'liked' : '' }}">
           <img
            src="{{ asset(
                $product->isLikedBy(auth()->user())
                ? 'images/heart-red.png'
                : 'images/heart.png'
            ) }}"
            class="heart-icon"
            alt="like"
           >
        </button>
    </form>

    <span>{{ $product->likes->count() }}</span>


     {{-- コメント --}}
      <img
         src="{{ asset('images/comment.png') }}"
         class="comment-icon"
        alt="comment"
       >

      <span>{{ $product->comments->count() }}</span>
           
        </div>

        @if($product->is_sold)
        <button class="buy-btn" disabled>
        売り切れ
        </button>
        @else
        <a href="{{ route('purchase.show',$product) }}" class="buy-btn">
        購入手続きへ
        </a>
        @endif

        {{-- 商品説明 --}}
        <h3 class="section-title">商品説明</h3>
        <p class="description">{!! nl2br(e($product->description)) !!}</p>

        {{-- 商品情報 --}}
        <h3 class="section-title">商品の情報</h3>

        <div class="meta">

            <div class="meta-row">
                <span class="meta-label">カテゴリー</span>
                 
                <div>
                    @foreach($product->categories as $cat)
                        <span class="tag">{{ $cat->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="meta-row">
                <span class="meta-label">商品の状態</span>
                <span>{{ $product->item_condition }}</span>
            </div>

        </div>

        {{-- コメント --}}
        <h3 class="section-title">
            コメント({{ $product->comments->count() }})
        </h3>

        @foreach($product->comments as $comment)
            <div class="comment">

                <div class="comment-user">
                    <div class="avatar">
                        <img src="{{ $comment->user->profile_image
                            ? asset('storage/'.$comment->user->profile_image)
                            : asset('images/noimage.png') }}">
                    </div>

                    <strong>{{ $comment->user->name }}</strong>
                </div>

                <div class="comment-body">
                    {{ $comment->content }}
                </div>

            </div>
        @endforeach


    <form method="POST" action="{{ route('products.comment',$product->id) }}">
    @csrf

    <label class="comment-label">商品へのコメント</label>

    {{-- ログインしていない場合は入力不可 --}}
    <textarea name="content"
        class="comment-box"
        {{ auth()->check() ? '' : 'disabled' }}
    >{{ old('content') }}</textarea>

    @error('content')
        <p class="error">{{ $message }}</p>
    @enderror

    {{-- ボタン制御 --}}
    @if(!auth()->check())
        <button class="comment-btn" disabled>
            コメントするにはログインが必要です
        </button>

    @elseif($product->is_sold)
        <button class="comment-btn" disabled>
            売り切れのためコメント出来ません
        </button>

    @else
        <button type="submit" class="comment-btn">
            コメントを送信する
        </button>
    @endif
    </form>
    </div>
    </div>

@endsection
