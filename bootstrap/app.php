<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust reverse proxy headers (HTTPS, correct host)
        $middleware->trustProxies(at: '*');

        // Use Redis for throttling when available
        if (env('REDIS_HOST') && env('CACHE_STORE') === 'redis') {
            $middleware->throttleWithRedis();
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (\Throwable $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Doğrulama hatası.',
                        'errors' => $e->errors(),
                    ], 422);
                }

                if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Kayıt bulunamadı.',
                    ], 404);
                }

                if ($status === 429) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Çok fazla istek. Lütfen bekleyin.',
                    ], 429);
                }

                if ($status >= 500) {
                    Log::error('API Error', [
                        'message' => $e->getMessage(),
                        'url' => $request->fullUrl(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'error' => $status >= 500 ? 'Sunucu hatası.' : $e->getMessage(),
                ], $status);
            }
        });
    })->create();
