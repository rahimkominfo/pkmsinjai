<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Frontend\Dashboard::index');
$routes->get('berita', 'Frontend\Berita::index');
$routes->get('berita/detail/(:segment)', 'Frontend\Berita::detail/$1');
$routes->get('galeri', 'Frontend\Galeri::index');
