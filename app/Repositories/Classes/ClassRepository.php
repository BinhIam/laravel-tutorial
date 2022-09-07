<?php

namespace App\Repositories\Classes;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Classes UserRepository.
 */
class ClassRepository extends BaseRepository implements ClassRepositoryInterface
{
    /**
     * @description Return the model
     * @return string
     */
    public function model(): string
    {
        return $this->model = User::class;
    }

    /**
     * @description Create user instant
     * @param array $request
     * @return Model
     */
    public function createClass($request): Model
    {
        return $this->create([
            'name' => $request->get('name'),
            'age' => $request->get('age'),
            'class' => $request->get('class_id'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
    }

    /**
     * @description Update user instant
     * @param $id
     * @param array $array
     * @param array $option
     * @return Collection|Model
     */
    public function updateClass($id, array $array, $option = [])
    {
        return $this->updateById($id, $array);
    }

    /**
     * @description Find all user instant
     * @return array
     */
    public function findAll(): array
    {
        return $this->all();
    }

    /**
     * @description Count all user instant
     * @return int
     */
    public function countAll(): int
    {
        return $this->count();
    }

    /**
     * @description Count all user instant
     * @return Collection|Model
     */
    public function findById($id)
    {
        return $this->getById($id);
    }

    /**
     * @description Delete user instant
     * @param int $id
     * @return bool|null
     * @throws Exception
     */
    public function deleteId($id): ?bool
    {
        return $this->deleteById($id);
    }

}
