<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\PermissionController;
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

// Route::get('/', function () {

//     // return view('hello');
//     return redirect('contact');
// });
Route::get('/', function () {
    return view('welcome');
});

Route::get('users/{user}', [Users::class, 'index']);
Route::get('user/{name}', [Usercontroller::class, 'index']);
Route::post('form', [Usercontroller::class, 'getData']);
Route::view('compo', 'users');
Route::view('noaccess', 'noaccess');
Route::group(['middleware' => ['protectedPage']], function () {
    Route::view('welcome', 'welcome');
    Route::view('contact', 'contact');
});
Route::view('home', 'home')->middleware('protectedPage');
Route::get('model',[Usercontroller::class, 'fetchdata']);
Route::get('httpclient',[Usercontroller::class,'HttpClient']);
 Route::view('login','login');



 Route::get('/roles', [PermissionController::class,'Permission']);
