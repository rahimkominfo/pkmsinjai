<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Portal Utama (Root Domain tanpa PKM)
$routes->get('/', function() {
    return '<h1>Portal Kesehatan Kabupaten Sinjai</h1><p>Silakan akses URL PKM spesifik, contoh: <a href="'.base_url('balangnipa').'">/balangnipa</a></p>';
});

// Routing Multi-Tenant PKM (Frontend)
$routes->group('(:segment)', ['namespace' => 'App\Controllers\Frontend'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('berita', 'Berita::index');
    $routes->get('berita/detail/(:segment)', 'Berita::detail/$2');
    $routes->get('galeri', 'Galeri::index');
});

$routes->group('admin/(:segment)', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    // Artikel CRUD
    $routes->group('artikel', function ($routes) {
        $routes->get('/', 'Artikel::index');
        $routes->get('create', 'Artikel::create');
        $routes->post('store', 'Artikel::store');
        $routes->get('edit/(:num)', 'Artikel::edit/$2');
        $routes->post('update/(:num)', 'Artikel::update/$2');
        $routes->get('delete/(:num)', 'Artikel::delete/$2');
    });
    // Kategori CRUD
    $routes->group('kategori', function ($routes) {
        $routes->get('/', 'Kategori::index');
        $routes->get('create', 'Kategori::create');
        $routes->post('store', 'Kategori::store');
        $routes->get('edit/(:num)', 'Kategori::edit/$2');
        $routes->post('update/(:num)', 'Kategori::update/$2');
        $routes->get('delete/(:num)', 'Kategori::delete/$2');
    });
    // Galeri CRUD
    $routes->group('galeri', function ($routes) {
        $routes->get('/', 'Galeri::index');
        $routes->get('create', 'Galeri::create');
        $routes->post('store', 'Galeri::store');
        $routes->get('edit/(:num)', 'Galeri::edit/$2');
        $routes->post('update/(:num)', 'Galeri::update/$2');
        $routes->get('delete/(:num)', 'Galeri::delete/$2');
        $routes->get('delete_foto/(:num)', 'Galeri::delete_foto/$2');
    });
    // Antrian CRUD
    $routes->group('antrian', function ($routes) {
        $routes->get('/', 'Antrian::index');
        $routes->get('create', 'Antrian::create');
        $routes->post('store', 'Antrian::store');
        $routes->get('edit/(:num)', 'Antrian::edit/$2');
        $routes->post('update/(:num)', 'Antrian::update/$2');
        $routes->get('delete/(:num)', 'Antrian::delete/$2');
    });
    
    // Pengguna CRUD
    $routes->group('pengguna', function ($routes) {
        $routes->get('/', 'Pengguna::index');
        $routes->get('create', 'Pengguna::create');
        $routes->post('store', 'Pengguna::store');
        $routes->get('edit/(:num)', 'Pengguna::edit/$2');
        $routes->post('update/(:num)', 'Pengguna::update/$2');
        $routes->get('delete/(:num)', 'Pengguna::delete/$2');
    });

    // Pengaturan CRUD
    $routes->group('pengaturan', function ($routes) {
        $routes->get('/', 'Pengaturan::index');
        $routes->get('create', 'Pengaturan::create');
        $routes->post('store', 'Pengaturan::store');
        $routes->get('edit/(:num)', 'Pengaturan::edit/$2');
        $routes->post('update/(:num)', 'Pengaturan::update/$2');
        $routes->get('delete/(:num)', 'Pengaturan::delete/$2');
    });
});
