<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birimini Seç – The Living Code 2026</title>
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
                        dark: { 900: '#020617', 800: '#0f172a' },
                        gold: { 100: '#fef08a', 200: '#facc15', 300: '#eab308', 400: 'rgba(250,204,21,0.25)' },
                        amethyst: { 100: '#e9d5ff', 200: '#c084fc', 300: '#a855f7', 400: 'rgba(168,85,247,0.25)' },
                        parchment: { 100: '#ffffff', 200: '#f1f5f9', 300: '#cbd5e1', 400: '#94a3b8' },
                    },
                    fontFamily: {
                        cinzel: ['"Cinzel Decorative"', 'serif'],
                        display: ['Playfair Display', 'serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                },
            },
        };
    </script>
    <style>
        .role-half { 
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .role-half:hover { flex: 1.25; }
        
        .role-bg-concept {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
            transition: transform 1.2s ease;
        }
        .role-half:hover .role-bg-concept {
            transform: scale(1.05);
        }

        .role-bg-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .role-content { 
            position: relative; 
            z-index: 10; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .divider-shadow {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 150px;
            z-index: 5;
            pointer-events: none;
        }
        .divider-left { right: 0; background: linear-gradient(to right, transparent, rgba(0,0,0,0.4)); }
        .divider-right { left: 0; background: linear-gradient(to left, transparent, rgba(0,0,0,0.4)); }

        .sync-bar {
            width: 120px;
            height: 2px;
            background: rgba(255,255,255,0.1);
            position: relative;
            margin: 10px auto;
            border-radius: 2px;
            overflow: hidden;
        }
        .sync-progress {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            transition: width 1s ease;
        }

        @keyframes pulse-gold {
            0% { box-shadow: 0 0 0 0 rgba(250, 204, 21, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(250, 204, 21, 0); }
            100% { box-shadow: 0 0 0 0 rgba(250, 204, 21, 0); }
        }
        .pulse-priority {
            animation: pulse-gold 2s infinite;
        }

        @media (max-width: 640px) {
            .role-half { min-height: 50vh; }
            .divider-shadow { display: none; }
        }
    </style>
</head>
<body class="bg-black text-white min-h-screen overflow-hidden font-sans">

    <div class="absolute inset-0 flex flex-col sm:flex-row">
        {{-- KAŞİF — Sol Taraf --}}
        <div class="role-half group/kasif">
            <div class="role-bg-concept" style="background-image: url('{{ $roleSelect['kasif']['concept_bg'] }}');"></div>
            <div class="role-bg-overlay" style="background: radial-gradient(circle at 30% center, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.8) 100%);"></div>
            <div class="divider-shadow divider-left"></div>

            @if($roleSelect['kasif']['sync_percent'] >= 100)
            <div class="role-content p-8 text-center cursor-not-allowed opacity-60 grayscale">
            @else
            <a href="{{ route('welcome', ['role' => 'kasif']) }}" class="role-content p-8 text-center">
            @endif
                <div class="max-w-md transform group-hover/kasif:scale-105 transition-transform duration-500 pt-24">
                    <span class="font-mono text-gold-300 text-[10px] tracking-[0.4em] uppercase mb-4 block opacity-80">KEŞİF YOLU</span>
                    
                    @if($roleSelect['kasif']['sync_percent'] < 100)
                        @if($roleSelect['kasif']['status'] === 'ÇOK YÜKSEK TALEP')
                            <div class="inline-block px-3 py-1 bg-red-600 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 animate-pulse rounded-sm">
                                DURUM: ÇOK YÜKSEK TALEP
                            </div>
                        @elseif($roleSelect['kasif']['status'] === 'YÜKSEK TALEP')
                            <div class="inline-block px-3 py-1 bg-red-500 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 rounded-sm">
                                DURUM: YÜKSEK TALEP
                            </div>
                        @elseif($roleSelect['kasif']['status'] === 'ARTAN TALEP')
                            <div class="inline-block px-3 py-1 bg-orange-500 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 rounded-sm">
                                DURUM: ARTAN TALEP
                            </div>
                        @elseif($roleSelect['kasif']['status'] === 'KRİTİK İHTİYAÇ')
                            <div class="inline-block px-3 py-1 bg-gold-200 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 pulse-priority rounded-sm">
                                DURUM: KRİTİK İHTİYAÇ
                            </div>
                        @elseif($roleSelect['kasif']['status'] === 'ACİL İHTİYAÇ')
                            <div class="inline-block px-3 py-1 bg-gold-300 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 rounded-sm">
                                DURUM: ACİL İHTİYAÇ
                            </div>
                        @elseif($roleSelect['kasif']['status'] === 'GEREKLİ İHTİYAÇ')
                            <div class="inline-block px-3 py-1 bg-slate-600 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 rounded-sm">
                                DURUM: GEREKLİ İHTİYAÇ
                            </div>
                        @endif
                    @endif

                    <h2 class="font-cinzel text-5xl sm:text-6xl md:text-7xl font-black text-white mb-1 drop-shadow-2xl">KAŞİF</h2>
                    <div class="w-10 h-0.5 bg-gold-300 mx-auto mb-6 opacity-40"></div>
                    
                    <p class="text-gold-200 text-sm font-cinzel font-bold tracking-[0.2em] mb-2">{{ $roleSelect['kasif']['tagline'] }}</p>
                    <p class="text-slate-200 text-xs max-w-xs mx-auto leading-relaxed mb-8 opacity-80">
                        {{ $roleSelect['kasif']['desc'] }}
                    </p>
                    <div class="inline-block px-8 py-2.5 border border-gold-300/30 font-mono text-[10px] tracking-[0.2em] text-gold-300 group-hover/kasif:bg-gold-200 group-hover/kasif:text-white transition-all uppercase">
                        @if($roleSelect['kasif']['sync_percent'] >= 100)
                            SİSTEM KAPALI: KOTA DOLDU
                        @else
                            SİSTEME BAĞLAN →
                        @endif
                    </div>
                </div>
            @if($roleSelect['kasif']['sync_percent'] >= 100)
            </div>
            @else
            </a>
            @endif
        </div>

        {{-- MİMAR — Sağ Taraf --}}
        <div class="role-half group/mimar">
            <div class="role-bg-concept" style="background-image: url('{{ $roleSelect['mimar']['concept_bg'] }}');"></div>
            <div class="role-bg-overlay" style="background: radial-gradient(circle at 70% center, rgba(2,6,23,0.1) 0%, rgba(2,6,23,0.9) 100%);"></div>
            <div class="divider-shadow divider-right"></div>

            @if($roleSelect['mimar']['sync_percent'] >= 100)
            <div class="role-content p-8 text-center cursor-not-allowed opacity-60 grayscale">
            @else
            <a href="{{ route('welcome', ['role' => 'mimar']) }}" class="role-content p-8 text-center">
            @endif
                <div class="max-w-md transform group-hover/mimar:scale-105 transition-transform duration-500 pt-24">
                    <span class="font-mono text-gold-300 text-[10px] tracking-[0.4em] uppercase mb-4 block opacity-80">MİMARİ DÜZEN</span>
                    
                    @if($roleSelect['mimar']['sync_percent'] < 100)
                        @if($roleSelect['mimar']['status'] === 'ÇOK YÜKSEK TALEP')
                            <div class="inline-block px-3 py-1 bg-red-600 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 animate-pulse rounded-sm">
                                DURUM: ÇOK YÜKSEK TALEP
                            </div>
                        @elseif($roleSelect['mimar']['status'] === 'YÜKSEK TALEP')
                            <div class="inline-block px-3 py-1 bg-red-500 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 rounded-sm">
                                DURUM: YÜKSEK TALEP
                            </div>
                        @elseif($roleSelect['mimar']['status'] === 'ARTAN TALEP')
                            <div class="inline-block px-3 py-1 bg-orange-500 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 rounded-sm">
                                DURUM: ARTAN TALEP
                            </div>
                        @elseif($roleSelect['mimar']['status'] === 'KRİTİK İHTİYAÇ')
                            <div class="inline-block px-3 py-1 bg-gold-200 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 pulse-priority rounded-sm">
                                DURUM: KRİTİK İHTİYAÇ
                            </div>
                        @elseif($roleSelect['mimar']['status'] === 'ACİL İHTİYAÇ')
                            <div class="inline-block px-3 py-1 bg-gold-300 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 rounded-sm">
                                DURUM: ACİL İHTİYAÇ
                            </div>
                        @elseif($roleSelect['mimar']['status'] === 'GEREKLİ İHTİYAÇ')
                            <div class="inline-block px-3 py-1 bg-slate-600 text-white font-mono text-[9px] font-bold tracking-tighter mb-2 rounded-sm">
                                DURUM: GEREKLİ İHTİYAÇ
                            </div>
                        @endif
                    @endif

                    <h2 class="font-cinzel text-5xl sm:text-6xl md:text-7xl font-black text-white mb-1 drop-shadow-2xl">MİMAR</h2>
                    <div class="w-10 h-0.5 bg-gold-300 mx-auto mb-6 opacity-40"></div>

                    <p class="text-slate-100 text-sm font-cinzel font-bold tracking-[0.2em] mb-2">{{ $roleSelect['mimar']['tagline'] }}</p>
                    <p class="text-slate-300 text-xs max-w-xs mx-auto leading-relaxed mb-8 opacity-80">
                        {{ $roleSelect['mimar']['desc'] }}
                    </p>
                    <div class="inline-block px-8 py-2.5 border border-gold-300/30 font-mono text-[10px] tracking-[0.2em] text-gold-300 group-hover/mimar:bg-gold-200 group-hover/mimar:text-white transition-all uppercase">
                        @if($roleSelect['mimar']['sync_percent'] >= 100)
                            SİSTEM KAPALI: KOTA DOLDU
                        @else
                            SİSTEME BAĞLAN →
                        @endif
                    </div>
                </div>
            @if($roleSelect['mimar']['sync_percent'] >= 100)
            </div>
            @else
            </a>
            @endif
        </div>
    </div>

    {{-- Minimal Header --}}
    <div class="fixed top-0 left-0 right-0 z-20 py-8 text-center pointer-events-none">
        <p class="font-mono text-gold-300/40 text-[10px] tracking-[0.8em] uppercase">{{ $roleSelect['subtitle'] }}</p>
    </div>

</body>
</html>
