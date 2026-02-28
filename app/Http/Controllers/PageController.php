<?php

namespace App\Http\Controllers;

use App\Models\RoleInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Giriş: Kaşif ve Mimar seçimi.
     */
    public function roleSelect(): View
    {
        $roleSelect = config('livingcode.role_select');
        
        try {
            // Benzersiz IP tıklamalarını (İlgi Oranı) çek
            $kasifInterest = RoleInteraction::getUniqueClicks('kasif');
            $mimarInterest = RoleInteraction::getUniqueClicks('mimar');
            
            // Gerçek kayıtları (Kota) çek
            $kasifRegistrations = RoleInteraction::getRegistrations('kasif');
            $mimarRegistrations = RoleInteraction::getRegistrations('mimar');
        } catch (\Throwable $e) {
            // Veritabanı veya tablo yoksa varsayılan 0
            $kasifInterest = $mimarInterest = $kasifRegistrations = $mimarRegistrations = 0;
            Log::warning('Database not ready: ' . $e->getMessage());
        }

        // Oranları ve Durumları Hesapla
        foreach (['kasif', 'mimar'] as $key) {
            $interest = ($key === 'kasif') ? $kasifInterest : $mimarInterest;
            $regs = ($key === 'kasif') ? $kasifRegistrations : $mimarRegistrations;
            $quota = 50; 

            $roleSelect[$key]['sync_percent'] = min(100, round(($regs / $quota) * 100));
            $roleSelect[$key]['quota'] = $quota;

            $otherInterest = ($key === 'kasif') ? $mimarInterest : $kasifInterest;
            
            if ($interest < $otherInterest) {
                $roleSelect[$key]['status'] = 'Kritik İhtiyaç';
            } elseif ($interest > $otherInterest) {
                $roleSelect[$key]['status'] = 'Yüksek Talep';
            } else {
                $roleSelect[$key]['status'] = 'Stabil';
            }
        }

        return view('pages.role-select', [
            'roleSelect' => $roleSelect,
            'event' => config('livingcode.event'),
        ]);
    }

    /**
     * Google Form'dan gelen kayıt bildirimini işle.
     */
    public function registerFromGoogleForm(Request $request)
    {
        $secret = $request->header('X-TBD-SECRET');
        if ($secret !== 'TBD_SECURE_KEY_2026') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $role = $request->input('role'); // 'kasif' veya 'mimar'
        $email = $request->input('email');

        if (in_array($role, ['kasif', 'mimar'])) {
            try {
                RoleInteraction::updateOrCreate(
                    ['role_key' => $role, 'ip_address' => $email, 'type' => 'registration'],
                    ['updated_at' => now()]
                );
                return response()->json(['success' => true]);
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Database error'], 500);
            }
        }

        return response()->json(['error' => 'Invalid role'], 400);
    }

    /**
     * Tanıtım sayfası — seçilen role göre (Kaşif/Mimar) vurgu.
     */
    public function welcome(Request $request): View
    {
        $role = $request->query('role') ?? session('livingcode_role', 'kasif');
        if (! in_array($role, ['kasif', 'mimar'], true)) {
            $role = 'kasif';
        }

        try {
            RoleInteraction::logClick($role, $request->ip());
            session(['livingcode_role' => $role]);
        } catch (\Throwable $e) {
            Log::warning('welcome: interaction logging failed', ['error' => $e->getMessage(), 'role' => $role]);
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
}
