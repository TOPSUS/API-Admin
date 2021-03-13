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
        $temp = array();
        $score = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0);

        $reviews = Review::orderBy('id_review', 'desc')->get();

        if (count($reviews) > 0) {
            $total_review = 0;
            $total_score = 0;

            foreach($reviews as $index => $review) {
                $time = strtotime($review->pembelian->tanggal);
                $date = date("d-m-Y H:i", $time);

                $total_review = $total_review + 1;
                $total_score = $total_score + $review->score;

                if ($review->score <= 1 && $review->score > 0) {
                    $score['1'] += 1;
                } else if ($review->score <= 2 && $review->score > 1) {
                    $score['2'] += 1;
                } else if ($review->score <= 3 && $review->score > 2) {
                    $score['3'] += 1;
                } else if ($review->score <= 4 && $review->score > 3) {
                    $score['4'] += 1;
                } else if ($review->score <= 5 && $review->score > 4) {
                    $score['5'] += 1;
                }

                array_push($temp, [
                    'id' => $review->id_review,
                    'image' => $review->pembelian->user->foto,
                    'email' => $review->pembelian->user->email,
                    'tanggal' => $date,
                    'score' => $review->score,
                    'review' => $review->review
                ]);
            }

            $data = [
                'review_list' => $temp,
                'review_summary' => [
                    'total_review' => $total_review,
                    'total_score' => $total_score / $total_review,
                    'review_summary_score' => $score
                ]
            ];

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
        $data = array();
        $additional = array();
        $score = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0);

        $review = Review::find($id);

        if (isset($review)) {
            $total_review = 0;
            $total_score = 0;
            
            $time = strtotime($review->pembelian->tanggal);
            $date = date("d-m-Y H:i", $time);

            $total_review = $total_review + 1;
            $total_score = $total_score + $review->score;

            if ($review->score <= 1 && $review->score > 0) {
                $score['1'] += 1;
            } else if ($review->score <= 2 && $review->score > 1) {
                $score['2'] += 1;
            } else if ($review->score <= 3 && $review->score > 2) {
                $score['3'] += 1;
            } else if ($review->score <= 4 && $review->score > 3) {
                $score['4'] += 1;
            } else if ($review->score <= 5 && $review->score > 4) {
                $score['5'] += 1;
            }

            $data = [
                'review_detail' => [
                    'id' => $review->id_review,
                    'image' => $review->pembelian->user->foto,
                    'email' => $review->pembelian->user->email,
                    'tanggal' => $date,
                    'score' => $review->score,
                    'review' => $review->review,
                ],
                'review_detail_order' => [
                    'from_place' => $review->pembelian->jadwal->pelabuhanasal->kode_pelabuhan,
                    'from_date' => date("d F Y", strtotime($review->pembelian->jadwal->waktu_berangkat)),
                    'from_time' => date("H.i A", strtotime($review->pembelian->jadwal->waktu_berangkat)),
                    'to_place' => $review->pembelian->jadwal->pelabuhantujuan->kode_pelabuhan,
                    'to_date' => date("d F Y", strtotime($review->pembelian->jadwal->waktu_sampai)),
                    'to_time' => date("H.i A", strtotime($review->pembelian->jadwal->waktu_sampai)),
                    'speedboat' => $review->speedboat->nama_speedboat,
                    'person' => count($review->pembelian->detail)." Persons",
                    'price' => $review->pembelian->jadwal->harga
                ]
            ];

            return response([
                'status' => 200,
                'data' => $data,
                'message' => 'detail fetched'
            ]);
        }

        return response([
            'status' => 404,
            'data' => $data,
            'message' => 'review detail not found'
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
