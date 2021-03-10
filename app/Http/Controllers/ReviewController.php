<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Review;

class ReviewController extends Controller
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
        $reviews = Review::all();

        if (count($reviews) > 0) {
            foreach($reviews as $index => $review) {
                array_push($data, [
                    'image' => $review->pembelian->user->foto,
                    'username' => $review->pembelian->user->nama,
                    'email' => $review->pembelian->user->email,
                    'tanggal' => $review->pembelian->tanggal,
                    'score' => $review->score,
                    'review' => $review->review
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
