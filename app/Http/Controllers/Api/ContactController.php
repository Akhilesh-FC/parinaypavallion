<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{

    /* =========================
       GET CONTACT INFO
    ========================= */
    public function getContactInfo()
    {
        try {
            $contact = DB::table('contact_details')->first();

            $social = DB::table('social_links')
                ->select('facebook', 'instagram')
                ->first();

            return response()->json([
                'status' => true,
                'data' => [
                    'address' => $contact->address ?? null,
                    'phone'   => $contact->phone ?? null,
                    'email'   => $contact->email ?? null,
                    'social'  => $social
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /* =========================
       SEND MESSAGE
    ========================= */
    public function sendMessage(Request $request)
    {
        try {
            $name    = $request->name;
            $mobile  = $request->mobile;
            $email   = $request->email;
            $message = $request->message;

            if (!$name || !$mobile || !$email || !$message) {
                return response()->json([
                    'status'  => false,
                    'message' => 'All fields are required'
                ], 400);
            }

            DB::table('contact_messages')->insert([
                'name'       => $name,
                'mobile'     => $mobile,
                'email'      => $email,
                'message'    => $message,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Message sent successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
