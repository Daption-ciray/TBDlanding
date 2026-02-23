<div id="announcement-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-800 rounded-xl p-6 border border-white/20 max-w-md w-full">
        <h3 class="font-cinzel text-xl font-bold text-amethyst-100 mb-4">📢 Duyuru Oluştur</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Mesaj</label>
                <textarea id="announcement-message" rows="3" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="Duyuru mesajı..."></textarea>
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Tip</label>
                <select id="announcement-type" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none">
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
            <div>
                <label class="block text-parchment-200 text-sm mb-2">Takım ID (opsiyonel)</label>
                <input type="number" id="announcement-team-id" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="Takım ID">
            </div>
            <div>
                <label class="block text-parchment-200 text-sm mb-2">İzleyici ID (opsiyonel)</label>
                <input type="number" id="announcement-viewer-id" class="w-full px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-100 focus:border-amethyst-100/50 focus:outline-none" placeholder="İzleyici ID">
            </div>
            <div class="flex gap-3">
                <button onclick="createAnnouncement()" class="flex-1 px-4 py-2 rounded-lg bg-amethyst-100 text-white font-semibold hover:bg-amethyst-200 transition-colors">
                    Oluştur
                </button>
                <button data-modal-close class="px-4 py-2 rounded-lg bg-dark-700 border border-white/10 text-parchment-200 hover:bg-dark-600 transition-colors">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>
