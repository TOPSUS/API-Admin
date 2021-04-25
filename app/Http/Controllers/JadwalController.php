<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Jadwal;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = array();
        $jadwals = Jadwal::all();

        if (count($jadwals) > 0) {
            foreach ($jadwals as $jadwal) {
                array_push($data, [
                    'id' => $jadwal->id,
                    'waktu_berangkat' => $jadwal->waktu_berangkat,
                    'waktu_sampai' => $jadwal->waktu_sampai,
                    'harga' => $jadwal->harga,
                    'asal' => $jadwal->pelabuhanasal->nama_pelabuhan,
                    'tujuan' => $jadwal->pelabuhantujuan->nama_pelabuhan,
                    'speedboat' => $jadwal->speedboat->nama_speedboat
                ]);
            }

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data index fetched'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'failed to fetch data index'
        ]);
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
        $data = array();
        $jadwal = Jadwal::find($id);

        if (isset($jadwal)) {
            array_push($data, [
                'id' => $jadwal->id,
                'waktu_berangkat' => $jadwal->waktu_berangkat,
                'waktu_sampai' => $jadwal->waktu_sampai,
                'harga' => $jadwal->harga,
                'asal' => $jadwal->id_asal_pelabuhan,
                'tujuan' => $jadwal->id_tujuan_pelabuhan,
                'speedboat' => $jadwal->id_speedboat
            ]);

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data jadwal fetched'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'failed to fetch data jadwal'
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
            'waktu_berangkat' => 'required',
            'waktu_sampai' => 'required',
            'id_asal_pelabuhan' => 'required',
            'id_tujuan_pelabuhan' => 'required',
            'id_speedboat' => 'required',
            'harga' => 'required'
        ]);

        
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'data' => $data,
                'message' => $validator->errors()
            ]);
        }

        $jadwal = Jadwal::find($id);

        if (isset($jadwal)) {
            $jadwal->waktu_berangkat = $request->waktu_berangkat;
            $jadwal->waktu_sampai = $request->waktu_sampai;
            $jadwal->id_asal_pelabuhan = $request->id_asal_pelabuhan;
            $jadwal->id_tujuan_pelabuhan = $request->id_tujuan_pelabuhan;
            $jadwal->id_speedboat = $request->id_speedboat;
            $jadwal->harga = $request->harga;

            if ($jadwal->save()) {
                return response([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'Successfully Update Jadwal'
                ]);
            }
   
            return response([
                'status' => 500,
                'data' => $data,
                'message' => 'Failed Update Jadwal'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Jadwal not Found'
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
