@extends('layouts.app')

@section('title', $siteTitle ?? 'Viral Quizzes & Friendship Challenges - Funfillia')
@section('meta_description', $siteDescription ?? 'Create your own friendship dare quiz, share with besties on WhatsApp, and see who truly knows you best!')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Viral Hero Section -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-600 via-pink-600 to-rose-500 text-white shadow-2xl p-8 sm:p-12 lg:p-16">
            <!-- Decorative blur shapes -->
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-yellow-400/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-black uppercase tracking-widest text-yellow-300 shadow-sm">
                    <span>🔥</span> Viral Friendship Dares & Fun Quizzes
                </div>
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                    How Well Do Your Besties <span class="underline decoration-yellow-400 decoration-wavy">Really</span> Know You?
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-white/90 leading-relaxed font-medium">
                    Answer fun personal questions, create your unique challenge link, and send it to your friends on WhatsApp. Watch them guess and discover your true soulmates!
                </p>
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="#quiz-list" class="px-6 py-3.5 rounded-2xl bg-white text-slate-900 font-black text-sm sm:text-base hover:bg-yellow-300 hover:scale-105 transition-all duration-200 shadow-lg inline-flex items-center gap-2">
                        <span>Pick a Quiz Below</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                    </a>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-white/80 bg-black/20 px-4 py-3 rounded-2xl backdrop-blur-sm">
                        <span>⚡ 100% Free & No Sign-up Needed</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3-Step How It Works -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-purple-500/50 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black text-xl mb-4">
                    1
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Answer Questions</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">Choose your favorite habits, secrets, and choices. You create the truth for your quiz!</p>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-pink-500/50 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-pink-100 dark:bg-pink-950/60 text-pink-600 dark:text-pink-400 flex items-center justify-center font-black text-xl mb-4">
                    2
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Share on WhatsApp</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">Get your personal share link and dare your friends or group chats to test their knowledge.</p>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:border-rose-500/50 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center font-black text-xl mb-4">
                    3
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Check Scoreboard</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">View real-time rankings and find out who got 100% Soulmate or who needs to hang out more!</p>
            </div>
        </div>

        <!-- Your Previously Created Dares & Challenges -->
        <div id="user-created-dares-section" class="{{ empty($myCreatedDares) ? 'hidden' : '' }} space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-100 dark:bg-pink-950/80 text-pink-600 dark:text-pink-400 text-xs font-black uppercase tracking-wider mb-1">
                        <span>✨</span> My Challenges
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Your Created Dares</h2>
                </div>
                <span class="text-xs font-bold text-slate-400" id="created-dares-count">
                    {{ count($myCreatedDares ?? []) }} Active
                </span>
            </div>

            <div id="created-dares-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($myCreatedDares ?? [] as $dare)
                    <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border-2 border-pink-500/30 hover:border-pink-500 shadow-sm hover:shadow-lg transition-all space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="text-3xl">{{ $dare['creator_avatar'] ?? '😎' }}</span>
                                <div>
                                    <div class="font-black text-sm text-slate-900 dark:text-white">{{ $dare['creator_name'] ?? 'You' }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $dare['created_at'] ?? 'Recently' }}</div>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-pink-100 dark:bg-pink-950 text-pink-600 dark:text-pink-400">
                                Live Dare
                            </span>
                        </div>

                        <div class="font-bold text-base text-slate-900 dark:text-white line-clamp-1">
                            {{ $dare['quiz_title'] ?? 'Friendship Dare' }}
                        </div>

                        <div class="flex items-center gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <a href="{{ route('quizzes.challenge.share', $dare['token']) }}" 
                               class="flex-1 py-2 px-3 rounded-xl bg-pink-600 hover:bg-pink-700 text-white text-xs font-bold text-center transition-colors shadow-sm">
                                📊 Scoreboard &amp; Share
                            </a>
                            <button type="button" 
                                    onclick="navigator.clipboard.writeText('{{ route('quizzes.challenge.take', $dare['token']) }}'); this.innerText = 'Copied! ✨'; setTimeout(() => this.innerText = 'Copy Link', 2000);"
                                    class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-colors">
                                Copy Link
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quizzes Grid -->
        <section id="quiz-list" class="space-y-6 pt-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Available Quizzes</h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Pick any quiz to start crafting your personalized challenge.</p>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 w-fit">
                    {{ count($quizzes) }} {{ \Illuminate\Support\Str::plural('Quiz', count($quizzes)) }} Available
                </span>
            </div>

            @if(empty($quizzes) || count($quizzes) === 0)
                <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 space-y-4">
                    <div class="text-5xl">🎉</div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Fresh Quizzes Dropping Soon!</h3>
                    <p class="text-slate-500 dark:text-slate-400 max-w-md mx-auto text-sm">
                        Our editors are cooking up exciting new dare challenges right now. Check back in a few moments!
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 transition-colors">
                        Back to Home
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($quizzes as $quiz)
                        <div class="group bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                            <!-- Image / Banner -->
                            <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-gradient-to-tr from-purple-500 to-pink-500">
                                @if(!empty($quiz['image_url']) || !empty($quiz['cover_image']))
                                    <img src="{{ blogger_media_url($quiz['image_url'] ?? $quiz['cover_image'] ?? null) }}" alt="{{ $quiz['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white/40 font-black text-5xl">
                                        ✨
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>

                                <!-- Badge -->
                                @if(!empty($quiz['badge']))
                                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-rose-500 text-white shadow-lg">
                                        {{ $quiz['badge'] }}
                                    </span>
                                @endif

                                <!-- Question Count Pill -->
                                <span class="absolute bottom-4 right-4 px-2.5 py-1 rounded-full text-xs font-bold bg-black/60 backdrop-blur-md text-white border border-white/20">
                                    {{ $quiz['questions_count'] ?? 0 }} Questions
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                <div class="space-y-2">
                                    <h3 class="text-xl font-black text-slate-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors leading-snug">
                                        {{ $quiz['title'] }}
                                    </h3>
                                    @if(!empty($quiz['description']))
                                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                            {{ $quiz['description'] }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Stats & CTA -->
                                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                        {{ number_format($quiz['challenges_count'] ?? 0) }} dares created
                                    </div>
                                    <a href="{{ route('quizzes.create', $quiz['slug']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white text-sm font-bold shadow-md hover:from-pink-600 hover:to-rose-600 hover:shadow-lg transition-all">
                                        <span>Start Dare</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</div>

<script>
    // Synchronize localStorage dares into the UI
    document.addEventListener('DOMContentLoaded', function() {
        try {
            const stored = JSON.parse(localStorage.getItem('funfillia_my_dares') || '[]');
            if (stored.length > 0) {
                const section = document.getElementById('user-created-dares-section');
                const grid = document.getElementById('created-dares-grid');
                const countBadge = document.getElementById('created-dares-count');

                // Get existing tokens from server rendered cards
                const existingTokens = Array.from(grid.querySelectorAll('a[href*="/quiz/challenge/"]'))
                    .map(a => {
                        const m = a.href.match(/challenge\/([^/]+)\/share/);
                        return m ? m[1] : '';
                    });

                let addedCount = 0;
                stored.forEach(dare => {
                    if (!existingTokens.includes(dare.token)) {
                        const card = document.createElement('div');
                        card.className = 'p-6 rounded-3xl bg-white dark:bg-slate-900 border-2 border-pink-500/30 hover:border-pink-500 shadow-sm hover:shadow-lg transition-all space-y-4';
                        card.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-3xl">${dare.creator_avatar || '😎'}</span>
                                    <div>
                                        <div class="font-black text-sm text-slate-900 dark:text-white">${dare.creator_name || 'You'}</div>
                                        <div class="text-[11px] text-slate-400">${dare.created_at || 'Recently'}</div>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-pink-100 dark:bg-pink-950 text-pink-600 dark:text-pink-400">
                                    Live Dare
                                </span>
                            </div>
                            <div class="font-bold text-base text-slate-900 dark:text-white line-clamp-1">
                                ${dare.quiz_title || 'Friendship Dare'}
                            </div>
                            <div class="flex items-center gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                                <a href="/quiz/challenge/${dare.token}/share" 
                                   class="flex-1 py-2 px-3 rounded-xl bg-pink-600 hover:bg-pink-700 text-white text-xs font-bold text-center transition-colors shadow-sm">
                                    📊 Scoreboard &amp; Share
                                </a>
                                <button type="button" 
                                        onclick="navigator.clipboard.writeText(window.location.origin + '/quiz/challenge/${dare.token}'); this.innerText = 'Copied! ✨'; setTimeout(() => this.innerText = 'Copy Link', 2000);"
                                        class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-colors">
                                    Copy Link
                                </button>
                            </div>
                        `;
                        grid.prepend(card);
                        addedCount++;
                    }
                });

                if (grid.children.length > 0) {
                    section.classList.remove('hidden');
                    countBadge.innerText = `${grid.children.length} Active`;
                }
            }
        } catch(e) {
            console.error('Error loading stored dares:', e);
        }
    });
</script>
@endsection
