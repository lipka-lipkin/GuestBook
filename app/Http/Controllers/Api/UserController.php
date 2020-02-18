<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return UserResource|ResponseFactory|Response
     */
    public function self(Request $request)
    {
        $user = $request->user();
        return UserResource::make($user->load('avatar'));
    }
}
