<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        $logData = $request->except('password');
        $logData['password'] = '********';
        Log::info('Login attempt', $logData);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if ($remember) {
                Cookie::queue('remember_email', $request->email, 60*24*30);
            } else {
                Cookie::queue(Cookie::forget('remember_email'));
            }

            $user = Auth::user();

            if ($user->status != 1) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda Sedang di Nonaktifkan.',
                ]);
            }

            // Redirect sesuai role
            switch ($user->role->name) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'drafter':
                    return redirect()->route('drafter.dashboard');
                case 'checker':
                    return redirect()->route('checker.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Role tidak dikenali.',
                    ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
