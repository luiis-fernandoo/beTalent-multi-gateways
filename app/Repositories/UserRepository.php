<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function createUser($data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
        ]);
    }

    public function updateUser($data, $userId)
    {
        User::where('id', $userId)->update($data);

        return User::find($userId);
    }

    public function destroyUser($userId)
    {
        return User::find($userId)->delete();
    }
}
