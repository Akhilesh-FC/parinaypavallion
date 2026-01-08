<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    
public function showLoginForm() {
    if (session()->has('admin_logged_in') && session('admin_logged_in') === true) {
        return redirect()->route('admin.dashboard');
        }
        return view('login');
}
    



public function login(Request $request)
{
    $email = $request->input('email');     // form se email
    $password = $request->input('password'); // form se password

    // admins table se user fetch
    $admin = DB::table('admins')
        ->where('email', $email)
        ->where('password', $password) // plain password match
        ->first();

    if ($admin) {
        // session set
        session(['admin_logged_in' => true]);
        session(['admin_user' => $admin]);

        return redirect()->route('admin.dashboard');
    }

    return back()->with('error', 'Invalid email or password');
}


    
//     public function dashboard(){
//     $activeUsers = DB::table('users')->where('status', 1)->count();
//     $inactiveUsers = DB::table('users')->where('status', 0)->count();
//     $vendors = DB::table('users')->where('role_id', 2)->count();
//     $totalDeposit = DB::table('payins')->where('status', 2)->sum('amount');
//     $today = Carbon::today();
//     // auth condtion
//       $user = session('admin_user');
//       $authid = $user->id;
//       $authrole = $user->role_id;
//       $vendor_request = null;
//       if ($authrole == 2 || $authrole == 3) {
//       $getid = [];
// 			$level1 = DB::table('users')->where('referrer_id', $authid)->get();
// 			foreach ($level1 as $user1) {
// 				$getid[] = $user1->id;
// 				$level2 = DB::table('users')->where('referrer_id', $user1->id)->get();
// 				foreach ($level2 as $user2) {
// 					$getid[] = $user2->id;

// 					$level3 = DB::table('users')->where('referrer_id', $user2->id)->get();
// 					foreach ($level3 as $user3) {
// 						$getid[] = $user3->id;
// 					}
// 				}
// 			}
// 		$activeUsers = DB::table('users')->whereIn('id', $getid)->count();
// 	    $vendor_request = DB::table('vendor_request')->where('status', 1)->where('vendor_id', $authid)->count();

// 		}

//     $todayDeposit = DB::table('payins')->where('status', 2)->whereDate('created_at', $today)->sum('amount');
//     $totalWithdraw = DB::table('withdraw_histories')->where('status', 2)->sum('amount');
//     $todayWithdraw = DB::table('withdraw_histories')->where('status', 2)->whereDate('created_at', $today)->sum('amount');
//     $liveGameCount = DB::table('game')->count();
//       return view('dashboard')
//         ->with('vendors', $vendors)
//         ->with('activeUsers', $activeUsers)
//         ->with('inactiveUsers', $inactiveUsers)
//         ->with('totalDeposit', $totalDeposit)
//         ->with('todayDeposit', $todayDeposit)
//         ->with('totalWithdraw', $totalWithdraw)
//         ->with('todayWithdraw', $todayWithdraw)
//         ->with('authrole', $authrole)
// 		  ->with('vendor_request', $vendor_request)
//         ->with('liveGameCount', $liveGameCount);
// }

public function dashboard()
{
    // 🔒 session se admin user (optional)
    $user = session('admin_user');

    // 🔹 COUNTS
    $activeUsers = DB::table('users')->count();
    $booking     = DB::table('bookings')->count(); 
    $totalDeposit = DB::table('payments')->sum('amount'); // assuming amount column
    $gallery     = DB::table('gallery')->count();
    
    // 🔹 PROPERTY TYPE COUNTS
    $lawns = DB::table('properties')
        ->where('type', 'lawn')
        ->count();

    $halls = DB::table('properties')
        ->where('type', 'hall')
        ->count();
        
     $rooms = DB::table('properties')
        ->where('type', 'room')
        ->count();        

    $sliders = DB::table('sliders')->count();
    $carts   = DB::table('carts')->count();

    // // 🔹 OPTIONAL / DEFAULT VALUES
    // $vendors = DB::table('vendors')->count(); // agar vendors table hai
    // $vendor_request = DB::table('vendors')->where('status', 0)->count();

    $todayDeposit = DB::table('payments')
        ->whereDate('created_at', today())
        ->sum('amount');

    // $totalWithdraw = DB::table('withdraws')->sum('amount');
    // $todayWithdraw = DB::table('withdraws')
    //     ->whereDate('created_at', today())
    //     ->sum('amount');

    $liveGameCount = 0; // agar game table nahi hai abhi
    $authrole = 1; // admin role

    return view('dashboard', compact(
       // 'vendors',
        'activeUsers',
        'booking',
        'todayDeposit',
        // 'totalWithdraw',
        // 'todayWithdraw',
        'authrole',
       // 'vendor_request',
        'liveGameCount',
        'gallery',
        'lawns',
        'halls',
        'rooms',
        'sliders',
        'carts',
        'totalDeposit'
    ));
}


    public function logout() {
        
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
}