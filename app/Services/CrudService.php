<?php namespace App\Services;

use App\Repositories\Classes\ClassRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CrudService
{
    /**
     * The user repository.
     *
     * @var Model
     */
    public $userRepository;

    /**
     * The class repository.
     *
     * @var Model
     */
    public $classRepository;

    public function __construct(
        UserRepository $userRepository,
        ClassRepository $classRepository
    ){
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
    }

    /**
     * @description Find all user
     * @return array
     */
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @description  Create new user
     * @param $request
     * @return Model
     * @var Model
     */
    public function create($request): Model
    {
        return $this->userRepository->createUser([
            'name' => $request->get('name'),
            'age' => $request->get('age'),
            'class_id' => $request->get('class_id'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
    }

    /**
     * @description Register new user
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
     * @param $id
     * @param $request
     * @return Model
     */
    public function update($id, $request): Model
    {
        return $this->userRepository->updateUser($id,
            [
                'name' => $request->get('name'),
                'age' => $request->get('age'),
                'class_id' => $request->get('class_id'),
                'email' => $request->get('email'),
            ]
        );
    }
}
