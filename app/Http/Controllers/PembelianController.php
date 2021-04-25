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
                array_push($detail, [
                    'id' => $pembelian->id,
                    'username' => $pembelian->user->nama,
                    'email' => $pembelian->user->email,
                    'tanggal' => date("d F Y - H:i", strtotime($pembelian->tanggal)),
                    'status' => $pembelian->status,
                    'asal' => $pembelian->jadwal->pelabuhanasal->kode_pelabuhan,
                    'tujuan' => $pembelian->jadwal->pelabuhantujuan->kode_pelabuhan,
                    'tanggal_berangkat' => date("d F Y", strtotime($pembelian->jadwal->waktu_berangkat)),
                    'tanggal_sampai' => date("d F Y", strtotime($pembelian->jadwal->waktu_sampai)),
                    'jam_berangkat' => date("H:i", strtotime($pembelian->jadwal->waktu_berangkat)),
                    'jam_sampai' => date("H:i", strtotime($pembelian->jadwal->waktu_sampai)),
                    'person' => count($pembelian->detail)
                ]);
            }

            $data['transaksi_list'] = $detail;
    
            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data fetched'
            ]);
        }

        return response([
            'status' => 404,
            'message' => 'failed to fetch data'
        ]);
    }

    public function detailTransaksi($id) {
        $data = array();
        $detail = array();
        $pembelian = Pembelian::find($id);

        if (isset($pembelian)) {
            $detail_pembelians = DetailPembelian::where('id_pembelian', $id)->get();

            if (count($detail_pembelians) > 0) {
                foreach ($detail_pembelians as $dp) {
                    array_push($detail, [
                        'nama' => $dp->nama_pemegang_tiket,
                        'kode_tiket' => $dp->kode_tiket,
                        'nomor_id' => $dp->no_id_card,
                        'status' => $dp->status
                    ]);
                }
            }

            $data['transaksi'] = [
                'id' => $pembelian->id,
                'username' => $pembelian->user->nama,
                'email' => $pembelian->user->email,
                'tanggal' => date("d F Y - H:i", strtotime($pembelian->tanggal)),
                'status' => $pembelian->status,
                'asal' => $pembelian->jadwal->pelabuhanasal->kode_pelabuhan,
                'tujuan' => $pembelian->jadwal->pelabuhantujuan->kode_pelabuhan,
                'tanggal_berangkat' => date("d F Y", strtotime($pembelian->jadwal->waktu_berangkat)),
                'tanggal_sampai' => date("d F Y", strtotime($pembelian->jadwal->waktu_sampai)),
                'jam_berangkat' => date("H:i", strtotime($pembelian->jadwal->waktu_berangkat)),
                'jam_sampai' => date("H:i", strtotime($pembelian->jadwal->waktu_sampai)),
                'person' => count($pembelian->detail),
                'bukti' => $pembelian->bukti,
                'transaksi_detail' => $detail
            ];
    
            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data fetched'
            ]);
        }

        return response([
            'status' => 404,
            'message' => 'failed to fetch data'
        ]);
    }

    public function approvePembelian($id) {
        $pembelian = Pembelian::find($id);

        if (isset($pembelian)) {
            if ($pembelian->bukti != NULL) {
                $pembelian->status = "Terkonfirmasi";
                $pembelian->save();
    
                return response([
                    'status' => 200,
                    'message' => 'Berhasil Update Status'
                ]);
            }
    
            return response([
                'status' => 500,
                'message' => 'Bukti Pembayaran tidak ada'
            ]);
        }
    
        return response([
            'status' => 404,
            'message' => 'Pembelian tidak ditemukan'
        ]);
    }

    public function showTiket($kode_tiket) {
        $data = array();
        $detail = array();
        $tiket = DetailPembelian::where('kode_tiket', $kode_tiket)->first();

        if (isset($tiket)) {
            $data['tiket'] = [
                'id' => $tiket->id_detail_pembelian,
                'nama' => $tiket->nama_pemegang_tiket,
                'kode_tiket' => $tiket->kode_tiket,
                'nomor_id' => $tiket->no_id_card,
                'status_tiket' => $tiket->status,
                'harga' => $tiket->harga,
                'status_order' => $tiket->pembelian->status,
                'asal' => $tiket->pembelian->jadwal->pelabuhanasal->kode_pelabuhan,
                'tujuan' => $tiket->pembelian->jadwal->pelabuhantujuan->kode_pelabuhan,
                'tanggal_berangkat' => date("d F Y", strtotime($tiket->pembelian->jadwal->waktu_berangkat)),
                'tanggal_sampai' => date("d F Y", strtotime($tiket->pembelian->jadwal->waktu_sampai)),
                'jam_berangkat' => date("H:i", strtotime($tiket->pembelian->jadwal->waktu_berangkat)),
                'jam_sampai' => date("H:i", strtotime($tiket->pembelian->jadwal->waktu_sampai))
            ];
    
            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data fetched'
            ]);
        }
    
        return response([
            'status' => 404,
            'message' => 'Tiket tidak ditemukan'
        ]);
    }

    public function approveTiket($id) {
        $tiket = DetailPembelian::find($id);

        if (isset($tiket)) {
            if ($tiket->status != "Expired") {
                $tiket->status = "Used";
                $tiket->save();
    
                return response([
                    'status' => 200,
                    'message' => 'Tiket berhasil digunakan!'
                ]);
            }
    
            return response([
                'status' => 500,
                'message' => 'Tiket sudah Hangus!'
            ]);
        }
    
        return response([
            'status' => 404,
            'message' => 'Tiket tidak ditemukan!'
        ]);
    }
}
