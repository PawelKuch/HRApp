<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository {

    public function saveUser($user) : bool
    {
        if($user -> save()){
            return true;
        }
        return false;
    }

    public function getUsers() : Collection
    {
        return User::all();
    }

    public function getUserById($id) : object
    {
        return User::find($id);
    }

    public function getUserByUserId($userId) : User
    {
        return User::where('user_id', $userId) -> first();
    }

    public function getUserByEmail($email) : User
    {
        return User::where('email', $email)->first();
    }

    public function getUsersByName($name) : Collection
    {
        return User::where('name', $name) -> get();
    }

    public function deleteUserByUserId($userId) : bool
    {
        $user = User::where('user_id', $userId) -> first();
        if($user::delete()){
            return true;
        }
        return false;
    }

    public function updateUser($user, $data) : bool
    {
        if($user::update($data)){
            return true;
        }
        return false;
    }

    public function deleteAllUsers() : bool
    {
        if(DB::table('users') -> delete()){
            return true;
        }
        return false;
    }
}
