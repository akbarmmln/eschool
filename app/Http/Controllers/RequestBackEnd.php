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

        $response = $apiService->doListDataTingkatanKelas($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateDataTingkatanKelas(Request $request, ApiService $apiService) {
        $url = "api/v1/class-level/create";

        $response = $apiService->doCreateDataTingkatanKelas($request->only(['nama', 'deskripsi']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateDataTingkatanKelas(Request $request, ApiService $apiService) {
        $url = "api/v1/class-level/update";

        $response = $apiService->doUpdateDataTingkatanKelas($request->only(['id', 'nama', 'deskripsi']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteDataTingkatanKelas(Request $request, ApiService $apiService) {
        $url = "api/v1/class-level/delete";

        $response = $apiService->doDeleteDataTingkatanKelas($request->only(['id']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doLevelDataTingkatanKelas(Request $request, ApiService $apiService) {
        $url = "api/v1/class-level/level";
        
        $response = $apiService->doLevelDataTingkatanKelas($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDetailTingkatanKelas(Request $request, ApiService $apiService) {
        $id = $request->id;
        $url = "api/v1/class-level/detail/$id";

        $response = $apiService->doDetailTingkatanKelas($url);
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

        $response = $apiService->doListDataKelas($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doLevelDataKelas(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-room/class";
        $response = $apiService->doLevelDataKelas($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateDataKelas(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-room/create";
        $response = $apiService->doCreateDataKelas($request->only(['nama_kelas', 'id_wali_kelas', 'id_tingkatan_kelas']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateDataKelas(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-room/update";
        $response = $apiService->doUpdateDataKelas($request->only(['id_kelas', 'nama_kelas', 'id_wali_kelas', 'id_tingkatan_kelas']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteDataKelas(Request $request, ApiService $apiService) {
        $url = "/api/v1/class-room/delete";
        $response = $apiService->doDeleteDataKelas($request->only(['id']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSearchDataKelas(Request $request, ApiService $apiService) {
        $keyword = $request->keyword;
        $url = "api/v1/class-room/search/$keyword";

        $response = $apiService->doSearchDataKelas($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDetailKelas(Request $request, ApiService $apiService) {
        $id = $request->id;
        $url = "api/v1/class-room/detail/$id";

        $response = $apiService->doDetailKelas($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSearchTeacher(Request $request, ApiService $apiService) {
        $keyword = $request->keyword;
        $url = "api/v1/teacher/search/$keyword";

        $response = $apiService->doSearchTeacher($url);
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

        $response = $apiService->doListDataGuru($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateDataGuru(Request $request, ApiService $apiService) {
        $url = "/api/v1/teacher/create";
        $response = $apiService->doCreateDataGuru($request->only(['niy', 'nama', 'email']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateDataGuru(Request $request, ApiService $apiService) {
        $url = "/api/v1/teacher/update";
        $response = $apiService->doUpdateDataGuru($request->only([
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
        $response = $apiService->doDeleteDataGuru($request->only(['id']), $url);
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

        $response = $apiService->doListSilabus($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDeleteSilabus(Request $request, ApiService $apiService) {
        $url = "/api/v1/silabus/delete";
        $response = $apiService->doDeleteSilabus($request->only(['id']), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSearchSilabusId(Request $request, ApiService $apiService) {
        $keyword = $request->materiId;
        $url = "/api/v1/silabus/detail/$keyword";
        $response = $apiService->doSearchSilabusId($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateSilabus(Request $request, ApiService $apiService) {
        $url = "/api/v1/silabus/update";
        $response = $apiService->doUpdateSilabus($request->only([
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
        $response = $apiService->doCreateSilabus($request->only([
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
        $response = $apiService->doUpdateRelasiSilabus($request->only([
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

        $response = $apiService->doCreateSiswa($request->only([
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

        $response = $apiService->doUpdateSiswa($request->only([
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

    public function doListSiswa(Request $request, ApiService $apiService) {
        $page = $request->page;
        $search = $request->search;
        $url = "/api/v1/siswa/list/$page";

        if (filled($search)) {
            $url .= "/$search";
        }

        $response = $apiService->doListSiswa($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doDetailSiswa(Request $request, ApiService $apiService) {
        $id = $request->id;
        $url = "/api/v1/siswa/detail/$id";

        $response = $apiService->doDetailSiswa($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doKehadiranSiswa(Request $request, ApiService $apiService) {
        $url = "/api/v1/siswa/absensi";

        $response = $apiService->doKehadiranSiswa($request->only([
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

        $response = $apiService->doMyProfile($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doMyDs1ProfileUpdate(Request $request, ApiService $apiService) {
        $url = "/api/v1/profile/ds1/update-personal";

        $response = $apiService->doMyDs1ProfileUpdate($request->only([
            'object_update'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doCreateJurnal(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/create-new";
        $response = $apiService->doCreateJurnal($request->only([
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

        $response = $apiService->doDetailJurnal($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdateAbsensi(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/update-absensi";
        $response = $apiService->doUpdateAbsensi($request->only([
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
        $response = $apiService->doInisiasiPenilaian($request->only([
            'id_jurnal',
            'id_diajar'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doUpdatePenilaian(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/update-penilaian";
        $response = $apiService->doUpdatePenilaian($request->only([
            'data'
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

        $response = $apiService->doListDataJurnal($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doSubmitItemPenilaian(Request $request, ApiService $apiService) {
        $url = "/api/v1/jurnal/submit-item-penilaian";
        $response = $apiService->doSubmitItemPenilaian($request->only([
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
        $response = $apiService->doDownloadSingleNilaiHarian($request->only([
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
        $response = $apiService->doDownloadBulkNilaiHarian($request->only([
            'id_jurnal'
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doGetSettings(Request $request, ApiService $apiService) {
        $url = "/api/v1/settings";
        $response = $apiService->doGetSettings($url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function doChangePassword(Request $request, ApiService $apiService) {
        $url = "/api/v1/profile/change/password";
        $response = $apiService->doChangePassword($request->only([
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
        $response = $apiService->doOrtuRemoveAccess($request->only([
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
        $response = $apiService->doOrtuAddAccess($request->only([
            'id_siswa',
            'email',
        ]), $url);
        return response()->json(
            $response->json(),
            $response->status()
        );
    }
}