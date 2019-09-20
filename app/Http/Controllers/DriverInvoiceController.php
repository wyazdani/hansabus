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

    public function index(Request $request){

        $pageTitle = __('driver_invoice.heading.index');
//        $customers = Customer::where('status','1')->get(['name','id']);

        $query = DriverInvoice::where('id','>',0);

        if(!empty($request->input('status'))){
            $query = DriverInvoice::where('status',$request->input('status'));
        }

        if(!empty($request->id)){
            $query = $query->where('id',(int)$request->id);
        }
        if(!empty($request->customer_id)){
            $query = $query->where('customer_id',$request->customer_id);
        }

        $from =''; $to ='';
        if(!empty($request->from_date)){

            $from = date('Y-m-d H:i',strtotime($request->from_date)).':00';
        }
        if(!empty($request->to_date)){
            $to = date('Y-m-d H:i',strtotime($request->to_date)).':59';
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
        $customers = Customer::where('status','1')->get(['name','id']);
        return view('invoices.driver.index',compact('pageTitle','rows','customers'));
    }

    public function create(Request $request){

        $pageTitle = __('driver_invoice.heading.add');
        $customers = Customer::where('status','1')->get(['name','id']);

        $query = HireDriver::where('status',2);

        if(!empty($request->id)){
            $query = $query->where('id',(int)$request->id);
        }
        if(!empty($request->customer_id)){
            $query = $query->where('customer_id',$request->customer_id);
        }
        if(!empty($request->driver_id)){
            $query = $query->where('driver_id',$request->driver_id);
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

        $data=[];
        foreach($rows as $row){

            $row->driver;
            $row->customer;
            $row->from_date = date('d.m.Y H:i',strtotime($row->from_date));
            $row->to_date   = date('d.m.Y H:i',strtotime($row->to_date));
            $data[] = $row;
        }

        return view('invoices.driver.create',compact('pageTitle','customers','rows'));
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

        if(!empty($request->customer_id) && $request->customer_id>0) {

            $invoice = new DriverInvoice;
            $invoice->customer_id = (int)$request->customer_id;
            $invoice->total = (int)$request->total;
            $invoice->status = 1;
            if ($invoice->save()) {
                toastr()->success(__('driver_invoice.generated'));

                /* save invoice details */
                foreach ($request->ids as $id) {

                    $invoice_detail = new DriverInvoiceDetail;
                    $invoice_detail->invoice_id = $invoice->id;
                    $invoice_detail->hire_id = $id;
                    $invoice_detail->save();
                }

                /* change Hire status to invoiced */
                if (!empty($request->ids)) {

                    HireDriver::whereIn('id', $request->ids)->update(['status' => 3]);
                }
            }
        }else{
            toastr()->error('Error!');
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
        $invoice_date   =   date('Y-m-d');
        $html   =   view('invoices.driver.pdf_design', compact('customer','invoice','hires','total','vat','invoice_date'));
        return General::DownloadPdf("P",$html,"driver_invoice","Invoice");
        $pdf = PDF::loadView('invoices.driver.pdf_design', compact('customer','invoice','hires','total','vat','invoice_date'));
        return $pdf->download('hire_a_driver_invoice.pdf');
    }
}
