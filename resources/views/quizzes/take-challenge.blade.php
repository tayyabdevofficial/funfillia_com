@extends('layouts.app')

@section('title', 'How Well Do You Know ' . ($challenge['creator_name'] ?? 'Your Friend') . '? - Dare Challenge - Funfillia')
@section('meta_description', ($challenge['creator_name'] ?? 'Your friend') . ' challenged you to guess their answers on ' . ($quiz['title'] ?? 'this quiz') . '! Can you score 100%?')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 py-8 sm:py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 space-y-8">

        <!-- Friend Welcome Hero Card -->
        <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-3xl text-white p-6 sm:p-10 shadow-2xl text-center relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-8 -bottom-8 w-40 h-40 bg-yellow-400/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 space-y-4">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-4xl shadow-inner animate-bounce">
                    {{ $challenge['creator_avatar'] ?? '😎' }}
                </div>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-black uppercase tracking-wider text-yellow-300">
                    <span>⚡</span> Dare Challenge Accepted!
                </div>

                <h1 class="text-2xl sm:text-4xl font-black tracking-tight">
                    How Well Do You Know <span class="underline decoration-yellow-400 decoration-wavy">{{ $challenge['creator_name'] }}</span>?
                </h1>

                <p class="text-sm sm:text-base text-white/90 max-w-lg mx-auto">
                    {{ $challenge['creator_name'] }} has personally answered these questions. Guess their real choices and see where you rank on their friend scoreboard!
                </p>
            </div>
        </div>

        <!-- Progress Tracker -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 shadow-sm">
            <div class="flex justify-between text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">
                <span id="friend-progress-text">Answered 0 of {{ count($quiz['questions'] ?? []) }} questions</span>
                <span id="friend-progress-percent">0%</span>
            </div>
            <div class="w-full h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                <div id="friend-progress-bar" class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 transition-all duration-300 w-0 rounded-full"></div>
            </div>
        </div>

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-sm font-semibold flex items-center gap-3">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form id="friend-dare-form" action="{{ route('quizzes.challenge.submit', $challenge['share_token']) }}" method="POST" class="space-y-8">
            @csrf

            <!-- Friend Name Input Card -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-4">
                <label for="friend_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Your Name or Nickname <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="friend_name" name="friend_name" required maxlength="50"
                       value="{{ old('friend_name') }}"
                       placeholder="Enter your name so {{ $challenge['creator_name'] }} knows it was you!"
                       class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-white text-base font-semibold focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Your score will appear on {{ $challenge['creator_name'] }}'s scoreboard under this name.
                </p>
            </div>

            <!-- Quiz Questions Grid -->
            @foreach($quiz['questions'] ?? [] as $qIndex => $question)
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-6 question-card" data-question-id="{{ $question['id'] }}">
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-black">
                            Question {{ $qIndex + 1 }} of {{ count($quiz['questions']) }}
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white leading-snug">
                            {{ $question['question_text'] }}
                        </h3>

                        <!-- Optional Question Image -->
                        @if(!empty($question['image_url']) || !empty($question['image']))
                            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 max-h-72 w-full bg-slate-100 dark:bg-slate-800">
                                <img src="{{ blogger_media_url($question['image_url'] ?? $question['image'] ?? null) }}" alt="{{ $question['question_text'] }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>

                    <!-- Options Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        @foreach($question['options'] ?? [] as $option)
                            <label class="relative block cursor-pointer group">
                                <input type="radio" 
                                       name="answers[{{ $question['id'] }}]" 
                                       value="{{ $option['id'] }}" 
                                       required
                                       onchange="updateFriendProgress()"
                                       class="peer sr-only quiz-radio-input">
                                
                                <div class="option-box h-full p-4 rounded-2xl border-2 border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-850 transition-all duration-200 group-hover:border-purple-300 dark:group-hover:border-purple-700/60 flex items-center gap-3">
                                    @if(!empty($option['image_url']) || !empty($option['image']))
                                        <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border border-slate-200 dark:border-slate-700 bg-white">
                                            <img src="{{ blogger_media_url($option['image_url'] ?? $option['image'] ?? null) }}" alt="{{ $option['option_text'] }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif

                                    <div class="option-text flex-1 font-semibold text-sm text-slate-800 dark:text-slate-200">
                                        {{ $option['option_text'] }}
                                    </div>

                                    <div class="radio-circle w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 flex items-center justify-center transition-all shrink-0">
                                        <svg class="radio-tick w-3.5 h-3.5 text-white opacity-0 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Sticky Submit Floating Bar -->
            <div class="sticky bottom-4 z-30 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-slate-800 p-4 sm:p-6 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <div class="font-black text-slate-900 dark:text-white text-base">Finished guessing?</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">See your score & answers comparison instantly!</div>
                </div>
                <button type="submit" id="submit-friend-dare-btn" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white font-black text-base shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2">
                    <span>Submit & See Results</span>
                    <span>🎯</span>
                </button>
            </div>
        </form>

        <!-- Current Scoreboard (Motivation to beat peers!) -->
        @if(!empty($leaderboard) && count($leaderboard) > 0)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="font-black text-base text-slate-900 dark:text-white flex items-center gap-2">
                        <span>🏆</span> Current Top Scores to Beat
                    </h3>
                    <span class="text-xs font-bold text-slate-400">{{ count($leaderboard) }} tested</span>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach(array_slice($leaderboard, 0, 5) as $i => $item)
                        <div class="py-2.5 flex items-center justify-between text-xs sm:text-sm">
                            <div class="flex items-center gap-2.5 font-semibold text-slate-800 dark:text-slate-200">
                                <span class="w-5 text-center font-black {{ $i === 0 ? 'text-amber-500' : 'text-slate-400' }}">{{ $i === 0 ? '🥇' : $i + 1 }}</span>
                                <span>{{ $item['friend_name'] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-600 dark:text-slate-300">{{ $item['score'] }}/{{ $item['total_questions'] }}</span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-black bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300">{{ $item['percentage'] }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

<style>
/* Friend radio selected styling */
.quiz-radio-input:checked + .option-box {
    border-color: #8b5cf6 !important; /* purple-500 */
    background-color: rgba(245, 243, 255, 0.95) !important; /* purple-50 */
    box-shadow: 0 4px 14px 0 rgba(139, 92, 246, 0.18) !important;
}
.dark .quiz-radio-input:checked + .option-box {
    border-color: #8b5cf6 !important;
    background-color: rgba(76, 29, 149, 0.25) !important;
    box-shadow: 0 4px 14px 0 rgba(139, 92, 246, 0.22) !important;
}
.quiz-radio-input:checked + .option-box .option-text {
    color: #7c3aed !important; /* purple-600 */
    font-weight: 700 !important;
}
.dark .quiz-radio-input:checked + .option-box .option-text {
    color: #c4b5fd !important; /* purple-300 */
}
.quiz-radio-input:checked + .option-box .radio-circle {
    background-color: #8b5cf6 !important;
    border-color: #8b5cf6 !important;
    transform: scale(1.1);
}
.quiz-radio-input:checked + .option-box .radio-circle .radio-tick {
    opacity: 1 !important;
    stroke: #ffffff !important;
}
</style>

<script>
    const totalQuestions = {{ count($quiz['questions'] ?? []) }};

    function updateFriendProgress() {
        const checked = document.querySelectorAll('input[type="radio"][name^="answers"]:checked').length;
        const percent = totalQuestions > 0 ? Math.round((checked / totalQuestions) * 100) : 0;
        
        document.getElementById('friend-progress-text').innerText = `Answered ${checked} of ${totalQuestions} questions`;
        document.getElementById('friend-progress-percent').innerText = `${percent}%`;
        document.getElementById('friend-progress-bar').style.width = `${percent}%`;
    }

    document.getElementById('friend-dare-form').addEventListener('submit', function(e) {
        const name = document.getElementById('friend_name').value.trim();
        if (!name) {
            e.preventDefault();
            alert('Please enter your name first!');
            document.getElementById('friend_name').focus();
            return;
        }

        const checked = document.querySelectorAll('input[type="radio"][name^="answers"]:checked').length;
        if (checked < totalQuestions) {
            e.preventDefault();
            alert(`Please answer all questions! You have answered ${checked} of ${totalQuestions}.`);
            const cards = document.querySelectorAll('.question-card');
            for (let card of cards) {
                if (!card.querySelector('input[type="radio"]:checked')) {
                    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    card.classList.add('ring-2', 'ring-purple-500');
                    setTimeout(() => card.classList.remove('ring-2', 'ring-purple-500'), 2500);
                    break;
                }
            }
        }
    });

    document.addEventListener('DOMContentLoaded', updateFriendProgress);
</script>
@endsection
