<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthLoginRequest;
use App\Http\Requests\Api\Auth\AuthRegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\User;
use App\File;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $avatar = $request->avatar;
        if (!is_null($avatar) and array_key_exists('id', $avatar))
        {
            $user->avatar()->save(File::find($request->avatar['id']));
        }
        return UserResource::make($user->makeToken()->load('avatar'));
    }

    public function login(AuthLoginRequest $request)
    {
        $data = $request->only('email', 'password');
        if (!auth()->attempt($data))
        {
            $error = [
                ['message'=>'The given data was invalid.'],
                ['errors' => ['credentials' => 'incorrect credentials']]
            ];
            return response($error, 422);
        }
        $user = auth()->user();
        return UserResource::make($user->makeToken()->load('avatar'));
    }
}
