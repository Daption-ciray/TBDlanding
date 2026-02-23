<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeamAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $teamPassword = config('livingcode.team_password', 'takim2026');

        $password = $request->input('team_password')
            ?? $request->header('X-Team-Password');

        if (!$password || $password !== $teamPassword) {
            return response()->json([
                'success' => false,
                'error' => 'Takım şifresi gerekli veya hatalı.',
            ], 401);
        }

        return $next($request);
    }
}
