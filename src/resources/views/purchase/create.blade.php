@extends('layouts.app')

@section('title','購入')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="purchase-container">

    <div class="left">

        <div class="item-box">
        @php use Illuminate\Support\Str; @endphp

        <img src="{{ $product->image
         ? (Str::startsWith($product->image, ['http://','https://'])
          ? $product->image
          : asset('storage/'.$product->image)
         )
        : asset('images/noimage.png') }}"
    class="item-image">
        <div>
        <h2>{{ $product->name }}</h2>
        <p class="price">¥ {{ number_format($product->price) }}</p>
        </div>
     </div>
        <hr>

        <form method="POST" action="{{ route('purchase.store',$product) }}">
        @csrf

        <div class="section">
            <label>支払い方法</label>

            <select name="payment_method" id="payment" class="select">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ払い</option>
                <option value="card">カード支払い</option>
            </select>

            @error('payment_method')
           <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <hr>

        <div class="section">
            <div class="address-header">
                <label>配送先</label>
                <a href="{{ route('purchase.address.edit', $product->id) }}">
                 変更する
                </a>
            </div>

            <p>〒 {{ $postal }}</p>
            <p>{{ $address }}</p>
            <p>{{ $building }}</p>

            <input type="hidden" name="address" value="{{ $address }}">

            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

    </div>

    <div class="right">

        <div class="summary">

            <div class="row">
                <span>商品代金</span>
                <span>¥ {{ number_format($product->price) }}</span>
            </div>

            <div class="row">
                <span>支払い方法</span>
                <span id="paymentLabel">---</span>
            </div>

        </div>

        @if($product->is_sold)
        <button class="buy-btn" disabled>
        Sold Out
        </button>
        @else
        <button class="buy-btn">購入する</button>
        @endif

        </form>

    </div>

</div>

<script>
document.getElementById('payment').addEventListener('change', function(){
    const map = {
        convenience:'コンビニ払い',
        card:'カード支払い'
    };
    document.getElementById('paymentLabel').textContent =
        map[this.value] ?? '---';
});
</script>

@endsection