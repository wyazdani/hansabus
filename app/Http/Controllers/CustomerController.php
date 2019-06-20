<?php

namespace App\Http\Controllers;

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

            $query = Customer::where('name', 'LIKE','%'.$search.'%')
                ->orWhere('email', 'LIKE','%'.$search.'%')
                ->orWhere('phone', 'LIKE','%'.$search.'%')
                ->orWhere('address', 'LIKE',"%{$search}%")
                ->orWhere('url', 'LIKE',"%{$search}%");
        }
        $recordsTotal = $query->count();
        $rows = $query->offset($start)->limit($limit)->get(['id','name','email','phone','address','url','status']);

        $data=[];
        foreach($rows as $row){
            $row['action']='';
            $data[] = $row;
        }
        $recordsFiltered = $query->offset($start)->limit($limit)->count();

        return ['draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=> $recordsTotal, 'data'=>$data];
    }
    public function index(Request $request)
    {
        $pageTitle = 'Customers';

        $query = Customer::where('id', '>',0);

        $search =  '';
        if(!empty($request->input('q'))){

            $search = $request->input('q');
        }

        if(!empty($search)){

            $query = Customer::where('name', 'LIKE','%'.$search.'%')
                ->orWhere('email', 'LIKE','%'.$search.'%');
        }

        $customers = $query->paginate(3);
        return view('customer.index', compact('customers', 'pageTitle'));
    }

    public function status(Customer $Customer)
    {
        $Customer->status = !$Customer->status;
        $Customer->save();
        return redirect()->back()->with('info','Customer # '.$Customer->id.' status updated!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Customer Create';
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
            'phone' => 'required|max:15',
            'address' => 'required|string|max:200',
        ];
        $messages = [
            // 'title.required' => 'Title is required',
        ];
        $this->validate(request(), $rules, $messages);


        $msg = 'Customer created successfully.';
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

            if ($request->returnFlag == 1) {
                return redirect('/customers')->with('success','Record created successfully.');
            } else {
                return redirect('/customers/create')->with('success','Record created successfully.');
            }

        }
        return redirect()->back()->with('info', $msg);
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
            'phone' => 'required|max:15',
            'address' => 'required|string|max:200',
        ];
        $messages = [
            // 'title.required' => 'Title is required',
        ];

        $this->validate(request(), $rules, $messages);


        $msg = 'Customer updated successfully.';

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

            if ($request->returnFlag == 1) {
                return redirect('/customers')->with('success','Record # '.$customer->id.' updated!');
            } else {
                return redirect('/customers/create')->with('success','Record # '.$customer->id.' updated!');
            }
        }
        return redirect()->back()->with('success','Customer # '.$customer->id.' updated!');

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
