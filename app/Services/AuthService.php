<?php namespace App\Services;

use App\Events\UserRegistered;
use App\Helpers\ResponseHelper;
use App\Listeners\UserRegisterd;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * The user repository.
     *
     */
    public UserRepository|Model $userRepository;

    /**
     * The response helper.
     *
     */
    public ResponseHelper $responseHelper;


    public function __construct(
        UserRepository $userRepository,
        ResponseHelper $responseHelper
    ){
        $this->userRepository = $userRepository;
        $this->responseHelper = $responseHelper;
    }

    /**
     * @description Register for user
     *
     * @param $request
     * @return JsonResponse
     * @var Model
     */
    public function register($request): JsonResponse
    {
        // Create new user instantly
        $user = $this->userRepository->createUser([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
        event(new UserRegistered);
        if (!$user->exists) {
            return $this->responseHelper->responseFail();
        }
        return $this->responseHelper->responseSuccess(['user' => $user]);
    }

    /**
     * @description Login for user
     *
     * @param $request
     * @return JsonResponse
     * @var Model
     */
    public function login($request): JsonResponse
    {
        // Accept only email, password
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return $this->responseHelper->responseFail();
        }
        // Find user by email
        $user = $this->userRepository->findByEmail($request->get('email'));
        if (!Hash::check($request->get('password'), $user->password)) {
            return $this->responseHelper->responseNotFound();
        }
        // Generate current token for using other api
        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return $this->responseHelper->responseSuccess([
            'access_token' => $tokenResult,
            'user' => $user
        ]);
    }

    /**
     * @description Logout for user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        // Revoke all tokens
        auth()->user()->tokens()->delete();
        return $this->responseHelper->responseSuccess();
    }
}

