<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function getAllUsers() : Collection
    {
        if($users = User::all()){
            return $users;
        }
        throw new ModelNotFoundException("getUsers: No users found");
    }

    public function getUserById($id) : User
    {
        if($user = User::find($id)){
            return $user;
        }
        throw new ModelNotFoundException("No user found");
    }

    public function getUserByUserId($userId) : User
    {
       $user = User::where('userId', $userId) -> first();
        if($user){
            return $user;
        }
            throw new ModelNotFoundException("No user found");
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
        if($user -> update($data)){
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
