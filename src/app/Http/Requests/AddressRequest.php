<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
    // ログインしていれば誰でも編集可能
    return auth()->check();
    }

    /**
     * バリデーション
     */
    public function rules(): array
    {
        return [
            // 郵便番号（123-4567）
            'postal_code' => [
                'required',
                'regex:/^\d{3}-\d{4}$/'
            ],

            // 住所
            'address' => [
                'required'
            ],

            // 建物名（任意）
            'building' => [
                'nullable'
            ],
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'postal_code.required' =>
                '郵便番号を入力してください',

            'postal_code.regex' =>
                '郵便番号はハイフンあり8文字(例: 123-4567)で入力してください',

            'address.required' =>
                '住所を入力してください',
        ];
    }
}