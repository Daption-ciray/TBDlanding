{{-- Mentor & Test Ekibi --}}
<section id="mentor-tester" class="section-hucre py-16 sm:py-24 px-6 relative bg-dark-900">
    <div class="max-w-5xl mx-auto">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Destek</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Mentor & Test Ekibi
        </h2>
        <p class="text-parchment-400 text-sm mb-10 reveal">Mentor desteği al, oyununu test ettir. Takımını seçip şifreyle talepte bulun.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Mentor Request --}}
            <div class="reveal">
                <div class="info-card rounded-2xl p-7">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-12 h-12 rounded-xl bg-gold-400 border border-gold-300/30 flex items-center justify-center text-2xl">🧙</div>
                        <div>
                            <h3 class="font-cinzel text-gold-100 text-xl font-bold">Mentor Desteği</h3>
                            <span class="text-parchment-300 text-xs">Ücretsiz — Faz bazlı</span>
                        </div>
                    </div>
                    <p class="text-parchment-200 text-sm leading-relaxed mb-5">
                        Takımın bir konuda desteğe ihtiyaç duyarsa, alanında uzman bir mentordan yardım talep edebilirsin.
                    </p>

                    <div class="space-y-3 mb-5">
                        <label class="block text-parchment-300 text-xs">Takım Adı *</label>
                        <select id="mentor-team-id" required class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm focus:border-gold-200/40 focus:outline-none transition-colors">
                            <option value="" class="bg-dark-800">Takım seçin</option>
                            @foreach ($teamsForSelect ?? [] as $t)
                            <option value="{{ $t->id }}" class="bg-dark-800">{{ $t->name }}</option>
                            @endforeach
                        </select>
                        <label class="block text-parchment-300 text-xs">Takım şifresi *</label>
                        <input type="password" id="mentor-team-password" required placeholder="Takım şifresi" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm placeholder-parchment-300/50 focus:border-gold-200/40 focus:outline-none transition-colors" autocomplete="off">
                        <label class="block text-parchment-300 text-xs">Konu</label>
                        <select id="mentor-topic" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm focus:border-gold-200/40 focus:outline-none transition-colors">
                            <option value="" class="bg-dark-800">Konu Seçin</option>
                            @foreach (config('livingcode.gamification.mentor_topics', []) as $key => $label)
                            <option value="{{ $key }}" class="bg-dark-800">{{ $label }}</option>
                            @endforeach
                        </select>
                        <textarea id="mentor-details" rows="2" placeholder="Detay (opsiyonel)" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm placeholder-parchment-300/50 focus:border-gold-200/40 focus:outline-none transition-colors resize-none"></textarea>
                        <button id="mentor-request-btn" class="w-full px-4 py-2.5 rounded-lg bg-gold-200 text-black text-sm font-semibold hover:bg-gold-100 transition-colors">
                            Mentor Talep Et
                        </button>
                    </div>

                    <div id="mentor-status-list" class="space-y-2">
                        {{-- Filled by JS --}}
                    </div>
                </div>
            </div>

            {{-- Tester Request --}}
            <div class="reveal reveal-delay-1">
                <div class="info-card rounded-2xl p-7">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-12 h-12 rounded-xl bg-amethyst-300 border border-amethyst-100/30 flex items-center justify-center text-2xl">🧪</div>
                        <div>
                            <h3 class="font-cinzel text-amethyst-100 text-xl font-bold">Test Ekibi</h3>
                            <span class="text-parchment-300 text-xs">
                                Maliyet: <span class="text-amethyst-100 font-mono">{{ config('livingcode.gamification.tester_credit_cost', 50) }} Kredi</span>
                            </span>
                        </div>
                    </div>
                    <p class="text-parchment-200 text-sm leading-relaxed mb-5">
                        Kredi harcayarak test ekibini çağır. Oyununu profesyonel test ekibi dener ve geri bildirim verir.
                    </p>

                    <div class="space-y-3 mb-5">
                        <label class="block text-parchment-300 text-xs">Takım Adı *</label>
                        <select id="tester-team-id" required class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm focus:border-amethyst-100/40 focus:outline-none transition-colors">
                            <option value="" class="bg-dark-800">Takım seçin</option>
                            @foreach ($teamsForSelect ?? [] as $t)
                            <option value="{{ $t->id }}" class="bg-dark-800">{{ $t->name }}</option>
                            @endforeach
                        </select>
                        <label class="block text-parchment-300 text-xs">Takım şifresi *</label>
                        <input type="password" id="tester-team-password" required placeholder="Takım şifresi" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm placeholder-parchment-300/50 focus:border-amethyst-100/40 focus:outline-none transition-colors" autocomplete="off">
                    </div>

                    <div class="p-4 rounded-xl bg-amethyst-300/10 border border-amethyst-100/15 mb-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-parchment-200 text-sm">Kredi Maliyeti</span>
                            <span class="text-amethyst-100 font-mono font-bold">{{ config('livingcode.gamification.tester_credit_cost', 50) }} Kredi</span>
                        </div>
                        <p class="text-parchment-300 text-xs">Test ekibi oyununuzu dener ve detaylı geri bildirim sağlar.</p>
                    </div>

                    <button id="tester-request-btn" class="w-full px-4 py-2.5 rounded-lg bg-amethyst-100 text-white text-sm font-semibold hover:bg-amethyst-200 transition-colors">
                        Test Ekibini Çağır
                    </button>

                    <div id="tester-status-list" class="space-y-2 mt-5">
                        {{-- Filled by JS --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
