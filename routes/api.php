<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\HallController;
use App\Http\Controllers\Api\LawnController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\VenueController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\PolicyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\RatingController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/test', function () {
    return response()->json(['status' => true]);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/gallery-list', [GalleryController::class, 'list']);


Route::get('/venues-dropdown', [PropertyController::class, 'getVenuesForDropdown']);
Route::get('/event-types', [PropertyController::class, 'getEventTypes']);
Route::get('/check-availability', [PropertyController::class, 'checkAvailability']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/add-remove-cart', [BookingController::class, 'addRemoveCart']);
    Route::post('/my-cart', [BookingController::class, 'myCart']);
    Route::post('/confirm-booking', [BookingController::class, 'confirmBookingFromCart']);

});

Route::middleware('auth:sanctum')->post(
    '/checkout',
    [BookingController::class, 'checkout']
);
Route::post('/payment/paytm-success', [BookingController::class, 'paytmSuccess']);




Route::get('/contact-info', [ContactController::class, 'getContactInfo']);
Route::post('/contact-message', [ContactController::class, 'sendMessage']);



Route::get('/halls', [HallController::class, 'listHalls']);



Route::get('/lawns', [LawnController::class, 'listLawns']);
Route::get('/lawns/{id}', [LawnController::class, 'getLawnDetails']);



Route::get('/properties', [PropertyController::class, 'list']);
Route::get('/properties-count', [PropertyController::class, 'countProperties']);
Route::get('/properties/{id}', [PropertyController::class, 'show']);




Route::get('/rooms', [RoomController::class, 'listRooms']);


Route::get('/services', [ServiceController::class, 'list']);
Route::get('/featured-venues', [VenueController::class, 'featuredVenueList']);



Route::get('/sliders', [SliderController::class, 'list']);
Route::post('/sliders/create', [SliderController::class, 'create']); // temp/admin




Route::get('/terms-conditions-html', [PolicyController::class, 'termsHtml']);
Route::get('/cancellation-policy-html', [PolicyController::class, 'cancellationHtml']);
Route::get('/privacy-policy-html', [PolicyController::class, 'privacyHtml']);




// dropdown
Route::get('/venues', [AvailabilityController::class, 'getVenuesForDropdown']);

// event types
Route::get('/event-types', [AvailabilityController::class, 'getEventTypes']);

// check availability
Route::get('/check-availability', [AvailabilityController::class, 'checkAvailability']);


Route::post('/property/rate', [RatingController::class, 'rateProperty']);
Route::get('/property/ratings', [RatingController::class, 'getPropertyRatings']);












