<?php

use App\Http\Resources\ProductRessource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Resources\CustomerRessource;
use App\Models\Customer;
use App\Http\Controllers\CustomerController;
use App\Http\Resources\ClaimRessource;
use App\Models\Claim;
use App\Http\Controllers\ClaimController;
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
//  --------------------------------------------Product--------------------------------------------------------------------
Route::get('/products',function(){
    return ProductRessource::collection(Product::all());
});

Route::get('product/{id}',function($id){
    return new ProductRessource(Product::findOrFail($id));
});

Route::post('/product',[ProductController::class, 'store']);

Route::put('/product/{id}',[ProductController::class, 'update']);

Route::delete('/product/{id}',[ProductController::class, 'destroy']);

//  --------------------------------------------Customer--------------------------------------------------------------------
Route::get('/customers',function(){
    return CustomerRessource::collection(Customer::all());
});

Route::get('customer/{id}',function($id){
    return new CustomerRessource(Customer::findOrFail($id));
});

Route::post('/customer',[CustomerController::class, 'store']);

Route::put('/customer/{id}',[CustomerController::class, 'update']);

Route::delete('/customer/{id}',[CustomerController::class, 'destroy']);
//  --------------------------------------------Claim--------------------------------------------------------------------
Route::get('/claims',function(){
    return ClaimRessource::collection(Claim::all());
});

Route::get('claim/{id}',function($id){
    return new ClaimRessource(Claim::findOrFail($id));
});

Route::post('/claim',[ClaimController::class, 'store']);

Route::put('/claim/{id}',[ClaimController::class, 'update']);

Route::delete('/claim/{id}',[ClaimController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
