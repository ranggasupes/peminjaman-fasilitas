
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PeminjamFasilitasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AdminPeminjamanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanAdminController;
use App\Http\Controllers\AdminProfileController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTENTIKASI
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])->group(function () {

    // Dashboard Super Admin
    Route::get('/dashboard/super-admin', [
        DashboardController::class,
        'superAdmin',
    ])->name('dashboard.super-admin');

    /*
    |--------------------------------------------------------------------------
    | PROFIL SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/super-admin/profil-saya', [
        AdminProfileController::class,
        'edit',
    ])->name('super-admin.profil.edit');

    Route::put('/super-admin/profil-saya', [
        AdminProfileController::class,
        'update',
    ])->name('super-admin.profil.update');

    // CRUD Instansi
    Route::resource('instansi', InstansiController::class)
        ->except(['show']);

    // CRUD Fasilitas
    Route::resource('data-fasilitas', FasilitasController::class)
        ->except(['show'])
        ->parameters([
            'data-fasilitas' => 'fasilitas',
        ])
        ->names([
            'index' => 'fasilitas.index',
            'create' => 'fasilitas.create',
            'store' => 'fasilitas.store',
            'edit' => 'fasilitas.edit',
            'update' => 'fasilitas.update',
            'destroy' => 'fasilitas.destroy',
        ]);
});

/*
|--------------------------------------------------------------------------
| ADMIN FASILITAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin_fasilitas'])->group(function () {

    // Dashboard Admin
    Route::get('/dashboard/admin', [
        DashboardController::class,
        'admin',
    ])->name('dashboard.admin');

    /*
    |--------------------------------------------------------------------------
    | PROFIL ADMIN FASILITAS
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/profil-saya', [
        AdminProfileController::class,
        'edit',
    ])->name('admin.profil.edit');

    Route::put('/admin/profil-saya', [
        AdminProfileController::class,
        'update',
    ])->name('admin.profil.update');

    // CRUD Fasilitas milik instansi admin
    Route::resource('admin/fasilitas', FasilitasController::class)
        ->except(['show'])
        ->parameters([
            'fasilitas' => 'fasilitas',
        ])
        ->names([
            'index' => 'admin.fasilitas.index',
            'create' => 'admin.fasilitas.create',
            'store' => 'admin.fasilitas.store',
            'edit' => 'admin.fasilitas.edit',
            'update' => 'admin.fasilitas.update',
            'destroy' => 'admin.fasilitas.destroy',
        ]);

    /*
    |--------------------------------------------------------------------------
    | PENGELOLAAN PENGAJUAN PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    // Daftar pengajuan
    Route::get('/admin/pengajuan-peminjaman', [
        AdminPeminjamanController::class,
        'index',
    ])->name('admin.peminjaman.index');

    // Detail pengajuan
    Route::get('/admin/pengajuan-peminjaman/{peminjaman}', [
        AdminPeminjamanController::class,
        'show',
    ])->name('admin.peminjaman.show');

    // Menyetujui pengajuan
    Route::patch('/admin/pengajuan-peminjaman/{peminjaman}/terima', [
        AdminPeminjamanController::class,
        'approve',
    ])->name('admin.peminjaman.approve');

    // Menolak pengajuan
    Route::patch('/admin/pengajuan-peminjaman/{peminjaman}/tolak', [
        AdminPeminjamanController::class,
        'reject',
    ])->name('admin.peminjaman.reject');

    // Meminta perbaikan pengajuan
    Route::patch('/admin/pengajuan-peminjaman/{peminjaman}/perlu-perbaikan', [
        AdminPeminjamanController::class,
        'requestRevision',
    ])->name('admin.peminjaman.revision');

    // Memverifikasi pembayaran
    Route::patch(
        '/admin/pengajuan-peminjaman/{peminjaman}/verifikasi-pembayaran',
        [AdminPeminjamanController::class, 'verifyPayment']
    )->name('admin.peminjaman.verify-payment');

    // Menolak pembayaran
    Route::patch(
        '/admin/pengajuan-peminjaman/{peminjaman}/tolak-pembayaran',
        [AdminPeminjamanController::class, 'rejectPayment']
    )->name('admin.peminjaman.reject-payment');

    /*
    |--------------------------------------------------------------------------
    | LAPORAN ADMIN FASILITAS
    |--------------------------------------------------------------------------
    */

    // Laporan peminjaman
    Route::get('/admin/laporan/peminjaman', [
        LaporanAdminController::class,
        'peminjaman',
    ])->name('admin.laporan.peminjaman');

    // Laporan pembayaran
    Route::get('/admin/laporan/pembayaran', [
        LaporanAdminController::class,
        'pembayaran',
    ])->name('admin.laporan.pembayaran');
});

/*
|--------------------------------------------------------------------------
| PEMINJAM
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:peminjam'])->group(function () {

    // Dashboard Peminjam
    Route::get('/dashboard/peminjam', [
        DashboardController::class,
        'peminjam',
    ])->name('dashboard.peminjam');

    /*
    |--------------------------------------------------------------------------
    | PROFIL PEMINJAM
    |--------------------------------------------------------------------------
    */

    // Halaman edit profil
    Route::get('/profil-saya', [
        ProfileController::class,
        'edit',
    ])->name('peminjam.profil.edit');

    // Proses update profil
    Route::put('/profil-saya', [
        ProfileController::class,
        'update',
    ])->name('peminjam.profil.update');

    /*
    |--------------------------------------------------------------------------
    | FASILITAS
    |--------------------------------------------------------------------------
    */

    // Detail fasilitas
    Route::get('/fasilitas/{fasilitas}', [
        PeminjamFasilitasController::class,
        'show',
    ])->name('peminjam.fasilitas.show');

    /*
    |--------------------------------------------------------------------------
    | PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    // Daftar peminjaman saya
    Route::get('/peminjaman-saya', [
        PeminjamanController::class,
        'index',
    ])->name('peminjam.peminjaman.index');

    // Riwayat peminjaman
    Route::get('/riwayat-peminjaman', [
        PeminjamanController::class,
        'riwayat',
    ])->name('peminjam.peminjaman.riwayat');

    // Form pengajuan peminjaman
    Route::get('/fasilitas/{fasilitas}/ajukan', [
        PeminjamanController::class,
        'create',
    ])->name('peminjam.peminjaman.create');

    // Proses pengajuan peminjaman
    Route::post('/fasilitas/{fasilitas}/ajukan', [
        PeminjamanController::class,
        'store',
    ])->name('peminjam.peminjaman.store');

    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN PEMINJAM
    |--------------------------------------------------------------------------
    */

    // Halaman pembayaran
    Route::get('/peminjaman/{peminjaman}/pembayaran', [
        PembayaranController::class,
        'show',
    ])->name('peminjam.pembayaran.show');

    // Mengunggah bukti pembayaran
    Route::post('/peminjaman/{peminjaman}/pembayaran', [
        PembayaranController::class,
        'store',
    ])->name('peminjam.pembayaran.store');
});
