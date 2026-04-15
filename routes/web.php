<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('landing_page');
// });

Route::get('/', [UserController::class, 'landingPage']);

Route::get('/login', [LoginController::class, 'userLoginForm'])->name('user.login');
Route::post('/login', [LoginController::class, 'userLogin']);
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('user.register');
Route::post('/register', [LoginController::class, 'register']);
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password-act', [LoginController::class, 'sendResetLink'])->name('forgot.password.act');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');
Route::get('/admin/login', [LoginController::class, 'adminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dokumen/{filename}', [PendaftarController::class, 'lihatDokumen'])->name('dokumen.lihat');
Route::get('/lihat-foto/{filename}', [PendaftarController::class, 'lihatFoto'])->name('foto.lihat')->middleware('auth');
// Route untuk halaman verifikasi email
Route::get('/email/verify', function () {
    $title = "Verifikasi Email";
    return view('auth.verify-email', compact('title'));
})->middleware('auth')->name('verification.notice');

// Route untuk memproses link verifikasi email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // menandai email sebagai telah diverifikasi
    return redirect('/user/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Route untuk mengirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang ke email Anda.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
        Route::post('/admin/profile', [AdminController::class, 'adminUpdate'])->name('admin.profile.update');
        Route::resource('/admin/periodes', PeriodeController::class);
        Route::get('/periodes-data', [PeriodeController::class, 'getPeriodeData'])->name('periodes.data');
        Route::resource('/admin/tests', TestController::class);
        Route::resource('/admin/jadwals', JadwalController::class);
        Route::resource('/admin/pengumuman', PengumumanController::class);
        Route::get('/pengumuman-data', [PengumumanController::class, 'getPengumumanData'])->name('pengumuman.data');
        Route::resource('/admin/users', UserController::class);
        // middleware superadmin
        Route::middleware(['role:superadmin'])->group(function () {
            Route::resource('/admin/admins', AdminController::class);
            Route::get('/admins-data', [AdminController::class, 'getAdminsData'])->name('admins.data');
        });
        Route::get('/users-data', [UserController::class, 'getUsersData'])->name('users.data');
        Route::get('/admin/profil-sekolah', [ProfilSekolahController::class, 'create'])->name('profil-sekolah.create');
        Route::post('/admin/profil-sekolah', [ProfilSekolahController::class, 'store'])->name('profil-sekolah.store');
        Route::get('/admin/pendaftar', [PendaftarController::class, 'index'])->name('admin.pendaftar.index');
        Route::get('/admin/pendaftar/status/{status}/data', [PendaftarController::class, 'getPendaftarByStatus'])->name('pendaftar.status.data');
        Route::get('/admin/pendaftar/status/{status}', [PendaftarController::class, 'indexByStatus'])->name('pendaftar.status');
        Route::get('/admin/pendaftar/{id}', [PendaftarController::class, 'show'])->name('admin.pendaftar.show');
        Route::get('/admin/pendaftar/{id}/edit', [PendaftarController::class, 'edit'])->name('pendaftar.edit');
        Route::put('/admin/pendaftar/{id}', [PendaftarController::class, 'update'])->name('pendaftar.update');
        Route::delete('/admin/pendaftar/{id}', [PendaftarController::class, 'destroy'])->name('pendaftar.destroy');
        Route::post('/admin/pendaftar/{id}/input-nilai-tes', [PendaftarController::class, 'inputNilaiTes'])->name('pendaftar.inputNilaiTes');
        Route::post('/admin/pendaftar/{id}/verifikasi', [PendaftarController::class, 'verifikasi'])->name('pendaftar.verifikasi');
        Route::get('/admin/pendaftar/{id}/cetak-bukti', [PendaftarController::class, 'cetakBukti'])->name('admin.cetakBukti');
        Route::post('/pendaftar/{id}/update-daftar-ulang', [PendaftarController::class, 'updateDaftarUlang'])->name('pendaftar.updateDaftarUlang');
        Route::post('/pendaftar/{id}/update-status', [PendaftarController::class, 'updateStatus'])->name('pendaftar.updateStatus');
        Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/admin/laporan/getData', [LaporanController::class, 'getData'])->name('laporan.getData');
        Route::get('/admin/laporan/pdf', [LaporanController::class, 'generatePDF'])->name('laporan.pdf');
        Route::get('/admin/laporan/excel', [LaporanController::class, 'generateExcel'])->name('laporan.excel');
        Route::get('/admin/laporan/pdf-diterima/{periode_id}', [LaporanController::class, 'generatePdfDiterima'])->name('laporan.pdfDiterima');
        Route::get('/admin/laporan/excel-diterima/{periode_id}', [LaporanController::class, 'generateExcelDiterima'])->name('laporan.excelDiterima');
    });

    Route::middleware(['role:user', 'verified'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/user/pendaftaran', [PendaftarController::class, 'create'])->name('user.pendaftaran');
        Route::get('/user/pendaftaran/{id}/edit', [PendaftarController::class, 'editPendaftaran'])->name('pendaftaran.edit');
        Route::put('/user/pendaftaran/{id}', [PendaftarController::class, 'updatePendaftaran'])->name('pendaftaran.update');
        Route::post('/user/pendaftaran', [PendaftarController::class, 'store']);
        Route::get('/user/pendaftaran/{id}/cetak-bukti', [PendaftarController::class, 'cetakBukti'])->name('pendaftar.cetakBukti');
        Route::get('/user/informasi', [PendaftarController::class, 'informasiPendaftaran'])->name('user.informasi');
        Route::get('/user/pengumuman', [PengumumanController::class, 'pengumumanUser'])->name('pengumumanUser');
        Route::get('/user/pengumuman/{id}', [PengumumanController::class, 'pengumumanUserShow'])->name('pengumumanUser.show');
        Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
        Route::put('/user/update-password', [UserController::class, 'updatePassword'])->name('user.update.password');
    });
});
