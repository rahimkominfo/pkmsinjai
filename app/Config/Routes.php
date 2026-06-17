<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Portal Utama (Root Domain tanpa PKM)
$routes->get('/', 'Home::index');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::process');
$routes->get('logout', 'Auth::logout');


$routes->group('admin/(:segment)', ['namespace' => 'App\Controllers\Admin', 'filter' => ['auth', 'tenant_filter']], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    // Artikel CRUD
    $routes->group('artikel', ['filter' => 'auth:Admin Dinkes,Admin PKM,Editor,Penulis'], function ($routes) {
        $routes->get('/', 'Artikel::index');
        $routes->get('create', 'Artikel::create');
        $routes->post('store', 'Artikel::store');
        $routes->get('edit/(:segment)', 'Artikel::edit/$2');
        $routes->post('update/(:segment)', 'Artikel::update/$2');
        $routes->get('delete/(:segment)', 'Artikel::delete/$2');
    });
    // Media CRUD
    $routes->group('media', ['filter' => 'auth:Admin Dinkes,Admin PKM,Editor,Penulis'], function ($routes) {
        $routes->get('/', 'Media::index');
        $routes->post('store', 'Media::store');
        $routes->get('delete/(:num)', 'Media::delete/$2');
    });
    // Kategori CRUD
    $routes->group('kategori', ['filter' => 'auth:Admin Dinkes,Admin PKM,Editor'], function ($routes) {
        $routes->get('/', 'Kategori::index');
        $routes->get('create', 'Kategori::create');
        $routes->post('store', 'Kategori::store');
        $routes->get('edit/(:segment)', 'Kategori::edit/$2');
        $routes->post('update/(:segment)', 'Kategori::update/$2');
        $routes->get('delete/(:segment)', 'Kategori::delete/$2');
    });
    // Galeri CRUD
    $routes->group('galeri', ['filter' => 'auth:Admin Dinkes,Admin PKM,Editor'], function ($routes) {
        $routes->get('/', 'Galeri::index');
        $routes->get('create', 'Galeri::create');
        $routes->post('store', 'Galeri::store');
        $routes->get('edit/(:num)', 'Galeri::edit/$2');
        $routes->post('update/(:num)', 'Galeri::update/$2');
        $routes->get('delete/(:num)', 'Galeri::delete/$2');
        $routes->get('delete_foto/(:num)', 'Galeri::delete_foto/$2');
    });
    // Antrian CRUD
    $routes->group('antrian', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'Antrian::index');
        $routes->get('create', 'Antrian::create');
        $routes->post('store', 'Antrian::store');
        $routes->get('edit/(:num)', 'Antrian::edit/$2');
        $routes->post('update/(:num)', 'Antrian::update/$2');
        $routes->post('update_status/(:num)', 'Antrian::updateStatus/$2');
        $routes->get('reset/(:num)', 'Antrian::reset/$2');
        $routes->get('delete/(:num)', 'Antrian::delete/$2');
    });
    // Statistik CRUD
    $routes->group('statistik', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'Statistik::index');
        $routes->post('import', 'Statistik::import');
    });
    // Update Antrian Loket (Pendaftaran & Poli)
    $routes->group('antrian-loket', ['filter' => 'auth:Admin Dinkes,Admin PKM,Antrian,Pendaftaran,Poli Umum,Poli Gigi,Farmasi'], function ($routes) {
        $routes->get('/', 'AntrianLoket::index');
        $routes->post('update/(:num)', 'AntrianLoket::update/$2');
    });
    // Pengguna CRUD
    $routes->group('pengguna', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'Pengguna::index');
        $routes->get('create', 'Pengguna::create');
        $routes->post('store', 'Pengguna::store');
        $routes->get('edit/(:segment)', 'Pengguna::edit/$2');
        $routes->post('update/(:segment)', 'Pengguna::update/$2');
        $routes->get('delete/(:segment)', 'Pengguna::delete/$2');
    });
    // Running Text CRUD
    $routes->group('running-text', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'RunningText::index');
        $routes->get('create', 'RunningText::create');
        $routes->post('store', 'RunningText::store');
        $routes->get('edit/(:num)', 'RunningText::edit/$2');
        $routes->post('update/(:num)', 'RunningText::update/$2');
        $routes->get('delete/(:num)', 'RunningText::delete/$2');
        $routes->get('toggle/(:num)', 'RunningText::toggle/$2');
    });
    // Peran CRUD
    $routes->group('peran', ['filter' => 'auth:Admin Dinkes'], function ($routes) {
        $routes->get('/', 'Peran::index');
        $routes->get('create', 'Peran::create');
        $routes->post('store', 'Peran::store');
        $routes->get('edit/(:num)', 'Peran::edit/$2');
        $routes->post('update/(:num)', 'Peran::update/$2');
        $routes->get('delete/(:num)', 'Peran::delete/$2');
    });
    // Pengaturan CRUD
    $routes->group('pengaturan', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'Pengaturan::index');
        $routes->get('create', 'Pengaturan::create');
        $routes->post('store', 'Pengaturan::store');
        $routes->get('edit/(:num)', 'Pengaturan::edit/$2');
        $routes->post('update/(:num)', 'Pengaturan::update/$2');
        $routes->get('delete/(:num)', 'Pengaturan::delete/$2');
    });
    // Menu CRUD
    $routes->group('menu', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'Menu::index');
        $routes->get('create', 'Menu::create');
        $routes->post('store', 'Menu::store');
        $routes->get('edit/(:num)', 'Menu::edit/$2');
        $routes->post('update/(:num)', 'Menu::update/$2');
        $routes->get('delete/(:num)', 'Menu::delete/$2');
    });
    // Pages CRUD
    $routes->group('pages', ['filter' => 'auth:Admin Dinkes,Admin PKM,Editor'], function ($routes) {
        $routes->get('/', 'Pages::index');
        $routes->get('create', 'Pages::create');
        $routes->post('store', 'Pages::store');
        $routes->get('edit/(:segment)', 'Pages::edit/$2');
        $routes->post('update/(:segment)', 'Pages::update/$2');
        $routes->get('delete/(:segment)', 'Pages::delete/$2');
    });
    // Flyer CRUD
    $routes->group('flyer', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'Flyer::index');
        $routes->get('create', 'Flyer::create');
        $routes->post('store', 'Flyer::store');
        $routes->get('edit/(:segment)', 'Flyer::edit/$2');
        $routes->post('update/(:segment)', 'Flyer::update/$2');
        $routes->get('delete/(:segment)', 'Flyer::delete/$2');
    });
    // SDM PKM CRUD
    $routes->group('sdm-pkm', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'SdmPkmController::index');
        $routes->get('create', 'SdmPkmController::create');
        $routes->post('store', 'SdmPkmController::store');
        $routes->get('edit/(:segment)', 'SdmPkmController::edit/$2');
        $routes->post('update/(:segment)', 'SdmPkmController::update/$2');
        $routes->get('delete/(:segment)', 'SdmPkmController::delete/$2');
    });
});

// Routing Multi-Tenant PKM (Frontend)
// 1. Group untuk Domain Kustom (Tanpa prefix segment)
$routes->group('', ['namespace' => 'App\Controllers\Frontend', 'filter' => 'tenant_filter'], function ($routes) {
    // Jalur ini hanya aktif jika filter berhasil mendeteksi tenant via hostname
    $routes->get('/', 'Dashboard::index');
    $routes->get('berita', 'Berita::index');
    $routes->get('berita/detail/(:segment)', 'Berita::detail/$1');
    $routes->get('galeri', 'Galeri::index');
    $routes->get('flayer', 'Flyer::index');
    $routes->get('flayer/(:segment)', 'Flyer::detail/$1');
    $routes->get('halaman/(:segment)', 'Pages::detail/$1');
    $routes->get('sdm-pkm', 'SdmPkm::index');
    $routes->get('display-antrian', 'DisplayAntrian::index');
    $routes->get('api/antrian', 'DisplayAntrian::data');
});

// 2. Group untuk Domain Utama dengan Segment Slug (Fallback)
$routes->group('(:segment)', ['namespace' => 'App\Controllers\Frontend', 'filter' => 'tenant_filter'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('berita', 'Berita::index');
    $routes->get('berita/detail/(:segment)', 'Berita::detail/$2');
    $routes->get('galeri', 'Galeri::index');
    $routes->get('flayer', 'Flyer::index');
    $routes->get('flayer/(:segment)', 'Flyer::detail/$2');
    $routes->get('halaman/(:segment)', 'Pages::detail/$2');
    $routes->get('sdm-pkm', 'SdmPkm::index');
    $routes->get('display-antrian', 'DisplayAntrian::index');
    $routes->get('api/antrian', 'DisplayAntrian::data');
});
