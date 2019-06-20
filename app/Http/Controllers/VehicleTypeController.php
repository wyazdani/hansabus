<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\VehicleType;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList(Request $request)
    {

        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        $query = VehicleType::where('id','>',0);
        $start =0;
        if(!empty($request->input('start'))){

//            if($request->input('start')>0){
            $start = ($request->input('start')-1);
//            }
        }
        $limit = 10;
        if(!empty($request->input('length'))){
            $limit = $request->input('length');
        }
        $search = '';
        if(!empty($request->input('q'))){

            $search = $request->input('q');
        }else if(!empty($request->input('search.value'))){

            $search = $request->input('search.value');
        }

        if(!empty($search)){

            $query = VehicleType::where('name', 'LIKE','%'.$search.'%');
        }
        $recordsTotal = $query->count();
        $rows = $query->offset($start)->limit($limit)->get();

        $data=[];
        foreach($rows as $row){
            $row['action']='';
            $data[] = $row;
        }
        $recordsFiltered = $query->offset($start)->limit($limit)->count();

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
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
            'name'  =>'required|unique:vehicle_types,name,NULL,id,deleted_at,NULL|regex:/^[a-zA-Z]+$/u|'
        ]);

        $vehicle_type = new VehicleType([
            'name'  => $request->get('name'),
        ]);
        $vehicle_type->save();
        return redirect('/vehicle-type')->with('success', 'New vehicle type has been added.');

    }

    public function show(VehicleType $VehicleType)
    {
        return $VehicleType;
    }
    public function status(VehicleType $VehicleType)
    {
        $VehicleType->status = !$VehicleType->status;
        $VehicleType->save();
        return redirect()->back()->with('info','Vehicle type # '.$VehicleType->id.' status updated!');
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

        return redirect('/vehicle-type')->with('success', 'Vehicle type has been updated');
    }


    public function destroy($id)
    {
        $vehicleType = VehicleType::find($id);
        $vehicleType->delete();
//        return redirect('/vehicle-type')->with('success', 'Vehicle type has been deleted Successfully');
    }
}
