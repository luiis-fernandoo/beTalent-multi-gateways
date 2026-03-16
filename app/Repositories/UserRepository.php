<?php

namespace App\Repositories;

use App\Models\CustomSessions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function createUser($data)
    {
        return User::create($data);
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
