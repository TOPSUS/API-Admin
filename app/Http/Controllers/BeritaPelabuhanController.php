<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BeritaPelabuhan;
use Auth;
class BeritaPelabuhanController extends Controller
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
        $listBerita = BeritaPelabuhan::where('id_user', $id_user)->get();

        // dd(count($listKapal));

        $temp = array();
        foreach ($listBerita as $list) {
            $berita = BeritaPelabuhan::find($list->id);
            if (isset($berita)) {
                array_push($temp, [
                    'id' => $berita->id,
                    'judul' => $berita->judul,
                    'foto' => $berita->foto,
                    'created' => $berita->created_at,
                ]);
            }
        }

        $data = [
            'list_berita' => $temp
        ];

        return response([
            'status' => 200,
            'data' => $data,
            'message' => 'list data berita fetched'
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
}
