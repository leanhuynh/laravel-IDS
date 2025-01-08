<?php 
namespace App\Repositories;
use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface 
{
    protected $_model;

    // constructor
    public function __construct() {
        $this->_model = app()->make(\App\Models\User::class);
    }

    // implement interface function
    public function getAll() {
        $users = $this->_model::all();
        return $users;
    }

    public function findUserById($id) {
        $user = $this->_model::find($id);
        return $user;
    }

    public function createUser(Request $request) {
        $this->_model::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return $newUser;
    }

    public function updateUser(Request $request, $id) {
        $user = $this->_model::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return $user;
    }

    public function deleteUser($id) {
        $user = $this->_model::find($id);
        $user->delete();
    }
}