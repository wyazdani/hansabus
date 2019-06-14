<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function (){

    Route::resource('drivers', 'DriverController');
//    Route::resource('/vehicle-type', 'VehicleTypeController');
    Route::resource('/vehicles', 'VehicleController');
    Route::get('/vehicle-list', 'VehicleController@getList');
    Route::get('/vehicles/change-status/{Vehicle}', 'VehicleController@status')->name('vehicles.status-change');


    /*Route::get('/vehicle-list', function() {

        $model = App\User::query();

        return DataTables::eloquent($model)
            ->addColumn('intro', function(User $user) {
                return 'Hi ' . $user->name . '!';
            })
            ->toJson();
    });*/



    Route::resource('customers', 'CustomerController');
    Route::get('/customers/change-status/{Customer}', 'CustomerController@status')->name('customers.status-change');

});




