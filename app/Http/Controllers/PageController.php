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
            // Benzersiz tıklamaları (İlgi Oranı) çek - hem eski hem yeni isimler
            $kasifInterest = RoleInteraction::whereIn('role_key', ['kasif', 'adem'])->where('type', 'click')->count();
            $mimarInterest = RoleInteraction::whereIn('role_key', ['mimar', 'baba'])->where('type', 'click')->count();
            
            // Gerçek kayıtları (Kota) çek - hem eski hem yeni isimler
            $kasifRegistrations = RoleInteraction::whereIn('role_key', ['kasif', 'adem'])->where('type', 'registration')->count();
            $mimarRegistrations = RoleInteraction::whereIn('role_key', ['mimar', 'baba'])->where('type', 'registration')->count();
        } catch (\Throwable $e) {
            // Veritabanı veya tablo yoksa varsayılan 0
            $kasifInterest = $mimarInterest = $kasifRegistrations = $mimarRegistrations = 0;
            Log::warning('Database not ready: ' . $e->getMessage());
        }

        // Oranları ve Durumları Hesapla
        foreach (['kasif', 'mimar'] as $key) {
            $interest = ($key === 'kasif') ? $kasifInterest : $mimarInterest;
            $regs = ($key === 'kasif') ? $kasifRegistrations : $mimarRegistrations;
            $quota = config("livingcode.role_select.$key.quota", 50); 

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
        Log::info('Google Form Sync Request Received', [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'ip' => $request->ip()
        ]);

        $secret = $request->header('X-TBD-SECRET') ?? $request->input('secret');
        if ($secret !== 'TBD_SECURE_KEY_2026') {
            Log::warning('Google Form Sync: Unauthorized access attempt', [
                'header_secret' => $request->header('X-TBD-SECRET'),
                'body_secret' => $request->input('secret'),
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $role = strtolower((string) ($request->input('role') ?? '')); // 'kasif' veya 'mimar'
        
        // Alias desteği (adem=kasif, baba=mimar)
        if ($role === 'adem') $role = 'kasif';
        if ($role === 'baba') $role = 'mimar';

        $email = $request->input('email') ?? $request->input('mail') ?? 'no-email';
        // Her başvurunun benzersiz olması için formun gönderdiği ID'yi kullanıyoruz
        $submissionId = $request->input('submission_id') ?? $email;

        if (in_array($role, ['kasif', 'mimar'])) {
            try {
                $interaction = RoleInteraction::updateOrCreate(
                    ['role_key' => $role, 'ip_address' => $submissionId, 'type' => 'registration'],
                    ['updated_at' => now()]
                );
                
                Log::info('Google Form Sync: Registration successful', [
                    'role' => $role, 
                    'email' => $email,
                    'id' => $interaction->id
                ]);

                return response()->json(['success' => true]);
            } catch (\Throwable $e) {
                Log::error('Google Form Sync: Database error', [
                    'error' => $e->getMessage(),
                    'role' => $role,
                    'email' => $email
                ]);
                return response()->json(['error' => 'Database error', 'message' => $e->getMessage()], 500);
            }
        }

        Log::warning('Google Form Sync: Invalid role received', ['role' => $role]);
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
