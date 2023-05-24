<?php

use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes(); 

// ADMIN
Route::middleware(['auth'])->group(function(){
    Route::get('/dokumen', [CommonController::class, 'dokumen']);
    Route::post('/dokumen/add', [CommonController::class, 'dokumen_add']);
    Route::get('/dokumen/history', [CommonController::class, 'history']);
    Route::get('/dokumen/hapus/{id}', [CommonController::class, 'hapus']);
    Route::get('/profile', [CommonController::class, 'profile']);
    Route::post('/profile/update', [CommonController::class, 'user_update']); 
});

// USER / GUEST
Route::get('/', [CommonController::class, 'home']);  
Route::get('/dokumen/check', [CommonController::class, 'check']);


// TESTING
Route::get('/testt', [CommonController::class, 'test']);
Route::get('/phpinfo', [CommonController::class, 'phpinfo']);

