@extends('layouts.sura')

@section('content')
<div class="min-h-screen bg-dark-900 pt-20">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-cinzel text-4xl font-bold text-amethyst-100 mb-2">📢 Duyurular</h1>
                <p class="text-parchment-300 text-sm">Tüm sistem duyuruları</p>
            </div>
            <div class="flex gap-3">
                <button onclick="openAnnouncementModal()" class="px-4 py-2 rounded-lg bg-amethyst-100 text-white font-semibold hover:bg-amethyst-200 transition-colors text-sm">
                    + Yeni Duyuru
                </button>
                <a href="{{ route('sura.dashboard') }}" class="px-4 py-2 rounded-lg bg-dark-800 border border-white/10 text-parchment-200 hover:bg-dark-700 transition-colors text-sm">
                    ← Dashboard
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
                        @if($announcement->team)
                        <span>Takım: <span class="text-parchment-200">{{ $announcement->team->name }}</span></span>
                        @endif
                        @if($announcement->viewer)
                        <span>İzleyici: <span class="text-parchment-200">{{ $announcement->viewer->name }}</span></span>
                        @endif
                        <span>{{ $announcement->created_at->format('d.m.Y H:i') }}</span>
                        <span>{{ $announcement->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <button type="button" onclick="deleteAnnouncement({{ $announcement->id }})" class="flex-shrink-0 px-3 py-1.5 rounded-lg bg-red-500/20 text-red-400 text-sm hover:bg-red-500/30 transition-colors" title="Duyuruyu sil">
                    Sil
                </button>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    </div>
</div>

@include('sura.modals.announcement')

@push('scripts')
<script>
function openAnnouncementModal() {
    document.getElementById('announcement-modal').classList.remove('hidden');
}

async function createAnnouncement() {
    const data = {
        message: document.getElementById('announcement-message').value,
        type: document.getElementById('announcement-type').value,
        team_id: document.getElementById('announcement-team-id').value || null,
        viewer_id: document.getElementById('announcement-viewer-id').value || null,
    };
    const res = await fetch('/sura/announcement', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (result.success) {
        alert('Duyuru oluşturuldu!');
        location.reload();
    } else {
        alert('Hata: ' + (result.error || 'Bilinmeyen hata'));
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

document.querySelectorAll('[data-modal-close]').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('[id$="-modal"]').forEach(m => m.classList.add('hidden'));
    });
});
</script>
@endpush
@endsection
