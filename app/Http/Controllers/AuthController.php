<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangePass;
use Validator;
use Illuminate\Support\Str;

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

    public function getCodes(Request $request){
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response([
                'status' => 404,
                'message' =>'Email Not Found',
            ]);
        }
        $code = Str::random(5);
        $user->kode_verifikasi_email = $code;
        $user->update();

        Mail::to($user->email)->send(new ChangePass($user));
        return response([
            'status' => 200,
            'message' => 'Please Check Your Email',
        ]);
    }

    public function cekCodes(Request $request){
        $user = User::where('kode_verifikasi_email', $request->kode)->first();
        if(!$user){
            return response([
                'status' => 404,
                'message' =>'Kode yang Anda Masukan Salah',
            ]);
        }
        $data['user'] = [
            'email' => $user->email,
        ];
        return response([
            'status' => 200,
            'message' => 'Silahkan Ganti Password Anda',
            'data' => $data,
        ]);
    }

    public function forgotPass(Request $request){
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->oldpass, $user->password)) {
            return response([
                'status' => 404,
                'message' => "User not Found"
            ]);
        }
        $user->password = Hash::make($request->newpass);
        $user->update();

        return response([
            'status' => 200,
            'message' => 'Password Berhasil Diganti',
        ]);

    }

    public function gantiPass(Request $request){
        $validator = Validator::make($request->all(), [
            'oldpass' => 'required',
            'newpass' => 'required|same:confirmpass',
            'confirmpass' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 500,
                'message' => $validator->errors()->first()
            ]);
        }
        $user = User::where('email',$request->email)->first();
        
        if (! $user || ! Hash::check($request->oldpass, $user->password)) {
            return response([
                'status' => 404,
                'message' => "User not Found"
            ]);
        }
        $password = Hash::make($request->newpass);
        $user->password = $password;
        $user->update();

        return response([
            'status'=>200,
            'message'=>"Berhasil Merubah Password"
        ]);
    }
}
