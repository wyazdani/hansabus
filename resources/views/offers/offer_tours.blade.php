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
                                <h4 class="card-title">{{__('offer.heading.index')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTable">
                                <a href="{{ route('offers.create') }}" id="addRow" class="btn btn-info ml-2 mt-2">{{__('offer.heading.add')}}</a>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="px-3 mb-4">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-info {!! request()->is('offers')?'active':'' !!}" href="{!! route('offers.index') !!}">Offers</a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a class="nav-link btn btn-outline-info {!! request()->is('offer-tours')?'active':'' !!}" href="{!! route('offer_tours') !!}">Offer Tours</a>
                                </li>
                            </ul>
                            <div class="table-responsive">
                                <table class=" table table-hover datatable-basic table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" width="5%">ID</th>
                                        <th class="border-top-0" width="14%">{{__('offer.customer')}}</th>
                                        <th class="border-top-0" width="14%">{{__('offer.from')}}</th>
                                        <th class="border-top-0" width="14%">{{__('offer.to')}}</th>
                                        <th class="border-top-0" width="15%">{{__('offer.departure')}}</th>
                                        <th class="border-top-0" width="15%">{{__('offer.arrival')}}</th>
                                        <th class="border-top-0" width="7%">{{__('offer.type')}}</th>
                                        <th class="border-top-0" width="8%">{{__('offer.email')}}</th>
                                        <th class="border-top-0" width="3%">{{__('offer.web')}}</th>
                                        <th class="border-top-0 d-print-none" width="16%">{{__('offer.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inquiries  as $inquiry)
                                        <tr>
                                            <td>{!! $inquiry->id !!}</td>
                                            <td>{!! $inquiry->name !!}</td>
                                            <td>{!! $inquiry->inquiryaddresses[0]->from_address !!}</td>
                                            <td>{!! $inquiry->inquiryaddresses[0]->to_address !!}</td>
                                            <td>{!! !empty($inquiry->inquiryaddresses[0]->time)?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[0]->time)):'' !!}</td>
                                            <td>{!! !empty($inquiry->inquiryaddresses[1])?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[1]->time)):'' !!}</td>
                                            <td>{!! !empty($inquiry->inquiryaddresses[1])?__('offer.two_way'):__('offer.one_way') !!}</td>
                                            <td>{!! $inquiry->email !!}</td>
                                            <td>{!! !empty($inquiry->is_web)?__('messages.yes'):__('messages.no') !!}</td>
                                            <td>
                                                @if($inquiry->status)
                                                    <div style="display: none" class="btn-group">
                                                        <a class="btn" href="{!! route('offers.edit',$inquiry->id) !!}"><i class="icon-pencil font-medium-3 mr-2"></i></a>
                                                        <a class="btn" href="javascript:void(0)" data-inquiry_id="{!! $inquiry->id !!}" id="send_mail_popup" >
                                                            <i {!! ($inquiry->status==1)?'style="color:green;"':'' !!} class="icon-envelope font-medium-3 mr-2"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div  style="display: none" class="btn-group">
                                                        <a class="btn" href="{!! route('offers.edit',$inquiry->id) !!}"><i class="icon-pencil font-medium-3 mr-2"></i></a>
                                                        <a class="btn" href="javascript:void(0)" data-inquiry_id="{!! $inquiry->id !!}" id="send_mail_popup" >
                                                            <i {!! ($inquiry->status==1)?'style="color:green;"':'' !!} class="icon-envelope font-medium-3 mr-2"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pull-right">
                                    {!! $inquiries->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('pagejs')
    <div class="modal fade text-left"  id="addCustomerPopup" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">{{ __('customer.heading.add') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ft-x blue-grey darken-4"></i>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" tabindex="-1" id="default_model"
         role="dialog" aria-labelledby="myModalLabel17"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        </div>
    </div>
    <script>
        function _addCustomer(){
            $(".btn_submit").attr("disabled", true);
            $('#customerAddForm input').removeClass('error_input');
            $.ajax({
                url: "{{ route('customers.store') }}",
                data: $('#customerAddForm').serialize()+"&_token={{ csrf_token() }}&key=popup",
                type: 'POST',
                cache: false,
                success: function(res){

                    if(res.errors){
                        $(".btn_submit").attr("disabled", false);
                        $.each(res.errors, function (key, val) {
                            $( "input[name="+key+"]" ).addClass('error_input');
                        });

                    }else{

                        var newOption = new Option(res.name, res.id);
                        $('#customer_id').append(newOption);
                        $( "#customer_search" ).val(res.name);
                        $('#customer_id').val(res.id).trigger('change');
                        $('#customerAddForm')[0].reset();
                        $('.selectpicker').selectpicker('refresh');
                        $('#addCustomerPopup').modal('hide');
                        $(".btn_submit").attr("disabled", false);
                    }
                },
                error: function (reject) {
                    $(".btn_submit").attr("disabled", false);
                    if( reject.status === 422 ) {
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function (key, val) {
                            console.log(key+'=>'+val);
                            $( "input[name="+key+"]" ).addClass('error_input');
                        });
                    }
                }
            });
            return false;
        }
        function addCustomer(){

            $('#customerAddForm input').removeClass('error_input');
            $('#addCustomerPopup').modal('show');
        }
        $(document).ready(function() {
            var tableDiv = $('#listingTable').DataTable( {

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
                "order": [[ 0, "desc" ]],
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

                    "aTargets": [9],
                    "mData": "",
                    "mRender": function (data, type, row) {

                        var edit = '';   var email = ''; var view = ''; var buttons = '';



                        /*edit  = '<a class="btn" title="Edit" ';
                        edit += 'href="{!! url("/offers/'+row.id+'/edit") !!}">';
                        edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';*/

                        email  = '<a class="btn" href="javascript:void(0)"';
                        email += ' data-inquiry_id="'+row.id+'" id="send_mail_popup" title="Email" >';
                        email += '<i style="'+((row.status ==1)?"color:green":'')+'" class="icon-envelope font-medium-3 mr-2"></i></a>';
                        view  = '<a class="p-0 d-print-none view_offer" data-inquiry_id="'+row.id+'" title="View" ';
                        view += ' href="javascript:;"  >';
                        view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';
                        var add_customer    =   '';

                        buttons = view+edit;
                        return buttons;



                        // return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
                    }
                }],
                "ajax": "{{ route('offer_tour_list') }}",
                'rowId': 'id',
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "from_address" },
                    { "data": "to_address" },
                    { "data": "time0" },
                    { "data": "time1" },
                    { "data": "type" },
                    { "data": "email" },
                    { "data": "web" },
                    // { "data": "actions" }
                ],
                "fnDrawCallback": function(oSettings) {
                    if ($('#listingTable tr').length < 12) {
                        // $('.dataTables_paginate').hide();
                    }
                }

            });
            $('body').on('click', '.add_customer', function () {
                var elem        =   $(this);
                $.ajax({
                    type        :   'post',
                    url         :   '{!! route('add_customer_form') !!}',
                    data        :   {
                        _token      :    '{!! csrf_token() !!}',
                        offer_id    :      elem.attr('data-inquiry_id')
                    },
                    success     :   function(data){
                        $("#addCustomerPopup .modal-body").html(data);
                        $("#addCustomerPopup").modal('show');
                    }
                });
            });
            $('body').on('click', '#send_mail_popup', function () {
                var elem        =   $(this);
                var inquiry_id  =   elem.data('inquiry_id');
                $.ajax({
                    type:   "POST",
                    url:    "{!! route('offers.modal_mail') !!}",
                    data:   {
                        inquiry_id:inquiry_id,

                        _token:'{!! csrf_token() !!}',

                    },
                    success: function(data){
                        $("#default_model .modal-dialog").html(data);
                        $("#default_model").modal('show');



                    }
                });

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
