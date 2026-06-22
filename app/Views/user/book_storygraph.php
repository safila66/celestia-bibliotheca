<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
  .star-slider {
      -webkit-appearance: none;
      width: 250px;
      height: 12px;
      background: rgba(4,6,15,0.5);
      border-radius: 6px;
      outline: none;
      border: 1px solid var(--gold, #C9A84C);
  }
  .star-slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 40px;
      height: 40px;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23C9A84C" stroke="%23fff" stroke-width="1"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>') no-repeat center;
      background-size: contain;
      cursor: pointer;
  }
  .star-slider::-moz-range-thumb {
      width: 40px;
      height: 40px;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23C9A84C" stroke="%23fff" stroke-width="1"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>') no-repeat center;
      background-size: contain;
      cursor: pointer;
      border: none;
  }

  /* Base Layout */
  .sg-container {
    padding: 120px 5% 80px;
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 60px;
    color: var(--text);
  }

  /* Left Column */
  .sg-left {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }
  .sg-cover {
    width: 100%;
    aspect-ratio: 2/3;
    object-fit: cover;
    border-radius: 4px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    background: #1a1a2e;
  }
  .sg-title {
    font-family: 'Cinzel', serif;
    font-size: 28px;
    color: var(--ivory);
    line-height: 1.2;
    margin-bottom: 4px;
  }
  .sg-author {
    font-size: 16px;
    color: var(--gold-light);
    margin-bottom: 12px;
  }
  .sg-meta {
    font-size: 13px;
    color: var(--text-dim);
    margin-bottom: 16px;
    font-style: italic;
  }
  .sg-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 24px;
  }
  .sg-tag {
    font-family: 'Raleway', sans-serif;
    font-size: 13px;
    letter-spacing: 0.1em;
    padding: 6px 12px;
    border: 1px solid rgba(201,168,76,0.3);
    border-radius: 4px;
    color: var(--gold);
    text-transform: lowercase;
  }
  .sg-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .sg-btn {
    width: 100%;
    padding: 12px;
    text-align: center;
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
  }
  .sg-btn-primary {
    background: var(--gold);
    color: var(--deep-navy);
    border: none;
    font-weight: 700;
  }
  .sg-btn-primary:hover { background: var(--gold-light); transform: translateY(-2px); }
  .sg-btn-secondary {
    background: rgba(4,6,15,0.5);
    color: var(--ivory);
    border: 1px solid rgba(255,255,255,0.2);
  }
  .sg-btn-secondary:hover { background: rgba(255,255,255,0.1); border-color: var(--gold); }

  /* Right Column */
  .sg-right {
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  .sg-block {
    background: var(--panel, rgba(30,35,45,0.4));
    border: 1px solid var(--border, rgba(255,255,255,0.1));
    border-radius: 8px;
    padding: 30px;
  }
  
  .sg-block-title {
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 20px;
    font-weight: 700;
  }

  /* Description */
  .sg-desc {
    font-size: 15px;
    line-height: 1.8;
    color: var(--text);
  }

  /* Reviews & Moods */
  .sg-rating {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
  }
  .sg-score { font-size: 42px; font-weight: 700; color: #6DB3B3; }
  .sg-stars { color: #F0C420; font-size: 20px; }
  .sg-review-count { font-size: 13px; color: #6DB3B3; text-decoration: underline; }
  
  .sg-moods {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 14px;
    color: var(--text);
  }
  .sg-mood { display: flex; align-items: center; gap: 6px; }
  .sg-mood-val { color: var(--text-dim); }
  .sg-mood-label { font-size: 13px; color: var(--gold-light); }

  [data-theme="light"] .sg-tracker-form input,
  [data-theme="light"] .sg-tracker-form select,
  [data-theme="light"] textarea,
  [data-theme="light"] input[type="text"],
  [data-theme="light"] input[type="number"],
  [data-theme="light"] select {
      color: #1a1a2e !important;
      background: #f0f0f0 !important;
      border: 1px solid #ccc !important;
  }
  [data-theme="light"] textarea::placeholder {
      color: #666 !important;
  }
  [data-theme="light"] .sg-btn-secondary {
      color: #1a1a2e !important;
  }

  /* User Reviews List */
  .sg-user-reviews {
    margin-top: 30px;
    border-top: 1px solid var(--border);
    padding-top: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .sg-user-review {
    display: flex;
    gap: 16px;
  }
  .sg-user-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--gold-dim); display: flex; align-items: center; justify-content: center;
    font-weight: bold; color: var(--deep-navy); flex-shrink: 0;
  }
  .sg-user-comment {
    background: rgba(0,0,0,0.15);
    padding: 16px; border-radius: 8px;
    font-size: 14px; line-height: 1.6;
    flex: 1;
  }
  .sg-user-name { font-weight: bold; color: var(--gold-light); margin-bottom: 6px; font-size: 13px; }

  /* Stats Bars */
  .sg-stat-group {
    margin-bottom: 30px;
    text-align: center;
  }
  .sg-stat-q {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 16px;
    color: var(--ivory);
  }
  .sg-bar-wrap {
    display: flex;
    height: 24px;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 12px;
    background: rgba(0,0,0,0.2);
  }
  .sg-bar-segment {
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: #fff;
    transition: width 1s ease;
  }
  .sg-legend {
    display: flex;
    justify-content: center;
    gap: 20px;
    font-size: 12px;
    color: var(--text-dim);
  }
  .sg-legend-item { display: flex; align-items: center; gap: 6px; }
  .sg-dot { width: 10px; height: 10px; border-radius: 50%; }

  /* Colors for bars */
  .c-orange { background: #E68A2E; }
  .c-red { background: #D94856; }
  .c-purple { background: #713873; }
  .c-blue { background: #1B7A9B; }
  .c-teal { background: #4DB3B3; }
  .c-light { background: #A3D9D9; color: #333 !important; }

  /* Fix Option Color */
  .sg-btn-secondary option { background: var(--deep-navy); color: var(--ivory); }
  [data-theme="light"] .sg-btn-secondary option { background: #fff; color: #333; }

  /* Mood Card Styles */
  .sg-moods {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
  }
  .sg-mood-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
  }
  .sg-mood-icon-box {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: rgba(201,168,76,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold);
    transition: transform 0.3s;
  }
  .sg-mood-icon-box:hover { transform: translateY(-4px); background: rgba(201,168,76,0.2); }
  .sg-mood-label {
    font-size: 11px;
    font-family: 'Raleway', sans-serif;
    color: var(--text-dim);
  }

  /* Advanced Review Form Styles */
  .review-header { text-align: center; margin-bottom: 24px; }
  .review-title { font-size: 20px; font-weight: bold; color: #4DB3B3; margin-bottom: 12px; font-family: 'Raleway', sans-serif; }
  .review-subtitle { font-size: 14px; font-weight: bold; margin-bottom: 12px; }
  
  .rating-inputs { display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 6px; }
  .rating-select { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: var(--ivory); padding: 8px 12px; border-radius: 4px; font-size: 14px; }
  
  .mood-pills { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 24px; }
  .mood-pill {
      background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2);
      border-radius: 20px; padding: 6px 16px; font-size: 13px; cursor: pointer;
      display: flex; align-items: center; gap: 6px; transition: all 0.2s;
  }
  .mood-pill.active { background: rgba(201,168,76,0.2); border-color: var(--gold); color: var(--gold-light); }
  
  .adv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
  .adv-label { display: block; font-size: 14px; font-weight: bold; margin-bottom: 8px; }
  .adv-select, .adv-input { width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2); color: var(--ivory); padding: 10px; border-radius: 4px; font-size: 14px; font-family: inherit; }
  
  .ql-container { font-family: 'Raleway', sans-serif !important; font-size: 15px !important; }
  .ql-toolbar.ql-snow { border-color: rgba(255,255,255,0.2) !important; background: rgba(0,0,0,0.3); }
  .ql-container.ql-snow { border-color: rgba(255,255,255,0.2) !important; min-height: 150px; background: rgba(0,0,0,0.2); color: var(--ivory); }
  .ql-stroke { stroke: var(--ivory) !important; }
  .ql-fill { fill: var(--ivory) !important; }

  [data-theme="light"] .rating-select,
  [data-theme="light"] .adv-select,
  [data-theme="light"] .adv-input,
  [data-theme="light"] .sg-block {
      background: #E5E5E5; /* Slightly darker than before to contrast with cream background */
      border-color: rgba(0,0,0,0.2);
  }
  [data-theme="light"] .rating-select,
  [data-theme="light"] .adv-select,
  [data-theme="light"] .adv-input,
  [data-theme="light"] .mood-pill {
      background: #FFFFFF; border-color: #999; color: #1a1a2e;
  }
  [data-theme="light"] .mood-pill.active { background: rgba(201,168,76,0.3); border-color: #A8752A; color: #A8752A; }
  [data-theme="light"] .ql-toolbar.ql-snow { background: #D1D1D1; border-color: #999 !important; }
  [data-theme="light"] .ql-container.ql-snow { background: #FFFFFF; color: #1a1a2e; border-color: #999 !important; }
  [data-theme="light"] .ql-stroke { stroke: #1a1a2e !important; }
  [data-theme="light"] .ql-fill { fill: #1a1a2e !important; }
  
  .review-submit-btn { background: #fff; color: #333; font-weight: bold; padding: 12px 30px; border-radius: 4px; border: none; font-size: 14px; cursor: pointer; transition: background 0.2s; display: block; margin: 0 auto; text-transform: uppercase; letter-spacing: 0.05em; }
  .review-submit-btn:hover { background: #e0e0e0; }
  [data-theme="light"] .review-submit-btn { background: #333; color: #fff; }
  [data-theme="light"] .review-submit-btn:hover { background: #111; }

  .pdf-btn {
    padding: 8px 16px; border-radius: 4px; cursor: pointer;
    background: rgba(201,168,76,0.1); border: 1px solid rgba(201,168,76,0.3); color: var(--gold);
    transition: all 0.2s; font-family: 'Raleway', sans-serif;
  }
  .pdf-btn:hover { background: rgba(201,168,76,0.2); }
  .pdf-page-indicator {
    font-family: 'Raleway', sans-serif; font-weight: bold; font-size: 14px; color: var(--text);
  }
</style>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$bookTags = [];
if (!empty($book['genres'])) {
    $bookTags = explode(',', $book['genres']);
} else {
    $bookTags = ['fiction']; // fallback
}

$moodIcons = [
    'nostalgic' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
    'melancholic' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="30" height="30"><path d="M17.5 19c-1.5 0-2.5-1-3-2-.5 1-1.5 2-3 2s-2.5-1-3-2c-.5 1-1.5 2-3 2-1.66 0-3-1.34-3-3 0-1.66 1.34-3 3-3 .5 0 1 .16 1.42.42A4.97 4.97 0 0 1 12 11c1.9 0 3.55 1.05 4.38 2.58A2.99 2.99 0 0 1 17.5 13c1.66 0 3 1.34 3 3s-1.34 3-3 3z"/><path d="M12 11V3"/></svg>',
    'inspired' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="30" height="30"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>',
    'thoughtful' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="26" height="26"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
    'emotional' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="28" height="28"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>',
    'mysterious' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="28" height="28"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
    'tense' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="26" height="26"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>',
    'dark' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="26" height="26"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>',
    'adventurous' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="26" height="26"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>',
    'funny' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="26" height="26"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>'
];
?>

<div class="sg-container">
  <!-- LEFT COLUMN -->
  <div class="sg-left">
    <img src="/assets/covers/<?= esc($book['cover_image'] ?? 'default-cover.jpg') ?>" class="sg-cover" alt="Cover" onerror="this.src='https://via.placeholder.com/320x480/1a1a2e/C9A84C?text=No+Cover'">
    


    <div class="sg-tags">
      <?php foreach($bookTags as $t): ?>
        <a href="/catalog?genre=<?= urlencode(trim($t)) ?>" class="sg-tag" style="text-decoration:none;"><?= $t ?></a>
      <?php endforeach; ?>
    </div>

    <div class="sg-actions">
      <!-- Wishlist Action -->
      <form id="wishlistForm" onsubmit="toggleWishlist(event, <?= $book['id'] ?>)" style="width:100%; margin-bottom: 10px;">
         <button type="submit" id="wishlistBtn" class="sg-btn sg-btn-secondary" style="display:flex; justify-content:center; align-items:center; gap:8px;">
            <span id="wishlistIcon" style="font-size: 16px; color: <?= (isset($inWishlist) && $inWishlist) ? '#ff4757' : 'inherit' ?>;">♥</span>
            <span id="wishlistText"><?= (isset($inWishlist) && $inWishlist) ? 'Remove from Wishlist' : 'Add to Wishlist' ?></span>
         </button>
      </form>
      
      <!-- Add to List Action -->
      <button type="button" onclick="document.getElementById('addToListModal').style.display='flex'" class="sg-btn sg-btn-secondary" style="display:flex; justify-content:center; align-items:center; gap:8px;">
         <span style="font-size: 16px;">+</span>
         <span>Add to List</span>
      </button>

      <!-- Modal Add to List -->
      <div id="addToListModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
          <div style="background:var(--bg-card); border:1px solid var(--border-gold); padding:30px; border-radius:8px; width:400px; color:#fff;">
              <h3 style="font-family:'Cinzel', serif; color:var(--gold); margin-top:0;">Tambah ke List</h3>
              <form id="addToListForm" onsubmit="submitAddToList(event)">
                  <?= csrf_field() ?>
                  <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                  
                  <div style="margin-bottom: 20px;">
                      <label style="display:block; font-size:12px; color:#CCC; margin-bottom:5px;">Pilih List *</label>
                      <select name="list_id" required style="width:100%; padding:8px; background:rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.2); color:#fff; border-radius:4px;">
                          <option value="">-- Pilih List --</option>
                          <?php if(isset($userLists) && count($userLists) > 0): ?>
                              <?php foreach($userLists as $ulist): ?>
                                  <option value="<?= $ulist['id'] ?>"><?= esc($ulist['title']) ?></option>
                              <?php endforeach; ?>
                          <?php else: ?>
                              <option disabled>Belum ada list, buat di menu Profil Anda.</option>
                          <?php endif; ?>
                      </select>
                  </div>
                  
                  <div style="display:flex; justify-content:flex-end; gap:10px;">
                      <button type="button" onclick="document.getElementById('addToListModal').style.display='none'" style="padding:8px 16px; background:transparent; color:#CCC; border:none; cursor:pointer;">Batal</button>
                      <button type="submit" style="padding:8px 16px; background:var(--gold); color:#000; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">Simpan</button>
                  </div>
              </form>
          </div>
      </div>
      <script>
      function submitAddToList(e) {
          e.preventDefault();
          const form = document.getElementById('addToListForm');
          const formData = new FormData(form);

          fetch('<?= base_url('profil/list/add-book') ?>', {
              method: 'POST',
              headers: { 'X-Requested-With': 'XMLHttpRequest' },
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert(data.message);
                  document.getElementById('addToListModal').style.display = 'none';
              } else {
                  alert(data.message || 'Gagal menambahkan ke list.');
              }
          })
          .catch(error => {
              console.error('Error:', error);
              alert('Terjadi kesalahan pada server.');
          });
      }
      </script>      <!-- Reading Tracker -->
      <!-- Reading Tracker -->
      <div style="margin-top: 8px;">
         <form id="trackerForm" class="sg-tracker-form" style="display:flex; flex-direction:column; gap:8px;">
           <select name="status" class="sg-btn sg-btn-secondary" id="trackerStatus" onchange="handleTrackerChange(this.value)" style="width:100%; text-align:center; text-align-last:center; appearance:none; cursor:pointer; background-image: url('data:image/svg+xml;utf8,<svg fill=\'%23C9A84C\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/><path d=\'M0 0h24v24H0z\' fill=\'none\'/></svg>'); background-repeat: no-repeat; background-position-x: 95%; background-position-y: 5px;">
              <option value="to_read" <?= (isset($tracker) && $tracker['status']=='to_read')?'selected':'' ?>>TO READ</option>
              <option value="read" <?= (isset($tracker) && $tracker['status']=='read')?'selected':'' ?>>READ</option>
              <option value="currently_reading" <?= (isset($tracker) && $tracker['status']=='currently_reading')?'selected':'' ?>>CURRENTLY READING</option>
              <option value="did_not_finish" <?= (isset($tracker) && $tracker['status']=='did_not_finish')?'selected':'' ?>>DID NOT FINISH</option>
              <option value="remove">REMOVE BOOK</option>
           </select>
           
           <?php 
             $currProgress = isset($tracker) ? (int)$tracker['progress'] : 0;
             $totalPages = isset($book['pages']) && $book['pages'] > 0 ? (int)$book['pages'] : 100;
             $pct = round(($currProgress / $totalPages) * 100);
             if($pct > 100) $pct = 100;
           ?>
           <div id="progressInput" style="display: <?= (isset($tracker) && $tracker['status']=='currently_reading')?'flex':'none' ?>; flex-direction:column; gap:12px; align-items:flex-start; margin-top:8px; background: rgba(0,0,0,0.2); padding: 12px; border-radius: 8px;">
                <!-- PROGRESS BAR -->
                <div style="width:100%; height: 28px; background: rgba(0,0,0,0.3); border-radius: 4px; overflow:hidden; position:relative;">
                    <div style="height: 100%; width: <?= $pct ?>%; background: #10B981; transition: width 0.3s; display:flex; align-items:center; padding-left:8px; color:white; font-size:13px; font-weight:bold;">
                       <?= $pct ?>%
                    </div>
                </div>

                <div style="font-size: 13px; font-weight: bold; color: var(--gold); display: flex; align-items: center; gap: 6px;">
                    Track progress
                </div>
                
                <div style="width: 100%;">
                    <div style="font-size: 13px; font-weight: bold; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">Started <span style="font-size:12px;cursor:pointer;">✎</span></div>
                    <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                        <select name="started_day" class="sg-btn-secondary" style="padding: 6px; border-radius: 4px; width: 60px;">
                            <option value=""></option>
                            <?php for($i=1;$i<=31;$i++): ?><option value="<?= str_pad($i,2,'0',STR_PAD_LEFT) ?>"><?= $i ?></option><?php endfor; ?>
                        </select>
                        <select name="started_month" class="sg-btn-secondary" style="padding: 6px; border-radius: 4px; flex: 1;">
                            <option value=""></option>
                            <?php foreach(['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $k=>$v): ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="started_year" class="sg-btn-secondary" style="padding: 6px; border-radius: 4px; width: 80px;">
                            <option value=""></option>
                            <?php for($i=date('Y');$i>=2000;$i--): ?><option value="<?= $i ?>"><?= $i ?></option><?php endfor; ?>
                        </select>
                    </div>
                    <div style="color: #6DB3B3; font-size: 12px; cursor: pointer; text-decoration: underline; margin-bottom: 12px;" onclick="setTodayTracker()">Set to today</div>
                    
                    <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 16px;">
                        <input type="number" name="progress" value="<?= esc($tracker['progress'] ?? 0) ?>" class="sg-btn-secondary" style="width:80px; padding:6px; border-radius:4px; text-align:center;" placeholder="0">
                        <select name="progress_type" class="sg-btn-secondary" style="padding:6px; border-radius:4px;">
                            <option value="pages">pages</option>
                            <option value="%">%</option>
                        </select>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <button type="button" onclick="saveTracker()" class="sg-btn-primary" style="padding:8px 12px; border-radius:4px; border:none; cursor:pointer; font-size: 13px; font-weight:bold;">Update</button>
                        <span style="color: var(--text); font-size: 13px; text-decoration: underline; cursor: pointer; text-align:center;" onclick="document.getElementById('progressInput').style.display='none'">Cancel</span>
                    </div>
                </div>
            </div>
         </form>
      </div>
    </div>
  </div>

  <!-- RIGHT COLUMN -->
  <div class="sg-right">
    
    <!-- Identitas Buku & Description -->
    <div class="sg-block" style="padding: 40px;">
       <div style="font-family:'Cinzel',serif; font-size: 32px; color: var(--text); line-height: 1.1; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;"><?= esc($book['title']) ?></div>
       <div style="font-size: 16px; color: var(--gold-light); font-weight: bold; margin-bottom: 30px;">Oleh: <?= esc($book['author']) ?></div>

       <div style="display: grid; grid-template-columns: 120px 1fr; gap: 12px; font-size: 13px; color: var(--text-dim); border-top: 1px solid var(--border, rgba(255,255,255,0.1)); border-bottom: 1px solid var(--border, rgba(255,255,255,0.1)); padding: 20px 0; margin-bottom: 30px;">
           <div style="letter-spacing: 0.15em; text-transform: uppercase;">Kategori</div>
           <div style="text-align: right; color: var(--text);"><?= esc($book['category_name'] ?? '—') ?></div>
           
           <div style="letter-spacing: 0.15em; text-transform: uppercase;">Penerbit</div>
           <div style="text-align: right; color: var(--text);"><?= esc($book['publisher'] ?? '—') ?></div>

           <div style="letter-spacing: 0.15em; text-transform: uppercase;">Tahun</div>
           <div style="text-align: right; color: var(--text);"><?= esc($book['year'] ?? '—') ?></div>
           
           <div style="letter-spacing: 0.15em; text-transform: uppercase;">ISBN</div>
           <div style="text-align: right; color: var(--text);"><?= esc($book['isbn'] ?? '—') ?></div>

           <div style="letter-spacing: 0.15em; text-transform: uppercase;">Halaman</div>
           <div style="text-align: right; color: var(--text);"><?= esc($book['pages'] ?? '—') ?> hlm</div>

           <div style="letter-spacing: 0.15em; text-transform: uppercase;">Call No.</div>
           <div style="text-align: right; color: var(--text);"><?= esc($book['call_number'] ?? '—') ?></div>

           <div style="letter-spacing: 0.15em; text-transform: uppercase;">Stok</div>
           <div style="text-align: right; color: <?= ($book['stock_available'] ?? 0) > 0 ? '#7ec8a0' : '#e07070' ?>; font-weight: bold;">
               <span style="border: 1px solid <?= ($book['stock_available'] ?? 0) > 0 ? 'rgba(126,200,160,0.3)' : 'rgba(224,112,112,0.3)' ?>; padding: 4px 8px; border-radius: 4px; display: inline-block;">✦ <?= esc($book['stock_available'] ?? 0) ?> Tersedia</span>
           </div>
       </div>

       <div class="sg-desc" style="font-style: italic; margin-bottom: 30px; line-height: 1.8; color: var(--text);">
           <?= nl2br(esc($book['description'] ?? 'Deskripsi belum tersedia untuk buku ini.')) ?>
       </div>

       <a href="<?= session()->get('user_id') ? '/buku/'.$book['id'].'/pinjam-form' : '/login' ?>" class="sg-btn sg-btn-primary" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 14px; padding: 14px; text-decoration: none;">
           ✦ <?= session()->get('user_id') ? 'PINJAM BUKU INI' : 'LOGIN UNTUK MEMINJAM' ?>
       </a>
    </div>

    <?php
      $title_lower = strtolower($book['title']);
      $pdfFile = 'the_song_of_achilles_preview.pdf'; // default
      if (strpos($title_lower, 'achilles') !== false) {
          $pdfFile = 'the_song_of_achilles_preview.pdf';
      } elseif (strpos($title_lower, 'babel') !== false) {
          $pdfFile = 'babel_rf_kuang.pdf';
      } elseif (strpos($title_lower, 'white nights') !== false) {
          $pdfFile = 'white-nights.pdf';
      } elseif (strpos($title_lower, 'chaos') !== false || strpos($title_lower, 'sha po lang') !== false) {
          $pdfFile = 'Stars of Chaos_ Sha Po Lang Vol. 1.pdf';
      } elseif (strpos($title_lower, 'capital') !== false || strpos($title_lower, 'marx') !== false) {
          $pdfFile = 'capital-marx.pdf';
      }
    ?>
    
    <!-- Document Preview Slider -->
    <div class="sg-block" style="padding: 40px; margin-bottom: 30px;">
        <div class="sg-block-title" style="margin-bottom: 20px; font-size: 16px;">Document Preview</div>
        <div class="pdf-slider-container" style="position: relative; width: 100%; display: flex; flex-direction: column; align-items: center; background: var(--panel, rgba(30,35,45,0.8)); padding: 20px; border-radius: 8px;">
            <canvas id="pdf-canvas" style="max-width: 100%; max-height: 500px; object-fit: contain; cursor: pointer; border: 1px solid var(--border, rgba(255,255,255,0.1)); box-shadow: 0 4px 15px rgba(0,0,0,0.5);" title="Click left or right to change pages"></canvas>
            
            <div class="pdf-controls" style="display: flex; align-items: center; gap: 16px; margin-top: 20px;">
                <button type="button" id="pdf-prev" class="pdf-btn">← Prev</button>
                <span class="pdf-page-indicator"><span id="pdf-page-num">1</span> / <span id="pdf-page-count">10</span></span>
                <button type="button" id="pdf-next" class="pdf-btn">Next →</button>
            </div>
            <div style="font-size: 12px; color: var(--text-dim); margin-top: 8px; font-style: italic;">Preview limited to 10 pages</div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
      pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
      const pdfUrl = '/assets/pdfs/<?= $pdfFile ?>';
      let pdfDoc = null,
          pageNum = 1,
          pageIsRendering = false,
          pageNumIsPending = null;
      const maxPages = 10;
      
      const scale = 1.0,
            canvas = document.getElementById('pdf-canvas'),
            ctx = canvas.getContext('2d');

      const renderPage = num => {
        pageIsRendering = true;
        pdfDoc.getPage(num).then(page => {
          const viewport = page.getViewport({ scale });
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          const renderCtx = { canvasContext: ctx, viewport };
          page.render(renderCtx).promise.then(() => {
            pageIsRendering = false;
            if(pageNumIsPending !== null) {
              renderPage(pageNumIsPending);
              pageNumIsPending = null;
            }
          });
          document.getElementById('pdf-page-num').textContent = num;
        });
      };

      const queueRenderPage = num => {
        if(pageIsRendering) { pageNumIsPending = num; }
        else { renderPage(num); }
      };

      const showPrevPage = () => {
        if(pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
      };

      const showNextPage = () => {
        if(pageNum >= Math.min(pdfDoc.numPages, maxPages)) return;
        pageNum++;
        queueRenderPage(pageNum);
      };

      pdfjsLib.getDocument(pdfUrl).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        document.getElementById('pdf-page-count').textContent = Math.min(pdfDoc.numPages, maxPages);
        renderPage(pageNum);
      }).catch(err => {
         console.error('Error loading PDF:', err);
         canvas.style.display = 'none';
         document.querySelector('.pdf-controls').innerHTML = '<div style="color:#ff4757;">Error loading document preview.</div>';
      });

      document.getElementById('pdf-prev').addEventListener('click', showPrevPage);
      document.getElementById('pdf-next').addEventListener('click', showNextPage);

      // Click to slide implementation on the canvas
      canvas.addEventListener('click', (e) => {
        const rect = canvas.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        if (clickX > rect.width / 2) {
          showNextPage();
        } else {
          showPrevPage();
        }
      });
    </script>

    <!-- Write a Review Form -->
    <div class="sg-block" style="padding-top:40px; padding-bottom:40px;">
      <form id="reviewForm" onsubmit="submitReview(event, <?= $book['id'] ?>)">
          <div class="review-header">
              <div style="font-size: 20px; font-weight: bold; margin-bottom: 8px;">Add Review:</div>
              <div class="review-title"><?= esc($book['title']) ?></div>
              
              <div class="review-subtitle">Want to rate this book with stars?</div>
              <div class="rating-slider-container" style="display: flex; flex-direction: column; align-items: center; margin-top: 15px;">
                  <input type="range" name="rating" id="ratingSlider" min="0" max="5" step="0.25" value="0" class="star-slider">
                  <div class="rating-value-display" style="margin-top: 15px; font-size: 28px; color: var(--gold, #C9A84C); font-weight: bold; font-family: 'Cinzel', serif;">
                      <span id="ratingValTxt">0.0</span> <span style="font-size: 32px; text-shadow: 0 0 10px rgba(201,168,76,0.5);">★</span>
                  </div>
              </div>
              <div style="font-size:12px; color:var(--text-dim); text-align: center; margin-top: 5px;">Geser bintang untuk memberikan rating (mendukung desimal).</div>
          </div>

          <div style="margin-bottom: 30px;">
              <div class="adv-label" style="text-transform:uppercase; letter-spacing:1px; margin-bottom:12px;">Your Thoughts</div>
              <div id="quill-editor"></div>
              <input type="hidden" name="review_text" id="review_text_hidden">
          </div>

          <div style="margin-bottom: 30px;">
              <div class="review-subtitle">This book suits someone in the mood for something...</div>
              <div class="mood-pills">
                 <?php 
                 $availableMoods = ['adventurous', 'challenging', 'dark', 'emotional', 'funny', 'hopeful', 'informative', 'inspiring', 'lighthearted', 'mysterious', 'reflective', 'relaxing', 'sad', 'tense']; 
                 foreach($availableMoods as $am): 
                 ?>
                    <div class="mood-pill" onclick="toggleMood(this, '<?= $am ?>')">+ <?= $am ?></div>
                 <?php endforeach; ?>
                 <div id="mood-inputs-container"></div>
              </div>
          </div>

          <div class="adv-grid">
              <div>
                  <label class="adv-label">How would you rate the pace of this book?</label>
                  <select name="pace" class="adv-select">
                      <option value=""></option>
                      <option value="fast">Fast</option>
                      <option value="medium">Medium</option>
                      <option value="slow">Slow</option>
                  </select>
              </div>
              <div>
                  <label class="adv-label">Is this book mainly plot or character driven?</label>
                  <select name="plot_or_character" class="adv-select">
                      <option value=""></option>
                      <option value="plot">Plot</option>
                      <option value="mix">A Mix</option>
                      <option value="character">Character</option>
                  </select>
              </div>
              <div>
                  <label class="adv-label">Is there strong character development?</label>
                  <select name="strong_dev" class="adv-select">
                      <option value=""></option>
                      <option value="yes">Yes</option>
                      <option value="complicated">It's complicated</option>
                      <option value="no">No</option>
                  </select>
              </div>
              <div>
                  <label class="adv-label">Did you find the characters loveable?</label>
                  <select name="loveable" class="adv-select">
                      <option value=""></option>
                      <option value="yes">Yes</option>
                      <option value="complicated">It's complicated</option>
                      <option value="no">No</option>
                  </select>
              </div>
              <div>
                  <label class="adv-label">Is the cast of characters diverse?</label>
                  <select name="diverse" class="adv-select">
                      <option value=""></option>
                      <option value="yes">Yes</option>
                      <option value="complicated">It's complicated</option>
                      <option value="no">No</option>
                  </select>
              </div>
              <div>
                  <label class="adv-label">Are character flaws a main focus?</label>
                  <select name="flaws_focus" class="adv-select">
                      <option value=""></option>
                      <option value="yes">Yes</option>
                      <option value="complicated">It's complicated</option>
                      <option value="no">No</option>
                  </select>
              </div>
          </div>

          <div style="margin-bottom: 30px;">
              <label class="adv-label">To help other users find similar books, what would you say are the main themes, topics, or tropes covered in this book?</label>
              <input type="text" name="themes" class="adv-input" placeholder="">
              <div style="font-size:12px; color:var(--text-dim); margin-top:8px;">Aim for 1-5 comma-separated items. Your answer won't be publicly visible.</div>
          </div>
          
          <div style="margin-bottom: 30px;">
              <div style="font-weight:bold; font-size:14px; cursor:pointer; display:flex; align-items:center; gap:8px;" onclick="document.getElementById('cw-area').style.display = document.getElementById('cw-area').style.display === 'none' ? 'block' : 'none'">
                  <span style="font-size:18px;">›</span> Would you like to add any content warnings?
              </div>
              <div id="cw-area" style="display:none; margin-top:12px;">
                  <textarea name="content_warnings" class="adv-input" rows="3" placeholder="List any content warnings here..."></textarea>
              </div>
          </div>

          <button type="submit" class="review-submit-btn">Add Review</button>
          <div style="text-align:center; font-size:12px; color:var(--text-dim); margin-top:12px;">You can finish your review here, or continue on!</div>
      </form>
    </div>

    <!-- Community Reviews -->
    <div class="sg-block">
      <div class="sg-block-title">Community Reviews</div>
      <div class="sg-rating">
        <div class="sg-score"><?= $avg_rating ?></div>
        <div class="sg-stars" style="color:var(--gold); font-size:20px;"><?= str_repeat('★', round($avg_rating)) ?><?= str_repeat('☆', 5 - round($avg_rating)) ?></div>
        <div class="sg-review-count">based on <?= count($reviews) ?> reviews</div>
      </div>

      <?php if(!empty($moods)): ?>
      <div class="sg-block-title" style="margin-bottom:10px; font-size:12px;">Readers felt</div>
      <div class="sg-moods" style="margin-bottom:24px;">
        <?php foreach($moods as $mood => $pct): ?>
          <div class="sg-mood-card">
            <div class="sg-mood-icon-box" title="<?= $pct ?>% users felt this">
              <?= $moodIcons[$mood] ?? $moodIcons['inspired'] ?>
            </div>
            <div class="sg-mood-label"><?= $mood ?> (<?= $pct ?>%)</div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- Real User Reviews -->
      <div class="sg-user-reviews">
        <div class="sg-block-title" style="margin-bottom:16px;">What Readers Say</div>
        <?php if(!empty($reviews)): ?>
          <?php foreach($reviews as $r): ?>
          <div class="sg-user-review">
            <div class="sg-user-avatar"><?= strtoupper(substr($r['name'], 0, 1)) ?></div>
            <div class="sg-user-comment">
              <div class="sg-user-name" style="display:flex; justify-content:space-between;">
                 <span>@<?= esc($r['username'] ?? $r['name']) ?></span>
                 <span style="color:var(--gold); font-weight:bold;"><?= number_format((float)$r['rating'], 2) ?> ★</span>
              </div>
              <div style="margin-bottom:8px;" class="ql-editor ql-snow"><?= $r['review_text'] ?></div>
              <?php if(!empty($r['moods'])): ?>
                 <div style="font-size:11px; color:var(--gold-dim); font-style:italic;">Felt: <?= esc(str_replace(',', ', ', $r['moods'])) ?></div>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div style="color:var(--text-dim); font-size:13px; font-style:italic;">No reviews yet. Be the first to share your thoughts!</div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Stats -->
    <div class="sg-block">
      <?php
      $ts = $total_stats ?? 0;
      $p_fast = $ts > 0 ? round(($stats['pace']['fast'] / $ts) * 100) : 0;
      $p_med = $ts > 0 ? round(($stats['pace']['medium'] / $ts) * 100) : 0;
      $p_slow = $ts > 0 ? round(($stats['pace']['slow'] / $ts) * 100) : 0;

      $pc_plot = $ts > 0 ? round(($stats['plot_char']['plot'] / $ts) * 100) : 0;
      $pc_mix = $ts > 0 ? round(($stats['plot_char']['mix'] / $ts) * 100) : 0;
      $pc_char = $ts > 0 ? round(($stats['plot_char']['character'] / $ts) * 100) : 0;

      $d_yes = $ts > 0 ? round(($stats['dev']['yes'] / $ts) * 100) : 0;
      $d_comp = $ts > 0 ? round(($stats['dev']['complicated'] / $ts) * 100) : 0;
      $d_no = $ts > 0 ? round(($stats['dev']['no'] / $ts) * 100) : 0;

      $l_yes = $ts > 0 ? round(($stats['lov']['yes'] / $ts) * 100) : 0;
      $l_comp = $ts > 0 ? round(($stats['lov']['complicated'] / $ts) * 100) : 0;
      $l_no = $ts > 0 ? round(($stats['lov']['no'] / $ts) * 100) : 0;

      $div_yes = $ts > 0 ? round(($stats['div']['yes'] / $ts) * 100) : 0;
      $div_comp = $ts > 0 ? round(($stats['div']['complicated'] / $ts) * 100) : 0;
      $div_no = $ts > 0 ? round(($stats['div']['no'] / $ts) * 100) : 0;
      ?>
      
      <?php if($ts == 0): ?>
         <div style="color:var(--text-dim); font-size:13px; font-style:italic;">Not enough data yet. Write a review to contribute to these stats!</div>
      <?php else: ?>
          <!-- Pace -->
          <div class="sg-stat-group">
            <div class="sg-stat-q">Pace</div>
            <div class="sg-bar-wrap">
              <div class="sg-bar-segment c-orange" style="width: <?= $p_fast ?>%"><?= $p_fast > 0 ? $p_fast.'%' : '' ?></div>
              <div class="sg-bar-segment c-red" style="width: <?= $p_med ?>%"><?= $p_med > 0 ? $p_med.'%' : '' ?></div>
              <div class="sg-bar-segment c-purple" style="width: <?= $p_slow ?>%"><?= $p_slow > 0 ? $p_slow.'%' : '' ?></div>
            </div>
            <div class="sg-legend">
              <div class="sg-legend-item"><div class="sg-dot c-orange"></div>Fast</div>
              <div class="sg-legend-item"><div class="sg-dot c-red"></div>Medium</div>
              <div class="sg-legend-item"><div class="sg-dot c-purple"></div>Slow</div>
            </div>
          </div>
    
          <!-- Plot vs Character -->
          <div class="sg-stat-group">
            <div class="sg-stat-q">Plot or character driven?</div>
            <div class="sg-bar-wrap">
              <div class="sg-bar-segment c-orange" style="width: <?= $pc_plot ?>%"><?= $pc_plot > 0 ? $pc_plot.'%' : '' ?></div>
              <div class="sg-bar-segment c-red" style="width: <?= $pc_mix ?>%"><?= $pc_mix > 0 ? $pc_mix.'%' : '' ?></div>
              <div class="sg-bar-segment c-purple" style="width: <?= $pc_char ?>%"><?= $pc_char > 0 ? $pc_char.'%' : '' ?></div>
            </div>
            <div class="sg-legend">
              <div class="sg-legend-item"><div class="sg-dot c-orange"></div>Plot</div>
              <div class="sg-legend-item"><div class="sg-dot c-red"></div>A mix</div>
              <div class="sg-legend-item"><div class="sg-dot c-purple"></div>Character</div>
            </div>
          </div>
    
          <!-- Strong character dev -->
          <div class="sg-stat-group">
            <div class="sg-stat-q">Strong character development?</div>
            <div class="sg-bar-wrap">
              <div class="sg-bar-segment c-blue" style="width: <?= $d_yes ?>%"><?= $d_yes > 0 ? $d_yes.'%' : '' ?></div>
              <div class="sg-bar-segment c-teal" style="width: <?= $d_comp ?>%"><?= $d_comp > 0 ? $d_comp.'%' : '' ?></div>
              <div class="sg-bar-segment c-light" style="width: <?= $d_no ?>%"><?= $d_no > 0 ? $d_no.'%' : '' ?></div>
            </div>
            <div class="sg-legend">
              <div class="sg-legend-item"><div class="sg-dot c-blue"></div>Yes</div>
              <div class="sg-legend-item"><div class="sg-dot c-teal"></div>Complicated</div>
              <div class="sg-legend-item"><div class="sg-dot c-light"></div>No</div>
            </div>
          </div>
    
          <!-- Loveable characters -->
          <div class="sg-stat-group">
            <div class="sg-stat-q">Loveable characters?</div>
            <div class="sg-bar-wrap">
              <div class="sg-bar-segment c-blue" style="width: <?= $l_yes ?>%"><?= $l_yes > 0 ? $l_yes.'%' : '' ?></div>
              <div class="sg-bar-segment c-teal" style="width: <?= $l_comp ?>%"><?= $l_comp > 0 ? $l_comp.'%' : '' ?></div>
              <div class="sg-bar-segment c-light" style="width: <?= $l_no ?>%"><?= $l_no > 0 ? $l_no.'%' : '' ?></div>
            </div>
            <div class="sg-legend">
              <div class="sg-legend-item"><div class="sg-dot c-blue"></div>Yes</div>
              <div class="sg-legend-item"><div class="sg-dot c-teal"></div>Complicated</div>
              <div class="sg-legend-item"><div class="sg-dot c-light"></div>No</div>
            </div>
          </div>
    
          <!-- Diverse cast -->
          <div class="sg-stat-group">
            <div class="sg-stat-q">Diverse cast of characters?</div>
            <div class="sg-bar-wrap">
              <div class="sg-bar-segment c-blue" style="width: <?= $div_yes ?>%"><?= $div_yes > 0 ? $div_yes.'%' : '' ?></div>
              <div class="sg-bar-segment c-teal" style="width: <?= $div_comp ?>%"><?= $div_comp > 0 ? $div_comp.'%' : '' ?></div>
              <div class="sg-bar-segment c-light" style="width: <?= $div_no ?>%"><?= $div_no > 0 ? $div_no.'%' : '' ?></div>
            </div>
            <div class="sg-legend">
              <div class="sg-legend-item"><div class="sg-dot c-blue"></div>Yes</div>
              <div class="sg-legend-item"><div class="sg-dot c-teal"></div>Complicated</div>
              <div class="sg-legend-item"><div class="sg-dot c-light"></div>No</div>
            </div>
          </div>
      <?php endif; ?>
    </div>

  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
var quill = new Quill('#quill-editor', {
  theme: 'snow',
  placeholder: '',
  modules: {
    toolbar: [
      ['bold', 'italic', 'strike'],
      ['blockquote'],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      ['clean']
    ]
  }
});

const slider = document.getElementById('ratingSlider');
const text = document.getElementById('ratingValTxt');
if(slider && text) {
   slider.addEventListener('input', () => {
       let val = parseFloat(slider.value);
       text.innerText = val.toFixed(2).replace(/\.00$/, '');
   });
}


function toggleMood(element, mood) {
    element.classList.toggle('active');
    
    let container = document.getElementById('mood-inputs-container');
    let existingInput = document.getElementById('mood-input-' + mood);
    
    if(element.classList.contains('active')) {
        if(!existingInput) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'moods[]';
            input.value = mood;
            input.id = 'mood-input-' + mood;
            container.appendChild(input);
        }
    } else {
        if(existingInput) {
            existingInput.remove();
        }
    }
}

function handleTrackerChange(val) {
  if (val === 'currently_reading') {
    document.getElementById('progressInput').style.display = 'flex';
  } else {
    document.getElementById('progressInput').style.display = 'none';
    saveTracker();
  }
}

function saveTracker() {
  const form = document.getElementById('trackerForm');
  const formData = new FormData(form);
  
  // Calculate pages if progress type is %
  const pType = formData.get('progress_type');
  let pVal = parseFloat(formData.get('progress')) || 0;
  if (pType === '%') {
      const totalPages = <?= floatval($book['pages'] ?? 100) ?> || 100;
      pVal = Math.round((pVal / 100) * totalPages);
      formData.set('progress', pVal);
  }
  
  fetch('/book/update-tracker/<?= $book['id'] ?>', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if(data.status === 'success') {
      alert('Reading progress updated!');
      if(formData.get('status') === 'currently_reading') {
         location.reload(); 
      }
    }
  });
}

function setTodayTracker() {
    const today = new Date();
    document.querySelector('select[name="started_day"]').value = String(today.getDate()).padStart(2, '0');
    document.querySelector('select[name="started_month"]').value = String(today.getMonth() + 1).padStart(2, '0');
    document.querySelector('select[name="started_year"]').value = String(today.getFullYear());
}

function submitReview(e, bookId) {
    e.preventDefault();
    
    let html = quill.root.innerHTML;
    if(quill.getText().trim().length === 0) {
        html = '';
    }
    document.getElementById('review_text_hidden').value = html;
    
    const form = document.getElementById('reviewForm');
    const formData = new FormData(form);
    
    fetch('/book/submit-review/' + bookId, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            alert('Review submitted! Thank you. It will appear on the page shortly.');
            form.reset();
            quill.root.innerHTML = '';
            document.querySelectorAll('.sg-mood-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('mood-inputs-container').innerHTML = '';
        } else {
            alert(data.message || 'Error submitting review');
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred.');
    });
}

<?php if(isset($tracker) && $tracker['started_at']): ?>
    // Pre-fill date
    const d = new Date('<?= $tracker['started_at'] ?>');
    if (!isNaN(d.getTime())) {
        document.querySelector('select[name="started_day"]').value = String(d.getDate()).padStart(2, '0');
        document.querySelector('select[name="started_month"]').value = String(d.getMonth() + 1).padStart(2, '0');
        document.querySelector('select[name="started_year"]').value = String(d.getFullYear());
    }
<?php endif; ?>
function toggleWishlist(e, bookId) {
    e.preventDefault();
    fetch('/buku/' + bookId + '/wishlist', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            const icon = document.getElementById('wishlistIcon');
            const text = document.getElementById('wishlistText');
            if(data.isWishlisted) {
                icon.style.color = '#ff4757';
                text.innerText = 'Remove from Wishlist';
            } else {
                icon.style.color = 'inherit';
                text.innerText = 'Add to Wishlist';
            }
        } else {
            alert(data.message || 'Error updating wishlist');
        }
    })
    .catch(err => {
        console.error(err);
    });
}
</script>
<?= $this->endSection() ?>
