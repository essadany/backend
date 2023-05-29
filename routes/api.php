<?php

use App\Http\Resources\ProductRessource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
Route::get('/products',function(){
    return ProductRessource::collection(Product::all());
});

Route::get('product/{id}',function($id){
    return new ProductRessource(Product::findOrFail($id));
});

Route::post('/product',[ProductController::class, 'store']);

Route::put('/product/{id}',[ProductController::class, 'update']);

Route::delete('/product/{id}',[ProductController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
