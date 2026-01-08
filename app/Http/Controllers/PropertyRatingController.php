<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PropertyRatingController extends Controller
{
    /* ===========================
       PROPERTY RATINGS LIST
    ============================ */
    public function index()
    {
        $ratings = DB::table('property_ratings as pr')
            ->join('users as u', 'u.id', '=', 'pr.user_id')
            ->join('properties as p', 'p.id', '=', 'pr.property_id')
            ->select(
                'pr.id',
                'pr.rating',
                'pr.review',
                'pr.created_at',
                'u.name as user_name',
                'u.email',
                'u.mobile',
                'p.name as property_name',
                'p.type as property_type'
            )
            ->orderBy('pr.id', 'desc')
            ->get();

        return view('property_ratings.index', compact('ratings'));
    }
}
