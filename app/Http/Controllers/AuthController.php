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
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'status' => 404,
                'message' => "User not Found"
            ]);
        }

        return response([
            'token'=>$user->createToken('token')->plainTextToken,
            'status'=>'200',
            'message'=>'User Found & Match'
        ]);
    }
}
