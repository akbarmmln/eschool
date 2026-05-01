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
        $this->baseUrl = config('custom.api_url_v1');
        $this->token   = session('access-token');
    }

    public function request(string $method, string $endpoint, array $payload = [], int $timeout){
        \Log::info('START REQUEST', [
            'method' => $method,
            'endpoint' => $endpoint,
            'payload' => $payload
        ]);
        $http = Http::baseUrl($this->baseUrl)
            ->timeout($timeout)
            ->retry(0, 100, function ($exception, $request) {
                return $exception instanceof \Illuminate\Http\Client\ConnectionException;
            });

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

    public function fetchGET(string $url) {
        $response = $this->request('GET', $url);
        return $response;
    }

    public function fetchPOST(array $payload, string $url, int $timeout = 30) {
        //jika diperlukan untuk dilakukan mapping terhadap payload body gunakan cara ini
        // $newPayload = [
        //     'id' => $payload['id'],
        //     ...lainnya
        // ];

        $response = $this->request('POST', $url, $payload, $timeout);
        return $response;
    }
}