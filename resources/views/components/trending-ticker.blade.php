@props(['topics' => []])

<div class="bg-slate-950 text-slate-300 border-b border-slate-800 text-xs py-2 px-4 sm:px-8 relative z-30 shadow-sm select-none">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        <!-- Left: Live Date & Digital Edition -->
        <div class="flex items-center gap-3 shrink-0">
            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-slate-300">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="hidden md:inline text-slate-400">Funfillia Daily Edition &bull;</span>
                <span class="font-semibold text-slate-200">{{ now()->format('l, F j, Y') }}</span>
            </span>
        </div>

        <!-- Center / Action: Interactive "Surprise Me!" Story Discovery -->
        <div class="flex items-center justify-center">
            <a href="{{ route('blog.random') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold bg-indigo-500/15 hover:bg-indigo-500/25 text-indigo-300 hover:text-white border border-indigo-500/30 transition-all duration-200 shadow-sm hover:scale-105 active:scale-95 group">
                <span class="group-hover:rotate-180 transition-transform duration-300 inline-block">🎲</span>
                <span>Surprise Me!</span>
                <span class="text-[10px] text-indigo-400/80 hidden sm:inline">&mdash; Random Story</span>
            </a>
        </div>

        <!-- Right: Quick Links -->
        <div class="flex items-center gap-4 shrink-0">
            <div class="hidden sm:flex items-center gap-3 text-xs text-slate-400 font-medium">
                <a href="{{ route('pages.about') }}" class="hover:text-white transition-colors">About</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('pages.contact') }}" class="hover:text-white transition-colors">Contact</a>
            </div>
        </div>
    </div>
</div>
