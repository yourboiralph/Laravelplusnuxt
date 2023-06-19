<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SaveUserRequest;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::latest()->paginate(10);
        return $users;
    }

    public function getUser($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function saveUser(SaveUserRequest $request)
    {
        $payload = (object) $request->only([
            'name',
            'course',
            'password',
            'email',
            'is_active',
        ]);

        $user = new User;
        $user->name = $payload->name;
        $user->course = $payload->course;
        $user->password = Hash::make($payload->password);
        $user->email = $payload->email;
        $user->is_active = $payload->is_active;
        $user->save();
        return $user;
    }

    public function updateUser($id, UpdateUserRequest $request)
    {
        $payload = (object) $request->only([
            'name',
            'course',
            'password',
            'email',
            'is_active'
        ]);

        $user = User::find($id);
        $user->name = $payload->name;
        $user->course = $payload->course;
        $user->password = Hash::make($payload->password);
        $user->email = $payload->email;
        $user->is_active = $payload->is_active;
        $user->save();
        return $user;
    }
    
}