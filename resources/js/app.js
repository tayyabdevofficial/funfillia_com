// Theme Management with zero-flicker
window.toggleTheme = function () {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('funfillia_theme', isDark ? 'dark' : 'light');
    updateThemeIcons();
};

function updateThemeIcons() {
    const isDark = document.documentElement.classList.contains('dark');
    document.querySelectorAll('.theme-sun-icon').forEach(el => {
        el.style.display = isDark ? 'block' : 'none';
    });
    document.querySelectorAll('.theme-moon-icon').forEach(el => {
        el.style.display = isDark ? 'none' : 'block';
    });
}

// Copy link utility with toast
window.copyArticleLink = function (url) {
    navigator.clipboard.writeText(url || window.location.href).then(() => {
        showToast('Article link copied to clipboard!');
    }).catch(() => {
        showToast('Could not copy link.');
    });
};

function showToast(message) {
    let toast = document.getElementById('funfillia-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'funfillia-toast';
        toast.className = 'fixed bottom-6 right-6 z-50 px-5 py-3 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-2xl transition-all duration-300 transform translate-y-12 opacity-0 flex items-center gap-3 text-sm font-medium';
        document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.classList.remove('translate-y-12', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');

    setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-12', 'opacity-0');
    }, 2800);
}

// Reading Progress Bar (cached measurements with rAF)
function initReadingProgress() {
    const progressBar = document.getElementById('reading-progress-bar');
    const article = document.querySelector('article');
    if (!progressBar || !article) return;

    let articleTop = 0;
    let articleHeight = 0;
    let maxScroll = 0;

    function measure() {
        articleTop = article.offsetTop;
        articleHeight = article.offsetHeight;
        maxScroll = Math.max(1, articleHeight - window.innerHeight);
    }

    measure();
    window.addEventListener('resize', measure, { passive: true });

    let isProgressTicking = false;
    window.addEventListener('scroll', () => {
        if (!isProgressTicking) {
            window.requestAnimationFrame(() => {
                const scrollY = window.scrollY;
                if (scrollY < articleTop) {
                    progressBar.style.width = '0%';
                } else if (scrollY > articleTop + maxScroll) {
                    progressBar.style.width = '100%';
                } else {
                    const percent = ((scrollY - articleTop) / maxScroll) * 100;
                    progressBar.style.width = `${Math.min(100, Math.max(0, percent))}%`;
                }
                isProgressTicking = false;
            });
            isProgressTicking = true;
        }
    }, { passive: true });
}

// Dynamic Table of Contents with Zero-Reflow IntersectionObserver
function initTableOfContents() {
    const tocContainer = document.getElementById('table-of-contents-list');
    const articleBody = document.querySelector('.prose-content');
    if (!tocContainer || !articleBody) return;

    const headings = Array.from(articleBody.querySelectorAll('h2, h3'));
    if (headings.length < 2) {
        const tocWrapper = document.getElementById('table-of-contents-wrapper');
        if (tocWrapper) tocWrapper.style.display = 'none';
        return;
    }

    tocContainer.innerHTML = '';
    const items = [];
    const fragment = document.createDocumentFragment();

    headings.forEach((heading, index) => {
        let id = heading.id;
        if (!id) {
            id = heading.textContent
                .trim()
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '') || `section-${index}`;
            heading.id = id;
        }

        const isH3 = heading.tagName.toUpperCase() === 'H3';
        const li = document.createElement('li');
        li.className = 'relative';

        const a = document.createElement('a');
        a.href = `#${id}`;
        a.textContent = heading.textContent.trim();
        a.dataset.targetId = id;
        a.className = `toc-link block py-1.5 transition-all text-xs sm:text-sm rounded-lg leading-snug ${
            isH3
                ? 'pl-5 pr-2 text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400'
                : 'pl-2.5 pr-2 font-medium text-slate-800 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400'
        } line-clamp-2`;

        a.addEventListener('click', (e) => {
            e.preventDefault();
            const target = document.getElementById(id);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
                history.pushState(null, null, `#${id}`);
                setActiveLink(id, true);
            }
        });

        li.appendChild(a);
        fragment.appendChild(li);
        items.push({ id, heading, link: a, isH3 });
    });

    tocContainer.appendChild(fragment);

    let currentActiveId = null;

    function scrollTocToActive(activeLink) {
        if (!activeLink || !tocContainer) return;

        if (items.length > 0 && items[0].link === activeLink) {
            tocContainer.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }

        const containerRect = tocContainer.getBoundingClientRect();
        const linkRect = activeLink.getBoundingClientRect();
        const currentScroll = tocContainer.scrollTop;
        const relativeTop = linkRect.top - containerRect.top;
        const targetScroll = currentScroll + relativeTop - (containerRect.height / 2) + (linkRect.height / 2);

        tocContainer.scrollTo({
            top: Math.max(0, targetScroll),
            behavior: 'smooth'
        });
    }

    function setActiveLink(activeId, forceScroll = false) {
        if (currentActiveId === activeId && !forceScroll) return;
        currentActiveId = activeId;

        let activeLink = null;

        items.forEach(({ id, link, isH3 }) => {
            if (id === activeId) {
                activeLink = link;
                link.classList.add('text-indigo-600', 'dark:text-indigo-400', 'font-bold', 'bg-indigo-50/80', 'dark:bg-indigo-950/50');
                link.classList.remove('text-slate-600', 'text-slate-800', 'dark:text-slate-400', 'dark:text-slate-200');
            } else {
                link.classList.remove('text-indigo-600', 'dark:text-indigo-400', 'font-bold', 'bg-indigo-50/80', 'dark:bg-indigo-950/50');
                if (isH3) {
                    link.classList.add('text-slate-600', 'dark:text-slate-400');
                } else {
                    link.classList.add('text-slate-800', 'dark:text-slate-200');
                }
            }
        });

        if (activeLink) {
            scrollTocToActive(activeLink);
        }
    }

    // Zero-overhead IntersectionObserver for TOC scrollspy
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            for (let i = 0; i < entries.length; i++) {
                if (entries[i].isIntersecting) {
                    setActiveLink(entries[i].target.id);
                    break;
                }
            }
        }, {
            rootMargin: '-80px 0px -70% 0px',
            threshold: 0
        });

        headings.forEach(h => observer.observe(h));
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateThemeIcons();
    initReadingProgress();
    
    // Defer TOC building so critical content / LCP renders immediately
    if ('requestIdleCallback' in window) {
        requestIdleCallback(initTableOfContents);
    } else {
        setTimeout(initTableOfContents, 100);
    }

    // Search modal shortcut (Ctrl+K or Cmd+K)
    window.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const modal = document.getElementById('search-modal');
            if (modal) {
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                    document.getElementById('modal-search-input')?.focus();
                } else {
                    modal.classList.add('hidden');
                }
            }
        }
        if (e.key === 'Escape') {
            document.getElementById('search-modal')?.classList.add('hidden');
            document.getElementById('mobile-menu')?.classList.add('hidden');
        }
    });
});
