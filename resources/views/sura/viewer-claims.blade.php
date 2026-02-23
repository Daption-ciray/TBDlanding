@extends('layouts.sura')

@section('content')
<div class="min-h-screen bg-dark-900 pt-20">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-cinzel text-4xl font-bold text-amethyst-100 mb-2">📷 İzleyici XP Talepleri</h1>
                <p class="text-parchment-300 text-sm">Kanıt fotoğraflarıyla gelen talepleri onaylayın veya reddedin</p>
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
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">İzleyici</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Platform</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">XP</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Kanıt</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Tarih</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">İşlem</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($claims as $claim)
                        <tr class="hover:bg-dark-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm">
                                <span class="font-medium text-parchment-100">{{ $claim->viewer->name ?? '—' }}</span>
                                <span class="text-parchment-400 text-xs block">{{ $claim->viewer->email ?? '' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-parchment-200">{{ $claim->platform }}</td>
                            <td class="px-6 py-4 text-sm text-gold-200 font-mono">+{{ $claim->points_requested }}</td>
                            <td class="px-6 py-4">
                                @php $proofUrl = asset('storage/' . $claim->proof_path); @endphp
                                <button type="button" onclick="openProofModal({{ $claim->id }}, '{{ addslashes($proofUrl) }}', '{{ addslashes($claim->viewer->name ?? '') }}', '{{ $claim->platform }}', {{ $claim->points_requested }})" class="block w-14 h-14 rounded-lg border border-white/10 bg-white/5 overflow-hidden hover:border-amethyst-100/30 transition-colors">
                                    <img src="{{ $proofUrl }}" alt="Kanıt" class="w-full h-full object-cover" loading="lazy" onerror="this.parentElement.innerHTML='📷'">
                                </button>
                            </td>
                            <td class="px-6 py-4 text-sm text-parchment-400">{{ $claim->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-sm">
                                <button type="button" onclick="approveClaim({{ $claim->id }})" class="px-3 py-1.5 rounded-lg bg-green-500/20 text-green-400 text-xs font-semibold hover:bg-green-500/30 transition-colors mr-1">Onayla</button>
                                <button type="button" onclick="rejectClaim({{ $claim->id }})" class="px-3 py-1.5 rounded-lg bg-red-500/20 text-red-400 text-xs font-semibold hover:bg-red-500/30 transition-colors">Reddet</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-parchment-400 text-sm">Bekleyen izleyici XP talebi yok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/10">
                {{ $claims->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Kanıt fotoğrafı büyük görüntü + Onayla/Reddet --}}
<div id="claim-proof-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80">
    <div class="bg-dark-800 rounded-xl border border-white/20 max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
        <div class="p-4 border-b border-white/10 flex items-center justify-between">
            <div>
                <span id="claim-modal-viewer" class="font-medium text-parchment-100"></span>
                <span id="claim-modal-platform" class="text-parchment-400 text-sm ml-2"></span>
                <span id="claim-modal-points" class="text-gold-200 text-sm font-mono ml-2"></span>
            </div>
            <button type="button" onclick="closeProofModal()" class="text-parchment-400 hover:text-parchment-100 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-4 overflow-auto flex-1">
            <img id="claim-modal-img" src="" alt="Kanıt" class="w-full rounded-lg border border-white/10">
        </div>
        <div class="p-4 border-t border-white/10 flex gap-3">
            <input type="hidden" id="claim-modal-id" value="">
            <button type="button" id="claim-modal-approve" class="flex-1 px-4 py-2.5 rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 font-semibold hover:bg-green-500/30 transition-colors">Onayla (XP ekle)</button>
            <button type="button" id="claim-modal-reject" class="flex-1 px-4 py-2.5 rounded-lg bg-red-500/20 border border-red-500/30 text-red-400 font-semibold hover:bg-red-500/30 transition-colors">Reddet</button>
            <button type="button" onclick="closeProofModal()" class="px-4 py-2.5 rounded-lg bg-white/10 text-parchment-200 hover:bg-white/15 transition-colors">Kapat</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
const API_BASE = '/sura';

function openProofModal(id, imgUrl, viewerName, platform, points) {
    document.getElementById('claim-modal-id').value = id;
    document.getElementById('claim-modal-img').src = imgUrl;
    document.getElementById('claim-modal-viewer').textContent = viewerName;
    document.getElementById('claim-modal-platform').textContent = platform;
    document.getElementById('claim-modal-points').textContent = '+' + points + ' XP';
    document.getElementById('claim-proof-modal').classList.remove('hidden');
}

function closeProofModal() {
    document.getElementById('claim-proof-modal').classList.add('hidden');
}

document.getElementById('claim-modal-approve').addEventListener('click', function() {
    const id = document.getElementById('claim-modal-id').value;
    if (!id) return;
    approveClaim(parseInt(id, 10));
});
document.getElementById('claim-modal-reject').addEventListener('click', function() {
    const id = document.getElementById('claim-modal-id').value;
    if (!id) return;
    rejectClaim(parseInt(id, 10));
});

async function approveClaim(id) {
    const res = await fetch(API_BASE + '/viewer-claim/' + id + '/approve', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({}),
    });
    const data = await res.json();
    if (data.success) {
        closeProofModal();
        location.reload();
    } else {
        alert('Hata: ' + (data.error || 'Onaylanamadı'));
    }
}

async function rejectClaim(id) {
    const reason = prompt('Red sebebi (opsiyonel):');
    const res = await fetch(API_BASE + '/viewer-claim/' + id + '/reject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ reason: reason || null }),
    });
    const data = await res.json();
    if (data.success) {
        closeProofModal();
        location.reload();
    } else {
        alert('Hata: ' + (data.error || 'Reddedilemedi'));
    }
}
</script>
@endpush
@endsection
