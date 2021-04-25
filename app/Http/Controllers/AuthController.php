<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;

class AuthController extends Controller
{
    //
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $data = array();
    
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'status' => 404,
                'message' => "User not Found"
            ]);
        }
        
        $user->token_login = $user->createToken('token')->plainTextToken;
        $user->save();

        $data['auth'] = [
            'token' => $user->token_login,
            'user' => $user
        ];

        return response([
            'status' => 200,
            'message' => 'User Found & Match',
            'data' => $data
        ]);
    }

    public function logout(Request $request){
        $user = User::where('token_login', $request->token)->first();

        if(isset($user)){
            $user->token_login = "Logged Out";
            $user->save();

            return response([
                'status' => 200,
                'message' => $user->token_login,
            ]);
        }

        return response([
            'status' => 404,
            'message' =>'user not found',
        ]);
    }
}
