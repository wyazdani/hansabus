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
                                <h4 class="card-title">{{__('tour.heading.index')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTable">
                                <a href="{{ url('/tours/create') }}" id="addRow" class="btn btn-info ml-2 mt-2">{{__('tour.heading.add')}}</a>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="customer_id" id="customer_id" class="{{($errors->has('customer_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true">
                                    <option value="">{{__('tour.select_customer')}}</option>
                                    @foreach($customers as $customer)
                                        <option value="{!! $customer->id !!}" >{!! $customer->name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{--<input type='text' name="driver_search" id="driver_search"
                                       placeholder="{{__('tour.driver')}}" class="form-control filterBox"
                                       value="{{ request()->get('driver_search') }}"
                                       onkeyup="if(this.value=='')$('#driver_id').val('')">
                                <input type="hidden" id="driver_id" name="driver_id"
                                       value="{{ request()->get('driver_id') }}">--}}
                                <select name="driver_id" id="driver_id" class="{{($errors->has('driver_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true">
                                    <option value="">{{__('tour.select_driver')}}</option>
                                    @foreach($drivers as $driver)
                                        <option value="{!! $driver->id !!}" >{!! $driver->driver_name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select  name="vehicle_id" id="vehicle_id" class="{{($errors->has('vehicle_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control filterBox'}}" data-live-search="true">
                                    <option value="">{{__('tour.select_vehicle')}}</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
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
                                <input type='text' id="tourID" placeholder="Tour ID" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="status" id="status" class="form-control filterBox">
                                    <option value="">{{__('tour.select_status')}}</option>
                                    @foreach($tour_statuses as $status)
                                        <option value="{{ $status->id  }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
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
                                        <th class="border-top-0" width="20%">{{__('tour.customer')}}</th>
                                        <th class="border-top-0" width="15%">{{__('tour.vehicle')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.from')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.to')}}</th>
                                        <th class="border-top-0" width="15%">{{__('tour.driver')}}</th>
                                        <th class="border-top-0" width="3%">{{__('tour.passengers')}}</th>
                                        <th class="border-top-0" width="3%">{{__('tour.price')}}</th>
                                        <th class="border-top-0" width="5%">Status</th>
                                        <th class="border-top-0 d-print-none text-center" width="21%">{{__('tour.action')}}</th>

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
    <div class="modal fade text-left" tabindex="-1" id="default_model"
         role="dialog" aria-labelledby="myModalLabel17"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        </div>
    </div>
    @include('tours.view')
    <script>
        $(document).ready(function() {
            $('body').on('click', '#send_mail_popup', function () {
                var elem        =   $(this);
                var tour_id  =   elem.data('tour_id');
                $.ajax({
                    type:   "POST",
                    url:    "{!! route('tour-send-email') !!}",
                    data:   {
                        tour_id:tour_id,

                        _token:'{!! csrf_token() !!}',

                    },
                    success: function(data){
                        $("#default_model .modal-dialog").html(data);
                        $("#default_model").modal('show');

                    }
                });
            });
            $('body').on('click','.generate_invoice',function () {
                var elem    =   $(this);
                var customer_id = elem.data('customer_id');
                var total = elem.data('total');
                var ids= [];
                ids[0] = elem.data('id');
                $(this).remove();
                $.ajax({
                    type:   "POST",
                    url:    "{!! route('generate-tour-invoice') !!}",
                    data:   {
                        customer_id:customer_id,
                        total:total,
                        ids:ids,
                        _token:'{!! csrf_token() !!}',

                    },
                    success: function(data){
                        toastr.success("{!! __('driver_invoice.generated') !!}");
                    }
                });

            });

        });
        var deleteMe = function(id){

            if(confirm('{{__("messages.want_to_delete")}}')){

                $.ajax({
                    url: '{{ url('/tours') }}/'+id,
                    data: "_token={{ csrf_token() }}",
                    type: 'DELETE',  // user.destroy
                    success: function(result) {
                        // console.log(result);
                        $('#'+id).remove();
                    }
                });
            }
        };
        var viewTour = function(id){

            $.ajax({
                url: "{{ url('/tours') }}/"+id,
                cache: false,
                success: function(t){

                    $('#v_name').html(t.customer.name+  ': <small>'+ t.from_date+ ' - '+ t.to_date +'</small>');

                    $('#v_driver').html(t.driver.driver_name?t.driver.driver_name:'None');
                    $('#v_vehicle').html(t.vehicle.name?t.vehicle.name:'None');

                    $('#v_passengers').html(t.passengers?t.passengers:'None');
                    $('#v_guide').html(t.guide ? t.guide : 'None');
                    $('#v_price').html(t.price?t.price:'None');
                    $('#v_description').html(t.description?t.description:'None');
                    $('#v_tour_id').val(t.id);
                    $('#v_driver_id').val(t.driver_id);



                         if(t.status == 1) $('#v_status').html('Draft');
                    else if(t.status == 2) $('#v_status').html('Confirmed');
                    else if(t.status == 3) $('#v_status').html('Invoiced');
                    else if(t.status == 4) $('#v_status').html('Paid');
                    else if(t.status == 5) $('#v_status').html('Canceled');
                    else  $('#v_status').html('None');

                    var attachments = '<ul>';
                    $.each(t.attachments, function(index, item) {

                        if(item.file.includes('.pdf') || item.file.includes('.txt') || item.file.includes('.doc')){
                            attachments += '<li><a href="{{ url('/attachments') }}/'+item.file+'" target="_blank"><i class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i></a></li>';
                        }else{
                            attachments += '<li><img src="{{ url('/attachments') }}/'+item.file+'" style="display:block; width: 100%; height:auto;"></li>';
                        }

                    });
                    attachments += '</ul>';
                    if(t.attachments.length){
                        $('#v_attachments').html('<h4>Attachments:</h4>'+attachments);
                    }

                    $('#viewModel').modal('show');
                }
            });
        };
        var emailTour = function(id){


            $.ajax({
                url: "{{ url('/tours') }}/"+id,
                cache: false,
                success: function(t){

                    $('#v_name_e').html(t.customer.name+  ': <small>'+ t.from_date+ ' - '+ t.to_date +'</small>');

                    $('#v_driver_e').html(t.driver.driver_name?t.driver.driver_name:"None");
                    $('#v_vehicle_e').html(t.vehicle.name?t.vehicle.name:'None');

                    $('#v_passengers_e').html(t.passengers?t.passengers:'None');
                    $('#v_guide_e').html(t.guide ? t.guide : 'None');
                    $('#v_price_e').html(t.price?t.price:'None');
                    $('#v_description_e').html(t.description?t.description:'None');
                    $('#tour_id_email').val(t.id);
                    $('#customer_id_email').val(t.customer_id);
                    if(t.status == 1) $('#v_status_e').html('Draft');
                    else if(t.status == 2) $('#v_status_e').html('Confirmed');
                    else if(t.status == 3) $('#v_status_e').html('Invoiced');
                    else if(t.status == 4) $('#v_status_e').html('Paid');
                    else if(t.status == 5) $('#v_status_e').html('Canceled');
                    else  $('#v_status_e').html('None');
                    $('#e_customer_id').val(t.customer_id);
                    $('#e_status').val(t.status);
                    $('#e_ids').val(t.id);


                    var attachments = '<ul>';
                    $.each(t.attachments, function(index, item) {

                        if(item.file.includes('.pdf') || item.file.includes('.txt') || item.file.includes('.doc')){
                            attachments += '<li><a href="{{ url('/attachments') }}/'+item.file+'" target="_blank"><i class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i></a></li>';
                        }else{
                            attachments += '<li><img src="{{ url('/attachments') }}/'+item.file+'" style="display:block; width: 100%; height:auto;"></li>';
                        }

                    });
                    attachments += '</ul>';
                    if(t.attachments.length){
                        $('#v_attachments_e').html('<h4>Attachments:</h4>'+attachments);
                    }

                    $('#default_model').modal('show');

                }
            });
        };
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
                // 'bProcessing': true,
                "bInfo": false,
                // "bAutoWidth": false,
                "order": [[ 0, "desc" ]],
                "processing": true,
                "serverSide": true,
                // "searchable" : true,
                'searching':false,
                "language": {
                    "search": "{{__('messages.search')}}",
                    "emptyTable": "{{__('messages.no_record')}}"
                },
                "pageLength": 11,
                "bLengthChange" : false,
                "aoColumnDefs": [
                    // { aTargets: ["_all"], bSortable: false },
                    {
                        "aTargets": [8],
                        "mData": "",
                        "mRender": function (data, type, row) {
                            var status = '';
                            if(row.status == '1'){
                                status = 'Draft';
                            }else if(row.status == '2'){
                                status = 'Confirmed';
                            }else if(row.status == '3'){
                                status = 'Invoiced';
                            }else if(row.status == '4'){
                                status = 'Paid';
                            }else if(row.status == '5'){
                                status = 'Canceled';
                            }
                            return status;
                        }
                    },
                    {
                    "aTargets": [9],
                    "mData": "",
                    "mRender": function (data, type, row) {

                       var edit = '';  var trash = '';  var view = ''; var status=''; var buttons = '';

                        // console.log(row.status);
                        status  = '<a class="danger p-0 d-print-none" data-original-title="Change Status" title="Change Status" ';
                        if(row.status == '1'){
                            status  = '<a class="success p-0 d-print-none" data-original-title="Change Status" title="Change Status" ';
                        }

                        status += 'href="{!! url("/tours/change-status/'+row.id+'") !!}">';
                        status += '<i class="icon-power font-medium-3 mr-2"></i></a>';


                        edit  = '<a class="info p-0 d-print-none" data-original-title="Edit" title="Edit" ';
                        edit += 'href="tours/'+row.id+'/edit")">';
                        edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';

                        trash  = '<a class="danger p-0 d-print-none" data-original-title="Delete" title="Delete" ';
                        trash += ' href="javascript:;" onclick="deleteMe('+row.id+')" >';
                        trash += '<i class="icon-trash font-medium-3 mr-2"></i></a>';

                        view  = '<a class="p-0 d-print-none" data-original-title="View" title="View" ';
                        view += ' href="javascript:;" onclick="viewTour('+row.id+');" >';
                        view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';
                        var email = "email_" + row.id;
                        if(row.status == '1' || row.status == '2' || row.status == '3') {
                            email = '<a class="p-0 d-print-none" href="javascript:void(0)" data-tour_id=' + row.id + ' id="send_mail_popup" >';
                            email += '<i class="icon-envelope font-medium-3 mr-2"></i></a>';
                        }else{
                            email = '';
                        }
                        var generate_invoice = "generate_invoice_" + row.id;
                        if(row.status==2){
                            generate_invoice = '<a href="javascript:void(0)" title="{{__("messages.generate_invoice")}}" data-customer_id='+row.customer_id+' data-total="1" data-id='+row.id+' class="generate_invoice" id="generate_id['+row.id+']"><i class="fa fa-file-o font-medium-3 mr-2"></i></a>';

                        }else{
                            generate_invoice = '';
                        }
                        buttons = ''+view;
                        if(row.status == '1' || row.status == '2'){
                            buttons = edit+trash+view+generate_invoice;
                        }
                        return '<div class="text-right">'+buttons+email+'</div>';
                        // return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
                    }
                },
                    /*{
                        "aTargets": [10],
                        "mData": "",
                        sortable: false,
                        "mRender": function (data, type, row) {
                            var email = "email_" + row.id;
                            var fields;
                            email  = '<a class="p-0 d-print-none" href="javascript:void(0)" data-tour_id='+row.id+' id="send_mail_popup" >';
                            email += '<i class="icon-envelope font-medium-3 mr-2"></i></a>';
                            var generate_invoice = "generate_invoice_" + row.id;
                            if(row.status==2){
                                generate_invoice = '<a href="javascript:void(0)" data-customer_id='+row.customer_id+' data-total="1" data-id='+row.id+' class="generate_invoice success"><i class="fa fa-file font-medium-3 mr-2"></i></a>';

                            }else{
                                generate_invoice = '';
                            }

                            fields =email+generate_invoice;
                            return '<div class="text-right">'+fields+'</div>';
                        }
                    }*/

                ],
                "ajax": {
                    "url": "{{ url('/tours-list') }}",
                    "type": "GET",
                    "data": function ( d ) {

                        d.status = $('#status').val();
                        d.vehicle_id = $('#vehicle_id').val();
                        d.customer_id = $('#customer_id').val();
                        d.driver_id = $('#driver_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.id = $('#tourID').val();

                    }
                },
                searchText: {
                        search: '{{__("messages.search")}}'
                },
                'rowId': 'id',
                "columns": [
                    { "data": "id" },
                    { "data": "customer.name" },
                    { "data": "vehicle.name" },
                    { "data": "from_date" },
                    { "data": "to_date" },
                    { "data": "driver_name.driver_name" },
                    { "data": "passengers" },
                    { "data": "price" },

                ],
                drawCallback: deleteMe|viewTour|emailTour,
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
            $('.datetimepicker1').datetimepicker(
                {format:'DD.MM.YYYY HH:mm'}
            );
            $('.datetimepicker2').datetimepicker({
                format:'DD.MM.YYYY HH:mm',
                useCurrent: false //Important! See issue #1075
            });
            $(".datetimepicker1").on("dp.change", function (e) {
                $('.datetimepicker2').data("DateTimePicker").minDate(e.date);
            });
            $(".datetimepicker2").on("dp.change", function (e) {
                $('.datetimepicker1').data("DateTimePicker").maxDate(e.date);
            });

        });

    </script>
@endsection