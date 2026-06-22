<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// ═══════════════════════════════════════════
// AUTH — Guest only (ditangani di controller)
// ═══════════════════════════════════════════
$routes->get('/login', 'AuthController::login');
$routes->post('/login/process', 'AuthController::processLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register/process', 'AuthController::processRegister');
$routes->get('/logout', 'AuthController::logout'); 

// ═══════════════════════════════════════════
// USER — Public (Akses tanpa login)
// ═══════════════════════════════════════════
$routes->get('/',               'HomeController::index');

$routes->get('/run-migrate', function() {
    $migrate = \Config\Services::migrations();
    try {
        $migrate->latest();
        return 'Migrations ran successfully';
    } catch (\Throwable $e) {
        return $e->getMessage();
    }
});
$routes->get('/truncate-bookshelf', function() {
    $db = \Config\Database::connect();
    $db->table('user_bookshelf_details')->truncate();
    return 'Bookshelf truncated!';
});

$routes->get('/search-qris', function() {
    $path = APPPATH . 'Views';
    $dir = new \RecursiveDirectoryIterator($path);
    $ite = new \RecursiveIteratorIterator($dir);
    $files = new \RegexIterator($ite, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);
    $result = "";
    foreach($files as $file) {
        $content = file_get_contents($file[0]);
        if (preg_match('/(qrserver|qris)/i', $content)) {
            $result .= str_replace($path, '', $file[0]) . "\n";
        }
    }
    return $result;
});

// Scan Endpoints (Mobile Scan)
$routes->get('scan/fine/(:num)', 'ScanController::scanFine/$1');
$routes->get('scan/room-booking/(:num)', 'ScanController::scanRoomBooking/$1');
$routes->get('scan/mendeley/(:num)', 'ScanController::scanMendeley/$1');
$routes->get('scan/language/(:num)', 'ScanController::scanLanguage/$1');

// API Endpoints for Real-Time Polling
$routes->get('api/check-fine/(:num)', 'ScanController::apiCheckFine/$1');
$routes->get('api/check-room-booking/(:num)', 'ScanController::apiCheckRoomBooking/$1');
$routes->get('api/check-mendeley/(:num)', 'ScanController::apiCheckMendeley/$1');
$routes->get('api/check-language/(:num)', 'ScanController::apiCheckLanguage/$1');

// ➔ INI RUTE UNTUK CONSTELLATIONS (catalog)
$routes->get('catalog',         'CatalogController::index'); 
$routes->get('book/detail/(:num)', 'BookController::detail/$1');  // ← duluan
$routes->get('book/(:num)',        'BookController::show/$1');     // ← belakangan
$routes->post('book/submit-review/(:num)', 'BookController::submitReview/$1');
$routes->post('book/update-tracker/(:num)', 'BookController::updateTracker/$1');

// Halaman Statis / Publik Tambahan
$routes->get('catalog/categories', 'CatalogController::categories');
$routes->get('collections',     'HomeController::collections');

// Virtual Reading Rooms
$routes->group('reading-rooms', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'ReadingRoomController::index');
    $routes->get('join/(:num)', 'ReadingRoomController::join/$1');
    $routes->post('join/(:num)', 'ReadingRoomController::processJoin/$1');
    $routes->get('room/(:num)', 'ReadingRoomController::room/$1');
});

$routes->get('archives',        'HomeController::archives');
$routes->get('about',           'HomeController::about');
$routes->get('mini-journalism', 'HomeController::journal');
$routes->get('mini-journalism/(:num)', 'HomeController::journalDetail/$1');
$routes->get('odoc/latest',     'HomeController::latestOdoc');
$routes->get('readers',         'UserController::index');
$routes->get('u/(:num)',        'UserController::publicProfile/$1');
$routes->post('u/follow/(:num)', 'UserController::toggleFollow/$1');

// ═══════════════════════════════════════════
// USER — Authenticated (filter: auth)
// ═══════════════════════════════════════════
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Sirkulasi Utama & Profil
    $routes->get('buku/(:num)/pinjam-form', 'HomeController::loanForm/$1');
    $routes->post('buku/(:num)/process-loan', 'HomeController::processLoan/$1');
    $routes->get('delivery-tracking/(:any)', 'HomeController::deliveryTracking/$1');
    $routes->post('buku/(:num)/pinjam',   'HomeController::loanBook/$1'); // Backward compatible
    $routes->post('buku/(:num)/wishlist', 'HomeController::toggleWishlist/$1');
    $routes->get('loan-saya',             'HomeController::myLoans');
    $routes->get('daftar-bacaan',         'HomeController::wishlist');
    $routes->get('profil',                'HomeController::profile');
    $routes->post('profil',               'HomeController::updateProfile');
    $routes->get('profil/tab/(:segment)', 'ProfileTabController::getTab/$1');
    $routes->post('profil/pay-fine/(:num)', 'HomeController::payFine/$1');
    $routes->post('profil/submit-journal', 'HomeController::submitJournal');
    
    // Lists Feature
    $routes->post('profil/list/create',        'ListController::create');
    $routes->get('profil/list/(:num)',         'ListController::detail/$1');
    $routes->post('profil/list/add-book',      'ListController::addBook');
    $routes->post('profil/list/remove-book/(:num)', 'ListController::removeBook/$1');
    $routes->post('profil/list/delete/(:num)', 'ListController::deleteList/$1');

    // My Bookshelf (Fitur Baru)
    $routes->get('my-bookshelf',          'BookshelfController::index');
    $routes->post('my-bookshelf/save',    'BookshelfController::saveDetails');
    $routes->post('my-bookshelf/add',     'BookshelfController::addToBookshelf');
    $routes->post('my-bookshelf/update-status', 'BookshelfController::updateStatus');

    // Unified Services
    $routes->get('services',              'ServiceController::index');
    $routes->get('seed-refs',             'ServiceController::seed');
    
    // Chatbot API
    $routes->post('chatbot/ask',          'ChatbotController::ask');

    // Layanan Perpustakaan Tambahan Actions
    $routes->get('book-delivery',         'ServiceController::bookDelivery');
    $routes->post('book-delivery/request', 'ServiceController::requestDelivery');
    
    $routes->get('room-booking',          'ServiceController::roomBooking');
    $routes->post('room-booking/book',    'ServiceController::bookRoom');
    $routes->match(['get', 'post'], 'room-booking/check-availability', 'ServiceController::checkRoomAvailability');
    
    $routes->get('referensi',             'ServiceController::referensi');
    $routes->post('referensi/borrow',     'ServiceController::borrowReference');
    
    $routes->get('sitasi',                'ServiceController::sitasi');
    $routes->post('sitasi/check',         'ServiceController::checkCitation');
    
    $routes->get('konsultasi',            'ServiceController::konsultasi');
    $routes->post('konsultasi/book',      'ServiceController::bookConsultation');
    
    $routes->get('mendeley-class',        'ServiceController::mendeleyClass');
    $routes->post('mendeley-class/register', 'ServiceController::registerMendeley');
    
    $routes->get('language-class',        'ServiceController::languageClass');
    $routes->get('language-class/detail/(:any)', 'ServiceController::languageClassDetail/$1');
    $routes->get('language-class/seats',  'ServiceController::languageClassSeats');
    $routes->post('language-class/register', 'ServiceController::registerLanguage');
    $routes->get('language-class/ticket/(:num)', 'ServiceController::languageClassTicket/$1');
});



// ═══════════════════════════════════════════
// ADMIN — filter: auth + admin
// ═══════════════════════════════════════════
$routes->group('admin', ['filter' => 'admin'], function($routes) {

    // Dashboard Utama
    $routes->get('/',           'Admin\DashboardController::index');
    $routes->get('dashboard',   'Admin\DashboardController::index');

    // ─── RUTING BARU DARI HASIL MERGE (CRUD LENGKAP ADMIN) ───

    // 1. MANAJEMEN BUKU (Koleksi)
    // Alias untuk tombol dashboard:
    $routes->get('books',                   'Admin\BookController::index'); 
    $routes->get('list/books',              'Admin\BookController::index');
    $routes->get('list/books/table',        'Admin\BookController::ajaxTable');
    $routes->get('ajax/create/book',        'Admin\BookController::ajaxCreate');
    $routes->get('ajax/edit/book/(:num)',   'Admin\BookController::ajaxEdit/$1');
    $routes->get('create/book',             'Admin\BookController::create');
    $routes->get('books/tambah',            'Admin\BookController::create');
    $routes->post('create/book',            'Admin\BookController::store');
    $routes->get('edit/book/(:num)',        'Admin\BookController::edit/$1');
    $routes->post('update/book/(:num)',     'Admin\BookController::update/$1');
    $routes->get('delete/book/(:num)',      'Admin\BookController::delete/$1');
    $routes->get('book/trash',              'Admin\BookController::trash');
    $routes->get('restore/book/(:num)',     'Admin\BookController::restore/$1');
    $routes->get('purge/book/(:num)',       'Admin\BookController::purge/$1');

    // 2. MANAJEMEN ANGGOTA (Members / Users)
    // Alias untuk tombol dashboard:
    $routes->get('users',                           'Admin\MemberController::index'); 
    $routes->get('list/members',                    'Admin\MemberController::index');
    $routes->get('list/members/table',              'Admin\MemberController::ajaxTable');
    $routes->get('ajax/create/members',              'Admin\MemberController::ajaxCreate');
    $routes->get('ajax/edit/members/(:num)',         'Admin\MemberController::ajaxEdit/$1');
    $routes->post('create/member',                  'Admin\MemberController::store');
    $routes->post('admin/members/store', 'Admin\MemberController::store');
    $routes->post('update/member/(:num)',           'Admin\MemberController::update/$1');
    $routes->get('delete/member/(:num)',            'Admin\MemberController::delete/$1');
    $routes->get('list/members/trash',              'Admin\MemberController::trash');
    $routes->get('restore/member/(:num)',           'Admin\MemberController::restore/$1');
    $routes->get('delete-permanent/member/(:num)',  'Admin\MemberController::deletePermanent/$1');
    
    

    // 3. MANAJEMEN PEMINJAMAN
    $routes->get('loan',                      'Admin\LoanController::index');
    $routes->get('list/loan',                 'Admin\LoanController::index');
    $routes->get('list/loan/table',           'Admin\LoanController::ajaxTable');
    $routes->get('ajax/create/loan',          'Admin\LoanController::ajaxCreate');
    $routes->get('ajax/edit/loan/(:num)',     'Admin\LoanController::ajaxEdit/$1');
    $routes->post('create/loan',              'Admin\LoanController::store');
    $routes->get('admin/loan/getData',        'Admin\LoanController::getData');
    $routes->post('update/loan/(:num)',       'Admin\LoanController::update/$1');
    $routes->get('delete/loan/(:num)',        'Admin\LoanController::delete/$1');
    $routes->get('approve/loan/(:num)',       'Admin\LoanController::approve/$1');
    $routes->get('complete/loan/(:num)',      'Admin\LoanController::complete/$1');

    // 4. MANAJEMEN PENGEMBALIAN
    $routes->get('return',                    'Admin\ReturnController::index');
    $routes->get('list/return',               'Admin\ReturnController::index');
    $routes->get('list/return/table',         'Admin\ReturnController::ajaxTable');
    $routes->get('ajax/create/return',        'Admin\ReturnController::ajaxCreate');
    $routes->get('ajax/edit/return/(:num)',   'Admin\ReturnController::ajaxEdit/$1');
    $routes->get('return/hapus/(:num)',       'Admin\ReturnController::hapus/$1');
    $routes->post('create/return',            'Admin\ReturnController::simpanPengembalian');
    $routes->post('update/return/(:num)',     'Admin\ReturnController::update/$1');
    $routes->post('delete/return/(:num)',     'Admin\ReturnController::delete/$1');

    // 5. MANAJEMEN report & CETAK LABEL
    $routes->get('report/buku',                    'Admin\ReportController::buku');
    $routes->get('report/cetak-buku',              'Admin\ReportController::cetakBuku');
    $routes->get('report/label-buku',              'Admin\ReportController::labelBuku');
    $routes->get('report/cetak-label-buku',        'Admin\ReportController::cetakLabelBuku');
    $routes->get('report/cetak-label-buku/(:num)', 'Admin\ReportController::cetakLabelSatu/$1');

    // 6. MANAJEMEN KATEGORI
    $routes->get('kategori',                'Admin\CategoryController::index');
    $routes->post('kategori/simpan',        'Admin\CategoryController::store');
    $routes->get('kategori/(:num)/hapus',   'Admin\CategoryController::delete/$1');
    $routes->post('categories/delete/(:num)', 'Admin\CategoryController::delete/$1');
    $routes->get('report/export', 'Admin\ReportController::exportCsv');

    // Monitor Layanan (Referensi, Sitasi, Konsultasi, Mendeley, Language)
    $routes->get('services', 'Admin\ServiceMonitorController::index');
    $routes->post('services/update-status/(:any)/(:num)', 'Admin\ServiceMonitorController::updateStatus/$1/$2');
    
    // Superadmin actions
    $routes->get('list/superadmin',                    'Admin\AdminManagementController::index');
    $routes->get('list/superadmin/table',              'Admin\AdminManagementController::ajaxTable');
    $routes->get('ajax/create/superadmin',             'Admin\AdminManagementController::ajaxCreate');
    $routes->post('list/superadmin/add',               'Admin\AdminManagementController::addAdmin');
    $routes->post('list/superadmin/delete/(:num)',     'Admin\AdminManagementController::deleteAdmin/$1');
    $routes->get('ajax/edit/superadmin/(:num)',        'Admin\AdminManagementController::ajaxEdit/$1');
    $routes->post('create/superadmin',                 'Admin\AdminManagementController::store');
    $routes->post('update/superadmin/(:num)',          'Admin\AdminManagementController::update/$1');
    $routes->get('delete/superadmin/(:num)',           'Admin\AdminManagementController::delete/$1');
    $routes->get('list/superadmin/trash',              'Admin\AdminManagementController::trash');
    $routes->get('restore/superadmin/(:num)',          'Admin\AdminManagementController::restore/$1');
    $routes->get('purge/superadmin/(:num)',            'Admin\AdminManagementController::purge/$1');

    // 8. MANAJEMEN JURNAL
    $routes->get('list/journals',              'Admin\JournalController::index');
    $routes->get('ajax/create/journal',        'Admin\JournalController::ajaxCreate');
    $routes->get('ajax/edit/journal/(:num)',   'Admin\JournalController::ajaxEdit/$1');
    $routes->post('create/journal',            'Admin\JournalController::store');
    $routes->post('update/journal/(:num)',     'Admin\JournalController::update/$1');
    $routes->get('delete/journal/(:num)',      'Admin\JournalController::delete/$1');
    $routes->get('list/journals/trash',        'Admin\JournalController::trash');
    $routes->get('restore/journal/(:num)',     'Admin\JournalController::restore/$1');
    $routes->get('purge/journal/(:num)',       'Admin\JournalController::purge/$1');

    // 8. MISSING SERVICES & LAPORAN
    // Delivery
    $routes->get('delivery',                  'Admin\DeliveryController::index');
    $routes->get('ajax/create/delivery',      'Admin\DeliveryController::ajaxCreate');
    $routes->post('create/delivery',          'Admin\DeliveryController::store');
    $routes->get('ajax/edit/delivery/(:num)', 'Admin\DeliveryController::ajaxEdit/$1');
    $routes->post('update/delivery/(:num)',   'Admin\DeliveryController::update/$1');
    $routes->get('delete/delivery/(:num)',    'Admin\DeliveryController::delete/$1');

    // Fines
    $routes->get('fines',                  'Admin\FineController::index');
    $routes->get('ajax/create/fine',       'Admin\FineController::ajaxCreate');
    $routes->post('create/fine',           'Admin\FineController::store');
    $routes->get('ajax/edit/fine/(:num)',  'Admin\FineController::ajaxEdit/$1');
    $routes->post('update/fine/(:num)',    'Admin\FineController::update/$1');
    $routes->get('delete/fine/(:num)',     'Admin\FineController::delete/$1');
    $routes->post('fines/markPaid/(:num)', 'Admin\FineController::markPaid/$1');

    // Room Bookings
    $routes->get('room-bookings',                  'Admin\RoomBookingController::index');
    $routes->get('ajax/create/room-booking',       'Admin\RoomBookingController::ajaxCreate');
    $routes->post('create/room-booking',           'Admin\RoomBookingController::store');
    $routes->get('ajax/edit/room-booking/(:num)',  'Admin\RoomBookingController::ajaxEdit/$1');
    $routes->post('update/room-booking/(:num)',    'Admin\RoomBookingController::update/$1');
    $routes->get('delete/room-booking/(:num)',     'Admin\RoomBookingController::delete/$1');

    // Laporan
    $routes->get('laporan',            'Admin\ReportController::index');
    $routes->get('report',             'Admin\ReportController::index');
    $routes->get('scanner',            '\App\Controllers\AdminScannerController::index');
    $routes->get('report/cetak-kartu-member',        'Admin\ReportController::cetakKartuMemberSemua');
    $routes->get('report/cetak-kartu-member/(:num)', 'Admin\ReportController::cetakKartuMemberSatu/$1');
    $routes->get('report/member',      'Admin\ReportController::member');

});