@extends('layouts.sura')

@section('content')
<div class="min-h-screen bg-dark-900 pt-20">
    <div class="max-w-7xl mx-auto px-6 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-cinzel text-4xl font-bold text-amethyst-100 mb-2">⚖️ Şura Paneli</h1>
                    <p class="text-parchment-300 text-sm">Evrenin merkezi kontrol merkezi</p>
                </div>
                <a href="{{ route('sura.logout') }}" class="px-4 py-2 rounded-lg bg-red-500/20 border border-red-500/30 text-red-400 hover:bg-red-500/30 transition-colors text-sm">
                    Çıkış Yap
                </a>
            </div>
        </div>

        {{-- System Health --}}
        @if(isset($systemHealth))
        <div class="mb-6 p-4 rounded-xl border {{ $systemHealth['status'] === 'healthy' ? 'bg-green-500/10 border-green-500/20' : 'bg-red-500/10 border-red-500/20' }}">
            <div class="flex items-center gap-3 text-sm">
                <span class="{{ $systemHealth['status'] === 'healthy' ? 'text-green-400' : 'text-red-400' }} font-semibold">
                    {{ $systemHealth['status'] === 'healthy' ? '● Sistem Sağlıklı' : '● Sistem Sorunlu' }}
                </span>
                <span class="text-parchment-400 text-xs">
                    DB: {{ $systemHealth['database'] ?? 'unknown' }} |
                    Cache: {{ $systemHealth['cache'] ?? 'unknown' }}
                </span>
            </div>
        </div>
        @endif

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-8">
            <div class="bg-dark-800 rounded-xl p-4 border border-white/10">
                <div class="text-2xl mb-1">📦</div>
                <div class="text-parchment-300 text-xs mb-1">Hücreler</div>
                <div class="text-gold-200 font-mono font-bold text-xl">{{ $stats['hucreler'] }}</div>
            </div>
            <div class="bg-dark-800 rounded-xl p-4 border border-white/10">
                <div class="text-2xl mb-1">🏆</div>
                <div class="text-parchment-300 text-xs mb-1">Takımlar</div>
                <div class="text-gold-200 font-mono font-bold text-xl">{{ $stats['teams'] }}</div>
            </div>
            <div class="bg-dark-800 rounded-xl p-4 border border-white/10">
                <div class="text-2xl mb-1">👤</div>
                <div class="text-parchment-300 text-xs mb-1">Katılımcılar</div>
                <div class="text-gold-200 font-mono font-bold text-xl">{{ $stats['participants'] }}</div>
            </div>
            <div class="bg-dark-800 rounded-xl p-4 border border-white/10">
                <div class="text-2xl mb-1">👁️</div>
                <div class="text-parchment-300 text-xs mb-1">İzleyiciler</div>
                <div class="text-amethyst-100 font-mono font-bold text-xl">{{ $stats['viewers'] }}</div>
            </div>
            <div class="bg-dark-800 rounded-xl p-4 border border-white/10">
                <div class="text-2xl mb-1">🎯</div>
                <div class="text-parchment-300 text-xs mb-1">Aktif Görevler</div>
                <div class="text-green-400 font-mono font-bold text-xl">{{ $stats['active_quests'] }}</div>
            </div>
            <div class="bg-dark-800 rounded-xl p-4 border border-white/10">
                <div class="text-2xl mb-1">📢</div>
                <div class="text-parchment-300 text-xs mb-1">Duyurular</div>
                <div class="text-blue-400 font-mono font-bold text-xl">{{ $stats['announcements'] }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Quick Actions --}}
            <div class="lg:col-span-1">
                <div class="bg-dark-800 rounded-xl p-6 border border-white/10 mb-6">
                    <h2 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4">Hızlı İşlemler</h2>
                    <div class="space-y-3">
                        <button onclick="openAnnouncementModal()" class="w-full px-4 py-2.5 rounded-lg bg-amethyst-100 text-white text-sm font-semibold hover:bg-amethyst-200 transition-colors">
                            📢 Duyuru Yap
                        </button>
                        <button onclick="openBadgeModal()" class="w-full px-4 py-2.5 rounded-lg bg-gold-200 text-black text-sm font-semibold hover:bg-gold-100 transition-colors">
                            🏅 Rozet Ver
                        </button>
                        <button onclick="openCreditsModal()" class="w-full px-4 py-2.5 rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 text-sm font-semibold hover:bg-green-500/30 transition-colors">
                            💰 Hücreye Kredi Ver
                        </button>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="bg-dark-800 rounded-xl p-6 border border-white/10">
                    <h2 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4">Navigasyon</h2>
                    <nav class="space-y-2">
                        <a href="{{ route('sura.hucreler') }}" class="block px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 transition-colors text-sm">📦 Hücreler</a>
                        <a href="{{ route('sura.teams') }}" class="block px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 transition-colors text-sm">🏆 Takımlar</a>
                        <a href="{{ route('sura.viewers') }}" class="block px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 transition-colors text-sm">👁️ İzleyiciler</a>
                        <a href="{{ route('sura.viewer-claims') }}" class="block px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 transition-colors text-sm">📷 İzleyici XP Talepleri</a>
                        <a href="{{ route('sura.quests') }}" class="block px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 transition-colors text-sm">🎯 Görevler</a>
                        <a href="{{ route('sura.announcements') }}" class="block px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 transition-colors text-sm">📢 Duyurular</a>
                        <a href="{{ route('sura.viewer-announcements') }}" class="block px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 transition-colors text-sm">👁️ İzleyici Duyuruları</a>
                    </nav>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Pending Requests --}}
                <div class="bg-dark-800 rounded-xl p-6 border border-white/10">
                    <h2 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4">Bekleyen Talepler</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <h3 class="text-parchment-200 text-sm font-semibold mb-2">🧙 Mentor Talepleri</h3>
                            <div class="space-y-2">
                                @forelse($pendingMentors as $m)
                                <div class="p-3 rounded-lg bg-white/5 border border-white/5 text-xs">
                                    <div class="font-medium text-parchment-100">{{ $m->team->name }}</div>
                                    <div class="text-parchment-300 mt-1">{{ $m->topic }}</div>
                                    <button onclick="resolveMentor({{ $m->id }})" class="mt-2 px-2 py-1 rounded bg-green-500/20 text-green-400 text-[0.65rem] hover:bg-green-500/30 transition-colors">
                                        Çöz
                                    </button>
                                </div>
                                @empty
                                <p class="text-parchment-400 text-xs">Bekleyen talep yok</p>
                                @endforelse
                            </div>
                        </div>
                        <div>
                            <h3 class="text-parchment-200 text-sm font-semibold mb-2">📷 İzleyici XP Talepleri</h3>
                            <div class="space-y-2">
                                @if(($stats['pending_viewer_xp_claims'] ?? 0) > 0)
                                <p class="text-parchment-300 text-xs">{{ $stats['pending_viewer_xp_claims'] }} talep kanıt fotoğrafı ile onay bekliyor.</p>
                                <a href="{{ route('sura.viewer-claims') }}" class="inline-block mt-2 px-3 py-1.5 rounded bg-amethyst-100/20 text-amethyst-100 text-xs font-semibold hover:bg-amethyst-100/30 transition-colors">Talepleri incele →</a>
                                @else
                                <p class="text-parchment-400 text-xs">Bekleyen talep yok</p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h3 class="text-parchment-200 text-sm font-semibold mb-2">🧪 Test Talepleri</h3>
                            <div class="space-y-2">
                                @forelse($pendingTesters as $t)
                                <div class="p-3 rounded-lg bg-white/5 border border-white/5 text-xs">
                                    <div class="font-medium text-parchment-100">{{ $t->team->name }}</div>
                                    <div class="text-parchment-300 mt-1">{{ $t->created_at->diffForHumans() }}</div>
                                    <button onclick="resolveTester({{ $t->id }})" class="mt-2 px-2 py-1 rounded bg-green-500/20 text-green-400 text-[0.65rem] hover:bg-green-500/30 transition-colors">
                                        Test Et
                                    </button>
                                </div>
                                @empty
                                <p class="text-parchment-400 text-xs">Bekleyen talep yok</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Top Teams --}}
                <div class="bg-dark-800 rounded-xl p-6 border border-white/10">
                    <h2 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4">En İyi Takımlar</h2>
                    <div class="space-y-2">
                        @foreach($topTeams as $i => $team)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white/5 border border-white/5">
                            <div class="flex items-center gap-3">
                                <span class="text-gold-200 font-mono font-bold w-6">{{ $i + 1 }}</span>
                                <span class="font-medium text-parchment-100">{{ $team->name }}</span>
                                <span class="text-parchment-300 text-xs">{{ $team->supporter_count }} destekçi</span>
                            </div>
                            <span class="text-amethyst-100 text-xs">{{ $team->badges_count }} rozet</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Duyuru Kontrolü --}}
                <div class="bg-dark-800 rounded-xl p-6 border border-white/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-cinzel text-xl font-bold text-amethyst-100">📢 Duyuru Kontrolü</h2>
                        <div class="flex gap-2">
                            <button onclick="openAnnouncementModal()" class="px-3 py-1.5 rounded-lg bg-amethyst-100 text-white text-xs font-semibold hover:bg-amethyst-200 transition-colors">
                                + Ekle
                            </button>
                            <a href="{{ route('sura.announcements') }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-parchment-200 text-xs hover:bg-white/15 transition-colors">
                                Tümünü yönet
                            </a>
                        </div>
                    </div>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @forelse($recentAnnouncements as $a)
                        <div class="flex items-start justify-between gap-2 p-2 rounded-lg bg-white/5 text-xs group">
                            <div class="min-w-0 flex-1">
                                <span class="text-parchment-300">{{ $a->icon }}</span>
                                <span class="text-parchment-100 ml-2">{{ $a->message }}</span>
                                <span class="text-parchment-400 ml-2">{{ $a->created_at->diffForHumans() }}</span>
                            </div>
                            <button type="button" onclick="deleteAnnouncement({{ $a->id }})" class="flex-shrink-0 px-2 py-1 rounded bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors opacity-0 group-hover:opacity-100" title="Sil">
                                Sil
                            </button>
                        </div>
                        @empty
                        <p class="text-parchment-400 text-xs">Henüz duyuru yok. &quot;+ Ekle&quot; ile ekleyebilirsiniz.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals --}}
@include('sura.modals.announcement')
@include('sura.modals.badge', ['badges' => $badges ?? []])
@include('sura.modals.credits')
@include('sura.modals.mentor')
@include('sura.modals.tester')

@push('scripts')
<script>
const API_BASE = '/sura';

async function apiPost(endpoint, data) {
    const res = await fetch(API_BASE + endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        body: JSON.stringify(data),
    });
    return await res.json();
}

function openAnnouncementModal() {
    document.getElementById('announcement-modal').classList.remove('hidden');
}

function openBadgeModal() {
    document.getElementById('badge-modal').classList.remove('hidden');
}

function openCreditsModal() {
    document.getElementById('credits-modal').classList.remove('hidden');
}

async function createAnnouncement() {
    const data = {
        message: document.getElementById('announcement-message').value,
        type: document.getElementById('announcement-type').value,
        team_id: document.getElementById('announcement-team-id').value || null,
        viewer_id: document.getElementById('announcement-viewer-id').value || null,
    };
    const result = await apiPost('/announcement', data);
    if (result.success) {
        alert('Duyuru oluşturuldu!');
        location.reload();
    } else {
        alert('Hata: ' + (result.error || 'Bilinmeyen hata'));
    }
}

async function deleteAnnouncement(id) {
    if (!confirm('Bu duyuruyu silmek istediğinize emin misiniz?')) return;
    const res = await fetch(API_BASE + '/announcement/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Accept': 'application/json',
        },
    });
    const result = await res.json();
    if (result.success) {
        location.reload();
    } else {
        alert('Hata: ' + (result.error || 'Silinemedi'));
    }
}

async function assignBadge() {
    const data = {
        badge_id: document.getElementById('badge-select').value,
        team_id: document.getElementById('badge-team-id').value || null,
        viewer_id: document.getElementById('badge-viewer-id').value || null,
    };
    const result = await apiPost('/badge/assign', data);
    if (result.success) {
        alert('Rozet verildi!');
        location.reload();
    } else {
        alert('Hata: ' + (result.error || 'Bilinmeyen hata'));
    }
}

async function giveCredits() {
    const data = {
        hucre_id: document.getElementById('credits-hucre-id').value,
        amount: parseInt(document.getElementById('credits-amount').value),
    };
    const result = await apiPost('/credits/give', data);
    if (result.success) {
        alert('Kredi verildi!');
        location.reload();
    } else {
        alert('Hata: ' + (result.error || 'Bilinmeyen hata'));
    }
}

async function resolveMentor(id) {
    const mentorName = prompt('Mentor adı (opsiyonel):');
    const status = confirm('Talebi çözmek istediğinize emin misiniz?') ? 'resolved' : 'assigned';
    const result = await apiPost(`/mentor/${id}/resolve`, { mentor_name: mentorName, status });
    if (result.success) {
        location.reload();
    }
}

async function resolveTester(id) {
    const feedback = prompt('Geri bildirim (opsiyonel):');
    const rating = prompt('Puan (1-5, opsiyonel):');
    const status = confirm('Testi tamamlamak istediğinize emin misiniz?') ? 'completed' : 'testing';
    const result = await apiPost(`/tester/${id}/resolve`, {
        feedback: feedback || null,
        rating: rating ? parseInt(rating) : null,
        status,
    });
    if (result.success) {
        location.reload();
    }
}

document.querySelectorAll('[data-modal-close]').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('[id$="-modal"]').forEach(m => m.classList.add('hidden'));
    });
});
</script>
@endpush
@endsection
