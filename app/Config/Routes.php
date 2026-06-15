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
// Rute untuk membuka halaman Ruang Baca (Detail Buku)
$routes->get('book/detail/(:num)', 'BookController::detail/$1');

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
    $routes->post('buku/(:num)/pinjam',   'HomeController::borrowBook/$1');
    $routes->post('buku/(:num)/wishlist', 'HomeController::toggleWishlist/$1');
    $routes->get('peminjaman-saya',       'HomeController::myBorrowings');
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

    // Dashboard
    $routes->get('/',                   'Admin\DashboardController::index');

    // Koleksi / Buku
    $routes->get('koleksi',             'Admin\BookController::index');
    $routes->get('koleksi/tambah',      'Admin\BookController::create');
    $routes->post('koleksi/simpan',     'Admin\BookController::store');
    $routes->get('koleksi/(:num)/edit', 'Admin\BookController::edit/$1');
    $routes->post('koleksi/(:num)/update','Admin\BookController::update/$1');
    $routes->get('koleksi/(:num)/hapus','Admin\BookController::delete/$1');

    // Peminjaman & Delivery
    $routes->get('peminjaman',                  'Admin\LoanController::index');
    $routes->get('peminjaman/(:num)/setujui',   'Admin\LoanController::approve/$1');
    $routes->get('peminjaman/(:num)/tolak',     'Admin\LoanController::reject/$1');
    $routes->get('peminjaman/(:num)/kembalikan','Admin\LoanController::returnBook/$1');
    $routes->get('delivery',                    'Admin\LoanController::deliveryQueue');

    // Kelola Layanan Tambahan
    $routes->get('room-bookings',       'Admin\RoomBookingController::index');
    $routes->get('fines',               'Admin\FineController::index');

    // Anggota
    $routes->get('anggota',             'Admin\UserController::index');
    $routes->get('anggota/(:num)',      'Admin\UserController::detail/$1');
    $routes->get('anggota/(:num)/toggle','Admin\UserController::toggleStatus/$1');

    // Kategori
    $routes->get('kategori',            'Admin\CategoryController::index');
    $routes->post('kategori/simpan',    'Admin\CategoryController::store');
    $routes->get('kategori/(:num)/hapus','Admin\CategoryController::delete/$1');

    // Laporan
    $routes->get('laporan',             'Admin\ReportController::index');
});