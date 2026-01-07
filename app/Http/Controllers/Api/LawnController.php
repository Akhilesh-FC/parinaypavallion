<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LawnController extends Controller
{

    /* =========================
       GET ALL WEDDING LAWNS
    ========================= */
    
    


public function listLawns(Request $request)
{
    try {

        // 🔓 Token OPTIONAL (guest allowed)
        $user   = auth('sanctum')->user();
        $userId = $user ? $user->id : null;

        // Fetch lawns with optional cart check
        $lawns = DB::table('properties as p')
            ->leftJoin('carts as c', function ($join) use ($userId) {

                $join->on('c.property_id', '=', 'p.id');

                if ($userId) {
                    $join->where('c.user_id', '=', $userId)
                         ->where('c.status', '=', 'active');
                }
            })
            ->where('p.type', 'lawn')
            ->where('p.status', 1)
            ->select(
                'p.id',
                'p.name',
                'p.description',
                'p.base_price',
                'p.min_guests',
                'p.max_guests',

                DB::raw(
                    $userId
                        ? 'CASE WHEN c.id IS NULL THEN 0 ELSE 1 END AS check_cart'
                        : '0 as check_cart'
                )
            )
            ->orderBy('p.base_price', 'DESC')
            ->get();

        // ⬇️ Attach image + rating + reviews PER LAWN
        $lawns = $lawns->map(function ($lawn) {

            // 📷 single image (thumbnail)
            $image = DB::table('property_images')
                ->where('property_id', $lawn->id)
                ->select('image')
                ->orderBy('id', 'ASC')
                ->first();

            $lawn->images = $image ? [$image->image] : [];

            // ⭐ rating calculation
            $ratingData = DB::table('property_ratings')
                ->where('property_id', $lawn->id)
                ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as avg_rating')
                ->first();

            $lawn->total_ratings = (int) $ratingData->total_ratings;
            $lawn->avg_rating    = $ratingData->avg_rating
                                    ? round($ratingData->avg_rating, 1)
                                    : 0; // out of 5

            // 📝 latest reviews (max 3)
            $lawn->reviews = DB::table('property_ratings as pr')
                ->leftJoin('users as u', 'u.id', '=', 'pr.user_id')
                ->where('pr.property_id', $lawn->id)
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

            return $lawn;
        });

        return response()->json([
            'status'   => true,
            'is_login' => $userId ? true : false,
            'data'     => $lawns
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 500);
    }
}



    
    
    
    
//   public function listLawns(Request $request)
// {
//     try {

//         $userId = $request->query('user_id'); // cart check ke liye

//         // Fetch lawns with cart check
//         $lawns = DB::table('properties as p')
//             ->leftJoin('carts as c', function ($join) use ($userId) {
//                 $join->on('c.property_id', '=', 'p.id')
//                      ->where('c.user_id', '=', $userId)
//                      ->where('c.status', '=', 1);
//             })
//             ->where('p.type', 'lawn')
//             ->where('p.status', 1)
//             ->select(
//                 'p.id',
//                 'p.name',
//                 'p.description',
//                 'p.base_price',
//                 'p.min_guests',
//                 'p.max_guests',
//                 DB::raw('CASE WHEN c.id IS NULL THEN 0 ELSE 1 END AS check_cart')
//             )
//             ->orderBy('p.base_price', 'DESC')
//             ->get();

//         // Attach ONE image (thumbnail)
//         $lawns = $lawns->map(function ($lawn) {

//             $image = DB::table('property_images')
//                 ->where('property_id', $lawn->id)
//                 ->select('image')
//                 ->orderBy('id', 'ASC')
//                 ->first();

//             $lawn->images = $image ? [$image] : [];

//             return $lawn;
//         });

//         return response()->json([
//             'status' => true,
//             'data'   => $lawns
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'status'  => false,
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }



    /* =========================
       SINGLE LAWN DETAILS
    ========================= */
    public function getLawnDetails($id)
    {
        try {

            // Lawn basic details
            $lawn = DB::table('properties')
                ->where('id', $id)
                ->where('type', 'lawn')
                ->where('status', 1)
                ->select(
                    'id',
                    'name',
                    'description',
                    'base_price',
                    'min_guests',
                    'max_guests'
                )
                ->first();

            if (!$lawn) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lawn not found'
                ], 404);
            }

            // All images
            $lawn->images = DB::table('property_images')
                ->where('property_id', $id)
                ->select('image')
                ->get();

            // Facilities (pivot table based)
            $lawn->facilities = DB::table('facilities as f')
                ->join('property_facilities as pf', 'pf.facility_id', '=', 'f.id')
                ->where('pf.property_id', $id)
                ->select('f.name')
                ->get();

            return response()->json([
                'status' => true,
                'data'   => $lawn
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
