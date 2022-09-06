<?php

namespace App\Repositories\User;

/**
 * Class UserRepositoryInterface.
 */

interface UserRepositoryInterface
{
    /** Here you add common functions for all repositories */

    public function createUser(array $array);
    public function updateUser($id, array $array, $option = []);
    public function findAll();
    public function countAll();
    public function findById($id);
    public function deleteId($id);
    public function register($array);
}
