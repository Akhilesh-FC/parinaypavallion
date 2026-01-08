<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckUserSession;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\PropertyRatingController;
use App\Http\Controllers\PaymentController;


// Error Route
Route::get('/error', function () {
    abort(500);
});

Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

Route::middleware([CheckUserSession::class])->group(function () {
	
// ======================== AuthController ========================
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
Route::get('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/users', [UserController::class, 'index'])->name('users.list');

/* -------- SLIDERS -------- */
Route::get('/sliders', [SettingController::class, 'sliders'])->name('sliders');
Route::post('/sliders/update/{id}', [SettingController::class, 'updateSlider'])->name('sliders.update');

// Contact Details
Route::get('/contact-details', [SettingController::class, 'contactDetails'])->name('contact_details');
Route::post('/contact-details/update/{id}', [SettingController::class, 'updateContactDetails'])->name('contact_details.update');
    
// Bookings
Route::get('/bookings', [BookingController::class, 'bookings'])->name('bookings');
Route::post('/bookings/update/{id}', [BookingController::class, 'updateBooking'])->name('bookings.update');

/* -------- GALLERY -------- */
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::post('/gallery/update/{id}', [GalleryController::class, 'update'])->name('gallery.update');
Route::post('/gallery/store', [GalleryController::class, 'store'])->name('gallery.store');
Route::get('/gallery/delete/{id}', [GalleryController::class, 'delete'])->name('gallery.delete');


  
/* -------- PROPERTIES -------- */
Route::get('/properties/halls', [PropertyController::class, 'halls'])->name('properties.halls');
Route::post('/properties/halls/update/{id}', [PropertyController::class, 'updateHall'])->name('properties.halls.update');
Route::post('/properties/halls/store',[PropertyController::class,'storeHall'])->name('properties.halls.store');

    
/* -------- LAWNS -------- */
Route::get('/properties/lawns', [PropertyController::class, 'lawns'])->name('properties.lawns');

Route::post('/properties/lawns/update/{id}', [PropertyController::class, 'updateLawn'])->name('properties.lawns.update');

Route::post('/properties/lawns/store', [PropertyController::class, 'storeLawn'])->name('properties.lawns.store');

/* -------- ROOMS -------- */
Route::get('/properties/rooms', [PropertyController::class, 'rooms'])->name('properties.rooms');

Route::post('/properties/rooms/store', [PropertyController::class, 'storeRoom'])->name('properties.rooms.store');

Route::post('/properties/rooms/update/{id}', [PropertyController::class, 'updateRoom'])->name('properties.rooms.update');

// Social Links
Route::get('/settings/social-links', [SettingController::class, 'socialLinks'])->name('social.links');
Route::post('/settings/social-links/update/{id}', [SettingController::class, 'updateSocialLinks'])->name('social.links.update');

// Contact Messages
Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact.messages');
Route::get('/contact-messages/delete/{id}', [ContactMessageController::class, 'delete'])->name('contact.messages.delete');

// Property Ratings
Route::get('/property-ratings', [PropertyRatingController::class, 'index'])->name('property.ratings');

/* ========= PAYMENTS / PAY-IN ========= */
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/user-bank-details', [PaymentController::class, 'userBankDetails'])->name('user.bank.details');





});
