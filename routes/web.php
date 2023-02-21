<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about','about');
Route::get('/name/{name}', function ($name) {
    return view('name',['name' => $name]);
});
Route::get('/user/{name}', [User::class,'showUsers']);
Route::get('/users', [UserController::class, 'getDate']);

//  user authentcation

Route::get('/login',[AuthController::class,'login_view'])->middleware('allReadyLogIn');
Route::get('/signup',[AuthController::class,'signup_view'])->middleware('allReadyLogIn');
Route::post('/signin',[AuthController::class,'signin_add']);
Route::post('/signup',[AuthController::class,'signup_add']);
Route::get('/dashboard',[AuthController::class,'dashbord_view'])->middleware('isLogin');
Route::get('/logout',[AuthController::class,'logout']);