<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-rose-600 p-8 sm:p-12 text-white shadow-2xl my-12">
    <!-- Decorative background shapes -->
    <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
    <div class="absolute -left-12 -bottom-12 w-64 h-64 rounded-full bg-black/10 blur-2xl pointer-events-none"></div>

    <div class="relative max-w-3xl mx-auto text-center space-y-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur-md text-white shadow-sm">
            ✦ Never Miss a Story
        </span>
        <h3 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
            Discover Fresh Perspectives Every Morning
        </h3>
        <p class="text-sm sm:text-base text-white/80 max-w-xl mx-auto leading-relaxed">
            Join thousands of curious minds. Get our weekly digest of curated recipes, modern style, culture guides, and life tips.
        </p>

        <!-- Dynamic Success / Message Container -->
        <div id="newsletter-box-msg" class="hidden p-4 rounded-2xl bg-white/20 backdrop-blur-md text-white font-semibold text-sm max-w-md mx-auto"></div>

        <form id="newsletter-box-form" action="{{ route('newsletter.subscribe') }}" method="POST" class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3 max-w-lg mx-auto">
            @csrf
            <input type="email" 
                   name="email" 
                   required 
                   placeholder="Enter your email address" 
                   class="w-full sm:flex-1 px-5 py-3.5 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/60 text-sm backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-white">
            <button type="submit" id="newsletter-box-btn" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-white text-indigo-700 hover:bg-slate-100 font-bold text-sm shadow-xl transition-all hover:scale-105 shrink-0">
                Subscribe
            </button>
        </form>

        <p class="text-[11px] text-white/60 pt-1">Zero spam. Unsubscribe anytime with a single click.</p>
    </div>
</div>

<script>
    document.getElementById('newsletter-box-form')?.addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        const btn = document.getElementById('newsletter-box-btn');
        const msg = document.getElementById('newsletter-box-msg');
        btn.disabled = true;
        btn.textContent = 'Subscribing...';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(async (res) => {
            const data = await res.json();
            btn.disabled = false;
            btn.textContent = 'Subscribe';

            if (msg) {
                msg.textContent = '✓ ' + (data.message || 'Subscribed successfully!');
                msg.classList.remove('hidden');
                form.classList.add('hidden');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.textContent = 'Subscribe';
            if (msg) {
                msg.textContent = '✕ An error occurred. Please try again.';
                msg.classList.remove('hidden');
            }
        });
    });
</script>
