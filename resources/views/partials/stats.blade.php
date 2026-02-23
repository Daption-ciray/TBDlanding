<div class="stats-bar py-10 px-6">
    <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        @foreach ($stats ?? [] as $index => $stat)
        <div class="reveal {{ $index > 0 ? 'reveal-delay-' . $index : '' }}">
            <div class="stat-value" data-count="{{ $stat['value'] }}" data-suffix="{{ $stat['suffix'] ?? '' }}">0{{ $stat['suffix'] ?? '' }}</div>
            <div class="text-parchment-300 text-xs tracking-wider mt-1 uppercase font-cinzel">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>
</div>
