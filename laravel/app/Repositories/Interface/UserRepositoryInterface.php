<?php

namespace App\Repositories\Interface;
use Illuminate\Http\Request;

interface UserRepositoryInterface 
{
    public function getAll();

    public function findUserById($id);

    public function createUser(Request $request);

    public function updateUser(Request $request, $id);

    public function deleteUser($id);
}