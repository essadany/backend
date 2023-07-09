<?php

use Illuminate\Support\Facades\Route;
use App\Mail\SendMail;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('images/{filename}', function ($filename) {
    $path = storage_path('app/images/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->where('filename', '.*');

Route::get('/send-email', [MailController::class,'index']);

