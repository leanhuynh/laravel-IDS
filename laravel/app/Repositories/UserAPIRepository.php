<?php 
namespace App\Repositories;
// use App\Repositories\Interface\UserAPIRepositoryInterface;
// use App\Http\Request\UserRequest;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\DB;
// use App\Common\Constant;
// use App\Models\role;
// use Exception;

// class UserAPIRepository implements UserAPIRepositoryInterface 
// {
//     protected $_model;

//     // constructor
//     public function __construct() {
//         $this->_model = app()->make(\App\Models\User::class);
//     }

//     // implement interface function
//     public function getAll() {
//         $users = $this->_model::simplePaginate(Constant::PAGINATE_DEFAULT);
//         return $users;
//     }

//     public function findUserById($id) {
//         $user = $this->_model::find($id);
//         return $user;
//     }

//     public function createUser(array $data) {
//         $imagePath = "";
//         if (isset($data['avatar']) && !empty($data['avatar'])) {
//             $image = $data['avatar'];
//             $imagePath = $image->store('/images', 'public');
//         }

//         $role_id = (!isset($data['role_id']) || empty(['role_id'])) ? $data['role_id'] : Constant::DEFAULT_USER_ROLE;

//         $newUser = $this->_model::create([
//             'avatar' => $imagePath,
//             'name' => $data['name'],
//             'email' => $data['email'],
//             'password' => Hash::make($data['password']), // mã hóa mật khẩu
//             'role_id' => $role_id
//         ]);

//         return $newUser;
//     }

//     public function updateUser(array $data, $id) {
//         try {
//             $user = $this->_model::find($id);

//             // lưu file avatar
//             $imagePath = $user->avatar;
//             if (isset($data['avatar']) && $data['avatar']) {
//                 $image = $data['avatar'];
//                 $imagePath = $image->store('/images', 'public');
//             }

//             $role_id = $user->role_id;
//             if (isset($data['role_id']) && !empty($data['role_id'])) {
//                 $role_id = $data['role_id'];
//             }

//             $user->avatar = $imagePath;
//             $user->name = $data['name'];
//             $user->email = $data['email'];
//             $user->role_id = $role_id;

//             // mã hóa mật khẩu vừa tạo
//             if ($data['password']) {
//                 $user->password = Hash::make($data['password']);
//             }
//             $user->save();
//             return $user;
//         } catch (Exception $e) {
//             throw new Exception(__('exceptions.database.update'));
//         }
//     }

//     public function deleteUser($id) {
//         $user = $this->_model::find($id);
//         $user->delete();
//     }

//     public function searchByKeyword($keyword) {
//         $users = [];
//         if (is_null($keyword) || $keyword === '')
//             $users = $this->_model->get();
//         else 
//             $users = $this->_model::where('name', 'LIKE', '%' . $keyword . '%')
//                         ->orWhere('email', 'LIKE', '%' . $keyword . '%')->get();
                        
//         return $users;
//     }
// }