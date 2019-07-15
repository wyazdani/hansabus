<?php


namespace App\Http\Controllers;
use App\Models\BusService;
use App\Models\BusServiceDetail;
use App\Models\Driver;
use App\Models\ServiceType;
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

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==0){
            $orderColumn = 'id';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==1){
            $orderColumn = 'type_id';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==2){
            $orderColumn = 'customer';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==3){
            $orderColumn = 'total';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==4){
            $orderColumn = 'created_at';
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

        /* service type */
        if(!empty($request->type_id)){
            $query = $query->where('type_id',$request->type_id);
        }

        /* service ID */
        if(!empty($request->id)){
            $query = $query->where('id',(int)$request->id);
        }
        /* by date  */
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


        $recordsTotal = $query->count();
        $rows = $query->orderBy($orderColumn,$dir)->offset($start)->limit($limit)
            ->get(['id','type_id','customer','total','created_at']);

        $data=[];
        foreach($rows as $row){

            $row->title =  \Str::limit($row->service->name,55);
            $row['date'] = date('d.m.Y H:i',strtotime($row->created_at));
            $data[] = $row;
        }
//        dd($rows);
        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }



    public function index()
    {
        $pageTitle = __('service.heading.index');
        $service_types = ServiceType::get(['id','name']);
        return view('service.index',compact('pageTitle','service_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = __('service.heading.add');
        $service_types = ServiceType::get(['id','name']);
        return view('service.add', compact('pageTitle','service_types'));
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
            'type_id'=>'required',
            'customer' => 'required|string'
        ];
        $messages = [
            'type_id.required' => 'Please select service type.',
            'customer.required' => 'Customer info required.'
        ];

        $this->validate(request(), $rules, $messages);
        if(true){

            $total = 0;
            foreach($request->price as $price){
                $total += $price;
            }
            $vat = ($total/100)*19;

            if($total>0){

                $service = new BusService;
                $service->type_id = $request->type_id;
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
        $service = BusService::find($id);
        $total = $service->total;
        $vat = ($total/100)*19;
        $details = $service->details;

        $pdf = PDF::loadView('invoices.service.pdf_design', compact('service','details','total','vat'));
        return $pdf->stream();
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
        $service_types = ServiceType::get(['id','name']);

        $service = BusService::find($id);
        $details = BusServiceDetail::where('service_id',$service->id)->orderBy('id','ASC')->get();

        return view('service.add', compact('pageTitle','service','details','service_types'));
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
            'type_id'=>'required',
            'customer' => 'required|string'
        ];
        $messages = [
            'type_id.required' => 'Please select service type.',
            'customer.required' => 'Customer info required.'
        ];
        $this->validate(request(), $rules, $messages);
        if(true){

            $total = 0;
            foreach($request->price as $price){
                $total += $price;
            }
            $vat = ($total/100)*19;

            if($total>0){

                $service = BusService::find($request->id);
                $service->type_id = $request->type_id;
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
        $service_detail = BusServiceDetail::where('service_id',$id);
        $service_detail->delete();

        $service = BusService::find($id);
        $service->delete();
    }
}
