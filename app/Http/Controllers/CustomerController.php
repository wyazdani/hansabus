<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList(Request $request)
    {


        $orderColumn = 'id';
        $dir = 'desc';

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==1){
            $orderColumn = 'name';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==2){
            $orderColumn = 'email';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==3){
            $orderColumn = 'phone';
        }

        if(!empty($request->order[0]['column']) && $request->order[0]['column']==4){
            $orderColumn = 'address';
        }
        if(!empty($request->order[0]['column']) && $request->order[0]['column']==5){
            $orderColumn = 'url';
        }
        if(!empty($request->order[0]['dir'])){
            $dir = $request->order[0]['dir'];
        }


        $draw = 0;
        if(!empty($request->input('draw')) ) {
            $draw = $request->input('draw');
        }

        $query = Customer::where('id','>',0);
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

            $query = Customer::where(function ($query) use ($search) {
                $query->where('name', 'LIKE','%'.$search.'%')
                    ->orWhere('email', 'LIKE','%'.$search.'%')
                    ->orWhere('phone', 'LIKE','%'.$search.'%')
                    ->orWhere('address', 'LIKE','%'.$search.'%');
            });
            /* if searching from autocomplete */
            if(!empty($request->key) && $request->key=='auto'){
                $query->where('status',1);
            }
        }


        $recordsTotal = $query->count();
        $rows = $query->orderBy($orderColumn,$dir)->offset($start)->limit($limit)->get(['id','name','email','phone','address','url','status']);

        $data=[];
        foreach($rows as $row){

            $row['label'] = $row['name'];
            $row['value'] = $row['name'];
            $data[] = $row;
        }
        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function index(Request $request)
    {
        $pageTitle = trans('messages.customers');
        return view('customer.index', compact( 'pageTitle'));
    }

    public function status(Customer $Customer)
    {
        $Customer->status = !$Customer->status;
        $Customer->save();
        toastr()->success(__('customer.status_changed'));
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = __('customer.heading.add');
        return view('customer.add', compact('pageTitle'));
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
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:customer',
//            'url' => 'required|url|max:200',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:200',
        ];
        $messages = [
            'name.required' => 'Please provide your name.',
            'email.required' => 'Please provide your email address.',
            'phone.required' => 'Please provide your phone number.',
            'address.required' => 'Please provide your address..',
        ];

        if(!empty($request->key) && $request->key == 'popup'){

            $validation = Validator::make($request->only('name', 'email','phone','address'),$rules);
            if(!$validation->passes()) {

                return response()->json(['errors'=>$validation->errors()]);
            }
        }else {
            $this->validate(request(), $rules, $messages);
        }
        if(true){

            $customer = new Customer;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->url = $request->url;
            $customer->phone = $request->phone;
            $customer->address = $request->address;

            $status = false;
            if ($request->status) $status = true;
            $customer->status = $status;

            if ($customer->save()) {

                if(!empty($request->key) && $request->key == 'popup'){

                    return $customer;
                }else{
                    toastr()->success(__('customer.created'));
                    if ($request->returnFlag == 1) {
                        return redirect('/customers');
                    } else {
                        return redirect('/customers/create');
                    }
                }
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $Customer)
    {
        return $Customer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $Customer)
    {
        $pageTitle = 'Customer Update';
        $customer = $Customer;
        return view('customer.add', compact('pageTitle','customer'));
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
            'name' => 'required|string|max:200',
            'email' => 'required|email',
//            'url' => 'required|url|max:200',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:200',
        ];
        $messages = [
            'name.required' => 'Please provide your name.',
            'email.required' => 'Please provide your email address.',
            'phone.required' => 'Please provide your phone number.',
            'address.required' => 'Please provide your address..',
        ];
        $this->validate(request(), $rules, $messages);
        if(true){

            $customer = Customer::find($id);
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->url = $request->url;
            $customer->phone = $request->phone;
            $customer->address = $request->address;

            $status = false;
            if ($request->status) $status = true;
            $customer->status = $status;

            if ($customer->save()) {

                toastr()->success(__('customer.updated'));
                if ($request->returnFlag == 1) {
                    return redirect('/customers');
                } else {
                    return redirect('/customers/create');
                }
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
    }
}
