<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use App\Services\CrudService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public CrudService $userService;
    public UserRepository $repository;

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
     * @throws Exception
     */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            if ($request->isMethod('post') && Auth('sanctum')->check()) {
                if (!empty($request)) {
                    $user = $this->userService->create($request);
                    if (!$user->exists) {
                        return $this->responseFail();
                    }
                }
            }
        } catch (Exception $exception) {
            return $this->responseException($exception->getMessage());
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
        try {
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
        } catch (Exception $exception) {
            return $this->responseException($exception->getMessage());
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
        try {
            if ($request->isMethod('get') && Auth('sanctum')->check() && $id) {
                $user = $this->repository->findById($id);
                if (!$user) {
                    return $this->responseNotFound();
                }
            }
        } catch (Exception $exception) {
            return $this->responseException($exception->getMessage());
        }
        return $this->responseSuccess($user);
    }

    /**
     * @description Delete specific user
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        try {
            if ($request->isMethod('delete') && Auth('sanctum')->check() && $id) {
                $user = $this->repository->findById($id);
                if (!$user) {
                    return $this->responseNotFound();
                }
                $this->repository->deleteId($id);
            }
        } catch (Exception $exception) {
            return $this->responseException($exception->getMessage());
        }
        return $this->responseSuccess();
    }
}
