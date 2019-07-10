<?php


namespace App\Http\Controllers;
use App\Models\BusService;
use App\Models\BusServiceDetail;
use Illuminate\Http\Request;
use App\Helpers\General;
use PDF;

class BusServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getList(Request $request)
    {


        $orderColumn = 'id';
        $dir = 'DESC';

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==1){
            $orderColumn = 'customer';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==2){
            $orderColumn = 'total';
        }

        if(!empty($request->order[0]['dir'])){
            $dir = $request->order[0]['dir'];
        }


        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        $query = BusService::where('id','>',0);
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

            $query = BusService::where('customer', 'LIKE','%'.$search.'%');
        }
        $recordsTotal = $query->count();
        $rows = $query->orderBy($orderColumn,$dir)->offset($start)->limit($limit)
            ->get(['id','customer','total','created_at']);

        $data=[];
        foreach($rows as $row){

            $title = [];
            foreach($row->servicesTitle() as $s){
                $title[] = $s->title;
            }
            $row->title =  \Str::limit(implode(', ',$title),35);
            $row['date'] = date('d.m.Y H:i',strtotime($row->created_at));
            $data[] = $row;
        }
        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }



    public function index()
    {
        $pageTitle = __('service.heading.index');

        return view('service.index',compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = __('service.heading.add');

        $customer = 'Walking Customer';
        if(!empty($service->customer)) $customer = $service->customer;
        if(!empty(old('customer'))) $customer = old('customer');

        return view('service.add', compact('pageTitle','customer'));
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
            'customer' => 'required|string'
        ];
        $messages = [
            'customer.required' => 'Please enter customer information.'
        ];

        $general = new General();
        $validated = $general->validateMe($request, $rules, $messages);
        if($validated) {

            $total = 0;
            foreach($request->price as $price){
                $total += $price;
            }
            $vat = ($total/100)*19;

            if($total>0){

                $service = new BusService;
                $service->customer = $request->customer;
                $service->total = $total;
                if ($service->save()) {

                        $details=[];
                        /* delete old services */
                        BusServiceDetail::where('service_id',$service->id)->delete();
                        $i=0;
                        foreach($request->title as $title){

                            if(!empty($title)){

                                $serviceDetail = new BusServiceDetail;
                                $serviceDetail->service_id = $service->id;
                                $serviceDetail->title = $title;
                                $serviceDetail->price = $request->price[$i];
                                if($serviceDetail->save()){
                                    $details[] = ['title'=>$request->title[$i], 'price'=>$request->price[$i],'date'=>$serviceDetail->created_at];
                                }
                            }
                            $i++;
                        }
                        toastr()->success(__('service.created'));

                        $pdf = PDF::loadView('invoices.service.pdf_design', compact('service','details','total','vat'));
                        return $pdf->stream();
//                return $pdf->download('service_invoice.pdf');
                    }
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }
        return redirect('/bus-services');
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
        $pageTitle = __('service.heading.edit');

        $customer = 'Walking Customer';

        $service = BusService::find($id);
        $details = BusServiceDetail::where('service_id',$service->id)->orderBy('id','ASC')->get();

        if(!empty($service->customer)) $customer = $service->customer;
        if(!empty(old('customer'))) $customer = old('customer');

        return view('service.add', compact('pageTitle','service','details','customer'));
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
            'customer' => 'required|string'
        ];
        $messages = [
            'customer.required' => 'Please select customer.'
        ];

        $general = new General();
        $validated = $general->validateMe($request, $rules, $messages);
        if($validated) {

            $total = 0;
            foreach($request->price as $price){
                $total += $price;
            }
            $vat = ($total/100)*19;

            if($total>0){

                $service = BusService::find($request->id);
                $service->customer = $request->customer;
                $service->total = $total;
                if ($service->save()) {

                    $details=[];
                    /* delete old services */
                    BusServiceDetail::where('service_id',$service->id)->delete();
                    $i=0;
                    foreach($request->title as $title){

                        if(!empty($title)){

                            $serviceDetail = new BusServiceDetail;
                            $serviceDetail->service_id = $service->id;
                            $serviceDetail->title = $title;
                            $serviceDetail->price = $request->price[$i];
                            if($serviceDetail->save()){
                                $details[] = ['title'=>$request->title[$i], 'price'=>$request->price[$i],'date'=>$serviceDetail->created_at];
                            }
                        }
                        $i++;
                    }
                    toastr()->success(__('service.updated'));

                $pdf = PDF::loadView('invoices.service.pdf_design', compact('service','details','total','vat'));
                    return $pdf->stream();
//                return $pdf->download('service_invoice.pdf');

                }
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }
        return redirect('/bus-services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
