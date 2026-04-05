@extends('layouts.app')

@section('title','住所の変更')

@section('content')

<div class="address-page">

    <h2 class="address-title">住所の変更</h2>

    <form method="POST"
          action="{{ route('purchase.address.update', $product->id) }}"
          class="address-form">
        @csrf

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postal_code" value="{{ $postal }}">

            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address"     value="{{ $address }}">

            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building"    value="{{ $building }}">

            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button class="update-btn">
            更新する
        </button>

    </form>

</div>

@endsection