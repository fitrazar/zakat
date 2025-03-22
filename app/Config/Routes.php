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
$routes->get('/warga', 'WargaController::index', ['filter' => 'auth']);
$routes->get('/warga/create', 'WargaController::create', ['filter' => 'auth']);
$routes->post('/warga/store', 'WargaController::store', ['filter' => 'auth']);
$routes->get('/warga/edit/(:num)', 'WargaController::edit/$1', ['filter' => 'auth']);
$routes->post('/warga/update/(:num)', 'WargaController::update/$1', ['filter' => 'auth']);
$routes->get('/warga/delete/(:num)', 'WargaController::delete/$1', ['filter' => 'auth']);

// RT
$routes->get('/rt', 'RtController::index', ['filter' => 'auth']);
$routes->get('/rt/create', 'RtController::create', ['filter' => 'auth']);
$routes->post('/rt/store', 'RtController::store', ['filter' => 'auth']);
$routes->get('/rt/edit/(:num)', 'RtController::edit/$1', ['filter' => 'auth']);
$routes->post('/rt/update/(:num)', 'RtController::update/$1', ['filter' => 'auth']);
$routes->get('/rt/delete/(:num)', 'RtController::delete/$1', ['filter' => 'auth']);


// Penerima Zakat
$routes->get('/penerima_zakat', 'PenerimaZakatController::index', ['filter' => 'auth']);
$routes->get('/penerima_zakat/create', 'PenerimaZakatController::create', ['filter' => 'auth']);
$routes->post('/penerima_zakat/store', 'PenerimaZakatController::store', ['filter' => 'auth']);
$routes->get('/penerima_zakat/edit/(:num)', 'PenerimaZakatController::edit/$1', ['filter' => 'auth']);
$routes->put('/penerima_zakat/update/(:num)', 'PenerimaZakatController::update/$1', ['filter' => 'auth']);
$routes->get('/penerima_zakat/delete/(:num)', 'PenerimaZakatController::delete/$1', ['filter' => 'auth']);
$routes->get('penerima_zakat/cetak_pdf', 'PenerimaZakatController::cetak_pdf', ['filter' => 'auth']);
$routes->get('penerima_zakat/cetak_pdf/(:num)?', 'PenerimaZakatController::cetak_pdf/$1', ['filter' => 'auth']);
$routes->get('penerima_zakat/cetak_excel/(:num)?', 'PenerimaZakatController::cetak_excel/$1', ['filter' => 'auth']);

// Pemasukan Zakat
$routes->get('/pemasukan_zakat', 'PemasukanZakatController::index', ['filter' => 'auth']);
$routes->get('/pemasukan_zakat/create', 'PemasukanZakatController::create', ['filter' => 'auth']);
$routes->post('/pemasukan_zakat/store', 'PemasukanZakatController::store', ['filter' => 'auth']);
$routes->get('/pemasukan_zakat/edit/(:num)', 'PemasukanZakatController::edit/$1', ['filter' => 'auth']);
$routes->put('/pemasukan_zakat/update/(:num)', 'PemasukanZakatController::update/$1', ['filter' => 'auth']);
$routes->get('/pemasukan_zakat/delete/(:num)', 'PemasukanZakatController::delete/$1', ['filter' => 'auth']);
$routes->get('/pemasukan_zakat/cetak_pdf', 'PemasukanZakatController::cetak_pdf', ['filter' => 'auth']);
$routes->get('/pemasukan_zakat/cetak_excel', 'PemasukanZakatController::cetak_excel', ['filter' => 'auth']);

// Kas Zakat
$routes->get('kas_zakat/saldo', 'KasZakatController::getSaldo', ['filter' => 'auth']);