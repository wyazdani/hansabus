<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tour;
use Illuminate\Http\Request;
use PDF;


class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $pageTitle = 'Invoices';
        $customers = Customer::where('status','1')->get(['name','id']);
        return view('invoices.index',compact('pageTitle','customers'));
    }

    public function downloadInvoice(Request $request){


        $customer='';
//        dd($request->all());
        $query = Tour::where('status','>',1);

        if(!empty($request->id)){
            $query = $query->where('id',(int)$request->id);
        }
        if(!empty($request->customer_id)){
            $customer = Customer::find($request->customer_id);
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

            $query = $query->whereBetween('from_date', [$from, $to]);

        }elseif(!empty($from)){

            $query = $query->where('from_date','>=',$from);
        }elseif(!empty($to)){

            $query = $query->where('from_date','<=',$to);
        }

        $rows = $query->get([
            'id','customer_id','vehicle_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $total=0;
        $tours=[];
        foreach($rows as $row){
            $row->vehicle;
            $row->driver;
            $row->from_date = date('d/m/Y h:i',strtotime($row->from_date));
            $row->to_date = date('d/m/Y h:i',strtotime($row->to_date));
            $tours[] = $row;
            $total += $row->price;
        }

//        return view('invoices.pdf_design',compact('customer','tours','total'));


        $pdf = PDF::loadView('invoices.pdf_design', compact('customer','tours','total'));
        return $pdf->download('invoice.pdf');


    }
}
