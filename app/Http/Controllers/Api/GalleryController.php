<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    /* =========================
       GET GALLERY LIST
    ========================= */
    public function list(Request $request)
    {
        try {
            $type = $request->query('type'); // optional filter

            $query = DB::table('gallery')
                ->select('id', 'image','video', 'type', 'created_at');

            if (!empty($type)) {
                $query->where('type', $type);
            }

            $data = $query
                ->orderBy('id', 'DESC')
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
}
