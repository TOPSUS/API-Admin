<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pembelian;
use App\DetailPembelian;

class PembelianController extends Controller
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

    public function indexProses() {
        return $this->getPembelian('Menunggu Konfirmasi');
    }

    public function indexDone() {
        return $this->getPembelian('Terkonfirmasi');
    }

    private function getPembelian($tipe) {
        $data = array();
        $detail = array();
        $pembelians = Pembelian::where('status', '=', $tipe)->get();

        if (count($pembelians) > 0) {
            foreach($pembelians as $pembelian) {
                foreach($pembelian->detail as $data_detail) {
                    array_push($detail, [
                        'kode' => $data_detail->kode_tiket
                    ]);
                }

                array_push($data, [
                    'id' => $pembelian->id,
                    'username' => $pembelian->user->nama,
                    'tanggal' => $pembelian->tanggal,
                    'status' => $pembelian->status,
                    'tiket' => $detail,
                    'asal' => $pembelian->jadwal->pelabuhanasal->nama_pelabuhan,
                    'tujuan' => $pembelian->jadwal->pelabuhantujuan->nama_pelabuhan
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
            'message' => 'failed to fetch data'
        ]);
    }
}
