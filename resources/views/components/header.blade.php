@props(['categories' => [], 'trendingTopics' => []])

<header class="sticky top-0 z-40 w-full transition-colors duration-200">
    <!-- Trending topics bar -->
    <x-trending-ticker :topics="$trendingTopics" />

    <!-- Main Navigation Bar -->
    <nav class="backdrop-blur-md bg-white/90 dark:bg-slate-900/90 border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-18">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group" aria-label="Funfillia Homepage">
                        <!-- Compact brand mark on mobile -->
                        <picture class="block sm:hidden dark:hidden shrink-0">
                            <source srcset="{{ asset('logo_sm.webp') }}" type="image/webp">
                            <img src="{{ asset('logo_sm.png') }}" alt="Funfillia" width="28" height="28" fetchpriority="high" class="h-7 w-7 object-contain rounded-lg">
                        </picture>
                        <picture class="hidden dark:max-sm:block shrink-0">
                            <source srcset="{{ asset('logo_sm-dark.webp') }}" type="image/webp">
                            <img src="{{ asset('logo_sm-dark.png') }}" alt="Funfillia" width="28" height="28" fetchpriority="high" class="h-7 w-7 object-contain rounded-lg">
                        </picture>
                        <!-- Full horizontal brand logo for sm and above -->
                        <picture class="hidden sm:block dark:hidden group-hover:scale-105 transition-transform duration-200 shrink-0">
                            <source srcset="{{ asset('logo.webp') }}" type="image/webp">
                            <img src="{{ asset('logo.png') }}" alt="Funfillia" width="135" height="32" fetchpriority="high" class="h-7 sm:h-8 w-auto object-contain">
                        </picture>
                        <picture class="hidden dark:sm:block group-hover:scale-105 transition-transform duration-200 shrink-0">
                            <source srcset="{{ asset('logo-dark.webp') }}" type="image/webp">
                            <img src="{{ asset('logo-dark.png') }}" alt="Funfillia" width="135" height="32" fetchpriority="high" class="h-7 sm:h-8 w-auto object-contain">
                        </picture>
                    </a>
                </div>

                <!-- Desktop Category Navigation -->
                <div class="hidden lg:flex items-center gap-1 xl:gap-2 overflow-visible">
                    <a href="{{ route('quizzes.index') }}" 
                       class="px-3 py-2 rounded-xl text-sm font-bold transition-all inline-flex items-center gap-1.5 whitespace-nowrap shrink-0 {{ request()->routeIs('quizzes.*') ? 'text-pink-600 dark:text-pink-400 bg-pink-50 dark:bg-pink-950/50' : 'text-slate-700 dark:text-slate-300 hover:text-pink-600 dark:hover:text-pink-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        <span>Quizzes</span>
                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-black uppercase tracking-wider rounded-md bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-sm whitespace-nowrap leading-tight">🔥 FUN</span>
                    </a>

                    @php
                        $allCats = collect($categories);
                        $primaryCats = $allCats->take(4);
                        $moreCats = $allCats->slice(4);
                    @endphp

                    @foreach($primaryCats as $category)
                        @php
                            $subCats = $category['sub_categories'] ?? [];
                            $hasSubs = !empty($subCats) && count($subCats) > 0;
                            $isActive = request()->is('category/' . ($category['slug'] ?? ''));
                        @endphp

                        @if($hasSubs)
                            <div class="relative group shrink-0">
                                <a href="{{ route('category.show', $category['slug'] ?? '#') }}" 
                                   class="px-3 py-2 rounded-xl text-sm font-semibold inline-flex items-center gap-1.5 transition-all whitespace-nowrap {{ $isActive ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50' : 'text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                    <span>{{ $category['name'] }}</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:rotate-180 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </a>

                                <!-- Dropdown menu (Without "All in category") -->
                                <div class="absolute left-0 top-full pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 w-52">
                                    <div class="rounded-2xl bg-white dark:bg-slate-800 shadow-xl border border-slate-200 dark:border-slate-700 p-2 space-y-1">
                                        @foreach($subCats as $sub)
                                            <a href="{{ route('subcategory.show', $sub['slug'] ?? '#') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-700/60 transition-colors whitespace-nowrap truncate">
                                                {{ $sub['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('category.show', $category['slug'] ?? '#') }}" 
                               class="px-3 py-2 rounded-xl text-sm font-semibold transition-all whitespace-nowrap shrink-0 {{ $isActive ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50' : 'text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                {{ $category['name'] }}
                            </a>
                        @endif
                    @endforeach

                    @if($moreCats->count() > 0)
                        <div class="relative group shrink-0">
                            <button type="button" 
                                    class="px-3 py-2 rounded-xl text-sm font-semibold inline-flex items-center gap-1.5 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all whitespace-nowrap">
                                <span>More</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:rotate-180 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div class="absolute right-0 sm:left-0 top-full pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 w-56">
                                <div class="rounded-2xl bg-white dark:bg-slate-800 shadow-2xl border border-slate-200 dark:border-slate-700 p-2 space-y-1">
                                    @foreach($moreCats as $moreCat)
                                        <a href="{{ route('category.show', $moreCat['slug'] ?? '#') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-700/60 transition-colors whitespace-nowrap truncate">
                                            {{ $moreCat['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Actions: Search trigger icon button, Theme toggle, Mobile button -->
                <div class="flex items-center gap-2">
                    <!-- Search Icon Button -->
                    <button type="button" 
                            onclick="document.getElementById('search-modal').classList.remove('hidden'); document.getElementById('modal-search-input')?.focus();"
                            class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 flex items-center justify-center"
                            title="Search (⌘K)"
                            aria-label="Open Search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Theme Toggle Switch -->
                                        <!-- WhatsApp Action Button -->
                    <a href="https://wa.me/923099700930?text={{ urlencode('Hello, I am reaching out regarding ' . config('site.name') . ' editorial / inquiries.') }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 border border-emerald-300 dark:border-emerald-800 transition-all shadow-xs shrink-0 hover:scale-105" 
                       title="WhatsApp Editorial Desk (+92 309 9700930)">
                        <svg class="w-3.5 h-3.5 fill-current text-emerald-600 dark:text-emerald-400 shrink-0" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.311.045-.698.077-1.921-.427-1.442-.593-2.368-2.055-2.439-2.151-.07-.096-.583-.777-.583-1.482 0-.705.37-1.053.501-1.198.131-.144.287-.181.382-.181.096 0 .191.002.274.007.087.004.204-.033.319.243.119.288.406 1.001.443 1.074.037.073.061.16.012.257-.048.096-.073.156-.144.24-.072.083-.153.187-.218.251-.072.072-.148.15-.064.294.084.144.373.615.8 1.001.551.498 1.016.653 1.16.726.144.073.228.064.312-.033.084-.096.36-.419.456-.563.096-.144.192-.12.324-.072.131.048.837.395.981.467.144.073.24.108.275.168.036.06.036.348-.108.753z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.821.487 3.53 1.338 5L2 22l5.132-1.312A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167c-1.579 0-3.048-.445-4.295-1.216l-.308-.189-3.039.778.812-2.964-.207-.324A8.136 8.136 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167 4.503 0 8.167 3.664 8.167 8.167 0 4.503-3.664 8.167-8.167 8.167z"/></svg>
                        <span class="hidden xs:inline">WhatsApp</span>
                    </a>

                    <x-theme-toggle />

                    <!-- Mobile Hamburger Menu Button -->
                    <button type="button" 
                            onclick="openMobileNav()"
                            class="lg:hidden p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                            aria-label="Open Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Animated Mobile Drawer & Backdrop -->
    <div id="mobile-nav-backdrop" 
         class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"
         onclick="closeMobileNav()"></div>

    <div id="mobile-nav-drawer" 
         class="fixed top-0 right-0 bottom-0 z-50 w-80 max-w-[85vw] bg-white dark:bg-slate-900 shadow-2xl border-l border-slate-200 dark:border-slate-800 transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden flex flex-col">
        
        <!-- Drawer Header -->
        <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
            <a href="{{ route('home') }}" class="flex items-center" onclick="closeMobileNav()" aria-label="Funfillia Homepage">
                <picture class="block dark:hidden">
                    <source srcset="{{ asset('logo.webp') }}" type="image/webp">
                    <img src="{{ asset('logo.png') }}" alt="Funfillia" width="135" height="32" loading="lazy" class="h-8 w-auto object-contain">
                </picture>
                <picture class="hidden dark:block">
                    <source srcset="{{ asset('logo-dark.webp') }}" type="image/webp">
                    <img src="{{ asset('logo-dark.png') }}" alt="Funfillia" width="135" height="32" loading="lazy" class="h-8 w-auto object-contain">
                </picture>
            </a>
            <button type="button" 
                    onclick="closeMobileNav()" 
                    class="p-2 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    aria-label="Close Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Quick Search inside Mobile Drawer -->
        <div class="p-4 border-b border-slate-100 dark:border-slate-800">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="search" 
                       name="q" 
                       placeholder="Search stories..." 
                       class="w-full px-4 py-2.5 pl-10 rounded-xl bg-slate-100 dark:bg-slate-800 border-0 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>
        </div>

        <!-- Drawer Nav Links & Accordion -->
        <div class="flex-1 overflow-y-auto p-4 space-y-2">

            <a href="{{ route('quizzes.index') }}" 
               onclick="closeMobileNav()"
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('quizzes.*') ? 'bg-pink-50 dark:bg-pink-950/50 text-pink-600 dark:text-pink-400' : 'text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors">
                <div class="flex items-center gap-3">
                    <span class="text-base">✨</span>
                    <span>Viral Quizzes & Dares</span>
                </div>
                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-pink-500 text-white">HOT</span>
            </a>

            <div class="pt-2 pb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3">Categories</span>
            </div>

            @foreach($categories as $index => $category)
                @php
                    $subCats = $category['sub_categories'] ?? [];
                    $hasSubs = !empty($subCats) && count($subCats) > 0;
                    $accordionId = 'mobile-sub-' . ($category['id'] ?? $index);
                @endphp

                @if($hasSubs)
                    <div class="rounded-xl overflow-hidden border border-slate-100 dark:border-slate-800/80">
                        <div class="flex items-center justify-between px-3.5 py-2.5 bg-slate-50/70 dark:bg-slate-800/50">
                            <a href="{{ route('category.show', $category['slug'] ?? '#') }}" 
                               onclick="closeMobileNav()"
                               class="font-semibold text-sm text-slate-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400">
                                {{ $category['name'] }}
                            </a>
                            <button type="button" 
                                    onclick="toggleMobileAccordion('{{ $accordionId }}', this)" 
                                    aria-label="Toggle {{ $category['name'] }} subcategories"
                                    aria-expanded="false"
                                    class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-transform">
                                <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <div id="{{ $accordionId }}" class="hidden px-4 py-2 space-y-1 bg-white dark:bg-slate-900/60 border-t border-slate-100 dark:border-slate-800">
                            @foreach($subCats as $sub)
                                <a href="{{ route('subcategory.show', $sub['slug'] ?? '#') }}" 
                                   onclick="closeMobileNav()"
                                   class="block px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    &bull; {{ $sub['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ route('category.show', $category['slug'] ?? '#') }}" 
                       onclick="closeMobileNav()"
                       class="block px-3.5 py-2.5 rounded-xl font-semibold text-sm text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        {{ $category['name'] }}
                    </a>
                @endif
            @endforeach

            <div class="pt-4 pb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3">Information</span>
            </div>
            <a href="{{ route('pages.about') }}" onclick="closeMobileNav()" class="block px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600">About Funfillia</a>
            <a href="{{ route('pages.contact') }}" onclick="closeMobileNav()" class="block px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600">Contact Us</a>
            <a href="{{ route('pages.privacy') }}" onclick="closeMobileNav()" class="block px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600">Privacy Policy</a>
            <a href="{{ route('pages.terms') }}" onclick="closeMobileNav()" class="block px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600">Terms &amp; Conditions</a>
            <a href="{{ route('pages.cookies') }}" onclick="closeMobileNav()" class="block px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600">Cookie Policy</a>
        </div>

        <!-- Drawer Footer -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400">
            <span>&copy; {{ date('Y') }} Funfillia</span>
                                <!-- WhatsApp Action Button -->
                    <a href="https://wa.me/923099700930?text={{ urlencode('Hello, I am reaching out regarding ' . config('site.name') . ' editorial / inquiries.') }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 border border-emerald-300 dark:border-emerald-800 transition-all shadow-xs shrink-0 hover:scale-105" 
                       title="WhatsApp Editorial Desk (+92 309 9700930)">
                        <svg class="w-3.5 h-3.5 fill-current text-emerald-600 dark:text-emerald-400 shrink-0" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.311.045-.698.077-1.921-.427-1.442-.593-2.368-2.055-2.439-2.151-.07-.096-.583-.777-.583-1.482 0-.705.37-1.053.501-1.198.131-.144.287-.181.382-.181.096 0 .191.002.274.007.087.004.204-.033.319.243.119.288.406 1.001.443 1.074.037.073.061.16.012.257-.048.096-.073.156-.144.24-.072.083-.153.187-.218.251-.072.072-.148.15-.064.294.084.144.373.615.8 1.001.551.498 1.016.653 1.16.726.144.073.228.064.312-.033.084-.096.36-.419.456-.563.096-.144.192-.12.324-.072.131.048.837.395.981.467.144.073.24.108.275.168.036.06.036.348-.108.753z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.821.487 3.53 1.338 5L2 22l5.132-1.312A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167c-1.579 0-3.048-.445-4.295-1.216l-.308-.189-3.039.778.812-2.964-.207-.324A8.136 8.136 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167 4.503 0 8.167 3.664 8.167 8.167 0 4.503-3.664 8.167-8.167 8.167z"/></svg>
                        <span class="hidden xs:inline">WhatsApp</span>
                    </a>

                    <x-theme-toggle />
        </div>
    </div>
</header>

<script>
    function openMobileNav() {
        const backdrop = document.getElementById('mobile-nav-backdrop');
        const drawer = document.getElementById('mobile-nav-drawer');
        backdrop?.classList.remove('opacity-0', 'pointer-events-none');
        backdrop?.classList.add('opacity-100', 'pointer-events-auto');
        drawer?.classList.remove('translate-x-full');
        drawer?.classList.add('translate-x-0');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileNav() {
        const backdrop = document.getElementById('mobile-nav-backdrop');
        const drawer = document.getElementById('mobile-nav-drawer');
        backdrop?.classList.remove('opacity-100', 'pointer-events-auto');
        backdrop?.classList.add('opacity-0', 'pointer-events-none');
        drawer?.classList.remove('translate-x-0');
        drawer?.classList.add('translate-x-full');
        document.body.style.overflow = '';
    }

    function toggleMobileAccordion(id, btn) {
        const el = document.getElementById(id);
        const icon = btn?.querySelector('svg');
        if (el) {
            const isHidden = el.classList.toggle('hidden');
            if (btn) {
                btn.setAttribute('aria-expanded', !isHidden ? 'true' : 'false');
            }
            if (icon) {
                icon.classList.toggle('rotate-180', !isHidden);
            }
        }
    }
</script>
