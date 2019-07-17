@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')
    <div class="row match-height">
        <div class="col-md-12" id="recent-sales">
            <div class="card">
                <div class="card-header d-print-none">
                    <div class="row">

                        <div class="col-sm-6 col-md-6">
                            <div class="card-title-wrap bar-primary">
                                <h4 class="card-title">{{__('service.heading.index')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <a href="{{ route('bus-services.create') }}" id="addRow" class="btn btn-info ml-2 mt-2"> {{__('service.heading.add')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="type_id" id="type_id" class="form-control filterBox">
                                    <option value="">{{__('service.type')}}</option>
                                    @foreach($service_types as $service_type)
                                        <option value="{{ $service_type->id  }}"
                                        @if(!empty($service->type_id) && $service->type_id==$service_type->id || old('type_id') == $service_type->id)
                                            {{ 'Selected' }}
                                                @endif
                                        >{{ $service_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' id="from_date" autocomplete="off" placeholder="{{__('tour.from')}}" class="form-control datetimepicker1" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' id="to_date" autocomplete="off" placeholder="{{__('tour.to')}}" class="form-control datetimepicker2" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' id="id" placeholder="ID" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <a href="javascript:;" id="searchBtn" class="btn btn-outline-success"><i class="ft-search"></i> {{__('messages.search')}}</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="px-3 mb-4">

                    <div class="table-responsive">
                        <table class="table table-hover table-xl mb-0" id="listingTable">
                            <thead>
                                <tr>
                                    <th class="border-top-0" width="5%">ID</th>
                                    <th class="border-top-0" width="20%">{{__('service.title')}}</th>
                                    <th class="border-top-0" width="40%">{{__('service.customer')}}</th>
                                    <th class="border-top-0" width="10%">{{__('service.price')}}</th>
                                    <th class="border-top-0" width="15%">{{__('service.date')}}</th>
                                    <th class="border-top-0 d-print-none" width="10%">&nbsp;</th>
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
    <script>

        $(document).ready(function() {

            var tableDiv = $('#listingTable').DataTable({

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '10pt' )
                                .prepend('@include('layouts.print_header')')
                                .append('@include('layouts.print_footer')');

                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );
                        }
                    }
                ],
                'bSortable': true,
                'bProcessing': true,
                "bInfo": false,
                "processing": true,
                "serverSide": true,
                "searchable" : true,
                "language": {
                    "search": "{{__('messages.search')}}",
                    "emptyTable": "{{__('messages.no_record')}}"
                },
                "pageLength": 10,
                "bLengthChange" : false,
                "aoColumnDefs": [{

                    "aTargets": [5],
                    "mData": "",
                    "mRender": function (data, type, row) {

                        var edit = '';  var view = ''; var buttons = '';

                        edit  = '<a class="info p-0" data-original-title="Edit" title="Edit" ';
                        edit += 'href="{!! url("/bus-services/'+row.id+'/edit") !!}">';
                        edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';

                        view  = '<a class="p-0" data-original-title="View" title="View" ';
                        view += 'href="{!! url("/bus-services/'+row.id+'") !!}">';
                        view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';

                        buttons = edit+view;
                        return buttons;
                        // return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
                    }
                }],
                "ajax": {
                    "url": "{{ url('/bus-services-list') }}",
                    "type": "GET",
                    "data": function ( d ) {
                        d.type_id = $('#type_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.id =  $('#id').val();
                    }
                },
                'rowId': 'id',
                "columns": [
                    { "data": "id" },
                    { "data": "title" },
                    { "data": "customer" },
                    { "data": "total" },
                    { "data": "date" }
                ],
                "fnDrawCallback": function(oSettings) {
                    if ($('#listingTable tr').length < 11) {
                        // $('.dataTables_paginate').hide();
                    }
                }
            });


            $('.filterBox ').on('change', function(){
                tableDiv.draw();
            });
            $('#searchBtn').on('click', function(){
                tableDiv.draw();
            });


            /* DateTime Picker */
            $('.datetimepicker1').datetimepicker();
            $('.datetimepicker2').datetimepicker({
                useCurrent: false //Important! See issue #1075
            });
            $(".datetimepicker1").on("dp.change", function (e) {
                $('.datetimepicker2').data("DateTimePicker").minDate(e.date);
            });
            $(".datetimepicker2").on("dp.change", function (e) {
                $('.datetimepicker1').data("DateTimePicker").maxDate(e.date);
            });

        } );

    </script>
@endsection