@extends('layouts.sura')

@section('content')
<div class="min-h-screen bg-dark-900 pt-20">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-cinzel text-4xl font-bold text-amethyst-100 mb-2">👁️ İzleyiciler</h1>
                <p class="text-parchment-300 text-sm">Tüm izleyicilerin listesi ve istatistikleri</p>
            </div>
            <a href="{{ route('sura.dashboard') }}" class="px-4 py-2 rounded-lg bg-dark-800 border border-white/10 text-parchment-200 hover:bg-dark-700 transition-colors text-sm">
                ← Dashboard
            </a>
        </div>

        <div class="bg-dark-800 rounded-xl border border-white/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-700 border-b border-white/10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">İsim</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">İzleme Süresi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">XP</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Rozet</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Seri</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($viewers as $viewer)
                        <tr class="hover:bg-dark-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono text-parchment-300">{{ $viewer->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-parchment-100">{{ $viewer->name }}</td>
                            <td class="px-6 py-4 text-sm text-parchment-300">{{ $viewer->email }}</td>
                            <td class="px-6 py-4 text-sm text-amethyst-100 font-mono">{{ $viewer->total_watch_minutes }} dk</td>
                            <td class="px-6 py-4 text-sm text-gold-200 font-mono" id="viewer-xp-{{ $viewer->id }}">{{ $viewer->xp }}</td>
                            <td class="px-6 py-4 text-sm text-parchment-300 font-mono">{{ $viewer->badges_count }}</td>
                            <td class="px-6 py-4 text-sm text-green-400 font-mono">{{ $viewer->current_streak }}</td>
                            <td class="px-6 py-4 text-sm">
                                <button type="button" onclick="giveViewerXp({{ $viewer->id }}, '{{ addslashes($viewer->name) }}')" class="px-2 py-1 rounded bg-gold-200/20 text-gold-200 text-xs hover:bg-gold-200/30 transition-colors mr-1">XP Ver</button>
                                <button type="button" onclick="openBadgeForViewer({{ $viewer->id }})" class="px-2 py-1 rounded bg-amethyst-100/20 text-amethyst-100 text-xs hover:bg-amethyst-100/30 transition-colors">Rozet Ver</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/10">
                {{ $viewers->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Rozet ver modal (izleyici) --}}
<div id="viewer-badge-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-800 rounded-xl p-6 border border-white/20 max-w-sm w-full">
        <h3 class="font-cinzel text-lg font-bold text-amethyst-100 mb-4">🏅 İzleyiciye Rozet Ver</h3>
        <input type="hidden" id="viewer-badge-viewer-id" value="">
        <div class="space-y-4">
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Rozet</label>
                <select id="viewer-badge-select" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none">
                    @foreach($badges ?? [] as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="submitViewerBadge()" class="flex-1 px-4 py-2 rounded-lg bg-amethyst-100 text-white font-semibold hover:bg-amethyst-200 transition-colors">Ver</button>
                <button type="button" onclick="document.getElementById('viewer-badge-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-200 hover:bg-dark-600 transition-colors">İptal</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function giveViewerXp(viewerId, viewerName) {
    const amount = prompt(viewerName + ' için XP miktarı:', '50');
    if (amount === null || amount === '') return;
    const num = parseInt(amount, 10);
    if (isNaN(num) || num < 1 || num > 500) {
        alert('1–500 arası bir sayı girin.');
        return;
    }
    const res = await fetch('/sura/viewer/xp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ viewer_id: viewerId, amount: num }),
    });
    const data = await res.json();
    if (data.success) {
        const cell = document.getElementById('viewer-xp-' + viewerId);
        if (cell) cell.textContent = data.new_xp;
        alert('XP verildi.');
    } else {
        alert('Hata: ' + (data.error || data.message || 'Bilinmeyen hata'));
    }
}

let currentViewerIdForBadge = null;
function openBadgeForViewer(viewerId) {
    currentViewerIdForBadge = viewerId;
    document.getElementById('viewer-badge-viewer-id').value = viewerId;
    document.getElementById('viewer-badge-modal').classList.remove('hidden');
}

async function submitViewerBadge() {
    const viewerId = document.getElementById('viewer-badge-viewer-id').value;
    const badgeId = document.getElementById('viewer-badge-select').value;
    const res = await fetch('/sura/badge/assign', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ badge_id: badgeId, viewer_id: viewerId, team_id: null }),
    });
    const data = await res.json();
    if (data.success) {
        document.getElementById('viewer-badge-modal').classList.add('hidden');
        alert('Rozet verildi.');
        location.reload();
    } else {
        alert('Hata: ' + (data.error || data.message || 'Bilinmeyen hata'));
    }
}
</script>
@endpush
@endsection
