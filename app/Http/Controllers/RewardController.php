<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Reward;

class RewardController extends Controller
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
        $rewards = Reward::all();

        if (count($rewards) > 0) {
            foreach($rewards as $reward) {
                array_push($data, [
                    'id' => $reward->id,
                    'speedboat' => $reward->speedboat->nama_speedboat,
                    'berlaku' => $reward->berlaku,
                    'minimal_point' => $reward->minimal_point,
                    'reward' => $reward->reward,
                    'foto' => $reward->foto
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
            'message' => 'reward data not found'
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
        $data = array();
        $validator = Validator::make($request->all(), [
            'id_speedboat' => 'required',
            'reward' => 'required',
            'berlaku' => 'required',
            'minimal_point' => 'required',
            'foto' => 'required'
        ]);

        
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'data' => $data,
                'message' => $validator->errors()
            ]);
        }

        $reward = new Reward;

        if (isset($reward)) {
            $reward->id_speedboat = $request->id_speedboat;
            $reward->reward = $request->reward;
            $reward->berlaku = $request->berlaku;
            $reward->minimal_point = $request->minimal_point;
            $reward->foto = $request->foto;

            if ($reward->save()) {
                return response([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'Successfully Create Reward'
                ]);
            }
   
            return response([
                'status' => 500,
                'data' => $data,
                'message' => 'Failed Create Reward'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Reward not Found'
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
        $reward = Reward::find($id);

        if (isset($reward)) {
            array_push($data, [
                'id' => $reward->id,
                'id_speedboat' => $reward->id_speedboat,
                'berlaku' => $reward->berlaku,
                'minimal_point' => $reward->minimal_point,
                'reward' => $reward->reward,
                'foto' => $reward->foto
            ]);

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'data reward fetched'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'failed to fetch data reward'
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
            'id_speedboat' => 'required',
            'reward' => 'required',
            'berlaku' => 'required',
            'minimal_point' => 'required',
            'foto' => 'required'
        ]);

        
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'data' => $data,
                'message' => $validator->errors()
            ]);
        }

        $reward = Reward::find($id);

        if (isset($reward)) {
            $reward->id_speedboat = $request->id_speedboat;
            $reward->reward = $request->reward;
            $reward->berlaku = $request->berlaku;
            $reward->minimal_point = $request->minimal_point;
            $reward->foto = $request->foto;

            if ($reward->save()) {
                return response([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'Successfully Update Reward'
                ]);
            }
   
            return response([
                'status' => 500,
                'data' => $data,
                'message' => 'Failed Update Reward'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'Reward not Found'
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
        $reward = Reward::find($id);

        if (isset($reward)) {
            if ($reward->delete()) {
                return response([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'data reward deleted'
                ]);
            }

            return response([
                'status' => 500,
                'data' => $data,
                'message' => 'failed to delete data reward'
            ]);
        }
        
        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'data reward not found'
        ]);
    }
}
