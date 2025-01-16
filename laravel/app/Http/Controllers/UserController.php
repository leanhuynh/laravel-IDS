<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Request\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Exception;

class UserController extends Controller
{
    protected UserService $_userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        // $this->middleware('auth');
        $this->_userService = $userService;
    }

    // Show all users
    public function index()
    {
        try {
            $users = $this->_userService->getAll();
            return view('users.index', compact('users'));
        } catch (Exception $e) {
            log::error($e->getMessage());
            view('home');
        }
    }

    public function searchByKeyword(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $users = $this->_userService->searchByKeyword($keyword);
            return response()->json(['users' => $users]);
        } catch (Exception $e) {
            log::error($e->getMessage());
            return response()->json([
                'message' -> $e->getMessage(),
            ], 500);
        }
    }
}