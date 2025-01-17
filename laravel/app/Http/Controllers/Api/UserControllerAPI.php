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

    /**
     * @OA\Get(
     *     path="/",
     *     operationId="createUser",
     *     tags={"Users"},
     *     summary="Tạo người dùng mới",
     *     description="API này cho phép tạo người dùng mới.",
     *     @OA\Response(
     *         response=200,
     *         description="Thông tin người dùng mới",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 type="array",
     *                 @OA\Items(ref="./components/schemas/User")
     *             )
     *         )
     *     )
     * )
    */
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

    /**
     * @OA\Get(
     *     path="/users/update",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     summary="Cập nhật thông tin người dùng",
     *     description="API này cho phép cập nhật thông tin người dùng.",
     *     @OA\Response(
     *         response=200,
     *         description="Thông tin người dùng mới cập nhật",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 type="array",
     *                 @OA\Items(ref="./components/schemas/User")
     *             )
     *         )
     *     )
     * )
    */
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

    /**
     * @OA\Delete(
     *     path="/users/delete",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     summary="Xóa người dùng theo id",
     *     description="API này cho phép xóa người dùng theo id.",
     *     @OA\Response(
     *         response=200,
     *         description="Thông báo xóa người dùng thành công",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 type="array",
     *                 @OA\Items(ref="./components/schemas/User")
     *             )
     *         )
     *     )
     * )
    */
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

    /**
     * @OA\Get(
     *     path="/users/search",
     *     operationId="searchUsers",
     *     tags={"Users"},
     *     summary="Tìm kiếm người dùng theo từ khóa",
     *     description="API này cho phép tìm kiếm người dùng theo từ khóa trong tên hoặc email.",
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         required=false,
     *         description="Từ khóa tìm kiếm người dùng",
     *         @OA\Schema(
     *             type="string",
     *             example="John"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách người dùng tìm thấy",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 type="array",
     *                 @OA\Items(ref="./components/schemas/User")
     *             )
     *         )
     *     )
     * )
    */
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