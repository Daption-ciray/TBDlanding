@extends('layouts.sura')

@section('content')
<div class="min-h-screen bg-dark-900 pt-20">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-cinzel text-4xl font-bold text-amethyst-100 mb-2">👁️ İzleyici Duyuruları</h1>
                <p class="text-parchment-300 text-sm">İzleyicilere ait duyurular — mesaj ve tip düzenlenebilir</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('sura.dashboard') }}" class="px-4 py-2 rounded-lg bg-dark-800 border border-white/10 text-parchment-200 hover:bg-dark-700 transition-colors text-sm">
                    ← Dashboard
                </a>
                <a href="{{ route('sura.announcements') }}" class="px-4 py-2 rounded-lg bg-white/10 text-parchment-200 hover:bg-white/15 transition-colors text-sm">
                    Tüm Duyurular
                </a>
            </div>
        </div>

        <div class="space-y-3">
            @foreach($announcements as $announcement)
            <div class="bg-dark-800 rounded-xl p-4 border border-white/10 flex items-start gap-4 group">
                <div class="text-2xl">{{ $announcement->icon }}</div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-parchment-100 font-medium">{{ $announcement->message }}</span>
                        <span class="px-2 py-0.5 rounded text-xs bg-dark-700 text-parchment-300">{{ $announcement->type }}</span>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-parchment-400">
                        @if($announcement->viewer)
                        <span>İzleyici: <span class="text-parchment-200">{{ $announcement->viewer->name }}</span> ({{ $announcement->viewer->email }})</span>
                        @endif
                        <span>{{ $announcement->created_at->format('d.m.Y H:i') }}</span>
                        <span>{{ $announcement->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <button type="button" onclick="openEditModal({{ $announcement->id }}, {{ json_encode($announcement->message) }}, '{{ $announcement->type }}')" class="px-3 py-1.5 rounded-lg bg-amethyst-100/20 text-amethyst-100 text-sm hover:bg-amethyst-100/30 transition-colors" title="Düzenle">
                        Düzenle
                    </button>
                    <button type="button" onclick="deleteAnnouncement({{ $announcement->id }})" class="px-3 py-1.5 rounded-lg bg-red-500/20 text-red-400 text-sm hover:bg-red-500/30 transition-colors" title="Sil">
                        Sil
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    </div>
</div>

{{-- Düzenle modalı --}}
<div id="viewer-announcement-edit-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-800 rounded-xl p-6 border border-white/20 max-w-md w-full">
        <h3 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4">✏️ Duyuruyu Düzenle</h3>
        <input type="hidden" id="edit-announcement-id" value="">
        <div class="space-y-4">
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Mesaj</label>
                <textarea id="edit-announcement-message" rows="3" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="Duyuru mesajı..."></textarea>
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Tip</label>
                <select id="edit-announcement-type" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none">
                    <option value="system">Sistem</option>
                    <option value="level_up">Seviye Atlama</option>
                    <option value="badge_earned">Rozet Kazanma</option>
                    <option value="quest_complete">Görev Tamamlama</option>
                    <option value="card_used">Kart Kullanımı</option>
                    <option value="tester_called">Test Çağrısı</option>
                    <option value="trade_complete">Takas Tamamlandı</option>
                    <option value="social_share">Sosyal Paylaşım</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="saveEditAnnouncement()" class="flex-1 px-4 py-2 rounded-lg bg-amethyst-100 text-white font-semibold hover:bg-amethyst-200 transition-colors">
                    Kaydet
                </button>
                <button type="button" onclick="document.getElementById('viewer-announcement-edit-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-200 hover:bg-dark-600 transition-colors">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openEditModal(id, message, type) {
    document.getElementById('edit-announcement-id').value = id;
    document.getElementById('edit-announcement-message').value = message || '';
    document.getElementById('edit-announcement-type').value = type || 'system';
    document.getElementById('viewer-announcement-edit-modal').classList.remove('hidden');
}

async function saveEditAnnouncement() {
    const id = document.getElementById('edit-announcement-id').value;
    const message = document.getElementById('edit-announcement-message').value.trim();
    const type = document.getElementById('edit-announcement-type').value;
    if (!message) {
        alert('Mesaj boş olamaz.');
        return;
    }
    const res = await fetch('/sura/announcement/' + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ message, type }),
    });
    const result = await res.json();
    if (result.success) {
        document.getElementById('viewer-announcement-edit-modal').classList.add('hidden');
        location.reload();
    } else {
        alert('Hata: ' + (result.error || 'Kaydedilemedi'));
    }
}

async function deleteAnnouncement(id) {
    if (!confirm('Bu duyuruyu silmek istediğinize emin misiniz?')) return;
    const res = await fetch('/sura/announcement/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
</script>
@endpush
@endsection
