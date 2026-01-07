<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /* =========================
       GET ALL ACTIVE SERVICES
    ========================= */
    public function list()
    {
        try {
            $services = DB::table('services')
                ->where('status', 1)
                ->orderBy('id', 'ASC')
                ->get();

            return response()->json([
                'status' => true,
                'data'   => $services
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
