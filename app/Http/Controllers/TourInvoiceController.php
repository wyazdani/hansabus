<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Mail\InvoiceEmail;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\HireDriver;
use App\Models\Tour;
use App\Models\TourInvoice;
use App\Models\TourInvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;


class TourInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        /*dd($request->all());*/
        $pageTitle = __('tour_invoice.heading.index');
        $customers  =   Customer::orderBy('name','ASC')->where('status','=',1)->get();
        $query = TourInvoice::where('status','=',1);
        if(!empty($request->is_bulk)){
            $query = TourInvoice::where('is_bulk',1)->where('status','=',1);
        }else
        {
            $query = TourInvoice::where('is_bulk',0)->where('status','=',1);
        }
        if(!empty($request->status)){
            $query = TourInvoice::where('status',$request->status);
        }
        if (!empty($request->single_status)){
            $query = TourInvoice::where('status',2)->where('is_bulk',0);
        }
        if (!empty($request->bulk_status)){
            $query = TourInvoice::where('status',2)->where('is_bulk',1);
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
        return view('invoices.tour.create',compact('pageTitle','customers','rows','request'));
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
        /*if ($request->is_bulk){
            return redirect('/tour-invoices?is_bulk=1');
        }*/
        return redirect('/tour-invoices');
    }
    public function generateInvoice(Request $request){

        if(!empty($request->customer_id) && $request->customer_id>0) {

            /* save invoice */
            $invoice = new TourInvoice;
            $invoice->customer_id = (int)$request->customer_id;
            $invoice->total = (int)$request->total;
            $invoice->status = 1;
            $invoice->is_bulk = 0;
            $invoice->vat = !empty($request->vat)?(int)$request->vat:0;
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
        return redirect()->route('tour-invoices');
    }
    public function downloadInvoice(Request $request){


        $total=0;
        $invoice = TourInvoice::find((int)$request->id);

        // Invoice Number
        $general = new General();
        $invoice->id = $general->invoiceNumber($invoice->id);

        $customer = $invoice->customer;
        $invoice_details = TourInvoiceDetail::where('invoice_id',$invoice->id)->get();
        $tour =[];
        foreach($invoice_details as $inv){
            $inv->tour;
            $inv->tour->driver;
            $inv->tour->customer;
            $inv->tour->vehicle;
            $total += $inv->tour->price;

            $tour[] = $inv->tour;
        }

        if ($invoice->vat){
            $vat = ($total/100)*$invoice->vat;
        }else{
            $vat    =   0;
        }



        $invoice_date   =   date('Y-m-d');
        $html   =   view('invoices.tour.pdf_design', compact('customer','invoice','tour','total','vat','invoice_date'));
        if ($request->view){
            return General::CreatePdf("P",$html,"tour_invoice","Invoice");
        }else{
            return General::DownloadPdf("P",$html,"tour_invoice","Invoice");
        }
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
    public function generateInvoiceBulk(Request $request){

        $invoice = new TourInvoice;
        $invoice->customer_id = (int)$request->customer_id;
        $invoice->total = $request->grand_total;
        $invoice->status = 1;
        $invoice->is_bulk = 1;
        $invoice->vat = !empty($request->vat_bulk)?$request->vat_bulk:0;
        $invoice->save();
        foreach ($request->tours_ids as $tours_id){
            $invoice_detail = new TourInvoiceDetail;
            $invoice_detail->invoice_id = $invoice->id;
            $invoice_detail->tour_id = $tours_id;
            $invoice_detail->save();
        }
        foreach ($request->tours_ids as $tours_id){
            $invoice = new TourInvoice;
            $tour   =   Tour::find($tours_id);
            $invoice->customer_id = (int)$request->customer_id;
            $invoice->total = $tour->price;
            $invoice->status = 1;
            $invoice->save();
            $invoice_detail = new TourInvoiceDetail;
            $invoice_detail->invoice_id = $invoice->id;
            $invoice_detail->tour_id = $tours_id;
            $invoice_detail->save();
        }
        if (!empty($request->tours_ids)) {

            Tour::whereIn('id', $request->tours_ids)->update(['status' => 3]);
        }
    }

    public function modal_mail(Request $request){
        $invoice        =   TourInvoice::find($request->invoice_id);
        return view('invoices.tour.modal_mail',compact('invoice'));
    }
    public function send_mail(Request $request){
        $invoice    =   TourInvoice::find($request->invoice_id);
        $subject    =   $request->subject;
        $body       =   $request->body;
        if (empty($subject)){
            toastr()->error(__('tour_invoice.pls_enter_subject'));
            return redirect()->route('tour-invoices');
        }elseif(empty($body)){
            toastr()->error(__('tour_invoice.pls_enter_body'));
            return redirect()->route('tour-invoices');
        }
        if ($invoice){
            $invoice->update([
               'subject'    =>  $request->subject,
               'body'       =>  $request->body
            ]);
            Mail::send(new InvoiceEmail($invoice,$subject,$body));
            toastr()->success(__('offer.mail_sent'));
            return redirect()->route('tour-invoices');
        }
    }
}
