<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<style>
/* Base iOS-like Aesthetic */
.bookshelf-container {
    display: flex;
    max-width: 1400px;
    margin: 40px auto;
    gap: 30px;
    height: 85vh;
    font-family: 'Inter', sans-serif;
    background: #FAEFDF; /* Warm cream background */
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

/* Left Pane: Wood Shelves */
.shelves-pane {
    flex: 1;
    background: #F4E8D6;
    overflow-y: auto;
    padding: 30px;
}
.shelves-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.shelves-title {
    font-size: 28px;
    font-family: 'Cinzel', serif;
    color: #4A3C31;
    font-weight: bold;
}
.search-icon {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: #FFF;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    cursor: pointer;
}

/* Single Shelf Group */
.shelf-group {
    margin-bottom: 50px;
}
.shelf-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    color: #6C5B4E;
    margin-bottom: -15px; /* Pull down onto shelf */
    position: relative;
    z-index: 10;
    padding: 0 10px;
}
.shelf-label span:first-child {
    font-size: 16px;
    letter-spacing: 1px;
}
.shelf-label span:last-child {
    font-size: 13px;
    opacity: 0.7;
}

/* Wood Shelf Illusion */
.wood-shelf {
    display: flex;
    gap: 15px;
    padding: 20px 10px 0;
    border-bottom: 15px solid #C4A47C; /* Wood color */
    position: relative;
    box-shadow: inset 0 -4px 6px rgba(0,0,0,0.1);
    min-height: 180px;
    align-items: flex-end;
}
.wood-shelf::after {
    content: '';
    position: absolute;
    bottom: -15px; left: 0; right: 0;
    height: 15px;
    background: linear-gradient(to bottom, rgba(0,0,0,0.1), transparent);
    pointer-events: none;
}

/* Book on Shelf */
.book-item {
    width: 100px;
    height: 150px;
    border-radius: 4px;
    background-size: cover;
    background-position: center;
    box-shadow: -3px 0 10px rgba(0,0,0,0.3);
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}
.book-item:hover {
    transform: translateY(-10px) rotate(-2deg);
    box-shadow: -5px 10px 15px rgba(0,0,0,0.3);
}
.book-item.selected {
    transform: translateY(-15px) scale(1.05);
    box-shadow: 0 0 20px var(--gold);
    border: 2px solid var(--gold);
}

/* Right Pane: Book Detail */
.detail-pane {
    width: 450px;
    background: #FFFBF5;
    padding: 30px;
    overflow-y: auto;
    border-left: 1px solid rgba(0,0,0,0.05);
    display: none; /* hidden until selected */
    flex-direction: column;
    gap: 25px;
}
.detail-pane.active {
    display: flex;
}
.book-header {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}
.book-header-cover {
    width: 120px; height: 180px;
    border-radius: 8px;
    background-size: cover;
    background-position: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.book-header-info h2 {
    font-size: 22px; margin: 0 0 5px 0; color: #333;
    font-family: 'Cinzel', serif;
}
.book-header-info p {
    font-size: 14px; color: #777; margin: 0 0 15px 0;
}
.star-rating {
    color: #F5A623; font-size: 18px; margin-bottom: 10px;
}
.tags {
    display: flex; gap: 8px; flex-wrap: wrap;
}
.tag {
    background: #EFE6D5; color: #6C5B4E;
    padding: 4px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 600; text-transform: uppercase;
}

/* Detail Cards */
.detail-card {
    background: #FAEFDF;
    border-radius: 16px;
    padding: 20px;
}
.detail-card-title {
    font-size: 12px; font-weight: bold; color: #8A7A6B;
    text-transform: uppercase; letter-spacing: 1px;
    margin-bottom: 15px;
}

/* Moods */
.mood-grid {
    display: flex; gap: 10px; overflow-x: auto; padding-bottom: 5px;
}
.mood-btn {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    background: #FFF; border: 1px solid #EFE6D5;
    padding: 10px 15px; border-radius: 12px;
    cursor: pointer; transition: 0.2s;
    min-width: 80px;
}
.mood-btn.active {
    background: #EAD5B8; border-color: #C4A47C;
}
.mood-icon { font-size: 24px; }
.mood-label { font-size: 11px; color: #6C5B4E; }

/* Textareas for Notes & Quotes */
.journal-input {
    width: 100%;
    background: transparent;
    border: none;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    color: #4A3C31;
    resize: none;
    line-height: 1.6;
    outline: none;
}
.quote-box {
    position: relative;
    padding: 10px 0 10px 20px;
}
.quote-box::before {
    content: '“';
    position: absolute; left: -5px; top: -10px;
    font-size: 50px; color: #C4A47C; opacity: 0.5;
    font-family: serif;
}

/* Extra Ratings Slider */
.rating-row {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 10px; font-size: 13px; color: #4A3C31;
}
.rating-icons {
    display: flex; gap: 5px; color: #C4A47C; font-size: 16px;
}

/* Save Button */
.save-btn {
    width: 100%;
    padding: 15px;
    background: #C4A47C;
    color: #FFF;
    border: none;
    border-radius: 12px;
    font-size: 14px; font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}
.save-btn:hover { background: #A98A61; }

</style>

<div class="bookshelf-container">
    <!-- LEFT PANE: Shelves -->
    <div class="shelves-pane">
        <div class="shelves-header">
            <div class="shelves-title">my bookshelf</div>
            <div class="search-icon">🔍</div>
        </div>

        <?php 
        $sections = [
            ['title' => '📖 READ', 'books' => $readBooks, 'id' => 'read'],
            ['title' => '⏳ TO READ (TBR)', 'books' => $tbrBooks, 'id' => 'tbr'],
            ['title' => '📖 CURRENTLY READING', 'books' => $crBooks, 'id' => 'cr'],
            ['title' => '💔 DID NOT FINISH (DNF)', 'books' => $dnfBooks, 'id' => 'dnf'],
        ];
        ?>

        <?php foreach($sections as $sec): ?>
        <div class="shelf-group">
            <div class="shelf-label">
                <span><?= $sec['title'] ?></span>
                <span><?= count($sec['books']) ?> books ❯</span>
            </div>
            <div class="wood-shelf">
                <?php foreach($sec['books'] as $b): ?>
                    <div class="book-item" 
                         style="background-image: url('<?= base_url('uploads/covers/'.($b['cover_image'] ?: 'placeholder.jpg')) ?>')"
                         onclick='selectBook(<?= json_encode($b) ?>, this)'>
                    </div>
                <?php endforeach; ?>
                <?php if(empty($sec['books'])): ?>
                    <div style="opacity: 0.5; font-size: 12px; margin-bottom: 20px;">Rak kosong...</div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- RIGHT PANE: Details -->
    <div class="detail-pane" id="detailPane">
        <div class="book-header">
            <div class="book-header-cover" id="detCover"></div>
            <div class="book-header-info">
                <h2 id="detTitle">Book Title</h2>
                <p id="detAuthor">Author Name</p>
                <div class="star-rating">★★★★☆ <span style="color:#333;font-size:14px;font-weight:bold" id="detRating">4.2</span></div>
                <div class="tags">
                    <div class="tag" id="detFormat">Ebook</div>
                    <select class="tag" style="border:none; outline:none; background:#C4A47C; color:#FFF; cursor:pointer;" id="detStatus" onchange="updateShelfStatus(this.value)">
                        <option value="tbr">⏳ TBR</option>
                        <option value="read">📖 Read</option>
                        <option value="dnf">💔 DNF</option>
                    </select>
                </div>
            </div>
        </div>

        <form id="bookshelfForm" onsubmit="saveDetails(event)">
            <?= csrf_field() ?>
            <input type="hidden" id="detBookId" name="book_id">
            
            <div class="detail-card">
                <div class="detail-card-title">Mood & Feelings</div>
                <div class="mood-grid">
                    <?php 
                    $moodList = [
                        'nostalgic' => '🍂', 'melancholic' => '🌧️', 'inspired' => '☀️', 
                        'thoughtful' => '🤎', 'emotional' => '💧'
                    ];
                    foreach($moodList as $m => $icon): ?>
                    <div class="mood-btn" onclick="toggleMood('<?= $m ?>', this)" data-mood="<?= $m ?>">
                        <div class="mood-icon"><?= $icon ?></div>
                        <div class="mood-label"><?= $m ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="moods" id="detMoods">
            </div>

            <div class="detail-card">
                <div class="detail-card-title">Notes & Reflections</div>
                <textarea class="journal-input" name="notes" id="detNotes" rows="4" placeholder="Tulislah refleksimu di sini..."></textarea>
            </div>

            <div class="detail-card">
                <div class="detail-card-title">Favorite Quotes</div>
                <div class="quote-box">
                    <textarea class="journal-input" name="favorite_quotes" id="detQuotes" rows="3" placeholder="Kutipan favorit yang berkesan..."></textarea>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-title">Extra Ratings (0-5)</div>
                <div class="rating-row">
                    <span>Romance</span>
                    <input type="number" step="0.1" max="5" min="0" name="rating_romance" id="detRomance" style="width: 50px;">
                </div>
                <div class="rating-row">
                    <span>Spice</span>
                    <input type="number" step="0.1" max="5" min="0" name="rating_spice" id="detSpice" style="width: 50px;">
                </div>
                <div class="rating-row">
                    <span>Sadness</span>
                    <input type="number" step="0.1" max="5" min="0" name="rating_sadness" id="detSadness" style="width: 50px;">
                </div>
                <div class="rating-row">
                    <span>Writing Style</span>
                    <input type="number" step="0.1" max="5" min="0" name="rating_writing" id="detWriting" style="width: 50px;">
                </div>
            </div>

            <button type="submit" class="save-btn" id="saveBtn">Simpan Jurnal & Rating</button>
        </form>
    </div>
</div>

<script>
let selectedMoods = [];

function selectBook(book, el) {
    // Styling seleksi rak
    document.querySelectorAll('.book-item').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');

    // Tampilkan panel detail
    document.getElementById('detailPane').classList.add('active');

    // Set Data Dasar
    document.getElementById('detBookId').value = book.book_id;
    document.getElementById('detCover').style.backgroundImage = `url('<?= base_url('uploads/covers/') ?>${book.cover_image || 'placeholder.jpg'}')`;
    document.getElementById('detTitle').innerText = book.title;
    document.getElementById('detAuthor').innerText = book.author;
    document.getElementById('detRating').innerText = book.rating;
    document.getElementById('detFormat').innerText = book.format;

    // Set Jurnal & Teks
    document.getElementById('detNotes').value = book.notes || '';
    document.getElementById('detQuotes').value = book.favorite_quotes || '';
    document.getElementById('detRomance').value = book.rating_romance || 0;
    document.getElementById('detSpice').value = book.rating_spice || 0;
    document.getElementById('detSadness').value = book.rating_sadness || 0;
    document.getElementById('detWriting').value = book.rating_writing || 0;
    document.getElementById('detStatus').value = book.status || 'tbr';

    // Moods Parsing
    selectedMoods = [];
    if(book.moods) {
        try { selectedMoods = JSON.parse(book.moods); } catch(e) {}
    }
    document.querySelectorAll('.mood-btn').forEach(btn => {
        let m = btn.getAttribute('data-mood');
        if(selectedMoods.includes(m)) btn.classList.add('active');
        else btn.classList.remove('active');
    });
    document.getElementById('detMoods').value = JSON.stringify(selectedMoods);
}

function toggleMood(mood, el) {
    el.classList.toggle('active');
    if(selectedMoods.includes(mood)) {
        selectedMoods = selectedMoods.filter(m => m !== mood);
    } else {
        selectedMoods.push(mood);
    }
    document.getElementById('detMoods').value = JSON.stringify(selectedMoods);
}

async function saveDetails(e) {
    e.preventDefault();
    const btn = document.getElementById('saveBtn');
    btn.innerText = 'Menyimpan...';

    const formData = new FormData(document.getElementById('bookshelfForm'));
    
    // Konversi JSON Moods sebelum kirim (opsional karena sudah ada input hidden, tp untuk memastikan)
    const data = Object.fromEntries(formData.entries());
    data.moods = selectedMoods; // array dikirimkan

    try {
        const res = await fetch('<?= base_url('my-bookshelf/save') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if(result.success) {
            btn.innerText = 'Tersimpan!';
            setTimeout(() => btn.innerText = 'Simpan Jurnal & Rating', 2000);
        }
    } catch (err) {
        btn.innerText = 'Gagal menyimpan!';
        setTimeout(() => btn.innerText = 'Simpan Jurnal & Rating', 2000);
    }
}

async function updateShelfStatus(status) {
    const id = document.getElementById('detBookId').value;
    try {
        const res = await fetch('<?= base_url('my-bookshelf/update-status') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                'id': id,
                'status': status,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            })
        });
        const result = await res.json();
        if(result.success) {
            location.reload(); // Reload to reflect changes visually in the shelf
        }
    } catch (err) {
        alert('Gagal memindah buku');
    }
}
</script>

<?= $this->endSection() ?>
