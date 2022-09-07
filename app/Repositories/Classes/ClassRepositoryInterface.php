<?php

namespace App\Repositories\Classes;

/**
 * Classes UserRepositoryInterface.
 */

interface ClassRepositoryInterface
{
    /** Here you add common functions for all repositories */

    public function createClass($request);
    public function updateClass($id, array $array, $option = []);
    public function findAll();
    public function countAll();
    public function findById($id);
    public function deleteId($id);
}
