<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*///->middleware('auth', App\Http\Middleware\Admin::class);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//======================= set role
Route::get('/role','RoleController@index');
Route::post('/role','RoleController@setRole');

//======================= app controller
Route::get('/apps','PackageController@index');
Route::post('/apps','PackageController@store');
Route::get('/apps/edit/{id}','PackageController@edit');
Route::post('/apps/edit/{id}','PackageController@update');

//======================= month controller
Route::get('/months/{id}','MonthController@index');
Route::post('/months','MonthController@store');
Route::get('/months/edit/{appId}/{monthId}','MonthController@edit');
Route::post('/months/edit/{id}','MonthController@update');

//======================= holiday controller
Route::get('/holidays/{id}','HolidayController@holidaylist');
Route::get('/createholiday/{id}','HolidayController@createholiday');
Route::post('/holidays','HolidayController@store');
Route::get('/holidays/edit/{id}','HolidayController@edit');
Route::post('/holidays/edit/{id}','HolidayController@update');

//======================= language controller
Route::get('/languages','LanguageController@index');
Route::post('/languages','LanguageController@store');
Route::post('/languages/ajax','LanguageController@ajax');
Route::get('/languages/edit/{id}','LanguageController@edit');
Route::post('/languages/edit/{id}','LanguageController@update');

View::composer('*', function ($view) {
    //
    if(\Auth::check()){
        $roleforview = \Auth::user()->roles_id;
        $view->with('roleforview',$roleforview);
    }
});