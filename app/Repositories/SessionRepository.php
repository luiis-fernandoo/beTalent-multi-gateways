<?php

namespace App\Repositories;

use App\Models\CustomSessions;
use Illuminate\Support\Facades\Auth;

class SessionRepository
{
    public function createSession($data)
    {
        return CustomSessions::create($data);
    }
}
