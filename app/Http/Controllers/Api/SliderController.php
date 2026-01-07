<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /* =========================
       GET ALL ACTIVE SLIDERS
    ========================= */
    public function list()
    {
        try {
            $sliders = DB::table('sliders')
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->get();

            return response()->json([
                'status' => true,
                'data'   => $sliders
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /* =========================
       CREATE SLIDER (TEMP / ADMIN USE)
    ========================= */
    public function create(Request $request)
    {
        try {
            $title = $request->title;
            $image = $request->image;
            $link  = $request->link;

            if (!$image) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Image is required'
                ], 400);
            }

            $id = DB::table('sliders')->insertGetId([
                'title'      => $title,
                'image'      => $image,
                'link'       => $link,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $slider = DB::table('sliders')->where('id', $id)->first();

            return response()->json([
                'status'  => true,
                'message' => 'Slider created',
                'data'    => $slider
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
