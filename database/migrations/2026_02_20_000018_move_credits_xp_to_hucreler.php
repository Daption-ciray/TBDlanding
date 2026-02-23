<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mevcut takımları ikişer gruplara ayır ve hücreler oluştur
        // Her 2 takım bir hücreye atanır
        $teams = DB::table('teams')->where('is_active', true)->orderBy('role')->orderBy('id')->get();
        
        $currentHucre = null;
        $teamsInCurrentHucre = 0;
        $hucreNumber = 1;

        foreach ($teams as $team) {
            // Yeni hücre oluştur (her 2 takım için veya role değiştiğinde)
            if ($teamsInCurrentHucre === 0 || $teamsInCurrentHucre >= 2) {
                $roleLabel = $team->role === 'adem' ? 'ADEM' : 'BABA';
                $hucreName = "{$roleLabel} Hücresi {$hucreNumber}";
                $hucreSlug = \Illuminate\Support\Str::slug($hucreName);
                
                // Aynı isimde hücre varsa numara artır
                $existing = DB::table('hucreler')->where('slug', $hucreSlug)->exists();
                if ($existing) {
                    $hucreNumber++;
                    $hucreName = "{$roleLabel} Hücresi {$hucreNumber}";
                    $hucreSlug = \Illuminate\Support\Str::slug($hucreName);
                }

                $currentHucre = DB::table('hucreler')->insertGetId([
                    'name' => $hucreName,
                    'role' => $team->role,
                    'xp' => 0,
                    'credits' => 0,
                    'level' => 1,
                    'slug' => $hucreSlug,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $teamsInCurrentHucre = 0;
                $hucreNumber++;
            }

            // Takımı hücreye ata ve credits/xp'yi hücreye taşı
            DB::table('teams')->where('id', $team->id)->update([
                'hucre_id' => $currentHucre,
            ]);

            // Credits ve XP'yi hücreye ekle
            DB::table('hucreler')->where('id', $currentHucre)->increment('credits', $team->credits);
            DB::table('hucreler')->where('id', $currentHucre)->increment('xp', $team->xp);

            $teamsInCurrentHucre++;
        }
    }

    public function down(): void
    {
        // Credits ve XP'yi geri takımlara dağıt (basit: hücredeki değerleri takımlara eşit dağıt)
        $hucreler = DB::table('hucreler')->get();
        foreach ($hucreler as $hucre) {
            $teams = DB::table('teams')->where('hucre_id', $hucre->id)->get();
            if ($teams->count() > 0) {
                $creditsPerTeam = floor($hucre->credits / $teams->count());
                $xpPerTeam = floor($hucre->xp / $teams->count());
                foreach ($teams as $team) {
                    DB::table('teams')->where('id', $team->id)->update([
                        'credits' => $creditsPerTeam,
                        'xp' => $xpPerTeam,
                    ]);
                }
            }
        }
    }
};
