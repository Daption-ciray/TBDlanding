{{-- Wraith-style compact top bar: key dates + location + CTA --}}
<div id="topbar" class="topbar border-b border-gold-300/20 bg-white/95 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-2.5 flex flex-wrap items-center justify-between gap-3 text-xs">
        <div class="flex flex-wrap items-center gap-x-6 gap-y-1 text-parchment-300">
            <span>Etkinlik: <span class="text-gold-200 font-medium">{{ $event['date_display'] ?? '3-4 Nisan 2026' }}</span> {{ $event['time_start'] ?? '09:00' }}</span>
            <span>Lokasyon: <span class="text-parchment-100">{{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }}, {{ $event['venue_city'] ?? 'İstanbul' }}</span></span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('welcome') }}#hero" class="btn-topbar rounded-md px-4 py-2 font-medium text-black bg-gold-200 hover:bg-gold-100 transition-colors">Takımla Başvur</a>
            <button type="button" id="topbar-close" class="topbar-close p-1.5 text-parchment-400 hover:text-parchment-100 transition-colors" aria-label="Kapat">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
</div>
