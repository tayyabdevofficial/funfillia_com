<div id="cookie-consent-banner" class="hidden fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:max-w-md z-50 transform translate-y-24 opacity-0 pointer-events-none transition-[transform,opacity] duration-500 ease-out" aria-hidden="true" style="will-change: transform, opacity;">
    <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl space-y-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 flex items-center justify-center shrink-0 text-xl shadow-xs">
                🍪
            </div>
            <div>
                <p class="text-sm font-bold text-slate-950 dark:text-white">We Value Your Privacy</p>
                <p class="text-xs text-slate-700 dark:text-slate-200 leading-relaxed mt-1">
                    We use cookies to enhance your browsing experience, provide personalized content, and analyze site performance. Read our 
                    <a href="{{ route('pages.cookies') }}" class="text-indigo-700 dark:text-indigo-300 font-bold underline hover:text-indigo-900 dark:hover:text-indigo-100">Cookie Policy</a>.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2.5 pt-1">
            <button type="button" 
                    onclick="acceptCookies('essential')" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Essential Only
            </button>
            <button type="button" 
                    onclick="acceptCookies('all')" 
                    class="px-5 py-2 rounded-xl text-xs font-bold bg-indigo-700 hover:bg-indigo-800 text-white shadow-md transition-colors">
                Accept All
            </button>
        </div>
    </div>
</div>

<script>
    function checkCookieConsent() {
        const consent = localStorage.getItem('funfillia_cookie_consent');
        if (!consent) {
            const show = () => {
                const banner = document.getElementById('cookie-consent-banner');
                if (banner) {
                    banner.classList.remove('hidden');
                    banner.removeAttribute('aria-hidden');
                    requestAnimationFrame(() => {
                        banner.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
                        banner.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
                    });
                }
            };
            if ('requestIdleCallback' in window) {
                requestIdleCallback(() => setTimeout(show, 3000));
            } else {
                setTimeout(show, 3500);
            }
        }
    }

    function acceptCookies(preference) {
        localStorage.setItem('funfillia_cookie_consent', preference);
        const banner = document.getElementById('cookie-consent-banner');
        if (banner) {
            banner.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
            banner.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
            banner.setAttribute('aria-hidden', 'true');
            setTimeout(() => {
                banner.classList.add('hidden');
            }, 550);
        }
    }

    document.addEventListener('DOMContentLoaded', checkCookieConsent);
</script>

