<div class="overflow-hidden py-4 border-y border-gold-300/10" style="background: rgba(16,12,32,0.5)">
    <div class="marquee-track">
        @for ($i = 0; $i < 2; $i++)
        <span class="flex items-center gap-8 px-4 text-parchment-300 text-sm font-cinzel tracking-wider whitespace-nowrap">
            @foreach ($marqueeItems ?? config('livingcode.marquee_items') as $item)
            <span>{{ $item }}</span>
            <span class="text-gold-300">✦</span>
            @endforeach
            <span class="text-gold-300 mr-8">✦</span>
        </span>
        @endfor
    </div>
</div>
