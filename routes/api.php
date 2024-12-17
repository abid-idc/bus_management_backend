<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\TypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'specialties'], function(){
    Route::post('/', [SpecialtyController::class, 'create']);
    Route::put('/{id}', [SpecialtyController::class, 'update']);
    Route::delete('/{id}', [SpecialtyController::class, 'delete']);
    Route::get('/', [SpecialtyController::class, 'readAll']);
    Route::get('/{id}', [SpecialtyController::class, 'readById']);
});

Route::group(['prefix' => 'types'], function(){
    Route::post('/', [TypeController::class, 'create']);
    Route::put('/{id}', [TypeController::class, 'update']);
    Route::delete('/{id}', [TypeController::class, 'delete']);
    Route::get('/', [TypeController::class, 'readAll']);
    Route::get('/{id}', [TypeController::class, 'readById']);
});

Route::group(['prefix' => 'cities'], function(){
    Route::post('/', [CityController::class, 'create']);
    Route::put('/{id}', [CityController::class, 'update']);
    Route::delete('/{id}', [CityController::class, 'delete']);
    Route::get('/', [CityController::class, 'readAll']);
    Route::get('/{id}', [CityController::class, 'readById']);
});

Route::group(['prefix' => 'company'], function(){
    Route::get('/', [CompanyController::class, 'read']);
    Route::put('/', [CompanyController::class, 'update']);
});

Route::group(['prefix' => 'employees'], function(){
    Route::post('/', [EmployeeController::class, 'create']);
    Route::put('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'delete']);
    Route::get('/', [EmployeeController::class, 'readAll']);
    Route::get('/{id}', [EmployeeController::class, 'readById']);
    Route::post('/authenticate', [EmployeeController::class, 'login']);
});

Route::group(['prefix' => 'lines'], function(){
    Route::post('/', [LineController::class, 'create']);
    Route::put('/{id}', [LineController::class, 'update']);
    Route::delete('/{id}', [LineController::class, 'delete']);
    Route::get('/', [LineController::class, 'readAll']);
    Route::get('/{id}', [LineController::class, 'readById']);
});

Route::group(['prefix' => 'buses'], function(){
    Route::post('/', [BusController::class, 'create']);
    Route::put('/{id}', [BusController::class, 'update']);
    Route::delete('/{id}', [BusController::class, 'delete']);
    Route::get('/', [BusController::class, 'readAll']);
    Route::get('/{id}', [BusController::class, 'readById']);
});

Route::group(['prefix' => 'operations'], function(){
    Route::post('/', [OperationController::class, 'create']);
    Route::put('/{id}', [OperationController::class, 'update']);
    Route::delete('/{id}', [OperationController::class, 'delete']);
    Route::get('/', [OperationController::class, 'readAll']);
    Route::get('/{id}', [OperationController::class, 'readById']);
});
