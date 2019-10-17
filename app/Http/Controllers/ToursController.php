<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\Mail\TourConfirmation;
use App\Mail\TourConfirmationInvoice;
use App\Models\DriverBooking;
use App\Models\OfferTour;
use App\Models\TourInvoice;
use App\Models\TourInvoiceDetail;
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
use Illuminate\Support\Facades\Mail;


class ToursController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function calendar(Request $request)
    {
        $pageTitle = __('messages.calendar');
        $rows = Tour::where('status','>',1)->where('status','<',4)->whereNull('deleted_at')->get(
            ['id','vehicle_id','customer_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $colors = ['#ff3908','#0bb9d4','#0da837','#d6c809','#db7107'];

        $events = []; $i = $j=0;
        foreach($rows as $row){

            if($j>4){
                $j = $j-5;
            }

            $row->driver;
            $row->customer;

//            $vehicles[] = $row->vehicle;
            $events[$i]['id'] = $row->id;
            $events[$i]['resourceId'] = $row->vehicle->id;
            $events[$i]['start'] = $row->from_date;
            $events[$i]['end'] = $row->to_date;


            $events[$i]['title'] = ' 
            Customer: '.$row->customer->name.' 
            Driver: '.$row->driver->driver_name.' 
            vehicle: '.$row->vehicle->name;
            $events[$i]['url'] = url('/tour/'.$row->id);
            $events[$i]['backgroundColor'] = !empty($row->vehicle->color)?$row->vehicle->color:'#ff3908';

            $j++; $i++;
        }

//        dd($events);
        return view('tours.calendar',compact('events','pageTitle'));
    }
    public function getList(Request $request)
    {
        $orderColumn = 'id';
        $dir = 'desc';

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==0){
            $orderColumn = 'id';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==1){
            $orderColumn = 'customer_id';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==2){
            $orderColumn = 'vehicle_id';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==3){
            $orderColumn = 'from_date';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==4){
            $orderColumn = 'to_date';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==5){
            $orderColumn = 'driver_id';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==6){
            $orderColumn = 'passengers';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==7){
            $orderColumn = 'price';
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

            $from = date('Y-m-d ',strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $to = date('Y-m-d ',strtotime($request->to_date));
        }
        if(!empty($from)){

            $query = $query->whereDate('from_date','>=',$from);
        }
        if(!empty($to)){

            $query = $query->whereDate('to_date','<=',$to);
        }

        $recordsTotal = $query->count();

        $rows = $query->orderBy($orderColumn,$dir)->offset($start)->limit($limit)->get([
            'id','customer_id','vehicle_id','driver_id','status','passengers','guide','price','from_date','to_date','custom_tour_id']);

        $data=[];
        foreach($rows as $row){

            $row->custom_id =   $row->id;
            $row->vehicle;
            $row->driver_name;
            $row->customer;
            $row->from_date = !empty($row->from_date)?date('d.m.Y H:i',strtotime($row->from_date)):'';
            $row->to_date   = !empty($row->to_date)?date('d.m.Y H:i',strtotime($row->to_date)):'';
            $data[] = $row;
        }

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function index()
    {
        $pageTitle = __('messages.tours');

        $tour_statuses = TourStatus::get(['id','name']);
        $vehicles = Vehicle::orderBy('name','ASC')->get();
        $customers  =   Customer::orderBy('name','ASC')->get();
        $drivers  =   Driver::orderBy('driver_name','ASC')->get();

        return view('tours.index',compact('vehicles','tour_statuses','pageTitle','customers','drivers'));
    }

    public function create(Request $request)
    {

        $pageTitle = __('tour.heading.add');
        $general = new General();
        $randomKey = $general->randomKey();
        $tour_statuses = TourStatus::whereIn('id',[1,2,5])->get(['id','name']);
        $vehicles = Vehicle::orderBy('name','ASC')->where('status','1')->get();
        $customers  =   Customer::orderBy('name','ASC')->where('status','=',1)->get();
        $drivers  =   Driver::orderBy('driver_name','ASC')->where('status','=',1)->get();

        return view('tours.add',compact('pageTitle','vehicles','tour_statuses','randomKey','customers','drivers','request'));
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
            'to_date' => 'sometimes|required',
            /*'to_date' => 'required',*/
            'from_address' => 'required',
            'to_address' => 'required',
            'price' => 'required',
            /*'passengers' => 'required|integer|min:1,max:500',*/
            'description' => 'required',
//            'guide' => 'required',
        ];
        $messages = [
            'customer_id.required' => 'Please select customer.',
            'vehicle_id.required' => 'Please select vehicle.',
            'from_date.required' => 'Please provide tour starting date/time.',
            'to_date.required' => 'Please provide tour end date/time.',
            'driver_id.required' => 'Please select driver.',
            'price.required' => 'Please provide tour price.',
            'passengers.required' => 'Please provide number of passengers.',
            'description.required' => 'Please provide description.',
        ];
        $this->validate(request(), $rules, $messages);

        if(true){

            /* check if driver is available for this time slot */
            $from   =   '';
            $to     =   '';
            if ($request->from_date){
                $from = date('Y-m-d H:i:s', strtotime($request->from_date));
            }
           if ($request->to_date){
               $to = empty($request->to_date) ? null : date('Y-m-d H:i', strtotime($request->to_date));
           }
            $alreadyBooked = false;
            /* check for driver bookings */


            if ($request->driver_id == 'foo'){
                $request->driver_id =0;
            }
            if (!empty($request->driver_id)){
                $driverBooked = DriverBooking::where('driver_id', $request->driver_id)
                    ->where('from_date','<=',$from)
                    ->where('to_date','>=',$from)
                    ->first();

                $driverBooked2 = DriverBooking::where('driver_id', $request->driver_id)
                    ->where('from_date','<=',$to)
                    ->where('to_date','>=',$to)
                    ->first();

                if ($driverBooked ||  $driverBooked2) {

                    $alreadyBooked = true;
                    toastr()->error(__('hire.already_booked'));
                }
            }
            if (!empty($request->driver_id)){
                $vehicleBooked = Tour::where('vehicle_id', $request->vehicle_id)
                    ->where('status', '>', 1)->where('status', '<', 5)
                    ->where('from_date','<=',$from)
                    ->where('to_date','>=',$from)
                    ->first();

                $vehicleBooked2 = Tour::where('vehicle_id', $request->vehicle_id)
                    ->where('status', '>', 1)->where('status', '<', 5)
                    ->where('from_date','<=',$to)
                    ->where('to_date','>=',$to)
                    ->first();
                if ($vehicleBooked || $vehicleBooked2) {

                    $alreadyBooked = true;
                    toastr()->error(__('tour.vehicle_already_booked'));
                }
            }
            /* check for vehicle bookings */
            if (!$alreadyBooked) {
                $tour = new Tour;
                $tour->status = !empty($request->status)?(int)$request->status:1;
                $tour->customer_id = !empty($request->customer_id)?(int)$request->customer_id:0;
                $tour->vehicle_id = !empty($request->vehicle_id)?(int)$request->vehicle_id:0;
                $tour->driver_id = !empty($request->driver_id)?(int)$request->driver_id:0;
                $tour->from_date = !empty($request->from_date)?date('Y-m-d H:i', strtotime($request->from_date)):null;
                $tour->to_date = empty($request->to_date) ? null : date('Y-m-d H:i', strtotime($request->to_date));


                $tour->passengers = !empty($request->passengers)?(int)$request->passengers:0;
                $tour->price = !empty($request->price)?(int)$request->price:0;
                $tour->guide = !empty($request->guide)?$request->guide:'';
                $tour->description = !empty($request->description)?$request->description:'';
                $tour->from_address = !empty($request->from_address)?$request->from_address:'';
                $tour->to_address = !empty($request->to_address)?$request->to_address:'';
                $tour->custom_tour_id = !empty($request->custom_tour_id)?$request->custom_tour_id:'';
                /*$tour->color = $request->color;*/

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
                            'to_date' => !empty($to)?$to:null,
                            'with_vehicle' => 1]);
                    }
                    if ($request->offer_id){
                        OfferTour::create([
                            'offer_id'   =>   $request->offer_id,
                            'tour_id'   =>  $tour->id
                        ]);
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
        if ($request->returnFlag){
            return redirect()->back();
        }else{
            return redirect('/tours');
        }

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
        $Tour->id;
        $Tour->customer_id;
        $Tour->vehicle;
        $Tour->driver;
        $Tour->customer;
        $Tour->attachments;
        $Tour->from_date = date('d.m.Y H:i',strtotime($Tour->from_date));
        $Tour->to_date   = !empty($Tour->to_date)?date('d.m.Y H:i',strtotime($Tour->to_date)):'None';
        $Tour->tourdetails;
        $Tour->status;

        return $Tour;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $pageTitle = __('messages.edit_tour');
        $tour = Tour::find($id);
        $vehicles = Vehicle::orderBy('name','ASC')->get();
        $customers  =   Customer::orderBy('name','ASC')->get();
        $drivers  =   Driver::orderBy('driver_name','ASC')->where('status','=',1)->get();
        $general = new General();
        $randomKey = $general->randomKey();
        $tour_statuses = TourStatus::whereIn('id',[1,2,5])->get(['id','name']);
        $attachments = TourAttachment::where('tour_id',$id)->get();

        return view('tours.add',compact('tour','pageTitle','vehicles','tour_statuses','randomKey','attachments','customers','drivers','request'));
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
            'to_date' => 'sometimes|required',
            'from_address' => 'required',
            'to_address' => 'required',
            /*'driver_id' => 'required|integer',*/
            'price' => 'required',
            /*'passengers' => 'required|integer|min:1,max:500',*/
            'description' => 'required',
            /*'color' => 'required'*/
//            'guide' => 'required',
        ];
        $messages = [
            'customer_id.required' => 'Please select customer.',
            'vehicle_id.required' => 'Please select vehicle.',
            'from_date.required' => 'Please provide tour starting date/time.',
            'to_date.required' => 'Please provide tour end date/time.',
            'driver_id.required' => 'Please select driver.',
            'price.required' => 'Please provide tour price.',
            'passengers.required' => 'Please provide number of passengers.',
            'description.required' => 'Please provide description.',
        ];
        $this->validate(request(), $rules, $messages);
        if(true){

            /* check if driver is available for this time slot */
            $from = date('Y-m-d H:i:s', strtotime($request->from_date));
            $to = date('Y-m-d H:i:s', strtotime($request->to_date));

            $alreadyBooked = false;
            /* check for driver bookings */
            if ($request->driver_id == 'foo'){
                $request->driver_id =0;
            }
            $driverBooked = DriverBooking::where('driver_id', $request->driver_id)
                ->where('with_vehicle', 1)->where('booking_id', '!=', $request->id)
                ->where('from_date','<=',$from)
                ->where('to_date','>=',$from)
                ->first();

            $driverBooked2 = DriverBooking::where('driver_id', $request->driver_id)
                ->where('with_vehicle', 1)->where('booking_id', '!=', $request->id)
                ->where('from_date','<=',$to)
                ->where('to_date','>=',$to)
                ->first();

            if ($driverBooked ||  $driverBooked2) {

                $alreadyBooked = true;
                toastr()->error(__('hire.already_booked'));
            }
            /* check for vehicle bookings */
            $vehicleBooked = Tour::where('vehicle_id', $request->vehicle_id)
                ->where('id', '!=', $request->id)
                ->where('status', '>', 1)->where('status', '<', 5)
                ->where('from_date','<=',$from)
                ->where('to_date','>=',$from)
                ->first();

            $vehicleBooked2 = Tour::where('vehicle_id', $request->vehicle_id)
                ->where('id', '!=', $request->id)
                ->where('status', '>', 1)->where('status', '<', 5)
                ->where('from_date','<=',$to)
                ->where('to_date','>=',$to)
                ->first();
            if ($vehicleBooked || $vehicleBooked2) {

                $alreadyBooked = true;
                toastr()->error(__('tour.vehicle_already_booked'));
            }
            
            if (!$alreadyBooked) {

                $tour = Tour::find($request->id);
                $tour->status = (int)$request->status;
                $tour->customer_id = (int)$request->customer_id;
                $tour->vehicle_id = (int)$request->vehicle_id;
                $tour->driver_id = !empty($request->driver_id)?(int)$request->driver_id:0;
                $tour->from_date = date('Y-m-d H:i', strtotime($request->from_date));
                $tour->to_date = date('Y-m-d H:i', strtotime($request->to_date));
                $tour->passengers = !empty($request->passengers)?(int)$request->passengers:0;
                $tour->price = (int)$request->price;
                $tour->description = $request->description;
                $tour->guide = $request->guide;
                $tour->from_address = !empty($request->from_address)?$request->from_address:'';
                $tour->to_address = !empty($request->to_address)?$request->to_address:'';
                $tour->custom_tour_id = !empty($request->custom_tour_id)?$request->custom_tour_id:'';
                /*$tour->color = $request->color;*/
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

    public function tour_customer_email(Request  $request)
    {
        if ($request->send_invoice){
            /*$invoice = TourInvoiceDetail::where('tour_id','=',$request->tour_id_email)->first();*/
            $invoice = TourInvoiceDetail::join('tour_invoice as ti','ti.id','tour_invoice_details.invoice_id')
                ->where('ti.is_bulk',0)
                ->where('tour_id','=',$request->tour_id_email)
                ->select('tour_invoice_details.id')
                ->first();

            if ($invoice){
                Mail::send(new TourConfirmationInvoice($request->customer_id_email,$request->tour_id_email));
            }else{
                toastr()->error(__('tour.pls_create_invoice'));
                return redirect()->route('tours.index');
            }

        }else{
            Mail::send(new TourConfirmation($request->customer_id_email,$request->tour_id_email));
        }
        toastr()->success(__('tour.email'));
        return redirect('/tours');
    }
    public function tour_send_email(Request  $request)
    {

        $tour = Tour::find($request->tour_id);
        return view('tours.email',compact('tour'));

    }

    public function get_fields(){
        $vehicles = Vehicle::orderBy('name','ASC')->get();
        $customers  =   Customer::orderBy('name','ASC')->where('status','=',1)->get();
        $drivers  =   Driver::orderBy('driver_name','ASC')->where('status','=',1)->get();

        return response()->json([
           'vehicles'       =>   $vehicles,
           'customers'      =>   $customers,
           'drivers'        =>   $drivers,
        ]);
    }
    public function destroy($id)
    {
        $tour = Tour::find($id);
        $tour->delete();
    }

}
