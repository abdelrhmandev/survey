<?php
use Illuminate\Support\Facades\Route;
Route::group(
    [
        'prefix' => config('custom.route_prefix'),
        'namespace' => 'backend',
        'middleware' => 'auth:admin',
        'as' => 'admin.',
    ],
    function () {
        ######################### Start Dashboard #################################
        Route::get('/', 'DashboardController@index')->name('dashboard');
        ######################### End Dashboard ########################
        Route::resource('users', UserController::class)->except('show');
        Route::get('/{id}/EditUserPassword', 'UserController@editpassword')->name('users.editpassword');
        Route::put('update/UserPassword', 'UserController@updatepassword')->name('users.updatepassword');
        Route::delete('users/destroy/all', 'UserController@destroyMultiple')->name('users.destroyMultiple');
        ######################### End Users   ##########################

        ######################### Start Roles ##########################
        Route::resource('roles', RoleController::class)->except('show');
        Route::delete('roles/destroy/all', 'RoleController@destroyMultiple')->name('roles.destroyMultiple');
        ######################### End Roles ##########################

        ######################### Start Permissions ##########################
        Route::resource('permissions', PermissionController::class)->except('show');
        Route::delete('permissions/destroy/all', 'PermissionController@destroyMultiple')->name('permissions.destroyMultiple');
        ######################### End Permissions ##########################

        ######################### Start Questions ##########################


        
            Route::resource('questions', QuestionController::class)->except('show');            
            Route::post('questions/saveQCAnswer', 'QuestionController@saveQCAnswer')->name('saveQCAnswer');


            Route::get('questions/create/event/{id}', 'QuestionController@create')->name('Q');


            Route::delete('questions/destroy/all', 'QuestionController@destroyMultiple')->name('questions.destroyMultiple');
            ######################### End Questions ##########################

            ######################### Start Answers ##########################
            Route::resource('answers', AnswerController::class)->except('show');
            Route::delete('answers/destroy/all', 'AnswerController@destroyMultiple')->name('answers.destroyMultiple');
            ######################### End Answers ##########################

        

        ######################### Start teams ##########################
        Route::resource('teams', TeamController::class)->except('show');
        Route::delete('teams/destroy/all', 'TeamController@destroyMultiple')->name('teams.destroyMultiple');
        ######################### End teams ##########################

        ######################### Start Types ##########################
        Route::resource('types', TypeController::class)->except('show');
        Route::delete('types/destroy/all', 'TypeController@destroyMultiple')->name('types.destroyMultiple');
        ######################### End Types ##########################
                
        ######################### Start Events ##########################
        Route::resource('events', EventController::class)->except('show');
        Route::delete('events/destroy/all', 'EventController@destroyMultiple')->name('events.destroyMultiple');
        ######################### End Events ##########################


        ######################### Start Games ##########################
        Route::resource('games', GameController::class)->except('show');
        Route::delete('games/destroy/all', 'GameController@destroyMultiple')->name('games.destroyMultiple');
        ######################### End Games ##########################

        ######################### Start Profile ##########################
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', 'ProfileController@index')->name('profile');
            Route::get('/edit', 'ProfileController@edit')->name('profile.edit');
            Route::put('update', 'ProfileController@update')->name('profile.update');
            Route::get('/edit/password', 'ProfileController@editpassword')->name('profile.editpassword');
            Route::put('update/password', 'ProfileController@updatepassword')->name('profile.updatepassword');
        });
        ######################### End Profile ##########################

        ######################### Auth Routes #################################
        Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');
    },
);

Route::group(
    [
        'prefix' => config('custom.route_prefix'),
        'namespace' => 'backend',
        'middleware' => 'guest:admin',
        'as' => 'admin.',
    ],
    function () {
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
    },
);
