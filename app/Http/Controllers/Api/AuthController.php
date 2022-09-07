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
    public $repository;
    public $userService;
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
        $user = $this->userService->create($request);
        $this->message = config('message.user_register.success');
        return $this->response($this->status, $this->message,
            [
                'user' => $user
            ]
        );
    }

    /**
     * @description Show the list user
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Accept only email, password
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            $this->status = config('status.error');
            $this->message = config('message.user_login.fail');
        }
        // Find user by email
        $user = $this->repository->findByEmail($request->get('email'));
        if (!Hash::check($request->get('password'), $user->password)) {
            $this->status = config('status.not_found');
            $this->message = config('message.user_login.wrong');
        }
        // Generate current token for using other api
        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return $this->response($this->status, $this->message,
            [
                'access_token' => $tokenResult,
                'user' => $user
            ]
        );
    }

    /**
     * @description Log out user
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke all tokens
        auth()->user()->tokens()->delete();
        $this->message = config('message.user_logout.success');
        return $this->response($this->status, $this->message);
    }
}
