<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /* ==========================
       PAY-IN DETAILS (USER + PROPERTY)
    =========================== */
    public function index()
    {
        $payments = DB::table('payments as pay')
            ->leftJoin('users as u', 'u.id', '=', 'pay.user_id')
            ->leftJoin('bookings as b', 'b.id', '=', 'pay.booking_id')
            ->leftJoin('properties as p', 'p.id', '=', 'pay.properties_id')
            ->select(
                'pay.id',
                'pay.amount as paid_amount',
                'pay.payment_gateway',
                'pay.transaction_id',
                'pay.payment_status',
                'pay.created_at',

                'u.id as user_id',
                'u.name as user_name',
                'u.email',
                'u.mobile',

                'p.name as property_name',
                'p.base_price as property_price',

                'b.booking_date',
                'b.guest_count'
            )
            ->orderBy('pay.id', 'desc')
            ->get();

        return view('payments.index', compact('payments'));
    }
    
    
    /* ==========================
   USER BANK DETAILS LIST
========================== */
public function userBankDetails()
{
    $banks = DB::table('user_bank_details as ub')
        ->leftJoin('users as u', 'u.id', '=', 'ub.user_id')
        ->select(
            'ub.*',
            'u.name as user_name',
            'u.email',
            'u.mobile'
        )
        ->orderBy('ub.id','desc')
        ->get();

    return view('payments.user-bank-details', compact('banks'));
}

}
