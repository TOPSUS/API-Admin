<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Review;
use App\Kapal;
use App\BeritaSpeedboat;
use App\HakAksesKapal;
use App\DetailGolongan;
use App\Golongan;

use Auth;
use Image;

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

        // dd(count($listKapal));

        $temp = array();
        foreach ($listKapal as $list) {
            $kapal = Kapal::find($list->id_kapal);
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
            'list_kapal' => $temp
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
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kapasitas' => 'required',
            'deskripsi' => 'required',
            'contact' => 'required',
            'tanggal_beroperasi' => 'required',
            'tipe' => 'required',
            'golongan' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 500,
                'message' => 'Validator Fail'
            ]);
        }

        $create = new Kapal;
        $create->nama_kapal = $request->nama;
        $create->kapasitas = $request->kapasitas;
        $create->deskripsi = $request->deskripsi;
        $create->contact_service = $request->contact;
        $create->tanggal_beroperasi = $request->tanggal_beroperasi;
        $create->tipe_kapal = strtolower($request->tipe);
        if ($request->hasFile('image_kapal')) {
            $imageKapal = $request->file('image_kapal');
            
            $imageName = time().'.'.$imageKapal->getClientOriginalExtension();

            /*After Resize Add this Code to Upload Image*/
            $destinationPath = public_path('image_kapal/images');

            $imageKapal->move($destinationPath, $imageName);
            
            $create->foto = url('image_kapal/images/'.$imageName);
        }
        
        if ($create->save()) {
            $hakAkses = new HakAksesKapal;
            $hakAkses->id_kapal = $create->id;
            $hakAkses->hak_akses = 'Admin';
            $hakAkses->id_user = Auth::user()->id;
            $hakAkses->save();


            $golongan = Golongan::where('golongan', $request->golongan)->first();
            $detailGolongan = new DetailGolongan;
            $detailGolongan->id_golongan = $golongan->id;
            $detailGolongan->id_kapal = $create->id;
            $detailGolongan->jumlah = 1;
            if ($detailGolongan->save()) {
                return response([
                    'status' => 200,
                    'message' => 'success create kapal'
                ]);
            } else {
                return response([
                    'status' => 500,
                    'message' => 'success create kapal but failed create detail golongan'
                ]);
            }
        } else {
            return response([
                'status' => 500,
                'message' => 'failed to create kapal'
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
        $kapal = Kapal::find($id);

        if (isset($kapal)) {
            $data['kapal'] = [
                'id' => $kapal->id,
                'nama' => $kapal->nama_kapal,
                'kapasitas' => $kapal->kapasitas,
                'tipe' => $kapal->tipe_kapal,
                'foto' => $kapal->foto,
                'golongan' => $kapal->detailGolongan->golongan,
                'deskripsi' => $kapal->deskripsi,
                'contact' => $kapal->contact_service,
                'tanggal_beroperasi' => date('d M Y', strtotime($kapal->tanggal_beroperasi))
            ];

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
            'contact' => 'required',
            'tanggal_beroperasi' => 'required',
            'tipe' => 'required',
            'golongan' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 500,
                'message' => $validator->errors()->first()
            ]);
        }

        $update = Kapal::find($id);
        $update->nama_kapal = $request->nama;
        $update->kapasitas = $request->kapasitas;
        $update->deskripsi = $request->deskripsi;
        $update->contact_service = $request->contact;
        $update->tanggal_beroperasi = $request->tanggal_beroperasi;
        $update->tipe_kapal = strtolower($request->tipe);
        if ($request->hasFile('image_kapal')) {
            $imageKapal = $request->file('image_kapal');
            
            $imageName = time().'.'.$imageKapal->getClientOriginalExtension();

            /*After Resize Add this Code to Upload Image*/
            $destinationPath = public_path('image_kapal/images');

            $imageKapal->move($destinationPath, $imageName);
            
            // $update->foto = url('image_kapal/images/'.$imageName);
            $update->foto = $imageName;
        }
        
        if ($update->save()) {
            $golongan = Golongan::where('golongan', $request->golongan)->first();
            $checkDetailGolongan = DetailGolongan::where('id_kapal', $update->id)->first();

            if (isset($checkDetailGolongan)) {
                $detailGolongan = DetailGolongan::find($checkDetailGolongan->id);
            } else {
                $detailGolongan = new DetailGolongan;
            }

            $detailGolongan->id_golongan = $golongan->id;
            $detailGolongan->id_kapal = $update->id;
            $detailGolongan->jumlah = 1;

            if ($detailGolongan->save()) {
                return response([
                    'status' => 200,
                    'message' => 'success update kapal'
                ]);
            } else {
                return response([
                    'status' => 500,
                    'message' => 'success update kapal but failed update detail golongan'
                ]);
            }
        } else {
            return response([
                'status' => 500,
                'message' => 'failed to update kapal'
            ]);
        }
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
