<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Models\Vehicle;
use App\Models\tours;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToursController extends Controller
{
    public function index()
    {
        $pageTitle = 'Tours';
        $tours = tours::all();
        return view('tours.index',compact('tours','pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Add Tour';
        $vehicle_name = Vehicle::pluck('name','id');
        $vehicle_reg = Vehicle::pluck('registrationNumber','id');
        $driver = Driver::pluck('driver_name','id');
        return view('tours.add',compact('pageTitle','vehicle_name','vehicle_reg','driver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tour = new tours([
            'tour_name'  => $request->get('tour_name'),
            'price'  => $request->get('price'),
            'location'  => $request->get('location'),
            'destination'  => $request->get('destination'),
            'departure_date'  => $request->get('departure_date'),
            'vehicle_id'        => $request->get('vehicle_id'),
            'tour_id'  => $request->get('tour_id'),
            'customer_id'   => 0,
            'driver_id'    =>  !empty($request['driver_id'])?$request['driver_id']:0,

        ]);

        $tour->save();
        return redirect('/tours')->with('success', 'New Tour has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'Show Tour';
        $tour = tours::find($id);

        return view('tours.show',compact('tour','pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Edit Tour';
        $tour = tours::find($id);

        return view('tours.edit', compact('tour','pageTitle'));
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
        $request->validate([
            'tour_name'=>'required',
            'departure_date'=> 'required',
            'price' => 'required',
            'location' => 'required',
            'destination' => 'required',
        ]);

        $tour = tours::find($id);

        $tour->tour_name = $request->get('tour_name');
        $tour->departure_date = $request->get('departure_date');
        $tour->tour_id  = $request->get('tour_id');
        $tour->price = $request->get('price');
        $tour->location = $request->get('location');
        $tour->destination = $request->get('destination');
        $tour->vehicle_id = $request->get('vehicle_id');
        $tour->driver_id = $request->get('driver_id');
        $tour->customer_id = $request->get('customer_id');

        $tour->save();

        return redirect('/tours')->with('success', 'Tour has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tour = tours::find($id);
        $tour->delete();

        return redirect('/tours')->with('success', 'tour has been deleted Successfully');
    }

}
