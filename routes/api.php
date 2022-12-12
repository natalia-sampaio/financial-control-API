<?php

use App\Http\Controllers\Api\ExpenseReportController;
use App\Http\Controllers\Api\IncomeReportController;
use App\Http\Controllers\Api\SummaryController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/income', IncomeReportController::class);
    Route::apiResource('/expense', ExpenseReportController::class);

    Route::get('/income/{year}/{month}', [IncomeReportController::class, 'showIncomeOfTheMonth']);
    Route::get('/expense/{year}/{month}', [ExpenseReportController::class, 'showExpenseOfTheMonth']);
    Route::get('/summary/{year}/{month}',[SummaryController::class, 'showSummaryOfTheMonth']);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only(['email', 'password']);
    if (Auth::attempt($credentials) === false) {
        return response()->json('Unauthorized', 401);
    }

    $user = Auth::user();
    $token = $user->createToken('token');

    return response()->json($token->plainTextToken);
});

Route::post('/register', [UsersController::class, 'store']);