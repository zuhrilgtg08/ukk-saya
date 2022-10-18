<?php

namespace App\Http\Controllers;

use App\Models\ReviewRating;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Result = [
            "buku" => Buku::with('ReviewData')->first()
        ];

        $data = $Result['buku']->all()->map(function ($query) {
            $dataRatings = ReviewRating::where('id_buku', '=', $query->id)->get();
            if ($dataRatings->count() == 0) {
                $query->star_rating = 0;
            } else {
                $rating = $dataRatings->sum('star_rating') / $dataRatings->count();
                $query->star_rating = $rating;
            }
            return $query;
        });

        $data = $data->filter(function ($buku) {
            return $buku->star_rating >= 1;
        });
        // dd($data);
        // $data = $Result['buku']->all();
        return view('pages.admin.adminReviews.index', compact('data'));
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
        $Result = Buku::with('ReviewData')->where('id', '=', $id)->first();
        $singleUser = User::with('review')->where('status_type', '<>', 1)->first();
        dd($singleUser->email);
        // dd($Result->ReviewData[0]->comments);
        // return view('pages.admin.adminReviews.show',['data' => $Result]);
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
