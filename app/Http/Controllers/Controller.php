<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Repositories\User\UserRepository;
use App\Services\RedisCommonService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *
     * @var mixed
     */
    public mixed $userService;

    /**
     *
     * @var mixed
     */
    public mixed $authService;

    /**
     *
     * @var mixed
     */
    public mixed $repository;

    /**
     *
     * @var mixed
     */
    public mixed $responseHelper;

    /**
     *
     * @var mixed
     */
    public mixed $redis;

    /**
     * Construct
     *
     */
    public function __construct(
        UserRepository $repository,
        ResponseHelper $responseHelper,
        RedisCommonService $redisCommonService
    )
    {
        $this->repository = $repository;
        $this->responseHelper = $responseHelper;
        $this->redis = $redisCommonService;
        $this->userService = app('UserService');
        $this->authService = app('AuthService');

        $this->middleware('guest')->except('logout');
    }
}
