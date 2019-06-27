<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Drivers';
        $drivers = Driver::all();
        return view('drivers.index',compact('drivers','pageTitle'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Add Driver';
        return view('drivers.add',compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'driver_name' => 'required|string|max:150',
            'mobile_number' => 'required',
            'driver_license' => 'required|string|max:100',
            'nic' => 'required|string|max:100',
            'address' => 'required|string',
            'phone' => 'required',
            'other_details' => 'required|string'
        ];

        $this->validate(request(), $rules);
        $driver = new Driver([
            'driver_name'  => $request->get('driver_name'),
            'mobile_number'  => $request->get('mobile_number'),
            'driver_license'  => $request->get('driver_license'),
            'nic'  => $request->get('nic'),
            'address'  => $request->get('address'),
            'phone'  => $request->get('phone'),
            'other_details'  => $request->get('other_details'),

        ]);

        $driver->save();
        return redirect('/drivers')->with('success', 'New Driver has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::find($id);
        $driver->delete();

        return redirect('/drivers')->with('success', 'Driver has been deleted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Edit Driver';
        $driver = Driver::find($id);

        return view('drivers.edit', compact('driver','pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'driver_name' => 'required|string|max:150',
            'mobile_number' => 'required',
            'driver_license' => 'required|string|max:100',
            'nic' => 'required|string|max:100',
            'address' => 'required|string',
            'phone' => 'required',
            'other_details' => 'required|string'
        ];

        $this->validate(request(), $rules);

        $driver = Driver::find($id);

        $driver->driver_name = $request->get('driver_name');
        $driver->mobile_number = $request->get('mobile_number');
        $driver->driver_license = $request->get('driver_name');
        $driver->nic = $request->get('nic');
        $driver->address = $request->get('address');
        $driver->phone = $request->get('phone');
        $driver->other_details = $request->get('other_details');

        $driver->save();

        return redirect('/drivers')->with('success', 'Driver has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = Driver::find($id);
        $driver->delete();

        return redirect('/drivers')->with('success', 'Driver has been deleted Successfully');
    }
}
