<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function addRemoveCart(Request $request)
    {
    try {
        // 🔐 user_id token se
        $userId     = $request->user()->id;
        $propertyId = $request->property_id;
        $status     = $request->status; // 1 = add, 0 = remove

        /* =========================
           BASIC VALIDATION
        ========================== */
        if (!$propertyId || !isset($status)) {
            return response()->json([
                'status' => false,
                'message' => 'property_id and status required'
            ], 400);
        }

        /* =========================
           PROPERTY EXIST CHECK
        ========================== */
        $property = DB::table('properties')->where('id', $propertyId)->first();
        if (!$property) {
            return response()->json([
                'status' => false,
                'message' => 'Property not found'
            ], 404);
        }

        /* =========================
           CHECK EXISTING CART
        ========================== */
        $cart = DB::table('carts')
            ->where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->where('status', 'active')
            ->first();

        /* =========================
           ADD TO CART (status = 1)
        ========================== */
        if ((int)$status === 1) {

            if ($cart) {
                return response()->json([
                    'status' => true,
                    'message' => 'Already in cart'
                ]);
            }

            DB::table('carts')->insert([
                'user_id'     => $userId,
                'property_id' => $propertyId,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Added to cart'
            ]);
        }

        /* =========================
           REMOVE FROM CART (status = 0)
        ========================== */
        if ((int)$status === 0) {

            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            DB::table('carts')
                ->where('id', $cart->id)
                ->update([
                    'status'     => 'converted',
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => true,
                'message' => 'Removed from cart'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid status value'
        ], 400);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function myCart(Request $request)
    {
    try {

        $userId = $request->user()->id;

        $cartItems = DB::table('carts as c')
            ->join('properties as p', 'p.id', '=', 'c.property_id')
            ->where('c.user_id', $userId)
            ->where('c.status', 'active')
            ->select(
                'c.id as cart_id',
                'p.id',
                'p.type',
                'p.name',
                'p.description',
                'p.min_guests',
                'p.max_guests',
                'p.base_price',
                'p.status',
                'p.is_featured',
                'p.created_at',
                'p.updated_at'
            )
            ->get();

        // Attach images to each property
        $cartItems = $cartItems->map(function ($item) {

            $images = DB::table('property_images')
                ->where('property_id', $item->id)
                ->select('image')
                ->orderBy('id', 'ASC')
                ->get();

            $item->images = $images;

            return $item;
        });

        return response()->json([
            'status' => true,
            'count'  => $cartItems->count(),
            'data'   => $cartItems
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function confirmBookingFromCart(Request $request)
    {
    DB::beginTransaction();

    try {
        $userId = $request->user()->id;
        $cartId = $request->cart_id;

        if (!$cartId) {
            return response()->json([
                'status' => false,
                'message' => 'cart_id required'
            ], 400);
        }

        /* =========================
           1️⃣ FETCH CART
        ========================== */
        $cart = DB::table('carts')
            ->where('id', $cartId)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart not found or already booked'
            ], 404);
        }

        /* =========================
           2️⃣ FETCH PROPERTY PRICE
        ========================== */
        $property = DB::table('properties')
            ->where('id', $cart->property_id)
            ->select('base_price')
            ->first();

        if (!$property) {
            return response()->json([
                'status' => false,
                'message' => 'Property not found'
            ], 404);
        }

        /* =========================
           3️⃣ EXACT AMOUNT VALIDATION
        ========================== */
        if ((float)$cart->total_amount !== (float)$property->base_price) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid cart amount'
            ], 400);
        }

        if ((float)$request->paid_amount !== (float)$property->base_price) {
            return response()->json([
                'status' => false,
                'message' => 'Payment must be exactly ₹' . $property->base_price
            ], 400);
        }

        /* =========================
           4️⃣ SLOT AVAILABILITY CHECK
        ========================== */
        $alreadyBooked = DB::table('property_availabilities')
            ->where('property_id', $cart->property_id)
            ->where('date', $cart->booking_date)
            ->where('time_slot', $cart->time_slot)
            ->where('is_available', 0)
            ->exists();

        if ($alreadyBooked) {
            return response()->json([
                'status' => false,
                'message' => 'Slot already booked'
            ], 409);
        }

        /* =========================
           5️⃣ CREATE BOOKING (SINGLE PAYMENT)
        ========================== */
        $bookingId = DB::table('bookings')->insertGetId([
            'user_id'        => $userId,
            'cart_id'        => $cart->id,
            'property_id'    => $cart->property_id,
            'booking_date'   => $cart->booking_date,
            'time_slot'      => $cart->time_slot,
            'guest_count'    => $cart->guest_count,
            'total_amount'   => $property->base_price,
            'paid_amount'    => $property->base_price,
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        /* =========================
           6️⃣ LOCK SLOT
        ========================== */
        DB::table('property_availabilities')->insert([
            'property_id'  => $cart->property_id,
            'date'         => $cart->booking_date,
            'time_slot'    => $cart->time_slot,
            'is_available' => 0,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        /* =========================
           7️⃣ REMOVE FROM CART
        ========================== */
        DB::table('carts')
            ->where('id', $cart->id)
            ->update([
                'status'     => 'converted',
                'updated_at' => now()
            ]);

        DB::commit();

        return response()->json([
            'status'     => true,
            'message'    => 'Booking confirmed (single payment)',
            'booking_id' => $bookingId,
            'paid_amount'=> $property->base_price
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function checkout(Request $request)
    {
        try {
            $userId     = $request->user()->id;
            $propertyId = $request->property_id;
            $date       = $request->booking_date;
            $slot       = $request->time_slot;
    
            if (!$propertyId || !$date || !$slot) {
                return response()->json([
                    'status' => false,
                    'message' => 'property_id, booking_date and time_slot required'
                ], 400);
            }
    
            /* =========================
               CART CHECK
            ========================== */
            $cart = DB::table('carts')
                ->where('user_id', $userId)
                ->where('property_id', $propertyId)
                ->where('status', 'active')
                ->first();
    
            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Property not found in cart'
                ], 404);
            }
    
            /* =========================
               AVAILABILITY CHECK (CRITICAL)
            ========================== */
            $alreadyBooked = DB::table('property_availabilities')
                ->where('property_id', $propertyId)
                ->where('date', $date)
                ->where('time_slot', $slot)
                ->where('is_available', 0)
                ->exists();
    
            if ($alreadyBooked) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sorry, this property is already booked for selected date & slot'
                ], 409);
            }
    
            /* =========================
               PROPERTY PRICE
            ========================== */
            $property = DB::table('properties')
                ->where('id', $propertyId)
                ->select('base_price', 'name')
                ->first();
    
            return response()->json([
                'status' => true,
                'message' => 'Available. Proceed to payment',
                'property' => [
                    'id'    => $propertyId,
                    'name'  => $property->name,
                    'price' => $property->base_price
                ]
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
}

    public function paytmSuccess(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $userId     = $request->user_id;
            $propertyId = $request->property_id;
            $date       = $request->booking_date;
            $slot       = $request->time_slot;
            $amount     = $request->amount;
    
            /* =========================
               FINAL AVAILABILITY LOCK
            ========================== */
            $blocked = DB::table('property_availabilities')
                ->where('property_id', $propertyId)
                ->where('date', $date)
                ->where('time_slot', $slot)
                ->where('is_available', 0)
                ->lockForUpdate()
                ->exists();
    
            if ($blocked) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Slot just booked by another user'
                ], 409);
            }
    
            /* =========================
               CREATE BOOKING
            ========================== */
            $bookingId = DB::table('bookings')->insertGetId([
                'user_id'        => $userId,
                'property_id'    => $propertyId,
                'booking_date'   => $date,
                'time_slot'      => $slot,
                'total_amount'   => $amount,
                'paid_amount'    => $amount,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'created_at'     => now(),
                'updated_at'     => now()
            ]);
    
            /* =========================
               LOCK SLOT
            ========================== */
            DB::table('property_availabilities')->insert([
                'property_id'  => $propertyId,
                'date'         => $date,
                'time_slot'    => $slot,
                'is_available' => 0,
                'created_at'   => now(),
                'updated_at'   => now()
            ]);
    
            /* =========================
               REMOVE FROM CART
            ========================== */
            DB::table('carts')
                ->where('user_id', $userId)
                ->where('property_id', $propertyId)
                ->update([
                    'status' => 'converted'
                ]);
    
            DB::commit();
    
            return response()->json([
                'status' => true,
                'message' => 'Booking confirmed successfully',
                'booking_id' => $bookingId
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
}


}
