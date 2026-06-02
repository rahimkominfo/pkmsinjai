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


$routes->group('admin/(:segment)', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    // Artikel CRUD
    $routes->group('artikel', ['filter' => 'auth:Admin Dinkes,Admin PKM,Editor,Penulis'], function ($routes) {
        $routes->get('/', 'Artikel::index');
        $routes->get('create', 'Artikel::create');
        $routes->post('store', 'Artikel::store');
        $routes->get('edit/(:num)', 'Artikel::edit/$2');
        $routes->post('update/(:num)', 'Artikel::update/$2');
        $routes->get('delete/(:num)', 'Artikel::delete/$2');
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
        $routes->get('edit/(:num)', 'Kategori::edit/$2');
        $routes->post('update/(:num)', 'Kategori::update/$2');
        $routes->get('delete/(:num)', 'Kategori::delete/$2');
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
    // Update Antrian Loket (Pendaftaran & Poli)
    $routes->group('antrian-loket', ['filter' => 'auth:Admin Dinkes,Admin PKM,Pendaftaran,Poli Umum,Poli Gigi,Farmasi'], function ($routes) {
        $routes->get('/', 'AntrianLoket::index');
        $routes->post('update/(:num)', 'AntrianLoket::update/$2');
    });
    // Pengguna CRUD
    $routes->group('pengguna', ['filter' => 'auth:Admin Dinkes,Admin PKM'], function ($routes) {
        $routes->get('/', 'Pengguna::index');
        $routes->get('create', 'Pengguna::create');
        $routes->post('store', 'Pengguna::store');
        $routes->get('edit/(:num)', 'Pengguna::edit/$2');
        $routes->post('update/(:num)', 'Pengguna::update/$2');
        $routes->get('delete/(:num)', 'Pengguna::delete/$2');
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
});

// Routing Multi-Tenant PKM (Frontend)
$routes->group('(:segment)', ['namespace' => 'App\Controllers\Frontend'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('berita', 'Berita::index');
    $routes->get('berita/detail/(:segment)', 'Berita::detail/$2');
    $routes->get('galeri', 'Galeri::index');
});
