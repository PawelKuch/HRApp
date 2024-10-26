<?php
namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class UserService {
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser($name, $surname, $email, $password) : bool
    {
        $user = new User();
        $randomUserId = Str::uuid() ->toString();
        $user -> userId = $randomUserId;
        $user -> name = $name;
        $user -> surname = $surname;
        $user -> email = $email;
        $user -> password = $password;

        if($this -> userRepository -> saveUser($user)){
            return true;
        }
        return false;
    }

    public function updateUser(User $user, $data) : bool
    {
        if($this -> userRepository -> updateUser($user, $data)){
            return true;
        }
        return false;
    }

    public function getUsers() : Collection
    {
        try{
            return $this->userRepository -> getUsers();
        }catch (ModelNotFoundException $e){
            Log::error($e->getMessage());
            return collect();
        }
    }

    public function getUserByUserId($user_id) : User
    {
        try {
            return $this->userRepository -> getUserByUserId($user_id);
        } catch (ModelNotFoundException $e){
            Log::error($e->getMessage());
            return new User();
        }
    }

    public function blockUser($userId) : void {
        $user = $this->userRepository -> getUserByUserId($userId);
        if($user){
            $user -> is_blocked = true;
            $user -> save();
        }else {
            Log::warning("User Service: User not found: $userId");
        }

    }

    public function unblockUser($userId) : void
    {
        $user = $this -> userRepository -> getUserByUserId($userId);
        $user -> is_blocked = false;
        $user -> save();
    }

    public function changePassword($userId, $newPassword) : void
    {
        $user = $this->userRepository -> getUserByUserId($userId);
        $user -> password = Hash::make($newPassword);
        $user -> save();
    }

    public function changeEmail($userId, $newEmail) : void
    {
        $user = $this -> userRepository -> getUserByUserId($userId);
        $user -> email = $newEmail;
        $user -> save();
    }
}
