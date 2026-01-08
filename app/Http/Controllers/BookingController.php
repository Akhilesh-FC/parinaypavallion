<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /* ========================
       BOOKINGS LIST
    ========================= */
    public function bookings()
    {
        $bookings = DB::table('bookings')
            ->select(
                'id',
                'user_id',
                'property_id',
                'booking_date',
                'time_slot',
                'guest_count',
                'total_amount',
                'paid_amount',
                'booking_status',
                'payment_status',
                'created_at'
            )
            ->orderBy('id', 'desc')
            ->get();

        return view('Booking.index', compact('bookings'));
    }

    /* ========================
       UPDATE BOOKING
    ========================= */
    public function updateBooking(Request $request, $id)
    {
        DB::table('bookings')
            ->where('id', $id)
            ->update([
                'booking_status' => $request->booking_status,
                'payment_status' => $request->payment_status,
                'updated_at'     => now()
            ]);

        return back()->with('success', 'Booking updated successfully');
    }
}
