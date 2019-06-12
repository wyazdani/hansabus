<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function (){

    Route::resource('drivers', 'DriverController');
    Route::resource('/vehicles', 'VehicleController');

    Route::get('/vehicles/change-status/{Vehicle}', 'VehicleController@status');
    
	// Route::get('/vehicles', 'VehicleController@index')->name('vehicles');
    // Route::get('/vehicle-add', 'VehicleController@create')->name('vehicle-add');
    // Route::get('/vehicle-edit/{vehicle}', 'VehicleController@edit')->name('vehicle-edit');
    // Route::get('/vehicle-change-status/{vehicle}', 'VehicleController@status')->name('vehicle-status');
    // Route::post('/vehicle-store', 'VehicleController@store')->name('vehicle-store');
});





