<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Request\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    protected UserService $_userService;

    public function __construct(UserService $userService) {
        $this->_userService = $userService;
    }

    // Show all users
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $users = $this->_userService->getAll($keyword);
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
        $this->_userService->createUser($request->validated());
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
        $this->_userService->updateUser($request->validated(), $id);
        return redirect()->route('users.index')->with("success", __('messages.user.update.success'));
    }

    // Delete user
    public function destroy($id)
    {
        $this->_userService->deleteUser($id);
        return response()->json(["message" =>  __('messages.user.delete.success'), "id" => $id]);
    }
}