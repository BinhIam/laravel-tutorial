<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class UserController extends BaseController
{

    /**
     * Display a listing of the resource for user
     *
     * @return JsonResponse|ServiceProvider
     */
    public function index(Request $request): JsonResponse|ServiceProvider
    {
        if ($request->isMethod('get')) {
            $listUser = $this->repository->findAll();
        } else {
            $listUser = $this->userService->searchFullText($request);
        }
        return $this->responseHelper->responseSuccess($listUser);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse|ServiceProvider
     * @throws Exception
     */
    public function store(UserRequest $request): JsonResponse|ServiceProvider
    {
        try {
            return $this->userService->create($request);
        } catch (Exception $exception) {
            return $this->responseHelper->responseException($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse|ServiceProvider
     */
    public function update(UserRequest $request, $id): JsonResponse|ServiceProvider
    {
        try {
            return $this->userService->update($id, $request);
        } catch (Exception $exception) {
            return $this->responseHelper->responseException($exception);
        }
    }

    /**
     * Show specific user
     *
     * @param $id
     * @return JsonResponse|ServiceProvider
     */
    public function show($id): JsonResponse|ServiceProvider
    {
        try {
            return $this->userService->show($id);
        } catch (Exception $exception) {
            return $this->responseHelper->responseException($exception);
        }
    }

    /**
     * Delete specific user
     *
     * @param $id
     * @return JsonResponse|ServiceProvider
     */
    public function destroy($id): JsonResponse|ServiceProvider
    {
        try {
            return $this->userService->delete($id);
        } catch (Exception $exception) {
            return $this->responseHelper->responseException($exception);
        }
    }
}
