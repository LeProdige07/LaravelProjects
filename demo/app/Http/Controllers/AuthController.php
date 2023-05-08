<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password'=> 'required|string|confirmed'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password'=> 'required|string'
        ]);
        $input = $request->all();

//  Check email
        $user = User::where('email', $input['email'] )->first();

        // Check password
        if(!$user || !Hash::check($input['password'], $user->password)){
            return response([
                'message' => 'bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'logged out'
        ];
    }
}
