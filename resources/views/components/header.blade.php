@props(['categories' => [], 'trendingTopics' => []])

<header class="sticky top-0 z-40 w-full transition-colors duration-200">
    <!-- Trending topics bar -->
    <x-trending-ticker :topics="$trendingTopics" />

    <!-- Main Navigation Bar -->
    <nav class="backdrop-blur-md bg-white/90 dark:bg-slate-900/90 border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Funfillia" class="h-12 w-auto object-contain rounded-xl group-hover:scale-105 transition-transform duration-200">
                    </a>
                </div>

                <!-- Desktop Category Navigation -->
                <div class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="{{ route('home') }}" 
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50' : 'text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        Home
                    </a>

                    @foreach(collect($categories)->take(6) as $category)
                        @php
                            $subCats = $category['sub_categories'] ?? [];
                            $hasSubs = !empty($subCats) && count($subCats) > 0;
                            $isActive = request()->is('category/' . ($category['slug'] ?? ''));
                        @endphp

                        @if($hasSubs)
                            <div class="relative group">
                                <a href="{{ route('category.show', $category['slug'] ?? '#') }}" 
                                   class="px-3.5 py-2 rounded-xl text-sm font-semibold inline-flex items-center gap-1.5 transition-all {{ $isActive ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50' : 'text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                    <span>{{ $category['name'] }}</span>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </a>

                                <!-- Dropdown menu (Without "All in category") -->
                                <div class="absolute left-0 top-full pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 w-52">
                                    <div class="rounded-2xl bg-white dark:bg-slate-800 shadow-xl border border-slate-200 dark:border-slate-700 p-2 space-y-1">
                                        @foreach($subCats as $sub)
                                            <a href="{{ route('subcategory.show', $sub['slug'] ?? '#') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-700/60 transition-colors">
                                                {{ $sub['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('category.show', $category['slug'] ?? '#') }}" 
                               class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ $isActive ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50' : 'text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                {{ $category['name'] }}
                            </a>
                        @endif
                    @endforeach
                </div>

                <!-- Right Actions: Search trigger, Theme toggle, Mobile button -->
                <div class="flex items-center gap-2.5">
                    <!-- Search Trigger Button -->
                    <button type="button" 
                            onclick="document.getElementById('search-modal').classList.remove('hidden'); document.getElementById('modal-search-input')?.focus();"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400 text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="hidden md:inline">Search...</span>
                        <kbd class="hidden md:inline-block px-1.5 py-0.5 text-[10px] font-mono bg-white dark:bg-slate-900 rounded border border-slate-200 dark:border-slate-700 text-slate-400">⌘K</kbd>
                    </button>

                    <!-- Theme Toggle Switch -->
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
            <a href="{{ route('home') }}" class="flex items-center gap-2" onclick="closeMobileNav()">
                <img src="{{ asset('images/logo.png') }}" alt="Funfillia" class="h-10 w-auto object-contain">
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
            <a href="{{ route('home') }}" 
               onclick="closeMobileNav()"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-sm text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Home</span>
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
            el.classList.toggle('hidden');
            if (icon) {
                icon.classList.toggle('rotate-180');
            }
        }
    }
</script>
