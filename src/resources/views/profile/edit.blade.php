@extends('layouts.app') {{-- ← authヘッダーを読み込むレイアウト --}}

@section('title','プロフィール設定')

@section('content')

<div class="profile-wrapper">

    <h2 class="profile-title">プロフィール設定</h2>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form">
        @csrf
        @method('PUT')

        {{-- 画像 --}}
        <div class="image-area">

            <div class="avatar">
            <img id="preview"
                src="{{ auth()->user()->profile_image 
                ? asset('storage/'.auth()->user()->profile_image) 
                : asset('images/noimage.png') }}">
           </div>

            <label class="image-btn">
                画像を選択する
                <input type="file" name="profile_image" hidden onchange="previewImage(this)">

            </label>

        </div>

        {{-- ユーザー名 --}}
        <label>ユーザー名</label>
        <input type="text" name="name" value="{{ old('name',auth()->user()->name) }}">
        @error('name')
       <p class="error">{{ $message }}</p>
        @enderror

        {{-- 郵便番号 --}}
        <label>郵便番号</label>
        <input type="text" name="postal_code" value="{{ old('postal_code',auth()->user()->postal_code) }}">
        @error('postal_code')
        <p class="error">{{ $message }}</p>
        @enderror

        {{-- 住所 --}}
        <label>住所</label>
        <input type="text" name="address" value="{{ old('address',auth()->user()->address) }}">
        @error('address')
       <p class="error">{{ $message }}</p>
        @enderror

        {{-- 建物名 --}}
        <label>建物名</label>
        <input type="text" name="building" value="{{ old('building',auth()->user()->building) }}">

        <button type="submit" class="update-btn">更新する</button>

    </form>

</div>

{{-- 画像プレビュー --}}
<script>
function previewImage(input){
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
