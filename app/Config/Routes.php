<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');


// Auth Routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginPost');
$routes->get('register', function () {
    return redirect()->to('/login')->with('error', 'Registrasi hanya dapat dilakukan oleh admin.');
});
$routes->post('register', function () {
    return redirect()->to('/login')->with('error', 'Registrasi hanya dapat dilakukan oleh admin.');
});

$routes->get('logout', 'AuthController::logout');

// Dashboard Routes (dengan filter login)
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('admin/dashboard', 'Admin\Dashboard::index', ['filter' => 'auth']);
$routes->get('guru/dashboard', 'Guru\Dashboard::index', ['filter' => 'auth']);
$routes->get('siswa/dashboard', 'Siswa\Dashboard::index', ['filter' => 'auth']);

// Dashboard ROLE Admin - hanya bisa diakses oleh Admin (START)
$routes->group('admin', function($routes) {
    // CRUD Data Guru
    $routes->get('guru', 'Admin\GuruController::index');
    $routes->get('guru/create', 'Admin\GuruController::create');
    $routes->post('guru/store', 'Admin\GuruController::store');
    $routes->get('guru/edit/(:segment)', 'Admin\GuruController::edit/$1');
    $routes->post('guru/update/(:segment)', 'Admin\GuruController::update/$1');
    $routes->post('guru/delete/(:segment)', 'Admin\GuruController::delete/$1');

    // CRUD Data Siswa
    $routes->get('siswa', 'Admin\SiswaController::index');
    $routes->get('siswa/create', 'Admin\SiswaController::create');
    $routes->post('siswa/store', 'Admin\SiswaController::store');
    $routes->get('siswa/edit/(:segment)', 'Admin\SiswaController::edit/$1');
    $routes->post('siswa/update/(:segment)', 'Admin\SiswaController::update/$1');
    $routes->post('siswa/delete/(:segment)', 'Admin\SiswaController::delete/$1');

    // CRUD Data Kelas
    $routes->get('kelas', 'Admin\KelasController::index');
    $routes->get('kelas/create', 'Admin\KelasController::create');
    $routes->post('kelas/store', 'Admin\KelasController::store');
    $routes->get('kelas/edit/(:segment)', 'Admin\KelasController::edit/$1');
    $routes->post('kelas/update/(:segment)', 'Admin\KelasController::update/$1');
    $routes->post('kelas/delete/(:segment)', 'Admin\KelasController::delete/$1');

    // CRUD Data Jadwal
    $routes->get('jadwal', 'Admin\JadwalController::index');
    $routes->get('jadwal/create', 'Admin\JadwalController::create');
    $routes->post('jadwal/store', 'Admin\JadwalController::store');
    $routes->get('jadwal/edit/(:segment)', 'Admin\JadwalController::edit/$1');
    $routes->post('jadwal/update/(:segment)', 'Admin\JadwalController::update/$1');
    $routes->post('jadwal/delete/(:segment)', 'Admin\JadwalController::delete/$1');

    // CRUD Data Mapel
    $routes->get('mapel', 'Admin\MapelController::index');
    $routes->get('mapel/create', 'Admin\MapelController::create');
    $routes->post('mapel/store', 'Admin\MapelController::store');
    $routes->get('mapel/edit/(:segment)', 'Admin\MapelController::edit/$1');
    $routes->post('mapel/update/(:segment)', 'Admin\MapelController::update/$1');
    $routes->post('mapel/delete/(:segment)', 'Admin\MapelController::delete/$1');

    // CRUD Data Nilai
    $routes->get('nilai', 'Admin\NilaiController::index');
    $routes->get('nilai/create', 'Admin\NilaiController::create');
    $routes->post('nilai/store', 'Admin\NilaiController::store');
    $routes->get('nilai/edit/(:segment)', 'Admin\NilaiController::edit/$1');
    $routes->post('nilai/update/(:segment)', 'Admin\NilaiController::update/$1');
    $routes->post('nilai/delete/(:segment)', 'Admin\NilaiController::delete/$1');

    // CRUD Manajemen Akun
    $routes->get('manajemen-akun', 'Admin\UserController::index');
    $routes->get('manajemen-akun/create', 'Admin\UserController::create');
    $routes->post('manajemen-akun/store', 'Admin\UserController::store');
    $routes->get('manajemen-akun/edit/(:segment)', 'Admin\UserController::edit/$1');
    $routes->post('manajemen-akun/update/(:segment)', 'Admin\UserController::update/$1');
    $routes->post('manajemen-akun/delete/(:segment)', 'Admin\UserController::delete/$1');

    // Menu Pengumuman
    $routes->get('pengumuman', 'Admin\PengumumanController::index');
    $routes->get('pengumuman/create', 'Admin\PengumumanController::create');
    $routes->post('pengumuman/store', 'Admin\PengumumanController::store');
    $routes->get('pengumuman/edit/(:segment)', 'Admin\PengumumanController::edit/$1');
    $routes->post('pengumuman/update/(:segment)', 'Admin\PengumumanController::update/$1');
    $routes->post('pengumuman/delete/(:segment)', 'Admin\PengumumanController::delete/$1');

    // Cetak laporan
    $routes->get('laporan/rekap', 'Admin\LaporanRekapController::index');
    $routes->get('laporan/rekap/print/(:segment)', 'Admin\LaporanRekapController::print/$1');
    $routes->get('laporan/rekap/pdf/(:segment)', 'Admin\LaporanRekapController::pdf/$1');
    $routes->get('laporan/rekap/excel/(:segment)', 'Admin\LaporanRekapController::excel/$1');

    // Profile
    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::update');
    $routes->post('profile/password', 'Admin\Profile::password');

    // Notifikasi
    $routes->get('notifikasi/datamaster', 'Admin\NotifikasiController::datamaster');

});
// Dashbord ROLE Admin - hanya bisa diakses oleh Admin (END)


// Dashbord ROLE Guru - hanya bisa diakses oleh Guru (START)

$routes->group('guru', function($routes) {
    // Profile
    $routes->get('profile', 'Guru\Profile::index');
    $routes->post('profile/update', 'Guru\Profile::update');
    $routes->post('profile/password', 'Guru\Profile::password');

    // Jadwal
    $routes->get('jadwal', 'Guru\Jadwal::index');
     $routes->get('jadwal/mapel/(:num)', 'Guru\Jadwal::detail/$1');

    // Nilai
     $routes->get('nilai', 'Guru\Nilai::index');
    $routes->post('nilai/simpan', 'Guru\Nilai::simpan');
    $routes->get('nilai/rekap', 'Guru\Nilai::rekap');

    // Siswa
    $routes->get('siswa', 'Guru\Siswa::index');

    // Pengumuman
      $routes->get('pengumuman', 'Guru\Pengumuman::index');
    $routes->get('pengumuman/create', 'Guru\Pengumuman::create');
    $routes->post('pengumuman/store', 'Guru\Pengumuman::store');
    $routes->get('pengumuman/edit/(:num)', 'Guru\Pengumuman::edit/$1');
    $routes->post('pengumuman/update/(:num)', 'Guru\Pengumuman::update/$1');
    $routes->post('pengumuman/delete/(:num)', 'Guru\Pengumuman::delete/$1');

    // Presensi
    $routes->get('presensi', 'Guru\Presensi::index');
    $routes->post('presensi/load', 'Guru\Presensi::load');
    $routes->post('presensi/simpan', 'Guru\Presensi::simpan');
    $routes->get('presensi/rekap', 'Guru\Presensi::rekap');

    // Chat
    $routes->get('chat', 'Guru\Chat::index');
    $routes->post('chat/sendMessage', 'Guru\Chat::sendMessage');
    $routes->get('chat/getMessages/(:num)', 'Guru\Chat::getMessages/$1');
    $routes->get('chat/checkNewMessages', 'Guru\Chat::checkNewMessages');
    $routes->get('chat/unreadNotif', 'Guru\Chat::unreadNotif');

    // Search
    $routes->get('guru/search', 'Guru\Dashboard::search');


});

// Dashbord ROLE Guru - hanya bisa diakses oleh Guru (END)


// Dashbord ROLE Siswa - hanya bisa diakses oleh Siswa (START)

$routes->group('siswa', function($routes) {
    // Profile
    $routes->get('profile', 'Siswa\Profile::index');
    $routes->post('profile/update', 'Siswa\Profile::update');
    $routes->post('profile/password', 'Siswa\Profile::password');

    // Jadwal Pelajaran
    $routes->get('jadwal', 'Siswa\Jadwal::index');

    // Nilai
     $routes->get('nilai', 'Siswa\Nilai::index');

    // Absensi
    $routes->get('absensi', 'Siswa\Absensi::index');

    // Pengumuman
    $routes->get('pengumuman', 'Siswa\Pengumuman::index');

    // Chat
     $routes->get('chat', 'Siswa\Chat::index');
    $routes->post('chat/sendMessage', 'Siswa\Chat::sendMessage');
    $routes->get('chat/getMessages/(:num)', 'Siswa\Chat::getMessages/$1');
    $routes->get('chat/checkNewMessages', 'Siswa\Chat::checkNewMessages');
    $routes->get('chat/unreadNotif', 'Siswa\Chat::unreadNotif');
});

// Dashbord ROLE Siswa - hanya bisa diakses oleh Siswa (END)