<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

/**
 *
 */
class AuthController extends BaseController
{
    /**
     * Register new user
     *
     * @param RegisterRequest $request
     * @return JsonResponse|ServiceProvider
     */
    public function register(RegisterRequest $request): JsonResponse|ServiceProvider
    {
        $response = $this->authService->register($request);
        return $this->tryBlock($response);
    }

    /**
     * Show the list user
     *
     * @param LoginRequest $request
     * @return JsonResponse|ServiceProvider
     */
    public function login(LoginRequest $request): JsonResponse|ServiceProvider
    {
        $response = $this->authService->login($request);
        return $this->tryBlock($response);
    }

    /**
     * Log out user
     *
     * @param Request $request
     * @return JsonResponse|ServiceProvider
     */
    public function logout(Request $request): JsonResponse|ServiceProvider
    {
        $response = $this->authService->logout();
        return $this->tryBlock($response);
    }
}
