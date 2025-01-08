<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Request\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $_userService;

    public function __construct(UserService $userService) {
        $this->_userService = $userService;
    }

    // Show all users
    public function index()
    {
        $users = $this->_userService->getAll();
        return view('users.index', compact('users'));
    }

    // Show form to create new user
    public function create()
    {
        return view('users.create');
    }

    // Store new user
    public function store(UserRequest $request)
    {
        $this->_userService->createUser($request);
        return redirect()->route('users.index');
    }

    // Show form to edit user
    public function edit($id)
    {
        $user = $this->_userService->findUserById($id);
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(UserRequest $request, $id)
    {
        $this->_userService->updateUser($request, $id);
        return redirect()->route('users.index');
    }

    // Delete user
    public function destroy($id)
    {
        $this->_userService->deleteUser($id);
        return redirect()->route('users.index');
    }
}