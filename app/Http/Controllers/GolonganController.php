<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Golongan;
use App\Pelabuhan;

class GolonganController extends Controller
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

    public function golonganByPelabuhan($id) {
        $pelabuhan = Pelabuhan::where('nama_pelabuhan', $id)->first();

        $data = array();

        if (isset($pelabuhan)) {
            $golongans = Golongan::where('id_pelabuhan', $pelabuhan->id)->get();

            $temp = array();
            
            foreach($golongans as $golongan) {
                array_push($temp, [
                    'id' => $golongan->id,
                    'golongan' => $golongan->golongan,
                    'harga' => $golongan->harga
                ]);
            }

            $data['golongan'] = $temp;
            
            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'Successfully fetch golongan'
            ]);
        }
            
        return response([
            'status' => 500,
            'message' => 'pelabuhan not found'
        ]);
    }
}
