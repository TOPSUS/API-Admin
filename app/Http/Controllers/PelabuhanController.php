<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelabuhan;

class PelabuhanController extends Controller
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

    public function getPelabuhanName() {
        $pelabuhans = Pelabuhan::all();

        $data = array();
        $temp = array();

        foreach ($pelabuhans as $pelabuhan) {
            array_push($temp, [
                'id' => $pelabuhan->id,
                'nama' => $pelabuhan->nama_pelabuhan
            ]);
        }

        $data['pelabuhan'] = $temp;

        return response([
            'status' => 200,
            'data' => $data,
            'message' => 'Successfully Fetch Pelabuhan'
        ]);
    }

    public function getPelabuhan() {
        $data = array();
        
        $pelabuhans = Pelabuhan::all();

        $temp = array(); 
        
        foreach ($pelabuhans as $pelabuhan) {
            array_push($temp, [
                'id' => $pelabuhan->id,
                'text' => $pelabuhan->nama_pelabuhan
            ]);
        }

        $data = [
            'dropdown' => $temp
        ];

        return response([
            'status' => 200,
            'data' => $data,
            'message' => 'list data pelabuhan fetched'
        ]);
    }
}
