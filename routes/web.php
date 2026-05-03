<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestBackEnd;
use App\Constants\Role;

// auth.role:' . Role::ROLE_ADMIN . ',' . Role::ROLE_GURU . ',' . Role::ROLE_ORANG_TUA
Route::middleware('check.login')->group(function () {
    //route for index/dashboard
    Route::redirect('/', '/akademik/dashboard');
    Route::redirect('/akademik', '/akademik/dashboard');
    Route::get('/akademik/dashboard', [Controller::class, 'index'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU . ',' . Role::ROLE_ORANG_TUA)->name('dashboard');
    
    //route for materi : for now is in disabled
    // Route::get('/akademik/materi', [Controller::class, 'silabus'])->middleware('auth.role:' . Role::ROLE_ADMIN)->name('materi');
    // Route::get('/akademik/ubah-materi/{id}', [Controller::class, 'ubahmateri'])->middleware('auth.role:' . Role::ROLE_ADMIN)->name('materi-ubah');
    // Route::get('/akademik/tambah-materi', [Controller::class, 'tambahmateri'])->middleware('auth.role:' . Role::ROLE_ADMIN)->name('materi-tambah');
    
    //route for tingkat kelas
    Route::get('/akademik/tingkat-kelas', [Controller::class, 'tingkatkelas'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('tingkat-kelas');
    Route::get('/akademik/detail-tingkat-kelas/{id}', [Controller::class, 'tingkatkelasdetail'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('tingkat-kelas-detail');
    
    //route for kelas
    Route::get('/akademik/kelas', [Controller::class, 'kelas'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('kelas');
    Route::get('/akademik/detail-kelas/{id}', [Controller::class, 'kelasdetail'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('kelas-detail');
    
    //route for siswa
    Route::get('/akademik/siswa', [Controller::class, 'siswa'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('siswa');
    Route::get('/akademik/detail-siswa/{id}', [Controller::class, 'siswadetail'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('siswa-detail');
    Route::get('/akademik/ubah-siswa/{id}', [Controller::class, 'siswaubah'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('siswa-ubah');
    Route::get('/akademik/tambah-siswa', [Controller::class, 'siswatambah'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('siswa-tambah');
    
    //route for guru
    Route::get('/akademik/guru', [Controller::class, 'guru'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('guru');

    //route for jurnal
    Route::get('/akademik/aktifitas-jurnal/{id}', [Controller::class, 'jurnalmateri'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU)->name('dashboard');

    //route for settings
    Route::get('/akademik/pengaturan', [Controller::class, 'pengaturan'])->middleware('auth.role:' . Role::ROLE_ADMIN)->name('pengaturan');
    
    //route for profile
    Route::get('/akademik/profile', [Controller::class, 'profile'])->middleware('auth.role:' . Role::ROLE_ADMIN . ',' . ROLE::ROLE_GURU . ',' . Role::ROLE_ORANG_TUA)->name('profile');

    //route for wali lihat detail pengajaran
    Route::get('/akademik/wali/jurnal/{id_jurnal}/{id_siswa}', [Controller::class, 'waliJurnal'])->middleware('auth.role:' . Role::ROLE_ORANG_TUA)->name('wali-jurnal');

    //route for role-akses
    Route::get('/akademik/role-akses', [Controller::class, 'roleAkses'])->middleware('auth.role:' . Role::ROLE_ADMIN)->name('role-akses');
});

Route::middleware('check.notlogin')->group(function () {
    Route::get('/akademik/login', [Controller::class, 'login'])->name('login');
});

Route::get('/akademik/logout', [Controller::class, 'doLogout'])->name('logout');
Route::get('/akademik/lupa-password', [Controller::class, 'doLupaPassword'])->name('lupa-password');
Route::get('/akademik/invalidate-password', [Controller::class, 'doInvalidateForPass'])->name('invalidate-forg-password');
Route::get('/akademik/forbidden', [Controller::class, 'doForbidden'])->name('forbidden');
Route::get('/akademik/rto', [Controller::class, 'doRTO'])->name('rto');

Route::post('/_backend/logic/data-jabatan', [RequestBackEnd::class, 'doJabatanList']);
Route::post('/_backend/logic/data-acl', [RequestBackEnd::class, 'doAclList']);
Route::post('/_backend/logic/data-acl/update', [RequestBackEnd::class, 'doAclUpdate']);
Route::post('/_backend/logic/auth/role/list', [RequestBackEnd::class, 'doRoleList']);
Route::post('/_backend/auth/login-process', [RequestBackEnd::class, 'doLogin']);
Route::post('/_backend/auth/invalidate-reset-password', [RequestBackEnd::class, 'doForgetPassword']);
Route::post('/_backend/auth/invalidate/password', [RequestBackEnd::class, 'doInvalidatePassword']);
Route::post('/_backend/auth/verify-otp', [RequestBackEnd::class, 'doVerifyOTP']);
Route::post('/_backend/auth/invalidate-page', [RequestBackEnd::class, 'doInvalidatePage']);
Route::post('/_backend/profile', [RequestBackEnd::class, 'doMyProfile']);
Route::post('/_backend/profile/d2', [RequestBackEnd::class, 'doMyProfileD2']);
Route::post('/_backend/profile/ds1-update', [RequestBackEnd::class, 'doMyDs1ProfileUpdate']);
Route::post('/_backend/profile/ds2-update', [RequestBackEnd::class, 'doMyDs2ProfileUpdate']);
Route::post('/_backend/profile/update-email', [RequestBackEnd::class, 'doMyUpdateEmail']);
Route::post('/_backend/logic/settings', [RequestBackEnd::class, 'doGetSettings']);
Route::post('/_backend/profile/change-password', [RequestBackEnd::class, 'doChangePassword']);

Route::post('/_backend/logic/data-tingkatan-kelas', [RequestBackEnd::class, 'doListDataTingkatanKelas']);
Route::post('/_backend/logic/data-tingkatan-kelas-create', [RequestBackEnd::class, 'doCreateDataTingkatanKelas']);
Route::post('/_backend/logic/data-tingkatan-kelas-update', [RequestBackEnd::class, 'doUpdateDataTingkatanKelas']);
Route::post('/_backend/logic/data-tingkatan-kelas-delete', [RequestBackEnd::class, 'doDeleteDataTingkatanKelas']);
Route::post('/_backend/logic/data-tingkatan-kelas-level', [RequestBackEnd::class, 'doLevelDataTingkatanKelas']);
Route::post('/_backend/logic/detail-tingkat-kelas', [RequestBackEnd::class, 'doDetailTingkatanKelas']);

Route::post('/_backend/logic/data-kelas', [RequestBackEnd::class, 'doListDataKelas']);
Route::post('/_backend/logic/data-kelas-create', [RequestBackEnd::class, 'doCreateDataKelas']);
Route::post('/_backend/logic/data-kelas-update', [RequestBackEnd::class, 'doUpdateDataKelas']);
Route::post('/_backend/logic/data-kelas-delete', [RequestBackEnd::class, 'doDeleteDataKelas']);
Route::post('/_backend/logic/search-class-room', [RequestBackEnd::class, 'doSearchDataKelas']);
Route::post('/_backend/logic/detail-kelas', [RequestBackEnd::class, 'doDetailKelas']);
Route::post('/_backend/logic/data-kelas-level', [RequestBackEnd::class, 'doLevelDataKelas']);

Route::post('/_backend/logic/data-guru', [RequestBackEnd::class, 'doListDataGuru']);
Route::post('/_backend/logic/data-guru-create', [RequestBackEnd::class, 'doCreateDataGuru']);
Route::post('/_backend/logic/data-guru-update', [RequestBackEnd::class, 'doUpdateDataGuru']);
Route::post('/_backend/logic/data-guru-delete', [RequestBackEnd::class, 'doDeleteDataGuru']);
Route::post('/_backend/logic/search-teacher', [RequestBackEnd::class, 'doSearchTeacher']);

Route::post('/_backend/logic/data-silabus', [RequestBackEnd::class, 'doListSilabus']);
Route::post('/_backend/logic/data-silabus-create', [RequestBackEnd::class, 'doCreateSilabus']);
Route::post('/_backend/logic/data-silabus-update', [RequestBackEnd::class, 'doUpdateSilabus']);
Route::post('/_backend/logic/data-silabus-search-id', [RequestBackEnd::class, 'doSearchSilabusId']);
Route::post('/_backend/logic/data-silabus-delete', [RequestBackEnd::class, 'doDeleteSilabus']);
Route::post('/_backend/logic/update-relasi-silabus', [RequestBackEnd::class, 'doUpdateRelasiSilabus']);

Route::post('/_backend/logic/data-siswa', [RequestBackEnd::class, 'doListSiswa']);
Route::post('/_backend/logic/data-siswa-create', [RequestBackEnd::class, 'doCreateSiswa']);
Route::post('/_backend/logic/data-siswa-update', [RequestBackEnd::class, 'doUpdateSiswa']);
Route::post('/_backend/logic/data-siswa-delete', [RequestBackEnd::class, 'doDeleteSiswa']);
Route::post('/_backend/logic/detail-siswa', [RequestBackEnd::class, 'doDetailSiswa']);
Route::post('/_backend/logic/kehadiran-siswa', [RequestBackEnd::class, 'doKehadiranSiswa']);
Route::post('/_backend/logic/ortu/remove-access', [RequestBackEnd::class, 'doOrtuRemoveAccess']);
Route::post('/_backend/logic/ortu/add-access', [RequestBackEnd::class, 'doOrtuAddAccess']);
Route::post('/_backend/logic/ortu/reset-access', [RequestBackEnd::class, 'doOrtuResetAccess']);
Route::post('/_backend/logic/ortu/unlink', [RequestBackEnd::class, 'doOrtuUnlink']);
Route::post('/_backend/logic/siswa/jurnal', [RequestBackEnd::class, 'doSiswaJurnal']);
Route::post('/_backend/logic/siswa/jurnal/detail', [RequestBackEnd::class, 'doSiswaJurnalDetail']);

Route::post('/_backend/logic/jurnal-item-nilai', [RequestBackEnd::class, 'doJurnalItemNilai']);
Route::post('/_backend/logic/data-jurnal', [RequestBackEnd::class, 'doListDataJurnal']);
Route::post('/_backend/logic/jurnal-create', [RequestBackEnd::class, 'doCreateJurnal']);
Route::post('/_backend/logic/jurnal-update', [RequestBackEnd::class, 'doUpdateJurnal']);
Route::post('/_backend/logic/jurnal-detail', [RequestBackEnd::class, 'doDetailJurnal']);
Route::post('/_backend/logic/jurnal-delete', [RequestBackEnd::class, 'doDeleteJurnal']);
Route::post('/_backend/logic/jurnal-update-absensi', [RequestBackEnd::class, 'doUpdateAbsensi']);
Route::post('/_backend/logic/inisiasi-penilaian', [RequestBackEnd::class, 'doInisiasiPenilaian']);
Route::post('/_backend/logic/update-penilaian', [RequestBackEnd::class, 'doUpdatePenilaian']);
Route::post('/_backend/logic/submit-item-penilaian', [RequestBackEnd::class, 'doSubmitItemPenilaian']);
Route::post('/_backend/logic/update-item-penilaian', [RequestBackEnd::class, 'doUpdateItemPenilaian']);
Route::post('/_backend/logic/download-single-penilaian-harian', [RequestBackEnd::class, 'doDownloadSingleNilaiHarian']);
Route::post('/_backend/logic/download-bulk-penilaian-harian', [RequestBackEnd::class, 'doDownloadBulkNilaiHarian']);