<?php

namespace App\Http\Controllers;

use App\Models\TourStatus;
use App\Models\TourAttachment;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Tour;
use App\Models\Attachment;
use App\Driver;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ToursController extends Controller
{
    public function index()
    {
        $pageTitle = 'Tours';
        $tours = tours::all();
        return view('tours.index',compact('tours','pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Add Tour';
        $general = new General();
        $randomKey = $general->randomKey();
        $vehicles = Vehicle::get(['name','make','year','transmission','licensePlate','id']);
        $tour_statuses = TourStatus::get(['id','name']);
        $customers = Customer::pluck('name','id');
        $drivers = Driver::pluck('driver_name','id');

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
//        dd($request->all());

        $attachments=[];
        if(!empty($request->temp_key)){
            $attachments = Attachment::where('temp_key',$request->temp_key)->get();
        }

        $data = [
            'status' => (int)$request->status,
            'customer_id' => (int)$request->customer_id,
            'vehicle_id' => (int)$request->vehicle_id,
            'from_date' => date('Y-m-d h:i:s',strtotime($request->from_date)),
            'to_date'  => date('Y-m-d h:i:s',strtotime($request->to_date)),
            'driver_id' => $request->driver_id,
            'passengers' => $request->passengers,
            'guide' => $request->guide,
            'price' => $request->price
        ];

        $tour = new Tour($data);
        $tour->save();
        dd($data);

        $files=[];
        foreach($attachments as $attachment){
            $files[] = ['tour_id'=>$tour->id,'file'=>$attachment->file,'ext'=>$attachment->ext];
        }
        TourAttachment::insert($files);
        unset($files); unset($attachments);
//        unset($request);
        return redirect('/tours')->with('success', 'New Tour has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'Show Tour';
        $tour = tours::find($id);

        return view('tours.show',compact('tour','pageTitle'));
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
        $tour = tours::find($id);

        return view('tours.edit', compact('tour','pageTitle'));
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
            'tour_name'=>'required',
            'departure_date'=> 'required',
            'price' => 'required',
            'location' => 'required',
            'destination' => 'required',
        ]);

        $tour = tours::find($id);

        $tour->tour_name = $request->get('tour_name');
        $tour->departure_date = $request->get('departure_date');
        $tour->tour_id  = $request->get('tour_id');
        $tour->price = $request->get('price');
        $tour->location = $request->get('location');
        $tour->destination = $request->get('destination');
        $tour->vehicle_id = $request->get('vehicle_id');
        $tour->driver_id = $request->get('driver_id');
        $tour->customer_id = $request->get('customer_id');

        $tour->save();

        return redirect('/tours')->with('success', 'Tour has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tour = tours::find($id);
        $tour->delete();

        return redirect('/tours')->with('success', 'tour has been deleted Successfully');
    }

}
