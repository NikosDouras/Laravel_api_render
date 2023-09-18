<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GamesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Protected routes


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('my_games', GamesController::class);
    Route::get('all_games', [GamesController::class, 'allGames']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('my_games/{id}', 'GameController@destroy');
    Route::delete('all_games/{id}', [GamesController::class, 'admin_destroy']);

});


