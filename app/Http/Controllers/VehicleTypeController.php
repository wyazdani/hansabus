<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Vehicle Types';
        $vehicle_type = VehicleType::all();
        return view('vehicle_type.index',compact('vehicle_type','pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Vehicle Create';
        return view('vehicle_type.add', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  =>'required|unique:vehicle_types'
        ]);
        $vehicle_type = new VehicleType([
            'name'  => $request->get('name')
        ]);
        $vehicle_type->save();
        return redirect('/vehicle-type')->with('success', 'New Vehicle Type has been added');

    }

    public function show($id)
    {
        $vehicleType = VehicleType::find($id);
        $vehicleType->delete();

        return redirect('/vehicle-type')->with('success', 'Vehicle Type has been deleted Successfully');
    }



    public function edit($id)
    {
        $pageTitle= 'Edit Vehicle';
        $vehicleType = VehicleType::find($id);

        return view('vehicle_type.edit', compact('vehicleType','pageTitle'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name'=>'required'
            ]);
        $vehicleType = VehicleType::find($id);

        $vehicleType->name = $request->get('name');

        $vehicleType->save();

        return redirect('/vehicle-type')->with('success', 'Vehicle Type has been updated');
    }


    public function destroy($id)
    {
        $vehicleType = VehicleType::find($id);
        $vehicleType->delete();

        return redirect('/vehicle-type')->with('success', 'Vehicle Type has been deleted Successfully');
    }
}
