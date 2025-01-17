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

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API Documentation",
 *     description="Tài liệu API"
 * )
 */
class UserController extends Controller
{
    protected UserService $_userService;

    public function __construct(UserService $userService)
    {
        // $this->middleware('auth');
        $this->_userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/users",
     *     operationId="getUsers",
     *     tags={"Users"},
     *     summary="Lấy danh sách người dùng",
     *     description="Trả về danh sách người dùng",
     *     @OA\Response(
     *         response=200,
     *         description="View với danh sách người dùng",
     *         @OA\JsonContent(
     *             type="string",
     *             example="<html>...</html>"
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $users = $this->_userService->getAll();
            return view('users.index', compact('users'));
        } catch (Exception $e) {
            log::error($e->getMessage());
            return view('home');
        }
    }
}