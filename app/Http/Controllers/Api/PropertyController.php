<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    
  public function show($id)
{
    try {

        // 🔒 strict check
        if (empty($id) || !is_numeric($id)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid property id'
            ], 400);
        }

        // 🔍 fetch property
        $property = DB::table('properties')
            ->where('id', (int) $id)
            ->first();

        // ❌ property not found
        if (!$property) {
            return response()->json([
                'status'  => false,
                'message' => 'Property not found'
            ], 404);
        }

        // 🖼️ images
        $property->images = DB::table('property_images')
            ->where('property_id', $property->id)
            ->pluck('image');

        // 🏨 facilities
        $property->facilities = DB::table('facilities as f')
            ->join('property_facilities as pf', 'pf.facility_id', '=', 'f.id')
            ->where('pf.property_id', $property->id)
            ->pluck('f.name');

        // ⭐ rating calculation
        $ratingData = DB::table('property_ratings')
            ->where('property_id', $property->id)
            ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as avg_rating')
            ->first();

        $property->total_ratings = (int) $ratingData->total_ratings;
        $property->avg_rating    = $ratingData->avg_rating
                                    ? round($ratingData->avg_rating, 1)
                                    : 0;

        // 📝 reviews (latest 5)
        $property->reviews = DB::table('property_ratings as pr')
            ->leftJoin('users as u', 'u.id', '=', 'pr.user_id')
            ->where('pr.property_id', $property->id)
            ->whereNotNull('pr.review')
            ->select(
                'pr.user_id',
                DB::raw("IFNULL(u.name, 'Guest User') as user_name"),
                'pr.rating',
                'pr.review',
                'pr.created_at as reviewed_at'
            )
            ->orderBy('pr.created_at', 'DESC')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $property
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()
        ], 500);
    }
}



   
   

    
    /* =========================
       PROPERTY LIST
    ========================= */
    public function list(Request $request)
    {
        try {
            $type = $request->query('type');

            // Base query
            $query = DB::table('properties')
                ->select(
                    'id',
                    'type',
                    'name',
                    'description',
                    'base_price',
                    'min_guests',
                    'max_guests'
                );

            if (!empty($type)) {
                $query->where('type', $type);
            }

            $properties = $query->get();

            // Attach images & facilities
            $properties = $properties->map(function ($property) {

                // images
                $property->images = DB::table('property_images')
                    ->where('property_id', $property->id)
                    ->select('image')
                    ->get();

                // facilities (pivot table)
                $property->facilities = DB::table('facilities as f')
                    ->join('property_facilities as pf', 'pf.facility_id', '=', 'f.id')
                    ->where('pf.property_id', $property->id)
                    ->select('f.name')
                    ->get();

                return $property;
            });

            return response()->json([
                'status' => true,
                'data'   => $properties
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /* =========================
       COUNT PROPERTIES
    ========================= */
    public function countProperties()
    {
        try {
            $lawns = DB::table('properties')->where('type', 'lawn')->count();
            $halls = DB::table('properties')->where('type', 'hall')->count();
            $rooms = DB::table('properties')->where('type', 'room')->count();

            return response()->json([
                'status' => true,
                'data' => [
                    'lawns' => $lawns,
                    'halls' => $halls,
                    'rooms' => $rooms,
                    'total' => $lawns + $halls + $rooms
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
