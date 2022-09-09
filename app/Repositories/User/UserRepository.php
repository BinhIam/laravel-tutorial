<?php

namespace App\Repositories\User;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Classes UserRepository.
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
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
    public function createUser($request): Model
    {
        return $this->create($request);
    }

    /**
     * @description Register new user
     * @param array $request
     * @return Model
     */
    public function register($request): Model
    {
        return $this->create($request);
    }

    /**
     * @description Update user instant
     * @param $id
     * @param array $array
     * @param array $option
     * @return Collection|Model
     */
    public function updateUser($id, array $array, $option = []): Model|Collection
    {
        return $this->updateById($id, $array);
    }

    /**
     * @description Find all user instant
     * @return array
     */
    public function findAll(): array
    {
        return $this->all()->toArray();
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
     * @param $id
     * @return Collection|Model
     */
    public function findById($id): Model|Collection
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

    /**
     * @description Find by column
     * @param $value
     * @return Model|UserRepository|null
     */
    public function findByEmail($value): Model|UserRepository|null
    {
        return $this->getByColumn($value, 'email');
    }

}
