<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{

    /* =========================
       DROPDOWN: VENUE / ROOM
    ========================= */
    public function getVenuesForDropdown()
    {
        try {
            $data = DB::table('properties')
                ->where('status', 1)
                ->select('id', 'type', 'name')
                ->orderBy('type', 'ASC')
                ->orderBy('name', 'ASC')
                ->get();

            return response()->json([
                'status' => true,
                'data'   => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /* =========================
       EVENT TYPES
    ========================= */
    public function getEventTypes()
    {
        return response()->json([
            'status' => true,
            'data' => [
                ['key' => 'wedding',    'label' => 'Wedding'],
                ['key' => 'reception',  'label' => 'Reception'],
                ['key' => 'engagement', 'label' => 'Engagement'],
                ['key' => 'party',      'label' => 'Party'],
            ]
        ]);
    }


    /* =========================
       CHECK AVAILABILITY
    ========================= */
    public function checkAvailability(Request $request)
    {
        try {
            $property_id = $request->query('property_id');
            $date        = $request->query('date');
            $time_slot   = $request->query('time_slot');

            if (!$property_id || !$date || !$time_slot) {
                return response()->json([
                    'status'  => false,
                    'message' => 'property_id, date and time_slot required'
                ], 400);
            }

            $record = DB::table('property_availabilities')
                ->where('property_id', $property_id)
                ->where('date', $date)
                ->where('time_slot', $time_slot)
                ->first();

            if (!$record || $record->is_available == 1) {
                return response()->json([
                    'status'    => true,
                    'available' => true,
                    'message'   => 'Venue is available'
                ]);
            }

            return response()->json([
                'status'    => true,
                'available' => false,
                'message'   => 'Venue is not available'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
