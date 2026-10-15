@props(['blog' => [], 'type' => 'grid', 'rank' => null])

@php
    $title = $blog['title'] ?? 'Untitled Story';
    $slug = $blog['slug'] ?? '#';
    $detailUrl = route('blog.show', $slug);
    $date = blogger_format_date($blog['published_at'] ?? $blog['created_at'] ?? null);
    $category = $blog['category']['name'] ?? 'General';
    $categorySlug = $blog['category']['slug'] ?? null;
    $commentsCount = $blog['active_comments_count'] ?? $blog['comments_count'] ?? 0;
    
    // Views count
    $viewsCount = $blog['views_count'] ?? (is_array($blog['views'] ?? null) ? count($blog['views']) : ($blog['views'] ?? 0));
    
    // Resolve image via proxy helper
    $rawImage = $blog['image_400x300'] ?? $blog['image_850x500'] ?? $blog['image_url'] ?? $blog['thumbnail'] ?? null;
    $cardWidth = ($type === 'horizontal' || $type === 'featured') ? 800 : ($type === 'compact' ? 150 : 500);
    $imageUrl = blogger_media_url($rawImage, '/images/placeholder.svg', $cardWidth);
@endphp

@if($type === 'compact')
    <!-- Compact horizontal card for Recent Stories & Sidebars -->
    <a href="{{ $detailUrl }}" 
       class="group flex items-center gap-3.5 p-2 rounded-2xl hover:bg-slate-100/80 dark:hover:bg-slate-800/70 transition-colors">
        <img src="{{ $imageUrl }}" alt="{{ $title }}" loading="lazy" decoding="async" width="64" height="64" class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-xl object-cover bg-slate-200 dark:bg-slate-800 shadow-xs group-hover:scale-105 transition-transform duration-300">
        <div class="flex-1 min-w-0">
            @if($categorySlug)
                <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-indigo-700 dark:text-indigo-400 mb-0.5">
                    {{ $category }}
                </span>
            @endif
            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                {{ $title }}
            </p>
            <p class="flex items-center gap-2 text-[11px] text-slate-600 dark:text-slate-300 mt-1">
                <span>{{ $date }}</span>
                @if($viewsCount > 0)
                    <span>&bull; {{ number_format((int)$viewsCount) }} views</span>
                @endif
            </p>
        </div>
    </a>

@elseif($type === 'numbered')
    <!-- Numbered item for Today's Top trending ranking -->
    <a href="{{ $detailUrl }}"
       class="group flex items-start gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/50 shadow-xs hover:shadow-md transition-all duration-200">
        <div class="text-3xl font-black text-slate-500 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors w-9 shrink-0 text-center font-mono">
            {{ sprintf('%02d', $rank ?? 1) }}
        </div>
        <div class="flex-1 min-w-0">
            @if($categorySlug)
                <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-rose-700 dark:text-rose-400 mb-1">
                    {{ $category }}
                </span>
            @endif
            <p class="text-sm font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                {{ $title }}
            </p>
            <p class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300 mt-2">
                <span>{{ $date }}</span>
                <span>&bull; {{ number_format((int)$viewsCount) }} views</span>
            </p>
        </div>
    </a>

@elseif($type === 'horizontal')
    <!-- Full-width Horizontal Featured Card -->
    <a href="{{ $detailUrl }}"
       class="group bg-white dark:bg-slate-800/80 rounded-3xl border border-slate-200/80 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 grid grid-cols-1 md:grid-cols-12 gap-0">
        <div class="md:col-span-5 relative aspect-[16/10] md:aspect-auto overflow-hidden bg-slate-100 dark:bg-slate-800">
            <img src="{{ $imageUrl }}" alt="{{ $title }}" loading="lazy" decoding="async" width="400" height="250" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @if($categorySlug)
                <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-indigo-700 dark:text-indigo-400 shadow-xs">
                    {{ $category }}
                </span>
            @endif
        </div>
        <div class="md:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 text-xs text-slate-600 dark:text-slate-300 mb-2">
                    <span>{{ $date }}</span>
                    <span>&bull; {{ number_format((int)$viewsCount) }} views</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug mb-3">
                    {{ $title }}
                </h3>
                @if(!empty($blog['short_description']))
                    <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed">
                        {{ $blog['short_description'] }}
                    </p>
                @endif
            </div>

            <div class="flex items-center justify-between pt-6 mt-4 border-t border-slate-100 dark:border-slate-700/60">
                <span class="text-xs text-slate-600 dark:text-slate-300">{{ $commentsCount }} comments</span>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 group-hover:translate-x-1 transition-transform">
                    Read Story &rarr;
                </span>
            </div>
        </div>
    </a>

@else
    <!-- Standard Grid Card -->
    <a href="{{ $detailUrl }}"
       class="group bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
        <!-- Thumbnail -->
        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
            <img src="{{ $imageUrl }}" alt="{{ $title }}" loading="lazy" decoding="async" width="400" height="250" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @if($categorySlug)
                <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-indigo-700 dark:text-indigo-400 shadow-xs">
                    {{ $category }}
                </span>
            @endif
        </div>

        <!-- Content Body -->
        <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300 mb-2.5">
                    <span>{{ $date }}</span>
                    <span>&bull;</span>
                    <span>{{ number_format((int)$viewsCount) }} views</span>
                </div>

                <p class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2 leading-snug mb-3">
                    {{ $title }}
                </p>

                @if(!empty($blog['short_description']))
                    <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-2 leading-relaxed mb-4">
                        {{ $blog['short_description'] }}
                    </p>
                @endif
            </div>

            <!-- Footer Meta -->
            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700/60 text-xs">
                <span class="text-slate-600 dark:text-slate-300">
                    {{ $commentsCount }} comments
                </span>

                <span class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 dark:text-indigo-400 group-hover:translate-x-1 transition-transform">
                    Read &rarr;
                </span>
            </div>
        </div>
    </a>
@endif
