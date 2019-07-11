<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\Customer;
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

    public function index(){

        $pageTitle = __('tour_invoice.heading.index');
        $customers = Customer::where('status','1')->get(['name','id']);
        return view('invoices.tour.index',compact('pageTitle','customers'));
    }
    public function show(TourInvoice $TourInvoice){
        return $TourInvoice;
    }
    public function create(){

        $pageTitle = __('tour_invoice.heading.add');
        $customers = Customer::where('status','1')->get(['name','id']);
        return view('invoices.tour.create',compact('pageTitle','customers'));
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


        /* save invoice */
        $invoice  = new TourInvoice;
        $invoice->customer_id = (int)$request->customer_id;
        $invoice->total = (int)$request->total;
        $invoice->status = 1;
        $invoice->save();


        /* save invoice details */
        foreach($request->ids as $id){

            $invoice_detail = new TourInvoiceDetail;
            $invoice_detail->invoice_id = $invoice->id;
            $invoice_detail->tour_id = $id;
            $invoice_detail->save();
        }

        /* change Tours status to invoiced */
        if(!empty($request->ids)){

            Tour::whereIn('id',$request->ids)->update(['status'=>3]);
        }
        toastr()->success(__('driver_invoice.generated'));
        return redirect('/tour-invoices');
    }
    public function downloadInvoice(Request $request){



        $total=0;
        $invoice = TourInvoice::find((int)$request->id);

        // Invoice Number
        $general = new General();
        $invoice->id = $general->invoiceNumber($invoice->id);

        $customer = $invoice->customer;
        $invoice_details = TourInvoiceDetail::where('invoice_id',$invoice->id)->get();
        $tours =[];
        foreach($invoice_details as $inv){
            $inv->tour;
            $inv->tour->driver;
            $inv->tour->customer;
            $inv->tour->vehicle;
            $total += $inv->tour->price;

            $tours[] = $inv->tour;
        }

        $vat = ($total/100)*19;

        $pdf = PDF::loadView('invoices.tour.pdf_design', compact('customer','invoice','tours','total','vat'));
        return $pdf->download('tours_invoice.pdf');
    }
}
