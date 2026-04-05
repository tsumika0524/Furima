@extends('layouts.app')

@section('title','商品出品')

@section('content')

<div class="sell-wrapper">

<h2 class="sell-title">商品の出品</h2>

<form method="POST" action="{{ route('sell.store') }}" enctype="multipart/form-data">
@csrf

<label>商品画像</label>
<div class="image-upload">
    <input type="file" name="image">
</div>

@error('image')
<p class="error-message">{{ $message }}</p>
@enderror

<h3 class="section">商品の詳細</h3>

<label>カテゴリー</label>
<div class="categories">

@foreach($categories as $category)
<label class="chip">
<input type="checkbox"
       name="categories[]"
       value="{{ $category->id }}"
       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
<span>{{ $category->name }}</span>
</label>
@endforeach

</div>

@error('categories')
<p class="error-message">{{ $message }}</p>
@enderror

<label>商品の状態</label>
<select name="condition">
<option value="">選択してください</option>
<option value="良好" {{ old('condition')=='良好' ? 'selected':'' }}>良好</option>
<option value="目立った傷や汚れなし" {{ old('condition')=='目立った傷や汚れなし' ? 'selected':'' }}>目立った傷や汚れなし</option>
<option value="やや傷や汚れあり" {{ old('condition')=='やや傷や汚れあり' ? 'selected':'' }}>やや傷や汚れあり</option>
<option value="状態が悪い" {{ old('condition')=='状態が悪い' ? 'selected':'' }}>状態が悪い</option>
</select>

@error('condition')
<p class="error-message">{{ $message }}</p>
@enderror

<h3 class="section">商品名と説明</h3>

<label>商品名</label>
<input type="text" name="name" value="{{ old('name') }}">

@error('name')
<p class="error-message">{{ $message }}</p>
@enderror

<label>ブランド名</label>
<input type="text" name="brand" value="{{ old('brand') }}">

<label>商品の説明</label>
<textarea name="description">{{ old('description') }}</textarea>

@error('description')
<p class="error-message">{{ $message }}</p>
@enderror

<label>販売価格</label>

<div class="price-input">
<span class="yen">¥</span>
<input type="text"
       name="price"
       class="price-field"
       value="{{ old('price') }}"
    >
</div>

@error('price')
<p class="error-message">{{ $message }}</p>
@enderror

<button class="sell-btn-submit">出品する</button>

</form>

</div>

@endsection