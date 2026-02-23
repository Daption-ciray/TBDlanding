<div id="credits-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-800 rounded-xl p-6 border border-white/20 max-w-md w-full">
        <h3 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4">💰 Hücreye Kredi Ver</h3>
        <p class="text-parchment-400 text-xs mb-4">Kredi ve XP hücrenin ortak kasasına eklenir (2 takım paylaşır).</p>
        <div class="space-y-4">
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Hücre ID</label>
                <input type="number" id="credits-hucre-id" required class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="Hücre ID">
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Miktar</label>
                <input type="number" id="credits-amount" required min="1" max="1000" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="Kredi miktarı">
            </div>
            <div class="flex gap-3">
                <button onclick="giveCredits()" class="flex-1 px-4 py-2 rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 font-semibold hover:bg-green-500/30 transition-colors">
                    Ver
                </button>
                <button data-modal-close class="px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-200 hover:bg-dark-600 transition-colors">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>
