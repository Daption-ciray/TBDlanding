<div id="badge-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-800 rounded-xl p-6 border border-white/20 max-w-md w-full">
        <h3 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4">🏅 Rozet Ver</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Rozet</label>
                <select id="badge-select" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none">
                    @foreach($badges ?? [] as $badge)
                    <option value="{{ $badge->id }}">{{ $badge->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Takım ID (opsiyonel)</label>
                <input type="number" id="badge-team-id" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="Takım ID">
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">İzleyici ID (opsiyonel)</label>
                <input type="number" id="badge-viewer-id" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="İzleyici ID">
            </div>
            <div class="flex gap-3">
                <button onclick="assignBadge()" class="flex-1 px-4 py-2 rounded-lg bg-gold-200 text-black font-semibold hover:bg-gold-100 transition-colors">
                    Ver
                </button>
                <button data-modal-close class="px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-200 hover:bg-dark-600 transition-colors">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>
