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

// ➔ INI RUTE UNTUK CONSTELLATIONS (catalog)
$routes->get('catalog',         'CatalogController::index'); 
$routes->get('book/detail/(:num)', 'BookController::detail/$1');  // ← duluan
$routes->get('book/(:num)',        'BookController::show/$1');     // ← belakangan

// Halaman Statis / Publik Tambahan
$routes->get('collections',     'HomeController::collections');
$routes->get('reading-rooms',   'HomeController::readingRooms');
$routes->get('archives',        'HomeController::archives');
$routes->get('about',           'HomeController::about');

// ═══════════════════════════════════════════
// USER — Authenticated (filter: auth)
// ═══════════════════════════════════════════
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Sirkulasi Utama & Profil
    $routes->post('buku/(:num)/pinjam',   'HomeController::loanBook/$1');
    $routes->post('buku/(:num)/wishlist', 'HomeController::toggleWishlist/$1');
    $routes->get('loan-saya',       'HomeController::myBorrowings');
    $routes->get('daftar-bacaan',         'HomeController::wishlist');
    $routes->get('profil',                'HomeController::profile');
    $routes->post('profil',               'HomeController::updateProfile');

    // Layanan Perpustakaan Tambahan
    $routes->get('book-delivery',         'ServiceController::bookDelivery');
    $routes->get('room-booking',          'ServiceController::roomBooking');
    $routes->get('libcafe',               'ServiceController::libcafe');
    $routes->get('referensi',             'ServiceController::referensi');
    $routes->get('sitasi',                'ServiceController::sitasi');
    $routes->get('konsultasi',            'ServiceController::konsultasi');
    $routes->get('mendeley-class',        'ServiceController::mendeleyClass');
    $routes->get('language-class',        'ServiceController::languageClass');
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
    $routes->get('admin/categories/table', 'Admin\CategoryController::table');

    // 7. MANAJEMEN ADMIN (Superadmin)
    $routes->get('list/superadmin',                    'Admin\AdminManagementController::index');
    $routes->get('list/superadmin/table',              'Admin\AdminManagementController::ajaxTable');
    $routes->get('ajax/create/superadmin',             'Admin\AdminManagementController::ajaxCreate');
    $routes->get('ajax/edit/superadmin/(:num)',        'Admin\AdminManagementController::ajaxEdit/$1');
    $routes->post('create/superadmin',                 'Admin\AdminManagementController::store');
    $routes->post('update/superadmin/(:num)',          'Admin\AdminManagementController::update/$1');
    $routes->get('delete/superadmin/(:num)',           'Admin\AdminManagementController::delete/$1');
    $routes->get('list/superadmin/trash',              'Admin\AdminManagementController::trash');
    $routes->get('restore/superadmin/(:num)',          'Admin\AdminManagementController::restore/$1');
    $routes->get('purge/superadmin/(:num)',            'Admin\AdminManagementController::purge/$1');

});