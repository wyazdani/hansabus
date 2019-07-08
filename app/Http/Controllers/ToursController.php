<?php

namespace App\Http\Controllers;

use App\Models\DriverBooking;
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
        $rows = Tour::where('status','>',1)->where('status','<',4)->get(
            ['id','vehicle_id','customer_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $colors = ['red','green','blue','orange','tan','purple','brown','black'];

        $events = $vehicles = []; $i=$j=0;
        foreach($rows as $row){

            if($j>7){
                $j = $j-8;
            }


            $row->driver;
            $row->customer;

            $vehicles[] = $row->vehicle;
            $events[$i]['id'] = $row->id;
            $events[$i]['resourceId'] = $row->vehicle->id;
            $events[$i]['start'] = $row->from_date;
            $events[$i]['end'] = $row->to_date;


            $events[$i]['title'] = ' 
            Customer: '.$row->customer->name.' 
            Driver: '.$row->driver->driver_name;
            $events[$i]['url'] = url('/tour/'.$row->id);
            $events[$i]['eventColor'] = $colors[$j];

            $i++;
        }

//        dd($events);
        return view('tours.calendar',compact('events','vehicles','pageTitle'));
    }
    public function getList(Request $request)
    {
        $orderColumn = 'id';
        $dir = 'desc';

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==1){
            $orderColumn = 'customer.name';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==2){
            $orderColumn = 'vehicle.name';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==3){
            $orderColumn = 'year';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==4){
            $orderColumn = 'licensePlate';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==5){
            $orderColumn = 'engineNumber';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==6){
            $orderColumn = 'registrationNumber';
        }
        if(!empty($request->order[0]['dir'])){
            $dir = $request->order[0]['dir'];
        }


        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        if(!empty($request->input('status'))){
            $query = Tour::where('status',$request->input('status'));
        }else{
            $query = Tour::where('status','>',0);
        }

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

            $from = date('Y-m-d H:i',strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $to = date('Y-m-d H:i',strtotime($request->to_date));
        }
        if(!empty($from) && !empty($to)){

            $query = $query->whereBetween('from_date', [$from, $to]);

        }elseif(!empty($from)){

            $query = $query->where('from_date','>=',$from);
        }elseif(!empty($to)){

            $query = $query->where('from_date','<=',$to);
        }

        $recordsTotal = $query->count();

        $rows = $query->orderBy($orderColumn,$dir)->offset($start)->limit($limit)->get([
            'id','customer_id','vehicle_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $data=[];
        foreach($rows as $row){

            $row->vehicle;
            $row->driver;
            $row->customer;
            $row->from_date = date('d.m.Y H:i',strtotime($row->from_date));
            $row->to_date   = date('d.m.Y H:i',strtotime($row->to_date));
            $data[] = $row;
        }

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function index()
    {
        $pageTitle = __('messages.tours');

        $tour_statuses = TourStatus::get(['id','name']);
        $vehicles = Vehicle::where('status','1')->get(['name','id']);
        $customers = Customer::where('status','1')->get(['name','id']);
        $drivers = Driver::where('status','1')->get(['driver_name','id']);
        return view('tours.index',compact('drivers','customers','vehicles','tour_statuses','pageTitle'));
    }

    public function create()
    {
        $pageTitle = __('tour.heading.add');
        $general = new General();
        $randomKey = $general->randomKey();

        $tour_statuses = TourStatus::get(['id','name']);
        $customers = Customer::where('status','1')->get();
        $drivers = Driver::where('status','1')->get();
        $vehicles = Vehicle::where('status','1')->get();

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
            'passengers' => 'required|integer|min:1,max:500',
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
        $general = new General();
        $validated = $general->validateMe($request, $rules, $messages);
        if($validated) {


            /* check if driver is available for this time slot */
            $from = date('Y-m-d H:i:s', strtotime($request->from_date));
            $to = date('Y-m-d H:i:s', strtotime($request->to_date));

            $alreadyBooked = false;
            /* check for driver bookings */
            $driverBooked = DriverBooking::where('driver_id', $request->driver_id)
                ->where(function ($query) use ($from, $to) {
                    $query
                        ->whereBetween('from_date', [$from, $to])
                        ->orWhere(function ($query) use ($from, $to) {
                            $query->whereBetween('to_date', [$from, $to]);
                        });
                })->first();
            if ($driverBooked) {

                $alreadyBooked = true;
                toastr()->error(__('hire.already_booked'));
            }
            /* check for vehicle bookings */
            $vehicleBooked = Tour::where('vehicle_id', $request->vehicle_id)
                ->where('status', '>', 1)->where('status', '<', 5)
                ->where(function ($query) use ($from, $to) {
                    $query
                        ->whereBetween('from_date', [$from, $to])
                        ->orWhere(function ($query) use ($from, $to) {
                            $query->whereBetween('to_date', [$from, $to]);
                        });
                })->first();
            if ($vehicleBooked) {

                $alreadyBooked = true;
                toastr()->error(__('tour.vehicle_already_booked'));
            }
//        dd($driverBooked);

            if (!$alreadyBooked) {

                $tour = new Tour;
                $tour->status = (int)$request->status;
                $tour->customer_id = (int)$request->customer_id;
                $tour->vehicle_id = (int)$request->vehicle_id;
                $tour->driver_id = (int)$request->driver_id;
                $tour->from_date = date('Y-m-d H:i', strtotime($request->from_date));
                $tour->to_date = date('Y-m-d H:i', strtotime($request->to_date));
                $tour->passengers = (int)$request->passengers;
                $tour->price = (int)$request->price;
                $tour->guide = $request->guide;
                if ($tour->save()) {

                    toastr()->success(__('tour.created'));

                    /* if hiring status is not Draft and Canceled */
                    DriverBooking::where('driver_id', $request->driver_id)
                        ->where('booking_id', $tour->id)
                        ->where('with_vehicle', 1)->delete();

                    if ($request->status > 1 && $request->status < 5) {

                        DriverBooking::create([
                            'booking_id' => $tour->id,
                            'driver_id' => $request->driver_id,
                            'from_date' => $from,
                            'to_date' => $to,
                            'with_vehicle' => 1]);
                    }
                }

                $files = [];
                $attachments = [];
                if (!empty($request->temp_key)) {
                    $attachments = Attachment::where('temp_key', $request->temp_key)->get();

                    foreach ($attachments as $attachment) {
                        $files [] = ['tour_id' => $tour->id, 'file' => $attachment->file, 'ext' => $attachment->ext];
                        /* delete attachment */
                        Attachment::find($attachment->id)->delete();
                    }
                }
                if (count($files)) {
                    TourAttachment::insert($files);
                }
                unset($files);
                unset($attachments);
            } else {

                return back()->withInput();
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }
        return redirect('/tours');
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
        $tour_statuses = TourStatus::get(['id','name']);

        $vehicles = Vehicle::where('status','1')->get(['name','make','year','transmission','licensePlate','id']);
        $customers = Customer::where('status','1')->get(['name','id']);
        $drivers = Driver::where('status','1')->get(['driver_name','id']);
        $attachments = TourAttachment::where('tour_id',$id)->get();

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
            'passengers' => 'required|integer|min:1,max:500',
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
        $general = new General();
        $validated = $general->validateMe($request, $rules, $messages);
        if($validated) {


            /* check if driver is available for this time slot */
            $from = date('Y-m-d H:i:s', strtotime($request->from_date));
            $to = date('Y-m-d H:i:s', strtotime($request->to_date));

            $alreadyBooked = false;
            /* check for driver bookings */
            $driverBooked = DriverBooking::where('driver_id', $request->driver_id)
                ->where('with_vehicle', 1)->where('booking_id', '!=', $request->id)
                ->where(function ($query) use ($from, $to) {
                    $query
                        ->whereBetween('from_date', [$from, $to])
                        ->orWhere(function ($query) use ($from, $to) {
                            $query->whereBetween('to_date', [$from, $to]);
                        });
                })->first();
            if ($driverBooked) {

                $alreadyBooked = true;
                toastr()->error(__('hire.already_booked'));
            }
            /* check for vehicle bookings */
            $vehicleBooked = Tour::where('vehicle_id', $request->vehicle_id)
                ->where('id', '!=', $request->id)
                ->where('status', '>', 1)->where('status', '<', 5)
                ->where(function ($query) use ($from, $to) {
                    $query
                        ->whereBetween('from_date', [$from, $to])
                        ->orWhere(function ($query) use ($from, $to) {
                            $query->whereBetween('to_date', [$from, $to]);
                        });
                })->first();
            if ($vehicleBooked) {

                $alreadyBooked = true;
                toastr()->error(__('tour.vehicle_already_booked'));
            }


            if (!$alreadyBooked) {

                $tour = Tour::find($request->id);
                $tour->status = (int)$request->status;
                $tour->customer_id = (int)$request->customer_id;
                $tour->vehicle_id = (int)$request->vehicle_id;
                $tour->driver_id = (int)$request->driver_id;
                $tour->from_date = date('Y-m-d H:i', strtotime($request->from_date));
                $tour->to_date = date('Y-m-d H:i', strtotime($request->to_date));
                $tour->passengers = (int)$request->passengers;
                $tour->price = (int)$request->price;
                $tour->guide = $request->guide;
                if ($tour->save()) {
                    toastr()->success(__('tour.updated'));


                    /* if hiring status is not Draft and Canceled */
                    DriverBooking::where('driver_id', $request->driver_id)
                        ->where('booking_id', $tour->id)
                        ->where('with_vehicle', 1)->delete();

                    if ($request->status > 1 && $request->status < 5) {

                        DriverBooking::create([
                            'booking_id' => $tour->id,
                            'driver_id' => $request->driver_id,
                            'from_date' => $from,
                            'to_date' => $to,
                            'with_vehicle' => 1]);
                    }
                }

                /* if files uploaded */
                $files = [];
                $attachments = [];

                /* delete old tour attachments */
                TourAttachment::where('tour_id', $tour->id)->delete();

                /* already uploaded files */
                if (!empty($request->old_attachments)) {

                    foreach ($request->old_attachments as $attachment) {

                        $a = explode('.', $attachment);
                        $ext = $a[count($a) - 1];
                        $files [] = ['tour_id' => $tour->id, 'file' => $attachment, 'ext' => $ext];
                    }
                }
                /* new uploaded files */
                if (!empty($request->temp_key)) {
                    $attachments = Attachment::where('temp_key', $request->temp_key)->get();
                }

                foreach ($attachments as $attachment) {
                    $files [] = ['tour_id' => $tour->id, 'file' => $attachment->file, 'ext' => $attachment->ext];
                }
                if (count($files)) {
                    TourAttachment::insert($files);
                }
                unset($files);
                unset($attachments);
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }
        return redirect('/tours');
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
