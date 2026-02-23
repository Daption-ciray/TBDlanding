<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEvrenRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->query('role') ?? session('livingcode_role');

        if (! in_array($role, ['adem', 'baba'], true)) {
            return redirect()->route('role-select');
        }

        if ($request->has('role')) {
            session(['livingcode_role' => $role]);
        }

        $request->attributes->set('evren_role', $role);

        return $next($request);
    }
}
