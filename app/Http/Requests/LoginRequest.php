<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Необходимо указать адрес эл.почты.',
            'email.email' => 'Указан некорректный адрес эл.почты.',
            'password.required' => 'Необходимо указать пароль.',
        ];
    }
}
