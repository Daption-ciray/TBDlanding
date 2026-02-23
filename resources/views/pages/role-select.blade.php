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
                    colors: {
                        'dark': { 900: '#f8fafc', 800: '#f1f5f9' },
                        'gold': { 100: '#d97706', 200: '#b45309', 300: '#92400e', 400: 'rgba(217,119,6,0.25)' },
                        'amethyst': { 100: '#4c1d95', 200: '#5b21b6', 300: '#6d28d9', 400: 'rgba(76,29,149,0.25)' },
                        'parchment': { 100: '#0f172a', 200: '#1e293b', 300: '#334155', 400: '#475569' },
                    },
                    fontFamily: { 
                        'cinzel': ['"Cinzel Decorative"', 'serif'], 
                        'display': ['Playfair Display', 'serif'],
                        'inter': ['"Cinzel Decorative"', 'serif'], 
                        'mono': ['JetBrains Mono', 'monospace'] 
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="/css/custom.css">
    <style>
        .role-half { transition: flex 0.5s cubic-bezier(0.23, 1, 0.32, 1); }
        .role-half:hover { flex: 1.15; }
        .role-half a { display: block; height: 100%; }
        
        /* Blur'lu arka plan görselleri */
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
        .role-bg-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(26,24,37,0.3), rgba(37,34,56,0.2));
            z-index: 1;
        }
        .role-content {
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body class="font-inter bg-slate-100 text-slate-800 min-h-screen overflow-hidden">

    <div class="absolute inset-0 flex flex-col sm:flex-row">
        {{-- ADEM — sol yarı --}}
        <div class="role-half flex-1 flex flex-col justify-center items-center relative sm:border-r border-gold-300/20 min-h-[50vh] sm:min-h-screen overflow-hidden">
            {{-- Blur'suz net arka plan görseli (ADEM) - Görselin sol tarafı --}}
            <div class="role-bg-image" style="background-image: url('{{ asset('images/creation_of_adam_modern.png') }}'); background-position: left center; filter: none; opacity: 1;"></div>
            <div class="role-bg-overlay" style="background: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.7));"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-black/40 via-transparent to-gold-300/20 z-[2]"></div>
            
            <a href="{{ route('welcome', ['role' => 'adem']) }}" class="role-content absolute inset-0 z-10 flex flex-col justify-center items-center p-8 text-center group">
                <span class="font-mono text-gold-300 text-xs tracking-[0.3em] uppercase mb-4">{{ $roleSelect['pick_side'] ?? 'Tarafını seç' }}</span>
                <h2 class="font-cinzel text-4xl sm:text-5xl md:text-6xl font-black text-white mb-2 group-hover:scale-105 transition-transform drop-shadow-lg">ADEM</h2>
                <span class="text-gold-300 text-sm font-cinzel font-bold tracking-[0.25em] mb-4 drop-shadow-md">KAŞİF</span>
                <p class="text-gold-200 text-sm font-bold max-w-xs mb-2 drop-shadow-md">{{ $roleSelect['adem']['tagline'] ?? 'Deneysel · Risk · Prototip' }}</p>
                <p class="text-slate-100 text-sm max-w-sm mb-2 font-medium drop-shadow-md">{{ $roleSelect['adem']['desc'] ?? 'Sınırları zorla, oynanışı öne çıkar.' }}</p>
                <p class="text-slate-200 text-xs max-w-sm leading-relaxed drop-shadow-md">{{ $roleSelect['adem']['detail'] ?? '' }}</p>
                <span class="mt-6 text-gold-300 text-xs font-mono font-bold group-hover:text-gold-200 transition-colors drop-shadow-sm">Giriş →</span>
            </a>
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-gold-300/80 text-2xl drop-shadow-lg">🔥</div>
        </div>

        {{-- BABA — sağ yarı --}}
        <div class="role-half flex-1 flex flex-col justify-center items-center relative sm:border-l border-amethyst-100/20 min-h-[50vh] sm:min-h-screen overflow-hidden">
            {{-- Blur'suz net arka plan görseli (BABA) - Görselin sağ tarafı --}}
            <div class="role-bg-image" style="background-image: url('{{ asset('images/creation_of_adam_modern.png') }}'); background-position: right center; filter: none; opacity: 1;"></div>
            <div class="role-bg-overlay" style="background: linear-gradient(to bottom, rgba(255,255,255,0.7), rgba(248,250,252,0.85));"></div>
            <div class="absolute inset-0 bg-gradient-to-bl from-white/40 via-transparent to-amethyst-400 z-[2]"></div>
            
            <a href="{{ route('welcome', ['role' => 'baba']) }}" class="role-content absolute inset-0 z-10 flex flex-col justify-center items-center p-8 text-center group">
                <span class="font-mono text-amethyst-300 text-xs tracking-[0.3em] uppercase mb-4">{{ $roleSelect['pick_side'] ?? 'Tarafını seç' }}</span>
                <h2 class="font-cinzel text-4xl sm:text-5xl md:text-6xl font-black text-slate-900 mb-2 group-hover:scale-105 transition-transform drop-shadow-sm">BABA</h2>
                <span class="text-amethyst-300 text-sm font-cinzel font-bold tracking-[0.25em] mb-4">MİMAR</span>
                <p class="text-slate-800 text-sm font-bold max-w-xs mb-2">{{ $roleSelect['baba']['tagline'] ?? 'Bütünlük · Sistem · Mimari' }}</p>
                <p class="text-slate-700 text-sm max-w-sm mb-2 font-medium">{{ $roleSelect['baba']['desc'] ?? 'Yapıyı kur, tutarlılığı koru.' }}</p>
                <p class="text-slate-700 text-xs max-w-sm leading-relaxed">{{ $roleSelect['baba']['detail'] ?? '' }}</p>
                <span class="mt-6 text-amethyst-300 text-xs font-mono font-bold group-hover:text-amethyst-200 transition-colors">Giriş →</span>
            </a>
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-amethyst-300/80 text-2xl drop-shadow-md">🛡️</div>
        </div>
    </div>

    {{-- Üst ortada başlık --}}
    <div class="fixed top-0 left-0 right-0 z-20 py-4 text-center pointer-events-none">
        <p class="font-mono text-slate-500 text-xs tracking-widest font-bold">{{ $roleSelect['subtitle'] ?? 'THE LIVING CODE 2026' }}</p>
        <h1 class="font-display text-slate-800 text-lg font-bold mt-1 drop-shadow-sm">{{ $roleSelect['title'] ?? 'Takımını Seç' }}</h1>
    </div>

</body>
</html>
