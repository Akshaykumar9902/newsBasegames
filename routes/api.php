<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\OrganizationController;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Project Structure Apis

//Institution
Route::middleware('auth:api')->get('Institution',[InstitutionController::class, 'GetAllInstitution']);
Route::middleware('auth:api')->get('Institution/{id}',[InstitutionController::class, 'GetInstitutionWithId']);
Route::middleware('auth:api')->post('Institution',[InstitutionController::class, 'InstitutionInsert']);
Route::middleware('auth:api')->put('Institution',[InstitutionController::class, 'InstitutionUpdate']);
Route::middleware('auth:api')->delete('Institution/{id}',[InstitutionController::class, 'InstitutionDelete']);

//organization
Route::middleware('auth:api')->get('Organization',[InstitutionController::class, 'GetAllOrganization']);
Route::middleware('auth:api')->get('Organization/{id}',[InstitutionController::class, 'GetOrganizationWithId']);
Route::middleware('auth:api')->post('Organization',[InstitutionController::class, 'OrganizationInsert']);
Route::middleware('auth:api')->put('Organization',[InstitutionController::class, 'OrganizationUpdate']);
Route::middleware('auth:api')->delete('Organization/{id}',[InstitutionController::class, 'OrganizationDelete']);




//One to One relationship
Route::get('orgHasOne',[OrganizationController::class, 'hasOne']);
Route::get('orgbelongsTo',[OrganizationController::class, 'belongsTo']);
Route::get('EagerLoadingOrganization',[OrganizationController::class, 'EagerLoadingOrganization']);

//one to many relationship
Route::get('hasMany',[OrganizationController::class, 'hasMany']);

//login
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
     
Route::middleware('auth:api')->group( function () {
    Route::resource('products', ProductController::class);
});

//////////////////////////////////
Route::get('/roles', 'PermissionController@Permission');
