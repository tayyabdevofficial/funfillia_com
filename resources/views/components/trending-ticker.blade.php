@props(['topics' => []])

@if(!empty($topics) && count($topics) > 0)
<div class="border-b border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 text-xs py-2 px-4 sm:px-8">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 overflow-hidden flex-1">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold tracking-wider uppercase bg-gradient-to-r from-rose-500 to-indigo-600 text-white shrink-0 shadow-sm animate-pulse">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.527.82-1.17 2.13-1.605 3.328-1.04 2.85-2.023 5.485-3.084 6.643C4.84 13.687 4 14.73 4 16a4 4 0 008 0c0-1.27-.84-2.313-1.434-2.98-.59-.663-1.15-1.745-1.63-3.14-.388-1.134-.78-2.353-1.18-3.328.69.96 1.48 1.95 2.37 2.87.26.27.7.27.96 0 .27-.27.27-.71 0-.98-1.2-1.24-2.23-2.6-2.92-3.88.2-.18.42-.35.65-.5.95-.63 2.18-.84 3.38-.41a1 1 0 001.2-1.09z" clip-rule="evenodd"/>
                </svg>
                Trending
            </span>

            <div class="relative overflow-hidden whitespace-nowrap w-full">
                <div class="inline-flex items-center gap-6 animate-[marquee_25s_linear_infinite] hover:[animation-play-state:paused]">
                    @foreach($topics as $topic)
                        <a href="{{ route('search', ['q' => is_array($topic) ? ($topic['name'] ?? $topic['title'] ?? '') : (string)$topic]) }}" 
                           class="text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors flex items-center gap-2">
                            <span>#{{ is_array($topic) ? ($topic['name'] ?? $topic['title'] ?? '') : (string)$topic }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="hidden sm:flex items-center text-slate-500 dark:text-slate-400 font-medium shrink-0">
            {{ now()->format('l, M j, Y') }}
        </div>
    </div>
</div>
@endif
