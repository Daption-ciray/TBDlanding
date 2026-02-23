<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuraAuth
{
    private const SESSION_MAX_AGE_SECONDS = 7200; // 2 hours

    public function handle(Request $request, Closure $next): Response
    {
        $suraPassword = config('livingcode.sura_password', 'sura2026');
        $sessionKey = 'sura_authenticated';

        if (!session($sessionKey)) {
            if ($request->isMethod('post') && $request->has('sura_password')) {
                $key = 'sura-login:' . $request->ip();

                if (RateLimiter::tooManyAttempts($key, 5)) {
                    return redirect()->route('sura.login')
                        ->with('error', 'Çok fazla deneme. Lütfen bekleyin.');
                }

                if ($request->input('sura_password') === $suraPassword) {
                    RateLimiter::clear($key);
                    session([$sessionKey => true, 'sura_auth_at' => now()->timestamp]);
                    return redirect()->route('sura.dashboard');
                }

                RateLimiter::hit($key, 60);
                return redirect()->route('sura.login')->with('error', 'Yanlış şifre.');
            }
            return redirect()->route('sura.login');
        }

        $authAt = session('sura_auth_at', 0);
        if (now()->timestamp - $authAt > self::SESSION_MAX_AGE_SECONDS) {
            session()->forget([$sessionKey, 'sura_auth_at']);
            return redirect()->route('sura.login')
                ->with('error', 'Oturum süresi doldu. Tekrar giriş yapın.');
        }

        return $next($request);
    }
}
