<div id="search-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <!-- Backdrop with blur -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('search-modal').classList.add('hidden')"></div>

    <div class="min-h-screen px-4 text-center flex items-center justify-center py-12">
        <div class="relative w-full max-w-2xl transform overflow-hidden rounded-3xl bg-white dark:bg-slate-900 p-6 text-left shadow-2xl transition-all border border-slate-200 dark:border-slate-800">
            <!-- Modal Header / Search Form -->
            <form action="{{ route('search') }}" method="GET" class="relative">
                <div class="relative flex items-center">
                    <svg class="pointer-events-none absolute left-4 h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="search" 
                           name="q" 
                           id="modal-search-input"
                           placeholder="Search articles, recipes, guides, fashion..." 
                           class="w-full rounded-2xl bg-slate-100 dark:bg-slate-800 py-4 pl-12 pr-28 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium text-lg border-0">
                    <button type="submit" class="absolute right-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition-colors">
                        Search
                    </button>
                </div>
            </form>

            <!-- Quick Suggestions -->
            <div class="mt-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3">Popular Searches</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('search', ['q' => 'Recipes']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors">
                        🍳 Recipes
                    </a>
                    <a href="{{ route('search', ['q' => 'Biryani']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors">
                        🍚 Biryani
                    </a>
                    <a href="{{ route('search', ['q' => 'Fashion']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors">
                        👗 Fashion
                    </a>
                    <a href="{{ route('search', ['q' => 'Tips']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors">
                        💡 Tips &amp; Tricks
                    </a>
                    <a href="{{ route('search', ['q' => 'Vegetables']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors">
                        🥦 Vegetables
                    </a>
                </div>
            </div>

            <!-- Footer Hint -->
            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400">
                <span>Press <kbd class="px-1.5 py-0.5 rounded bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-mono">ESC</kbd> to close</span>
                <span>Press <kbd class="px-1.5 py-0.5 rounded bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-mono">↵ Enter</kbd> to search</span>
            </div>
        </div>
    </div>
</div>
