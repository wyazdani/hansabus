<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function (){

    Route::resource('drivers', 'DriverController');
    Route::resource('vehicles', 'VehicleController');
    Route::resource('vehicle-type', 'VehicleTypeController');
    Route::get('vehicle-type/index/data-table','VehicleTypeController@data_table_index')->name('vehicle-type.index.ajax');
    Route::resource('tours', 'ToursController');

});





