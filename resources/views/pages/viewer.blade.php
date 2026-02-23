@extends('layouts.app')

@section('content')
<section class="min-h-[40vh] flex items-center justify-center px-6 py-16 bg-dark-900 border-b border-white/10">
    <div class="text-center">
        <span class="section-voice-label text-amethyst-200/90 text-xs font-mono tracking-widest uppercase block mb-2">İzleyici Portalı</span>
        <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-parchment-100 mb-2">Evreni İzle, XP Kazan</h1>
        <p class="text-parchment-400 text-sm max-w-xl mx-auto">Kayıt ol, izle, görev tamamla, rozet topla.</p>
        <a href="{{ route('welcome') }}" class="inline-block mt-6 text-gold-200 hover:text-gold-100 text-sm font-medium">← Ana sayfaya dön</a>
    </div>
</section>

{{-- İzleyici Kayıt + Profil --}}
<section class="py-16 sm:py-24 px-6 relative bg-dark-800/50">
    <div class="max-w-5xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Registration / Profile --}}
            <div class="lg:col-span-1 reveal">
                <div class="viewer-profile-card rounded-2xl p-6 border border-amethyst-100/15 bg-amethyst-300/5" id="viewer-card">
                    <div id="viewer-register-form">
                        <h3 class="font-cinzel font-bold text-amethyst-100 text-lg mb-4">Evrene Katıl</h3>
                        <p class="text-parchment-200 text-sm mb-4">İzleyici olarak kayıt ol veya e-postanla giriş yap.</p>
                        <div class="space-y-3">
                            <input type="text" id="viewer-name" required placeholder="İsmin *" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm placeholder-parchment-300/50 focus:border-amethyst-100/40 focus:outline-none transition-colors">
                            <input type="email" id="viewer-email" required placeholder="E-posta *" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm placeholder-parchment-300/50 focus:border-amethyst-100/40 focus:outline-none transition-colors">
                            <button id="viewer-register-btn" class="w-full px-4 py-2.5 rounded-lg bg-amethyst-100 text-white text-sm font-semibold hover:bg-amethyst-200 transition-colors">
                                Kayıt Ol
                            </button>
                        </div>
                        <p class="text-parchment-400 text-[0.65rem] mt-2 text-center" id="viewer-register-error"></p>
                        <div class="mt-4 pt-4 border-t border-white/10">
                            <p class="text-parchment-300 text-xs mb-2">Zaten kayıtlı mısın?</p>
                            <div class="flex gap-2">
                                <input type="email" id="viewer-login-email" placeholder="E-posta" class="flex-1 px-4 py-2 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm placeholder-parchment-300/50 focus:border-amethyst-100/40 focus:outline-none">
                                <button type="button" id="viewer-login-btn" class="px-4 py-2 rounded-lg bg-white/10 text-parchment-200 text-sm font-medium hover:bg-white/15 transition-colors">Giriş Yap</button>
                            </div>
                            <p class="text-parchment-400 text-[0.65rem] mt-1 text-center" id="viewer-login-error"></p>
                        </div>
                    </div>

                    <div id="viewer-profile" class="hidden">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-amethyst-300/30 border-2 border-amethyst-100/40 flex items-center justify-center text-2xl mx-auto mb-2">👁️</div>
                            <h3 class="font-cinzel font-bold text-amethyst-100 text-lg" id="viewer-display-name"></h3>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            <div class="text-center p-2 rounded-lg bg-white/5">
                                <span class="font-mono font-bold text-amethyst-100 text-lg block" id="viewer-xp-display">0</span>
                                <span class="text-parchment-300 text-[0.6rem]">XP</span>
                            </div>
                            <div class="text-center p-2 rounded-lg bg-white/5">
                                <span class="font-mono font-bold text-amethyst-100 text-lg block" id="viewer-minutes-display">0</span>
                                <span class="text-parchment-300 text-[0.6rem]">Dakika</span>
                            </div>
                            <div class="text-center p-2 rounded-lg bg-white/5">
                                <span class="font-mono font-bold text-amethyst-100 text-lg block" id="viewer-streak-display">0</span>
                                <span class="text-parchment-300 text-[0.6rem]">Seri</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 p-3 rounded-lg bg-green-500/10 border border-green-500/15 mb-3">
                            <span class="live-pulse w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                            <span class="text-green-400 text-xs">İzleme aktif — XP kazanıyorsun</span>
                        </div>
                        <button type="button" id="viewer-logout-btn" class="w-full py-1.5 text-parchment-400 hover:text-parchment-200 text-xs transition-colors">Farklı hesapla giriş yap</button>
                    </div>
                </div>
            </div>

            {{-- Sosyal Paylaşım + Leaderboard --}}
            <div class="lg:col-span-2 space-y-6 reveal">
                <div class="rounded-2xl p-6 border border-white/10 bg-white/[0.03]">
                    <h3 class="font-cinzel font-bold text-parchment-100 text-lg mb-3">📢 Sosyal Medya Paylaşımı</h3>
                    <p class="text-parchment-200 text-sm mb-4">Paylaşarak XP kazan! Kanıt fotoğrafı yükle; şura onayından sonra XP hesabına eklenir.</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="social-share-btns">
                        <button type="button" class="social-share-btn flex items-center justify-center gap-2 px-4 py-3 rounded-lg border border-blue-400/20 bg-blue-500/10 text-blue-400 text-sm hover:bg-blue-500/20 transition-colors" data-platform="twitter" data-points="15">𝕏 <span class="text-xs">+15 XP</span></button>
                        <button type="button" class="social-share-btn flex items-center justify-center gap-2 px-4 py-3 rounded-lg border border-pink-400/20 bg-pink-500/10 text-pink-400 text-sm hover:bg-pink-500/20 transition-colors" data-platform="instagram" data-points="20">📷 <span class="text-xs">+20 XP</span></button>
                        <button type="button" class="social-share-btn flex items-center justify-center gap-2 px-4 py-3 rounded-lg border border-blue-600/20 bg-blue-700/10 text-blue-300 text-sm hover:bg-blue-700/20 transition-colors" data-platform="linkedin" data-points="25">💼 <span class="text-xs">+25 XP</span></button>
                        <button type="button" class="social-share-btn flex items-center justify-center gap-2 px-4 py-3 rounded-lg border border-white/10 bg-white/5 text-parchment-200 text-sm hover:bg-white/10 transition-colors" data-platform="tiktok" data-points="20">🎵 <span class="text-xs">+20 XP</span></button>
                    </div>
                </div>

                {{-- XP talep modalı (kanıt fotoğrafı) --}}
                <div id="viewer-claim-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70">
                    <div class="bg-dark-800 rounded-2xl p-6 border border-amethyst-100/20 max-w-md w-full shadow-xl">
                        <h3 class="font-cinzel font-bold text-amethyst-100 text-lg mb-2">XP talebi — <span id="viewer-claim-platform-label">Sosyal paylaşım</span></h3>
                        <p class="text-parchment-400 text-xs mb-4">Paylaşımını kanıtlayan bir ekran görüntüsü veya fotoğraf yükle. Şura ekibi onayladıktan sonra XP eklenecek.</p>
                        <form id="viewer-claim-form">
                            <input type="hidden" id="viewer-claim-platform" name="platform" value="">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-parchment-200 text-sm mb-1">Paylaşım linki (opsiyonel)</label>
                                    <input type="url" id="viewer-claim-share-url" name="share_url" placeholder="https://..." class="w-full px-4 py-2 rounded-lg bg-white/5 border border-white/10 text-parchment-100 text-sm placeholder-parchment-300/50 focus:border-amethyst-100/40 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-parchment-200 text-sm mb-1">Kanıt fotoğrafı <span class="text-red-400">*</span></label>
                                    <input type="file" id="viewer-claim-proof" name="proof" accept="image/jpeg,image/png,image/webp" required class="w-full text-parchment-300 text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amethyst-100 file:text-white file:text-sm file:font-semibold">
                                </div>
                                <p class="text-parchment-400 text-[0.65rem]" id="viewer-claim-error"></p>
                                <div class="flex gap-3">
                                    <button type="submit" id="viewer-claim-submit" class="flex-1 px-4 py-2.5 rounded-lg bg-amethyst-100 text-white text-sm font-semibold hover:bg-amethyst-200 transition-colors">Gönder</button>
                                    <button type="button" id="viewer-claim-cancel" class="px-4 py-2.5 rounded-lg bg-white/10 text-parchment-200 text-sm hover:bg-white/15 transition-colors">İptal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="rounded-2xl p-6 border border-white/10 bg-white/[0.03]">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-cinzel font-bold text-parchment-100 text-lg">👁️ İzleyici sıralaması</h3>
                        <span class="text-parchment-400 text-xs">İzleme süresi · Canlı</span>
                    </div>
                    <div class="space-y-2" id="viewer-mini-leaderboard">
                        @forelse(($topViewers ?? []) as $i => $v)
                        <div class="flex items-center gap-3 p-2 rounded-lg {{ $i === 0 ? 'bg-amethyst-300/10' : '' }}">
                            <span class="text-xs text-parchment-300 w-5 text-center font-mono">{{ $i + 1 }}</span>
                            <span class="flex-1 text-parchment-100 text-sm truncate">{{ $v['name'] ?? '' }}</span>
                            <span class="text-amethyst-100 text-xs font-mono">{{ $v['watch_minutes'] ?? 0 }} dk</span>
                        </div>
                        @empty
                        <p class="text-parchment-300 text-sm text-center py-4">Henüz izleyici verisi yok.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
