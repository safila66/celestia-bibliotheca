/**
 * main.js
 * Celestia Bibliotheca — Core UI interactions
 * public/js/main.js
 */

(function () {
    'use strict';

    /* ══════════════════════════════════════════
       NAVBAR — scroll class & mobile toggle
    ══════════════════════════════════════════ */
    const nav       = document.getElementById('main-nav');
    const hamburger = document.getElementById('navHamburger');
    const navLinks  = document.getElementById('navLinks');

    if (nav) {
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        }, { passive: true });
    }

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            const open = navLinks.classList.toggle('open');
            hamburger.classList.toggle('open', open);
            hamburger.setAttribute('aria-expanded', String(open));
        });

        /* Close on outside click */
        document.addEventListener('click', e => {
            if (!nav.contains(e.target)) {
                navLinks.classList.remove('open');
                hamburger.classList.remove('open');
                hamburger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /* ══════════════════════════════════════════
       HERO SLIDE COUNTER
    ══════════════════════════════════════════ */
    const slideNum  = document.getElementById('slideNum');
    const heroPrev  = document.getElementById('heroPrev');
    const heroNext  = document.getElementById('heroNext');
    let   slide     = 1;
    const slideMax  = 4;

    function updateSlide() {
        if (slideNum) slideNum.textContent = `${slide} / ${slideMax}`;
    }

    if (heroPrev) {
        heroPrev.addEventListener('click', () => {
            slide = Math.max(1, slide - 1);
            updateSlide();
        });
    }
    if (heroNext) {
        heroNext.addEventListener('click', () => {
            slide = Math.min(slideMax, slide + 1);
            updateSlide();
        });
    }

    /* ══════════════════════════════════════════
       BOOK GRID — JS fallback if PHP $books empty
    ══════════════════════════════════════════ */
    const bookGrid = document.getElementById('bookGrid');

    if (bookGrid && bookGrid.children.length === 0) {
        const fallbackBooks = [
            { emoji: '🌙', genre: 'Mythology',      title: 'The Lunar Codex',          author: 'Artemis Vael',    stars: '★★★★★', slug: 'lunar-codex' },
            { emoji: '⭐', genre: 'Cosmology',      title: 'Stars Without Names',       author: 'Orion Blackthorn',stars: '★★★★☆', slug: 'stars-without-names' },
            { emoji: '🔮', genre: 'Divination',     title: "The Seer's Almanac",        author: 'Selene Noctis',   stars: '★★★★★', slug: 'seers-almanac' },
            { emoji: '📜', genre: 'Ancient Scrolls',title: 'Tablets of Anunnaki',       author: 'H. Dawnmere',     stars: '★★★★☆', slug: 'tablets-anunnaki' },
            { emoji: '🦅', genre: 'Epic',           title: 'Wings of Aether',           author: 'Caelum Bright',   stars: '★★★★★', slug: 'wings-of-aether' },
            { emoji: '⚗️', genre: 'Alchemy',        title: 'The Gold Cipher',           author: 'Mercu Ral',       stars: '★★★★☆', slug: 'gold-cipher' },
            { emoji: '🌌', genre: 'Cosmology',      title: 'Void Between Worlds',       author: 'Nyx Celestine',   stars: '★★★★★', slug: 'void-between-worlds' },
            { emoji: '🗡️', genre: 'Epic',           title: 'The Iron Constellation',    author: 'Ares Duskborne',  stars: '★★★☆☆', slug: 'iron-constellation' },
        ];

        fallbackBooks.forEach(b => {
            const card = document.createElement('div');
            card.className = 'book-card';
            card.innerHTML = `
                <div class="book-cover">${b.emoji}</div>
                <div class="book-genre">${b.genre}</div>
                <div class="book-title">${b.title}</div>
                <div class="book-author">${b.author}</div>
                <div class="book-meta">
                    <span class="stars">${b.stars}</span>
                    <a href="/book/${b.slug}" class="book-btn">Read</a>
                </div>
            `;
            bookGrid.appendChild(card);
        });
    }

    /* ══════════════════════════════════════════
       SMOOTH SCROLL — anchor links
    ══════════════════════════════════════════ */
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const target = document.querySelector(link.getAttribute('href'));
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    /* ══════════════════════════════════════════
       HERO CARDS — subtle entrance animation
    ══════════════════════════════════════════ */
    const heroCards = document.querySelectorAll('.hero-card');
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.style.opacity  = '1';
                    e.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        heroCards.forEach((card, i) => {
            card.style.opacity   = '0';
            card.style.transform = 'translateY(16px)';
            card.style.transition = `opacity 0.6s ease ${i * 0.12}s, transform 0.6s ease ${i * 0.12}s`;
            obs.observe(card);
        });
    }

    /* ══════════════════════════════════════════
       SEARCH FORM — basic client validation
    ══════════════════════════════════════════ */
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', e => {
            const input = searchForm.querySelector('input[name="q"]');
            if (input && !input.value.trim()) {
                e.preventDefault();
                input.focus();
                input.style.borderColor = '#C9A84C';
                setTimeout(() => { input.style.borderColor = ''; }, 1500);
            }
        });
    }

})();