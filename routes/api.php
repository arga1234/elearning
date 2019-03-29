<?php

use Illuminate\Http\Request;

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


Route::group(['prefix' => 'v1','middleware' => 'auth'], function () {

});

Route::middleware('auth:api')->group(function() {
    Route::get('v1/logout', 'Api\v1\PassportController@logout');
    //comment
    Route::post('v1/comment/store', 'Api\v1\CommentController@store');
    Route::post('v1/comment/reply', 'Api\v1\CommentController@replyStore');
    Route::post('v1/comment/delete', 'Api\v1\CommentController@delete');

    //pendampingan
    Route::post('v1/pendampingan', 'Api\v1\PendampinganController@store');

});


//untuk versioning, nantinya endpoint akan seperti ini {{url}}/api/v1/login
Route::group(['prefix' => 'v1'], function () {
    //Auth routes
    Route::post('login', 'Api\v1\PassportController@login');
    Route::post('register', 'Api\v1\PassportController@register');

    Route::get('/school-gsm/user-trend', 'Api\v1\UsersController@userRegisteredChart');
    Route::get('/school-gsm', 'Api\v1\SchoolGsmController@get');
    Route::post('/school-gsm/store', 'Api\v1\SchoolGsmController@store');
    Route::delete('/school-gsm/delete', 'Api\v1\SchoolGsmController@delete');
    Route::get('/school-gsm/daerah', 'Api\v1\SchoolGsmController@getDaerah');
    Route::post('/school-gsm/per-daerah', 'Api\v1\SchoolGsmController@sekolahPerDaerah');
    Route::get('/school-gsm/map', 'Api\v1\SchoolGsmController@dataGraphMap');
    Route::get('/school-gsm/top', 'Api\v1\SchoolGsmController@topSekolahperDaerah');

    //article resources
    Route::post('/article/store', 'Api\v1\ArticleController@store');
    Route::get('/article', 'Api\v1\ArticleController@get');
    Route::post('/article/delete', 'Api\v1\ArticleController@delete');

   //User resources
   Route::get('/users', 'Api\v1\UsersController@all');
   Route::get('/users/test', 'Api\v1\UsersController@test');

   Route::get('/users/{id}', 'Api\v1\UsersController@get');

   //Modul resources
   Route::get('/modul/basic/all', 'Api\v1\ModulsController@getBasic');
   Route::get('/modul/advance/all', 'Api\v1\ModulsController@getAdvance');
   Route::post('/modul/upload', 'Api\v1\ModulsController@Upload');

   Route::post('/modul/basic', 'Api\v1\ModulsController@storeBasic');
   Route::post('/modul/advance', 'Api\v1\ModulsController@storeAdvance');
   Route::delete('/modul/{id}', 'Api\v1\ModulsController@remove');
   Route::post('/modul/{id}', 'Api\v1\ModulsController@edit');

    //Pendampingan resources
    Route::get('/pendampingan', 'Api\v1\PendampinganController@index');
    Route::get('/pendampingan/create', 'Api\v1\PendampinganController@create');
    Route::get('/pendampingan/{id}', 'Api\v1\PendampinganController@show');
    Route::put('/pendampingan/{id}', 'Api\v1\PendampinganController@update');

    //Reset password routes
    Route::group(['prefix' => 'password'], function() {
      Route::post('create', 'Api\v1\PasswordResetController@create');
      Route::get('find/{token}', 'Api\v1\PasswordResetController@find');
      Route::post('reset', 'Api\v1\PasswordResetController@reset');
    });

    //Admin scopes
    Route::group(['prefix' => 'admin'], function() {
      Route::post('login', 'Api\v1\PassportController@adminLogin');
      Route::middleware(['auth:api', 'scope:admin'])->group(function() {
        Route::get('logout', 'Api\v1\PassportController@logout');
        Route::get('user', 'Api\v1\AdminController@index');
        Route::get('user/{id}', 'Api\v1\AdminController@userById');
        Route::get('user/role/{role}', 'Api\v1\AdminController@userByRole');
        Route::post('user/role/{id}', 'Api\v1\AdminController@changeRole');
      });
    });
});

Route::group(['prefix' => 'api/v2'], function () {
  //reserved
});
