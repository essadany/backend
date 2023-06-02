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
use App\Models\User;
use App\Http\Resources\UserRessource;
use App\Http\Controllers\UserController;
use App\Models\Action;
use App\Http\Resources\ActionRessource;
use App\Http\Controllers\ActionController;
use App\Models\ActionUser;
use App\Http\Resources\ActionUserRessource;
use App\Models\Team;
use App\Http\Resources\TeamRessource;
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


//  --------------------------------------------Users--------------------------------------------------------------------
Route::get('/users',function(){
    return UserRessource::collection(User::all());
});

Route::get('user/{id}',function($id){
    return new UserRessource(User::findOrFail($id));
});
Route::post('/user',[UserController::class, 'store']);

Route::put('/user/{id}',[UserController::class, 'update']);

Route::delete('/user/{id}',[UserController::class, 'destroy']);
//  --------------------------------------------Actions--------------------------------------------------------------------
Route::get('/actions',function(){
    return ActionRessource::collection(Action::all());
});

Route::get('action/{id}',function($id){
    return new ActionRessource(Action::findOrFail($id));
});
Route::post('/action',[ActionController::class, 'store']);

Route::put('/action/{id}',[ActionController::class, 'update']);

Route::delete('/action/{id}',[ActionController::class, 'destroy']);
//--------------------------------------------Actions--------------------------------------------------------------------
Route::get('/action_users',function(){
    return ActionUserRessource::collection(ActionUser::all());
});

Route::get('action_users/{id}',function($id){
    return new ActionUserRessource(ActionUser::findOrFail($id));
});
//--------------------------------------------Team--------------------------------------------------------------------
Route::get('/teams',function(){
    return TeamRessource::collection(ActionUser::all());
});

Route::get('team/{id}',function($id){
    return new TeamRessource(Team::findOrFail($id));
});
//--------------------------------------------Team--------------------------------------------------------------------






Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
