@extends('layouts.app')

@php
    $title = $blog['title'] ?? 'Article';
    $shortDesc = $blog['short_description'] ?? '';
    $category = $blog['category']['name'] ?? 'General';
    $categorySlug = $blog['category']['slug'] ?? null;
    $subCategory = $blog['sub_category']['name'] ?? null;
    $subCategorySlug = $blog['sub_category']['slug'] ?? null;
    $publishedDate = blogger_format_date($blog['published_at'] ?? $blog['created_at'] ?? null);
    $comments = $blog['active_comments'] ?? [];
    $rawImage = $blog['image_1150x900'] ?? $blog['image_850x500'] ?? $blog['image_url'] ?? null;
    $imageUrl = blogger_media_url($rawImage);
@endphp

@section('title', ($seoData['meta_title'] ?? $title) . ' - Funfillia')
@section('meta_description', $seoData['meta_description'] ?? ($shortDesc ?: 'Read ' . $title . ' on Funfillia.'))
@section('og_image', $imageUrl)
@section('og_type', 'article')

@section('content')
<article class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-6 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a>
        <span>&rsaquo;</span>
        @if($categorySlug)
            <a href="{{ route('category.show', $categorySlug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ $category }}</a>
            <span>&rsaquo;</span>
        @endif
        @if($subCategory && $subCategorySlug)
            <a href="{{ route('subcategory.show', $subCategorySlug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ $subCategory }}</a>
            <span>&rsaquo;</span>
        @endif
        <span class="text-slate-800 dark:text-slate-200 font-semibold line-clamp-1 max-w-xs sm:max-w-md">{{ $title }}</span>
    </nav>

    <!-- Article Header (Author & Read Time removed) -->
    <div class="max-w-4xl mx-auto text-center space-y-4 mb-10">
        @if($categorySlug)
            <a href="{{ route('category.show', $categorySlug) }}" class="inline-block px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800 shadow-sm">
                {{ $category }}
            </a>
        @endif

        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
            {{ $title }}
        </h1>

        @if(!empty($shortDesc))
            <p class="text-base sm:text-xl text-slate-600 dark:text-slate-300 font-normal leading-relaxed max-w-2xl mx-auto">
                {{ $shortDesc }}
            </p>
        @endif

        <!-- Date & Views Meta -->
        <div class="flex items-center justify-center gap-4 text-xs sm:text-sm text-slate-400 pt-3 flex-wrap">
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $publishedDate }}</span>
            </span>
            @php
                $displayViews = $views ?? ($blog['views_count'] ?? 0);
            @endphp
            @if($displayViews > 0)
                <span>&bull;</span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>{{ number_format($displayViews) }} {{ Str::plural('view', (int)$displayViews) }}</span>
                </span>
            @endif
        </div>
    </div>

    <!-- Featured Image with Shimmer -->
    <div class="max-w-5xl mx-auto mb-12 rounded-3xl overflow-hidden shadow-2xl shimmer-loading bg-slate-100 dark:bg-slate-800 aspect-[16/9]">
        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="w-full h-full object-cover">
    </div>

    <!-- Main Content Layout (Article + Sidebar) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 max-w-6xl mx-auto">
        
        <!-- Social Share Column (Left Sticky on Desktop) -->
        <div class="lg:col-span-1 hidden lg:block">
            <div class="sticky top-28 flex flex-col items-center gap-3">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Share</span>
                
                <!-- Twitter / X -->
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($title) }}" target="_blank" rel="noopener" class="p-2.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-black hover:text-white transition-all shadow-sm" title="Share on X">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="p-2.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Share on Facebook">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                
                <!-- WhatsApp -->
                <a href="https://api.whatsapp.com/send?text={{ urlencode($title . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="p-2.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-emerald-500 hover:text-white transition-all shadow-sm" title="Share on WhatsApp">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                </a>
                
                <!-- Copy Link Button -->
                <button type="button" onclick="copyArticleLink()" class="p-2.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Copy Link">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </button>
            </div>
        </div>

        <!-- Article Body Column (7 cols on lg) -->
        <div class="lg:col-span-8 space-y-10">
            <!-- Main HTML Content -->
            <div class="prose-content">
                {!! $blog['content'] ?? '' !!}
            </div>

            <!-- In-Article Horizontal Ad -->
            <x-ad-banner placement="horizontal_ad" />

            <!-- Tags -->
            @php
                $tags = !empty($blog['tags_array']) ? $blog['tags_array'] : (is_array($blog['tags'] ?? null) ? $blog['tags'] : explode(',', $blog['tags'] ?? ''));
                $tags = array_filter(array_map('trim', $tags));
            @endphp
            @if(!empty($tags))
                <div class="pt-6 border-t border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-3">Tags:</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('search', ['q' => $tag]) }}" class="px-3 py-1 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Previous & Next Story Navigation -->
            @if(!empty($previousBlog) || !empty($nextBlog))
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-8 border-t border-slate-200 dark:border-slate-800">
                    @if(!empty($previousBlog))
                        <a href="{{ route('blog.show', $previousBlog['slug']) }}" class="p-4 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-800 hover:border-indigo-500 transition-all group">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">&larr; Previous Article</span>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 line-clamp-2">{{ $previousBlog['title'] }}</h4>
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if(!empty($nextBlog))
                        <a href="{{ route('blog.show', $nextBlog['slug']) }}" class="p-4 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-800 hover:border-indigo-500 transition-all group sm:text-right">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Next Article &rarr;</span>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 line-clamp-2">{{ $nextBlog['title'] }}</h4>
                        </a>
                    @endif
                </div>
            @endif

            <!-- Comments Section -->
            @if($blog['allow_comments'] ?? true)
                <section class="pt-10 border-t border-slate-200 dark:border-slate-800 space-y-8" id="comments">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span>Discussion</span>
                            <span id="comments-badge" class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 dark:bg-indigo-900/60 text-indigo-600 dark:text-indigo-400">
                                {{ count($comments) }}
                            </span>
                        </h3>
                    </div>

                    <!-- Dynamic AJAX Status Alert -->
                    <div id="comment-alert" class="hidden p-4 rounded-2xl text-sm font-semibold transition-all"></div>

                    <!-- Comment Form with Custom Captcha & AJAX -->
                    <form id="comment-form" action="{{ route('blog.comment', $blog['slug']) }}" method="POST" class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-5 shadow-sm">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog['id'] }}">

                        <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                            <h4 class="text-base font-bold text-slate-900 dark:text-white">Leave a Response</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Your email address will not be published.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Your Name *</label>
                                <input type="text" name="full_name" required placeholder="Jane Doe" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address *</label>
                                <input type="email" name="email" required placeholder="jane@example.com" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Your Comment *</label>
                            <textarea name="description" rows="4" required placeholder="Write your thoughts..." class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>

                        <!-- Custom Security Captcha -->
                        <div class="p-4 rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                    🛡
                                </span>
                                <div>
                                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">Security Verification</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">Calculate: <strong class="text-indigo-600 dark:text-indigo-400 font-mono text-sm">{{ $captchaQuestion ?? '5 + 3' }} = ?</strong></span>
                                </div>
                            </div>
                            <div class="w-full sm:w-36">
                                <input type="number" 
                                       name="captcha" 
                                       required 
                                       placeholder="Your answer" 
                                       class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 border border-indigo-200 dark:border-indigo-800 text-sm text-center font-mono font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <button type="submit" 
                                id="comment-submit-btn"
                                class="px-7 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-700 hover:to-rose-700 text-white font-bold text-xs sm:text-sm shadow-md transition-all flex items-center gap-2">
                            <span>Post Comment</span>
                        </button>
                    </form>

                    <!-- Existing Comments Container -->
                    <div id="comments-list" class="space-y-4">
                        @foreach($comments as $comment)
                            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 space-y-2 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-indigo-500 text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                            {{ strtoupper(substr($comment['full_name'] ?? 'A', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $comment['full_name'] }}</span>
                                    </div>
                                    <span class="text-xs text-slate-400">{{ blogger_format_date($comment['created_at'] ?? null) }}</span>
                                </div>
                                <p class="text-sm text-slate-600 dark:text-slate-300 pl-9 leading-relaxed">
                                    {{ $comment['description'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        <!-- Sidebar Column (3 cols on lg) -->
        <aside class="lg:col-span-3">
            <div class="lg:sticky lg:top-28 space-y-6">
                <!-- Enhanced Non-Transparent Table of Contents Widget -->
                <div id="table-of-contents-wrapper" class="rounded-3xl bg-white dark:bg-slate-900 p-5 border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 ring-4 ring-indigo-500/20"></span>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">On This Page</h4>
                        </div>
                        <span class="text-[10px] font-semibold uppercase px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400">Quick Nav</span>
                    </div>
                    <ul id="table-of-contents-list" class="space-y-1 max-h-[300px] overflow-y-auto scroll-smooth pr-1 text-sm border-l-2 border-slate-100 dark:border-slate-800 pl-2">
                        <!-- Dynamically generated TOC -->
                    </ul>
                </div>

                <!-- Sidebar Vertical Display Ad -->
                <x-ad-banner placement="vertical_ad" />

                <!-- Recent Stories Widget (Reduced thumbnail size and clean title) -->
                @if(!empty($recentBlogs) && count($recentBlogs) > 0)
                    <div class="rounded-3xl bg-white dark:bg-slate-900 p-5 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 ring-4 ring-rose-500/20"></span>
                            <h4 class="text-sm font-black text-slate-900 dark:text-white tracking-tight">Recent Stories</h4>
                        </div>
                        <div class="space-y-2 divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach(collect($recentBlogs)->take(4) as $rec)
                                <x-blog-card :blog="$rec" type="compact" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Sidebar Multiplex Grid Ad -->
                <x-ad-banner placement="vertical_multiplex" />
            </div>
        </aside>
    </div>

    <!-- Bottom Horizontal Multiplex Ad -->
    <div class="max-w-6xl mx-auto pt-8">
        <x-ad-banner placement="horizontal_multiplex" />
    </div>

    <!-- Related Articles Grid -->
    @if(!empty($relatedBlogs) && count($relatedBlogs) > 0)
        <section class="max-w-6xl mx-auto pt-16 border-t border-slate-200 dark:border-slate-800 mt-16">
            <div class="mb-8">
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">You Might Also Like</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white">Related Stories</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach(collect($relatedBlogs)->take(4) as $rel)
                    <x-blog-card :blog="$rel" type="grid" />
                @endforeach
            </div>
        </section>
    @endif
</article>
@endsection

@section('scripts')
<script>
    document.getElementById('comment-form')?.addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        const btn = document.getElementById('comment-submit-btn');
        const alertBox = document.getElementById('comment-alert');
        const commentsList = document.getElementById('comments-list');
        const badge = document.getElementById('comments-badge');
        
        btn.disabled = true;
        btn.innerHTML = '<span>Posting comment...</span>';
        alertBox.classList.add('hidden');

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(async (res) => {
            const data = await res.json();
            btn.disabled = false;
            btn.innerHTML = '<span>Post Comment</span>';

            if (res.ok && (data.success !== false)) {
                // Success alert
                alertBox.className = 'p-4 rounded-2xl text-sm font-semibold bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400';
                alertBox.textContent = '✓ ' + (data.message || 'Comment posted successfully!');
                alertBox.classList.remove('hidden');

                // Prepend comment card dynamically
                if (data.comment) {
                    const newCard = document.createElement('div');
                    newCard.className = 'p-5 rounded-2xl bg-emerald-50/50 dark:bg-slate-900 border border-emerald-200 dark:border-emerald-800 space-y-2 shadow-sm animate-fade-in';
                    newCard.innerHTML = `
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold">
                                    ${(data.comment.full_name || 'A').charAt(0).toUpperCase()}
                                </div>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">${data.comment.full_name}</span>
                            </div>
                            <span class="text-xs text-slate-400">Just now</span>
                        </div>
                        <p class="text-sm text-slate-600 dark:text-slate-300 pl-9 leading-relaxed">${data.comment.description}</p>
                    `;
                    commentsList.prepend(newCard);

                    if (badge) {
                        badge.textContent = parseInt(badge.textContent || '0') + 1;
                    }
                }

                form.reset();
            } else {
                // Error alert
                alertBox.className = 'p-4 rounded-2xl text-sm font-semibold bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400';
                alertBox.textContent = '✕ ' + (data.message || 'Failed to submit comment. Please check your inputs.');
                alertBox.classList.remove('hidden');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<span>Post Comment</span>';
            alertBox.className = 'p-4 rounded-2xl text-sm font-semibold bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400';
            alertBox.textContent = '✕ Network error. Please try again.';
            alertBox.classList.remove('hidden');
        });
    });
</script>
@endsection
