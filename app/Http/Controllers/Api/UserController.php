<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $status = 200;
    public $message = '';

    public function register(RegisterRequest $request, UserRepository $repository){
        $user = $repository->register($request);
        //create token
        $token = $user->createToken('authToken')->plainTextToken;
        $this->message = config('message.user_register.success');

        $response = [
            'status_code'=> $this->status,
            'message'=> $this->message,
            'data' =>   [
                'user' => $user,
                #'token' => $token
            ]
        ];
        return response($response,201);
    }

    /**
     * Show the list user
     *
     * @param UserRequest $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function login(LoginRequest $request, UserRepository $repository): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            $this->status = config('status.error');
            $this->message = config('message.user_login.fail');
        }
        $user = $repository->findByEmail($request->get('email'));
        if (!Hash::check($request->get('password'), $user->password)) {
            $this->status = config('status.not_found');
            $this->message = config('message.user_login.wrong');
        }
        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'status_code' => 200,
            'data' => [
                'access_token' => $tokenResult,
                'user' => $user
            ]
        ]);
    }

    /**
     * Log out user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke all tokens
        auth()->user()->tokens()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => config('message.user_logout.success'),
        ]);
    }

    /**
     * Show the list user
     *
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function index(UserRepository $repository): JsonResponse
    {
        $listUser = $repository->findAll();
        return response()->json($listUser);
    }

    /**
     * Create new user
     *
     * @param UserRequest $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function create(UserRequest $request, UserRepository $repository): JsonResponse
    {
        if ($request->isMethod('post') && Auth('sanctum')->check()) {
            if (!empty($request)) {
                $user = $repository->createUser([
                    'name' => $request->get('name'),
                    'age' => $request->get('age'),
                    'class' => $request->get('class_id'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password'))
                ]);
                if (!$user->exists) {
                    $this->status = config('status.error');
                }
                $this->message = config('message.user_add.success');
            }
        }
        return response()->json([
                'message' => $this->message,
                'status_code' => $this->status
            ]
        );
    }

    public function update(UserRequest $request, UserRepository $repository, $id): JsonResponse
    {
        if ($request->isMethod('put') && Auth('sanctum')->check() && $id) {
            if (!empty($request)) {
                $user = $repository->findById($id);
                if (!$user) {
                    $this->status = config('status.not_found');
                    $this->message = config('message.user_update.not_found');
                } else {
                    $userUpdate = $repository->updateUser($id, [
                        'name' => $request->get('name'),
                        #'age' => $request->get('age'),
                        #'class' => $request->get('class_id'),
                        'email' => $request->get('email'),
                    ]);
                    if (!$userUpdate) {
                        $this->status = config('status.error');
                    }
                }
            }
        }
        return response()->json([
            'message' => $this->message,
            'status_code' => $this->status
        ]);
    }

    public function view(UserRequest $request, UserRepository $repository, $id): JsonResponse
    {
        $user = [];
        if ($request->isMethod('get')) {
            if (Auth('sanctum')->check() && $id) {
                $user = $repository->findById($id);
                if (!$user) {
                    $this->status = config('status.not_found');
                    $this->message = config('message.user_update.not_found');
                }
            }
        }
        return response()->json($user, $this->status);
    }

    public function destroy(Request $request, UserRepository $repository, $id): JsonResponse
    {
        if ($request->isMethod('delete')) {
            if (Auth('sanctum')->check() && $id) {
                $user = $repository->findById($id);
                if (!$user) {
                    $this->status = config('status.not_found');
                    $this->message = config('message.user_update.not_found');
                }
                $repository->deleteId($id);
            }
        }
        return response()->json([
            'message' => $this->message,
            'status_code' => $this->status
        ]);
    }
}
