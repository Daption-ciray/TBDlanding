<?php

namespace App\Http\Controllers;

use App\Models\RoleInteraction;
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
        $roleSelect = config('livingcode.role_select');
        
        // Benzersiz IP tıklamalarını (İlgi Oranı) çek
        $ademInterest = RoleInteraction::getUniqueClicks('adem');
        $babaInterest = RoleInteraction::getUniqueClicks('baba');
        
        // Gerçek kayıtları (Kota) çek
        $ademRegistrations = RoleInteraction::getRegistrations('adem');
        $babaRegistrations = RoleInteraction::getRegistrations('baba');

        // Oranları ve Durumları Hesapla
        foreach (['adem', 'baba'] as $key) {
            $interest = ($key === 'adem') ? $ademInterest : $babaInterest;
            $regs = ($key === 'adem') ? $ademRegistrations : $babaRegistrations;
            $quota = 50; // KOTA SABİT 50

            // Sync Percent: Gerçek Kayıt / 50
            $roleSelect[$key]['sync_percent'] = min(100, round(($regs / $quota) * 100));
            $roleSelect[$key]['quota'] = $quota;

            // Status: İlgiye (tıklamaya) göre dinamik belirle
            $otherInterest = ($key === 'adem') ? $babaInterest : $ademInterest;
            
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
        // Google Form'dan gönderilecek gizli bir anahtar (Güvenlik için)
        $secret = $request->header('X-TBD-SECRET');
        if ($secret !== 'TBD_SECURE_KEY_2026') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $role = $request->input('role'); // 'adem' veya 'baba'
        $email = $request->input('email'); // Tekillik için email kullanabiliriz

        if (in_array($role, ['adem', 'baba'])) {
            // Kayıt türünde etkileşim oluştur
            RoleInteraction::updateOrCreate(
                ['role_key' => $role, 'ip_address' => $email, 'type' => 'registration'],
                ['updated_at' => now()]
            );
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Invalid role'], 400);
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

        // IP Bazlı Benzersiz Tıklama Kaydı (Manipülasyonu Önler)
        try {
            RoleInteraction::logClick($role, $request->ip());
            session(['livingcode_role' => $role]);
        } catch (\Throwable $e) {
            Log::warning('welcome: interaction logging failed', ['error' => $e->getMessage(), 'role' => $role, 'ip' => $request->ip()]);
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
