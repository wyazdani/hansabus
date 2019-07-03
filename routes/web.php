<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function (){

    /*invoices*/
    Route::get('/tour-invoices', 'TourInvoiceController@index')->name('tour-invoices');
    Route::get('/tour-invoices/create', 'TourInvoiceController@create')->name('tour-invoice-create');
    Route::get('/tour-invoices-list', 'TourInvoiceController@getList')->name('tour-invoices-list');
    Route::get('/mark-as-paid', 'TourInvoiceController@markAsPaid')->name('mark-as-paid');
    Route::get('/download-tours-invoice', 'TourInvoiceController@downloadInvoice')->name('download-tours-invoice');
    Route::post('/generate-tour-invoice', 'TourInvoiceController@generateInvoice')->name('generate-tour-invoice');

    /* Hire a driver Invoices */
    Route::get('/driver-invoices', 'DriverInvoiceController@index')->name('driver-invoices');
    Route::get('/driver-invoices/create', 'DriverInvoiceController@create')->name('driver-invoice-create');
    Route::get('/driver-invoices-list', 'DriverInvoiceController@getList')->name('driver-invoices-list');
    Route::get('/driver-mark-as-paid', 'DriverInvoiceController@markAsPaid')->name('driver-mark-as-paid');
    Route::get('/download-driver-invoice', 'DriverInvoiceController@downloadInvoice')->name('download-driver-invoice');
    Route::post('/generate-driver-invoice', 'DriverInvoiceController@generateInvoice')->name('generate-driver-invoice');



    /* drivers */
    Route::resource('v-drivers', 'DriverController');
    Route::get('/drivers-list', 'DriverController@getList')->name('drivers-list');
    Route::get('/v-drivers/change-status/{Driver}', 'DriverController@status')->name('driver.status-change');

    /* hire drivers */
    Route::resource('hire-drivers', 'HireDriverController');
    Route::get('/hire-driver-list', 'HireDriverController@getList')->name('hire-driver-list');
    Route::get('/hire-driver/{HireDriver}', 'HireDriverController@detail')->name('hire-driver-detail');
    Route::get('/hire-driver-calendar', 'HireDriverController@calendar')->name('hire-driver-calendar');



    /* vehicle types */
    Route::resource('vehicle-type', 'VehicleTypeController');
    Route::get('/vehicle-type-list', 'VehicleTypeController@getList')->name('vehicle-type-list');
    Route::get('/vehicle-type/change-status/{Vehicle}', 'VehicleTypeController@status')->name('vehicle-type.status-change');


    /* tuors */
    Route::resource('tours', 'ToursController');
    Route::get('/tours-list', 'ToursController@getList')->name('tour-list');
    Route::get('/tour/{Tour}', 'ToursController@detail')->name('tour-detail');
    Route::get('/tour-calendar', 'ToursController@calendar')->name('tour-calendar');


    /* vehicles */
    Route::resource('/vehicles', 'VehicleController');
    Route::get('/vehicle-list', 'VehicleController@getList')->name('vehicle-list');
    Route::get('/vehicles/change-status/{Vehicle}', 'VehicleController@status')->name('vehicles.status-change');

    /* customers */
    Route::resource('customers', 'CustomerController');
    Route::get('/customer-list', 'CustomerController@getList')->name('customer-list');
    Route::get('/customers/change-status/{Customer}', 'CustomerController@status')->name('customers.status-change');

    /* file upload */
    Route::post('/file-upload', 'AttachmentController@uploadFiles')->name('file-upload');

    Route::get('locale/{locale}', function ($locale){
        Session::put('locale', $locale);
        return redirect()->back();
    });

});
