/**
 * goddess.js
 * Celestia Bibliotheca — Moon Goddess silhouette canvas renderer
 * public/js/goddess.js
 */

(function () {
    'use strict';

    const canvas = document.getElementById('goddessCanvas');
    if (!canvas) return;

    function render() {
        const dpr = window.devicePixelRatio || 1;
        const dw  = canvas.offsetWidth;
        const dh  = canvas.offsetHeight;

        canvas.width  = dw * dpr;
        canvas.height = dh * dpr;

        const ctx = canvas.getContext('2d');
        ctx.scale(dpr, dpr);

        const cx = dw * 0.5;
        const cy = dh * 0.08;

        /* Gradient for main figure */
        const fig = ctx.createLinearGradient(dw * 0.35, 0, dw * 0.65, dh);
        fig.addColorStop(0,   'rgba(212,208,200,0.28)');
        fig.addColorStop(0.4, 'rgba(212,208,200,0.22)');
        fig.addColorStop(1,   'rgba(212,208,200,0.04)');

        /* ── Head ── */
        ctx.save();
        ctx.globalAlpha = 1;
        ctx.fillStyle = fig;
        ctx.beginPath();
        ctx.ellipse(cx, cy + dh * 0.055, dw * 0.058, dh * 0.072, 0, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();

        /* ── Crescent above head ── */
        ctx.save();
        ctx.beginPath();
        ctx.arc(cx, cy + dh * 0.005, dw * 0.04, Math.PI * 1.1, Math.PI * 1.9, false);
        ctx.lineWidth   = dw * 0.012;
        ctx.strokeStyle = 'rgba(201,168,76,0.55)';
        ctx.stroke();
        ctx.restore();

        /* ── Draped body ── */
        ctx.save();
        ctx.fillStyle = fig;
        ctx.beginPath();
        ctx.moveTo(cx - dw * 0.06, cy + dh * 0.13);
        ctx.bezierCurveTo(cx - dw * 0.14, cy + dh * 0.22, cx - dw * 0.22, cy + dh * 0.38, cx - dw * 0.18, cy + dh * 0.60);
        ctx.bezierCurveTo(cx - dw * 0.12, cy + dh * 0.82, cx - dw * 0.08, cy + dh * 0.92, cx, cy + dh * 0.97);
        ctx.bezierCurveTo(cx + dw * 0.08, cy + dh * 0.92, cx + dw * 0.12, cy + dh * 0.82, cx + dw * 0.18, cy + dh * 0.60);
        ctx.bezierCurveTo(cx + dw * 0.22, cy + dh * 0.38, cx + dw * 0.14, cy + dh * 0.22, cx + dw * 0.06, cy + dh * 0.13);
        ctx.closePath();
        ctx.fill();
        ctx.restore();

        /* ── Right flowing cloak ── */
        ctx.save();
        ctx.fillStyle = 'rgba(200,195,185,0.13)';
        ctx.beginPath();
        ctx.moveTo(cx, cy + dh * 0.12);
        ctx.bezierCurveTo(cx + dw * 0.15, cy + dh * 0.04, cx + dw * 0.38, cy + dh * 0.08, cx + dw * 0.44, cy + dh * 0.22);
        ctx.bezierCurveTo(cx + dw * 0.46, cy + dh * 0.35, cx + dw * 0.32, cy + dh * 0.42, cx + dw * 0.18, cy + dh * 0.44);
        ctx.bezierCurveTo(cx + dw * 0.08, cy + dh * 0.42, cx + dw * 0.04, cy + dh * 0.32, cx, cy + dh * 0.20);
        ctx.fill();
        ctx.restore();

        /* ── Left flowing cloak ── */
        ctx.save();
        ctx.fillStyle = 'rgba(200,195,185,0.13)';
        ctx.beginPath();
        ctx.moveTo(cx, cy + dh * 0.12);
        ctx.bezierCurveTo(cx - dw * 0.15, cy + dh * 0.04, cx - dw * 0.38, cy + dh * 0.08, cx - dw * 0.44, cy + dh * 0.22);
        ctx.bezierCurveTo(cx - dw * 0.46, cy + dh * 0.35, cx - dw * 0.32, cy + dh * 0.42, cx - dw * 0.18, cy + dh * 0.44);
        ctx.bezierCurveTo(cx - dw * 0.08, cy + dh * 0.42, cx - dw * 0.04, cy + dh * 0.32, cx, cy + dh * 0.20);
        ctx.fill();
        ctx.restore();
    }

    /* Render on load and resize */
    render();
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(render, 250);
    });

})();