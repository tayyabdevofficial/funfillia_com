@props(['categories' => []])

<footer class="bg-slate-950 text-slate-300 border-t border-slate-800/80 transition-colors pt-16 pb-12 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-slate-800/80">
            <!-- Brand & Mission Column (5 cols on lg) -->
            <div class="lg:col-span-4 space-y-5">
                <a href="{{ route('home') }}" class="inline-block group">
                    <img src="{{ asset('logo-dark.png') }}" alt="Funfillia" class="h-10 sm:h-12 w-auto object-contain group-hover:scale-105 transition-transform duration-200">
                </a>
                
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                    Funfillia is your premier digital magazine destination for viral entertainment, daily challenge guides, pop culture trends, and creative lifestyle discoveries.
                </p>

                <div class="flex items-center gap-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>Verified Digital Publication</span>
                    </div>
                </div>

            </div>

            <!-- Explore Categories Column (3 cols on lg) -->
            <div class="lg:col-span-3 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-white border-b border-slate-800 pb-2">
                    Trending Categories
                </h4>
                <ul class="space-y-2 text-sm">
                    @foreach(collect($categories)->take(6) as $cat)
                        <li>
                            <a href="{{ route('category.show', $cat['slug'] ?? '#') }}" 
                               class="group flex items-center justify-between text-slate-400 hover:text-white transition-colors py-1">
                                <span class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500/60 group-hover:bg-indigo-400 group-hover:scale-125 transition-all"></span>
                                    <span class="group-hover:translate-x-0.5 transition-transform">{{ $cat['name'] }}</span>
                                </span>
                                <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Company & Editorial Legal Column (2 cols on lg) -->
            <div class="lg:col-span-2 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-white border-b border-slate-800 pb-2">
                    Company &amp; Legal
                </h4>
                <ul class="space-y-2.5 text-sm">
                    <li>
                        <a href="{{ route('pages.about') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <span class="text-slate-600 group-hover:text-indigo-400 transition-colors">&rsaquo;</span>
                            <span class="group-hover:translate-x-0.5 transition-transform">About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.contact') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <span class="text-slate-600 group-hover:text-indigo-400 transition-colors">&rsaquo;</span>
                            <span class="group-hover:translate-x-0.5 transition-transform">Contact Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.privacy') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <span class="text-slate-600 group-hover:text-indigo-400 transition-colors">&rsaquo;</span>
                            <span class="group-hover:translate-x-0.5 transition-transform">Privacy Policy</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.terms') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <span class="text-slate-600 group-hover:text-indigo-400 transition-colors">&rsaquo;</span>
                            <span class="group-hover:translate-x-0.5 transition-transform">Terms of Service</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.cookies') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <span class="text-slate-600 group-hover:text-indigo-400 transition-colors">&rsaquo;</span>
                            <span class="group-hover:translate-x-0.5 transition-transform">Cookie Policy</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sitemap') }}" target="_blank" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <span class="text-slate-600 group-hover:text-indigo-400 transition-colors">&rsaquo;</span>
                            <span class="group-hover:translate-x-0.5 transition-transform">XML Sitemap</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Professional Newsletter Box (3 cols on lg) -->
            <div class="lg:col-span-3">
                <div class="rounded-2xl bg-slate-900/90 border border-slate-800 p-5 shadow-lg space-y-3.5">
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <h4 class="text-sm font-bold text-white tracking-tight">Stay Ahead of Trends</h4>
                    </div>

                    <p class="text-xs text-slate-400 leading-relaxed">
                        Get our weekly digest of hilarious challenges, viral pop discoveries, and game nights. Zero spam, unsubscribe anytime.
                    </p>

                    <div id="footer-newsletter-msg" class="hidden p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold"></div>

                    <form id="footer-newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                        @csrf
                        <div class="relative">
                            <input type="email" 
                                   name="email" 
                                   required 
                                   placeholder="Enter your email address" 
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white placeholder-slate-500 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <button type="submit" 
                                id="footer-newsletter-btn" 
                                class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-indigo-500 to-rose-500 hover:from-indigo-600 hover:to-rose-600 text-white text-xs font-bold transition-all duration-200 shadow-md hover:shadow-indigo-500/25 active:scale-95">
                            Subscribe Free
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright & Quick Actions -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2">
                <p>&copy; {{ date('Y') }} Funfillia Media Network. All rights reserved.</p>
            </div>

            <div class="flex items-center gap-4 text-xs">
                <a href="{{ route('pages.privacy') }}" class="hover:text-slate-300 transition-colors">Privacy</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('pages.terms') }}" class="hover:text-slate-300 transition-colors">Terms</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('pages.cookies') }}" class="hover:text-slate-300 transition-colors">Cookies</a>
                <span class="text-slate-700">&bull;</span>
                <button type="button" 
                        onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="text-indigo-400 hover:text-indigo-300 transition-colors font-semibold inline-flex items-center gap-1">
                    <span>Back to Top</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                </button>
            </div>
        </div>
    </div>
</footer>

<script>
    document.getElementById('footer-newsletter-form')?.addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        const btn = document.getElementById('footer-newsletter-btn');
        const msg = document.getElementById('footer-newsletter-msg');
        btn.disabled = true;
        btn.textContent = 'Subscribing...';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(async (res) => {
            const data = await res.json();
            btn.disabled = false;
            btn.textContent = 'Subscribe Free';

            if (msg) {
                msg.textContent = '✓ ' + (data.message || 'Subscribed successfully!');
                msg.classList.remove('hidden');
                form.classList.add('hidden');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.textContent = 'Subscribe Free';
            if (msg) {
                msg.textContent = '✕ Error subscribing. Try again.';
                msg.classList.remove('hidden');
            }
        });
    });
</script>
