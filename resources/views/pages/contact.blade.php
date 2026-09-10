@extends('layouts.app')

@section('title', 'Contact Us - Funfillia')
@section('meta_description', 'Get in touch with the Funfillia editorial, entertainment, and creative partnership team. We welcome your viral story tips, game ideas, and inquiries.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Centered Professional Hero Header -->
    <div class="relative text-center py-8 sm:py-12 space-y-4 max-w-3xl mx-auto">
        <!-- Breadcrumbs -->
        <nav class="flex items-center justify-center gap-2 text-xs font-semibold text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-600 dark:text-slate-400">Company</span>
            <span>/</span>
            <span class="text-indigo-600 dark:text-indigo-400">Contact</span>
        </nav>

        <!-- Topic Pill Badge -->
        <div class="flex justify-center">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/80 shadow-sm">
                <span>✉</span>
                <span>We'd Love to Hear From You</span>
            </span>
        </div>

        <!-- Responsive Centered Title -->
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
            Contact Funfillia
        </h1>

        <!-- Centered Subtitle -->
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
            Have a viral story tip, challenge proposal, brand collaboration, or reader feedback? Send us a message and our team will get back to you promptly.
        </p>

        <!-- Metadata Chip -->
        <div class="flex items-center justify-center gap-2 pt-1 text-xs text-slate-400">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700/80">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Direct Editorial &amp; Reader Support Desk</span>
            </span>
        </div>
    </div>

    <!-- Contact Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-center space-y-2 shadow-sm">
            <span class="text-2xl">✉</span>
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Email Us</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400">contact@funfillia.com</p>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-center space-y-2 shadow-sm">
            <span class="text-2xl">⏱</span>
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Response Time</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400">Within 24-48 Hours</p>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-center space-y-2 shadow-sm">
            <span class="text-2xl">📍</span>
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Location</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400">Worldwide Digital Magazine</p>
        </div>
    </div>

    <!-- AJAX Contact Form -->
    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 sm:p-12 shadow-sm">
        <div id="contact-alert" class="hidden p-4 rounded-2xl text-sm font-semibold mb-6"></div>

        <form id="contact-form" action="{{ route('pages.contact.submit') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Your Name *</label>
                    <input type="text" name="name" required placeholder="Jane Doe" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Your Email *</label>
                    <input type="email" name="email" required placeholder="jane@example.com" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Subject *</label>
                <input type="text" name="subject" required placeholder="Story Tip, Challenge Pitch, or Partnership" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Message *</label>
                <textarea name="message" rows="5" required placeholder="Tell us what's on your mind..." class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500"></textarea>
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
                           placeholder="Answer" 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-indigo-200 dark:border-indigo-800 text-sm text-center font-mono font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <button type="submit" id="contact-btn" class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-700 hover:to-rose-700 text-white font-bold text-sm shadow-md transition-all">
                Send Message
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('contact-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const btn = document.getElementById('contact-btn');
        const alertBox = document.getElementById('contact-alert');

        btn.disabled = true;
        btn.textContent = 'Sending...';

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
            btn.textContent = 'Send Message';

            if (res.ok && data.success) {
                alertBox.className = 'p-4 rounded-2xl text-sm font-semibold bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 mb-6';
                alertBox.textContent = '✓ ' + (data.message || 'Message sent successfully!');
                alertBox.classList.remove('hidden');
                form.reset();
            } else {
                alertBox.className = 'p-4 rounded-2xl text-sm font-semibold bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 mb-6';
                alertBox.textContent = '✕ ' + (data.message || 'Failed to send message.');
                alertBox.classList.remove('hidden');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.textContent = 'Send Message';
            alertBox.className = 'p-4 rounded-2xl text-sm font-semibold bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 mb-6';
            alertBox.textContent = '✕ Network error. Please try again.';
            alertBox.classList.remove('hidden');
        });
    });
</script>
@endsection
