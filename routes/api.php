<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::group(
    [
        'namespace' => 'Api',
        'middleware' => 'api',
    ],
    function () {
        Route::get('/gameInfoBySlug/{slug}', 'GameController@gameInfoBySlug');
        Route::post('/gameCheckPin', 'GameController@gameCheckPin');
    },
);

Route::group(
    [
        'namespace' => 'Api',
        'middleware' => 'jwt.verify',
    ],
    function () { 
        Route::post('/getTeamsByGameId', 'GameTeamController@getTeamsByGameId');
        Route::post('/playerTeam', 'PlayerTeamController@playerTeam');
        Route::post('/playerQuestion', 'QuestionController@playerQuestion');
        Route::post('/playerPostAnswer', 'AnswerController@playerPostAnswer');    
    },
);
