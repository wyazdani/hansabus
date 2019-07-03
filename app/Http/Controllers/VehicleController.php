<?php

    namespace App\Http\Controllers;

    use App\Models\Vehicle;
    use App\Models\VehicleType;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;



    class VehicleController extends Controller
    {

        public function __construct()
        {
            $this->middleware('auth');
        }

        public function getList(Request $request)
        {

            if(!empty($request->input('draw')) ) {
                $draw = $request->input('draw');
            }else{
                $draw = 0;
            }

            $query = Vehicle::where('id','>',0);
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

                $query = Vehicle::where('name', 'LIKE','%'.$search.'%')
                    ->orWhere('make', 'LIKE','%'.$search.'%')
                    ->orWhere('year', 'LIKE','%'.$search.'%')
                    ->orWhere('registrationNumber', 'LIKE',"%{$search}%")
                    ->orWhere('engineNumber', 'LIKE',"%{$search}%")
                    ->orWhere('licensePlate', 'LIKE',"%{$search}%")
                    ->orWhere('transmission', 'LIKE',"%{$search}%");


            }
            $recordsTotal = $query->count();
            $rows = $query->offset($start)->limit($limit)->get(['id','name','make','year','licensePlate','engineNumber','registrationNumber','status']);

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
            $pageTitle = 'Vehicles';

            return view('vehicle.index', compact('pageTitle'));
        }

        public function status(Vehicle $Vehicle)
        {
            // dd($vehicle);
            $Vehicle->status = !$Vehicle->status;
            $Vehicle->save();
            toastr()->success(__('vehicle.status_changed'));
            return redirect()->back();
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $pageTitle = 'Vehicle Create';
            $vehicleTypes = VehicleType::whereNull('deleted_at')->get();
            return view('vehicle.add', compact('pageTitle', 'vehicleTypes'));
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
                'name' => 'required|string|max:150',
                'year' => 'required|integer|min:1900|max:2050',
                'make' => 'required|string|max:100',
                'engineNumber' => 'required|string|max:100',
                'vehicle_type' => 'required|integer',
                'licensePlate' => 'required|string|max:50',
                'seats' => 'required|integer',
                'color' => 'required|string|max:50',
                'registrationNumber' => 'required|string|max:100',
                'transmission' => 'required',
            ];
            $messages = [
                // 'title.required' => 'Title is required',
            ];
            $this->validate(request(), $rules, $messages);

            $vehicle = new Vehicle;
            $vehicle->name = $request->name;
            $vehicle->year = $request->year;
            $vehicle->make = $request->make;
            $vehicle->engineNumber = $request->engineNumber;
            $vehicle->vehicle_type = $request->vehicle_type;
            $vehicle->licensePlate = $request->licensePlate;
            $vehicle->color = $request->color;
            $vehicle->seats = $request->seats;
            $vehicle->registrationNumber = $request->registrationNumber;
            $vehicle->transmission = $request->transmission;

            $status = true;
            $ac = $sunroof = $radio = $phoneCharging = false;

            if ($request->AC) $ac = true;
            if ($request->sunroof) $sunroof = true;
            if ($request->radio) $radio = true;
            if ($request->phoneCharging) $phoneCharging = true;

            $vehicle->AC = $ac;
            $vehicle->radio = $radio;
            $vehicle->sunroof = $sunroof;
            $vehicle->phoneCharging = $phoneCharging;
            $vehicle->status = $status;

            if ($vehicle->save()) {
                toastr()->success(__('vehicle.created'));
                if ($request->returnFlag == 1) {
                    return redirect('/vehicles');
                } else {
                    return redirect('/vehicles/create');
                }
            }else{
                dd('error');
            }

            return redirect()->back();
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show(Vehicle $Vehicle)
        {

            $Vehicle->type;
            return $Vehicle;
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function edit(Vehicle $vehicle)
        {
            $pageTitle = 'Vehicle Update';
            $vehicleTypes = VehicleType::all();
            return view('vehicle.add', compact('pageTitle', 'vehicleTypes', 'vehicle'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $vehicle)
        {
            // dd($vehicle);
            $rules = [
                'name' => 'required|string|max:150',
                'year' => 'required|integer|min:1900|max:2050',
                'make' => 'required|string|max:100',
                'engineNumber' => 'required|string|max:100',
                'vehicle_type' => 'required|integer',
                'licensePlate' => 'required|string|max:50',
                'seats' => 'required|integer',
                'color' => 'required|string|max:50',
                'registrationNumber' => 'required|string|max:100',
                'transmission' => 'required',
            ];
            $messages = [
                // 'title.required' => 'Title is required',
            ];
            $this->validate(request(), $rules, $messages);

            $vehicle = Vehicle::find($request->id);
            $vehicle->name = $request->name;
            $vehicle->year = $request->year;
            $vehicle->make = $request->make;
            $vehicle->engineNumber = $request->engineNumber;
            $vehicle->vehicle_type = $request->vehicle_type;
            $vehicle->licensePlate = $request->licensePlate;
            $vehicle->color = $request->color;
            $vehicle->seats = $request->seats;
            $vehicle->registrationNumber = $request->registrationNumber;
            $vehicle->transmission = $request->transmission;

            $status = true;
            $ac = $sunroof = $radio = $phoneCharging = false;

            if ($request->AC) $ac = true;
            if ($request->sunroof) $sunroof = true;
            if ($request->radio) $radio = true;
            if ($request->phoneCharging) $phoneCharging = true;

            $vehicle->AC = $ac;
            $vehicle->radio = $radio;
            $vehicle->sunroof = $sunroof;
            $vehicle->phoneCharging = $phoneCharging;
            $vehicle->status = $status;

            if ($vehicle->save()) {
                toastr()->success(__('vehicle.updated'));
                if ($request->returnFlag == 1) {
                    return redirect('/vehicles');
                } else {
                    return redirect('/vehicles/create');
                }

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
            $vehicle = Vehicle::find($id);
            $vehicle->delete();
        }
    }