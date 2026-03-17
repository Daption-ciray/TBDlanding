/* ===== TBD - The Living Code 2026 - Main JavaScript v3 (Gamified) ===== */

document.addEventListener('DOMContentLoaded', () => {
    initCountdown();
    initRevealAnimations();
    initNavbar();
    initFAQ();
    initMobileMenu();
    initStatCounters();
    initTopbarClose();

    initLeaderboard();
    initLiveFeed();
    initQuestBoard();
    initBadgeGallery();
    initCardMarket();
    initViewerZone();

    initHeroGamification();
});

/* ===== Countdown Timer ===== */
function initCountdown() {
    const hero = document.getElementById('hero');
    const targetStr = hero && hero.dataset.countdown ? hero.dataset.countdown : '2026-04-03T09:00:00+03:00';
    const targetDate = new Date(targetStr).getTime();

    function update() {
        const now = Date.now();
        const diff = targetDate - now;

        if (diff <= 0) {
            setVal('countdown-days', '0');
            setVal('countdown-hours', '00');
            setVal('countdown-minutes', '00');
            setVal('countdown-seconds', '00');
            return;
        }

        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        setVal('countdown-days', d);
        setVal('countdown-hours', String(h).padStart(2, '0'));
        setVal('countdown-minutes', String(m).padStart(2, '0'));
        setVal('countdown-seconds', String(s).padStart(2, '0'));
    }

    function setVal(id, val) {
        const el = document.getElementById(id);
        if (el && el.textContent !== String(val)) {
            el.textContent = val;
            el.style.transform = 'scale(1.1)';
            setTimeout(() => { el.style.transition = 'transform 0.3s ease'; el.style.transform = 'scale(1)'; }, 50);
        }
    }

    update();
    setInterval(update, 1000);
}

/* ===== Scroll Reveal Animations ===== */
function initRevealAnimations() {
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
}

/* ===== Navbar ===== */
function initNavbar() {
    const nav = document.getElementById('navbar');
    if (!nav) return;

    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                nav.classList.toggle('scrolled', window.scrollY > 50);
                ticking = false;
            });
            ticking = true;
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const top = target.getBoundingClientRect().top + window.pageYOffset - 80;
                window.scrollTo({ top, behavior: 'smooth' });
                const mm = document.getElementById('mobile-menu');
                if (mm) mm.classList.remove('open');
            }
        });
    });
}

/* ===== FAQ ===== */
function initFAQ() {
    document.querySelectorAll('.faq-question').forEach(q => {
        q.addEventListener('click', () => {
            const item = q.closest('.faq-item');
            const wasActive = item.classList.contains('active');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
            if (!wasActive) item.classList.add('active');
        });
    });
}

/* ===== Topbar close ===== */
function initTopbarClose() {
    const topbar = document.getElementById('topbar');
    const closeBtn = document.getElementById('topbar-close');
    if (!topbar || !closeBtn) return;

    const key = 'livingcode_topbar_closed';
    if (localStorage.getItem(key) === '1') {
        topbar.classList.add('hidden');
        document.body.classList.remove('has-topbar');
    } else {
        document.body.classList.add('has-topbar');
    }

    closeBtn.addEventListener('click', () => {
        topbar.classList.add('hidden');
        document.body.classList.remove('has-topbar');
        try { localStorage.setItem(key, '1'); } catch (e) {}
    });
}

function initMobileMenu() {
    const btn = document.getElementById('mobile-toggle');
    const menu = document.getElementById('mobile-menu');
    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
        menu.classList.toggle('open');
        const svg = btn.querySelector('svg');
        svg.innerHTML = menu.classList.contains('open')
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
    });

    menu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => menu.classList.remove('open'));
    });
}

/* ===== Stat Counter Animation ===== */
function initStatCounters() {
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                animateCounter(e.target);
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-count]').forEach(el => obs.observe(el));
}

function animateCounter(el) {
    const target = parseInt(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    const duration = 1500;
    const start = performance.now();

    function step(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(target * eased) + suffix;
        if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
}

/* ===== API Helper ===== */
const API_BASE = '/api';

async function apiFetch(endpoint, options = {}) {
    try {
        const res = await fetch(API_BASE + endpoint, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            ...options,
        });
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            const msg = err.message || err.error || (err.errors && Object.values(err.errors)[0]?.[0]) || 'Bir hata oluştu.';
            return { error: msg, status: res.status };
        }
        return await res.json();
    } catch (e) {
        return { error: 'Bağlantı hatası.' };
    }
}

/* ===== Leaderboard ===== */
function initLeaderboard() {
    const tabs = document.querySelectorAll('.lb-tab');
    const panels = document.querySelectorAll('.lb-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            const panelId = 'lb-' + tab.dataset.tab;
            const panel = document.getElementById(panelId);
            if (panel) panel.classList.add('active');
        });
    });

    async function refreshLeaderboard() {
        const activeTab = document.querySelector('.lb-tab.active');
        if (!activeTab) return;
        const type = activeTab.dataset.tab;

        const typeMap = { teams: 'teams', participants: 'participants', viewers: 'viewers' };
        const apiType = typeMap[type] || 'teams';

        const data = await apiFetch('/leaderboard/' + apiType);
        if (data.error || !data.data) return;

        const list = document.getElementById('lb-' + type + '-list');
        if (!list || data.data.length === 0) return;

        list.innerHTML = data.data.map((item, i) => {
            if (type === 'teams') {
                return buildTeamRow(item, i);
            } else if (type === 'participants') {
                return buildParticipantRow(item, i);
            } else {
                return buildViewerRow(item, i);
            }
        }).join('');
    }

    setInterval(refreshLeaderboard, 30000);
}

function buildTeamRow(t, i) {
    const roleColor = t.role === 'kasif' ? 'text-gold-200' : 'text-amethyst-100';
    const roleBg = t.role === 'kasif' ? 'bg-gold-400 text-gold-200' : 'bg-amethyst-300 text-amethyst-100';
    const topClass = i < 3 ? 'leaderboard-top-' + (i + 1) : '';
    const rankBg = i === 0 ? 'bg-gold-400 text-gold-200' : (i === 1 ? 'bg-parchment-300/20 text-parchment-200' : (i === 2 ? 'bg-amber-900/30 text-amber-400' : 'bg-white/5 text-parchment-300'));

    return `<div class="leaderboard-row flex items-center gap-4 p-4 rounded-xl border border-white/10 bg-white/[0.03] hover:border-gold-200/20 transition-all ${topClass}">
        <div class="rank-badge w-10 h-10 rounded-full flex items-center justify-center font-cinzel font-bold text-sm ${rankBg}">${i + 1}</div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
                <span class="font-cinzel font-bold text-parchment-100 truncate">${escHtml(t.name)}</span>
                <span class="px-2 py-0.5 rounded text-[0.6rem] font-mono ${roleBg}">${t.role.toUpperCase()}</span>
            </div>
            <div class="flex items-center gap-3 mt-1 text-xs text-parchment-300">
                <span>${t.badge_count || 0} rozet</span><span>${t.supporter_count || 0} destekçi</span>
            </div>
        </div>
        <div class="text-right">
            <span class="font-mono font-bold text-lg ${roleColor}">${Number(t.supporter_count || 0).toLocaleString()}</span>
            <span class="text-parchment-300 text-xs block">Destekçi</span>
        </div>
    </div>`;
}

function buildParticipantRow(p, i) {
    const rankBg = i === 0 ? 'bg-gold-400 text-gold-200' : 'bg-white/5 text-parchment-300';
    return `<div class="leaderboard-row flex items-center gap-4 p-4 rounded-xl border border-white/10 bg-white/[0.03] transition-all">
        <div class="rank-badge w-10 h-10 rounded-full flex items-center justify-center font-cinzel font-bold text-sm ${rankBg}">${i + 1}</div>
        <div class="flex-1 min-w-0">
            <span class="font-cinzel font-bold text-parchment-100 truncate block">${escHtml(p.name)}</span>
            <span class="text-parchment-300 text-xs">${escHtml(p.team_name || '')}</span>
        </div>
        <div class="text-right">
            <span class="text-parchment-300 text-xs">${escHtml(p.role_in_team || '')}</span>
        </div>
    </div>`;
}

function buildViewerRow(v, i) {
    const rankBg = i === 0 ? 'bg-amethyst-300 text-amethyst-100' : 'bg-white/5 text-parchment-300';
    return `<div class="leaderboard-row flex items-center gap-4 p-4 rounded-xl border border-white/10 bg-white/[0.03] transition-all">
        <div class="rank-badge w-10 h-10 rounded-full flex items-center justify-center font-cinzel font-bold text-sm ${rankBg}">${i + 1}</div>
        <div class="flex-1 min-w-0">
            <span class="font-cinzel font-bold text-parchment-100 truncate block">${escHtml(v.name)}</span>
            <span class="text-parchment-300 text-xs">${v.watch_minutes || 0} dk izleme</span>
        </div>
        <div class="text-right">
            <span class="font-mono font-bold text-lg text-amethyst-100">${Number(v.xp).toLocaleString()}</span>
            <span class="text-parchment-300 text-xs block">XP</span>
        </div>
    </div>`;
}

/* ===== Live Feed ===== */
function initLiveFeed() {
    const feedList = document.getElementById('feed-list');
    const feedScroll = document.getElementById('feed-scroll');
    if (!feedList) return;

    let lastId = null;
    let isHovering = false;

    if (feedScroll) {
        feedScroll.addEventListener('mouseenter', () => isHovering = true);
        feedScroll.addEventListener('mouseleave', () => isHovering = false);
    }

    async function pollFeed() {
        const params = lastId ? `?since=${encodeURIComponent(lastId)}` : '?limit=20';
        const data = await apiFetch('/feed' + params);
        if (data.error || !data.data || data.data.length === 0) return;

        const empty = document.getElementById('feed-empty');
        if (empty) empty.remove();

        data.data.reverse().forEach(item => {
            const div = document.createElement('div');
            div.className = 'feed-item flex items-start gap-3 px-4 py-3 border-b border-white/5 hover:bg-white/[0.02] transition-colors';
            div.innerHTML = buildFeedItem(item);
            feedList.prepend(div);
        });

        while (feedList.children.length > 50) {
            feedList.removeChild(feedList.lastChild);
        }

        if (data.data.length > 0) {
            lastId = data.data[0].time;
        }

        if (!isHovering && feedScroll) {
            feedScroll.scrollTop = 0;
        }
    }

    setInterval(pollFeed, 10000);
}

function buildFeedItem(item) {
    const typeColors = {
        level_up: 'bg-gold-400/30 text-gold-200',
        badge_earned: 'bg-amethyst-300/30 text-amethyst-100',
        quest_complete: 'bg-green-500/20 text-green-400',
        card_used: 'bg-red-500/20 text-red-400',
        tester_called: 'bg-cyan-500/20 text-cyan-400',
        trade_complete: 'bg-blue-500/20 text-blue-400',
        social_share: 'bg-pink-500/20 text-pink-400',
        system: 'bg-white/10 text-parchment-300',
    };
    const typeLabels = {
        level_up: 'seviye', badge_earned: 'rozet', quest_complete: 'görev', card_used: 'kart',
        tester_called: 'test', trade_complete: 'takas', social_share: 'paylaşım', system: 'sistem',
    };
    const subtype = (item.meta && item.meta.subtype) || null;
    const isRank = subtype === 'team_rank_change' || subtype === 'viewer_rank_change';
    const typeClass = isRank ? 'bg-gold-400/30 text-gold-200' : (typeColors[item.type] || typeColors.system);
    const typeLabel = isRank ? 'sıralama' : (typeLabels[item.type] || 'sistem');

    const teamRole = item.team_role || '';
    const teamBg = teamRole === 'kasif' ? 'bg-gold-400/50 text-gold-200' : 'bg-amethyst-300/50 text-amethyst-100';
    let tag = '';
    if (item.team_name) tag += `<span class="text-[0.65rem] px-1.5 py-0.5 rounded ${teamBg}">${escHtml(item.team_name)}</span>`;
    if (item.viewer_name) tag += `<span class="text-[0.65rem] px-1.5 py-0.5 rounded bg-amethyst-300/30 text-amethyst-100">👁️ ${escHtml(item.viewer_name)}</span>`;

    return `<span class="text-lg flex-shrink-0 mt-0.5">${item.icon || '📌'}</span>
    <div class="flex-1 min-w-0">
        <p class="text-parchment-100 text-sm leading-snug">${escHtml(item.message)}</p>
        <div class="flex items-center gap-2 mt-1">${tag}<span class="text-parchment-400 text-[0.65rem]">${escHtml(item.time_human || '')}</span></div>
    </div>
    <span class="feed-type-badge text-[0.6rem] px-2 py-0.5 rounded-full font-mono uppercase tracking-wider ${typeClass}">${typeLabel}</span>`;
}

/* ===== Quest Board ===== */
function initQuestBoard() {
    document.querySelectorAll('.quest-timer').forEach(timer => {
        const expiresAt = timer.dataset.expires;
        if (!expiresAt) return;

        const target = new Date(expiresAt).getTime();
        const span = timer.querySelector('.quest-time-remaining');

        function updateTimer() {
            const diff = target - Date.now();
            if (diff <= 0) {
                span.textContent = 'Süresi doldu';
                timer.closest('.quest-card')?.classList.add('opacity-50');
                return;
            }

            const h = Math.floor(diff / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);

            if (h > 0) {
                span.textContent = `${h}sa ${m}dk kaldı`;
            } else if (m > 0) {
                span.textContent = `${m}dk ${s}sn kaldı`;
            } else {
                span.textContent = `${s}sn kaldı`;
            }

            if (diff < 3600000) {
                timer.closest('.quest-card')?.classList.add('quest-expiring');
            }
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    });

    async function refreshQuests() {
        const data = await apiFetch('/quests');
        if (data.error || !data.data) return;

        const teamList = document.getElementById('quest-team-list');
        const viewerList = document.getElementById('quest-viewer-list');

        if (teamList) {
            const teamQuests = data.data.filter(q => q.type !== 'viewer');
            if (teamQuests.length > 0) {
                teamList.innerHTML = teamQuests.map(q => buildQuestCard(q, 'gold')).join('');
                initQuestTimersFor(teamList);
            }
        }

        if (viewerList) {
            const viewerQuests = data.data.filter(q => q.type !== 'team');
            if (viewerQuests.length > 0) {
                viewerList.innerHTML = viewerQuests.map(q => buildQuestCard(q, 'amethyst')).join('');
                initQuestTimersFor(viewerList);
            }
        }
    }

    setInterval(refreshQuests, 60000);
}

function initQuestTimersFor(container) {
    container.querySelectorAll('.quest-timer').forEach(timer => {
        const expiresAt = timer.dataset.expires;
        if (!expiresAt) return;
        const target = new Date(expiresAt).getTime();
        const span = timer.querySelector('.quest-time-remaining');

        function updateTimer() {
            const diff = target - Date.now();
            if (diff <= 0) { span.textContent = 'Süresi doldu'; return; }
            const h = Math.floor(diff / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            span.textContent = h > 0 ? `${h}sa ${m}dk kaldı` : `${m}dk kaldı`;
        }
        updateTimer();
        setInterval(updateTimer, 1000);
    });
}

function buildQuestCard(q, accent) {
    const diffColors = { easy: 'bg-green-500/20 text-green-400', medium: 'bg-gold-400/30 text-gold-200', hard: 'bg-red-500/20 text-red-400' };
    const diffLabels = { easy: 'Kolay', medium: 'Orta', hard: 'Zor' };
    const barColor = accent === 'gold' ? 'bg-gold-200' : 'bg-amethyst-100';
    const hoverBorder = accent === 'gold' ? 'hover:border-gold-200/20' : 'hover:border-amethyst-100/20';
    const pct = q.max_completions > 0 ? Math.min(100, (q.current_completions / q.max_completions) * 100) : 0;
    const expiring = q.expiring_soon ? 'quest-expiring' : '';

    return `<div class="quest-card rounded-xl p-5 border border-white/10 bg-white/[0.03] transition-all ${hoverBorder} ${expiring}">
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="text-2xl">${q.icon}</span>
                <div>
                    <h4 class="font-cinzel font-bold text-parchment-100">${escHtml(q.title)}</h4>
                    <span class="quest-difficulty text-[0.6rem] px-2 py-0.5 rounded-full font-mono uppercase ${diffColors[q.difficulty] || diffColors.medium}">${diffLabels[q.difficulty] || 'Orta'}</span>
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                ${accent === 'gold' ? (q.credit_reward > 0 ? `<span class="text-amethyst-100 font-mono font-bold text-sm">+${q.credit_reward} Kredi</span>` : '<span class="text-gold-200 font-mono text-xs">Görev tamamlandı</span>') : `<span class="text-amethyst-100 font-mono font-bold text-sm">+${q.xp_reward} XP</span>`}
            </div>
        </div>
        <p class="text-parchment-200 text-sm mb-3">${escHtml(q.description)}</p>
        <div class="flex items-center justify-between">
            <div class="quest-timer flex items-center gap-1.5 text-xs" data-expires="${q.expires_at}">
                <svg class="w-3.5 h-3.5 text-parchment-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-parchment-300 quest-time-remaining">${escHtml(q.remaining)}</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="quest-progress-bar w-20 h-1.5 rounded-full bg-white/10 overflow-hidden">
                    <div class="h-full rounded-full ${barColor} transition-all" style="width:${pct}%"></div>
                </div>
                <span class="text-parchment-400 text-[0.6rem]">${q.current_completions}/${q.max_completions}</span>
            </div>
        </div>
    </div>`;
}

/* ===== Badge Gallery ===== */
function initBadgeGallery() {
    const filters = document.querySelectorAll('.badge-filter');
    const badges = document.querySelectorAll('.badge-item');

    filters.forEach(filter => {
        filter.addEventListener('click', () => {
            filters.forEach(f => f.classList.remove('active'));
            filter.classList.add('active');
            const rarity = filter.dataset.rarity;

            badges.forEach(badge => {
                if (rarity === 'all' || badge.dataset.rarity === rarity) {
                    badge.style.display = '';
                } else {
                    badge.style.display = 'none';
                }
            });
        });
    });

    badges.forEach(badge => {
        badge.addEventListener('click', () => {
            if (badge.classList.contains('badge-earned')) {
                badge.style.transform = 'scale(1.1) rotate(5deg)';
                setTimeout(() => { badge.style.transform = ''; }, 300);
            }
        });
    });
}

/* ===== Card Market ===== */
function initCardMarket() {
    const tabs = document.querySelectorAll('.card-tab');
    const cards = document.querySelectorAll('.card-flip-container');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const type = tab.dataset.type;

            cards.forEach(card => {
                if (type === 'all' || card.dataset.cardType === type) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    if ('ontouchstart' in window) {
        document.querySelectorAll('.card-flip').forEach(card => {
            card.addEventListener('click', () => {
                card.classList.toggle('flipped');
            });
        });
    }

    refreshCardTicker();
    setInterval(refreshCardTicker, 15000);
}

async function refreshCardTicker() {
    const ticker = document.getElementById('card-ticker-content');
    if (!ticker) return;

    const data = await apiFetch('/cards');
    if (data.error || !data.recent_purchases || data.recent_purchases.length === 0) return;

    const text = data.recent_purchases.map(p => {
        const icon = p.type === 'gazap' ? '⚡' : '✨';
        const target = p.target ? ` → ${p.target}` : '';
        return `${icon} ${p.team}: ${p.card}${target} (${p.time})`;
    }).join('  •  ');

    ticker.textContent = text + '  •  ' + text;
}

/* ===== Viewer Zone ===== */
function initViewerZone() {
    const VIEWER_KEY = 'livingcode_viewer';
    let viewer = null;

    try {
        const stored = localStorage.getItem(VIEWER_KEY);
        if (stored) viewer = JSON.parse(stored);
    } catch (e) {}

    if (viewer && viewer.id) {
        showViewerProfile(viewer);
        startWatchHeartbeat(viewer.id);
    }

    const registerBtn = document.getElementById('viewer-register-btn');
    if (registerBtn) {
        registerBtn.addEventListener('click', async () => {
            const name = document.getElementById('viewer-name')?.value.trim();
            const email = document.getElementById('viewer-email')?.value.trim();
            const errorEl = document.getElementById('viewer-register-error');

            if (!name || !email) {
                if (errorEl) errorEl.textContent = 'İsim ve e-posta gerekli.';
                return;
            }

            registerBtn.disabled = true;
            registerBtn.textContent = 'Kaydediliyor...';

            const data = await apiFetch('/viewer/register', {
                method: 'POST',
                body: JSON.stringify({ name, email }),
            });

            if (data.error) {
                if (errorEl) { errorEl.textContent = data.error; errorEl.classList.add('text-red-400'); }
                registerBtn.disabled = false;
                registerBtn.textContent = 'Kayıt Ol';
                return;
            }

            viewer = data.viewer;
            if (errorEl) { errorEl.textContent = ''; errorEl.classList.remove('text-red-400'); }
            try { localStorage.setItem(VIEWER_KEY, JSON.stringify(viewer)); } catch (e) {}
            showViewerProfile(viewer);
            startWatchHeartbeat(viewer.id);
            refreshViewerMiniLeaderboard();
        });
    }

    const loginBtn = document.getElementById('viewer-login-btn');
    if (loginBtn) {
        loginBtn.addEventListener('click', async () => {
            const email = document.getElementById('viewer-login-email')?.value.trim();
            const errorEl = document.getElementById('viewer-login-error');
            if (!email) {
                if (errorEl) { errorEl.textContent = 'E-posta girin.'; errorEl.classList.add('text-red-400'); }
                return;
            }
            loginBtn.disabled = true;
            if (errorEl) errorEl.textContent = '';
            const data = await apiFetch('/viewer/login', {
                method: 'POST',
                body: JSON.stringify({ email }),
            });
            if (data.error) {
                if (errorEl) { errorEl.textContent = data.error; errorEl.classList.add('text-red-400'); }
                loginBtn.disabled = false;
                return;
            }
            viewer = data.viewer;
            if (errorEl) errorEl.classList.remove('text-red-400');
            try { localStorage.setItem(VIEWER_KEY, JSON.stringify(viewer)); } catch (e) {}
            showViewerProfile(viewer);
            startWatchHeartbeat(viewer.id);
            refreshViewerMiniLeaderboard();
            loginBtn.disabled = false;
        });
    }

    const platformLabels = { twitter: '𝕏 (Twitter)', instagram: '📷 Instagram', linkedin: '💼 LinkedIn', tiktok: '🎵 TikTok' };
    const claimModal = document.getElementById('viewer-claim-modal');
    const claimPlatform = document.getElementById('viewer-claim-platform');
    const claimPlatformLabel = document.getElementById('viewer-claim-platform-label');
    const claimForm = document.getElementById('viewer-claim-form');
    const claimProof = document.getElementById('viewer-claim-proof');
    const claimError = document.getElementById('viewer-claim-error');
    const claimSubmit = document.getElementById('viewer-claim-submit');
    const claimCancel = document.getElementById('viewer-claim-cancel');

    const shareBtns = document.querySelectorAll('.social-share-btn');
    shareBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (!viewer || !viewer.id) {
                alert('Önce izleyici olarak kayıt olun.');
                return;
            }
            if (!viewer.token) {
                alert('Oturum süresi dolmuş olabilir. Lütfen çıkış yapıp tekrar giriş yapın.');
                return;
            }
            const platform = btn.dataset.platform;
            if (claimPlatform) claimPlatform.value = platform;
            if (claimPlatformLabel) claimPlatformLabel.textContent = platformLabels[platform] || platform;
            if (claimForm) claimForm.reset();
            if (claimPlatform) claimPlatform.value = platform;
            if (claimError) claimError.textContent = '';
            if (claimModal) claimModal.classList.remove('hidden');
            else alert('Talep formu yüklenemedi. Sayfayı yenileyin.');
        });
    });

    if (claimCancel && claimModal) {
        claimCancel.addEventListener('click', () => claimModal.classList.add('hidden'));
    }
    if (claimForm) {
        claimForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            let v = viewer;
            try {
                const stored = localStorage.getItem('livingcode_viewer');
                if (stored) v = JSON.parse(stored);
            } catch (err) {}
            if (!v || !v.id || !v.token) {
                if (claimError) claimError.textContent = 'Oturum bulunamadı. Lütfen tekrar giriş yapın.';
                return;
            }
            const file = claimProof && claimProof.files && claimProof.files[0];
            if (!file) {
                if (claimError) claimError.textContent = 'Kanıt fotoğrafı seçin.';
                return;
            }
            const formData = new FormData();
            formData.append('viewer_id', v.id);
            formData.append('viewer_token', v.token);
            formData.append('platform', claimPlatform ? claimPlatform.value : '');
            const shareUrl = document.getElementById('viewer-claim-share-url');
            if (shareUrl && shareUrl.value.trim()) formData.append('share_url', shareUrl.value.trim());
            formData.append('proof', file);

            claimSubmit.disabled = true;
            if (claimError) claimError.textContent = '';
            try {
                const res = await fetch(API_BASE + '/viewer/claim', {
                    method: 'POST',
                    body: formData,
                    headers: { 'Accept': 'application/json' },
                });
                const data = await res.json().catch(() => ({}));
                if (data.success) {
                    if (claimModal) claimModal.classList.add('hidden');
                    alert(data.message || 'Talebiniz alındı. Konsey onayından sonra XP eklenecek.');
                } else {
                    if (claimError) claimError.textContent = data.error || data.message || 'Gönderilemedi.';
                }
            } catch (err) {
                if (claimError) claimError.textContent = 'Bağlantı hatası.';
            }
            claimSubmit.disabled = false;
        });
    }

    setInterval(refreshViewerMiniLeaderboard, 30000);

    const viewerLogoutBtn = document.getElementById('viewer-logout-btn');
    if (viewerLogoutBtn) {
        viewerLogoutBtn.addEventListener('click', () => {
            viewer = null;
            try { localStorage.removeItem(VIEWER_KEY); } catch (e) {}
            const form = document.getElementById('viewer-register-form');
            const profile = document.getElementById('viewer-profile');
            if (form) { form.classList.remove('hidden'); form.querySelector('#viewer-name')?.focus(); }
            if (profile) profile.classList.add('hidden');
        });
    }
}

async function refreshViewerMiniLeaderboard() {
    const container = document.getElementById('viewer-mini-leaderboard');
    if (!container) return;
    const data = await apiFetch('/leaderboard/viewers');
    if (data.error || !data.data) return;
    const list = Array.isArray(data.data) ? data.data : [];
    container.innerHTML = list.slice(0, 5).map((v, i) =>
        `<div class="flex items-center gap-3 p-2 rounded-lg ${i === 0 ? 'bg-amethyst-300/10' : ''}">
            <span class="text-xs text-parchment-300 w-5 text-center font-mono">${i + 1}</span>
            <span class="flex-1 text-parchment-100 text-sm truncate">${escHtml(v.name || '')}</span>
            <span class="text-amethyst-100 text-xs font-mono">${v.watch_minutes ?? v.total_watch_minutes ?? 0} dk</span>
        </div>`
    ).join('') || '<p class="text-parchment-300 text-sm text-center py-4">Henüz izleyici verisi yok.</p>';
}

function showViewerProfile(viewer) {
    const form = document.getElementById('viewer-register-form');
    const profile = document.getElementById('viewer-profile');
    if (form) form.classList.add('hidden');
    if (profile) profile.classList.remove('hidden');

    const nameEl = document.getElementById('viewer-display-name');
    const xpEl = document.getElementById('viewer-xp-display');
    const minEl = document.getElementById('viewer-minutes-display');
    const streakEl = document.getElementById('viewer-streak-display');

    if (nameEl) nameEl.textContent = viewer.name;
    if (xpEl) xpEl.textContent = viewer.xp || 0;
    if (minEl) minEl.textContent = viewer.watch_minutes || 0;
    if (streakEl) streakEl.textContent = viewer.streak || 0;
}

function startWatchHeartbeat(viewerId) {
    setInterval(async () => {
        if (document.hidden) return;

        const data = await apiFetch('/viewer/heartbeat', {
            method: 'POST',
            body: JSON.stringify({ viewer_id: viewerId, minutes: 1 }),
        });

        if (!data.error) {
            const minEl = document.getElementById('viewer-minutes-display');
            const xpEl = document.getElementById('viewer-xp-display');
            if (minEl) minEl.textContent = data.total_minutes || 0;
            if (xpEl) xpEl.textContent = data.xp || 0;
        }
    }, 60000);
}


/* ===== Hero Gamification ===== */
function initHeroGamification() {
    // Takım XP sistemi kaldırıldı, sadece çevrimiçi sayacı güncelleniyor
    updateOnlineCount();
    setInterval(updateOnlineCount, 15000);
}

async function updateOnlineCount() {
    const el = document.getElementById('hero-online-count');
    if (!el) return;

    const data = await apiFetch('/leaderboard/viewers');
    const count = data.data ? data.data.length : 0;
    el.textContent = count;
}

/* ===== Utilities ===== */
function getActiveTeamId() {
    try {
        const stored = localStorage.getItem('livingcode_team_id');
        if (stored) return parseInt(stored);
    } catch (e) {}
    return null;
}

function escHtml(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}
