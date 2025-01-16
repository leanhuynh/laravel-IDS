<?php

namespace App\Http\Controllers\Api;

use App\Common\StatusCode;
use App\Models\User;
use App\Http\Request\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Http\Controllers\Controller;

class UserControllerAPI extends Controller
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

    // Store new user
    public function store(UserRequest $request)
    {   
        try {
            $newUser = $this->_userService->createUser($request->validated());
            return response()->json(['status' => StatusCode::HTTP_STATUS_CREATED,'message' => __('messages.user.create.success'), 'user' => $newUser]);
        } catch(Exception $e) {
            log::error($e->getMessage());
            return response()->json([
                'message' -> $e->getMessage(),
            ], ErrorCode::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    // Update user
    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->_userService->updateUser($request->validated(), $id);
            return response()->json(['status' => StatusCode::HTTP_STATUS_ACCEPTED,'message' => __('messages.user.update.success'), 'user' => $user]);
        } catch (Exception $e) {
            log::error($e->getMessage());
            return response()->json([
                'message' -> $e->getMessage(),
            ], ErrorCode::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    // Delete user
    public function destroy($id)
    {
        try {
            $this->_userService->deleteUser($id);
            return response()->json(['status' => StatusCode::HTTP_STATUS_OK, 'message' =>  __('messages.user.delete.success'), 'id' => $id]);
        } catch (Exception $e) {
            log::error($e->getMessage());
            return response()->json([
                'message' -> $e->getMessage(),
            ], StatusCode::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    // tìm kiếm người dùng theo keyword
    public function searchByKeyword(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $users = $this->_userService->searchByKeyword($keyword);
            return response()->json(['status' => StatusCode::HTTP_STATUS_OK,'users' => $users]);
        } catch (Exception $e) {
            log::error($e->getMessage());
            return response()->json([
                'message' -> $e->getMessage(),
            ], StatusCode::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}