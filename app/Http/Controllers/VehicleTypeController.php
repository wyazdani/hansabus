<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\User;
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

        $orderColumn = 'id';
        $dir = 'desc';

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==1){
            $orderColumn = 'name';
        }
        if(!empty($request->order[0]['dir'])){
            $dir = $request->order[0]['dir'];
        }


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

        $rows = $query->orderBy($orderColumn,$dir)->offset($start)->limit($limit)->get();

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
        $rules = [
            'name'  =>'required|string'
        ];
        $messages = [
             'name.required' => 'Vehicle type is required',
        ];
        $this->validate(request(), $rules, $messages);
        if(true){

            $vehicle_type = new VehicleType([
                'name'  => $request->name,
                'status' => '1'
            ]);
            if($vehicle_type->save()){
                toastr()->success(__('vehicle_type.created'));
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }

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

    public function changePasswordForm(){

        $pageTitle = __('message.change_password');
        return view('change_password', compact('pageTitle'));
    }
    public function changePassword(Request $request){

        $rules = [
            'password'      =>  'required|min:6|confirmed'
        ];

        $this->validate(request(), $rules);
        if(true){

            $u = User::find(\Auth::user()->id);
            $u->password = bcrypt($request->password);
            if($u->save()) {
                toastr()->success(__('messages.password_updated'));
            }
        }

        return redirect('/change-password');
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'name'  =>'required|string'
        ];
        $messages = [
            'name.required' => 'Vehicle type is required',
        ];
        $this->validate(request(), $rules, $messages);
        if(true){

            $vehicleType = VehicleType::find($id);
            $vehicleType->name = $request->get('name');
            if($vehicleType->save()) {
                toastr()->success(__('vehicle_type.updated'));
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }
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
