<?php

// app/Http/Requests/LoginRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 必ず true
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '正しいメールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }

    public function attributes()
    {
    return [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
    ];
    }
}

