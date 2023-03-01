<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//  Controllers
use App\Http\Controllers\Api\RatesController;
use App\Http\Controllers\Api\CurrenciesController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('currencies', [CurrenciesController::class, 'index']);

Route::get('rates/date/{date}/{base}', [RatesController::class , 'date']);
Route::post('rates/save', [RatesController::class , 'save']);
