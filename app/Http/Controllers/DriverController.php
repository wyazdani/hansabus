<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
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

            $query = Driver::where('driver_name', 'LIKE','%'.$search.'%')
                ->orWhere('mobile_number', 'LIKE','%'.$search.'%')
                ->orWhere('driver_license', 'LIKE','%'.$search.'%')
                ->orWhere('nic', 'LIKE',"%{$search}%")
                ->orWhere('address', 'LIKE',"%{$search}%")
                ->orWhere('phone', 'LIKE',"%{$search}%")
                ->orWhere('other_details', 'LIKE',"%{$search}%")
            ;
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
    public function show(Driver $Driver)
    {
        return $Driver;
    }
    public function status(Driver $Driver)
    {
        $Driver->status = !$Driver->status;
        $Driver->save();
        return redirect()->back()->with('info','Driver # '.$Driver->id.' status updated!');
    }
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
        $request->validate([
            'driver_name'=>'required',
            'mobile_number'=> 'required',
            'driver_license' => 'required',
            'nic' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'other_details' => 'required',
        ]);

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


    public function destroy($id)
    {
        $driver = Driver::find($id);
        $driver->delete();
    }
}
