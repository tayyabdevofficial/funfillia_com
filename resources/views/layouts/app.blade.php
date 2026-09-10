<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Instant Zero-Flicker Dark/Light Theme Script -->
    <script>
        (function() {
            try {
                const storedTheme = localStorage.getItem('funfillia_theme');
                if (storedTheme === 'dark' || (!storedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    <!-- SEO Meta Tags & Social Cards -->
    @php
        $hasCustomMeta = !empty($metaTags);
        $hasCustomTitle = $hasCustomMeta && preg_match('/<title[\s>]/i', $metaTags);
        $hasCustomDesc = $hasCustomMeta && preg_match('/name=["\']description["\']/i', $metaTags);
        $hasCustomOgImage = $hasCustomMeta && preg_match('/property=["\']og:image["\']/i', $metaTags);
    @endphp

    @if(!$hasCustomTitle)
        <title>@yield('title', $siteTitle ?? 'Funfillia - Entertainment, Humor & Viral Culture')</title>
    @endif

    @if(!$hasCustomDesc)
        <meta name="description" content="@yield('meta_description', $siteDescription ?? 'Discover viral entertainment, hilarious challenges, party games, pop trends, and creative digital stories on Funfillia.')">
    @endif

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Dynamic Admin Meta Tags Injection (Takes Full Priority) -->
    {!! $metaTags ?? '' !!}

    <!-- Fallback Open Graph & Social Cards (Only if not supplied by Admin Meta Tags) -->
    @if(!$hasCustomMeta || !preg_match('/property=["\']og:title["\']/i', $metaTags))
        <meta property="og:title" content="@yield('title', $siteTitle ?? 'Funfillia - Entertainment, Humor & Viral Culture')">
    @endif
    @if(!$hasCustomMeta || !preg_match('/property=["\']og:description["\']/i', $metaTags))
        <meta property="og:description" content="@yield('meta_description', $siteDescription ?? 'Discover viral entertainment, hilarious challenges, party games, pop trends, and creative digital stories on Funfillia.')">
    @endif
    @if(!$hasCustomMeta || !preg_match('/property=["\']og:url["\']/i', $metaTags))
        <meta property="og:url" content="{{ url()->current() }}">
    @endif
    @if(!$hasCustomMeta || !preg_match('/property=["\']og:type["\']/i', $metaTags))
        <meta property="og:type" content="@yield('og_type', 'website')">
    @endif
    @if(!$hasCustomOgImage)
        <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
    @endif
    @if(!$hasCustomMeta || !preg_match('/name=["\']twitter:card["\']/i', $metaTags))
        <meta name="twitter:card" content="summary_large_image">
    @endif

    <!-- Multi-Device Favicons & Manifest -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#6366f1">

    <!-- Global AdSense & AMP Auto-Ads Head Scripts -->
    @if($adsEnabled ?? false)
        {!! $websiteAds['head_script'] ?? '' !!}
        {!! $websiteAds['amp_head_script'] ?? '' !!}
    @endif

    @yield('extra_head')

    <!-- Fonts & Vite Assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 min-h-screen flex flex-col font-sans transition-colors duration-200 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- AMP Auto-Ads Body Tag Injection -->
    @if(($adsEnabled ?? false) && !empty($websiteAds['amp_body_code']))
        {!! $websiteAds['amp_body_code'] !!}
    @endif

    <!-- Reading Progress Bar (for article detail pages) -->
    <div id="reading-progress-bar" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-rose-500 via-purple-500 to-indigo-600 z-50 transition-all duration-75 w-0 pointer-events-none"></div>

    <!-- Header Navigation -->
    <x-header :categories="$allCategories ?? []" :trendingTopics="$trendingTopics ?? []" />

    <!-- Top Header Ad Placement -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <x-ad-banner placement="header" />
    </div>

    <!-- Main Content Area -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Global Search Modal (Ctrl+K) -->
    <x-search-modal />

    <!-- Footer Ad Placement -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <x-ad-banner placement="footer" />
    </div>

    <!-- Footer -->
    <x-footer :categories="$allCategories ?? []" />

    <!-- Cookie Consent Banner -->
    <x-cookie-consent />

    <!-- Floating Back to Top Button -->
    <button type="button" 
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            id="back-to-top"
            aria-label="Back to top"
            class="fixed bottom-6 left-6 z-40 p-3 rounded-full bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 shadow-xl border border-slate-200 dark:border-slate-700 hover:scale-110 transition-all duration-300 opacity-0 pointer-events-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script>
        window.addEventListener('scroll', () => {
            const btn = document.getElementById('back-to-top');
            if (btn) {
                if (window.scrollY > 400) {
                    btn.classList.remove('opacity-0', 'pointer-events-none');
                    btn.classList.add('opacity-100');
                } else {
                    btn.classList.remove('opacity-100');
                    btn.classList.add('opacity-0', 'pointer-events-none');
                }
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
