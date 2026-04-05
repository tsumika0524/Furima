<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            // 商品名：入力必須
            'name' => ['required'],

            'brand' => 'required',

            // 商品説明：必須 + 255文字以内
            'description' => ['required', 'max:255'],

            // 商品画像：必須 + jpeg/png
            'image' => ['required', 'image', 'mimes:jpeg,png'],

            // カテゴリ：必須（配列）
            'categories' => ['required', 'array'],

            // 商品状態：必須
            'condition' => ['required'],

            // 価格：必須・数値・0以上
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * エラーメッセージ（評価対応）
     */
    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',

            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',

            'image.required' => '商品画像をアップロードしてください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください',

            'categories.required' => 'カテゴリーを選択してください',
            'categories.array' => 'カテゴリーの形式が正しくありません',

            'condition.required' => '商品の状態を選択してください',

            'price.required' => '販売価格を入力してください',
            'price.numeric' => '販売価格は数値で入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
        ];
    }
}