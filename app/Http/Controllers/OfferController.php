<?php

namespace App\Http\Controllers;

use App\Mail\OfferEmail;
use App\Models\Inquiry;
use App\Models\InquiryAddress;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $inquiries      =   Inquiry::orderBy('id','DESC')->paginate(10);
        $pageTitle      =   __('offer.heading.index');
        return view('offers.index',compact('pageTitle','inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle      =   __('offer.heading.add');
        return view('offers.create',compact('pageTitle'));
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
            'name'              => 'required',
            'email'             => 'required|email',
            'from_address'      => 'required',
            'to_address'        => 'required',
            'departure_date'    =>  'required',
            'arrival_date'      =>  'sometimes|required',
            'seats'             =>  'required',
        ];
        $this->validate(request(), $rules);

        $inquiry    =   Inquiry::create([
           'name'           =>  $request->name,
           'email'          =>  $request->email,
           'seats'          =>  $request->seats,
           'is_web'         =>  0,
           'with_driver'    =>  1,
           'status'         =>  0
        ]);

        InquiryAddress::create([
           'inquiry_id'     =>  $inquiry->id,
           'from_address'   =>  $request->from_address,
            'to_address'    =>  $request->to_address,
            'time'          =>  !empty($request->departure_date)?date('Y-m-d H:i:s',strtotime($request->departure_date)):'',
            'trip_type'     =>  1,
        ]);
        if ($request->trip_type){
            InquiryAddress::create([
                'inquiry_id'     =>  $inquiry->id,
                'from_address'   =>  $request->to_address,
                'to_address'    =>  $request->from_address,
                'time'          =>  !empty($request->arrival_date)?date('Y-m-d H:i:s',strtotime($request->arrival_date)):'',
                'trip_type'     =>  2,
            ]);
        }
        toastr()->success(__('offer.success'));
        return redirect()->route('offers.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inquiry    =   Inquiry::find($id);
        $pageTitle      =   __('offer.heading.edit');
        return view('offers.edit',compact('pageTitle','inquiry'));
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
            'name'              => 'required',
            'email'             => 'required|email',
            'from_address'      => 'required',
            'to_address'        => 'required',
            'departure_date'    =>  'required',
            'arrival_date'      =>  'sometimes|required',
            'seats'             =>  'required',
        ];
        $this->validate(request(), $rules);

        $inquiry    =   Inquiry::find($id);

        $inquiry->update([
            'name'           =>  $request->name,
            'email'          =>  $request->email,
            'seats'          =>  $request->seats,
            'is_web'         =>  !empty($inquiry->is_web)?$inquiry->is_web:0,
            'with_driver'    =>  1,
            'status'         =>  !empty($inquiry->status)?$inquiry->status:0,
        ]);
        $inquiryAddress    =   InquiryAddress::where('inquiry_id','=',$inquiry->id)->get();
        $inquiryAddress[0]->update([
            'inquiry_id'     =>  $inquiry->id,
            'from_address'   =>  $request->from_address,
            'to_address'    =>  $request->to_address,
            'time'          =>  !empty($request->departure_date)?date('Y-m-d H:i:s',strtotime($request->departure_date)):'',
            'trip_type'     =>  1,
        ]);

        if (!empty($request->arrival_date)){
            if (!empty($inquiryAddress[1])){
                $inquiryAddress[1]->update([
                    'inquiry_id'     =>  $inquiry->id,
                    'from_address'   =>  $request->to_address,
                    'to_address'    =>  $request->from_address,
                    'time'          =>  !empty($request->arrival_date)?date('Y-m-d H:i:s',strtotime($request->arrival_date)):'',
                    'trip_type'     =>  2,
                ]);
            }else{
                InquiryAddress::create([
                    'inquiry_id'     =>  $inquiry->id,
                    'from_address'   =>  $request->to_address,
                    'to_address'    =>  $request->from_address,
                    'time'          =>  !empty($request->arrival_date)?date('Y-m-d H:i:s',strtotime($request->arrival_date)):'',
                    'trip_type'     =>  2,
                ]);
            }
        }elseif (!empty($inquiryAddress[1])){
            $inquiryAddress[1]->delete();
        }




        toastr()->success(__('offer.success_update'));
        return redirect()->route('offers.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modal_mail(Request $request)
    {
        $inquiry    =   Inquiry::find($request->inquiry_id);
        return view('offers.send_mail',compact('inquiry'));
    }

    public function send_mail(Request  $request)
    {
        if ($request->price){
            Offer::create([
               'inquiry_id' =>  $request->inquiry_id,
                'price'     =>  $request->price
            ]);
            $inquiry    =   Inquiry::find($request->inquiry_id);
            $inquiry->update([
               'status'     =>  1
            ]);
            Mail::send(new OfferEmail($request->inquiry_id,$request->price));
            toastr()->success(__('offer.mail_sent'));
            return redirect()->route('offers.index');
        }else{
            toastr()->error(__('offer.pls_enter_price'));
            return redirect()->route('offers.index');
        }

    }

    public function ecoach_web(Request      $request)
    {


        if ($request->name && $request->departure_date && $request->to_address && $request->email && $request->to_address){
            $inquiry    =   Inquiry::create([
                'name'           =>  $request->name,
                'email'          =>  $request->email,
                'seats'          =>  $request->seats,
                'is_web'         =>  1,
                'with_driver'    =>  1,
                'status'         =>  0
            ]);

            InquiryAddress::create([
                'inquiry_id'     =>  $inquiry->id,
                'from_address'   =>  $request->from_address,
                'to_address'    =>  $request->to_address,
                'time'          =>  !empty($request->departure_date)?date('Y-m-d H:i:s',strtotime($request->departure_date.$request->departure_time)):'',
                'trip_type'     =>  1,
            ]);
            return  $inquiry;
        }elseif ($request->name_two && $request->from_address_two && $request->to_address_two &&$request->departure_date_two &&$request->arrival_date_two){
            $inquiry    =   Inquiry::create([
                'name'           =>  $request->name_two,
                'email'          =>  $request->email_two,
                'seats'          =>  $request->seats_two,
                'is_web'         =>  1,
                'with_driver'    =>  1,
                'status'         =>  0
            ]);

            InquiryAddress::create([
                'inquiry_id'     =>  $inquiry->id,
                'from_address'   =>  $request->from_address_two,
                'to_address'    =>  $request->to_address_two,
                'time'          =>  !empty($request->departure_date_two)?date('Y-m-d H:i:s',strtotime($request->departure_date_two.$request->departure_time_two)):'',
                'trip_type'     =>  1,
            ]);
            InquiryAddress::create([
                'inquiry_id'     =>  $inquiry->id,
                'from_address'   =>  $request->to_address_two,
                'to_address'    =>  $request->from_address_two,
                'time'          =>  !empty($request->arrival_date_two)?date('Y-m-d H:i:s',strtotime($request->arrival_date_two.$request->arrival_time_two)):'',
                'trip_type'     =>  2,
            ]);
            return  $inquiry;
        }
    }
    public function destroy($id)
    {
        //
    }
}
