<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class SuraAuthController extends Controller
{
    public function login(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('post')) {
            $key = 'sura-login:' . $request->ip();

            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);
                return redirect()->route('sura.login')
                    ->with('error', "Çok fazla deneme. {$seconds} saniye bekleyin.");
            }

            $password = config('livingcode.sura_password', 'sura2026');

            if ($request->input('sura_password') === $password) {
                RateLimiter::clear($key);
                session(['sura_authenticated' => true, 'sura_auth_at' => now()->timestamp]);
                return redirect()->route('sura.dashboard');
            }

            RateLimiter::hit($key, 60);
            return redirect()->route('sura.login')->with('error', 'Yanlış şifre.');
        }

        return view('sura.login');
    }

    public function logout(Request $request)
    {
        session()->forget(['sura_authenticated', 'sura_auth_at']);
        return redirect()->route('sura.login')->with('message', 'Çıkış yapıldı.');
    }
}
