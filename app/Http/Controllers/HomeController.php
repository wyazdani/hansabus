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
        $recentTours    = Tour::limit(10)->orderby('id', 'desc')->get();


        return view('home',compact('pageTitle','totalVehicles','totalDrivers','totalCustomers','recentTours'));
    }
}
