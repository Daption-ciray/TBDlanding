<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Takımını Seç – The Living Code 2026</title>
    <link rel="icon" href="/images/tbd_logo.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    // Komünite esintili turuncu / altın / siyah / beyaz paleti
                    colors: {
                        dark: { 900: '#ffffff', 800: '#f9fafb' },
                        gold: { 100: '#fef08a', 200: '#facc15', 300: '#eab308', 400: 'rgba(250,204,21,0.25)' },
                        amethyst: { 100: '#fed7aa', 200: '#fdba74', 300: '#f97316', 400: 'rgba(249,115,22,0.25)' },
                        parchment: { 100: '#020617', 200: '#111827', 300: '#4b5563', 400: '#9ca3af' },
                    },
                    fontFamily: {
                        cinzel: ['"Cinzel Decorative"', 'serif'],
                        display: ['Playfair Display', 'serif'],
                        inter: ['"Cinzel Decorative"', 'serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                },
            },
        };
    </script>
    <link rel="stylesheet" href="/css/custom.css">
    <style>
        .role-half { transition: flex 0.5s cubic-bezier(0.23, 1, 0.32, 1); }
        .role-half:hover { flex: 1.15; }
        .role-half a { display: block; height: 100%; }
        
        .role-bg-image {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px) brightness(0.75) saturate(1.2);
            opacity: 1;
            z-index: 0;
        }
        /* Konsept görseli — rollerin tam arkasında, net */
        .role-bg-concept {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
        }
        .role-bg-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(26,24,37,0.3), rgba(37,34,56,0.2));
            z-index: 1;
        }
        .role-content { position: relative; z-index: 10; }
        /* Her tarafta bir insan/karakter görseli alanı */
        .role-figure {
            flex-shrink: 0;
            width: 38%;
            max-width: 280px;
            min-height: 280px;
            min-width: 180px;
            background-size: contain;
            background-position: center bottom;
            background-repeat: no-repeat;
        }
        .role-figure img {
            width: 100%;
            height: auto;
            max-height: 70vh;
            object-fit: contain;
            object-position: center bottom;
        }
        .role-half-adem .role-figure { order: -1; }
        .role-half-baba .role-figure { order: 1; }
        @media (max-width: 640px) {
            .role-half { flex-direction: column; }
            .role-figure { width: 100%; min-height: 160px; min-width: auto; max-width: 200px; margin: 0 auto; }
            .role-half-baba .role-content { order: -1; }
            .role-half-baba .role-figure { order: 0; }
        }
    </style>
</head>
<body class="font-inter bg-slate-100 text-slate-800 min-h-screen overflow-hidden">

    @php
        $ademFigure = $roleSelect['adem']['figure_image'] ?? 'images/adem_figure.png';
        $babaFigure = $roleSelect['baba']['figure_image'] ?? 'images/baba_figure.png';
        $ademBg = $roleSelect['adem']['concept_bg'] ?? 'images/adem_bg.jpg';
        $babaBg = $roleSelect['baba']['concept_bg'] ?? 'images/baba_bg.png';
        $ademFigureExists = file_exists(public_path($ademFigure));
        $babaFigureExists = file_exists(public_path($babaFigure));
        $ademBgExists = file_exists(public_path($ademBg));
        $babaBgExists = file_exists(public_path($babaBg));
        if (!$ademBgExists) { $ademBg = 'images/adem_bg.png'; $ademBgExists = file_exists(public_path($ademBg)); }
        if (!$babaBgExists) { $babaBg = 'images/baba_bg.png'; $babaBgExists = file_exists(public_path($babaBg)); }
    @endphp
    <div class="absolute inset-0 flex flex-col sm:flex-row">
        {{-- ADEM — sol yarı: konsept görseli arkada, üstünde içerik --}}
        <div class="role-half role-half-adem flex-1 flex flex-row justify-center items-stretch relative sm:border-r border-gold-300/20 min-h-[50vh] sm:min-h-screen overflow-hidden">
            @if($ademBgExists)
                <div class="role-bg-concept" style="background-image: url('{{ asset($ademBg) }}');"></div>
            @else
                <div class="role-bg-image" style="background-image: url('{{ asset('images/creation_of_adam_modern.png') }}'); background-position: left center; filter: none; opacity: 1;"></div>
            @endif
            <div class="role-bg-overlay" style="background: linear-gradient(to bottom, rgba(0,0,0,0.45), rgba(0,0,0,0.65));"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-black/30 via-transparent to-gold-300/20 z-[2]"></div>
            {{-- Sol tarafta insan/karakter alanı --}}
            <div class="role-figure flex items-end justify-center pt-20 pb-4 px-4 z-[5]">
                @if($ademFigureExists)
                    <img src="{{ asset($ademFigure) }}" alt="ADEM — Kaşif" class="drop-shadow-2xl">
                @else
                    <div class="w-full h-full min-h-[200px] flex items-center justify-center text-gold-300/60 text-6xl" aria-hidden="true">🔥</div>
                @endif
            </div>
            <a href="{{ route('welcome', ['role' => 'adem']) }}" class="role-content flex-1 flex flex-col justify-center items-center p-6 sm:p-8 text-center group">
                <span class="font-mono text-gold-300 text-xs tracking-[0.3em] uppercase mb-4">{{ $roleSelect['pick_side'] ?? 'Tarafını seç' }}</span>
                <h2 class="font-cinzel text-4xl sm:text-5xl md:text-6xl font-black text-white mb-2 group-hover:scale-105 transition-transform drop-shadow-lg">ADEM</h2>
                <span class="text-gold-300 text-sm font-cinzel font-bold tracking-[0.25em] mb-4 drop-shadow-md">KAŞİF</span>
                <p class="text-gold-200 text-sm font-bold max-w-xs mb-2 drop-shadow-md">{{ $roleSelect['adem']['tagline'] ?? 'Deneysel · Risk · Prototip' }}</p>
                <p class="text-slate-100 text-sm max-w-sm mb-2 font-medium drop-shadow-md">{{ $roleSelect['adem']['desc'] ?? 'Sınırları zorla, oynanışı öne çıkar.' }}</p>
                <p class="text-slate-200 text-xs max-w-sm leading-relaxed drop-shadow-md">{{ $roleSelect['adem']['detail'] ?? '' }}</p>
                <span class="mt-6 text-gold-300 text-xs font-mono font-bold group-hover:text-gold-200 transition-colors drop-shadow-sm">Giriş →</span>
            </a>
        </div>

        {{-- BABA — sağ yarı: konsept görseli arkada, üstünde içerik --}}
        <div class="role-half role-half-baba flex-1 flex flex-row justify-center items-stretch relative sm:border-l border-gold-300/20 min-h-[50vh] sm:min-h-screen overflow-hidden">
            {{-- Solid base: hafif koyu, tamamen siyah değil --}}
            <div class="absolute inset-0 bg-[#020617] opacity-90 z-[0]"></div>
            @if($babaBgExists)
                <div class="role-bg-concept" style="background-image: url('{{ asset($babaBg) }}'); z-index: 1; opacity: 0.65; filter: saturate(1.05) contrast(1.05) brightness(1);"></div>
            @else
                <div class="role-bg-image" style="background-image: url('{{ asset('images/creation_of_adam_modern.png') }}'); background-position: right center; filter: none; opacity: 1;"></div>
            @endif
            <div class="role-bg-overlay" style="z-index: 2; background: linear-gradient(to bottom, rgba(2,6,23,0.40), rgba(2,6,23,0.80));"></div>
            <div class="absolute inset-0 bg-gradient-to-bl from-transparent via-transparent to-gold-300/20 z-[3]"></div>
            <a href="{{ route('welcome', ['role' => 'baba']) }}" class="role-content flex-1 flex flex-col justify-center items-center p-6 sm:p-8 text-center group">
                <span class="font-mono text-gold-300 text-xs tracking-[0.3em] uppercase mb-4 drop-shadow-md">{{ $roleSelect['pick_side'] ?? 'Tarafını seç' }}</span>
                <h2 class="font-cinzel text-4xl sm:text-5xl md:text-6xl font-black text-white mb-2 group-hover:scale-105 transition-transform drop-shadow-[0_4px_12px_rgba(0,0,0,0.9)]">BABA</h2>
                <span class="text-gold-300 text-sm font-cinzel font-bold tracking-[0.25em] mb-4 drop-shadow-md">MİMAR</span>
                <p class="text-slate-100 text-sm font-bold max-w-xs mb-2 drop-shadow-md">{{ $roleSelect['baba']['tagline'] ?? 'Bütünlük · Sistem · Mimari' }}</p>
                <p class="text-slate-100 text-sm max-w-sm mb-2 font-medium drop-shadow-md">{{ $roleSelect['baba']['desc'] ?? 'Yapıyı kur, tutarlılığı koru.' }}</p>
                <p class="text-slate-200 text-xs max-w-sm leading-relaxed drop-shadow-md">{{ $roleSelect['baba']['detail'] ?? '' }}</p>
                <span class="mt-6 text-gold-300 text-xs font-mono font-bold group-hover:text-gold-200 transition-colors">Giriş →</span>
            </a>
            {{-- Sağ tarafta insan/karakter alanı --}}
            <div class="role-figure flex items-end justify-center pt-20 pb-4 px-4 z-[5]">
                @if($babaFigureExists)
                    <img src="{{ asset($babaFigure) }}" alt="BABA — Mimar" class="drop-shadow-2xl opacity-90">
                @else
                    <div class="w-full h-full min-h-[200px] flex items-center justify-center text-gold-300/60 text-6xl" aria-hidden="true">🛡️</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Üst ortada başlık --}}
    <div class="fixed top-0 left-0 right-0 z-20 py-4 text-center pointer-events-none">
        <p class="font-mono text-slate-500 text-xs tracking-widest font-bold">{{ $roleSelect['subtitle'] ?? 'THE LIVING CODE 2026' }}</p>
        <h1 class="font-display text-slate-800 text-lg font-bold mt-1 drop-shadow-sm">{{ $roleSelect['title'] ?? 'Takımını Seç' }}</h1>
    </div>

</body>
</html>
