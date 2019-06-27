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
                            <form class="form" method="GET" action="{{ route('vehicles.index') }}" id="theForm">
                            <label>
                                <input type="search" name="q" class="form-control form-control-sm" placeholder="Search"></label>
                                <input type="submit" value="Search" class="btn btn-sm btn-info ml-2 mt-2">

                                <a href="{{ url('/vehicles/create') }}" id="addRow" class="btn btn-sm btn-info ml-2 mt-2"><i class="ft-plus"></i> Add Vehicle</a>
                            </form>

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
                                <th class="border-top-0" width="7%">ID</th>
                                <th class="border-top-0" width="15%">Vehicle Name</th>
                                <th class="border-top-0" width="10%">Make/Model</th>
                                <th class="border-top-0" width="10%">Engine #</th>
                                <th class="border-top-0" width="10%">Vehicle Type</th>
                                <th class="border-top-0" width="10%">License Plate</th>
{{--                                <th class="border-top-0" width="5%">Seats</th>--}}
                                <th class="border-top-0" width="5%">Color</th>
                                <th class="border-top-0" width="10%">Transmission</th>
                                <th class="border-top-0" width="10%">Registration #</th>
{{--                                <th class="border-top-0" width="5%">Status</th>--}}
                                <th class="border-top-0" width="13%">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($vehicles as $vehicle)
                            <tr id="row_{{ $vehicle->id }}">
                                <td class="text-truncate">{{ $vehicle->id }}</td>
                                <td class="text-truncate">{{ str_limit($vehicle->name,15) }}</td>
                                <td class="text-truncate">{{ $vehicle->make.' / '.$vehicle->year }}</td>
                                <td class="text-truncate">{{ $vehicle->engineNumber }}</td>
                                <td class="text-truncate">{{ $vehicle->type->name }}</td>
                                <td class="text-truncate">{{ $vehicle->licensePlate }}</td>
{{--                                <td class="text-truncate">{{ $vehicle->seats }}</td>--}}
                                <td class="text-truncate">{{ $vehicle->color }}</td>
                                <td class="text-truncate">{{ ucwords($vehicle->transmission) }}</td>
                                <td class="text-truncate">{{ $vehicle->registrationNumber }}</td>
                                <td>
                                    {{-- edit --}}
                                    <a class="info p-0" data-original-title="" title="Edit"
                                        href="{{ url('/vehicles/'.$vehicle->id.'/edit') }}">
                                        <i class="icon-pencil font-medium-3 mr-2"></i>
                                    </a>
                                    {{-- change status--}}
                                    <a href="{{ url('/vehicles/change-status/'.$vehicle->id) }}"
                                       class="{{ (!$vehicle->status)?'danger':'success' }} p-0" 
                                       data-original-title="" title="{{ ($vehicle->status)?'Click to in-activate':'Click to activate' }}">
                                        <i class="icon-power font-medium-3 mr-2"></i>
                                    </a>
                                    {{-- delete --}}
                                    <a class="danger p-0"  href="javascript:;" onclick="deleteMe('{{ $vehicle->id }}')"
                                       data-original-title="Delete" >
                                        <i class="icon-trash font-medium-3 mr-2"></i>
                                    </a>
                                    {{-- view --}}
                                    <a href="javascript:;" onclick="viewVehicle('{{ $vehicle->id }}')"
                                       data-original-title="Delete" >
                                        <i class="icon-eye font-medium-3 mr-2"></i>
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-12">{{ $vehicles->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('pagejs')
    @include('vehicle.view')
    <script>
        function deleteMe(id){
            // console.log('here');

            if(confirm('Are you sure you want to delete?')){

                $.ajax({
                    url: '/vehicles/'+id,
                    data: "_token={{ csrf_token() }}",
                    type: 'DELETE',  // user.destroy
                    success: function(result) {
                        // console.log(result);
                        $('#row_'+id).remove();
                    }
                });
            }

        }
        function viewVehicle(id){
             // console.log(id);
            $.ajax({
                url: "{{ url('/vehicles') }}/"+id,
                cache: false,
                success: function(vehicle){

                    // console.log(vehicle);

                    $('#v_name').html(vehicle.name);
                    $('#v_make').html(vehicle.make);
                    $('#v_year').html(vehicle.year);
                    $('#v_vehicle_type').html(vehicle.type.name);
                    $('#v_licensePlate').html(vehicle.licensePlate);
                    $('#v_registrationNumber').html(vehicle.registrationNumber);
                    $('#v_engineNumber').html(vehicle.engineNumber);
                    $('#v_seats').html(vehicle.seats);
                    $('#v_transmission').html(vehicle.transmission);
                    $('#v_color').html(vehicle.color);

                    if(vehicle.status == 1) $('#v_status').html('Yes'); else $('#v_status').html('No');
                    if(vehicle.AC == 1) $('#v_AC').html('Yes'); else $('#v_AC').html('No');
                    if(vehicle.radio == 1) $('#v_radio').html('Yes'); else $('#v_radio').html('No');
                    if(vehicle.sunroof == 1) $('#v_sunroof').html('Yes'); else $('#v_sunroof').html('No');
                    if(vehicle.phoneCharging == 1) $('#v_phoneCharging').html('Yes'); else $('#v_phoneCharging').html('No');

                    $('#viewModel').modal('show');

                }
            });
        }
    </script>
@endsection