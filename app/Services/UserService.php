<?php
namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
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

    public function getUsers() : Collection
    {
        return $this->userRepository -> getUsers();
    }
}
