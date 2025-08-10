<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing page routes
$routes->get('/', 'Home::index');
$routes->get('kalkulator-zakat', 'Home::kalkulatorZakat');

// Auth Routes
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Register dengan OTP
$routes->get('auth/register', 'Auth::registerForm');
$routes->post('auth/register', 'Auth::register');
$routes->post('auth/verify-register-otp', 'Auth::verifyRegisterOTP');

// Forgot Password dengan OTP
$routes->get('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/verify-forgot-password-otp', 'Auth::verifyForgotPasswordOTP');
$routes->post('auth/reset-password', 'Auth::resetPassword');

// Resend OTP
$routes->post('auth/resend-otp', 'Auth::resendOTP');

// Profile Completion Routes
$routes->get('profile/check', 'ProfileController::checkProfileCompletion');
$routes->get('profile/complete/donatur', 'ProfileController::completeProfileDonatur');
$routes->get('profile/complete/mustahik', 'ProfileController::completeProfileMustahik');
$routes->post('profile/save/donatur', 'ProfileController::saveProfileDonatur');
$routes->post('profile/save/mustahik', 'ProfileController::saveProfileMustahik');

// Dashboard Routes for Donatur
$routes->group('dashboard/donatur', ['filter' => ['auth', 'role:donatur']], function ($routes) {
    $routes->get('/', 'DashboardDonaturController::index');
    $routes->get('edit-profile', 'DashboardDonaturController::editProfile');
    $routes->post('update-profile', 'DashboardDonaturController::updateProfile');
    
    // Donasi routes for donatur
    $routes->get('donasi', 'DashboardDonaturController::donasi');
    $routes->get('donasi/view', 'DashboardDonaturController::viewDonasi');
    $routes->get('donasi/form', 'DashboardDonaturController::formDonasi');
    $routes->get('donasi/form/(:segment)', 'DashboardDonaturController::formDonasi/$1'); // For program selection from home
    $routes->post('donasi/save', 'DashboardDonaturController::saveDonasi');
    $routes->get('donasi/detail/(:segment)', 'DashboardDonaturController::detailDonasi/$1');
    $routes->post('donasi/upload-bukti', 'DashboardDonaturController::uploadBuktiDonasi');
    
                    // Zakat routes for donatur
                $routes->get('zakat', 'DashboardDonaturController::zakat');
                $routes->get('zakat/view', 'DashboardDonaturController::viewZakat');
                $routes->get('zakat/form', 'DashboardDonaturController::formZakat');
                $routes->get('zakat/kalkulator', 'DashboardDonaturController::kalkulatorZakat');
                $routes->post('zakat/save', 'DashboardDonaturController::saveZakat');
                $routes->get('zakat/detail/(:segment)', 'DashboardDonaturController::detailZakat/$1');
                $routes->post('zakat/upload-bukti', 'DashboardDonaturController::uploadBuktiZakat');
});

// Dashboard Routes for Mustahik
$routes->group('dashboard/mustahik', ['filter' => ['auth', 'role:mustahik']], function ($routes) {
    $routes->get('/', 'DashboardMustahikController::index');
    $routes->get('edit-profile', 'DashboardMustahikController::editProfile');
    $routes->post('update-profile', 'DashboardMustahikController::updateProfile');
    
    // Permohonan routes for mustahik
    $routes->get('permohonan', 'DashboardMustahikController::permohonan');
    $routes->post('permohonan/view', 'DashboardMustahikController::viewPermohonan');
    $routes->get('permohonan/form', 'DashboardMustahikController::formtambahPermohonan');
    $routes->post('permohonan/save', 'DashboardMustahikController::savePermohonan');
    $routes->get('permohonan/edit/(:segment)', 'DashboardMustahikController::formeditPermohonan/$1');
    $routes->post('permohonan/update/(:segment)', 'DashboardMustahikController::updatePermohonan/$1');
    $routes->post('permohonan/delete', 'DashboardMustahikController::deletePermohonan');
    $routes->get('permohonan/detail/(:segment)', 'DashboardMustahikController::detailPermohonan/$1');
    $routes->post('permohonan/syarat', 'DashboardMustahikController::getSyaratByKategori');
});

// General Routes (accessible for logged in users)
$routes->get('profile/edit', function() {
    $role = session()->get('role');
    if ($role === 'donatur') {
        return redirect()->to(site_url('dashboard/donatur/edit-profile'));
    } elseif ($role === 'mustahik') {
        return redirect()->to(site_url('dashboard/mustahik/edit-profile'));
    }
    return redirect()->to(site_url('auth'));
});



// Admin & Dokter & Pimpinan dashboard (protected by auth filter)
$routes->group('dashboard', ['filter' => ['auth', 'role:admin,ketua,program,keuangan']], function ($routes) {
    $routes->get('/', 'Dashboard::index');
});


$routes->group('mustahik', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'MustahikController::index');
    $routes->get('view', 'MustahikController::viewMustahik');
    $routes->post('detail', 'MustahikController::getMustahikDetail');
    $routes->get('formtambah', 'MustahikController::formtambah');
    $routes->post('save', 'MustahikController::save');
    $routes->get('formedit/(:segment)', 'MustahikController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'MustahikController::updatedata/$1');
    $routes->get('detail/(:segment)', 'MustahikController::detail/$1');
    $routes->post('delete', 'MustahikController::delete');
    $routes->post('createUser/(:segment)', 'MustahikController::createUser/$1');
    $routes->post('updatePassword/(:segment)', 'MustahikController::updatePassword/$1');
});

$routes->group('donatur', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'DonaturController::index');
    $routes->get('view', 'DonaturController::viewDonatur');
    $routes->post('detail', 'DonaturController::getDonaturDetail');
    $routes->get('formtambah', 'DonaturController::formtambah');
    $routes->post('save', 'DonaturController::save');
    $routes->get('formedit/(:segment)', 'DonaturController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'DonaturController::updatedata/$1');
    $routes->get('detail/(:segment)', 'DonaturController::detail/$1');
    $routes->post('delete', 'DonaturController::delete');
    $routes->post('createUser/(:segment)', 'DonaturController::createUser/$1');
    $routes->post('updatePassword/(:segment)', 'DonaturController::updatePassword/$1');
});

$routes->group('user', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('view', 'UserController::view');
    $routes->get('formtambah', 'UserController::formtambah');
    $routes->post('save', 'UserController::save');
    $routes->get('formedit/(:segment)', 'UserController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'UserController::updatedata/$1');
    $routes->post('detail', 'UserController::detail');
    $routes->post('delete', 'UserController::delete');
});

$routes->group('laporan-users', ['filter' => ['auth', 'role:admin,ketua']], function ($routes) {
    $routes->get('mustahik', 'Laporan\LaporanUsers::LaporanMustahik');
    $routes->get('mustahik/view', 'Laporan\LaporanUsers::viewallLaporanMustahik');
    $routes->get('donatur', 'Laporan\LaporanUsers::LaporanDonatur');
    $routes->get('donatur/view', 'Laporan\LaporanUsers::viewallLaporanDonatur');
});

$routes->group('kategori', ['filter' => ['auth', 'role:program']], function ($routes) {
    $routes->get('/', 'KategoriController::index');
    $routes->get('view', 'KategoriController::view');
    $routes->get('formtambah', 'KategoriController::formtambah');
    $routes->post('save', 'KategoriController::save');
    $routes->get('formedit/(:segment)', 'KategoriController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'KategoriController::updatedata/$1');
    $routes->post('delete', 'KategoriController::delete');
});

$routes->group('permohonan', ['filter' => ['auth', 'role:program']], function ($routes) {
    $routes->get('/', 'PermohonanController::index');
    $routes->get('view', 'PermohonanController::viewPermohonan');
    $routes->get('formtambah', 'PermohonanController::formtambah');
    $routes->post('save', 'PermohonanController::save');
    $routes->get('formedit/(:segment)', 'PermohonanController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'PermohonanController::updatedata/$1');
    $routes->get('detail/(:segment)', 'PermohonanController::detail/$1');
    $routes->post('delete', 'PermohonanController::delete');
    $routes->post('updateStatus', 'PermohonanController::updateStatus');
    $routes->post('getSyaratByKategori', 'PermohonanController::getSyaratByKategori');
});

$routes->group('zakat', ['filter' => ['auth', 'role:keuangan']], function ($routes) {
    $routes->get('/', 'ZakatController::index');
    $routes->get('view', 'ZakatController::viewZakat');
    $routes->get('formtambah', 'ZakatController::formtambah');
    $routes->post('save', 'ZakatController::save');
    $routes->get('formedit/(:segment)', 'ZakatController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'ZakatController::updatedata/$1');
    $routes->get('detail/(:segment)', 'ZakatController::detail/$1');
    $routes->post('delete', 'ZakatController::delete');
    $routes->post('verifyPayment', 'ZakatController::verifyPayment');
    $routes->post('getBuktiBayar', 'ZakatController::getBuktiBayar');
});

$routes->group('donasi', ['filter' => ['auth', 'role:keuangan']], function ($routes) {
    $routes->get('/', 'DonasiController::index');
    $routes->get('view', 'DonasiController::viewDonasi');
    $routes->get('formtambah', 'DonasiController::formtambah');
    $routes->post('save', 'DonasiController::save');
    $routes->get('formedit/(:segment)', 'DonasiController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'DonasiController::updatedata/$1');
    $routes->get('detail/(:segment)', 'DonasiController::detail/$1');
    $routes->post('delete', 'DonasiController::delete');
    $routes->post('verifyPayment', 'DonasiController::verifyPayment');
    $routes->post('getBuktiBayar', 'DonasiController::getBuktiBayar');
});

$routes->group('program', ['filter' => ['auth', 'role:program']], function ($routes) {
    $routes->get('/', 'ProgramController::index');
    $routes->get('view', 'ProgramController::view');
    $routes->get('formtambah', 'ProgramController::formtambah');
    $routes->post('save', 'ProgramController::save');
    $routes->get('formedit/(:segment)', 'ProgramController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'ProgramController::updatedata/$1');
    $routes->get('detail/(:segment)', 'ProgramController::detail/$1');
    $routes->post('delete', 'ProgramController::delete');
    $routes->post('updateStatus', 'ProgramController::updateStatus');
    $routes->get('status/(:segment)', 'ProgramController::status/$1');
});

$routes->group('penyaluran', ['filter' => ['auth', 'role:keuangan']], function ($routes) {
    $routes->get('/', 'PenyaluranController::index');
    $routes->get('view', 'PenyaluranController::view');
    $routes->get('formtambah', 'PenyaluranController::formtambah');
    $routes->post('save', 'PenyaluranController::save');
    $routes->get('formedit/(:segment)', 'PenyaluranController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'PenyaluranController::updatedata/$1');
    $routes->get('detail/(:segment)', 'PenyaluranController::detail/$1');
    $routes->post('delete', 'PenyaluranController::delete');
    $routes->get('getPermohonan', 'PenyaluranController::getPermohonan');
    $routes->post('viewGetPermohonan', 'PenyaluranController::viewGetPermohonan');
    $routes->get('getMustahik', 'PenyaluranController::getMustahik');
    $routes->get('viewGetMustahik', 'PenyaluranController::viewGetMustahik');
    $routes->get('getPermohonanAjax', 'PenyaluranController::getPermohonanAjax');
    $routes->get('getMustahikAjax', 'PenyaluranController::getMustahikAjax');
});

$routes->group('laporan', ['filter' => ['auth', 'role:keuangan,ketua']], function ($routes) {
    $routes->get('zakat', 'Laporan\LaporanTransaksi::LaporanZakat');
    $routes->get('zakat/view', 'Laporan\LaporanTransaksi::viewLaporanZakat');
    $routes->post('zakat/viewtanggal', 'Laporan\LaporanTransaksi::viewLaporanZakatTanggal');
    $routes->post('zakat/viewbulan', 'Laporan\LaporanTransaksi::viewLaporanZakatBulan');
    $routes->get('donasi', 'Laporan\LaporanTransaksi::LaporanDonasi');
    $routes->get('donasi/view', 'Laporan\LaporanTransaksi::viewLaporanDonasi');
    $routes->post('donasi/viewtanggal', 'Laporan\LaporanTransaksi::viewLaporanDonasiTanggal');
    $routes->post('donasi/viewbulan', 'Laporan\LaporanTransaksi::viewLaporanDonasiBulan');
    $routes->get('penyaluran', 'Laporan\LaporanTransaksi::LaporanPenyaluran');
    $routes->get('penyaluran/viewzakat', 'Laporan\LaporanTransaksi::viewLaporanPenyaluranZakat');
    $routes->get('penyaluran/viewdonasi', 'Laporan\LaporanTransaksi::viewLaporanPenyaluranDonasi');
    $routes->post('penyaluran/viewtanggal', 'Laporan\LaporanTransaksi::viewLaporanPenyaluranTanggal');
    $routes->post('penyaluran/viewbulan', 'Laporan\LaporanTransaksi::viewLaporanPenyaluranBulan');
});

