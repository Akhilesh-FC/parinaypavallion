<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class RatingController extends Controller
{
  public function getPropertyRatings(Request $request)
{
    try {

        $propertyId = $request->query('property_id');

        if (empty($propertyId) || !is_numeric($propertyId)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid property id'
            ], 400);
        }

        // ratings with user name
        $ratings = DB::table('property_ratings as pr')
            ->leftJoin('users as u', DB::raw('u.id'), '=', DB::raw('pr.user_id'))
            ->where('pr.property_id', $propertyId)
            ->select(
                'pr.user_id',
                DB::raw("IFNULL(u.name, 'Unknown User') as user_name"),
                'pr.rating',
                'pr.review',
                'pr.created_at as rated_at'
            )
            ->orderBy('pr.created_at', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $ratings
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()
        ], 500);
    }
}


    
    
    
    public function rateProperty(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id'     => 'required|integer',
        'property_id' => 'required|integer',
        'rating'      => 'required|integer|min:1|max:5',
        'review'      => 'nullable|string'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first()
        ], 400);
    }

    try {

        // check property exists
        $property = DB::table('properties')->where('id', $request->property_id)->first();
        if (!$property) {
            return response()->json([
                'status'  => false,
                'message' => 'Property not found'
            ], 404);
        }

        // insert or update rating
        DB::table('property_ratings')->updateOrInsert(
            [
                'property_id' => $request->property_id,
                'user_id'     => $request->user_id
            ],
            [
                'rating'     => $request->rating,
                'review'     => $request->review,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        // ⭐ recalculate average rating
        $avgRating = DB::table('property_ratings')
            ->where('property_id', $request->property_id)
            ->avg('rating');

        // update property table
        DB::table('properties')
            ->where('id', $request->property_id)
            ->update([
                'rating' => round($avgRating, 1)
            ]);

        return response()->json([
            'status' => true,
            'message'=> 'Rating submitted successfully',
            'rating' => round($avgRating, 1)
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()
        ], 500);
    }
}


    
}