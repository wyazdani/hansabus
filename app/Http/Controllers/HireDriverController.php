<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\HireDriver;
use App\Models\HireAttachment;
use App\Models\TourAttachment;
use App\Models\TourStatus;
use App\Models\Customer;
use App\Models\Attachment;

use Illuminate\Http\Request;
use App\Helpers\General;


class HireDriverController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function calendar(Request $request)
    {
        $pageTitle = __('hire.heading.calendar');
        $rows = HireDriver::where('status','>',1)->get(['id','customer_id','driver_id','status','price','from_date','to_date']);

        $data=[]; $i=0;
        foreach($rows as $row){

            $row->driver;
            $row->customer;

            $data[$i]['title'] = 'Hire # '.$row->id;
            $data[$i]['start'] = $row->from_date;
            $data[$i]['end'] = $row->to_date;
            $data[$i]['url'] = url('/hire-driver/'.$row->id);
            $i++;
        }
//        dd($data);
        return view('hire-drivers.calendar',compact('data','pageTitle'));
    }
    public function getList(Request $request)
    {
        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        $query = HireDriver::where('status','>',0);
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

        if(!empty($request->id)){
            $query = $query->where('id',(int)$request->id);
        }
        if(!empty($request->customer_id)){
            $query = $query->where('customer_id',$request->customer_id);
        }
        if(!empty($request->driver_id)){
            $query = $query->where('driver_id',$request->driver_id);
        }


        $from =''; $to ='';
        if(!empty($request->from_date)){

            $from = date('Y-m-d h:i',strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $to = date('Y-m-d h:i',strtotime($request->to_date));
        }
        if(!empty($from) && !empty($to)){

            $query = $query->whereBetween('from_date', [$from, $to]);

        }elseif(!empty($from)){

            $query = $query->where('from_date','>=',$from);
        }elseif(!empty($to)){

            $query = $query->where('from_date','<=',$to);
        }

        $recordsTotal = $query->count();
        $rows = $query->offset($start)->limit($limit)->get([
            'id','customer_id','driver_id','status','price','from_date','to_date']);

        $data=[];
        foreach($rows as $row){

            $row->driver;
            $row->customer;
            $row->from_date = date('d/m/Y h:i',strtotime($row->from_date));
            $row->to_date = date('d/m/Y h:i',strtotime($row->to_date));
            $data[] = $row;
        }
        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function index()
    {
        $pageTitle = __('hire.heading.index');
        $customers = Customer::where('status','1')->get(['name','id']);
        $drivers = Driver::where('status','1')->get(['driver_name','id']);

        return view('hire-drivers.index',compact('drivers','customers','pageTitle'));
    }

    public function create()
    {
        $pageTitle = __('hire.heading.add');
        $general = new General();
        $randomKey = $general->randomKey();

        $tour_statuses = TourStatus::get(['id','name']);
        $customers = Customer::get(['name','id']);
        $drivers = Driver::get(['driver_name','id']);

        return view('hire-drivers.add',compact('pageTitle','customers','drivers','tour_statuses','randomKey'));
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
            'status' => 'required|integer',
            'driver_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'from_date' => 'required',
            'to_date' => 'required',
            'price' => 'required|numeric|digits_between:1,20'
        ];
        $messages = [
            'customer_id.required' => 'Please select customer.',
            'from_date.required' => 'Please provide tour starting date/time.',
            'to_date.required' => 'Please provide tour end date/time.',
            'driver_id.required' => 'Please select driver.',
            'price.required' => 'Please provide tour price.'
        ];
        $this->validate(request(), $rules, $messages);

        $HireDriver = new HireDriver;
        $HireDriver->status = (int)$request->status;
        $HireDriver->customer_id = (int)$request->customer_id;
        $HireDriver->driver_id = (int)$request->driver_id;
        $HireDriver->from_date = date('Y-m-d h:i',strtotime($request->from_date));
        $HireDriver->to_date = date('Y-m-d h:i',strtotime($request->to_date));
        $HireDriver->price = (int)$request->price;
        $HireDriver->save();


        $files=[]; $attachments=[];
        if(!empty($request->temp_key)){
            $attachments = Attachment::where('temp_key',$request->temp_key)->get();

            foreach($attachments as $attachment){
                $files [] = ['hire_id'=>$HireDriver->id,'file'=>$attachment->file,'ext'=>$attachment->ext];
                /* delete attachment */
                Attachment::find($attachment->id)->delete();
            }
        }

        if(count($files)){
            HireAttachment::insert($files);
        }
        unset($files); unset($attachments);
        return redirect('/hire-drivers')->with('success', 'Hire driver successfully created.');
    }

    public function detail(HireDriver $HireDriver)
    {
        $pageTitle = 'Hire # '.$HireDriver->id;

        $HireDriver->driver;
        $HireDriver->customer;
        $HireDriver->attachments;

        return view('hire-drivers.detail',compact('pageTitle','HireDriver'));
    }
    public function show(HireDriver $HireDriver)
    {
        $HireDriver->driver;
        $HireDriver->customer;
        $HireDriver->attachments;
        $HireDriver->from_date = date('d/m/Y h:i A',strtotime($HireDriver->from_date));
        $HireDriver->to_date = date('d/m/Y h:i A',strtotime($HireDriver->to_date));
        return $HireDriver;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = __('hire.heading.edit');
        $hire = HireDriver::find($id);

        $general = new General();
        $randomKey = $general->randomKey();

        $tour_statuses = TourStatus::get(['id','name']);
        $customers = Customer::get(['name','id']);
        $drivers = Driver::get(['driver_name','id']);

        $attachments = HireAttachment::where('hire_id',$id)->get();
//        dd($attachments);
        return view('hire-drivers.add',compact('hire','pageTitle','customers','drivers','tour_statuses','randomKey','attachments'));
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
            'status' => 'required|integer',
            'customer_id' => 'required|integer',
            'from_date' => 'required',
            'to_date' => 'required',
            'driver_id' => 'required|integer',
            'price' => 'required|numeric|digits_between:1,20'
        ];
        $messages = [
            'customer_id.required' => 'Please select customer.',
            'from_date.required' => 'Please provide tour starting date/time.',
            'to_date.required' => 'Please provide tour end date/time.',
            'driver_id.required' => 'Please select driver.',
            'price.required' => 'Please provide tour price.'
        ];
        $this->validate(request(), $rules, $messages);


        $hire = HireDriver::find($request->id);
        $hire->status = (int)$request->status;
        $hire->customer_id = (int)$request->customer_id;
        $hire->driver_id = (int)$request->driver_id;
        $hire->from_date = date('Y-m-d h:i',strtotime($request->from_date));
        $hire->to_date = date('Y-m-d h:i',strtotime($request->to_date));
        $hire->price = (int)$request->price;
        $hire->save();

        /* if files uploaded */
        $files=[]; $attachments=[];

        /* delete old tour attachments */
        HireAttachment::where('hire_id',$hire->id)->delete();

        /* already uploaded files */
        if(!empty($request->old_attachments)){

            foreach($request->old_attachments as $attachment){

                $a = explode('.',$attachment);
                $ext = $a[count($a)-1];
                $files [] = ['hire_id'=>$hire->id,'file'=>$attachment,'ext'=>$ext];
            }
        }
        /* new uploaded files */
        if(!empty($request->temp_key)){
            $attachments = Attachment::where('temp_key',$request->temp_key)->get();
        }

        foreach($attachments as $attachment){
            $files [] = ['hire_id'=>$hire->id,'file'=>$attachment->file,'ext'=>$attachment->ext];
        }
        if(count($files)){
            HireAttachment::insert($files);
        }
        unset($files); unset($attachments);

        return redirect('/hire-drivers')->with('success', 'Hiring successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HireDriver::find($id)->delete();
    }

}
