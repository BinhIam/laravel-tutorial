<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

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
        try {
            return $this->authService->register($request);
        } catch (\Exception $exception) {
            return $this->responseHelper->responseException($exception);
        }
    }

    /**
     * Show the list user
     *
     * @param LoginRequest $request
     * @return JsonResponse|ServiceProvider
     */
    public function login(LoginRequest $request): JsonResponse|ServiceProvider
    {
        try {
            return $this->authService->login($request);
        } catch (\Exception $exception) {
            return $this->responseHelper->responseException($exception);
        }
    }

    /**
     * Log out user
     *
     * @param Request $request
     * @return JsonResponse|ServiceProvider
     */
    public function logout(Request $request): JsonResponse|ServiceProvider
    {
        try {
            return $this->authService->logout();
        } catch (\Exception $exception) {
            return $this->responseHelper->responseException($exception);
        }
    }
}
