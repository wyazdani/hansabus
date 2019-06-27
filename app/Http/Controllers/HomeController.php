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

        /* recent tours */
//        $recentTours    = Tour::limit(10)->orderby('id', 'desc')->get();

        /* tours calendar */
        $rows = Tour::where('status','>',1)->orderby('id','desc')->limit(50)->get(
            ['id','customer_id','vehicle_id','driver_id','status','passengers','guide','price','from_date','to_date']);

        $calendarTours =[]; $i=0; $recentTours=[];
        foreach($rows as $row){
            $row->vehicle;
            $row->driver;
            $row->customer;
            // ' passengers on '.$row->vehicle->name.'. driver: '.$row->driver->driver_name
            $calendarTours[$i]['title'] = 'Tour # '.$row->id;
            $calendarTours[$i]['start'] = $row->from_date;
            $calendarTours[$i]['end'] = $row->to_date;
            $calendarTours[$i]['url'] = url('/tour/'.$row->id);
            $i++;
            $recentTours[] = $row;
        }
        unset($rows);

        return view('home',compact('pageTitle','totalVehicles','totalDrivers','totalCustomers','recentTours','calendarTours'));
    }
}
