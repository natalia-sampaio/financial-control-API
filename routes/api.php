<?php

use App\Http\Controllers\Api\ExpenseReportController;
use App\Http\Controllers\Api\IncomeReportController;
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

Route::apiResource('/income', IncomeReportController::class);
Route::apiResource('/expense', ExpenseReportController::class);

Route::get('/income/{year}/{month}', [IncomeReportController::class, 'showIncomeOfTheMonth']);
Route::get('/expense/{year}/{month}', [ExpenseReportController::class, 'showExpenseOfTheMonth']);
Route::get('/summary/{year}/{month}', [IncomeReportController::class, 'showSummaryOfTheMonth']);