<?php

namespace App\Http\Controllers;

use App\Models\TourStatus;
use App\Models\TourAttachment;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Tour;
use App\Models\Attachment;
use App\Models\Driver;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ToursController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function calendar(Request $request)
    {
        $pageTitle = 'Tour Canlendar';
        $rows = Tour::where('status','>',1)->get(
            ['id','vehicle_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $data=[]; $i=0;
        foreach($rows as $row){
            $row->vehicle;
            $row->driver;
            $row->customer;
            // ' passengers on '.$row->vehicle->name.'. driver: '.$row->driver->driver_name
            $data[$i]['title'] = 'Tour # '.$row->id;
            $data[$i]['start'] = $row->from_date;
            $data[$i]['end'] = $row->to_date;
            $data[$i]['url'] = url('/tour/'.$row->id);
            $i++;
        }

        return view('tours.calendar',compact('data','pageTitle'));
    }
    public function getList(Request $request)
    {

        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        $query = Tour::where('id','>',0);
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

            $query = Tour::where('name', 'LIKE','%'.$search.'%')
                ->orWhere('email', 'LIKE','%'.$search.'%');
        }
        $recordsTotal = $query->count();
        $rows = $query->offset($start)->limit($limit)->get([
            'id','vehicle_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $data=[];
        foreach($rows as $row){
            $row->vehicle;
            $row->driver;
            $row->customer;
            $row['action']='';
            $data[] = $row;
        }
        $recordsFiltered = $query->offset($start)->limit($limit)->count();

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function index()
    {
        $pageTitle = 'Tours';
        $tours = Tour::all();
        return view('tours.index',compact('tours','pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Add Tour';
        $general = new General();
        $randomKey = $general->randomKey();
        //$vehicles = Vehicle::get(['name','make','year','transmission','licensePlate','id']);
        $tour_statuses = TourStatus::get(['id','name']);
        $customers = Customer::get(['name','id']);
        $drivers = Driver::get(['driver_name','id']);
        $vehicles = Vehicle::where('status','=',1)->get();


        return view('tours.add',compact('pageTitle','vehicles','customers','drivers','tour_statuses','randomKey'));
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
            'customer_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
            'from_date' => 'required',
            'to_date' => 'required',
            'driver_id' => 'required|integer',
            'price' => 'required|integer',
            'passengers' => 'required|integer',
            'guide' => 'required',
        ];
        $messages = [
            // 'title.required' => 'Title is required',
        ];
        $this->validate(request(), $rules, $messages);

        $tour = new Tour;
        $tour->status = (int)$request->status;
        $tour->customer_id = (int)$request->customer_id;
        $tour->vehicle_id = (int)$request->vehicle_id;
        $tour->driver_id = (int)$request->driver_id;
        $tour->from_date = $request->from_date;
        $tour->to_date = $request->to_date;
        $tour->passengers = (int)$request->passengers;
        $tour->price = (int)$request->price;
        $tour->guide = $request->guide;
        $tour->save();


        $attachments=[];
        if(!empty($request->temp_key)){
            $attachments = Attachment::where('temp_key',$request->temp_key)->get();
        }
        $files=[];
        foreach($attachments as $attachment){
            $files [] = ['tour_id'=>$tour->id,'file'=>$attachment->file,'ext'=>$attachment->ext];

            /* delete attachment */
            Attachment::find($attachment->id)->delete();
        }
        if(count($files)){
            TourAttachment::insert($files);
        }

        unset($files); unset($attachments);
        return redirect('/tours')->with('success', 'Tour successfully created.');
    }

    public function detail(Tour $Tour)
    {
        $pageTitle = 'Tour # '.$Tour->id;
        $Tour->vehicle;
        $Tour->driver;
        $Tour->customer;
        $Tour->attachments;

        return view('tours.detail',compact('pageTitle','Tour'));
    }
    public function show(Tour $Tour)
    {
        $Tour->vehicle;
        $Tour->driver;
        $Tour->customer;
        $Tour->attachments;
        return $Tour;
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
        $tour = Tour::find($id);

        $general = new General();
        $randomKey = $general->randomKey();
        $vehicles = Vehicle::get(['name','make','year','transmission','licensePlate','id']);
        $tour_statuses = TourStatus::get(['id','name']);
        $customers = Customer::get(['name','id']);
        $drivers = Driver::get(['driver_name','id']);

        $attachments = TourAttachment::where('tour_id',$id)->get();

//        dd($attachments);

        return view('tours.add',compact('tour','pageTitle','vehicles','customers','drivers','tour_statuses','randomKey','attachments'));
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
            'customer_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
            'from_date' => 'required',
            'to_date' => 'required',
            'driver_id' => 'required|integer',
            'price' => 'required|integer',
            'passengers' => 'required|integer',
            'guide' => 'required',
        ];
        $messages = [
            // 'title.required' => 'Title is required',
        ];
        $this->validate(request(), $rules, $messages);


        $tour = Tour::find($request->id);
        $tour->status = (int)$request->status;
        $tour->customer_id = (int)$request->customer_id;
        $tour->vehicle_id = (int)$request->vehicle_id;
        $tour->driver_id = (int)$request->driver_id;
        $tour->from_date = $request->from_date;
        $tour->to_date = $request->to_date;
        $tour->passengers = (int)$request->passengers;
        $tour->price = (int)$request->price;
        $tour->guide = $request->guide;
        $tour->save();

        /* if files uploaded */
        $attachments=[];
        if(!empty($request->temp_key)){
            $attachments = Attachment::where('temp_key',$request->temp_key)->get();
        }
        $files=[];

        if(!empty($request->old_attachments)){

            foreach($request->old_attachments as $attachment){


                $a = explode('.',$attachment);
                $ext = $a[count($a)-1];

                $files [] = ['tour_id'=>$tour->id,'file'=>$attachment,'ext'=>$ext];
            }
        }
        foreach($attachments as $attachment){
            $files [] = ['tour_id'=>$tour->id,'file'=>$attachment->file,'ext'=>$attachment->ext];

            Attachment::find($attachment->id)->delete();
        }
        if(count($files)){
            TourAttachment::insert($files);
        }

//        dd('OK');

        unset($files); unset($attachments);

        return redirect('/tours')->with('success', 'Tour successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tour = Tour::find($id);
        $tour->delete();
    }

}
