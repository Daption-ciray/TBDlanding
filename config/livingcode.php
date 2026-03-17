<?php

return [

    'event' => [
        'name' => 'The Living Code 2026',
        'tagline' => 'TBD Game Jam',
        'description' => '36 saatlik kaotik oyun geliştirme deneyimi.',
        'date' => '2026-04-10',
        'date_display' => '10-11 Nisan 2026',
        'time_start' => '09:00',
        'timezone' => 'Europe/Istanbul',
        'venue' => 'Nişantaşı Üniversitesi',
        'venue_city' => 'İstanbul',
        'duration_hours' => 36,
    ],

    'countdown_target' => '2026-04-10T09:00:00+03:00',

    'contact' => [
        'email' => 'HACKATHON@TBD.ORG.TR',
    ],

    'phases' => [
        [
            'num' => '01',
            'name' => 'Sisteme Giriş',
            'day' => 'Cumartesi 09:00 - 11:00',
            'color' => 'gold-200',
            'desc' => 'Uyanış başlar. Kayıt ve Hücre birleşimi. Matrisin kuralları ve token ekonomisi sisteme yüklenir.',
            'icon' => '🔌',
        ],
        [
            'num' => '02',
            'name' => 'Kurgu (The Construct)',
            'day' => 'Cumartesi 11:00 - 18:00',
            'color' => 'amethyst-100',
            'desc' => 'Gerçeklik inşa ediliyor. Görevci NPC\'ler alana sızar, yan görevler ile veri paketleri (token) toplanır.',
            'icon' => '💻',
        ],
        [
            'num' => '03',
            'name' => 'Optimizasyon',
            'day' => 'Cumartesi 18:00 - 00:00',
            'color' => 'red-400',
            'desc' => 'Hatalar ayıklanıyor, sistem stabilize ediliyor. Teknik mentorlar veri akışını optimize etmek için sahada.',
            'icon' => '⚡',
        ],
        [
            'num' => '04',
            'name' => 'Kaynak Kod (Source Code)',
            'day' => 'Pazar 12:00 - 19:00',
            'color' => 'gold-100',
            'desc' => 'Final senaryosu yürütülüyor. Konsey huzurunda sunumlar, oylama ve sistemin nihai mühürlenmesi.',
            'icon' => '📀',
        ],
    ],

    'faqs' => [
        [
            'q' => 'Yeme ve içme imkanları nelerdir?',
            'a' => '36 saatlik maraton boyunca ana öğünler, gece pizzası ve sınırsız çay/kahve ikramı ücretsiz olarak sağlanacaktır.',
        ],
        [
            'q' => 'Uyku ve dinlenme alanları var mı?',
            'a' => 'Evet. Dinlenmek isteyen katılımcılar için konforlu uyku alanlarımız mevcuttur. Dilerseniz kendi yastık veya battaniyenizi getirebilirsiniz.',
        ],
        [
            'q' => 'Hangi ekipmanları getirmeliyim?',
            'a' => 'Kendi bilgisayarınız, uzatma kablonuz ve varsa çizim tabletiniz gibi kişisel üretim araçlarınızı yanınızda bulundurmalısınız.',
        ],
        [
            'q' => 'Etkinlik alanına ulaşım nasıl sağlanır?',
            'a' => 'Etkinlik Nişantaşı Üniversitesi NeoTech Campus\'te gerçekleşecektir. Metro ve otobüs hatları ile kampüse kolayca ulaşım sağlayabilirsiniz.',
        ],
        [
            'q' => 'İzleyici olarak gelebilir miyim?',
            'a' => 'Evet, etkinlik boyunca alanı ziyaret edebilir, oyun geliştirme sürecini yerinde izleyebilir ve takımlara destek olabilirsiniz.',
        ],
        [
            'q' => 'Hücre (Takım) yapısı nasıl oluşur?',
            'a' => 'Takımlar sisteme bağımsız birimler (KAŞİF veya MİMAR) olarak başvurur. Etkinlik sahasında her bir KAŞİF birimi bir MİMAR birimiyle eşleşerek bir Hücre oluşturur ve maraton boyunca birlikte yarışır.',
        ],
    ],

    'stats' => [
        ['value' => 36, 'suffix' => '+', 'label' => 'Saat Maraton'],
        ['value' => 200, 'suffix' => '+', 'label' => 'Katılımcı'],
        ['value' => 50, 'suffix' => '+', 'label' => 'Hücre'],
        ['value' => 10, 'suffix' => 'k', 'label' => 'Token Havuzu'],
    ],

    /* Terminoloji: Ana konsept ile uyumlu (Hücre = takım, Konsey = jüri) */
    'terminology' => [
        'hucre' => 'Hücre',
        'konsey' => 'Konsey',
        'asimetri' => 'Asimetri bilinçli olarak korunur.',
    ],

    /* Rol seçimi (CS tarzı): Takım olarak katılım, KAŞİF veya MİMAR tarafı */
    'role_select' => [
        'title' => 'Birimini Seç',
        'subtitle' => 'THE LIVING CODE 2026',
        'pick_side' => 'Tarafını seç — Evrene bağlan',
        'kasif' => [
            'name' => 'KAŞİF',
            'label' => 'EXPLORER',
            'tagline' => 'Deneysel · Risk · Prototip',
            'desc' => 'Sınırları zorla, akışı keşfet. İnovasyonu kucakla.',
            'quota' => 50,
            'status' => 'Yüksek Talep',
            'sync_percent' => 0,
            'detail' => 'Deneysel mekanikleri keşfet, hızlı prototipleme ile vizyonu ayağa kaldır. Oynanışı öne çıkar — MİMAR ile uyumda asimetri korunur.',
            'figure_image' => 'images/kasif_figure.png',
            'concept_bg' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&q=80&w=1920',
        ],
        'mimar' => [
            'name' => 'MİMAR',
            'label' => 'ARCHITECT',
            'tagline' => 'Bütünlük · Sistem · Mimari',
            'desc' => 'Yapıyı kur, tutarlılığı koru. Temelleri sağlam at.',
            'quota' => 50,
            'status' => 'Kritik İhtiyaç',
            'sync_percent' => 0,
            'detail' => 'Mimari kararları yönet, teknik borçtan kaçın, sürdürülebilir temeller inşa et. Sistem tutarlılığını koru — KAŞİF ile uyumda asimetri korunur.',
            'figure_image' => 'images/mimar_figure.png',
            'concept_bg' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=1920',
        ],
    ],

    /* Rol bazlı landing: KAŞİF ve MİMAR için farklı hero / vurgu */
    'landing_by_role' => [
        'kasif' => [
            'hero_tagline' => '<Kaşif olarak evrene bağlan />',
            'hero_lead' => 'Sen risk alan taraftasın. Akışı keşfet, sınırları zorla — Konsey seni izliyor; MİMAR ile uyumun kritik.',
            'hero_cta_primary' => 'Hücreni Kaydet',
            'hero_cta_secondary' => 'İzleyici Olarak Başvur',
            'accent' => 'gold',
        ],
        'mimar' => [
            'hero_tagline' => '<Mimar olarak evrene bağlan />',
            'hero_lead' => 'Sen yapıyı kuran taraftasın. Sistemi tutarlı tut, mimariyi koru — KAŞİF ile uyumun kritik.',
            'hero_cta_primary' => 'Hücreni Kaydet',
            'hero_cta_secondary' => 'İzleyici Olarak Başvur',
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
        '⚖ KONSEY',
        '🔥 36 SAAT',
        '🎮 KAOTİK UYUM',
        '📜 MÜHÜRLÜ ZARFLAR',
        '🃏 MÜDAHALE KARTLARI',
        '10-11 NİSAN 2026',
    ],

];
