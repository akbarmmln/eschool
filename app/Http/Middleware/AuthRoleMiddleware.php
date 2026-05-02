<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ApiService;
use App\Http\Controllers\Controller;

class AuthRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    protected $apiService;

    public function __construct(ApiService $apiService) {
        $this->apiService = $apiService;
    }

    public function handle(Request $request, Closure $next, ...$roles): Response {
        $endpoint = "api/v1/auth/access";
        $response = $this->apiService->fetchAccess($endpoint);
        $dataStatusCode = $response->status();
        $dataResponse = $response->json();

        if ($response->failed()) {
            if ($dataStatusCode == 500 || $dataStatusCode == 502 || $dataStatusCode == 504) {
                session(['page_gateway_timeout' => true]);
                return redirect('/akademik/rto');
            } else if($dataStatusCode == 401) {
                return app(Controller::class)->doLogout('jwt-expr');
            } else {
                return app(Controller::class)->doLogout('jwt-expr');
            }
        } else {
            $role = $dataResponse['data']['role'];
            $tipe_account = $dataResponse['data']['tipe_account'];
            $id_account = $dataResponse['data']['id_account'];

            if (!in_array($role, $roles)) {
                session(['page_forbidden_access' => true]);
                return redirect('/akademik/forbidden');
            }

            $request->merge([
                'auth_role' => $role,
                'auth_tipe_account' => $tipe_account,
                'auth_id_account' => $id_account
            ]);

            return $next($request);
        }
    }
}
