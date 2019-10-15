<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\HireDriver;
use App\Models\Tour;
use App\Models\TourInvoice;
use App\Models\TourInvoiceDetail;
use Illuminate\Http\Request;
use PDF;


class TourInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        $pageTitle = __('tour_invoice.heading.index');
        $customers  =   Customer::orderBy('name','ASC')->where('status','=',1)->get();
        $query = TourInvoice::where('status','>',0);
        if(!empty($request->status)){
            $query = TourInvoice::where('status',$request->status);
        }

        if(!empty($request->id)){
            $query = $query->where('id',(int)$request->id);
        }
        if(!empty($request->customer_id)){
            $query = $query->where('customer_id',$request->customer_id);
        }

        $from =''; $to ='';
        if(!empty($request->from_date)){

            $from = date('Y-m-d h:i',strtotime($request->from_date)).':00';
        }
        if(!empty($request->to_date)){
            $to = date('Y-m-d h:i',strtotime($request->to_date)).':59';
        }
        if(!empty($from) && !empty($to)){

            $query = $query->whereBetween('created_at', [$from, $to]);

        }elseif(!empty($from)){

            $query = $query->where('created_at','>=',$from);
        }elseif(!empty($to)){

            $query = $query->where('created_at','<=',$to);
        }
        $rows = $query->orderBy('id','DESC')->paginate(10);
        $general = new General();
        foreach($rows as $row){

            $row->invoice_id = (string)$general->invoiceNumber($row->id);
            $row->customer;
            $row->status = ($row->status == 1)?'Unpaid':'Paid';
            $row->created = date('d.m.Y H:i',strtotime($row->created_at));
        }

        return view('invoices.tour.index',compact('pageTitle','rows','customers'));
    }
    public function show(TourInvoice $TourInvoice){
        return $TourInvoice;
    }
    public function create(Request $request){

        $pageTitle = __('tour_invoice.heading.add');
        $customers = Customer::where('status','1')->get(['name','id']);

        $query = Tour::where('status',2);

        if(!empty($request->id)){
            $query = $query->where('id',(int)$request->id);
        }
        if(!empty($request->customer_id)){
            $query = $query->where('customer_id',$request->customer_id);
        }

        $from =''; $to ='';
        if(!empty($request->from_date)){

            $from = date('Y-m-d h:i',strtotime($request->from_date)).':00';
        }
        if(!empty($request->to_date)){
            $to = date('Y-m-d h:i',strtotime($request->to_date)).':59';
        }
        if(!empty($from) && !empty($to)){

            $query = $query->whereBetween('from_date', [$from, $to]);

        }elseif(!empty($from)){

            $query = $query->where('from_date','>=',$from);
        }elseif(!empty($to)){

            $query = $query->where('from_date','<=',$to);
        }

        $rows = $query->orderBy('id','DESC')->paginate(10);
        foreach($rows as $row){

            $row->driver;
            $row->customer;
            $row->vehicle;
            $row->from_date = date('d.m.Y H:i',strtotime($row->from_date));
            $row->to_date   = date('d.m.Y H:i',strtotime($row->to_date));
        }
        return view('invoices.tour.create',compact('pageTitle','customers','rows'));
    }

    public function getList(Request $request)
    {
//        dd($request->all());
        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        if(!empty($request->input('status'))){
            $query = TourInvoice::where('status',$request->input('status'));
        }else{
            $query = TourInvoice::where('status','>',0);
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

        $from =''; $to ='';
        if(!empty($request->from_date)){

            $from = date('Y-m-d h:i',strtotime($request->from_date)).':00';
        }
        if(!empty($request->to_date)){
            $to = date('Y-m-d h:i',strtotime($request->to_date)).':59';
        }
        if(!empty($from) && !empty($to)){

            $query = $query->whereBetween('created_at', [$from, $to]);

        }elseif(!empty($from)){

            $query = $query->where('created_at','>=',$from);
        }elseif(!empty($to)){

            $query = $query->where('created_at','<=',$to);
        }

        $recordsTotal = $query->count();
        $rows = $query->orderBy('id','DESC')->offset($start)->limit($limit)->get([
            'id','customer_id','status','total','created_at']);

        $data=[];

        $general = new General();

        foreach($rows as $row){

            $row->invoice_id = (string)$general->invoiceNumber($row->id);
            $row->customer;
            $row->status = ($row->status == 1)?'Unpaid':'Paid';
//            $row['created_at'] = date('d/m/Y h:i A',strtotime($row['created_at']));
            $data[] = $row;
        }
//        dd($data);
        unset($rows);
        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }


    public function markAsPaid(Request $request){

        if(!empty($request->ids)){

            foreach($request->ids as $id) {

                $invoice = TourInvoice::find($id);
                $invoice->status = 2;
                $invoice->save();
            }
        }
        toastr()->success(__('tour_invoice.mark_paid'));
        return redirect('/tour-invoices');
    }
    public function generateInvoice(Request $request){

        if(!empty($request->customer_id) && $request->customer_id>0) {

            /* save invoice */
            $invoice = new TourInvoice;
            $invoice->customer_id = (int)$request->customer_id;
            $invoice->total = (int)$request->total;
            $invoice->status = 1;
            $invoice->save();

            /* save invoice details */
            foreach ($request->ids as $id) {

                $invoice_detail = new TourInvoiceDetail;
                $invoice_detail->invoice_id = $invoice->id;
                $invoice_detail->tour_id = $id;
                $invoice_detail->save();

            }

            /* change Tours status to invoiced */
            if (!empty($request->ids)) {

                Tour::whereIn('id', $request->ids)->update(['status' => 3]);
            }
            toastr()->success(__('driver_invoice.generated'));
        }else{
            toastr()->error('Error!');
        }
        return redirect()->back();
    }
    public function downloadInvoice(Request $request){


        $total=0;
        $invoice = TourInvoice::find((int)$request->id);

        // Invoice Number
        $general = new General();
        $invoice->id = $general->invoiceNumber($invoice->id);

        $customer = $invoice->customer;
        $invoice_details = TourInvoiceDetail::where('invoice_id',$invoice->id)->get();
        $tour ='';
        foreach($invoice_details as $inv){
            $inv->tour;
            $inv->tour->driver;
            $inv->tour->customer;
            $inv->tour->vehicle;
            $total += $inv->tour->price;

            $tour = $inv->tour;
        }

        $vat = ($total/100)*19;

        $invoice_date   =   date('Y-m-d');
        $html   =   view('invoices.tour.pdf_design', compact('customer','invoice','tour','total','vat','invoice_date'));
        return General::DownloadPdf("P",$html,"tour_invoice","Invoice");
        /*$pdf = PDF::loadView('invoices.tour.pdf_design', compact('customer','invoice','tour','total','vat','invoice_date'));

        return $pdf->download('tours_invoice.pdf');*/
    }

    public function driver_pdf(Request  $request){

        $tour   =   Tour::find($request->tour_id);
        $driver =   Driver::find($request->driver_id);
        $details    =   $request->details;
        $general = new General();
        $number = $general->invoiceNumber($request->tour_id);
        $html   =   view('driver-form.driver_form',compact('date','driver','tour','number','details'));

        return General::CreatePdf("P",$html,"driver_form","Form");



    }
}
