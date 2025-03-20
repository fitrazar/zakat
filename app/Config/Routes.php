<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/login', 'AuthController::login');
$routes->post('/login/process', 'AuthController::processLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/forgot-password', 'AuthController::forgotPassword');
$routes->post('/forgot-password', 'AuthController::processResetPassword');
$routes->get('/', 'DashboardController::index', ['filter' => 'auth']);


// Warga
$routes->get('/warga', 'WargaController::index');
$routes->get('/warga/create', 'WargaController::create');
$routes->post('/warga/store', 'WargaController::store');
$routes->get('/warga/edit/(:num)', 'WargaController::edit/$1');
$routes->post('/warga/update/(:num)', 'WargaController::update/$1');
$routes->get('/warga/delete/(:num)', 'WargaController::delete/$1');

// RT
$routes->get('/rt', 'RtController::index');
$routes->get('/rt/create', 'RtController::create');
$routes->post('/rt/store', 'RtController::store');
$routes->get('/rt/edit/(:num)', 'RtController::edit/$1');
$routes->post('/rt/update/(:num)', 'RtController::update/$1');
$routes->get('/rt/delete/(:num)', 'RtController::delete/$1');


// Penerima Zakat
$routes->get('/penerima_zakat', 'PenerimaZakatController::index');
$routes->get('/penerima_zakat/create', 'PenerimaZakatController::create');
$routes->post('/penerima_zakat/store', 'PenerimaZakatController::store');
$routes->get('/penerima_zakat/edit/(:num)', 'PenerimaZakatController::edit/$1');
$routes->put('/penerima_zakat/update/(:num)', 'PenerimaZakatController::update/$1');
$routes->get('/penerima_zakat/delete/(:num)', 'PenerimaZakatController::delete/$1');
$routes->get('penerima_zakat/cetak_pdf', 'PenerimaZakatController::cetak_pdf');
$routes->get('penerima_zakat/cetak_pdf/(:num)?', 'PenerimaZakatController::cetak_pdf/$1');
$routes->get('penerima_zakat/cetak_excel/(:num)?', 'PenerimaZakatController::cetak_excel/$1');

// Pemasukan Zakat
$routes->group('pemasukan_zakat', function ($routes) {
    $routes->get('/', 'PemasukanZakatController::index');
    $routes->get('create', 'PemasukanZakatController::create');
    $routes->post('store', 'PemasukanZakatController::store');
    $routes->get('edit/(:num)', 'PemasukanZakatController::edit/$1');
    $routes->put('update/(:num)', 'PemasukanZakatController::update/$1');
    $routes->get('delete/(:num)', 'PemasukanZakatController::delete/$1');
    $routes->get('cetak_pdf', 'PemasukanZakatController::cetak_pdf');
    $routes->get('cetak_excel', 'PemasukanZakatController::cetak_excel');
});

// Kas Zakat
$routes->get('kas_zakat/saldo', 'KasZakatController::getSaldo');