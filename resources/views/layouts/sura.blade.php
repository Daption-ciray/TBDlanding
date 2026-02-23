<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>Şura Paneli - The Living Code</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'dark': { 900: '#1a1825', 800: '#252238', 700: '#2f2d45', 600: '#3a3852' },
                            'gold': { 100: '#fce68a', 200: '#f5d55a', 300: '#d4a843' },
                            'amethyst': { 100: '#c4b5fd', 200: '#a78bfa', 300: '#8b5cf6' },
                            'parchment': { 100: '#faf8f3', 200: '#e8e0d6', 300: '#c4b8a8', 400: '#9b8e7e' },
                        },
                        fontFamily: {
                            'cinzel': ['Cormorant Garamond', 'serif'],
                            'mono': ['JetBrains Mono', 'monospace'],
                        },
                    }
                }
            }
        </script>
    @endif

    <link rel="stylesheet" href="/css/custom.css">
    @stack('head')
</head>
<body class="bg-dark-900 text-parchment-100 font-sans">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[9999] focus:bg-gold-200 focus:text-dark-900 focus:px-4 focus:py-2 focus:rounded">
        İçeriğe atla
    </a>
    <main id="main-content">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
