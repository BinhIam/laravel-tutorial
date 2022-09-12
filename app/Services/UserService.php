<?php namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserService
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
     * @description Find all user
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @description  Create new user
     *
     * @param $request
     * @return JsonResponse
     * @var Model
     */
    public function create($request): JsonResponse
    {
        if ($request->isMethod('post') && Auth('sanctum')->check()) {
            $user = $this->userRepository->createUser([
                'name' => $request->get('name'),
                'age' => $request->get('age'),
                'class_id' => $request->get('class_id'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]);
            if (!$user->exists) {
                return $this->responseHelper->responseFail();
            }
        }
        return $this->responseHelper->responseSuccess();
    }

    /**
     * @description Register new user
     *
     * @param $request
     * @return Model
     * @var Model
     */
    public function register($request): Model
    {
        return $this->userRepository->register([
            'name'=> $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
    }

    /**
     * @description Update old user
     *
     * @param $id
     * @param $request
     * @return JsonResponse
     */
    public function update($id, $request): JsonResponse
    {
        if ($request->isMethod('put') && Auth('sanctum')->check() && $id) {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return $this->responseHelper->responseNotFound();
            } else {
                $userUpdate = $this->userRepository->updateUser($id,
                    [
                        'name' => $request->get('name'),
                        'age' => $request->get('age'),
                        'class_id' => $request->get('class_id'),
                        'email' => $request->get('email'),
                    ]
                );
                if (!$userUpdate) {
                    return $this->responseHelper->responseFail();
                }
            }
        }
        return $this->responseHelper->responseSuccess();
    }

    /**
     * @description Update old user
     *
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete($id): JsonResponse
    {
        if (Auth('sanctum')->check() && $id) {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return $this->responseHelper->responseNotFound();
            }
            $this->userRepository->deleteId($id);
        }
        return $this->responseHelper->responseSuccess();
    }

    /**
     * @description Show information of user
     *
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function show($id): JsonResponse
    {
        $user = [];
        if (Auth('sanctum')->check() && $id) {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return $this->responseHelper->responseNotFound();
            }
        }
        return $this->responseHelper->responseSuccess($user);
    }

    /**
     * Search user by text
     *
     * @param $text
     * @return Model
     */
    public function searchFullText($text): Model
    {
        return $this->userRepository->searchFullTextUser($text);
    }
}

