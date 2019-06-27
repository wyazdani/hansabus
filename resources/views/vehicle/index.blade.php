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
                                <h4 class="card-title">{{__('messages.vehicles')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <!-- <label><input type="search" class="form-control form-control-sm" placeholder="Search:" aria-controls="DataTables_Table_0"></label> -->
                                <a href="{{ url('/vehicles/create') }}" id="addRow" class="btn btn-info ml-2 mt-2"><i class="ft-plus"></i>{{__('vehicle.heading.add')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="row"><div class="col-12">@include('layouts.errors')</div></div>
                </div>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="px-3 mb-4">
                            <div class="table-responsive">
                                <table class="table table-hover table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" width="7%">ID</th>
                                        <th class="border-top-0" width="20%">{{__('vehicle.name')}}</th>
                                        <th class="border-top-0" width="10%">{{__('vehicle.make')}}</th>
                                        <th class="border-top-0" width="10%">{{__('vehicle.year')}}</th>
                                        <th class="border-top-0" width="20%">{{__('vehicle.license_plate')}}</th>
                                        <th class="border-top-0" width="20%">{{__('vehicle.engine_number')}}</th>
                                        <th class="border-top-0" width="15%">{{__('vehicle.reg_number')}}</th>
                                        <th class="border-top-0" width="10%">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('pagejs')
    @include('vehicle.view')
    <script>
        var deleteMe = function(id){
            // console.log('here');

            if(confirm('{{__("messages.want_to_delete")}}')){

                $.ajax({
                    url: '/vehicles/'+id,
                    data: "_token={{ csrf_token() }}",
                    type: 'DELETE',  // user.destroy
                    success: function(result) {
                        // console.log(result);
                        $('#'+id).remove();
                    }
                });
            }

        };
        var viewVehicle = function(id){
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

                    if(vehicle.status == 1) $('#v_status').html('{{__('messages.yes')}}'); else $('#v_status').html('{{__('messages.no')}}');
                    if(vehicle.AC == 1) $('#v_AC').html('{{__('messages.yes')}}'); else $('#v_AC').html('{{__('messages.no')}}');
                    if(vehicle.radio == 1) $('#v_radio').html('{{__('messages.yes')}}'); else $('#v_radio').html('{{__('messages.no')}}');
                    if(vehicle.sunroof == 1) $('#v_sunroof').html('{{__('messages.yes')}}'); else $('#v_sunroof').html('{{__('messages.no')}}');
                    if(vehicle.phoneCharging == 1) $('#v_phoneCharging').html('{{__('messages.yes')}}'); else $('#v_phoneCharging').html('{{__('messages.no')}}');

                    $('#viewModel').modal('show');

                }
            });
        };
        $(document).ready(function() {


            var tableDiv = $('#listingTable').DataTable( {

                "bInfo": false,
                "processing": true,
                "serverSide": true,
                "searchable" : true,
                "pageLength": 10,
                "bLengthChange" : false,
                "aoColumnDefs": [{

                    "aTargets": [7],
                    "mData": "",
                    "mRender": function (data, type, row) {

                        var edit = '';  var trash = '';  var view = ''; var status=''; var buttons = '';

                        // console.log(row.status);
                        status  = '<a class="danger p-0" data-original-title="Change Status" title="Change Status" ';
                        if(row.status == '1'){
                            status  = '<a class="success p-0" data-original-title="Change Status" title="Change Status" ';
                        }

                        status += 'href="{!! url("/vehicles/change-status/'+row.id+'") !!}">';
                        status += '<i class="icon-power font-medium-3 mr-2"></i></a>';

                        edit  = '<a class="info p-0" data-original-title="Edit" title="Edit" ';
                        edit += 'href="{!! url("/vehicles/'+row.id+'/edit") !!}">';
                        edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';

                        trash  = '<a class="danger p-0" data-original-title="Delete" title="Delete" ';
                        trash += ' href="javascript:;" onclick="deleteMe('+row.id+')" >';
                        trash += '<i class="icon-trash font-medium-3 mr-2"></i></a>';

                        view  = '<a class="p-0" data-original-title="View" title="View" ';
                        view += ' href="javascript:;" onclick="viewVehicle('+row.id+');" >';
                        view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';

                        buttons = status+edit+trash+view;
                        return buttons;



                        // return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
                    }
                }],
                "ajax": "{{ url('/vehicle-list') }}",
                'rowId': 'id',
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "make" },
                    { "data": "year" },
                    { "data": "licensePlate" },
                    { "data": "engineNumber" },
                    { "data": "registrationNumber" },
                    // { "data": "actions" }
                ],
                drawCallback: deleteMe|viewVehicle,
                "fnDrawCallback": function(oSettings) {
                    if ($('#listingTable tr').length < 11) {
                        $('.dataTables_paginate').hide();
                    }
                }

            });

        } );

    </script>
@endsection