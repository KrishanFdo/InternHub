<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return redirect('/login');
})->middleware('guest');

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::get('/register', function () {
    return view('register');
})->middleware('guest');

Route::get('/home', function () {
    return view('home');
})->middleware('auth:webadmin');


Route::post('/register-submit',[RegisterController::class,'register']);
Route::get('/admin-accept',[RegisterController::class,'admin_accept'])->middleware('auth:webadmin');
Route::get('/filtered-registers', [RegisterController::class,'filtered_registers'])->middleware('auth:webadmin');
Route::delete('/delete-register',[RegisterController::class,'delete_register'])->middleware('auth:webadmin');

Route::post('/accept',[UserController::class,'accept'])->middleware('auth:webadmin');
Route::get('/users',[UserController::class,'users'])->middleware('auth:webadmin');
Route::get('/members',[UserController::class,'members'])->middleware('auth:web');
Route::delete('/delete-user',[UserController::class,'delete_user'])->middleware('auth:webadmin');
Route::get('/filtered-users', [UserController::class,'filtered_users'])->middleware('auth:webadmin');
Route::get('/filtered-members', [UserController::class,'filtered_members'])->middleware('auth:web');
Route::post('/update-user-password',[UserController::class,'update_user_password'])->middleware('auth:web');


Route::post('/authenticate',[LoginController::class,'authenticate']);
Route::post('/logout',[LoginController::class,'logout']);
Route::post('/adminlogout',[LoginController::class,'adminlogout']);

Route::get('/export-users',[ExportController::class,'exportFilteredUsers'])->middleware('auth:webadmin');
