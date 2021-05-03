<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Jadwal;

use Auth;

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
        $idKapals = array();
        $hakAksesKapal = Auth::user()->hakAksesKapal;

        foreach ($hakAksesKapal as $hakAkses) {
            array_push($idKapals, $hakAkses->id_kapal);
        }

        $data = array();
        $jadwals = Jadwal::whereIn('id_kapal', $idKapals)->get();
        
        $temp = array();
        foreach ($jadwals as $jadwal) {
            array_push($temp, [
                'id' => $jadwal->id,
                'nama_kapal' => $jadwal->kapal->nama_kapal,
                'tanggal' => $jadwal->tanggal,
                'waktu' => $jadwal->waktu_berangkat,
                'estimasi_waktu' => $jadwal->estimasi_waktu,
                'nama_tujuan' => $jadwal->pelabuhantujuan->nama_pelabuhan,
                'nama_asal' => $jadwal->pelabuhanasal->nama_pelabuhan,
                'kode_tujuan' => $jadwal->pelabuhantujuan->kode_pelabuhan,
                'kode_asal' => $jadwal->pelabuhanasal->kode_pelabuhan,
                'harga' => $jadwal->harga
            ]);
        }

        $data['list_jadwal'] = $temp;

        return response([
            'status' => 200,
            'data' => $data,
            'message' => 'data index fetched'
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
        $validator = Validator::make($request->all(), [
            'kapal' => 'required',
            'asal' => 'required',
            'tujuan' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'estimasi' => 'required',
            'harga' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 500,
                'message' => 'Validator Fail'
            ]);
        }

        $create = new Jadwal;
        $create->waktu_berangkat = $request->waktu;
        $create->id_asal_pelabuhan = $request->asal;
        $create->id_tujuan_pelabuhan = $request->tujuan;
        $create->estimasi_waktu = $request->estimasi;
        $create->id_kapal = $request->kapal;
        $create->tanggal = $request->tanggal;
        $create->harga = $request->harga;
        if ($create->save()) {
            return response([
                'status' => 200,
                'message' => 'success create jadwal'
            ]);
        } else {
            return response([
                'status' => 500,
                'message' => 'failed create jadwal'
            ]);
        }
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
                'harga' => $jadwal->harga,
                'asal' => $jadwal->id_asal_pelabuhan,
                'tujuan' => $jadwal->id_tujuan_pelabuhan,
                'estimasi' => $jadwal->estimasi_waktu,
                'id_kapal' => $jadwal->id_kapal,
                'tanggal' => $jadwal->tanggal
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
        $jadwal = Jadwal::find($id);

        if (isset($jadwal)) {
            if ($jadwal->delete()) {
                return response([
                    'status' => 200,
                    'message' => 'Success Delete jadwal'
                ]);
            }

            return response([
                'status' => 500,
                'message' => 'Failed Delete jadwal'
            ]);
        }

        return response([
            'status' => 404,
            'message' => 'jadwal not Found'
        ]);
    }
}
