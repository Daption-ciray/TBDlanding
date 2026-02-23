<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Giriş: CS tarzı taraf seçimi (ADEM vs BABA).
     */
    public function roleSelect(): View
    {
        return view('pages.role-select', [
            'roleSelect' => config('livingcode.role_select'),
            'event' => config('livingcode.event'),
        ]);
    }

    /**
     * Tanıtım sayfası — seçilen role göre (ADEM/BABA) vurgu.
     */
    public function welcome(Request $request): View
    {
        $role = $request->query('role') ?? session('livingcode_role', 'adem');
        if (! in_array($role, ['adem', 'baba'], true)) {
            $role = 'adem';
        }
        try {
            session(['livingcode_role' => $role]);
        } catch (\Throwable $e) {
            Log::warning('welcome: session write failed', ['error' => $e->getMessage(), 'role' => $role]);
        }

        return view('pages.welcome', [
            'role' => $role,
            'phases' => config('livingcode.phases'),
            'faqs' => config('livingcode.faqs'),
            'stats' => config('livingcode.stats'),
            'sponsorTiers' => config('livingcode.sponsor_tiers'),
            'event' => config('livingcode.event'),
            'contact' => config('livingcode.contact'),
            'countdownTarget' => config('livingcode.countdown_target'),
        ]);
    }

    public function arena(Request $request): View
    {
        return view('pages.coming-soon', ['section' => 'arena']);
    }

    public function viewer(Request $request): View
    {
        return view('pages.coming-soon', ['section' => 'viewer']);
    }
}
