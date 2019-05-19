<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserGetByRole;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function getUsersByRoles(UserGetByRole $request)
    {
        $role = $request->get('role');
        $users = User::where($role, true)->get();

        return response()->json($users);
    }
}
