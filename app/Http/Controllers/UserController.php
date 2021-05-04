<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $user = User::find($id);

        if (isset($user)) {
            $data['user'] = [
                'id' => $user->id,
                'foto' => $user->foto,
                'nama' => $user->nama,
                'alamat' => $user->alamat,
                'jeniskelamin' => $user->jeniskelamin,
                'nohp' => $user->nohp,
                'email' => $user->email,
                'role' => $user->role
            ];

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data user fetched'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'user not found'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        if (isset($user)) {
            $user->nama = $request->nama;
            $user->alamat = $request->alamat;
            $user->jeniskelamin = $request->jeniskelamin;
            $user->nohp = $request->nohp;
            $user->email = $request->email;
            
            if ($request->hasFile('foto')) {
                $fotoUser = $request->file('foto');
                
                $fotoName = time().'.'.$fotoUser->getClientOriginalExtension();
    
                /*After Resize Add this Code to Upload Image*/
                    $destinationPath = public_path('user/images');
    
                $fotoUser->move($destinationPath, $fotoName);
                
                $user->foto = $fotoName;
            }
            
            if ($user->save()) {
                return response([
                    'status' => 200,
                    'message' => 'Profile Updated'
                ]);
            }
            
            return response([
                'status' => 500,
                'message' => 'Profile Failed to Update'
            ]);
        }
            
        return response([
            'status' => 404,
            'message' => 'User not found'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
