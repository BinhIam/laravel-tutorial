<?php

namespace App\Repositories\User;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return $this->model = User::class;
    }

    /**
     * @param array $array
     * @return string
     * @description Create user instant
     */
    public function createUser(array $array)
    {
        return $this->model()::create($array);
    }

    /**
     * @param $request
     * @return string
     * @description Register new user
     */
    public function register($request)
    {
        return $this->model()::create([
            'name'=> $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
    }

    /**
     * @param $id
     * @param array $array
     * @param array $option
     * @return Collection|Model
     * @description Update user instant
     */
    public function updateUser($id, array $array, $option = [])
    {
        return $this->updateById($id, $array);
    }

    /**
     * @return array
     *  Find all user instant
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * @return int
     * @description Count all user instant
     */
    public function countAll()
    {
        return $this->count();
    }

    /**
     * @return Collection|Model
     * @description Count all user instant
     */
    public function findById($id)
    {
        return $this->getById($id);
    }

    /**
     * @return bool|null
     * @description Delete user instant
     * @throws Exception
     */
    public function deleteId($id)
    {
        return $this->deleteById($id);
    }

    /**
     * @return string
     * @description Find by column
     */
    public function findByEmail($value)
    {
        return $this->getByColumn($value, 'email');
    }

}
