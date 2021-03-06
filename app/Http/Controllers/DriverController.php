<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\Customer;
use App\Models\Driver;
use Illuminate\Http\Request;


class DriverController extends Controller
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
            $orderColumn = 'driver_name';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==2){
            $orderColumn = 'mobile_number';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==3){
            $orderColumn = 'driver_license';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==4){
            $orderColumn = 'nic';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==5){
            $orderColumn = 'phone';
        }
        if(!empty($request->order[0]['dir'])){
            $dir = $request->order[0]['dir'];
        }


        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        $query = Driver::where('id','>',0);
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

            $query = Driver::where(function ($query) use ($search) {
                $query->where('driver_name', 'LIKE','%'.$search.'%')
                    ->orWhere('mobile_number', 'LIKE','%'.$search.'%')
                    ->orWhere('driver_license', 'LIKE','%'.$search.'%')
                    ->orWhere('nic', 'LIKE','%'.$search.'%')
                    ->orWhere('address', 'LIKE','%'.$search.'%')
                    ->orWhere('phone', 'LIKE','%'.$search.'%')
                    ->orWhere('other_details', 'LIKE','%'.$search.'%');
            });
            /* if searching from autocomplete */
            if(!empty($request->key) && $request->key=='auto'){
                $query->where('status',1);
            }
        }
        $recordsTotal = $query->count();
        $rows = $query->orderBy($orderColumn,$dir)->offset($start)->limit($limit)->get();

        $data=[];
        foreach($rows as $row){
            $row['label'] = $row['driver_name'];
            $row['value'] = $row['driver_name'];
            $data[] = $row;
        }

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function show(Driver $v_driver)
    {
        return $v_driver;
    }
    public function status(Driver $Driver)
    {
        $Driver->status = !$Driver->status;
        $Driver->save();

        toastr()->success(__('driver.status_changed'));
        return redirect('/v-drivers');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = trans('messages.drivers');
        return view('drivers.index',compact('pageTitle'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = trans('messages.drivers');
        $customers  =   Customer::orderBy('name','ASC')->where('status','=',1)->get();
        $drivers  =   Driver::orderBy('driver_name','ASC')->where('status','=',1)->get();
        return view('drivers.add',compact('pageTitle','customers','drivers'));
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
            'mobile_number' => 'required|numeric|digits_between:1,16',
            'driver_license' => 'required|string|max:100',
            'nic' => 'required|numeric|digits_between:1,30',
            'address' => 'required|string',
            'phone' => 'required|numeric|digits_between:1,16',
//            'other_details' => 'required|string'
        ];
        $messages = [
             'driver_name.required' => 'Name is required.',
            'nic.required'=>'NIN No. is required.'
        ];
        $this->validate(request(), $rules, $messages);
        if(true){

            /* Profile picture upload */
            $profilePic = '';
            if (!empty($request->profile_pic)) {

                $general = new General;
                $ext = $request->file('profile_pic')->getClientOriginalExtension();
                $profilePic = $general->randomKey() . '.' . $ext;

                $request->file('profile_pic')->move(
                    base_path() . '/public/images/drivers/', $profilePic
                );
            }
            /* save data into database */
            $driver = new Driver;
            $driver->driver_name = $request->get('driver_name');
            $driver->mobile_number = $request->get('mobile_number');
            $driver->driver_license = $request->get('driver_license');
            $driver->nic = $request->get('nic');
            $driver->address = $request->get('address');
            $driver->phone = $request->get('phone');

            $other_details = ' ';
            if(!empty($request->other_details)){
                $other_details = $request->other_details;
            }
            $driver->other_details = $other_details;
            $driver->profile_pic = $profilePic;
            if($driver->save()){

                if(!empty($request->key) && $request->key == 'popup'){

                    return $driver;
                }else{
                    toastr()->success(__('driver.created'));
                }
            }

        }else{
            return redirect()->back()->withInput($request->all());
        }

        return redirect('/v-drivers');

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
        $customers  =   Customer::orderBy('name','ASC')->where('status','=',1)->get();
        $drivers  =   Driver::orderBy('driver_name','ASC')->where('status','=',1)->get();
        return view('drivers.add', compact('driver','pageTitle','drivers','customers'));
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
            'mobile_number' => 'required|numeric|digits_between:1,16',
            'driver_license' => 'required|string|max:100',
            'nic' => 'required|numeric|digits_between:1,30',
            'address' => 'required|string',
            'phone' => 'required|numeric|digits_between:1,16',
//            'other_details' => 'required|string'
        ];

        $messages = [
            'driver_name.required' => 'Name is required.',
            'nic.required'=>'NIN No. is required.'
        ];
        $this->validate(request(), $rules, $messages);
        if(true){

            /* Profile picture upload */
            $profilePic = '';
            if (!empty($request->old_profile_pic)) {
                $profilePic = $request->old_profile_pic;
            }
            if (!empty($request->profile_pic)) {

                $general = new General;
                $ext = $request->file('profile_pic')->getClientOriginalExtension();
                $profilePic = $general->randomKey() . '.' . $ext;

                $request->file('profile_pic')->move(
                    base_path() . '/public/images/drivers/', $profilePic
                );
            }
            /* save data into database */
            $driver = Driver::find($id);
            $driver->driver_name = $request->get('driver_name');
            $driver->mobile_number = $request->get('mobile_number');
            $driver->driver_license = $request->get('driver_license');
            $driver->nic = $request->get('nic');
            $driver->address = $request->get('address');
            $driver->phone = $request->get('phone');
            $other_details = ' ';
            if(!empty($request->other_details)){
                $other_details = $request->other_details;
            }
            $driver->other_details = $other_details;
            $driver->profile_pic = $profilePic;
            if($driver->save()){
                toastr()->success(__('driver.updated'));
            }

        }else{
            return redirect()->back()->withInput($request->all());
        }
        return redirect('/v-drivers');
    }


    public function destroy($id)
    {
        $driver = Driver::find($id);
        $driver->delete();
    }
}
