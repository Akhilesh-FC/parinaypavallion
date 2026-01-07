<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PolicyController extends Controller
{
    /* =========================
       TERMS & CONDITIONS (HTML)
    ========================= */
    public function termsHtml()
    {
        $policy = DB::table('policies')->first();

        $html = '
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Terms & Conditions</title>
        </head>
        <body>
            <h2>TERMS AND CONDITIONS</h2>
            <p>' . ($policy->terms_conditions ?? '') . '</p>
        </body>
        </html>';

        return response($html, 200)
            ->header('Content-Type', 'text/html');
    }


    /* =========================
       CANCELLATION POLICY (HTML)
    ========================= */
    public function cancellationHtml()
    {
        $policy = DB::table('policies')->first();

        $html = '
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Cancellation Policy</title>
        </head>
        <body>
            <h2>CANCELLATION RULES</h2>
            <p>' . ($policy->cancellation_rules ?? '') . '</p>
        </body>
        </html>';

        return response($html, 200)
            ->header('Content-Type', 'text/html');
    }


    /* =========================
       PRIVACY POLICY (HTML)
    ========================= */
    public function privacyHtml()
    {
        $policy = DB::table('policies')->first();

        $html = '
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Privacy Policy</title>
        </head>
        <body>
            <h2>PRIVACY POLICY</h2>
            <p>' . ($policy->privacy_policy ?? '') . '</p>
        </body>
        </html>';

        return response($html, 200)
            ->header('Content-Type', 'text/html');
    }
}
