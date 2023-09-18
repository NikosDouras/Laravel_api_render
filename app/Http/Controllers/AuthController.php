<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Auth;
use Hash;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request) //loging in
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('', 'Credentials do not match', 401);
        }
        
        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
        ]);

    }



    public function register(StoreUserRequest $request) //registering
    {
        
        $request->validated($request->all());

        $usertype = $request->input('usertype', 'regularuser');

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $usertype

        ]);


        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken

        ]);
    }



    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'You are logged out. Token deleted.'
        ]);
    }
}
