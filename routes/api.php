<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::group(
    [
        'namespace' => 'Api',
        'middleware' => 'api',
    ],
    function () {
        Route::get('/gameInfoBySlug/{slug}', 'GameController@gameInfoBySlug');
        Route::post('/gameCheckPin', 'GameController@gameCheckPin');

        Route::post('/getTeamsByGameId', 'GameController@getTeamsByGameId');

        Route::post('/playerTeam', 'GameController@playerTeam');
        
    },
);

