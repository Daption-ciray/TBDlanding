{{-- Wraith-style minimal footer --}}
<footer class="footer-wraith py-8 px-6 border-t border-white/10">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-parchment-400 text-xs">The Living Code © 2026 · TBD Istanbul</p>
        <a href="mailto:{{ config('livingcode.contact.email') }}" class="text-parchment-400 text-xs hover:text-gold-200 transition-colors">{{ config('livingcode.contact.email') }}</a>
    </div>
</footer>
