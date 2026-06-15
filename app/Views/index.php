<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<!-- ═══════════════════════════════════════════
     HERO
════════════════════════════════════════════ -->
<section id="hero">

    <div class="moon-glow"></div>

    <!-- Crescent moon SVG -->
    <svg class="crescent" width="70" height="50" viewBox="0 0 70 50" aria-hidden="true">
        <path d="M55 10 C55 10 30 14 30 25 C30 36 55 40 55 40 C40 38 22 33 22 25 C22 17 40 12 55 10Z"
            fill="none" stroke="#C9A84C" stroke-width="1.5" opacity="0.8"/>
    </svg>

    <!-- Moon Goddess silhouette (drawn by goddess.js) -->
    <div class="goddess-overlay">
        <canvas id="goddessCanvas"></canvas>
    </div>

    <!-- Hero copy -->
    <div class="hero-content">
        <div class="hero-eyebrow">The Eternal Archive</div>
        <h1 class="hero-title">
            CELESTIA<br>
            <span>BIBLIOTHECA</span>
        </h1>
        <p class="hero-subtitle">Where Stars Write in Ink</p>
        <p class="hero-desc">
            A celestial sanctuary of knowledge, myth, and wonder. Explore thousands of volumes
            illuminated beneath an eternal night sky — from ancient lore to the furthest reaches
            of imagination.
        </p>
        <div class="hero-cta">
            <a href="<?= base_url('catalogue') ?>" class="btn-primary">Enter the Archive</a>
            <a href="<?= base_url('collections') ?>" class="btn-ghost">Browse Collections</a>
        </div>
    </div>

    <div class="scroll-hint">Scroll to discover</div>

    <div class="hero-counter">
        <button id="heroPrev" aria-label="Previous slide">←</button>
        <span id="slideNum">1 / 4</span>
        <button id="heroNext" aria-label="Next slide">→</button>
    </div>

    <!-- Quick cards -->
    <div class="hero-cards">
        <div class="hero-card">
            <div class="card-eyebrow">New Arrival</div>
            <div class="card-title">The Selenite Chronicles</div>
            <div class="card-sub">Fantasy · Vol. I added to collection</div>
        </div>
        <div class="hero-card">
            <div class="card-eyebrow">Reading Room</div>
            <div class="card-title">Moonlit Reading Session</div>
            <div class="card-sub">Every eve at 8 &amp; 10 PM · Open to all</div>
        </div>
        <div class="hero-card">
            <div class="card-eyebrow">Volume of the Night</div>
            <div class="card-title">Astronomica Arcana</div>
            <div class="card-sub">Curator's choice · Celestial history</div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     CATEGORY FRAMES
════════════════════════════════════════════ -->
<section id="categories-section">
    <div class="section-header">
        <div class="divider-rune">✦</div>
        <h2>Explore the Constellations</h2>
        <p>Each constellation guards a different realm of knowledge. Choose your path.</p>
    </div>

    <div id="categories">
        <!-- Categories data for JS — rendered from PHP controller -->
        <script id="categoriesData" type="application/json">
        <?= json_encode($categories ?? [
            ['icon' => '🌙', 'label' => 'Mythology',  'sub' => '1,240 volumes', 'info' => 'Tales of gods, heroes, and the cosmos across all ancient cultures.'],
            ['icon' => '⚗️', 'label' => 'Alchemy',    'sub' => '834 volumes',   'info' => 'Arcane sciences, transmutation, and the philosopher\'s stone.'],
            ['icon' => '🦁', 'label' => 'Bestiary',   'sub' => '612 volumes',   'info' => 'Creatures of legend, celestial beasts, and mythic fauna.'],
            ['icon' => '✨', 'label' => 'Cosmology',  'sub' => '1,560 volumes', 'info' => 'The architecture of the heavens, star maps, and astral lore.'],
            ['icon' => '📜', 'label' => 'Scrolls',    'sub' => '2,100 volumes', 'info' => 'Ancient manuscripts, sacred texts, and forbidden knowledge.'],
            ['icon' => '🔮', 'label' => 'Divination', 'sub' => '490 volumes',   'info' => 'Oracles, prophecy, and the art of reading fate in stars.'],
            ['icon' => '🗡️', 'label' => 'Epics',     'sub' => '780 volumes',   'info' => 'Heroic sagas, quests, and the trials of legendary figures.'],
        ]) ?>
        </script>

        <div class="frames-row" id="framesRow"></div>

        <div class="frame-info" id="frameInfo">
            <h3></h3><p></p>
        </div>

        <div class="frame-arrows">
            <button id="prevFrame" aria-label="Previous category">←</button>
            <span id="frameCounter">1 / 7</span>
            <button id="nextFrame" aria-label="Next category">→</button>
        </div>

        <!-- Icon editor for active frame -->
        <div class="frame-icon-editor" id="frameIconEditor">
            <div class="icon-editor-label">Change icon for <strong id="editorCatName"></strong></div>
            <div class="icon-picker" id="iconPicker"></div>
            <div class="icon-editor-custom">
                <input type="text" id="customIconInput" maxlength="2" placeholder="Paste emoji…">
                <button id="applyCustomIcon" class="btn-primary-sm">Apply</button>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     FEATURED BOOKS
════════════════════════════════════════════ -->
<section id="collection-section">
    <div class="section-header">
        <div class="divider-rune">✦</div>
        <h2>Featured Volumes</h2>
        <p>Curated from across the celestial archive</p>
    </div>
    <div id="collection">
        <div class="collection-grid" id="bookGrid">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <div class="book-cover"><?= esc($book['emoji']) ?></div>
                    <div class="book-genre"><?= esc($book['genre']) ?></div>
                    <div class="book-title"><?= esc($book['title']) ?></div>
                    <div class="book-author"><?= esc($book['author']) ?></div>
                    <div class="book-meta">
                        <span class="stars"><?= esc($book['stars']) ?></span>
                        <a href="<?= base_url('book/' . ($book['slug'] ?? '')) ?>" class="book-btn">Read</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback rendered by books.js if $books is empty -->
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     SEARCH BAND
════════════════════════════════════════════ -->
<div class="nebula-band">
    <h2>Search the Stars</h2>
    <p>Every star is a story. Find yours.</p>
    <form action="<?= base_url('search') ?>" method="GET" class="search-form">
        <?= csrf_field() ?>
        <input type="text" name="q" placeholder="Title, author, constellation…"
               value="<?= esc(isset($searchQuery) ? $searchQuery : '') ?>">
        <button type="submit" class="btn-primary">Search</button>
    </form>
</div>

<?= $this->endSection() ?>