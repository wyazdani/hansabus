<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class VehicleController extends Controller
{

    public function index()
    {

        $pageTitle = 'Vehicles';
        $vehicles = Vehicle::paginate(10);
        return view('vehicle.list', compact('vehicles', 'pageTitle'));
    }


    public function status(Vehicle $vehicle)
    {
        // dd($vehicle);
        $vehicle->status = !$vehicle->status;
        $vehicle->save();
        return redirect()->back()->with('info','Vehicle # '.$vehicle->id.' status updated!');
    }

    public function edit(Vehicle $vehicle)
    {
        // dd($vehicle);
        $pageTitle = 'Vehicle Update';
        $vehicleTypes = VehicleType::all();
        return view('vehicle.add', compact('pageTitle', 'vehicleTypes', 'vehicle'));
    }

    public function create()
    {

        $pageTitle = 'Vehicle Create';
        $vehicleTypes = VehicleType::all();
        return view('vehicle.add', compact('pageTitle', 'vehicleTypes'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:150',
            'year' => 'required|integer|min:1900|max:2050',
            'make' => 'required|string|max:100',
            'engineNumber' => 'required|string|max:100',
            'vehicle_type' => 'required|integer',
            'licensePlate' => 'required|string|max:50',
            'seats' => 'required|integer',
            'color' => 'required|string|max:50',
            'registrationNumber' => 'required|string|max:100',
            'transmission' => 'required',
        ];
        $messages = [
            // 'title.required' => 'Title is required',
        ];
        $this->validate(request(), $rules, $messages);


        if (isset($request->id)) {

            $vehicle = Vehicle::find($request->id);
            $msg = 'Vehicle updated successfully.';
        } else {
            $vehicle = new Vehicle;
            $msg = 'Vehicle created successfully.';
        }

        $vehicle->name = $request->name;
        $vehicle->year = $request->year;
        $vehicle->make = $request->make;
        $vehicle->engineNumber = $request->engineNumber;
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->licensePlate = $request->licensePlate;
        $vehicle->color = $request->color;
        $vehicle->seats = $request->seats;
        $vehicle->registrationNumber = $request->registrationNumber;
        $vehicle->transmission = $request->transmission;

        $status = true;
        $ac = $sunroof = $radio = $phoneCharging = false;

        if ($request->ac) $ac = true;
        if ($request->sunroof) $sunroof = true;
        if ($request->radio) $radio = true;
        if ($request->phoneCharging) $phoneCharging = true;

        $vehicle->ac = $ac;
        $vehicle->radio = $radio;
        $vehicle->sunroof = $sunroof;
        $vehicle->phoneCharging = $phoneCharging;
        $vehicle->status = $status;

        if ($vehicle->save()) {

            if ($request->returnFlag == 1) {
                return redirect('/vehicles');
            } else {
                return redirect('/vehicle-add');
            }
        }
        return redirect()->back()->with('info', $msg);
    }
}
