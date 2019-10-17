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
                                <h4 class="card-title">{{__('hire.heading.index')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <a href="{{ route('hire-drivers.create') }}" id="addRow" class="btn btn-info ml-2 mt-2">{{__('hire.heading.add')}}</a>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            {{--<div class="form-group">
                                <input type='text' name="customer_search" id="customer_search"
                                       placeholder="{{__('tour.customer')}}" class="form-control filterBox"
                                       value="{{ request()->get('customer_search') }}"
                                       onkeyup="if(this.value=='')$('#customer_id').val('')">
                                <input type="hidden" id="customer_id" name="customer_id"
                                       value="{{ request()->get('customer_id') }}" >
                            </div>--}}
                            <select name="customer_id" id="customer_id" class="{{($errors->has('customer_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true">
                                <option value="">{{__('tour.select_customer')}}</option>
                                @foreach($customers as $customer)
                                    <option value="{!! $customer->id !!}" >{!! $customer->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
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
                                <input type='text' id="hireID" placeholder="Hire ID" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <a href="javascript:;" id="searchBtn" class="btn btn-outline-success"><i class="ft-search"></i> {{__('messages.search')}}</a>
                            </div>
                        </div>
                    </div>
                    {{--<div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('driver-invoice-create') }}" class="btn btn-success ml-2 mt-2">
                                {{ __('driver_invoice.heading.add') }}</a>
                        </div>
                    </div>--}}
                </div>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="px-3 mb-4">
                            <div class="table-responsive">
                                <table class="table table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" width="5%">ID</th>
                                        <th class="border-top-0" width="20%">{{__('hire.customer')}}</th>
                                        <th class="border-top-0" width="15%">{{__('hire.driver')}}</th>
                                        <th class="border-top-0" width="11%">{{__('hire.from')}}</th>
                                        <th class="border-top-0" width="11%">{{__('hire.to')}}</th>
                                        <th class="border-top-0" width="8%">{{__('hire.price')}}</th>
                                        <th class="border-top-0" width="5%">Status</th>
                                        <th class="border-top-0" width="8%">{{__('tour.action')}}</th>
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
    @include('hire-drivers.view')
    <script>

        var deleteMe = function(id){

            if(confirm('{{__("messages.want_to_delete")}}')){

                $.ajax({
                    url: '{{ url('/hire-drivers') }}/'+id,
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
                url: "{{ url('/hire-drivers') }}/"+id,
                cache: false,
                success: function(t){

                    $('#v_name').html(t.driver.driver_name+  ': <small>'+ t.from_date+ ' - '+ t.to_date +'</small>');
                    $('#v_customer').html(t.customer.name);
                    $('#v_price').html(t.price);

                         if(t.status == 1) $('#v_status').html('Draft');
                    else if(t.status == 2) $('#v_status').html('Confirmed');
                    else if(t.status == 3) $('#v_status').html('Invoiced');
                    else if(t.status == 4) $('#v_status').html('Paid');
                    else if(t.status == 5) $('#v_status').html('Canceled');

                    var attachments = '<ul>';
                    $.each(t.attachments, function(index, item) {

                        if(item.file.includes('.pdf') || item.file.includes('.txt') || item.file.includes('.doc')){
                            attachments += '<li><a href="{{ url('/attachments') }}/'+item.file+'" target="_blank"><i class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i></a></li>';
                        }else{
                            attachments += '<p><img src="{{ url('/attachments') }}/'+item.file+'" style="display:block; width: 90%; height:auto;"></p>';
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

        $(document).ready(function() {
            $('body').on('click','.generate_invoice',function () {
                var elem    =   $(this);
                var customer_id = elem.data('customer_id');
                var total = elem.data('total');
                var ids= [];
                ids[0] = elem.data('id');
                $(this).remove();
                $.ajax({
                    type:   "POST",
                    url:    "{!! route('generate-driver-invoice') !!}",
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
                "bInfo": false,
                // "bAutoWidth": false,

                "processing": true,
                "serverSide": true,
                // "searchable" : true,
                'searching':false,
                "order": [[ 0, "desc" ]],
                "language": {
                    "search": "{{__('messages.search')}}",
                    "emptyTable": "{{__('messages.no_record')}}"
                },
                "pageLength": 10,
                "bLengthChange" : false,
                "aoColumnDefs": [
                    {
                        "aTargets": [6],
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
                    "aTargets": [7],
                    "mData": "",
                    "mRender": function (data, type, row) {

                        var edit = '';  var trash = '';  var view = ''; var status=''; var buttons = '';

                        // console.log(row.status);
                        status  = '<a class="danger p-0" data-original-title="Change Status" title="Change Status" ';
                        if(row.status == '1'){
                            status  = '<a class="success p-0" data-original-title="Change Status" title="Change Status" ';
                        }

                        status += 'href="{!! url("/hire-driver/change-status/'+row.id+'") !!}">';
                        status += '<i class="icon-power font-medium-3 mr-2"></i></a>';


                        edit  = '<a class="info p-0" data-original-title="Edit" title="Edit" ';
                        edit += 'href="hire-drivers/'+row.id+'/edit")">';
                        edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';

                        trash  = '<a class="danger p-0" data-original-title="Delete" title="Delete" ';
                        trash += ' href="javascript:;" onclick="deleteMe('+row.id+')" >';
                        trash += '<i class="icon-trash font-medium-3 mr-2"></i></a>';

                        view  = '<a class="p-0" data-original-title="View" title="View" ';
                        view += ' href="javascript:;" onclick="viewTour('+row.id+');" >';
                        view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';

                        var generate_invoice = "generate_invoice_" + row.id;
                        if(row.status==2){
                            /*generate_invoice = '<a href="javascript:void(0)" title="{{__("messages.generate_invoice")}}" data-customer_id='+row.customer_id+' data-total="1" data-id='+row.id+' class="generate_invoice" id="generate_id['+row.id+']"><i class="fa fa-file-o font-medium-3 mr-2"></i></a>';*/
                            generate_invoice = '';

                        }else{
                            generate_invoice = '';
                        }
                        buttons = ''+view;
                        if(row.status == '1' || row.status == '2'){
                            buttons = edit+trash+view;
                        }
                        return '<div class="text-right">'+buttons+generate_invoice+'</div>';


                        // return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
                    }
                }],
                "ajax": {
                    "url": "{{ url('/hire-driver-list') }}",
                    "type": "GET",
                    "data": function ( d ) {
                        d._token = '{{ csrf_token() }}';
                        d.customer_id = $('#customer_id').val();
                        d.driver_id = $('#driver_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.id = $('#hireID').val();
                    }
                },
                'rowId': 'id',
                "columns": [
                    { "data": "id" },
                    { "data": "customer.name" },
                    { "data": "driver.driver_name" },
                    { "data": "from_date" },
                    { "data": "to_date" },
                    { "data": "price" }
                ],
                drawCallback: deleteMe|viewTour,
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