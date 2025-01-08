<?php
namespace App\Services;
use Illuminate\Http\Request;

use App\Repositories\UserRepository;

class UserService {

    protected UserRepository $_userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->_userRepository = $userRepository;
    }

    public function getAll() {
        return $this->_userRepository->getAll();
    }

    public function createUser(Request $request) {
        return $this->_userRepository->createUser();
    }

    public function findUserById($id) {
        return $this->_userRepository->findUserById($id);
    }

    public function updateUser(Request $request, $id) {
        return $this->_userRepository->updateUser($request, $id);
    }

    public function deleteUser($id) {
        return $this->_userRepository->deleteUser($id);
    }
}