<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
});


Route::middleware('guest')->group(function () {
    //1) register
    Route::post('register', [RegisteredUserController::class, 'store']);

    //2) login
    // Login route defined first without auth middleware
    Route::post('login', [AuthenticatedSessionController::class, 'store']);



    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
//Catagory
Route::middleware('guest')->group(function () {
    Route::post('add-category',[CategoryController::class,'store']);
    Route::get('show-category',[CategoryController::class,'show']);
    Route::get('update-category/{id}',[CategoryController::class,'edit']);
    Route::post('update-category/{id}',[CategoryController::class,'update']);
    Route::post('delete-category/{id}',[CategoryController::class,'destroy']);
});

//Brandes
Route::middleware('guest')->group(function () {
    Route::post('add-brand',[BrandsController::class,'store']);
    Route::get('show-brand',[BrandsController::class,'show']);

});
//Product
Route::controller(App\Http\Controllers\ProductController::class)->group(function(){
    Route::post('add-product','store');
    Route::get('show-product','show');
    Route::get('product-detailes/{id}','ProductDetailes');
    Route::get('show-product-category/{id}','showproduct');
    Route::get('update-product/{id}','edit');
    Route::post('update-product/{id}','update');
    Route::delete('delete-product/{id}','destroy');

});
Route::controller(App\Http\Controllers\CartController::class)->group(function(){

    Route::post('add-to-cart','addtocart');
    Route::get('cart','Cart');
    Route::put('updatequantity/{cardId}/{scope}','updatequantity');
    Route::delete('delete-itemCard/{cardId}','deleteItem');
});

Route::controller(App\Http\Controllers\OrderController::class)->group(function(){

    Route::post('orders','orders');
    Route::get('/show-order','showorder');
    Route::get('order-detailes/{id}','orderdetailes');
    Route::get('sailesfilter','sailesfilter');
});
Route::controller(App\Http\Controllers\Wishlist::class)->group(function(){
    Route::get('/whislist/show', 'Wishlist');
    Route::post('/wishlist/add/', 'addtowishlist')->name('wishlist.add');
    Route::delete('/wishlist/remove/{$WishlistId}', 'deleteItem')->name('wishlist.remove');


});
