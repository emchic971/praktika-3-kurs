<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Показ формы входа
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Обработка входа (по логину, email или телефону)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = $credentials['login'];
        $password = $credentials['password'];

        // Проверяем по очереди: логин, телефон, email
        if (Auth::attempt(['login' => $loginField, 'password' => $password]) ||
            Auth::attempt(['phone' => $loginField, 'password' => $password]) ||
            Auth::attempt(['email' => $loginField, 'password' => $password])) {
            
            $request->session()->regenerate();
            return redirect()->intended('/catalog');
        }

        return back()->withErrors([
            'login' => 'Неверный логин, телефон, email или пароль.',
        ])->onlyInput('login');
    }

    // Выход
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/catalog');
    }
}