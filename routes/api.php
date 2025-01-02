<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\StatisticsController;
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

Route::group(['prefix' => 'specialties', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [SpecialtyController::class, 'create']);
    Route::put('/{id}', [SpecialtyController::class, 'update']);
    Route::delete('/{id}', [SpecialtyController::class, 'delete']);
    Route::get('/', [SpecialtyController::class, 'readAll']);
    Route::get('/paginated/read-all', [SpecialtyController::class, 'paginatedReadAll']);
    Route::get('/{id}', [SpecialtyController::class, 'readById']);
});

Route::group(['prefix' => 'types', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [TypeController::class, 'create']);
    Route::put('/{id}', [TypeController::class, 'update']);
    Route::delete('/{id}', [TypeController::class, 'delete']);
    Route::get('/', [TypeController::class, 'readAll']);
    Route::get('/paginated/read-all', [TypeController::class, 'paginatedReadAll']);
    Route::get('/{id}', [TypeController::class, 'readById']);
});

Route::group(['prefix' => 'cities', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [CityController::class, 'create']);
    Route::put('/{id}', [CityController::class, 'update']);
    Route::delete('/{id}', [CityController::class, 'delete']);
    Route::get('/', [CityController::class, 'readAll']);
    Route::get('/paginated/read-all', [CityController::class, 'paginatedReadAll']);
    Route::get('/{id}', [CityController::class, 'readById']);
});

Route::group(['prefix' => 'company', 'middleware' => ['auth:sanctum']], function(){
    Route::get('/', [CompanyController::class, 'read']);
    Route::put('/', [CompanyController::class, 'update']);
});

Route::group(['prefix' => 'employees', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [EmployeeController::class, 'create']);
    Route::put('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'delete']);
    Route::get('/', [EmployeeController::class, 'readAll']);
    Route::get('/read/all', [EmployeeController::class, 'readAllByRole']);
    Route::get('/paginated/read-all', [EmployeeController::class, 'paginatedReadAll']);
    Route::get('/roles/read-all', [EmployeeController::class, 'readAllRoles']);
    Route::get('/paginated/read-all-by-role', [EmployeeController::class, 'paginatedReadAllByRole']);
    Route::get('/{id}', [EmployeeController::class, 'readById']);
    Route::post('/print-employees-list', [EmployeeController::class, 'printEmployeesList']);
    Route::post('/print-employee-operations', [EmployeeController::class, 'printEmployeeOperations']);
    Route::post('/print-employee-controls', [EmployeeController::class, 'printEmployeeControls']);
});

Route::group(['prefix' => 'employees'], function(){
    Route::post('/authenticate', [EmployeeController::class, 'login']);
});

Route::group(['prefix' => 'lines', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [LineController::class, 'create']);
    Route::put('/{id}', [LineController::class, 'update']);
    Route::delete('/{id}', [LineController::class, 'delete']);
    Route::get('/', [LineController::class, 'readAll']);
    Route::get('/paginated/read-all', [LineController::class, 'paginatedReadAll']);
    Route::get('/{id}', [LineController::class, 'readById']);
});

Route::group(['prefix' => 'buses', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [BusController::class, 'create']);
    Route::put('/{id}', [BusController::class, 'update']);
    Route::delete('/{id}', [BusController::class, 'delete']);
    Route::get('/', [BusController::class, 'readAll']);
    Route::get('/paginated/read-all', [BusController::class, 'paginatedReadAll']);
    Route::get('/{id}', [BusController::class, 'readById']);
    Route::get('/qrcode/{qrcode}', [BusController::class, 'readByQrCode']);
    Route::post('/print-buses-list', [BusController::class, 'printBusesList']);
    Route::post('/print-bus-operations', [BusController::class, 'printBusOperations']);
});

Route::group(['prefix' => 'operations', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [OperationController::class, 'create']);
    Route::put('/{id}', [OperationController::class, 'update']);
    Route::delete('/{id}', [OperationController::class, 'delete']);
    Route::get('/', [OperationController::class, 'readAll']);
    Route::get('/paginated/read-all', [OperationController::class, 'paginatedReadAll']);
    Route::get('/{id}', [OperationController::class, 'readById']);
});

Route::group(['prefix' => 'recipes', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [RecipeController::class, 'create']);
    Route::post('/accounting', [RecipeController::class, 'accounting']);
    Route::put('/{id}', [RecipeController::class, 'update']);
    Route::delete('/{id}', [RecipeController::class, 'delete']);
    Route::get('/', [RecipeController::class, 'readAll']);
    Route::get('/paginated/read-all', [RecipeController::class, 'paginatedReadAll']);
    Route::get('/{id}', [RecipeController::class, 'readById']);
    Route::post('/print-recipe', [RecipeController::class, 'printRecipe']);
});

Route::group(['prefix' => 'controls', 'middleware' => ['auth:sanctum']], function(){
    Route::post('/', [ControlController::class, 'create']);
    Route::put('/{id}', [ControlController::class, 'update']);
    Route::delete('/{id}', [ControlController::class, 'delete']);
    Route::get('/', [ControlController::class, 'readAll']);
    Route::get('/paginated/read-all', [ControlController::class, 'paginatedReadAll']);
    Route::get('/{id}', [ControlController::class, 'readById']);
});

Route::group(['prefix' => 'statistics', 'middleware' => ['auth:sanctum']], function(){
    Route::get('/general', [StatisticsController::class, 'generalStatistics']);
    Route::get('/employees', [StatisticsController::class, 'employeeStatistics']);
    Route::get('/buses', [StatisticsController::class, 'busStatistics']);
    Route::get('/operations', [StatisticsController::class, 'operationStatistics']);
    Route::get('/revenue', [StatisticsController::class, 'revenueStatistics']);
});


