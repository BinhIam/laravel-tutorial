<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepository;
use App\Services\CrudService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public UserRepository $repository;
    public CrudService $userService;
    public $status = 200;
    public $message = '';

    public function __construct(UserRepository $repository, CrudService $userService)
    {
        $this->repository = $repository;
        $this->userService = $userService;
    }

    /**
     * @description Register new user
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            // Create new user instantly
            $user = $this->userService->create($request);
            if (!$user->exists) {
                return $this->responseFail();
            }
            return $this->responseSuccess(['user' => $user]);
        } catch (\Exception $exception) {
            return $this->responseException($exception->getMessage());
        }
    }

    /**
     * @description Show the list user
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            // Accept only email, password
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                return $this->responseFail();
            }
            // Find user by email
            $user = $this->repository->findByEmail($request->get('email'));
            if (!Hash::check($request->get('password'), $user->password)) {
                return $this->responseNotFound();
            }
            // Generate current token for using other api
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return $this->responseSuccess([
                'access_token' => $tokenResult,
                'user' => $user
            ]);
        } catch (\Exception $exception) {
            return $this->responseException($exception->getMessage());
        }
    }

    /**
     * @description Log out user
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Revoke all tokens
            auth()->user()->tokens()->delete();
            return $this->responseSuccess();
        } catch (\Exception $exception) {
            return $this->responseException($exception->getMessage());
        }
    }
}
