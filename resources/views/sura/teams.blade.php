@extends('layouts.sura')

@section('content')
<div class="min-h-screen bg-dark-900 pt-20">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-cinzel text-4xl font-bold text-amethyst-100 mb-2">🏆 Takımlar</h1>
                <p class="text-parchment-300 text-sm">
                    @if(request('role') === 'adem')
                        ADEM Hücresi takımları
                    @elseif(request('role') === 'baba')
                        BABA Hücresi takımları
                    @else
                        Tüm takımların listesi ve detayları
                    @endif
                </p>
            </div>
            <div class="flex gap-2">
                <button onclick="openTeamModal()" class="px-4 py-2 rounded-lg bg-amethyst-100 text-white text-sm font-semibold hover:bg-amethyst-200 transition-colors">+ Takım Ekle</button>
                <a href="{{ route('sura.hucreler') }}" class="px-4 py-2 rounded-lg bg-dark-800 border border-white/10 text-parchment-200 hover:bg-dark-700 transition-colors text-sm">📦 Hücreler</a>
                <a href="{{ route('sura.dashboard') }}" class="px-4 py-2 rounded-lg bg-dark-800 border border-white/10 text-parchment-200 hover:bg-dark-700 transition-colors text-sm">← Dashboard</a>
            </div>
        </div>

        <div class="bg-dark-800 rounded-xl border border-white/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-700 border-b border-white/10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Takım Adı</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Hücre (Rol)</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Hücre</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Destekçi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Rozet</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">Katılımcı</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-parchment-300 uppercase">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($teams as $team)
                        <tr class="hover:bg-dark-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono text-parchment-300">{{ $team->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-parchment-100">{{ $team->name }}</td>
                            <td class="px-6 py-4 text-sm text-parchment-300">{{ $team->role }}</td>
                            <td class="px-6 py-4 text-sm text-parchment-200">
                                @if($team->hucre)
                                    <a href="{{ route('sura.hucreler') }}" class="hover:text-amethyst-100">{{ $team->hucre->name }}</a>
                                @else
                                    <span class="text-parchment-400">Atanmamış</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gold-200 font-mono">{{ $team->supporter_count }}</td>
                            <td class="px-6 py-4 text-sm text-amethyst-100 font-mono">{{ $team->badges_count }}</td>
                            <td class="px-6 py-4 text-sm text-parchment-300 font-mono">{{ $team->participants_count }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-1">
                                    <button onclick="openTeamBadgeModal({{ $team->id }}, '{{ addslashes($team->name) }}')" class="px-2 py-1 rounded bg-gold-200/20 text-gold-200 text-xs hover:bg-gold-200/30 transition-colors" title="Rozet Ver">
                                        🏅
                                    </button>
                                    <button onclick="editTeam({{ $team->id }}, '{{ addslashes($team->name) }}', '{{ $team->role }}', {{ $team->hucre_id ?? 'null' }}, {{ $team->supporter_count }}, {{ $team->is_active ? 'true' : 'false' }})" class="px-2 py-1 rounded bg-blue-500/20 text-blue-400 text-xs hover:bg-blue-500/30 transition-colors" title="Düzenle">
                                        ✏️
                                    </button>
                                    <button onclick="deleteTeam({{ $team->id }}, '{{ addslashes($team->name) }}')" class="px-2 py-1 rounded bg-red-500/20 text-red-400 text-xs hover:bg-red-500/30 transition-colors" title="Sil">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/10">
                {{ $teams->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Takım Ekle/Düzenle Modal --}}
<div id="team-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-800 rounded-xl p-6 border border-white/20 max-w-md w-full">
        <h3 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4" id="team-modal-title">Takım Ekle</h3>
        <div class="space-y-4">
            <input type="hidden" id="team-modal-id" value="">
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Takım Adı *</label>
                <input type="text" id="team-modal-name" required class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="Takım adı">
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Rol *</label>
                <select id="team-modal-role" required class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none">
                    <option value="adem">ADEM</option>
                    <option value="baba">BABA</option>
                </select>
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Hücre</label>
                <select id="team-modal-hucre-id" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none">
                    <option value="">Hücre seçin (opsiyonel)</option>
                    @foreach($hucreler ?? [] as $h)
                    <option value="{{ $h->id }}" data-role="{{ $h->role }}">{{ $h->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Destekçi Sayısı</label>
                <input type="number" id="team-modal-supporter-count" min="0" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="0" value="0">
            </div>
            <div id="team-modal-active-field" class="hidden">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="team-modal-is-active" class="rounded bg-dark-700 border-white/10">
                    <span class="text-parchment-200 text-sm">Aktif</span>
                </label>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="saveTeam()" class="flex-1 px-4 py-2 rounded-lg bg-amethyst-100 text-white font-semibold hover:bg-amethyst-200 transition-colors">
                    Kaydet
                </button>
                <button type="button" onclick="closeTeamModal()" class="px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-200 hover:bg-dark-600 transition-colors">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Takıma Rozet Ver Modal --}}
<div id="team-badge-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-800 rounded-xl p-6 border border-white/20 max-w-sm w-full">
        <h3 class="font-cinzel text-lg font-bold text-amethyst-100 mb-2">🏅 Takıma Rozet Ver</h3>
        <p class="text-parchment-300 text-sm mb-4" id="team-badge-modal-team-name"></p>
        <input type="hidden" id="team-badge-modal-team-id" value="">
        <div class="space-y-4">
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Rozet</label>
                <select id="team-badge-select" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none">
                    @foreach($badges ?? [] as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="submitTeamBadge()" class="flex-1 px-4 py-2 rounded-lg bg-gold-200 text-black font-semibold hover:bg-gold-100 transition-colors">Ver</button>
                <button type="button" onclick="document.getElementById('team-badge-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-200 hover:bg-dark-600 transition-colors">İptal</button>
            </div>
        </div>
    </div>
</div>

<script>
function openTeamBadgeModal(teamId, teamName) {
    document.getElementById('team-badge-modal-team-id').value = teamId;
    document.getElementById('team-badge-modal-team-name').textContent = 'Takım: ' + teamName;
    document.getElementById('team-badge-modal').classList.remove('hidden');
}

async function submitTeamBadge() {
    const teamId = document.getElementById('team-badge-modal-team-id').value;
    const badgeId = document.getElementById('team-badge-select').value;
    const res = await fetch('/sura/badge/assign', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ badge_id: badgeId, team_id: teamId, viewer_id: null }),
    });
    const result = await res.json();
    if (result.success) {
        document.getElementById('team-badge-modal').classList.add('hidden');
        alert('Rozet verildi!');
        location.reload();
    } else {
        alert('Hata: ' + (result.message || result.error || 'Bilinmeyen hata'));
    }
}

function openTeamModal() {
    document.getElementById('team-modal-title').textContent = 'Takım Ekle';
    document.getElementById('team-modal-id').value = '';
    document.getElementById('team-modal-name').value = '';
    document.getElementById('team-modal-role').value = 'adem';
    document.getElementById('team-modal-hucre-id').value = '';
    document.getElementById('team-modal-supporter-count').value = '0';
    document.getElementById('team-modal-active-field').classList.add('hidden');
    document.getElementById('team-modal').classList.remove('hidden');
}

function editTeam(id, name, role, hucreId, supporterCount, isActive) {
    document.getElementById('team-modal-title').textContent = 'Takım Düzenle';
    document.getElementById('team-modal-id').value = id;
    document.getElementById('team-modal-name').value = name;
    document.getElementById('team-modal-role').value = role;
    document.getElementById('team-modal-hucre-id').value = hucreId || '';
    document.getElementById('team-modal-supporter-count').value = supporterCount;
    document.getElementById('team-modal-is-active').checked = isActive;
    document.getElementById('team-modal-active-field').classList.remove('hidden');
    document.getElementById('team-modal').classList.remove('hidden');
    filterHucrelerByRole(role);
}

function closeTeamModal() {
    document.getElementById('team-modal').classList.add('hidden');
}

function filterHucrelerByRole(role) {
    const select = document.getElementById('team-modal-hucre-id');
    Array.from(select.options).forEach(opt => {
        if (opt.value === '' || opt.dataset.role === role) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
        }
    });
}

document.getElementById('team-modal-role').addEventListener('change', function() {
    filterHucrelerByRole(this.value);
});

async function saveTeam() {
    const id = document.getElementById('team-modal-id').value;
    const data = {
        name: document.getElementById('team-modal-name').value,
        role: document.getElementById('team-modal-role').value,
        hucre_id: document.getElementById('team-modal-hucre-id').value || null,
        supporter_count: parseInt(document.getElementById('team-modal-supporter-count').value) || 0,
    };
    if (id) {
        data.is_active = document.getElementById('team-modal-is-active').checked;
    }
    const url = id ? `/sura/team/${id}` : '/sura/team';
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
        alert(id ? 'Takım güncellendi!' : 'Takım eklendi!');
        location.reload();
    } else {
        const errorMsg = result.message || result.error || (result.errors && Object.values(result.errors).flat().join(', ')) || 'Bilinmeyen hata';
        alert('Hata: ' + errorMsg);
    }
}

async function deleteTeam(id, name) {
    if (!confirm(name + ' takımını silmek istediğinize emin misiniz?')) return;
    const res = await fetch(`/sura/team/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    });
    const result = await res.json();
    if (result.success) {
        alert('Takım silindi!');
        location.reload();
    } else {
        alert('Hata: ' + (result.error || 'Bilinmeyen hata'));
    }
}

}
</script>
@endsection
