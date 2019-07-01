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
        $pageTitle = __('messages.calendar');
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
//        dd($request->all());
        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        $query = Tour::where('status','>',0);
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
        if(!empty($request->vehicle_id)){
            $query = $query->where('vehicle_id',$request->vehicle_id);
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
            'id','customer_id','vehicle_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $data=[];
        foreach($rows as $row){
            $row->vehicle;
            $row->driver;
            $row->customer;
            $row->from_date = date('d/m/Y h:i',strtotime($row->from_date));
            $row->to_date = date('d/m/Y h:i',strtotime($row->to_date));
//            $row['action']='';
            $data[] = $row;
        }
        $recordsFiltered = $query->offset($start)->limit($limit)->count();

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function index()
    {
        $pageTitle = __('messages.tours');
//        $tours = Tour::all();

        $vehicles = Vehicle::where('status','1')->get(['name','id']);
        $customers = Customer::where('status','1')->get(['name','id']);
        $drivers = Driver::where('status','1')->get(['driver_name','id']);

        return view('tours.index',compact('drivers','customers','vehicles','pageTitle'));
    }

    public function create()
    {
        $pageTitle = __('tour.heading.add');
        $general = new General();
        $randomKey = $general->randomKey();
        //$vehicles = Vehicle::get(['name','make','year','transmission','licensePlate','id']);
        $tour_statuses = TourStatus::get(['id','name']);
        $customers = Customer::where('status','=',1)->get();
        $drivers = Driver::where('status','=',1)->get();
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
            'status' => 'required|integer',
            'customer_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
            'from_date' => 'required',
            'to_date' => 'required',
            'driver_id' => 'required|integer',
            'price' => 'required|numeric|digits_between:1,20',
            'passengers' => 'required|integer',
            'guide' => 'required',
        ];
        $messages = [
            'customer_id.required' => 'Please select customer.',
            'vehicle_id.required' => 'Please select vehicle.',
            'from_date.required' => 'Please provide tour starting date/time.',
            'to_date.required' => 'Please provide tour end date/time.',
            'driver_id.required' => 'Please select driver.',
            'price.required' => 'Please provide tour price.',
            'passengers.required' => 'Please provide number of passengers.',
            'guide.required' => 'Please provide guide name.',
        ];
        $this->validate(request(), $rules, $messages);

        $tour = new Tour;
        $tour->status = (int)$request->status;
        $tour->customer_id = (int)$request->customer_id;
        $tour->vehicle_id = (int)$request->vehicle_id;
        $tour->driver_id = (int)$request->driver_id;
        $tour->from_date = date('Y-m-d h:i',strtotime($request->from_date));
        $tour->to_date = date('Y-m-d h:i',strtotime($request->to_date));
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
        return redirect('/tours')->with('success', trans('messages.tour_created'));
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
        $Tour->from_date = date('d/m/Y h:i A',strtotime($Tour->from_date));
        $Tour->to_date = date('d/m/Y h:i A',strtotime($Tour->to_date));
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
        $pageTitle = __('messages.edit_tour');
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
            'status' => 'required|integer',
            'customer_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
            'from_date' => 'required',
            'to_date' => 'required',
            'driver_id' => 'required|integer',
            'price' => 'required|numeric|digits_between:1,20',
            'passengers' => 'required|integer',
            'guide' => 'required',
        ];
        $messages = [
            'customer_id.required' => 'Please select customer.',
            'vehicle_id.required' => 'Please select vehicle.',
            'from_date.required' => 'Please provide tour starting date/time.',
            'to_date.required' => 'Please provide tour end date/time.',
            'driver_id.required' => 'Please select driver.',
            'price.required' => 'Please provide tour price.',
            'passengers.required' => 'Please provide number of passengers.',
            'guide.required' => 'Please provide guide name.',
        ];
        $this->validate(request(), $rules, $messages);


        $tour = Tour::find($request->id);
        $tour->status = (int)$request->status;
        $tour->customer_id = (int)$request->customer_id;
        $tour->vehicle_id = (int)$request->vehicle_id;
        $tour->driver_id = (int)$request->driver_id;
        $tour->from_date = date('Y-m-d h:i',strtotime($request->from_date));
        $tour->to_date = date('Y-m-d h:i',strtotime($request->to_date));
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

        return redirect('/tours')->with('success', trans('messages.tour_updated'));
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
