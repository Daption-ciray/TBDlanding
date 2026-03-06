@php
    $currentRoute = request()->route()?->getName();
@endphp
<nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 py-3" role="navigation" aria-label="Ana navigasyon">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a href="{{ $currentRoute === 'welcome' ? route('role-select') : route('welcome') }}" class="flex items-center gap-2.5 group" aria-label="TBD Istanbul Ana Sayfa">
            <img src="/images/tbd_logo.png" alt="TBD Logo" class="w-9 h-9 rounded-full ring-1 ring-gold-300/30 group-hover:ring-gold-200/50 transition-all" loading="lazy" width="36" height="36">
            <div class="hidden sm:block">
                <span class="font-cinzel text-gold-200 font-bold text-sm block leading-none">TBD</span>
                <span class="text-parchment-300 text-[0.6rem] tracking-wider">ISTANBUL</span>
            </div>
        </a>

        <div class="hidden md:flex items-center gap-8" role="menubar">
            <a href="{{ route('welcome') }}" class="nav-link {{ $currentRoute === 'welcome' ? 'text-gold-200' : 'text-parchment-200 hover:text-gold-200' }} focus:outline-none focus:ring-2 focus:ring-gold-300 focus:ring-offset-2 focus:ring-offset-dark-900 rounded" role="menuitem" @if($currentRoute === 'welcome') aria-current="page" @endif>Tanıtım</a>
            <a href="{{ route('welcome') }}#sss" class="nav-link text-parchment-200 hover:text-gold-200 focus:outline-none focus:ring-2 focus:ring-gold-300 focus:ring-offset-2 focus:ring-offset-dark-900 rounded" role="menuitem">SSS</a>
        </div>

        <div class="flex items-center gap-3">
            @if($currentRoute === 'welcome')
            <a href="{{ route('role-select') }}" class="text-parchment-400 hover:text-gold-200 text-xs hidden sm:inline-block focus:outline-none focus:ring-2 focus:ring-gold-300 rounded">Tarafı değiştir</a>
            @endif
            
            <button id="theme-toggle" class="p-2 rounded-lg bg-white/5 border border-white/10 text-parchment-300 hover:text-gold-200 focus:outline-none transition-all" aria-label="Temayı Değiştir">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
            </button>

            <a href="https://docs.google.com/forms/d/1K4EvhIRr2e64HHnLS5evHZBKUiDQwjR1FaAGcZecm4Y/viewform" target="_blank" class="btn-gold px-5 py-2 rounded-lg text-xs hidden sm:inline-block focus:outline-none focus:ring-2 focus:ring-gold-300">Takımla Başvur</a>
            <button id="mobile-toggle" class="md:hidden text-parchment-200 hover:text-gold-200 p-2 min-w-[44px] min-h-[44px] flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-gold-300 rounded" aria-label="Menüyü aç/kapat" aria-expanded="false" aria-controls="mobile-menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="mobile-menu md:hidden" role="menu" aria-label="Mobil menü">
        <div class="py-4 px-6 flex flex-col gap-3 border- Aquat-300/10 mt-3">
            <a href="{{ route('welcome') }}" class="text-parchment-200 hover:text-gold-200 text-sm py-2 min-h-[44px] flex items-center focus:outline-none focus:ring-2 focus:ring-gold-300 rounded" role="menuitem">Tanıtım</a>
            <a href="{{ route('welcome') }}#sss" class="text-parchment-200 hover:text-gold-200 text-sm py-2 min-h-[44px] flex items-center focus:outline-none focus:ring-2 focus:ring-gold-300 rounded" role="menuitem">SSS</a>
            @if($currentRoute === 'welcome')<a href="{{ route('role-select') }}" class="text-parchment-400 hover:text-gold-200 text-sm py-2 min-h-[44px] flex items-center focus:outline-none focus:ring-2 focus:ring-gold-300 rounded" role="menuitem">Tarafı değiştir</a>@endif
            <a href="#" class="btn-gold px-5 py-2.5 rounded-lg text-xs text-center mt-2 min-h-[44px] flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-gold-300" role="menuitem">Takımla Başvur</a>
        </div>
    </div>
</nav>
