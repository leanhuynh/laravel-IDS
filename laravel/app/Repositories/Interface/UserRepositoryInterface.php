<?php

namespace App\Repositories\Interface;
use App\Http\Request\UserRequest;

interface UserRepositoryInterface 
{
    public function getAll();

    public function findUserById($id);

    public function createUser(UserRequest $request);

    public function updateUser(UserRequest $request, $id);

    public function deleteUser($id);
}