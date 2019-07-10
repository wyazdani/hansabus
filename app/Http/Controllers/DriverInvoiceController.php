<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\DriverInvoice;
use App\Models\DriverInvoiceDetail;
use App\Models\HireDriver;
use Illuminate\Http\Request;
use PDF;


class DriverInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $pageTitle = __('driver_invoice.heading.index');
        $customers = Customer::where('status','1')->get(['name','id']);
        return view('invoices.driver.index',compact('pageTitle','customers'));
    }

    public function create(){

        $pageTitle = __('driver_invoice.heading.add');
        $customers = Customer::where('status','1')->get(['name','id']);
        return view('invoices.driver.create',compact('pageTitle','customers'));
    }

    public function getList(Request $request)
    {
//        dd($request->all());
        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }


        if(!empty($request->input('status'))){
            $query = DriverInvoice::where('status',$request->input('status'));
        }else{
            $query = DriverInvoice::where('status','>',0);
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

            $from = date('Y-m-d h:i',strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $to = date('Y-m-d h:i',strtotime($request->to_date));
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
            $row->created = date('d.m.Y H:i',strtotime($row->created_at));
//            dd($row);
            $data[] = $row;
        }
//        dd($data);
        unset($rows);
        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }


    public function markAsPaid(Request $request){

        if(!empty($request->ids)){

            foreach($request->ids as $id) {

                $invoice = DriverInvoice::find($id);
                $invoice->status = 2;
                $invoice->save();
            }
        }
        toastr()->success(__('driver_invoice.mark_paid'));
        return redirect('/driver-invoices');
    }
    public function generateInvoice(Request $request){


        /* save invoice */
        $invoice  = new DriverInvoice;
        $invoice->customer_id = (int)$request->customer_id;
        $invoice->total = (int)$request->total;
        $invoice->status = 1;
        if($invoice->save()){
            toastr()->success(__('driver_invoice.generated'));
        }


        /* save invoice details */
        foreach($request->ids as $id){

            $invoice_detail = new DriverInvoiceDetail;
            $invoice_detail->invoice_id = $invoice->id;
            $invoice_detail->hire_id = $id;
            $invoice_detail->save();
        }

        /* change Hire status to invoiced */
        if(!empty($request->ids)){

            HireDriver::whereIn('id',$request->ids)->update(['status'=>3]);
        }

        return redirect('/driver-invoices');
    }
    public function downloadInvoice(Request $request){


        $total=0;
        $invoice = DriverInvoice::find((int)$request->id);

        // Invoice Number
        $general = new General();
        $invoice->id = $general->invoiceNumber($invoice->id);

        $customer = $invoice->customer;
        $invoice_details = DriverInvoiceDetail::where('invoice_id',$invoice->id)->get();

//        dd($invoice_details);
        $hires =[];
        foreach($invoice_details as $inv){

            $inv->hire->driver;
            $inv->hire->customer;
            $total += $inv->hire->price;

            $hires[] = $inv->hire;
        }
//        dd($hires);
        $vat = ($total/100)*19;

        $pdf = PDF::loadView('invoices.driver.pdf_design', compact('customer','invoice','hires','total','vat'));
        return $pdf->download('hire_a_driver_invoice.pdf');
    }
}
