<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /* =========================
       REGISTER
    ========================= */
    public function register(Request $request)
    {
        try {
            $rules = [
                'name'     => 'required|string',
                'password' => [
                    'required',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/'
                ]
            ];

            if ($request->email) {
                $rules['email'] = 'required|email|unique:users,email';
            } else {
                $rules['mobile'] = 'required|unique:users,mobile';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'mobile'   => $request->mobile,
                'password' => Hash::make($request->password),
            ]);

            // ✅ TOKEN (7 days similar behavior)
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'  => true,
                'message' => 'Registration successful',
                'token'   => $token,
                'user'    => [
                    'id'         => $user->id,
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'mobile'     => $user->mobile,
                    'created_at'=> $user->created_at
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
       LOGIN
    ========================= */
    public function login(Request $request)
    {
        try {
            if ((!$request->email && !$request->mobile) || !$request->password) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Email/mobile and password required'
                ], 400);
            }

            $user = User::where(
                $request->email ? 'email' : 'mobile',
                $request->email ?? $request->mobile
            )->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token'  => $token,
                'user'   => [
                    'id'     => $user->id,
                    'name'   => $user->name,
                    'email'  => $user->email,
                    'mobile' => $user->mobile
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
