<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // 🔹 Show all users
    public function index()
    {
        $users = DB::table('users')
            ->select('id', 'name', 'email', 'mobile', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('users.index', compact('users'));
    }
}
