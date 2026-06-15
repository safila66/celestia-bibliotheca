/**
 * starfield.js
 * Celestia Bibliotheca — Rotating animated starfield canvas
 * public/js/starfield.js
 */

(function () {
    'use strict';

    const canvas = document.getElementById('starfield');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let W, H, stars = [];
    let animId = null;
    let t = 0;

    /* ── Resize ── */
    function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = document.documentElement.scrollHeight;
        createStars();
    }

    /* ── Star factory ── */
    function makeStar(bright) {
        return {
            x:            Math.random() * W,
            y:            Math.random() * H,
            r:            bright ? Math.random() * 2.5 + 1.5 : Math.random() * 1.6 + 0.2,
            alpha:        bright ? 0.9 : Math.random() * 0.7 + 0.15,
            speed:        Math.random() * 0.02  + 0.005,
            phase:        Math.random() * Math.PI * 2,
            drift:        (Math.random() - 0.5) * (bright ? 0.02 : 0.04),
            bright:       !!bright,
        };
    }

    function createStars() {
        stars = [];
        const density = Math.floor((W * H) / 3000);
        for (let i = 0; i < density; i++) stars.push(makeStar(false));
        for (let i = 0; i < 20;      i++) stars.push(makeStar(true));
    }

    /* ── Draw frame ── */
    function draw() {
        ctx.clearRect(0, 0, W, H);

        /* Deep-space gradient background */
        const bg = ctx.createLinearGradient(0, 0, 0, H);
        bg.addColorStop(0,   '#04060F');
        bg.addColorStop(0.3, '#07091A');
        bg.addColorStop(0.7, '#060815');
        bg.addColorStop(1,   '#04060F');
        ctx.fillStyle = bg;
        ctx.fillRect(0, 0, W, H);

        /* Nebula wisps */
        drawNebula(W * 0.65, H * 0.22, W * 0.35, 'rgba(80,40,120,0.07)', 'rgba(40,20,80,0.04)');
        drawNebula(W * 0.15, H * 0.60, W * 0.25, 'rgba(20,60,100,0.06)', 'transparent');
        drawNebula(W * 0.80, H * 0.75, W * 0.20, 'rgba(60,20,80,0.05)',  'transparent');

        t += 0.008;

        stars.forEach(s => {
            /* Slow horizontal drift — wraps at edges */
            s.x += s.drift;
            if (s.x < 0) s.x = W;
            if (s.x > W) s.x = 0;

            const a = s.alpha * (0.5 + 0.5 * Math.sin(t * s.speed * 60 + s.phase));

            ctx.save();

            /* Cross-flare for bright stars */
            if (s.bright) {
                ctx.globalAlpha  = a * 0.3;
                ctx.strokeStyle  = '#E8C96A';
                ctx.lineWidth    = 0.5;
                ctx.beginPath();
                ctx.moveTo(s.x - s.r * 4, s.y);
                ctx.lineTo(s.x + s.r * 4, s.y);
                ctx.moveTo(s.x, s.y - s.r * 4);
                ctx.lineTo(s.x, s.y + s.r * 4);
                ctx.stroke();
            }

            /* Star glow */
            ctx.globalAlpha = a;
            const g = ctx.createRadialGradient(s.x, s.y, 0, s.x, s.y, s.r);
            g.addColorStop(0, s.bright ? '#FFF8E0' : '#D4D0C8');
            g.addColorStop(1, 'transparent');
            ctx.fillStyle = g;
            ctx.beginPath();
            ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
            ctx.fill();

            ctx.restore();
        });

        animId = requestAnimationFrame(draw);
    }

    function drawNebula(cx, cy, r, inner, outer) {
        const g = ctx.createRadialGradient(cx, cy, 0, cx, cy, r);
        g.addColorStop(0, inner);
        g.addColorStop(0.5, outer === 'transparent' ? 'rgba(0,0,0,0)' : outer);
        g.addColorStop(1,   'rgba(0,0,0,0)');
        ctx.fillStyle = g;
        ctx.fillRect(0, 0, W, H);
    }

    /* ── Init ── */
    resize();
    draw();

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            cancelAnimationFrame(animId);
            resize();
            draw();
        }, 200);
    });

})();