<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şura Girişi - The Living Code</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark': { 900: '#1a1825', 800: '#252238', 700: '#2f2d45' },
                        'gold': { 100: '#fce68a', 200: '#f5d55a', 300: '#d4a843' },
                        'amethyst': { 100: '#c4b5fd', 200: '#a78bfa', 300: '#8b5cf6' },
                        'parchment': { 100: '#faf8f3', 200: '#e8e0d6', 300: '#c4b8a8' },
                    },
                    fontFamily: {
                        'cinzel': ['Cormorant Garamond', 'serif'],
                        'mono': ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="bg-dark-900 text-parchment-100 font-sans min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-6">
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">⚖️</div>
            <h1 class="font-cinzel text-3xl font-bold text-gold-200 mb-2">Şura Paneli</h1>
            <p class="text-parchment-300 text-sm">Evrenin merkezi otoritesi</p>
        </div>

        <form method="POST" action="{{ route('sura.login') }}" class="bg-dark-800 rounded-xl p-8 border border-amethyst-100/20">
            @csrf
            @if(session('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-500/30 text-red-400 text-sm">
                {{ session('error') }}
            </div>
            @endif
            @if(session('message'))
            <div class="mb-4 p-3 rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 text-sm">
                {{ session('message') }}
            </div>
            @endif

            <div class="mb-6">
                <label class="block text-parchment-200 text-sm font-medium mb-2">Şura Şifresi</label>
                <input type="password" name="sura_password" required autofocus
                    class="w-full px-4 py-3 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 font-mono focus:border-amethyst-100/50 focus:outline-none transition-colors"
                    placeholder="••••••••">
            </div>

            <button type="submit" class="w-full px-4 py-3 rounded-lg bg-amethyst-100 text-white font-semibold hover:bg-amethyst-200 transition-colors">
                Giriş Yap
            </button>
        </form>

        <p class="text-center text-parchment-400 text-xs mt-6">
            <a href="{{ route('welcome') }}" class="hover:text-parchment-200 transition-colors">← Ana Sayfaya Dön</a>
        </p>
    </div>
</body>
</html>
