{{-- Konsey: dört farz — sistem sesi, asimetrik sağ ağırlık --}}
@php $activeRole = $role ?? 'kasif'; @endphp
<section
    id="sura"
    class="section-sura py-16 sm:py-24 px-6 relative {{ $activeRole === 'mimar' ? 'bg-[#020617] mimar-theme' : 'bg-dark-900 kasif-theme' }}"
>
    <div class="max-w-5xl mx-auto text-center">
        <span class="section-voice-label {{ $activeRole === 'mimar' ? 'text-amethyst-200/90' : 'text-gold-300' }} text-xs font-mono tracking-widest uppercase block mb-2 reveal"><span class="term-tooltip" data-term="Etkinliğin jüri konseyi">Konsey</span></span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Operasyon ve Demo Akışı
        </h2>
        <p class="text-parchment-400 text-sm mb-12 reveal">
            <strong class="{{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}">Uyanış</strong> · <strong class="{{ $activeRole === 'mimar' ? 'text-amethyst-300' : 'text-gold-300' }}">Kurgu</strong> · <strong class="text-red-400">Optimizasyon</strong> · <strong class="{{ $activeRole === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }}">Kaynak Kod</strong>
        </p>

        <div class="section-sura-content grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
            @foreach ($phases ?? [] as $i => $phase)
            @php
                $num = str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT);
            @endphp
            <div class="process-card rounded-xl p-6 border border-white/10 bg-white/[0.03] {{ $activeRole === 'mimar' ? 'hover:border-amethyst-200/20' : 'hover:border-gold-200/20' }} transition-colors reveal">
                <div class="{{ $activeRole === 'mimar' ? 'text-amethyst-200/80' : 'text-gold-200/80' }} font-mono text-sm mb-2">{{ $num }}</div>
                <div class="text-parchment-300 text-xs mb-1">{{ $phase['day'] }}</div>
                <h3 class="font-cinzel {{ $activeRole === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold mb-3">{{ $phase['name'] }}</h3>
                <p class="text-parchment-200 text-sm leading-relaxed">{{ $phase['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
