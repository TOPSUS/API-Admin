<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\BeritaSpeedboat;
use App\User;

class BeritaSpeedboatController extends Controller
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
        $data = array();
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'berita' => 'required',
            'tanggal' => 'required',
            'foto' => 'required'
        ]);

        
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'data' => $data,
                'message' => $validator->errors()
            ]);
        }

        $user = User::find($request->id_user);

        if (!isset($user)) {
            return response([
                'status' => 404,
                'data' => $data,
                'message' => 'User not Found'
            ]);
        }

        $berita = new BeritaSpeedboat;

        if (isset($berita)) {
            $berita->id_user = $user->id;
            $berita->id_speedboat = $user->id_speedboat;
            $berita->berita = $request->berita;
            $berita->tanggal = $request->tanggal;
            $berita->foto = $request->foto;

            if ($berita->save()) {
                return response([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'Successfully Create Berita'
                ]);
            }
   
            return response([
                'status' => 500,
                'data' => $data,
                'message' => 'Failed Create Berita'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Berita not Found'
        ]);
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
        $data = array();
        $berita = BeritaSpeedboat::find($id);

        if (isset($berita)) {
            array_push($data, [
                'id' => $berita->id,
                'username' => $berita->user->nama,
                'berita' => $berita->berita,
                'tanggal' => $berita->tanggal,
                'foto' => $berita->foto
            ]);

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data berita fetched'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Data Berita not Found'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = array();
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'berita' => 'required',
            'tanggal' => 'required',
            'foto' => 'required'
        ]);

        
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'data' => $data,
                'message' => $validator->errors()
            ]);
        }

        $user = User::find($request->id_user);

        if (!isset($user)) {
            return response([
                'status' => 404,
                'data' => $data,
                'message' => 'User not Found'
            ]);
        }

        $berita = BeritaSpeedboat::find($id);

        if (isset($berita)) {
            $berita->id_user = $user->id;
            $berita->id_speedboat = $user->id_speedboat;
            $berita->berita = $request->berita;
            $berita->tanggal = $request->tanggal;
            $berita->foto = $request->foto;

            if ($berita->save()) {
                return response([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'Successfully Update Berita'
                ]);
            }
   
            return response([
                'status' => 500,
                'data' => $data,
                'message' => 'Failed Update Berita'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Berita not Found'
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
        $data = array();
        $berita = BeritaSpeedboat::find($id);

        if (isset($berita)) {
            if ($berita->delete()) {
                return response([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'data berita deleted'
                ]);
            }

            return response([
                'status' => 500,
                'data' => $data,
                'message' => 'failed to delete data berita'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'data berita not found'
        ]);
    }

    public function indexSpeedboat($id) {
        
        $data = array();
        $beritas = BeritaSpeedboat::where('id_speedboat', $id)->get();

        if (count($beritas) > 0) {
            foreach($beritas as $berita) {
                array_push($data, [
                    'id' => $berita->id,
                    'username' => $berita->user->nama,
                    'berita' => $berita->berita,
                    'tanggal' => $berita->tanggal,
                    'foto' => $berita->foto
                ]);
            }
    
            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data fetched'
            ]);
        }
    
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'berita data not found'
        ]);
    }
}
