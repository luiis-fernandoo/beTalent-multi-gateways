<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function store(UserRequest $request)
    {
        dd($request);
    }

    public function login(LoginRequest $request)
    {

    }
}
