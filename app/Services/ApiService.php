<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Exception;
use Illuminate\Http\Client\ConnectionException;

class ApiService
{
    protected string $baseUrl;
    protected ?string $token;

    public function __construct(){
        $this->baseUrl = env('API_URL');
        $this->token   = session('access-token');
    }

    public function request(string $method, string $endpoint, array $payload = []){
        \Log::info('START REQUEST', [
            'method' => $method,
            'endpoint' => $endpoint,
            'payload' => $payload
        ]);
        $http = Http::baseUrl($this->baseUrl)
                ->timeout(5)
                ->retry(2, 100);

        // Inject custom header
        if ($this->token) {
            $http = $http->withHeaders([
                'Authorization' => $this->token
            ]);
        }

        try {
            $response = $http->$method($endpoint, $payload);
            $newToken = $response->header('Authorization');
            if ($newToken) {
                session(['access-token' => $newToken]);
            }
            \Log::info('FINISH REQUEST', [
                'method' => $method,
                'endpoint' => $endpoint,
                'headers' => $response->headers(),
                'data' => $response->json()
            ]);
            return $response;
        } catch (ConnectionException $e) {
            \Log::error('API TIMEOUT', [
                'message' => $e->getMessage(),
                'method' => $method,
                'endpoint' => $endpoint ?? null,
                'payload' => $payload ?? null
            ]);
            return new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(
                    504,
                    [],
                    json_encode([
                        'err_code' => 'TIMEOUT',
                        'err_msg'  => 'service timeout'
                    ])
                )
            );
        } catch (\Throwable $e) {
            $body = optional($e->response)->json() ?? [];
            \Log::error('API ERROR', [
                'message' => $e->getMessage(),
                'method' => $method ?? null,
                'endpoint' => $endpoint ?? null,
                'payload' => $payload ?? null,
                'response' => $body,
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(
                    500,
                    [],
                    json_encode([
                        'message' => $body['message'],
                        'err_code' => $body['err_code'],
                        'err_msg' => $body['err_msg'],
                        'err_details' => $body['err_details'],
                        'language' => $body['language'],
                        'timestamp' => $body['timestamp']
                    ])
                )
            );
        }
    }

    public function doLogin(string $email, string $password, string $endpoint) {
        try {
            $response = Http::baseUrl($this->baseUrl)
                    ->timeout(5)
                    ->retry(1, 100)
                    ->post($endpoint, [
                        'email' => $email,
                        'password' => $password
            ]);
            $token = $response->header('Authorization');
            $status_code = $response->status();
            $data = $response->json();
            
            if ($token) {
                session([
                    'access-token' => $token,
                    'nama_sekolah_sidebar' => $data['data']['nama_yayasan'],
                    'image' => $data['data']['image'],
                ]);
                $this->token = $token;
            }

            return $response;
        } catch (ConnectionException $e) {
            \Log::error('API TIMEOUT LOGIN', [
                'message' => $e->getMessage(),
                'endpoint' => $endpoint ?? null
            ]);

            return new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(
                    504,
                    [],
                    json_encode([
                        'err_code' => 'TIMEOUT',
                        'err_msg'  => 'service timeout'
                    ])
                )
            );
        } catch (\Throwable $e) {
            $body = $e->response->json();
            \Log::error('API ERROR LOGIN', [
                'message' => $e->getMessage(),
                'method' => 'POST',
                'endpoint' => $endpoint ?? null,
                'response' => $body,
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(
                    500,
                    [],
                    json_encode([
                        'data' => $body,
                        'err_msg' => 'Service tidak dapat dihubungi'
                    ])
                )
            );
        }
    }

    public function fetchAccess($endpoint) {
        try {
            \Log::info('START FETCH ACCESS', [
                'endpoint' => $endpoint
            ]);

            $response = Http::baseUrl($this->baseUrl)
                        ->timeout(5)
                        ->retry(1, 100)
                        ->post($endpoint, [
                'authorization' => $this->token
            ]);
            $token = $response->header('Authorization');
            $status_code = $response->status();
            $data = $response->json();

            if ($token) {
                session(['access-token' => $token]);
                $this->token = $token;
            }

            return $response;
        } catch (ConnectionException $e) {
            \Log::error('API TIMEOUT FETCH ACCESS', [
                'message' => $e->getMessage(),
                'endpoint' => $endpoint ?? null
            ]);
            return new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(
                    504,
                    [],
                    json_encode([
                        'err_code' => 'TIMEOUT',
                        'err_msg'  => 'service timeout'
                    ])
                )
            );
        } catch (\Throwable $e) {
            $body = optional($e->response)->json() ?? [];
            \Log::error('API ERROR FETCH ACCESS', [
                'message' => $e->getMessage(),
                'method' => $method ?? null,
                'endpoint' => $endpoint ?? null,
                'payload' => $payload ?? null,
                'response' => $body,
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(
                    500,
                    [],
                    json_encode([
                        'message' => $body['message'],
                        'err_code' => $body['err_code'],
                        'err_msg' => $body['err_msg'],
                        'err_details' => $body['err_details'],
                        'language' => $body['language'],
                        'timestamp' => $body['timestamp']
                    ])
                )
            );
        }
    }

    public function doListDataTingkatanKelas(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doCreateDataTingkatanKelas(array $data, string $url) {
        $payload = [
            'nama' => $data['nama'],
            'deskripsi' => $data['deskripsi']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doUpdateDataTingkatanKelas(array $data, string $url) {
        $payload = [
            'id' => $data['id'],
            'nama' => $data['nama'],
            'deskripsi' => $data['deskripsi']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doDeleteDataTingkatanKelas(array $data, string $url) {
        $payload = [
            'id' => $data['id']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doLevelDataTingkatanKelas(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doDetailTingkatanKelas(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doListDataKelas(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doLevelDataKelas(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doCreateDataKelas(array $data, string $url) {
        $payload = [
            'nama_kelas' => $data['nama_kelas'],
            'id_wali_kelas' => $data['id_wali_kelas'],
            'id_tingkatan_kelas' => $data['id_tingkatan_kelas']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doUpdateDataKelas(array $data, string $url) {
        $payload = [
            'id_kelas' => $data['id_kelas'],
            'nama_kelas' => $data['nama_kelas'],
            'id_wali_kelas' => $data['id_wali_kelas'],
            'id_tingkatan_kelas' => $data['id_tingkatan_kelas']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doDeleteDataKelas(array $data, string $url) {
        $payload = [
            'id' => $data['id']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doSearchDataKelas(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doDetailKelas(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doSearchTeacher(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doListDataGuru(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doCreateDataGuru(array $data, string $url) {
        $payload = [
            'niy' => $data['niy'],
            'nama' => $data['nama'],
            'email' => $data['email']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doUpdateDataGuru(array $data, string $url) {
        $payload = [
            'id' => $data['id'],
            'object_update' => $data['object_update']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doDeleteDataGuru(array $data, string $url) {
        $payload = [
            'id' => $data['id']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doListSilabus(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doDeleteSilabus(array $data, string $url) {
        $payload = [
            'id' => $data['id']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doSearchSilabusId(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doUpdateSilabus(array $data, string $url) {
        $payload = [
            'id' => $data['id'],
            'judul' => $data['judul'],
            'items' => $data['items']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doCreateSilabus(array $data, string $url) {
        $payload = [
            'judul' => $data['judul'],
            'items' => $data['items']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doUpdateRelasiSilabus(array $data, string $url) {
        $payload = [
            'id' => $data['id'],
            'items' => $data['items']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doCreateSiswa(array $payload, string $url){
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doUpdateSiswa(array $payload, string $url){
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doListSiswa(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doDetailSiswa(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doKehadiranSiswa(array $payload, string $url){
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doMyProfile(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doMyDs1ProfileUpdate(array $payload, string $url) {
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doCreateJurnal(array $payload, string $url){
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doDetailJurnal(string $url){
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doUpdateAbsensi(array $data, string $url) {
        $payload = [
            'id' => $data['id'],
            'absensi' => $data['absensi']
        ];
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doInisiasiPenilaian(array $payload, string $url) {
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doUpdatePenilaian(array $payload, string $url) {
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doListDataJurnal(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doSubmitItemPenilaian(array $payload, string $url) {
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doDownloadSingleNilaiHarian(array $payload, string $url) {
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doDownloadBulkNilaiHarian(array $payload, string $url) {
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doGetSettings(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function doChangePassword(array $payload, string $url) {
        $response = $this->request('POST', $url, $payload);
        return $response;
    }

    public function doOrtuRemoveAccess(array $payload, string $url) {
        $response = $this->request('POST', $url, $payload);
        return $response;
    }
}