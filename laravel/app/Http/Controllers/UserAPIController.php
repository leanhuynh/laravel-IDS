<?php

namespace App\Http\Controllers;

// use App\Models\User;
// use App\Http\Request\UserRequest;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use App\Services\UserAPIService;
// use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\Log;
// use Exception;

// class UserAPIController extends Controller
// {
//     protected UserAPIService $_userService;

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct(UserAPIService $userService)
//     {
//         $this->middleware('auth');
//         $this->_userService = $userService;
//     }

//     // Show all users
//     public function index()
//     {
//         try {
//             $users = $this->_userService->getAll();
//             return view('users.index', compact('users'));
//         } catch (Exception $e) {
//             log::error($e->getMessage());
//             return response()->json([
//                 'message' => $e->getMessage(),
//             ], 500);
//         }
//     }

//     // Show form to create new user
//     public function create()
//     {
//         try {
//             return view('users.create');
//         } catch (Exception $e) {
//             log::error($e->getMessage());
//             return response()->json([
//                 'message' -> $e->getMessage(),
//             ], 500);
//         }
//     }

//     // Store new user
//     public function store(UserRequest $request)
//     {   
//         try {
//             $newUser = $this->_userService->createUser($request->validated());
//             return response()->json(['message' => __('messages.user.create.success'), 'user' => $newUser]);
//         } catch(Exception $e) {
//             log::error($e->getMessage());
//             return response()->json([
//                 'message' -> $e->getMessage(),
//             ], 500);
//         }
//     }

//     // Show form to edit user
//     public function edit($id)
//     {
//         try {
//             $user = $this->_userService->findUserById($id);
//             return view('users.edit', compact('user'));
//         } catch (Exception $e) {
//             log::error($e->getMessage());
//             return response()->json([
//                 'message' -> $e->getMessage(),
//             ], 500);
//         }
//     }

//     // Update user
//     public function update(UserRequest $request, $id)
//     {
//         try {
//             $user = $this->_userService->updateUser($request->validated(), $id);
//             return response()->json(['message' => __('messages.user.update.success'), 'user' => $user]);
//         } catch (Exception $e) {
//             log::error($e->getMessage());
//             return response()->json([
//                 'message' -> $e->getMessage(),
//             ], 500);
//         }
//     }

//     // Delete user
//     public function destroy($id)
//     {
//         try {
//             $this->_userService->deleteUser($id);
//             return response()->json(['message' =>  __('messages.user.delete.success'), 'id' => $id]);
//         } catch (Exception $e) {
//             log::error($e->getMessage());
//             return response()->json([
//                 'message' -> $e->getMessage(),
//             ], 500);
//         }
//     }

//     public function searchByKeyword(Request $request)
//     {
//         try {
//             $keyword = $request->input('keyword');
//             $users = $this->_userService->searchByKeyword($keyword);
//             return response()->json(['users' => $users]);
//         } catch (Exception $e) {
//             log::error($e->getMessage());
//             return response()->json([
//                 'message' -> $e->getMessage(),
//             ], 500);
//         }
//     }
// }