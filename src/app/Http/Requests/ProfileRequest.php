<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
{
    return [
        'profile_image' => ['nullable','image','mimes:jpeg,png','max:2048'],
        'name' => ['required','string','max:20'],
        'postal_code' => ['required','regex:/^\d{3}[-ー−‐]\d{4}$/u'],
        'address' => ['required','string','max:255'],
        'building' => ['nullable','string','max:255'],
    ];
}

public function messages()
{
    return [
        'name.required' => 'ユーザー名を入力してください',
        'name.max' => 'ユーザー名は20文字以内で入力してください',

        'postal_code.required' => '郵便番号を入力してください',
        'postal_code.regex' => '郵便番号はハイフンありの8文字で入力してください',

        'address.required' => '住所を入力してください',

        'profile_image.mimes' => '画像はjpegまたはpng形式でアップロードしてください',
    ];
}

}
