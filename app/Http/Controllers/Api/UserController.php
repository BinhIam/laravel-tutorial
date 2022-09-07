<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use App\Services\CrudService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public $userService;
    public $repository;
    public $response;

    public function __construct(UserRepository $repository, CrudService $userService)
    {
        $this->repository = $repository;
        $this->userService = $userService;
    }

    /**
     * @description Display a listing of the resource for user
     * @param null
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $listUser = $this->repository->findAll();
        return $this->responseSuccess($listUser);
    }

    /**
     * @description Store a newly created resource in storage.
     * @param UserRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(UserRequest $request): JsonResponse
    {
        if ($request->isMethod('post') && Auth('sanctum')->check()) {
            try {
                if (!empty($request)) {
                    $user = $this->userService->create($request);
                    if (!$user->exists) {
                        return $this->responseFail();
                    }
                }
            } catch (\Exception $exception) {
                return $this->responseException($exception->getMessage());
            }
        }
        return $this->responseSuccess();
    }

    /**
     * @description Update the specified resource in storage.
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UserRequest $request, $id): JsonResponse
    {
        if ($request->isMethod('put') && Auth('sanctum')->check() && $id) {
            if (!empty($request)) {
                $user = $this->repository->findById($id);
                if (!$user) {
                    return $this->responseNotFound();
                } else {
                    $userUpdate = $this->userService->update($id,$request);
                    if (!$userUpdate) {
                        return $this->responseFail();
                    }
                }
            }
        }
        return $this->responseSuccess();
    }

    /**
     * @description Show specific user
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function show(UserRequest $request, $id): JsonResponse
    {
        $user = [];
        if ($request->isMethod('get')) {
            if (Auth('sanctum')->check() && $id) {
                $user = $this->repository->findById($id);
                if (!$user) {
                    return $this->responseNotFound();
                }
            }
        }
        return $this->responseSuccess($user);
    }

    /**
     * @description Delete specific user
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        if ($request->isMethod('delete')) {
            if (Auth('sanctum')->check() && $id) {
                $user = $this->repository->findById($id);
                if (!$user) {
                    return $this->responseNotFound();
                }
                $this->repository->deleteId($id);
            }
        }
        return $this->responseSuccess();
    }
}
