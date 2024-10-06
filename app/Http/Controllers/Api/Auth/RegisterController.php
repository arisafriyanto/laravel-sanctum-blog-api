<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(UserRequest $request)
    {
        $attr = $request->all();
        $attr['password'] = bcrypt($request->password);

        $user = User::create($attr);

        return response()->json([
            'status' => true,
            'data' => $user,
            'message' => 'Register success'
        ], 201);
    }
}
