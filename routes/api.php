<?php

use App\Models\Cmodel;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CbrandController;
use App\Http\Controllers\CmodelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomtypeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::post('/login',[AuthController::class,'login']);
// Route::post('/register',[AuthController::class,'register']);
// Route::post('/logout',[AuthController::class,'logout']);



Route::get('cars/car_offers',[CarController::class,'car_offers']);
Route::get('cars/{id}',[CarController::class,'show']);
Route::get('cbrands',[CbrandController::class,'index']);
Route::get('cmodels',[CmodelController::class,'index']);
Route::get('cmodels/findBrand/{id}',[CmodelController::class,'findBrand']);
Route::get('cities',[CityController::class,'index']);
Route::post('reservations',[ReservationController::class,'store']);


Route::get('/restaurants/{id}/table-types', [RestaurantController::class, 'getTableTypes']);
Route::get('/cuisines/cuisines/cuisines', [RestaurantController::class,"getCuisine"]);
Route::get('/restaurants/restaurant_offers', [RestaurantController::class,"restaurant_offers"]);
Route::get('/cities', [RestaurantController::class,"getCities"]);
Route::get('/restaurants/{id}', [RestaurantController::class,"show"]);
Route::post('/reservations', [RestaurantController::class,"store"]);
Route::post('/reservations/store_table',[ReservationController::class,'storeTableReservation']);

Route::get('/hotels', [HotelController::class, 'index']);
Route::get('hotels/hotel_offers',[HotelController::class,'hotel_offers']);
Route::get('hotels/{id}',[HotelController::class,'show']);
Route::get('/roomtypes/name', [RoomtypeController::class, 'index']);
// Route::get('/roomtypes/get', [RoomtypeController::class, 'getRoomTypes']);
Route::get('/hotels', [HotelController::class, 'getHotelsByStars']);
Route::post('/reservation/storeTableHotel', [ReservationController::class, 'storeTableHotel']);
