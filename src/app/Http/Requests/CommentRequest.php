<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        // 誰でもログイン済みなら許可
        return auth()->check();
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:255',
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'content.required' => 'コメントを入力してください',
            'content.max'      => 'コメントは255文字以内で入力してください',
        ];
    }
}