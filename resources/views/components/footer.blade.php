@props(['categories' => []])

<footer class="bg-slate-900 text-slate-300 border-t border-slate-800 transition-colors pt-16 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
            <!-- Brand & Bio (2 cols on lg) -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('images/logo.png') }}" alt="Funfillia" class="h-12 w-auto object-contain rounded-xl brightness-110">
                </a>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                    Funfillia is your premier digital magazine destination for trending lifestyle guides, culinary secrets, modern fashion, and viral daily discoveries.
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Live Stories Daily
                    </span>
                </div>
            </div>

            <!-- Explore Categories -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Categories</h4>
                <ul class="space-y-2.5 text-sm">
                    @foreach(collect($categories)->take(5) as $cat)
                        <li>
                            <a href="{{ route('category.show', $cat['slug'] ?? '#') }}" class="hover:text-indigo-400 transition-colors flex items-center gap-1.5">
                                <span class="text-xs text-slate-600">&rsaquo;</span>
                                <span>{{ $cat['name'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Company & Legal Pages -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Company &amp; Legal</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('pages.about') }}" class="hover:text-indigo-400 transition-colors">&rsaquo; About Us</a></li>
                    <li><a href="{{ route('pages.contact') }}" class="hover:text-indigo-400 transition-colors">&rsaquo; Contact Us</a></li>
                    <li><a href="{{ route('pages.privacy') }}" class="hover:text-indigo-400 transition-colors">&rsaquo; Privacy Policy</a></li>
                    <li><a href="{{ route('pages.terms') }}" class="hover:text-indigo-400 transition-colors">&rsaquo; Terms &amp; Conditions</a></li>
                    <li><a href="{{ route('pages.cookies') }}" class="hover:text-indigo-400 transition-colors">&rsaquo; Cookie Policy</a></li>
                    <li><a href="{{ route('sitemap') }}" class="hover:text-indigo-400 transition-colors" target="_blank">&rsaquo; XML Sitemap</a></li>
                </ul>
            </div>

            <!-- Newsletter Signup (AJAX) -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Stay Connected</h4>
                <p class="text-xs text-slate-400 mb-3">Get the latest stories and trends directly in your inbox.</p>
                <div id="footer-newsletter-msg" class="hidden p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold mb-2"></div>
                <form id="footer-newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                    @csrf
                    <input type="email" 
                           name="email" 
                           required 
                           placeholder="Enter your email" 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit" id="footer-newsletter-btn" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-indigo-500 to-rose-500 hover:from-indigo-600 hover:to-rose-600 text-white text-xs font-bold transition-all shadow-md">
                        Subscribe Free
                    </button>
                </form>
            </div>
        </div>

        <!-- Copyright Bottom -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} Funfillia. All rights reserved.</p>
            <div class="flex items-center gap-4 text-xs">
                <a href="{{ route('pages.privacy') }}" class="hover:underline">Privacy</a>
                <span>&bull;</span>
                <a href="{{ route('pages.terms') }}" class="hover:underline">Terms</a>
                <span>&bull;</span>
                <a href="{{ route('pages.cookies') }}" class="hover:underline">Cookies</a>
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
