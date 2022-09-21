<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;

class BaseController extends Controller
{
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
     * Construct
     *
     */
    public function __construct(UserRepository $repository, ResponseHelper $responseHelper)
    {
        $this->repository = $repository;
        $this->responseHelper = $responseHelper;
        $this->userService = app('UserService');
        $this->authService = app('AuthService');
    }

    public function tryBlock($response)
    {
        try {
            return $response;
        } catch (\Exception $exception) {
            return $this->responseHelper->responseException($exception);
        }
    }

}
