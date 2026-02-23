@extends('layouts.sura')

@section('content')
<div class="min-h-screen bg-dark-900 pt-20">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-cinzel text-4xl font-bold text-amethyst-100 mb-2">📦 Hücreler</h1>
                <p class="text-parchment-300 text-sm">ADEM ve BABA hücreleri — takım sayıları ve özetler</p>
            </div>
            <div class="flex gap-2">
                <button onclick="openHucreModal()" class="px-4 py-2 rounded-lg bg-amethyst-100 text-white text-sm font-semibold hover:bg-amethyst-200 transition-colors">+ Hücre Ekle</button>
                <a href="{{ route('sura.dashboard') }}" class="px-4 py-2 rounded-lg bg-dark-800 border border-white/10 text-parchment-200 hover:bg-dark-700 transition-colors text-sm">
                    ← Dashboard
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($hucreler as $h)
            <div class="bg-dark-800 rounded-xl border border-white/10 overflow-hidden">
                <div class="p-6 border-b border-white/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-cinzel text-xl font-bold text-amethyst-100">{{ $h->name }}</h2>
                        <div class="flex gap-1">
                            <button onclick="editHucre({{ $h->id }}, '{{ addslashes($h->name) }}', '{{ $h->role }}', {{ $h->credits }}, {{ $h->xp }}, {{ $h->is_active ? 'true' : 'false' }})" class="px-2 py-1 rounded bg-blue-500/20 text-blue-400 text-xs hover:bg-blue-500/30 transition-colors" title="Düzenle">
                                ✏️
                            </button>
                            <button onclick="giveCreditsToHucre({{ $h->id }}, '{{ addslashes($h->name) }}')" class="px-2 py-1 rounded bg-green-500/20 text-green-400 text-xs hover:bg-green-500/30 transition-colors" title="Kredi Ver">
                                💰
                            </button>
                            <button onclick="deleteHucre({{ $h->id }}, '{{ addslashes($h->name) }}')" class="px-2 py-1 rounded bg-red-500/20 text-red-400 text-xs hover:bg-red-500/30 transition-colors" title="Sil">
                                🗑️
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-3">
                        <div class="text-center p-3 rounded-lg bg-white/5">
                            <span class="font-mono font-bold text-gold-200 text-lg block">{{ $h->teams->count() }}</span>
                            <span class="text-parchment-300 text-xs">Takım</span>
                        </div>
                        <div class="text-center p-3 rounded-lg bg-white/5">
                            <span class="font-mono font-bold text-green-400 text-lg block">{{ $h->credits }}</span>
                            <span class="text-parchment-300 text-xs">Kredi</span>
                        </div>
                        <div class="text-center p-3 rounded-lg bg-white/5">
                            <span class="font-mono font-bold text-amethyst-100 text-lg block">{{ $h->xp }}</span>
                            <span class="text-parchment-300 text-xs">XP</span>
                        </div>
                        <div class="text-center p-3 rounded-lg bg-white/5">
                            <span class="font-mono font-bold text-parchment-200 text-lg block">{{ $h->total_supporters }}</span>
                            <span class="text-parchment-300 text-xs">Destekçi</span>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-parchment-300 text-xs font-semibold uppercase mb-2">Bu hücredeki takımlar</h3>
                    <ul class="space-y-1.5">
                        @forelse($h->teams as $t)
                        <li class="flex items-center justify-between text-sm">
                            <a href="{{ route('sura.teams') }}?role={{ $h->role }}" class="text-parchment-200 hover:text-amethyst-100 truncate">{{ $t->name }}</a>
                            <span class="text-parchment-400 text-xs font-mono flex-shrink-0 ml-2">{{ $t->supporter_count }} destekçi · {{ $t->badges_count }} rozet</span>
                        </li>
                        @empty
                        <li class="text-parchment-400 text-sm">Bu hücrede henüz takım yok.</li>
                        @endforelse
                    </ul>
                    <a href="{{ route('sura.teams') }}?role={{ $h->role }}" class="inline-block mt-3 text-amethyst-100 text-sm hover:underline">Tüm takımları gör →</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Hücre Ekle/Düzenle Modal --}}
<div id="hucre-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-800 rounded-xl p-6 border border-white/20 max-w-md w-full">
        <h3 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4" id="hucre-modal-title">Hücre Ekle</h3>
        <div class="space-y-4">
            <input type="hidden" id="hucre-modal-id" value="">
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Hücre Adı *</label>
                <input type="text" id="hucre-modal-name" required class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="Hücre adı">
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Rol *</label>
                <select id="hucre-modal-role" required class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none">
                    <option value="adem">ADEM</option>
                    <option value="baba">BABA</option>
                </select>
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Başlangıç Kredisi</label>
                <input type="number" id="hucre-modal-credits" min="0" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="100" value="100">
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Başlangıç XP</label>
                <input type="number" id="hucre-modal-xp" min="0" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="0" value="0">
            </div>
            <div id="hucre-modal-active-field" class="hidden">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="hucre-modal-is-active" class="rounded bg-dark-700 border-white/10">
                    <span class="text-parchment-200 text-sm">Aktif</span>
                </label>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="saveHucre()" class="flex-1 px-4 py-2 rounded-lg bg-amethyst-100 text-white font-semibold hover:bg-amethyst-200 transition-colors">
                    Kaydet
                </button>
                <button type="button" onclick="closeHucreModal()" class="px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-200 hover:bg-dark-600 transition-colors">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openHucreModal() {
    document.getElementById('hucre-modal-title').textContent = 'Hücre Ekle';
    document.getElementById('hucre-modal-id').value = '';
    document.getElementById('hucre-modal-name').value = '';
    document.getElementById('hucre-modal-role').value = 'adem';
    document.getElementById('hucre-modal-credits').value = '100';
    document.getElementById('hucre-modal-xp').value = '0';
    document.getElementById('hucre-modal-active-field').classList.add('hidden');
    document.getElementById('hucre-modal').classList.remove('hidden');
}

function editHucre(id, name, role, credits, xp, isActive) {
    document.getElementById('hucre-modal-title').textContent = 'Hücre Düzenle';
    document.getElementById('hucre-modal-id').value = id;
    document.getElementById('hucre-modal-name').value = name;
    document.getElementById('hucre-modal-role').value = role;
    document.getElementById('hucre-modal-credits').value = credits;
    document.getElementById('hucre-modal-xp').value = xp;
    document.getElementById('hucre-modal-is-active').checked = isActive;
    document.getElementById('hucre-modal-active-field').classList.remove('hidden');
    document.getElementById('hucre-modal').classList.remove('hidden');
}

function closeHucreModal() {
    document.getElementById('hucre-modal').classList.add('hidden');
}

async function saveHucre() {
    const id = document.getElementById('hucre-modal-id').value;
    const data = {
        name: document.getElementById('hucre-modal-name').value,
        role: document.getElementById('hucre-modal-role').value,
        credits: parseInt(document.getElementById('hucre-modal-credits').value) || 100,
        xp: parseInt(document.getElementById('hucre-modal-xp').value) || 0,
    };
    if (id) {
        data.is_active = document.getElementById('hucre-modal-is-active').checked;
    }
    const url = id ? `/sura/hucre/${id}` : '/sura/hucre';
    const method = id ? 'PUT' : 'POST';
    const res = await fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (res.ok && result.success) {
        alert(id ? 'Hücre güncellendi!' : 'Hücre eklendi!');
        location.reload();
    } else {
        const errorMsg = result.message || result.error || (result.errors && Object.values(result.errors).flat().join(', ')) || 'Bilinmeyen hata';
        alert('Hata: ' + errorMsg);
    }
}

async function deleteHucre(id, name) {
    if (!confirm(name + ' hücresini silmek istediğinize emin misiniz? Hücredeki takımlar hücresiz kalacak.')) return;
    const res = await fetch(`/sura/hucre/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    });
    const result = await res.json();
    if (result.success) {
        alert('Hücre silindi!');
        location.reload();
    } else {
        alert('Hata: ' + (result.error || 'Bilinmeyen hata'));
    }
}

function giveCreditsToHucre(hucreId, hucreName) {
    const amount = prompt(hucreName + ' hücresine kredi miktarı:');
    if (!amount) return;
    fetch('/sura/credits/give', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ hucre_id: hucreId, amount: parseInt(amount) }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            alert('Kredi verildi!');
            location.reload();
        } else {
            alert('Hata: ' + (data.error || 'Bilinmeyen hata'));
        }
    });
}
</script>
@endpush
@endsection
