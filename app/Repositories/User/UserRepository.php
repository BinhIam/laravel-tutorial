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
     * Return the model
     *
     * @return string
     */
    public function model(): string
    {
        return $this->model = User::class;
    }

    /**
     * Create user instant
     *
     * @param array $request
     * @return Model
     */
    public function createUser($request): Model
    {
        return $this->create($request);
    }

    /**
     * Register new user
     *
     * @param array $request
     * @return Model
     */
    public function register($request): Model
    {
        return $this->create($request);
    }

    /**
     * Update user instant
     *
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
     * Find all user instant
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->all()->toArray();
    }

    /**
     * Count all user instant
     *
     * @return int
     */
    public function countAll(): int
    {
        return $this->count();
    }

    /**
     * Count all user instant
     *
     * @param $id
     * @return Collection|Model
     */
    public function findById($id): Model|Collection
    {
        return $this->getById($id);
    }

    /**
     * Delete user instant
     *
     * @param int $id
     * @return bool|null
     * @throws Exception
     */
    public function deleteId($id): ?bool
    {
        return $this->deleteById($id);
    }

    /**
     * Find by column
     *
     * @param $value
     * @return Model|UserRepository|null
     */
    public function findByEmail($value): Model|UserRepository|null
    {
        return $this->getByColumn($value, 'email');
    }

    /**
     * Search full text
     *
     * @param $str
     * @return Collection
     */
    public function searchFullTextUser($str): Collection
    {
        return User::search($str)->get();
    }

    /**
     * Send mail to user by command
     *
     * @param $str
     * @return
     */
    public function mailToUserCommand($str)
    {
        return $this->getByColumn($str, 'email');
    }


}
