@extends('layouts.sura')

@section('content')
<div class="min-h-screen bg-dark-900 pt-20">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-cinzel text-4xl font-bold text-amethyst-100 mb-2">🎯 Görevler</h1>
                <p class="text-parchment-300 text-sm">Tüm görevlerin listesi ve tamamlanma durumları</p>
            </div>
            <a href="{{ route('sura.dashboard') }}" class="px-4 py-2 rounded-lg bg-dark-800 border border-white/10 text-parchment-200 hover:bg-dark-700 transition-colors text-sm">
                ← Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quests as $quest)
            <div class="bg-dark-800 rounded-xl p-6 border border-white/10">
                <div class="flex items-start justify-between mb-4">
                    <div class="text-3xl">{{ $quest->icon }}</div>
                    <span class="px-2 py-1 rounded text-xs {{ $quest->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                        {{ $quest->is_active ? 'Aktif' : 'Pasif' }}
                    </span>
                </div>
                <h3 class="font-cinzel text-lg font-bold text-amethyst-100 mb-2">{{ $quest->title }}</h3>
                <p class="text-parchment-300 text-sm mb-4">{{ $quest->description }}</p>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-parchment-400">Tip:</span>
                        <span class="text-parchment-200">{{ $quest->type }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-parchment-400">Tamamlanma:</span>
                        <span class="text-parchment-200">{{ $quest->completions_count }} / {{ $quest->max_completions ?? '∞' }}</span>
                    </div>
                    @if($quest->xp_reward)
                    <div class="flex justify-between">
                        <span class="text-parchment-400">XP Ödülü:</span>
                        <span class="text-gold-200">{{ $quest->xp_reward }}</span>
                    </div>
                    @endif
                    @if($quest->credit_reward)
                    <div class="flex justify-between">
                        <span class="text-parchment-400">Kredi Ödülü:</span>
                        <span class="text-green-400">{{ $quest->credit_reward }}</span>
                    </div>
                    @endif
                    @if($quest->expires_at)
                    <div class="flex justify-between">
                        <span class="text-parchment-400">Bitiş:</span>
                        <span class="text-parchment-200">{{ $quest->expires_at->format('d.m.Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $quests->links() }}
        </div>
    </div>
</div>
@endsection
