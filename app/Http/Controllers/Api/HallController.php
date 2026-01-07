<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HallController extends Controller
{
    /* =========================
       GET ALL HALLS
    ========================= */
    
    
    

public function listHalls(Request $request)
{
    try {

        // 🔓 Token OPTIONAL (guest allowed)
        $user   = auth('sanctum')->user();
        $userId = $user ? $user->id : null;

        $halls = DB::table('properties as p')
            ->leftJoin('carts as c', function ($join) use ($userId) {
                $join->on('c.property_id', '=', 'p.id');

                if ($userId) {
                    $join->where('c.user_id', '=', $userId)
                         ->where('c.status', '=', 'active');
                }
            })
            ->where('p.type', 'hall')
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

        // ⬇️ Attach image + rating + reviews PER HALL
        $halls = $halls->map(function ($hall) {

            // 📷 single image (thumbnail)
            $image = DB::table('property_images')
                ->where('property_id', $hall->id)
                ->select('image')
                ->orderBy('id', 'ASC')
                ->first();

            $hall->images = $image ? [$image->image] : [];

            // ⭐ rating calculation
            $ratingData = DB::table('property_ratings')
                ->where('property_id', $hall->id)
                ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as avg_rating')
                ->first();

            $hall->total_ratings = (int) $ratingData->total_ratings;
            $hall->avg_rating    = $ratingData->avg_rating
                                    ? round($ratingData->avg_rating, 1)
                                    : 0;

            // 📝 latest reviews (max 3)
            $hall->reviews = DB::table('property_ratings as pr')
                ->leftJoin('users as u', 'u.id', '=', 'pr.user_id')
                ->where('pr.property_id', $hall->id)
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

            return $hall;
        });

        return response()->json([
            'status'   => true,
            'is_login' => $userId ? true : false,
            'data'     => $halls
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 500);
    }
}



    
    
    
    
    
    
    
//     public function listHalls(Request $request)
// {
//     try {

//         $userId = $request->query('user_id'); // cart check ke liye

//         // Get halls with cart check
//         $halls = DB::table('properties as p')
//             ->leftJoin('carts as c', function ($join) use ($userId) {
//                 $join->on('c.property_id', '=', 'p.id')
//                      ->where('c.user_id', '=', $userId)
//                      ->where('c.status', '=', 1);
//             })
//             ->where('p.type', 'hall')
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

//         // Attach 1 image per hall
//         $halls = $halls->map(function ($hall) {

//             $image = DB::table('property_images')
//                 ->where('property_id', $hall->id)
//                 ->select('image')
//                 ->orderBy('id', 'ASC')
//                 ->first();

//             $hall->images = $image ? [$image] : [];

//             return $hall;
//         });

//         return response()->json([
//             'status' => true,
//             'data'   => $halls
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'status'  => false,
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }

}
