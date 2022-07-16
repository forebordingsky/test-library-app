<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:200',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed|min:6|max:200'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Необходимо указать имя пользователя.',
            'name.min' => 'Имя пользователя не может быть менее 3 символов.',
            'name.max' => 'Имя пользователя не может содержать более 200 символов.',
            'email.required' => 'Необходимо указать адрес эл.почты.',
            'email.email' => 'Указан некорректный адрес эл.почты.',
            'email.unique' => 'Пользователь с таким адресом эл.почты уже зарегистрирован.',
            'password.required' => 'Необходимо указать пароль.',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен состоять из не менее 6 символов.',
            'password.max' => 'Пароль не может содержать более 200 символов.'
        ];
    }
}
