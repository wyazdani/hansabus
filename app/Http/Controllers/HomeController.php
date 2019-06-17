<?php

namespace App\Http\Controllers;

use App\Driver;
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
        $vehicle = Vehicle::all();
        $driver =   Driver::all();
        $company    = Vehicle::all();
        return view('home',compact('pageTitle','vehicle','driver'));
    }
}
