<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function (){

    Route::resource('drivers', 'DriverController');
    Route::resource('vehicles', 'VehicleController');
    Route::resource('vehicle-type', 'VehicleTypeController');
    Route::resource('tours', 'ToursController');

});





