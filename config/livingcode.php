<?php

return [

    'event' => [
        'name' => 'The Living Code 2026',
        'tagline' => 'TBD Game Jam',
        'description' => '36 saatlik kaotik oyun geliştirme deneyimi.',
        'date' => '2026-04-03',
        'date_display' => '3-4 Nisan 2026',
        'time_start' => '09:00',
        'timezone' => 'Europe/Istanbul',
        'venue' => 'Nişantaşı Üniversitesi',
        'venue_city' => 'İstanbul',
        'duration_hours' => 36,
    ],

    'countdown_target' => '2026-04-03T09:00:00+03:00',

    'contact' => [
        'email' => 'tbd-istanbul@tbd.org.tr',
    ],

    'sura_password' => env('SURA_PASSWORD', 'sura2026'),

    'team_password' => env('TEAM_PASSWORD', 'takim2026'),

    'phases' => [
        [
            'num' => 'I',
            'name' => 'Genesis',
            'day' => 'Cuma – Başlangıç',
            'color' => 'gold-200',
            'desc' => 'Kredi sistemi aktifleşir. İlk prototipler şekillenmeye başlar. Takımlar "Hücre" kimliğini kazanır, ADEM ve BABA rolleri atanır. Evrene giriş ritüeli gerçekleşir.',
            'icon' => '🌅',
        ],
        [
            'num' => 'II',
            'name' => 'Vahiy',
            'day' => 'Cumartesi – Ortak Dil',
            'color' => 'amethyst-100',
            'desc' => 'Ortak dil ve çekirdek sistem onayı. Takımlar arası iletişim kanalları açılır. Şura ilk denetimi yapar, ADEM-BABA uyumu değerlendirilir.',
            'icon' => '📖',
        ],
        [
            'num' => 'III',
            'name' => 'İmtihan',
            'day' => 'Cumartesi – Diplomasi',
            'color' => 'red-400',
            'desc' => 'Müdahale kartları aktifleşir. Diplomasi Masası kurulur. Şura Pazarı açılır — kredi ile kart ticareti başlar. Mahkûm İkilemi mekaniği devreye girer.',
            'icon' => '⚔️',
        ],
        [
            'num' => 'IV',
            'name' => 'Kıyamet',
            'day' => 'Pazar – Final',
            'color' => 'gold-100',
            'desc' => 'Sistem mühürlenir. Mahşer Meydanı\'nda final sunumları yapılır. Jüri değerlendirmesi, diplomasi bonusları hesaplanır ve ödül töreni gerçekleşir.',
            'icon' => '🔥',
        ],
    ],

    'faqs' => [
        [
            'q' => 'Online katılabilir miyim?',
            'a' => 'Hayır. The Living Code tamamen fiziksel bir etkinliktir. Şura\'nın mühürlü zarfları, diplomasi masası ve müdahale kartları yüz yüze etkileşim gerektirir.',
        ],
        [
            'q' => 'Hücre kaç kişiden oluşur?',
            'a' => 'Her Hücre 2-5 kişiden oluşur. Her Hücrede en az bir ADEM (Kaşif) ve bir BABA (Mimar) rolü bulunmalıdır. Asimetri Şura tarafından denetlenir.',
        ],
        [
            'q' => 'Hangi oyun motorları kullanılabilir?',
            'a' => 'Unity, Unreal Engine, Godot, GameMaker dahil tüm motorlar serbesttir. Hatta kendi motorunuzu yazabilirsiniz!',
        ],
        [
            'q' => 'Yemek sağlanacak mı?',
            'a' => 'Evet! 36 saat boyunca yemek ve içecek sağlanacaktır. Gece pizzası ve kahve molaları programın bir parçasıdır.',
        ],
        [
            'q' => '"Kaotik Uyum" ne anlama geliyor?',
            'a' => 'Birbirine zıt iki kavramı (tür, mekanik, estetik veya anlatı düzeyinde) tek bir oyun sisteminde dengeli ve sürdürülebilir şekilde bir araya getirmektir.',
        ],
        [
            'q' => 'Değerlendirme kriterleri nelerdir?',
            'a' => 'Şura, Bütünlük (%35), Asimetri Kalitesi (%25) ve Oynanabilirlik (%20) ile değerlendirir. Final puanı diplomasi bonusu ve ihanet bedeli ile etkilenir.',
        ],
        [
            'q' => 'XP ve kredi sistemi nasıl çalışır?',
            'a' => 'Görevleri tamamlayarak, sosyal medya paylaşımı yaparak ve kart kullanarak XP kazanırsınız. Krediler ise kart satın almak ve stratejik hamleler için kullanılır. Her 100 XP yeni bir seviye demektir.',
        ],
        [
            'q' => 'Müdahale kartları nedir?',
            'a' => 'İki türde kart var: Lütuf Kartları (mentor desteği, XP boost, kredi) ve Gazap Kartları (sabotaj, kredi vergisi, rol karıştırma). Kartlar Şura Pazarı\'nda kredi ile satın alınır.',
        ],
        [
            'q' => 'İzleyici olarak katılabilir miyim?',
            'a' => 'Evet! Web sitesinden izleyici olarak kayıt olabilir, görev tamamlayabilir, XP kazanabilir ve rozet toplayabilirsiniz. En uzun süre izleyen kişi özel rozet kazanır.',
        ],
        [
            'q' => 'Rozet takası nasıl yapılır?',
            'a' => 'Efsanevi rozetler hariç tüm rozetler takımlar arası takas edilebilir. Rozet galerisi bölümünden takas teklifi gönderebilirsiniz.',
        ],
    ],

    'stats' => [
        ['value' => 36, 'suffix' => '+', 'label' => 'Saat Maraton'],
        ['value' => 200, 'suffix' => '+', 'label' => 'Katılımcı'],
        ['value' => 50, 'suffix' => '+', 'label' => 'Hücre'],
        ['value' => 4, 'suffix' => '', 'label' => 'Farz (Şura)'],
    ],

    /* Terminoloji: Ana konsept ile uyumlu (Hücre = takım, Şura = konsey) */
    'terminology' => [
        'hucre' => 'Hücre',
        'sura' => 'Şura',
        'asimetri' => 'Asimetri bilinçli olarak korunur.',
    ],

    /* Rol seçimi (CS tarzı): Takım olarak katılım, ADEM veya BABA tarafı */
    'role_select' => [
        'title' => 'Takımını Seç',
        'subtitle' => 'THE LIVING CODE 2026',
        'pick_side' => 'Tarafını seç — evrene giriş',
        'adem' => [
            'name' => 'ADEM',
            'label' => 'KAŞİF',
            'tagline' => 'Deneysel · Risk · Prototip',
            'desc' => 'Sınırları zorla, oynanışı öne çıkar. İnovasyonu kucakla.',
            'detail' => 'Kaşif ruhuyla deneysel mekanikleri keşfet, hızlı prototipleme ile vizyonu ayağa kaldır. "Çalışır mı?" sorusunu önce sen sor; başarısızlıktan öğren, iterasyon yap. Oynanışı öne çıkar — BABA ile uyumda asimetri korunur, Şura seni izler.',
        ],
        'baba' => [
            'name' => 'BABA',
            'label' => 'MİMAR',
            'tagline' => 'Bütünlük · Sistem · Mimari',
            'desc' => 'Yapıyı kur, tutarlılığı koru. Temelleri sağlam at.',
            'detail' => 'Mimari kararları yönet, teknik borçtan kaçın, sürdürülebilir temeller inşa et. "Nasıl ölçeklenir?" ve "Nasıl sürdürülebilir kalır?" sorularına cevap ver. Sistem tutarlılığını koru — ADEM ile uyumda asimetri korunur, Şura seni izler.',
        ],
    ],

    /* Rol bazlı landing: ADEM ve BABA için farklı hero / vurgu */
    'landing_by_role' => [
        'adem' => [
            'hero_tagline' => '<Kaşif olarak evrene gir />',
            'hero_lead' => 'Sen risk alan taraftasın. Prototipi hızla ayağa kaldır, oynanışı keşfet — Şura seni izler; BABA ile uyumda asimetri korunur.',
            'hero_cta_primary' => 'Takımımla Başvur',
            'hero_cta_secondary' => 'Şura\'yı Gör',
            'accent' => 'gold',
        ],
        'baba' => [
            'hero_tagline' => '<Mimar olarak evrene gir />',
            'hero_lead' => 'Sen yapıyı kuran taraftasın. Sistemi tutarlı tut, mimariyi koru — Şura seni izler; ADEM ile uyumda asimetri korunur.',
            'hero_cta_primary' => 'Takımımla Başvur',
            'hero_cta_secondary' => 'Şura\'yı Gör',
            'accent' => 'amethyst',
        ],
    ],

    'sponsor_tiers' => [
        'diamond' => [
            'name' => 'Elmas Sponsor',
            'subtitle' => 'Ana Sponsor',
            'price' => '450.000 ₺',
            'icon' => '💎',
            'color_class' => 'cyan',
            'features' => [
                'Etkinlikte isim hakkı',
                'Jüri koltuğunda temsil',
                'Maksimum logo görünürlüğü',
                'Özel ödül kategorisi',
                '"Deep Dive" workshop',
                'Yetenek matrisi raporu',
            ],
        ],
        'gold' => [
            'name' => 'Altın Sponsor',
            'subtitle' => '',
            'price' => '200.000 ₺',
            'icon' => '🥇',
            'color_class' => 'gold',
            'features' => [
                'Stant alanı & demo',
                '2 teknik mentor',
                '15 dk sunum slotu',
                'Özel ödül kategorisi',
            ],
        ],
        'silver' => [
            'name' => 'Gümüş Sponsor',
            'subtitle' => '',
            'price' => '100.000 ₺',
            'icon' => '🥈',
            'color_class' => 'gray',
            'features' => [
                'Web & sosyal medya logosu',
                'Sponsor duvarı & tişört',
                'Roll-up alanı',
                'Promosyon paketi',
            ],
        ],
        'supporter' => [
            'name' => 'Destekçi',
            'subtitle' => 'Barter İmkanı',
            'price' => '50.000 ₺',
            'icon' => '🤝',
            'color_class' => 'amethyst',
            'features' => [
                'Yaka kartı sponsoru',
                'Yemek sponsorluğu',
                'Kahve sponsorluğu',
            ],
        ],
    ],

    'marquee_items' => [
        '⚔ GAME JAM',
        '🔷 HÜCRE',
        '⚖ ŞURA',
        '🔥 36 SAAT',
        '🎮 KAOTİK UYUM',
        '📜 MÜHÜRLÜ ZARFLAR',
        '🃏 MÜDAHALE KARTLARI',
        '3-4 NİSAN 2026',
        '🏆 LİDERLİK TABLOSU',
        '🎯 GÖREVLER',
        '🛡️ ROZETLER',
    ],

    'gamification' => [
        'level_thresholds' => [
            1 => 0,
            2 => 100,
            3 => 250,
            4 => 500,
            5 => 800,
            6 => 1200,
            7 => 1800,
            8 => 2500,
            9 => 3500,
            10 => 5000,
        ],

        'xp_rewards' => [
            'quest_easy' => 25,
            'quest_medium' => 50,
            'quest_hard' => 100,
            'social_share' => 15,
            'badge_earned' => 30,
            'card_used' => 20,
            'tester_feedback' => 40,
        ],

        'social_share_points' => [
            'twitter' => 15,
            'instagram' => 20,
            'linkedin' => 25,
            'tiktok' => 20,
            'other' => 10,
        ],

        'tester_xp_cost' => 150, // Artık kullanılmıyor, tester_credit_cost kullanılıyor
        'tester_credit_cost' => 50,

        'mentor_topics' => [
            'game-design' => 'Oyun Tasarımı',
            'programming' => 'Programlama',
            'art-audio' => 'Sanat & Ses',
            'project-management' => 'Proje Yönetimi',
            'unity' => 'Unity',
            'unreal' => 'Unreal Engine',
            'godot' => 'Godot',
            'general' => 'Genel Mentorluk',
        ],

        'badge_definitions' => [
            ['slug' => 'ilk-adim', 'name' => 'İlk Adım', 'icon' => '👣', 'type' => 'team', 'rarity' => 'common', 'description' => 'Evrene ilk kez giriş yapan Hücre.'],
            ['slug' => 'en-yaratici-fikir', 'name' => 'En Yaratıcı Fikir Kupası', 'icon' => '🏆', 'type' => 'special', 'rarity' => 'legendary', 'description' => 'Şura tarafından en yaratıcı fikir ödülü.'],
            ['slug' => 'en-uzun-izleyici', 'name' => 'Sadık Göz', 'icon' => '👁️', 'type' => 'viewer', 'rarity' => 'epic', 'description' => 'En uzun süre izleyen kişi.'],
            ['slug' => 'en-cok-destekci', 'name' => 'Kalabalık Ordu', 'icon' => '👥', 'type' => 'team', 'rarity' => 'epic', 'description' => 'En çok destekçi ile gelen Hücre.'],
            ['slug' => 'diplomasi-ustasi', 'name' => 'Diplomasi Ustası', 'icon' => '🤝', 'type' => 'team', 'rarity' => 'rare', 'description' => '3 başarılı rozet takası gerçekleştiren Hücre.'],
            ['slug' => 'kart-koleksiyoncusu', 'name' => 'Kart Koleksiyoncusu', 'icon' => '🃏', 'type' => 'team', 'rarity' => 'rare', 'description' => '5 farklı kart satın alan Hücre.'],
            ['slug' => 'gorev-avcisi', 'name' => 'Görev Avcısı', 'icon' => '🎯', 'type' => 'team', 'rarity' => 'rare', 'description' => '10 görev tamamlayan Hücre.'],
            ['slug' => 'sosyal-fenomen', 'name' => 'Sosyal Fenomen', 'icon' => '📢', 'type' => 'team', 'rarity' => 'rare', 'description' => '5 sosyal medya paylaşımı yapan Hücre.'],
            ['slug' => 'mentor-dostu', 'name' => 'Mentor Dostu', 'icon' => '🧙', 'type' => 'team', 'rarity' => 'common', 'description' => 'Mentor desteği alan Hücre.'],
            ['slug' => 'test-edilmis', 'name' => 'Test Edilmiş', 'icon' => '🧪', 'type' => 'team', 'rarity' => 'common', 'description' => 'Oyununu test ekibine test ettiren Hücre.'],
            ['slug' => 'genesis-veterani', 'name' => 'Genesis Veteranı', 'icon' => '🌅', 'type' => 'team', 'rarity' => 'common', 'description' => 'Genesis fazını tamamlayan Hücre.'],
            ['slug' => 'imtihan-savasçisi', 'name' => 'İmtihan Savaşçısı', 'icon' => '⚔️', 'type' => 'team', 'rarity' => 'epic', 'description' => 'İmtihan fazında 3 kartı başarıyla kullanan Hücre.'],
            ['slug' => 'izleyici-yildizi', 'name' => 'İzleyici Yıldızı', 'icon' => '⭐', 'type' => 'viewer', 'rarity' => 'common', 'description' => 'İlk görevini tamamlayan izleyici.'],
            ['slug' => 'izleyici-gorev-ustasi', 'name' => 'Görev Ustası', 'icon' => '🎖️', 'type' => 'viewer', 'rarity' => 'rare', 'description' => '5 görevi tamamlayan izleyici.'],
            ['slug' => 'sabotajci', 'name' => 'Sabotajcı', 'icon' => '💀', 'type' => 'team', 'rarity' => 'epic', 'description' => '3 Gazap kartı kullanan Hücre.'],
            ['slug' => 'koruyucu', 'name' => 'Koruyucu', 'icon' => '🛡️', 'type' => 'team', 'rarity' => 'rare', 'description' => '3 Lütuf kartı kullanan Hücre.'],
            ['slug' => 'xp-kralı', 'name' => 'XP Kralı', 'icon' => '👑', 'type' => 'team', 'rarity' => 'legendary', 'description' => 'En yüksek XP\'ye sahip Hücre.'],
            ['slug' => 'sponsor-favorisi', 'name' => 'Sponsor Favorisi', 'icon' => '💎', 'type' => 'sponsor', 'rarity' => 'legendary', 'description' => 'Sponsorlar tarafından seçilen Hücre.'],
        ],

        'card_catalog' => [
            ['slug' => 'mentor-cagri', 'name' => 'Mentor Çağrısı', 'type' => 'lutuf', 'rarity' => 'common', 'cost' => 30, 'description' => 'Takımınıza 30 dakikalık özel mentor desteği.', 'effect' => 'Anında mentor ataması yapılır.'],
            ['slug' => 'xp-boost', 'name' => 'XP Boost', 'type' => 'lutuf', 'rarity' => 'common', 'cost' => 25, 'description' => '30 dakika boyunca 2x XP kazanın.', 'effect' => '30 dakika süreyle XP kazanımı ikiye katlanır.'],
            ['slug' => 'kredi-yagmuru', 'name' => 'Kredi Yağmuru', 'type' => 'lutuf', 'rarity' => 'rare', 'cost' => 50, 'description' => 'Takımınıza anında 75 kredi.', 'effect' => '+75 kredi.'],
            ['slug' => 'kalkan', 'name' => 'Kalkan', 'type' => 'lutuf', 'rarity' => 'rare', 'cost' => 60, 'description' => '1 saat boyunca Gazap kartlarından korunma.', 'effect' => '60 dakika Gazap koruması.'],
            ['slug' => 'sura-lutfu', 'name' => 'Şura Lütfu', 'type' => 'lutuf', 'rarity' => 'epic', 'cost' => 80, 'description' => 'Şura\'dan özel avantaj.', 'effect' => 'Bir sonraki değerlendirmede +5 bonus puan.'],
            ['slug' => 'zaman-hirsizi', 'name' => 'Zaman Hırsızı', 'type' => 'gazap', 'rarity' => 'common', 'cost' => 25, 'description' => 'Hedef takımın aktif görevine 15 dk eklenir.', 'effect' => 'Hedef takımın aktif görev süresine 15 dk dezavantaj.'],
            ['slug' => 'kod-karistirici', 'name' => 'Kod Karıştırıcı', 'type' => 'gazap', 'rarity' => 'rare', 'cost' => 45, 'description' => 'Hedef takım 15 dk boyunca kart satın alamaz.', 'effect' => '15 dk kart satın alma engeli.'],
            ['slug' => 'kredi-vergisi', 'name' => 'Kredi Vergisi', 'type' => 'gazap', 'rarity' => 'common', 'cost' => 30, 'description' => 'Hedef takımdan 20 kredi çalın.', 'effect' => 'Hedeften -20, size +20 kredi.'],
            ['slug' => 'rol-karistirici', 'name' => 'Rol Karıştırıcı', 'type' => 'gazap', 'rarity' => 'epic', 'cost' => 70, 'description' => 'Hedef takımın ADEM-BABA rolleri 30 dk değişir.', 'effect' => '30 dk zorunlu rol değişimi.'],
            ['slug' => 'sura-gazabi', 'name' => 'Şura Gazabı', 'type' => 'gazap', 'rarity' => 'legendary', 'cost' => 100, 'description' => 'Hedef takımın bir sonraki görev ödülü yarıya düşer.', 'effect' => 'Sonraki görev ödülü %50 azalır.'],
        ],
    ],

];
