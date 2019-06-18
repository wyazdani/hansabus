<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function (){


    /* drivers */
    Route::resource('drivers', 'DriverController');

    /* vehicle types */
    Route::resource('vehicle-type', 'VehicleTypeController');

    /* tuors */
    Route::resource('tours', 'ToursController');

    /* vehicles */
    Route::resource('/vehicles', 'VehicleController');
    Route::get('/vehicle-list', 'VehicleController@getList')->name('vehicle-list');
    Route::get('/vehicles/change-status/{Vehicle}', 'VehicleController@status')->name('vehicles.status-change');

    /* customers */
    Route::resource('customers', 'CustomerController');
    Route::get('/customer-list', 'CustomerController@getList')->name('customer-list');
    Route::get('/customers/change-status/{Customer}', 'CustomerController@status')->name('customers.status-change');


    Route::post('/file-upload', 'AttachmentController@uploadFiles')->name('file-upload');

});
