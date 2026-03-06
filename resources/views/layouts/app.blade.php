<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The Living Code 2026 – TBD Game Jam. 3-4 Nisan 2026, Nişantaşı Üniversitesi. Kaotik Uyum temasıyla 36 saatlik oyun geliştirme deneyimi.">
    <meta property="og:title" content="The Living Code 2026 – TBD Game Jam">
    <meta property="og:description" content="36 saatlik kaotik oyun geliştirme deneyimi. 3-4 Nisan 2026, Nişantaşı Üniversitesi.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Living Code 2026 – TBD Game Jam</title>
    <link rel="icon" href="/images/tbd_logo.png" type="image/png">

    {{-- Font preloading --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Vite build varsa onu kullan, yoksa Tailwind CDN + public/js --}}
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            // Arka plan: Koyu tonlar
                            'dark': {
                                900: '#020617',
                                800: '#0f172a',
                                700: '#1e293b',
                                600: '#334155',
                            },
                            // Altın sarısı
                            'gold': {
                                100: '#fef08a',
                                200: '#facc15',
                                300: '#eab308',
                                400: 'rgba(250,204,21,0.25)',
                            },
                            // Turuncu tonları
                            'amethyst': {
                                100: '#fed7aa',
                                200: '#fdba74',
                                300: '#f97316',
                                400: 'rgba(249,115,22,0.25)',
                            },
                            // Metinler: Daima açık renkler
                            'parchment': {
                                100: '#ffffff',
                                200: '#f1f5f9',
                                300: '#cbd5e1',
                                400: '#94a3b8',
                            },
                        },
                        fontFamily: {
                            'cinzel': ['"Cinzel Decorative"', 'serif'],
                            'display': ['"Cinzel Decorative"', 'serif'],
                            'inter': ['Inter', 'sans-serif'],
                            'mono': ['JetBrains Mono', 'monospace'],
                        },
                    }
                }
            }
        </script>
    @endif

    <link rel="stylesheet" href="/css/custom.css?v={{ file_exists(public_path('css/custom.css')) ? filemtime(public_path('css/custom.css')) : time() }}">
    @stack('head')
@php
    $activeRole = session('livingcode_role', 'kasif');
    $activeTheme = session('livingcode_theme', 'light');
@endphp
</head>
<body class="font-inter {{ $activeTheme }} {{ $activeRole === 'mimar' ? 'theme-baba' : 'theme-adem' }}">

    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[9999] focus:bg-gold-200 focus:text-parchment-100 focus:px-4 focus:py-2 focus:rounded">
        İçeriğe atla
    </a>

    @include('partials.topbar', ['event' => config('livingcode.event')])
    @include('partials.nav')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="/js/main.js" defer></script>
    <script>
        // Theme Toggle Logic
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            
            // Initial state based on body class
            if (document.body.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                // Toggle icons
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // Toggle body class
                if (document.body.classList.contains('dark')) {
                    document.body.classList.remove('dark');
                    document.body.classList.add('light');
                    saveTheme('light');
                } else {
                    document.body.classList.remove('light');
                    document.body.classList.add('dark');
                    saveTheme('dark');
                }
            });

            function saveTheme(theme) {
                fetch('{{ route('toggle-theme') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ theme: theme })
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
