<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\ApiService;

class RequestBackEnd
{
    // public function __construct(ApiService $apiService) {
    //     $this->apiService = $apiService;
    // }

    public function doLogin(Request $request, ApiService $apiService) {
        $result = $apiService->doLogin($request->email, $request->password, '/api/v1/auth/login');
        $dataStatusCode = $result->status();
        $dataResponse = $result->json();

        if ($result->failed()) {
            $errCode = $dataResponse['err_code'] ?? null;
            $message = ($errCode === '70005') ? 'Username dan Password tidak sesuai' : ($dataResponse['err_msg'] ?? 'Terjadi kesalahan');
            return response()->json([
                'status'  => false,
                'message' => $message
            ], $dataStatusCode);
        } else {
            return response()->json([
                'status'  => true,
                'message' => ''
            ], $dataStatusCode);
        }
    }

    public function doListDataTingkatanKelas(Request $request, ApiService $apiService) {
        $page = $request->page;
        $search = $request->search;
        $url = "/api/v1/class-level/list/$page";

        if (filled($search)) {
            $url .= "/$search";
        }

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateDataTingkatanKelas(Request $request, ApiService $apiService) {
        $url = "api/v1/class-level/create";

        $response = $apiService->fetchPOST($request->only(['nama', 'deskripsi']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateDataTingkatanKelas(Request $request, ApiService $apiService) {
        $url = "api/v1/class-level/update";

        $response = $apiService->fetchPOST($request->only(['id', 'nama', 'deskripsi']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteDataTingkatanKelas(Request $request, ApiService $apiService) {
        $url = "api/v1/class-level/delete";

        $response = $apiService->fetchPOST($request->only(['id']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doLevelDataTingkatanKelas(Request $request, ApiService $apiService) {
        $url = "api/v1/class-level/level";
        
        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDetailTingkatanKelas(Request $request, ApiService $apiService) {
        $id = $request->id;
        $url = "api/v1/class-level/detail/$id";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doListDataKelas(Request $request, ApiService $apiService) {
        $page = $request->page;
        $search = $request->search;
        $url = "/api/v1/class-room/list/$page";

        if (filled($search)) {
            $url .= "/$search";
        }

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doLevelDataKelas(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-room/class";
        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateDataKelas(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-room/create";
        $response = $apiService->fetchPOST($request->only(['nama_kelas', 'id_wali_kelas', 'id_tingkatan_kelas']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateDataKelas(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-room/update";
        $response = $apiService->fetchPOST($request->only(['id_kelas', 'nama_kelas', 'id_wali_kelas', 'id_tingkatan_kelas']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteDataKelas(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-room/delete";
        $response = $apiService->fetchPOST($request->only(['id']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSearchDataKelas(Request $request, ApiService $apiService) {
        $keyword = $request->keyword;
        $url = "api/v1/class-room/search/$keyword";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDetailKelas(Request $request, ApiService $apiService) {
        $id = $request->id;
        $url = "api/v1/class-room/detail/$id";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSearchTeacher(Request $request, ApiService $apiService) {
        $keyword = $request->keyword;
        $url = "api/v1/teacher/search/$keyword";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doListDataGuru(Request $request, ApiService $apiService) {
        $page = $request->page;
        $search = $request->search;
        $url = "/api/v1/teacher/list/$page";

        if (filled($search)) {
            $url .= "/$search";
        }

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateDataGuru(Request $request, ApiService $apiService) {
        $url = "/api/v1/teacher/create";
        $response = $apiService->fetchPOST($request->only(['niy', 'nama', 'email']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateDataGuru(Request $request, ApiService $apiService) {
        $url = "/api/v1/teacher/update";
        $response = $apiService->fetchPOST($request->only([
            'id',
            'object_update.niy',
            'object_update.nama'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteDataGuru(Request $request, ApiService $apiService) {
        $url = "/api/v1/teacher/delete";
        $response = $apiService->fetchPOST($request->only(['id']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doListSilabus(Request $request, ApiService $apiService) {
        $page = $request->page;
        $search = $request->search;
        $url = "/api/v1/silabus/list/$page";

        if (filled($search)) {
            $url .= "/$search";
        }

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteSilabus(Request $request, ApiService $apiService) {
        $url = "/api/v1/silabus/delete";
        $response = $apiService->fetchPOST($request->only(['id']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSearchSilabusId(Request $request, ApiService $apiService) {
        $keyword = $request->materiId;
        $url = "/api/v1/silabus/detail/$keyword";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateSilabus(Request $request, ApiService $apiService) {
        $url = "/api/v1/silabus/update";
        $response = $apiService->fetchPOST($request->only([
            'id',
            'judul',
            'items'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateSilabus(Request $request, ApiService $apiService) {
        $url = "/api/v1/silabus/create";
        $response = $apiService->fetchPOST($request->only([
            'judul',
            'items'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateRelasiSilabus(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-level/update/relasi-silabus";
        $response = $apiService->fetchPOST($request->only([
            'id',
            'items'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateSiswa(Request $request, ApiService $apiService) {
        $url = "api/v1/siswa/create";

        $response = $apiService->fetchPOST($request->only([
            'image',
            'nik',
            'nama_lengkap',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat',
            'no_rt',
            'no_rw',
            'kelurahan',
            'kecamatan',
            'id_kelas',
            'nama_ayah',
            'nama_ibu',
            'email_aktif',
            'ocup_ayah',
            'ocup_ibu'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateSiswa(Request $request, ApiService $apiService) {
        $url = "api/v1/siswa/update";

        $response = $apiService->fetchPOST($request->only([
            'id_siswa',
            'change_image',
            'image',
            'nik',
            'nama_lengkap',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat',
            'no_rt',
            'no_rw',
            'kelurahan',
            'kecamatan',
            'id_kelas',
            'id_parent',
            'nama_ayah',
            'nama_ibu',
            'email_aktif',
            'ocup_ayah',
            'ocup_ibu'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteSiswa(Request $request, ApiService $apiService) {
        $url = "api/v1/siswa/delete";

        $response = $apiService->fetchPOST($request->only([
            'id'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doListSiswa(Request $request, ApiService $apiService) {
        $page = $request->page;
        $search = $request->search;
        $url = "/api/v1/siswa/list/$page";

        if (filled($search)) {
            $url .= "/$search";
        }

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDetailSiswa(Request $request, ApiService $apiService) {
        $id = $request->id;
        $url = "/api/v1/siswa/detail/$id";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doKehadiranSiswa(Request $request, ApiService $apiService) {
        $url = "/api/v1/siswa/absensi";

        $response = $apiService->fetchPOST($request->only([
            'id_siswa',
            'dari',
            'sampai'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doMyProfile(Request $request, ApiService $apiService) {
        $url = "/api/v1/profile";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doMyProfileD2(Request $request, ApiService $apiService) {
        $url = "/api/v1/profile/d2";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doMyDs1ProfileUpdate(Request $request, ApiService $apiService) {
        $url = "/api/v1/profile/ds1/update-personal";

        $response = $apiService->fetchPOST($request->only([
            'object_update'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doMyDs2ProfileUpdate(Request $request, ApiService $apiService) {
        $url = "/api/v1/profile/ds2/update-personal";

        $response = $apiService->fetchPOST($request->only([
            'object_update'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doMyUpdateEmail(Request $request, ApiService $apiService) {
        $url = "/api/v1/profile/update-email";
        $response = $apiService->fetchPOST($request->only([
            'email_baru'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateJurnal(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/create-new";
        $response = $apiService->fetchPOST($request->only([
            'tanggal',
            'mulai',
            'selesai',
            'materi',
            'refleksi',
            'kelas',
            'guru'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDetailJurnal(Request $request, ApiService $apiService) {
        $id = $request->id;
        $url = "/api/v1/jurnal/detail/$id";

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteJurnal(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/delete";

        $response = $apiService->fetchPOST($request->only([
            'id',
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateAbsensi(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/update-absensi";
        $response = $apiService->fetchPOST($request->only([
            'id',
            'absensi'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doInisiasiPenilaian(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/inisiasi-penilaian";
        $response = $apiService->fetchPOST($request->only([
            'id_jurnal',
            'id_siswa',
            'id_diajar'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdatePenilaian(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/update-penilaian";
        $response = $apiService->fetchPOST($request->only([
            'data',
            'files',
            'id_jurnal',
            'id_siswa'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doListDataJurnal(Request $request, ApiService $apiService) {
        $page = $request->page;
        $dari = $request->dari;
        $sampai = $request->sampai;
        
        $url = "/api/v1/jurnal/list/$page";

        if (filled($dari) && filled($sampai)) {
            $url .= "/$dari/$sampai";
        }

        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSubmitItemPenilaian(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/submit-item-penilaian";
        $response = $apiService->fetchPOST($request->only([
            'id_jurnal',
            'id_diajar',
            'judul',
            'item_penilaian'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDownloadSingleNilaiHarian(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/download-single-penilaian-harian";
        $response = $apiService->fetchPOST($request->only([
            'id_jurnal',
            'id_detail_diajar',
            'nama_siswa'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDownloadBulkNilaiHarian(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/download-bulk-penilaian-harian";
        $response = $apiService->fetchPOST($request->only([
            'id_jurnal'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doGetSettings(Request $request, ApiService $apiService) {
        $url = "/api/v1/settings";
        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doChangePassword(Request $request, ApiService $apiService) {
        $url = "/api/v1/profile/change/password";
        $response = $apiService->fetchPOST($request->only([
            'password_lama',
            'password_baru'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doOrtuRemoveAccess(Request $request, ApiService $apiService) {
        $url = "/api/v1/siswa/ortu/remove-access";
        $response = $apiService->fetchPOST($request->only([
            'id_siswa',
            'id_access',
            'email'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doOrtuAddAccess(Request $request, ApiService $apiService) {
        $url = "/api/v1/siswa/ortu/add-access";
        $response = $apiService->fetchPOST($request->only([
            'id_siswa',
            'email',
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doOrtuResetAccess(Request $request, ApiService $apiService) {
        $url = "/api/v1/siswa/ortu/reset-access";
        $response = $apiService->fetchPOST($request->only([
            'id_access'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doOrtuUnlink(Request $request, ApiService $apiService) {
        $url = "/api/v1/siswa/ortu/unlink";
        $response = $apiService->fetchPOST($request->only([
            'id_siswa'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSiswaJurnal(Request $request, ApiService $apiService) {
        $page = $request->page;
        $url = "/api/v1/siswa/jurnal/$page";
        $response = $apiService->fetchPOST($request->only([
            'id_siswa',
            'dari',
            'sampai'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doForgetPassword(Request $request, ApiService $apiService) {
        $url = "/api/v1/auth/invalidate-forgot-password";
        $response = $apiService->fetchPOST($request->only([
            'email'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doInvalidatePage(Request $request, ApiService $apiService) {
        $jwt = $request->jwt;
        $url = "/api/v1/auth/invalidate-page/$jwt";
        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doVerifyOTP(Request $request, ApiService $apiService) {
        $url = "/api/v1/auth/verify-otp";
        $response = $apiService->fetchPOST($request->only([
            'type',
            'otp',
            'jwt'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doInvalidatePassword(Request $request, ApiService $apiService) {
        $url = "/api/v1/auth/invalidate/password";
        $response = $apiService->fetchPOST($request->only([
            'password',
            'session'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSiswaJurnalDetail(Request $request, ApiService $apiService) {
        $idjurnal = $request->idjurnal;
        $idsiswa = $request->idsiswa;
        $url = "/api/v1/siswa/jurnal/detail/$idjurnal/$idsiswa";
        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doRoleList(Request $request, ApiService $apiService) {
        $page = $request->page;
        $url = "/api/v1/auth/role/list/$page";
        $response = $apiService->fetchGET($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }
}