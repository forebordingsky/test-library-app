<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function registerPage(){
        return view('auth.register');
    }

    public function register(RegisterRequest $request){
        $user = User::create($request->validated());
        return redirect(route('auth.login'))->with('message','Вы успешно были зарегистрированы. Пожалуйста авторизуйтесь.');
    }

    public function loginPage(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        if(Auth::attempt(['email' => $request->validated('email'),'password' => $request->validated('password')])){
            $request->session()->regenerate();
            return redirect()->intended(route('books.user'));
        }
        return back()->withErrors([
            'email' => 'Указан неверный адрес эл.почты или пароль.'
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect(route('auth.login.page'));
    }
}
