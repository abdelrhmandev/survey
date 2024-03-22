<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::group(['namespace' => 'Api', 'middleware' => 'api'], function () {
    Route::get('/gameInfoBySlug/{slug}', 'GameController@gameInfoBySlug');
    Route::post('/gameCheckPin', 'GameController@gameCheckPin');
});

///////////////////////////////////////////Admin End Points ///////////////////////////
Route::group(['namespace' => 'Api', 'middleware' => 'api'], function () {
    Route::group(['prefix' => 'Admin', 'namespace' => 'backend'], function () {
        Route::post('/StartPlay', 'ManageController@CheckgameAuthor');
        Route::post('/NextQuestion', 'ManageController@NextQuestion');
        Route::post('/Winnerslist', 'ManageController@Winnerslist');
    });
});

/////////////////////////////////////////////////////////////////////////////////////////////
Route::group(['namespace' => 'Api', 'middleware' => 'jwt.verify'], function () {
    Route::post('/getTeamsByGameId', 'GameTeamController@getTeamsByGameId');
    Route::post('/playerTeam', 'PlayerTeamController@playerTeam');
    Route::post('/playerQuestion', 'QuestionController@playerQuestion');
    Route::post('/playerPostAnswer', 'AnswerController@playerPostAnswer');
});
