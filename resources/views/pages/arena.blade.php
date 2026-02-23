@extends('layouts.app')

@section('content')
{{-- Arena Hero --}}
<section id="arena-hero" class="min-h-[30vh] flex items-center justify-center px-6 py-12 bg-dark-900 border-b border-white/10">
    <div class="text-center">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2">Canlı</span>
        <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-parchment-100 mb-2">Arena</h1>
        <p class="text-parchment-400 text-sm max-w-xl mx-auto">Sıralama, görevler, kartlar, rozetler ve mentor desteği.</p>
    </div>
</section>

{{-- Live Feed Ticker --}}
<div class="py-3 px-6 bg-dark-800/50 border-b border-white/5">
    <div class="max-w-5xl mx-auto flex items-center gap-3">
        <span class="live-pulse w-2 h-2 rounded-full bg-red-500 inline-block flex-shrink-0"></span>
        <span class="text-parchment-300 text-xs flex-shrink-0 font-mono">CANLI</span>
        <div class="overflow-hidden flex-1">
            <div class="feed-ticker-content text-xs text-parchment-200 whitespace-nowrap" id="arena-feed-ticker">
                @forelse (array_slice($feedItems ?? [], 0, 5) as $item)
                    <span class="inline-block mr-6">{{ $item['icon'] ?? '📌' }} {{ $item['message'] ?? '' }}</span>
                @empty
                    <span>Etkinlik başladığında canlı akış burada olacak.</span>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Arena Tab Navigation --}}
<div class="sticky top-14 z-30 bg-dark-900/95 backdrop-blur-sm border-b border-white/10">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex gap-1 overflow-x-auto py-3 arena-tabs" id="arena-tabs">
            <button class="arena-tab active px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap" data-panel="leaderboard">
                🏆 Sıralama
            </button>
            <button class="arena-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap" data-panel="quests">
                🎯 Görevler
            </button>
            <button class="arena-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap" data-panel="cards">
                🃏 Kartlar
            </button>
            <button class="arena-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap" data-panel="badges">
                🛡️ Rozetler
            </button>
            <button class="arena-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap" data-panel="support">
                🧙 Mentor & Test
            </button>
        </div>
    </div>
</div>

{{-- Arena Panels --}}
<div class="min-h-[60vh]">
    <div class="arena-panel active" id="panel-leaderboard">
        @include('partials.leaderboard', ['leaderboardTeams' => $leaderboardTeams ?? [], 'leaderboardParticipants' => $leaderboardParticipants ?? [], 'leaderboardViewers' => $leaderboardViewers ?? []])
    </div>

    <div class="arena-panel" id="panel-quests">
        @include('partials.quest-board', ['quests' => $quests ?? collect()])
    </div>

    <div class="arena-panel" id="panel-cards">
        @include('partials.card-market', ['cards' => $cards ?? []])
    </div>

    <div class="arena-panel" id="panel-badges">
        @include('partials.badge-gallery', ['badges' => $badges ?? []])
    </div>

    <div class="arena-panel" id="panel-support">
        @include('partials.mentor-tester', ['teamsForSelect' => $teamsForSelect ?? []])
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.arena-tab');
    const panels = document.querySelectorAll('.arena-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            const panel = document.getElementById('panel-' + tab.dataset.panel);
            if (panel) panel.classList.add('active');
        });
    });

    const hash = window.location.hash.replace('#', '');
    if (hash) {
        const panelMap = { 'leaderboard': 'leaderboard', 'quests': 'quests', 'card-market': 'cards', 'badges': 'badges', 'mentor-tester': 'support' };
        const targetPanel = panelMap[hash];
        if (targetPanel) {
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            const tab = document.querySelector(`.arena-tab[data-panel="${targetPanel}"]`);
            const panel = document.getElementById('panel-' + targetPanel);
            if (tab) tab.classList.add('active');
            if (panel) panel.classList.add('active');
        }
    }
});
</script>
@endpush
