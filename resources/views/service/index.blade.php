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
                                <h4 class="card-title">{{__('service.heading.index')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <a href="{{ route('bus-services.create') }}" id="addRow" class="btn btn-info ml-2 mt-2"> {{__('service.heading.add')}}</a>
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
                                    <th class="border-top-0" width="5%">ID</th>
                                    <th class="border-top-0" width="25%">{{__('service.customer')}}</th>
                                    <th class="border-top-0" width="35%">{{__('service.title')}}</th>
                                    <th class="border-top-0" width="10%">{{__('service.price')}}</th>
                                    <th class="border-top-0" width="15%">{{__('service.date')}}</th>
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
    <script>
        var deleteMe = function(id){

            if(confirm('{{__("messages.want_to_delete")}}')){

                $.ajax({
                    url: "{{ url('/bus-services') }}/"+id,
                    data: "_token={{ csrf_token() }}",
                    type: 'DELETE',  // user.destroy
                    success: function(result) {
                        // console.log(result);
                        $('#'+id).remove();
                    }
                });
            }
        };
        var viewCustomer = function(id){

            $.ajax({
                url: "{{ url('/bus-services') }}/"+id,
                cache: false,
                success: function(cus){

                    $('#v_name').html(cus.name);
                    $('#v_email').html(cus.email);
                    $('#v_phone').html(cus.phone);
                    $('#v_url').html(cus.url);
                    $('#v_address').html(cus.address);

                    if(cus.status == 1) $('#v_status').html('Yes'); else $('#v_status').html('No');

                    $('#viewModel').modal('show');
                }
            });
        };
        $(document).ready(function() {


            var tableDiv = $('#listingTable').DataTable({

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
                        view += ' href="javascript:;" onclick="viewCustomer('+row.id+');" >';
                        view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';

                        buttons = edit+view;
                        return buttons;
                        // return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
                    }
                }],
                "ajax": "{{ url('/bus-services-list') }}",
                'rowId': 'id',
                "columns": [
                    { "data": "id" },
                    { "data": "customer" },
                    { "data": "title" },
                    { "data": "total" },
                    { "data": "date" }
                ],
                drawCallback: deleteMe|viewCustomer,
                "fnDrawCallback": function(oSettings) {
                    if ($('#listingTable tr').length < 11) {
                        $('.dataTables_paginate').hide();
                    }
                }

            });

            tableDiv.sPaging = 'btn btn-info ml-2 mt-2';

        } );

    </script>
@endsection