@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')
<div class="row match-height">

    <div class="col-md-12" id="recent-sales">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <div class="col-sm-6 col-md-6">
                        <div class="card-title-wrap bar-primary">
                            <h4 class="card-title">Vehicles</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 text-right">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <!-- <label><input type="search" class="form-control form-control-sm" placeholder="Search:" aria-controls="DataTables_Table_0"></label> -->
                            <a href="{{ url('/vehicles/create') }}" id="addRow" class="btn btn-info ml-2 mt-2"><i class="ft-plus"></i> Add Vehicle</a>
                        </div>
                    </div>

                </div>
                <div class="row"><div class="col-12">@include('layouts.errors')</div></div>    
            </div>

            <div class="card-content mt-1">
                <div class="table-responsive">
                    <table class="table table-hover table-xl mb-0" id="recent-orders">

                        <thead>
                            <tr>
                                <th class="border-top-0">ID</th>
                                <th class="border-top-0">Vehicle Name</th>
                                <th class="border-top-0">Make</th>
                                <th class="border-top-0">Model</th>
                                <th class="border-top-0">Engine Number</th>
                                <th class="border-top-0">Vehicle Type</th>
                                <th class="border-top-0">License Plate</th>                        
                                <th class="border-top-0">No. of Seats</th>
                                <th class="border-top-0">Color</th>
                                <th class="border-top-0">Transmission</th>                    
                                <th class="border-top-0">Registration #</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($vehicles as $vehicle)
                            <tr>
                                <td class="text-truncate">{{ $vehicle->id }}</td>
                                <td class="text-truncate">{{ str_limit($vehicle->name,15) }}</td>
                                <td class="text-truncate">{{ $vehicle->make }}</td>
                                <td class="text-truncate">{{ $vehicle->year }}</td>
                                <td class="text-truncate">{{ $vehicle->engineNumber }}</td>
                                <td class="text-truncate">{{ $vehicle->type->name }}</td>
                                <td class="text-truncate">{{ $vehicle->licensePlate }}</td>
                                <td class="text-truncate">{{ $vehicle->seats }}</td>
                                <td class="text-truncate">{{ $vehicle->color }}</td>
                                <td class="text-truncate">{{ ucwords($vehicle->transmission) }}</td>
                                <td class="text-truncate">{{ $vehicle->registrationNumber }}</td>
                                <td class="text-truncate">{{ ($vehicle->status)?'Active':'Inactive' }}</td>
                                <td>
                                    <a class="info p-0" data-original-title="" title="Edit" 
                                    href="{{ url('/vehicles/'.$vehicle->id.'/edit') }}">
                                        <i class="icon-pencil font-medium-3 mr-2"></i>
                                    </a>
                                    <a href="{{ url('/vehicles/change-status/'.$vehicle->id) }}"
                                       class="{{ (!$vehicle->status)?'danger':'success' }} p-0" 
                                       data-original-title="" title="{{ ($vehicle->status)?'Click to in-activate':'Click to activate' }}">
                                        <i class="icon-power font-medium-3 mr-2"></i>
                                    </a>

                                    <button 
                                class="btn btn-sm btn-outline-danger round mb-0" 
                                onclick="viewVehicle('{{ $vehicle->id }}')"
                                type="button" data-toggle="modal"
                                >View</button>

                                </td>
                            </tr>
                        @endforeach
                            

                            <tr><td colspan="14" class="text-right">{{ $vehicles->links() }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('vehicle.view')
@endsection
@section('pagejs')
<script> 
function viewVehicle(id){
    
    $.ajax({
    url: "vehicle",
    cache: false,
    success: function(html){
        $("#results").append(html);
    }
    });

}
</script>
@endsection