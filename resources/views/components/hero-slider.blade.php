@props(['blogs' => []])

@if(!empty($blogs) && count($blogs) > 0)
    @php
        $mainHero = $blogs[0];
        $secondaryHeroes = array_slice($blogs, 1, 2);
    @endphp

    <section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Main Spotlight Hero (takes 8 cols on lg) -->
            @php
                $mainImage1150 = !empty($mainHero['image_1150x900']) ? blogger_media_url($mainHero['image_1150x900'], '/images/placeholder.svg', 1150) : null;
                $mainImage850  = !empty($mainHero['image_850x500']) ? blogger_media_url($mainHero['image_850x500'], '/images/placeholder.svg', 850) : null;
                $mainImage500  = !empty($mainHero['image_500x500']) ? blogger_media_url($mainHero['image_500x500'], '/images/placeholder.svg', 500) : (!empty($mainHero['image_400x300']) ? blogger_media_url($mainHero['image_400x300'], '/images/placeholder.svg', 500) : null);
                $mainImageDefault = $mainImage850 ?: ($mainImage1150 ?: blogger_media_url($mainHero['image_url'] ?? null, '/images/placeholder.svg', 850));
                $mainTitle = $mainHero['title'] ?? '';
                $mainSlug = $mainHero['slug'] ?? '#';
                $mainDetailUrl = route('blog.show', $mainSlug);
                $mainCat = $mainHero['category']['name'] ?? 'Spotlight';
                $mainCatSlug = $mainHero['category']['slug'] ?? null;
                $mainDate = blogger_format_date($mainHero['published_at'] ?? null);
                $mainViews = $mainHero['views_count'] ?? (is_array($mainHero['views'] ?? null) ? count($mainHero['views']) : ($mainHero['views'] ?? 0));
            @endphp
            <div onclick="window.location.href='{{ $mainDetailUrl }}'" 
                 style="aspect-ratio: 16/10;"
                 class="lg:col-span-8 relative rounded-3xl overflow-hidden aspect-[16/10] sm:aspect-[16/9] shadow-2xl group cursor-pointer shimmer-loading bg-slate-900">

                <picture class="absolute inset-0 w-full h-full">
                    @if($mainImage500)
                        <source media="(max-width: 640px)" srcset="{{ $mainImage500 }}">
                    @endif
                    @if($mainImage850)
                        <source media="(max-width: 1024px)" srcset="{{ $mainImage850 }}">
                    @endif
                    <img src="{{ $mainImageDefault }}" 
                         alt="{{ $mainTitle }}" 
                         fetchpriority="high"
                         decoding="async"
                         width="850"
                         height="500"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                </picture>
                
                <!-- Rich Dark Gradient Overlay for optimal readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>

                <div class="absolute inset-0 p-6 sm:p-10 flex flex-col justify-between">
                    <!-- Top Category & Badges -->
                    <div class="flex items-center gap-2">
                        @if($mainCatSlug)
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-rose-600 text-white shadow-lg backdrop-blur-md">
                                {{ $mainCat }}
                            </span>
                        @endif
                    </div>

                    <!-- Bottom Content -->
                    <div class="space-y-3 max-w-2xl">
                        <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight tracking-tight group-hover:text-rose-300 transition-colors drop-shadow-md">
                            {{ $mainTitle }}
                        </h2>

                        @if(!empty($mainHero['short_description']))
                            <p class="text-sm sm:text-base text-slate-300 line-clamp-2 leading-relaxed hidden sm:block">
                                {{ $mainHero['short_description'] }}
                            </p>
                        @endif

                        <div class="flex items-center gap-3 text-xs sm:text-sm text-slate-300 font-medium">
                            <span>{{ $mainDate }}</span>
                            @if($mainViews > 0)
                                <span>&bull;</span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>{{ number_format((int)$mainViews) }} {{ Str::plural('view', (int)$mainViews) }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Featured Cards (4 cols on lg) -->
            <div class="lg:col-span-4 flex flex-col gap-6 justify-between">
                @foreach($secondaryHeroes as $hero)
                    @php
                        $subImage = blogger_media_url($hero['image_400x300'] ?? $hero['image_500x500'] ?? $hero['image_url'] ?? null, '/images/placeholder.svg', 500);
                        $subTitle = $hero['title'] ?? '';
                        $subSlug = $hero['slug'] ?? '#';
                        $subDetailUrl = route('blog.show', $subSlug);
                        $subCat = $hero['category']['name'] ?? 'Trending';
                        $subCatSlug = $hero['category']['slug'] ?? null;
                        $subDate = blogger_format_date($hero['published_at'] ?? null);
                        $subViews = $hero['views_count'] ?? (is_array($hero['views'] ?? null) ? count($hero['views']) : ($hero['views'] ?? 0));
                    @endphp

                    <div onclick="window.location.href='{{ $subDetailUrl }}'"
                         class="relative flex-1 rounded-3xl overflow-hidden shadow-lg group aspect-[16/9] lg:aspect-auto cursor-pointer shimmer-loading bg-slate-900">
                        <img src="{{ $subImage }}" alt="{{ $subTitle }}" decoding="async" width="400" height="250" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            @if($subCatSlug)
                                <span class="self-start px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-indigo-600 text-white mb-2 shadow-sm">
                                    {{ $subCat }}
                                </span>
                            @endif
                            <h3 class="text-base sm:text-lg font-bold text-white leading-snug line-clamp-2 group-hover:text-indigo-300 transition-colors">
                                {{ $subTitle }}
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-slate-200 mt-2">
                                <span>{{ $subDate }}</span>
                                @if($subViews > 0)
                                    <span>&bull;</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ number_format((int)$subViews) }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
