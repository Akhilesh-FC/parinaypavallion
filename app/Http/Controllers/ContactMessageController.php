<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactMessageController extends Controller
{
    /* =========================
       CONTACT MESSAGES LIST
    ========================== */
    public function index()
    {
        $messages = DB::table('contact_messages')
            ->select('id', 'name', 'mobile', 'email', 'message', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('contact_messages.index', compact('messages'));
    }

    /* =========================
       DELETE MESSAGE
    ========================== */
    public function delete($id)
    {
        DB::table('contact_messages')->where('id', $id)->delete();

        return back()->with('success', 'Message deleted successfully');
    }
}
