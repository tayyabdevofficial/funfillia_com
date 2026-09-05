<div id="cookie-consent-banner" class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:max-w-md z-50 transform transition-all duration-500 translate-y-24 opacity-0 pointer-events-none">
    <div class="p-6 rounded-3xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border border-slate-200 dark:border-slate-800 shadow-2xl space-y-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 text-xl shadow-xs">
                🍪
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">We Value Your Privacy</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mt-1">
                    We use cookies to enhance your browsing experience, provide personalized content, and analyze site performance. Read our 
                    <a href="{{ route('pages.cookies') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold underline hover:text-indigo-700">Cookie Policy</a>.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2.5 pt-1">
            <button type="button" 
                    onclick="acceptCookies('essential')" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Essential Only
            </button>
            <button type="button" 
                    onclick="acceptCookies('all')" 
                    class="px-5 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-md transition-colors">
                Accept All
            </button>
        </div>
    </div>
</div>

<script>
    function checkCookieConsent() {
        const consent = localStorage.getItem('funfillia_cookie_consent');
        if (!consent) {
            setTimeout(() => {
                const banner = document.getElementById('cookie-consent-banner');
                if (banner) {
                    banner.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
                    banner.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
                }
            }, 1200);
        }
    }

    function acceptCookies(preference) {
        localStorage.setItem('funfillia_cookie_consent', preference);
        const banner = document.getElementById('cookie-consent-banner');
        if (banner) {
            banner.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
            banner.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
        }
    }

    document.addEventListener('DOMContentLoaded', checkCookieConsent);
</script>
