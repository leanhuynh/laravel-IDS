<?php 
namespace App\Repositories;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Http\Request\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface 
{
    protected $_model;

    // constructor
    public function __construct() {
        $this->_model = app()->make(\App\Models\User::class);
    }

    // implement interface function
    public function getAll($keyword) {
        $users = [];
        if (is_null($keyword) || $keyword === '')
            $users = $this->_model::simplePaginate(5);
        else 
            $users = $this->_model::simplePaginate(5);
        return $users;
    }

    public function findUserById($id) {
        $user = $this->_model::find($id);
        return $user;
    }

    public function createUser(array $data) {
        $newUser = $this->_model::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']) // mã hóa mật khẩu
        ]);
        return $newUser;
    }

    public function updateUser(array $data, $id) {
        $user = $this->_model::find($id);
        $user->name = $data['name'];
        $user->email = $data['email'];

        // mã hóa mật khẩu vừa tạo
        if ($data['password']) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        return $user;
    }

    public function deleteUser($id) {
        $user = $this->_model::find($id);
        $user->delete();
    }
}