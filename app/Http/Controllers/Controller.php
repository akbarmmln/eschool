<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Services\ApiService;

class Controller
{
    const ROLE_ADMIN = '0';
    const ROLE_GURU = '1';
    const ROLE_ORANG_TUA = '2';

    public function __construct(ApiService $apiService) {
        $this->apiService = $apiService;
    }

    public function index(Request $request) {
        $dashboards = [
            '0' => 'admin.dashboard',
            '1' => 'guru.dashboard',
            '2' => 'ortu.dashboard',
        ];

        $role = $request->auth_role;
        $tipe_account = $request->auth_tipe_account;
        $id_account = $request->auth_id_account;
        return isset($dashboards[$role])
            ? view($dashboards[$role], compact('id_account', 'tipe_account'))
            : response()->view('forbidden', [], 403);
    }
    
    public function ubahmateri(Request $request, $id) {
        $role = $request->auth_role;
        return view('ubah-materi', compact('role', 'id'));
    }

    public function tambahmateri(Request $request) {
        $role = $request->auth_role;
        return view('tambah-materi', compact('role'));
    }

    public function silabus(Request $request) {
        $role = $request->auth_role;
        return view('data-silabus', compact('role'));
    }

    public function tingkatkelasdetail(Request $request, $id) {
        $role = $request->auth_role;
        return view('detail-tingkat-kelas-new', compact('role', 'id'));
    }

    public function tingkatkelas(Request $request) {
        $role = $request->auth_role;
    	return view('data-tingkat-kelas', compact('role'));
    }

    public function kelasdetail(Request $request, $id) {
        $role = $request->auth_role;
        return view('detail-kelas-new', compact('role', 'id'));
    }

    public function kelas(Request $request) {
        $role = $request->auth_role;
    	return view('data-kelas', [
            'role' => $role
        ]);
    }

    public function guru(Request $request) {
        $role = $request->auth_role;
        $id_account = $request->auth_id_account;
        
    	return view('data-guru', compact('role', 'id_account'));
    }

    public function siswa(Request $request) {
        $role = $request->auth_role;
        return view('data-siswa', compact('role'));
    }

    public function siswatambah(Request $request) {
        $role = $request->auth_role;
        return view('tambah-siswa', compact('role'));
    }

    public function siswadetail(Request $request, $id) {
        $role = $request->auth_role;
        return view('detail-siswa', compact('role', 'id'));
    }

    public function siswaubah(Request $request, $id) {
        $role = $request->auth_role;
        return view('ubah-siswa', compact('role', 'id'));
    }

    public function jurnalmateri(Request $request, $id) {
        $role = $request->auth_role;
        return response()->view('jurnal-materi-new', compact('role', 'id'));
    }

    public function pengaturan(Request $request) {
        $role = $request->auth_role;
        return response()->view('pengaturan', compact('role'));
    }

    public function profile(Request $request) {
        $role = $request->auth_role;
        return response()->view('profile', compact('role'));
    }

    public function doForbidden() {
        return response()->view('forbidden', [], 403);
    }

    public function login() {
        return view('login');
    }

    public function doLogout(string $status = 'success') {
        session()->flush();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        if($status == 'jwt-expr') {
            return redirect('/akademik/login')->with('error', 'Demi keamanan, Anda baru saja ter-logout otomatis. Login kembali untuk melanjutkan');
        } else {
            return redirect('/akademik/login')->with('success', 'Logout berhasil.');
        }
    }
}
