<?php

namespace App\Repositories\Interface;
use App\Http\Request\UserRequest;

interface UserRepositoryInterface 
{
    public function getAll();

    public function findUserById($id);

    public function createUser(array $data);

    public function updateUser(array $data, $id);

    public function deleteUser($id);
}