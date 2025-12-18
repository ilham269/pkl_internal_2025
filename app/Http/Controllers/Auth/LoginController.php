<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect setelah login.
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect dinamis setelah login berhasil.
     */
    protected function redirectTo(): string
    {
        return auth()->user()->role === 'admin'
            ? route('admin.dashboard')
            : route('home');
    }

    /**
     * Validasi input login.
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate(
            [
                $this->username() => 'required|string|email',
                'password' => 'required|string|min:6',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 6 karakter.',
            ]
        );
    }
}
