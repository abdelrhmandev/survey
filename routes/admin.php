<?php
use Illuminate\Support\Facades\Route;
        Route::group([
        'prefix' => config('custom.route_prefix'),
        'namespace' => 'backend',
        'middleware' => 'auth:admin',
        'as'=>'admin.'
        ], function () {

                ######################### Start Dashboard #################################
                Route::get('/', 'DashboardController@index')->name('dashboard');
                ######################### End Dashboard ########################
                // Route::resource('users', UserController::class)->except('show');
                // Route::delete('users/destroy/all', 'UserController@destroyMultiple')->name('users.destroyMultiple');
                ######################### End Users   ##########################


                ######################### Start Roles ##########################
                // Route::resource('roles', RoleController::class)->except('show');
                // Route::delete('roles/destroy/all', 'RoleController@destroyMultiple')->name('roles.destroyMultiple');
                ######################### End Roles ##########################
                
                ######################### Start Permissions ##########################
                // Route::resource('permissions', PermissionController::class)->except('show');
                // Route::delete('permissions/destroy/all', 'RecipeController@destroyMultiple')->name('permissions.destroyMultiple');
                ######################### End Permissions ##########################   



});


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

                  Route::group(['prefix' => 'email'], function () {
                    Route::get('/verify', 'Auth\VerificationController@show')->name('auth.verification.notice');
                    Route::get('/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('auth.verification.verify'); // v6.x
                    Route::get('/resend', 'Auth\VerificationController@resend')->name('auth.verification.resend');
                });

                #########################  Start Password Reset Routes ######################### 
                Route::group(['prefix' => 'password'], function () {
                  Route::get('/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.request');
                  Route::post('/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.email');
                  Route::get('/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('auth.password.reset');
                  Route::post('/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.update');
              });
              #########################  End Password Reset Routes ###########################




            });