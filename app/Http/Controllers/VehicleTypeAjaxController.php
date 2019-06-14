<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class VehicleTypeAjaxController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Vehicle Types';
        if ($request->ajax()) {
            $data = VehicleType::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('vehicle_type.index',compact('products'));
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
