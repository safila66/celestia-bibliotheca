/**
 * frames.js
 * Celestia Bibliotheca — Category frames renderer with changeable icons
 * public/js/frames.js
 *
 * Features:
 *  - 7-frame ornate baroque carousel (3 visible either side + active center)
 *  - Per-category icon picker with 30+ emoji options
 *  - Custom emoji input field
 *  - Icons persisted to localStorage per category slug
 */

(function () {
    'use strict';

    /* ── Read categories from the JSON script tag injected by PHP ── */
    const dataEl = document.getElementById('categoriesData');
    if (!dataEl) return;

    const categories = JSON.parse(dataEl.textContent);

    /* Restore any saved icons */
    categories.forEach((cat, i) => {
        const saved = localStorage.getItem('cb_icon_' + i);
        if (saved) cat.icon = saved;
    });

    /* ── State ── */
    let activeFrame = Math.floor(categories.length / 2); // start at center

    /* ── Icon palette (30+ options) ── */
    const ICON_PALETTE = [
        '🌙','⭐','✨','🌟','💫','🌌','🪐','☄️',
        '⚗️','🔮','📜','🗡️','🛡️','🏺','🦁','🦅',
        '🐉','🦄','🌿','🍄','🌸','🔱','⚡','🌊',
        '🔥','❄️','🌑','🌕','🧿','📖','🗝️','⚖️',
    ];

    /* ── DOM references ── */
    const framesRow      = document.getElementById('framesRow');
    const frameInfo      = document.getElementById('frameInfo');
    const frameCounter   = document.getElementById('frameCounter');
    const prevBtn        = document.getElementById('prevFrame');
    const nextBtn        = document.getElementById('nextFrame');
    const iconPicker     = document.getElementById('iconPicker');
    const editorCatName  = document.getElementById('editorCatName');
    const customInput    = document.getElementById('customIconInput');
    const applyCustomBtn = document.getElementById('applyCustomIcon');

    if (!framesRow) return;

    /* ══════════════════════════════════════════
       SVG Frame builder
    ══════════════════════════════════════════ */
    function getFrameSVG(fc, fc2, icon, isActive) {
        const bgId   = 'bg' + fc.replace('#', '');
        const glowDef = isActive
            ? `<filter id="glowF" x="-30%" y="-30%" width="160%" height="160%">
                 <feGaussianBlur stdDeviation="3" result="blur"/>
                 <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
               </filter>`
            : '';
        const filterAttr = isActive ? 'filter="url(#glowF)"' : '';
        const orbitRing  = isActive
            ? `<circle cx="80" cy="102" r="42" fill="none" stroke="${fc2}"
                 stroke-width="0.8" opacity="0.25" stroke-dasharray="4 3"/>`
            : '';

        return `
<svg viewBox="0 0 160 200" width="160" height="200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <defs>
    ${glowDef}
    <radialGradient id="${bgId}" cx="50%" cy="40%" r="55%">
      <stop offset="0%"   stop-color="#1a1a2e"/>
      <stop offset="100%" stop-color="#07080f"/>
    </radialGradient>
  </defs>

  <g ${filterAttr}>
    <!-- Outer frame body -->
    <rect x="18" y="28" width="124" height="148" rx="6" ry="6"
      fill="url(#${bgId})" stroke="${fc}" stroke-width="2.5"/>

    <!-- Inner double border -->
    <rect x="24" y="34" width="112" height="136" rx="4" ry="4"
      fill="none" stroke="${fc2}" stroke-width="1" opacity="0.6"/>

    <!-- Crown top ornament -->
    <path d="M80 6 L90 20 L95 14 L100 28 L80 28 L60 28 L65 14 L70 20 Z"
      fill="${fc2}" opacity="0.9"/>
    <circle cx="80" cy="8" r="4" fill="${fc2}"/>

    <!-- Bottom scroll -->
    <path d="M62 176 Q80 188 98 176" fill="none" stroke="${fc}" stroke-width="1.5"/>
    <circle cx="80" cy="186" r="3" fill="${fc}" opacity="0.7"/>

    <!-- Side medallions -->
    <circle cx="18"  cy="102" r="5" fill="${fc}" opacity="0.8"/>
    <circle cx="142" cy="102" r="5" fill="${fc}" opacity="0.8"/>
    <path d="M6 90 Q14 102 6 114"   fill="none" stroke="${fc}" stroke-width="1.5" opacity="0.6"/>
    <path d="M154 90 Q146 102 154 114" fill="none" stroke="${fc}" stroke-width="1.5" opacity="0.6"/>

    <!-- Corner filigree -->
    <path d="M26 36  Q30 30 36 34"  fill="none" stroke="${fc2}" stroke-width="1" opacity="0.5"/>
    <path d="M124 36 Q130 30 134 34" fill="none" stroke="${fc2}" stroke-width="1" opacity="0.5"/>
    <path d="M26 164 Q30 170 36 166" fill="none" stroke="${fc2}" stroke-width="1" opacity="0.5"/>
    <path d="M124 164 Q130 170 134 166" fill="none" stroke="${fc2}" stroke-width="1" opacity="0.5"/>
  </g>

  <!-- Icon emoji -->
  <text x="80" y="115" text-anchor="middle" dominant-baseline="middle"
    font-size="${isActive ? 42 : 36}" opacity="${isActive ? 0.9 : 0.65}">${icon}</text>

  ${orbitRing}
</svg>`;
    }

    /* ══════════════════════════════════════════
       Render carousel
    ══════════════════════════════════════════ */
    const FRAME_COLORS = ['#7A5C28','#8B6914','#9E7A2C','#C9A84C','#9E7A2C','#8B6914','#7A5C28'];
    const POSITIONS    = [-3, -2, -1, 0, 1, 2, 3];
    const CLASS_MAP    = { '-3':'side','-2':'side','-1':'near','0':'active','1':'near','2':'side','3':'side' };

    function renderFrames() {
        framesRow.innerHTML = '';
        const total = categories.length;

        POSITIONS.forEach(offset => {
            const idx = ((activeFrame + offset) % total + total) % total;
            const cat = categories[idx];

            const fc  = FRAME_COLORS[offset + 3] || '#7A5C28';
            const fc2 = offset === 0 ? '#E8C96A' : '#C9A84C';

            const item       = document.createElement('div');
            item.className   = 'frame-item ' + (CLASS_MAP[String(offset)] || 'side');
            item.dataset.idx = idx;

            item.innerHTML = `
                <div class="frame-svg-wrap">${getFrameSVG(fc, fc2, cat.icon, offset === 0)}</div>
                <div class="frame-label">${cat.label}</div>
                <div class="frame-sub">${cat.sub}</div>
            `;

            item.addEventListener('click', () => {
                activeFrame = idx;
                renderFrames();
                updateInfo();
                updateEditor();
            });

            framesRow.appendChild(item);
        });

        updateInfo();
        updateEditor();
        frameCounter.textContent = `${activeFrame + 1} / ${total}`;
    }

    function updateInfo() {
        const cat = categories[activeFrame];
        frameInfo.innerHTML = `<h3>${cat.label}</h3><p>${cat.info}</p>`;
    }

    /* ══════════════════════════════════════════
       Icon editor
    ══════════════════════════════════════════ */
    function updateEditor() {
        const cat = categories[activeFrame];
        if (editorCatName) editorCatName.textContent = cat.label;
        if (customInput)   customInput.value = '';
        renderPicker();
    }

    function renderPicker() {
        if (!iconPicker) return;
        iconPicker.innerHTML = '';
        const current = categories[activeFrame].icon;

        ICON_PALETTE.forEach(emoji => {
            const btn       = document.createElement('button');
            btn.className   = 'icon-option' + (emoji === current ? ' selected' : '');
            btn.textContent = emoji;
            btn.title       = emoji;
            btn.setAttribute('aria-label', 'Set icon to ' + emoji);
            btn.addEventListener('click', () => applyIcon(emoji));
            iconPicker.appendChild(btn);
        });
    }

    function applyIcon(emoji) {
        if (!emoji || !emoji.trim()) return;
        categories[activeFrame].icon = emoji.trim();
        /* Persist to localStorage */
        try { localStorage.setItem('cb_icon_' + activeFrame, emoji.trim()); } catch(_) {}
        renderFrames();
        renderPicker();
    }

    /* Custom emoji input */
    if (applyCustomBtn && customInput) {
        applyCustomBtn.addEventListener('click', () => {
            const val = customInput.value.trim();
            if (val) applyIcon(val);
        });
        customInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                const val = customInput.value.trim();
                if (val) applyIcon(val);
            }
        });
    }

    /* ── Arrow nav ── */
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            activeFrame = (activeFrame - 1 + categories.length) % categories.length;
            renderFrames();
        });
    }
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            activeFrame = (activeFrame + 1) % categories.length;
            renderFrames();
        });
    }

    /* ── Keyboard nav ── */
    document.addEventListener('keydown', e => {
        const inCategory = document.activeElement.closest('#categories');
        if (!inCategory && document.activeElement !== document.body) return;
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            activeFrame = (activeFrame - 1 + categories.length) % categories.length;
            renderFrames();
        }
        if (e.key === 'ArrowRight') {
            e.preventDefault();
            activeFrame = (activeFrame + 1) % categories.length;
            renderFrames();
        }
    });

    /* ── Init ── */
    renderFrames();

})();