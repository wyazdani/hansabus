<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
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
        $rows = $query->orderBy('name','asc')->offset($start)->limit($limit)->get();

        $data=[];
        foreach($rows as $row){

            $data[] = $row;
        }
//        $recordsFiltered = $query->offset($start)->limit($limit)->count();

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function index()
    {
        $pageTitle = __('vehicle_type.heading.index');
        return view('vehicle_type.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = __('vehicle_type.heading.add');
        return view('vehicle_type.add', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  =>'required|string'
        ]);

        $vehicle_type = new VehicleType([
            'name'  => $request->get('name'),
            'status' => '1'
        ]);
        $vehicle_type->save();
        toastr()->success(__('vehicle_type.created'));
        return redirect('/vehicle-type');
    }

    public function show(VehicleType $VehicleType)
    {
        return $VehicleType;
    }
    public function edit($id)
    {
        $pageTitle = __('vehicle_type.heading.edit');
        $vehicleType = VehicleType::find($id);

        return view('vehicle_type.add', compact('vehicleType','pageTitle'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name'  =>'required|string'
            ]);
        $vehicleType = VehicleType::find($id);

        $vehicleType->name = $request->get('name');

        $vehicleType->save();

        toastr()->success(__('vehicle_type.updated'));
        return redirect('/vehicle-type');
    }

    public function status(VehicleType $VehicleType)
    {
        // dd($vehicle);
        $VehicleType->status = !$VehicleType->status;
        $VehicleType->save();
        toastr()->success(__('vehicle_type.status_changed'));
        return redirect()->back();
    }
    public function destroy($id)
    {
        $vehicleType = VehicleType::find($id);
        $vehicleType->delete();
//        toastr()->success(__('vehicle_type.deleted'));
//        return redirect('/vehicle-type');
    }
}
