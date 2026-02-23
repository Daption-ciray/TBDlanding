<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Card;
use App\Models\Quest;
use App\Models\Team;
use App\Models\Participant;
use App\Models\Viewer;
use Illuminate\Database\Seeder;

class GamificationSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBadges();
        $this->seedCards();
        $this->seedQuests();
        $this->seedDemoTeams();
        $this->seedDemoViewers();
    }

    private function seedBadges(): void
    {
        $badges = config('livingcode.gamification.badge_definitions', []);

        foreach ($badges as $badge) {
            Badge::firstOrCreate(
                ['slug' => $badge['slug']],
                [
                    'name' => $badge['name'],
                    'icon' => $badge['icon'],
                    'type' => $badge['type'],
                    'rarity' => $badge['rarity'],
                    'description' => $badge['description'],
                    'is_tradeable' => !in_array($badge['rarity'], ['legendary']),
                ]
            );
        }
    }

    private function seedCards(): void
    {
        $cards = config('livingcode.gamification.card_catalog', []);

        foreach ($cards as $card) {
            Card::firstOrCreate(
                ['slug' => $card['slug']],
                [
                    'name' => $card['name'],
                    'type' => $card['type'],
                    'rarity' => $card['rarity'],
                    'cost_credits' => $card['cost'],
                    'description' => $card['description'],
                    'effect_description' => $card['effect'],
                    'stock' => match ($card['rarity']) {
                        'common' => 20,
                        'rare' => 10,
                        'epic' => 5,
                        'legendary' => 2,
                    },
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedQuests(): void
    {
        $baseTime = now();

        $quests = [
            ['title' => 'İlk Prototip', 'slug' => 'ilk-prototip', 'description' => 'Oynanabilir ilk prototipi Şura\'ya sunun.', 'type' => 'team', 'xp_reward' => 100, 'credit_reward' => 50, 'icon' => '🎮', 'difficulty' => 'medium', 'hours' => 8, 'max' => 50],
            ['title' => 'Sosyal Paylaşım', 'slug' => 'sosyal-paylasim', 'description' => '#TheLivingCode hashtagi ile sosyal medyada paylaşım yapın.', 'type' => 'both', 'xp_reward' => 25, 'credit_reward' => 15, 'icon' => '📱', 'difficulty' => 'easy', 'hours' => 36, 'max' => 200],
            ['title' => 'Takım Tanıtımı', 'slug' => 'takim-tanitimi', 'description' => 'Hücrenizin 30 saniyelik tanıtım videosunu çekin.', 'type' => 'team', 'xp_reward' => 50, 'credit_reward' => 30, 'icon' => '🎬', 'difficulty' => 'easy', 'hours' => 4, 'max' => 50],
            ['title' => 'Bug Avcısı', 'slug' => 'bug-avcisi', 'description' => 'Başka bir Hücre\'nin oyununda bug raporu girin.', 'type' => 'team', 'xp_reward' => 40, 'credit_reward' => 20, 'icon' => '🐛', 'difficulty' => 'medium', 'hours' => 6, 'max' => 100],
            ['title' => 'İzleyici Anketi', 'slug' => 'izleyici-anketi', 'description' => 'Kısa anketi doldurun ve geri bildirim verin.', 'type' => 'viewer', 'xp_reward' => 30, 'credit_reward' => 0, 'icon' => '📝', 'difficulty' => 'easy', 'hours' => 12, 'max' => 500],
            ['title' => 'Gece Nöbeti', 'slug' => 'gece-nobeti', 'description' => 'Gece 00:00-06:00 arası aktif kalın.', 'type' => 'both', 'xp_reward' => 75, 'credit_reward' => 40, 'icon' => '🌙', 'difficulty' => 'hard', 'hours' => 6, 'max' => 100],
            ['title' => 'Diplomasi Zirvesi', 'slug' => 'diplomasi-zirvesi', 'description' => 'Başka bir Hücre ile başarılı rozet takası yapın.', 'type' => 'team', 'xp_reward' => 60, 'credit_reward' => 35, 'icon' => '🤝', 'difficulty' => 'medium', 'hours' => 12, 'max' => 50],
            ['title' => 'Hızlı Tepki', 'slug' => 'hizli-tepki', 'description' => '5 dakika içinde yeni bir görevi tamamlayın.', 'type' => 'both', 'xp_reward' => 40, 'credit_reward' => 25, 'icon' => '⚡', 'difficulty' => 'hard', 'hours' => 2, 'max' => 30],
            ['title' => 'İzle & Oyla', 'slug' => 'izle-oyla', 'description' => 'En az 30 dakika izleyin ve favori Hücrenize oy verin.', 'type' => 'viewer', 'xp_reward' => 35, 'credit_reward' => 0, 'icon' => '👁️', 'difficulty' => 'easy', 'hours' => 24, 'max' => 500],
            ['title' => 'Kart Ustası', 'slug' => 'kart-ustasi', 'description' => 'Bir müdahale kartını başarıyla kullanın.', 'type' => 'team', 'xp_reward' => 45, 'credit_reward' => 20, 'icon' => '🃏', 'difficulty' => 'medium', 'hours' => 8, 'max' => 50],
        ];

        foreach ($quests as $q) {
            Quest::firstOrCreate(
                ['slug' => $q['slug']],
                [
                    'title' => $q['title'],
                    'description' => $q['description'],
                    'type' => $q['type'],
                    'xp_reward' => $q['xp_reward'],
                    'credit_reward' => $q['credit_reward'],
                    'icon' => $q['icon'],
                    'difficulty' => $q['difficulty'],
                    'starts_at' => $baseTime,
                    'expires_at' => $baseTime->copy()->addHours($q['hours']),
                    'max_completions' => $q['max'],
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedDemoTeams(): void
    {
        $hucreDefs = [
            ['hucre_name' => 'ADEM Hücresi Alpha', 'role' => 'adem', 'xp' => 1070, 'credits' => 270, 'level' => 4],
            ['hucre_name' => 'BABA Hücresi Alpha', 'role' => 'baba', 'xp' => 670, 'credits' => 370, 'level' => 3],
            ['hucre_name' => 'ADEM Hücresi Beta', 'role' => 'adem', 'xp' => 510, 'credits' => 130, 'level' => 4],
        ];

        $teamDefs = [
            ['name' => 'Kaos Mühendisleri', 'role' => 'adem', 'supporter_count' => 12, 'hucre_idx' => 0],
            ['name' => 'Pixel Korsanları', 'role' => 'adem', 'supporter_count' => 15, 'hucre_idx' => 0],
            ['name' => 'Sistem Mimarları', 'role' => 'baba', 'supporter_count' => 8, 'hucre_idx' => 1],
            ['name' => 'Kod Simyacıları', 'role' => 'baba', 'supporter_count' => 6, 'hucre_idx' => 1],
            ['name' => 'Glitch Avcıları', 'role' => 'adem', 'supporter_count' => 10, 'hucre_idx' => 2],
        ];

        $hucreler = [];
        foreach ($hucreDefs as $hd) {
            $hucreler[] = \App\Models\Hucre::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($hd['hucre_name'])],
                [
                    'name' => $hd['hucre_name'],
                    'role' => $hd['role'],
                    'xp' => $hd['xp'],
                    'credits' => $hd['credits'],
                    'level' => $hd['level'],
                    'is_active' => true,
                ]
            );
        }

        foreach ($teamDefs as $t) {
            $hucre = $hucreler[$t['hucre_idx']];
            $team = Team::firstOrCreate(
                ['name' => $t['name']],
                [
                    'role' => $t['role'],
                    'hucre_id' => $hucre->id,
                    'supporter_count' => $t['supporter_count'],
                    'slug' => \Illuminate\Support\Str::slug($t['name']),
                    'is_active' => true,
                ]
            );

            if ($team->wasRecentlyCreated) {
                Participant::create(['team_id' => $team->id, 'name' => 'Kaptan ' . $t['name'], 'email' => \Illuminate\Support\Str::slug($t['name']) . '-kaptan@demo.test', 'role_in_team' => $t['role']]);
                Participant::create(['team_id' => $team->id, 'name' => 'Üye ' . $t['name'], 'email' => \Illuminate\Support\Str::slug($t['name']) . '-uye@demo.test', 'role_in_team' => $t['role'] === 'adem' ? 'baba' : 'adem']);
            }
        }
    }

    private function seedDemoViewers(): void
    {
        $viewers = [
            ['name' => 'Ali İzleyici', 'email' => 'ali@demo.test', 'total_watch_minutes' => 180, 'xp' => 120, 'current_streak' => 3],
            ['name' => 'Ayşe İzleyici', 'email' => 'ayse@demo.test', 'total_watch_minutes' => 320, 'xp' => 200, 'current_streak' => 5],
            ['name' => 'Mehmet İzleyici', 'email' => 'mehmet@demo.test', 'total_watch_minutes' => 90, 'xp' => 60, 'current_streak' => 1],
        ];

        foreach ($viewers as $v) {
            Viewer::firstOrCreate(
                ['email' => $v['email']],
                $v
            );
        }
    }
}
