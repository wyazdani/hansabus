<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Tour;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pageTitle = 'Welcome';
        $totalVehicles = Vehicle::where('status',1)->count();
        $totalDrivers= Driver::where('status',1)->count();
        $totalCustomers = Customer::where('status',1)->count();


        $rows = Tour::where('status','>',1)->where('status','<',4)->orderBy('id','DESC')->offset(0)->limit(10)->get(
            ['id','vehicle_id','customer_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $colors = ['#1E9FF2','#34D093','#F78C47','#FF9149','#2FAC68','#F8C631','#9ABE21','#3D84E8','#E74D17'];

        $events = $recentTours = []; $i=$j=0;
        foreach($rows as $row){

            if($j>7){
                $j = $j-8;
            }


            $row->driver;
            $row->customer;

            if($i<11) {
                $recentTours[] = $row;
            }
//            $vehicles[] = $row->vehicle;
            $events[$i]['id'] = $row->id;
            $events[$i]['resourceId'] = $row->vehicle->id;
            $events[$i]['start'] = $row->from_date;
            $events[$i]['end'] = $row->to_date;


            $events[$i]['title'] = ' 
            Customer: '.$row->customer->name.' 
            Driver: '.$row->driver->driver_name.' 
            vehicle: '.$row->vehicle->name;;
            $events[$i]['url'] = url('/tour/'.$row->id);
            $events[$i]['backgroundColor'] = !empty($row->vehicle->color)?$row->vehicle->color:'#ff3908';

            $i++; $j++;
        }

        return view('home',compact('pageTitle','totalVehicles','totalDrivers','totalCustomers','recentTours','events'));
    }
}
