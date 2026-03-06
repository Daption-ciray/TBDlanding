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
            // Not: Google Form entegrasyonu kaldırıldığı için artık oranlar tamamen bu veriden hesaplanıyor.
            $kasifInterest = RoleInteraction::whereIn('role_key', ['kasif', 'adem'])->where('type', 'click')->count();
            $mimarInterest = RoleInteraction::whereIn('role_key', ['mimar', 'baba'])->where('type', 'click')->count();
        } catch (\Throwable $e) {
            // Veritabanı veya tablo yoksa varsayılan 0
            $kasifInterest = $mimarInterest = 0;
            Log::warning('Database not ready: ' . $e->getMessage());
        }

        // Oranları ve Durumları Hesapla
        foreach (['kasif', 'mimar'] as $key) {
            $interest = ($key === 'kasif') ? $kasifInterest : $mimarInterest;
            $quota = config("livingcode.role_select.$key.quota", 50); 

            // Sync percent artık ilgiye (tıklamaya) göre doluyor
            $roleSelect[$key]['sync_percent'] = min(100, round(($interest / $quota) * 100));
            $roleSelect[$key]['quota'] = $quota;

            $otherInterest = ($key === 'kasif') ? $mimarInterest : $kasifInterest;
            $diff = $interest - $otherInterest;
            
            if ($diff >= 15) {
                $roleSelect[$key]['status'] = 'ÇOK YÜKSEK TALEP';
            } elseif ($diff >= 8) {
                $roleSelect[$key]['status'] = 'YÜKSEK TALEP';
            } elseif ($diff >= 1) {
                $roleSelect[$key]['status'] = 'ARTAN TALEP';
            } elseif ($diff <= -15) {
                $roleSelect[$key]['status'] = 'KRİTİK İHTIYAÇ';
            } elseif ($diff <= -8) {
                $roleSelect[$key]['status'] = 'ACİL İHTİYAÇ';
            } elseif ($diff <= -1) {
                $roleSelect[$key]['status'] = 'GEREKLİ İHTİYAÇ';
            } else {
                $roleSelect[$key]['status'] = 'STABİL';
            }
        }

        return view('pages.role-select', [
            'roleSelect' => $roleSelect,
            'event' => config('livingcode.event'),
        ]);
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

            // Rol bazlı durum ve oran hesapla
            $kasifInterest = RoleInteraction::whereIn('role_key', ['kasif', 'adem'])->where('type', 'click')->count();
            $mimarInterest = RoleInteraction::whereIn('role_key', ['mimar', 'baba'])->where('type', 'click')->count();
            
            $interest = ($role === 'kasif') ? $kasifInterest : $mimarInterest;
            $otherInterest = ($role === 'kasif') ? $mimarInterest : $kasifInterest;
            $diff = $interest - $otherInterest;
            $quota = config("livingcode.role_select.$role.quota", 50);

            $syncPercent = min(100, round(($interest / $quota) * 100));
            $statusText = 'STABİL';

            if ($diff >= 15) {
                $statusText = 'ÇOK YÜKSEK TALEP';
            } elseif ($diff >= 8) {
                $statusText = 'YÜKSEK TALEP';
            } elseif ($diff >= 1) {
                $statusText = 'ARTAN TALEP';
            } elseif ($diff <= -15) {
                $statusText = 'KRİTİK İHTİYAÇ';
            } elseif ($diff <= -8) {
                $statusText = 'ACİL İHTİYAÇ';
            } elseif ($diff <= -1) {
                $statusText = 'GEREKLİ İHTİYAÇ';
            }
        } catch (\Throwable $e) {
            Log::warning('welcome: interaction logging failed', ['error' => $e->getMessage(), 'role' => $role]);
            $syncPercent = 0;
            $statusText = 'STABİL';
        }

        return view('pages.welcome', [
            'role' => $role,
            'syncPercent' => $syncPercent,
            'statusText' => $statusText,
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
