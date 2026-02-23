{{-- Wraith-style: simple Lokasyon block --}}
<section id="mekan" class="py-16 sm:py-24 px-6 relative border-t border-white/10 bg-dark-800/50">
    <div class="max-w-3xl mx-auto">
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Lokasyon
        </h2>
        <p class="text-parchment-400 text-sm mb-6 reveal">{{ strtolower($event['venue'] ?? 'Nişantaşı Üniversitesi') }}</p>
        <p class="text-parchment-200 text-sm leading-relaxed reveal">
            {{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }}, {{ $event['venue_city'] ?? 'İstanbul' }}. Modern altyapı, geniş çalışma alanları ve kolay ulaşım.
        </p>
    </div>
</section>
