<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register',[ApiController::class,'register']);
Route::post('forget-password',[ApiController::class,'forget_password']);
Route::post('verify-account',[ApiController::class,'verifyAccount']);
Route::post('verify-otp',[ApiController::class,'verifyOtp']);
Route::post('login',[ApiController::class,'login']);
Route::get('list-settings',[ApiController::class,'get_settings']);
Route::get('list-slider',[ApiController::class,'sliderList']);
Route::get('list-category',[ApiController::class,'categoryList']);
Route::get('list-product',[ApiController::class,'productList']);
Route::post('cart-details',[ApiController::class,'store_cart_details']);
Route::post('list-product-by-category-id',[ApiController::class,'getProductByCategoryId']);
Route::post('get-product-by-id',[ApiController::class,'getProductById']);
Route::post('product-search',[ApiController::class,'product_search']);
Route::post('get-related-products',[ApiController::class,'get_related_products']);
//Route::post('get-product-filters',[ApiController::class,'get_product_filters']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('profile',[ApiController::class,'userProfile']);
    Route::post('get_addresses',[ApiController::class,'userAddresses']);
    Route::post('store-user-address',[ApiController::class,'store_user_address']);
    Route::post('update-profile',[ApiController::class,'update_profile']);
    Route::post('place-order',[ApiController::class,'place_order']);
});
