<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{

    /* =========================
       GET ALL ROOMS
    ========================= */
    
    
 
public function listRooms(Request $request)
{
    try {

        // 🔓 Token OPTIONAL (guest allowed)
        $user   = auth('sanctum')->user();
        $userId = $user ? $user->id : null;

        // Get rooms with optional cart check
        $rooms = DB::table('properties as p')
            ->leftJoin('carts as c', function ($join) use ($userId) {

                $join->on('c.property_id', '=', 'p.id');

                if ($userId) {
                    $join->where('c.user_id', '=', $userId)
                         ->where('c.status', '=', 'active');
                }
            })
            ->where('p.type', 'room')
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
            ->orderBy('p.base_price', 'ASC')
            ->get();

        // ⬇️ Attach image + rating + reviews PER ROOM
        $rooms = $rooms->map(function ($room) {

            // 📷 single image (thumbnail)
            $image = DB::table('property_images')
                ->where('property_id', $room->id)
                ->select('image')
                ->orderBy('id', 'ASC')
                ->first();

            $room->images = $image ? [$image->image] : [];

            // ⭐ rating calculation
            $ratingData = DB::table('property_ratings')
                ->where('property_id', $room->id)
                ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as avg_rating')
                ->first();

            $room->total_ratings = (int) $ratingData->total_ratings;
            $room->avg_rating    = $ratingData->avg_rating
                                    ? round($ratingData->avg_rating, 1)
                                    : 0; // out of 5

            // 📝 latest reviews (max 3)
            $room->reviews = DB::table('property_ratings as pr')
                ->leftJoin('users as u', 'u.id', '=', 'pr.user_id')
                ->where('pr.property_id', $room->id)
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

            return $room;
        });

        return response()->json([
            'status'   => true,
            'is_login' => $userId ? true : false,
            'data'     => $rooms
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


    
    
    
    
//   public function listRooms(Request $request)
// {
//     try {

//         $userId = $request->query('user_id'); // cart check ke liye

//         // Get rooms with cart check
//         $rooms = DB::table('properties as p')
//             ->leftJoin('carts as c', function ($join) use ($userId) {
//                 $join->on('c.property_id', '=', 'p.id')
//                      ->where('c.user_id', '=', $userId)
//                      ->where('c.status', '=', 1);
//             })
//             ->where('p.type', 'room')
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
//             ->orderBy('p.base_price', 'ASC')
//             ->get();

//         // Attach one image (thumbnail)
//         $rooms = $rooms->map(function ($room) {

//             $image = DB::table('property_images')
//                 ->where('property_id', $room->id)
//                 ->select('image')
//                 ->orderBy('id', 'ASC')
//                 ->first();

//             $room->images = $image ? [$image] : [];

//             return $room;
//         });

//         return response()->json([
//             'status' => true,
//             'data'   => $rooms
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'status'  => false,
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }

}
