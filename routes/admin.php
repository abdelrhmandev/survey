<?php
use Illuminate\Support\Facades\Route;
        Route::group([
        'prefix' => config('custom.route_prefix'),
        'namespace' => 'backend',
        'middleware' => 'guest:admin',
        'as'=>'admin.'
        ], function () {

            ######################### Start Auth Guest Routes #################################
            Route::group(['prefix' => 'login'], function () {
               /////////////
                 Route::get('/', 'Auth\LoginController@showLoginForm')->name('auth.login');
                 Route::post('/', 'Auth\LoginController@login')->name('auth.login.submit');
            });
            #########################  End Password Reset Routes ########################### 
});