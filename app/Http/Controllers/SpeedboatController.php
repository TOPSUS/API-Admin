<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Review;
use App\Kapal;
use App\BeritaSpeedboat;
use App\HakAksesKapal;

use Auth;

class SpeedboatController extends Controller
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
        $id_user = Auth::user()->id;
        $listKapal = HakAksesKapal::where('id_user', $id_user)->get();

        foreach ($listKapal as $list) {
            $kapal = Kapal::find($list->id_kapal);
            $temp = array();
            if (isset($kapal)) {
                array_push($temp, [
                    'id' => $kapal->id,
                    'nama' => $kapal->nama_kapal,
                    'kapasitas' => $kapal->kapasitas,
                    'tipe' => $kapal->tipe_kapal,
                    'foto' => $kapal->foto,
                    'golongan' => $kapal->detailGolongan->golongan
                ]);
            }
        }

        $data = [
            'kapal' => $temp
        ];

        return response([
            'status' => 200,
            'data' => $data,
            'message' => 'list data kapal fetched'
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
        $speedboat = Speedboat::find($id);

        if (isset($speedboat)) {
            array_push($data, [
                'id' => $speedboat->id,
                'nama' => $speedboat->nama_speedboat,
                'kapasitas' => $speedboat->kapasitas,
                'deskripsi' => $speedboat->deskripsi,
                'contact_service' => $speedboat->contact_service,
                'tanggal_beroperasi' => $speedboat->tanggal_beroperasi,
                'foto' => $speedboat->foto
            ]);

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data speedboat fetched'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'speedboat not found'
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
            'nama' => 'required',
            'kapasitas' => 'required',
            'deskripsi' => 'required',
            'contact_service' => 'required',
            'tanggal_beroperasi' => 'required',
            'foto' => 'required'
        ]);

        
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'data' => $data,
                'message' => $validator->errors()
            ]);
        }

        $speedboat = Speedboat::find($id);

        if (isset($speedboat)) {
            $speedboat->nama_speedboat = $request->nama;
            $speedboat->kapasitas = $request->kapasitas;
            $speedboat->deskripsi = $request->deskripsi;
            $speedboat->contact_service = $request->contact_service;
            $speedboat->tanggal_beroperasi = $request->tanggal_beroperasi;
            $speedboat->foto = $request->foto;

            if ($speedboat->save()) {
                return response([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'Successfully Update Speedboat'
                ]);
            }
   
            return response([
                'status' => 500,
                'data' => $data,
                'message' => 'Failed Update Speedboat'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Speedboat not Found'
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
        $kapal = Kapal::find($id);

        if (isset($kapal)) {
            if ($kapal->delete()) {
                return response([
                    'status' => 200,
                    'message' => 'Success Delete Kapal'
                ]);
            }

            return response([
                'status' => 500,
                'message' => 'Failed Delete Kapal'
            ]);
        }

        return response([
            'status' => 404,
            'message' => 'Kapal not Found'
        ]);
    }

    public function berita($id) {
        $data = array();
        $beritas = BeritaSpeedboat::where('id_speedboat', $id)->get();

        if (count($beritas) > 0) {
            foreach ($beritas as $berita) {
                array_push($data, [
                    'id' => $berita->id,
                    'username' => $berita->user->nama,
                    'speedboat' => $berita->speedboat->nama_speedboat,
                    'berita' => $berita->berita,
                    'tangal' => $berita->tanggal,
                    'foto' => $berita->foto
                ]);
            }

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'Successfully fetch berita speedboat'
            ]);
        }

        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Berita Speedboat not Found'
        ]);
    }

    public function review($id) {
        $data = array();
        $reviews = Review::where('id_speedboat', $id)->get();

        if (count($reviews) > 0) {
            foreach ($reviews as $review) {
                array_push($data, [
                    'id' => $review->id_review,
                    'username' => $review->pembelian->user->nama,
                    'review' => $review->review,
                    'score' => $review->score,
                    'tangal' => $review->pembelian->tanggal
                ]);
            }

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'Successfully fetch review speedboat'
            ]);
        }

        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Review Speedboat not Found'
        ]);
    }
}
