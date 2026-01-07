<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class VenueController extends Controller
{
    /* =========================
       FEATURED VENUES LIST
    ========================= */

// public function featuredVenueList(Request $request)
// {
//     try {

//         // 🔓 Token OPTIONAL (guest allowed)
//         $user = auth('sanctum')->user();
//         $userId = $user ? $user->id : null;

//         // Get featured venues with optional cart check
//         $venues = DB::table('properties as p')
//             ->leftJoin('carts as c', function ($join) use ($userId) {

//                 $join->on('c.property_id', '=', 'p.id');

//                 // cart join sirf logged-in user ke liye
//                 if ($userId) {
//                     $join->where('c.user_id', '=', $userId)
//                          ->where('c.status', '=', 'active');
//                 }
//             })
//             ->where('p.is_featured', 1)
//             ->where('p.status', 1)
//             ->select(
//                 'p.id',
//                 'p.type',
//                 'p.name',
//                 'p.description',
//                 'p.min_guests',
//                 'p.max_guests',
//                 'p.base_price',

//                 // 👇 guest ke liye hamesha 0
//                 DB::raw(
//                     $userId
//                         ? 'CASE WHEN c.id IS NULL THEN 0 ELSE 1 END AS check_cart'
//                         : '0 as check_cart'
//                 )
//             )
//             ->orderBy('p.id', 'DESC')
//             ->get();

//         // Attach one image (thumbnail)
//         $venues = $venues->map(function ($venue) {

//             $image = DB::table('property_images')
//                 ->where('property_id', $venue->id)
//                 ->select('image')
//                 ->orderBy('id', 'ASC')
//                 ->first();

//             $venue->images = $image ? [$image] : [];

//             return $venue;
//         });

//         return response()->json([
//             'status'   => true,
//             'is_login' => $userId ? true : false,
//             'data'     => $venues
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'status'  => false,
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }

public function featuredVenueList(Request $request)
{
    try {

        // 🔓 Token OPTIONAL (guest allowed)
        $user   = auth('sanctum')->user();
        $userId = $user ? $user->id : null;

        $venues = DB::table('properties as p')
            ->leftJoin('carts as c', function ($join) use ($userId) {

                $join->on('c.property_id', '=', 'p.id');

                if ($userId) {
                    $join->where('c.user_id', '=', $userId)
                         ->where('c.status', '=', 'active');
                }
            })
            ->where('p.is_featured', 1)
            ->where('p.status', 1)
            ->select(
                'p.id',
                'p.type',
                'p.name',
                'p.description',
                'p.min_guests',
                'p.max_guests',
                'p.base_price',

                DB::raw(
                    $userId
                        ? 'CASE WHEN c.id IS NULL THEN 0 ELSE 1 END AS check_cart'
                        : '0 as check_cart'
                )
            )
            ->orderBy('p.id', 'DESC')
            ->get();

        $venues = $venues->map(function ($venue) {

            // 📷 thumbnail image
            $image = DB::table('property_images')
                ->where('property_id', $venue->id)
                ->select('image')
                ->orderBy('id', 'ASC')
                ->first();

            $venue->images = $image ? [$image->image] : [];

            // ⭐ rating calculation
            $ratingData = DB::table('property_ratings')
                ->where('property_id', $venue->id)
                ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as avg_rating')
                ->first();

            $venue->total_ratings = (int) $ratingData->total_ratings;
            $venue->avg_rating    = $ratingData->avg_rating
                                    ? round($ratingData->avg_rating, 1)
                                    : 0;

            // 📝 latest reviews (max 3)
            $venue->reviews = DB::table('property_ratings as pr')
                ->leftJoin('users as u', 'u.id', '=', 'pr.user_id')
                ->where('pr.property_id', $venue->id)
                ->whereNotNull('pr.review')
                ->select(
                    DB::raw("IFNULL(u.name, 'Guest User') as user_name"),
                    'pr.rating',
                    'pr.review',
                    'pr.created_at as reviewed_at'
                )
                ->orderBy('pr.created_at', 'DESC')
                ->limit(3)
                ->get();

            return $venue;
        });

        return response()->json([
            'status'   => true,
            'is_login' => $userId ? true : false,
            'data'     => $venues
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 500);
    }
}




}
