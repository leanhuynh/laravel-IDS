<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

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