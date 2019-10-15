<?php

namespace App\Http\Controllers;

use App\Helpers\General;
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
    public function getList(Request $request)
    {

        $orderColumn = 'id';
        $dir = 'desc';

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==1){
            $orderColumn = 'name';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==2){
            $orderColumn = 'customer';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==3){
            $orderColumn = 'from';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==4){
            $orderColumn = 'to';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==5){
            $orderColumn = 'departuredate';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==6){
            $orderColumn = 'arrivaldate';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==7){
            $orderColumn = 'type';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==8){
            $orderColumn = 'email';
        }
        if(!empty($request->order[0]['dir'])){
            $dir = $request->order[0]['dir'];
        }


        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }else{
            $draw = 0;
        }

        $query = Inquiry::where('id','>',0);
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

            $query = Inquiry::where('name', 'LIKE','%'.$search.'%')
                ->orWhere('email', 'LIKE','%'.$search.'%')
                ->orWhere('is_web', 'LIKE','%'.$search.'%');


        }
        $recordsTotal = $query->count();
        $rows = $query->orderBy($orderColumn,$dir)->offset($start)->limit($limit)->get(['id','name','email','is_web','status']);

        $data=[];
        foreach($rows as $row){

            $row->id;
            $row->name;
            $row->from_address  =   $row->inquiryaddresses[0]->from_address;
            $row->to_address  = $row->inquiryaddresses[0]->to_address;
            $row->time0 = !empty($row->inquiryaddresses[0]->time)?date('M j, Y, g:i a',strtotime($row->inquiryaddresses[0]->time)):'';
            $row->time1 = !empty($row->inquiryaddresses[1])?date('M j, Y, g:i a',strtotime($row->inquiryaddresses[1]->time)):'';
            $row->type  =   !empty($row->inquiryaddresses[1])?__('offer.two_way'):__('offer.one_way');
            $row->email;
            $row->web   =   !empty($row->is_web)?__('messages.yes'):__('messages.no');
            $data[] = $row;
        }
        $recordsFiltered = $query->offset($start)->limit($limit)->count();

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
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
           'description'    =>  $request->description,
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
            'description'    =>  $request->description,
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
            $offer = Offer::create([
               'inquiry_id' =>  $request->inquiry_id,
                'price'     =>  $request->price
            ]);
            $general = new General();
            $inquiry    =   Inquiry::find($request->inquiry_id);
            $inquiry->update([
               'status'     =>  1
            ]);
            Mail::send(new OfferEmail($request->inquiry_id,$request->price,$offer->id));
            toastr()->success(__('offer.mail_sent'));
            return redirect()->route('offers.index');
        }else{
            toastr()->error(__('offer.pls_enter_price'));
            return redirect()->route('offers.index');
        }

    }

    public function offer_view(Request $request)
    {

        $inquiry    =   Inquiry::find($request->inquiry_id);
        return view('offers.show',compact('inquiry'));
    }
    public function ecoach_web(Request      $request)
    {


        if ($request->name && $request->departure_date && $request->to_address && $request->email){
            $inquiry    =   Inquiry::create([
                'name'           =>  $request->name,
                'email'          =>  $request->email,
                'seats'          =>  $request->seats,
                'description'   =>  $request->description,
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
                'description'   =>  $request->description_two,
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
