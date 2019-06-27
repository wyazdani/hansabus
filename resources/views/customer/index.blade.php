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
                                <h4 class="card-title">{{__('customer.heading.index')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <a href="{{ route('customers.create') }}" id="addRow" class="btn btn-info ml-2 mt-2"><i class="ft-plus"></i> {{__('customer.heading.add')}}</a>
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
                                    <th class="border-top-0" width="20%">{{__('customer.name')}}</th>
                                    <th class="border-top-0" width="20%">{{__('customer.email')}}</th>
                                    <th class="border-top-0" width="10%">{{__('customer.mobile')}}</th>
                                    <th class="border-top-0" width="20%">{{__('customer.address')}}</th>
                                    <th class="border-top-0" width="15%">{{__('customer.web')}}</th>
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
    @include('customer.view')
    <script>
        var deleteMe = function(id){

            if(confirm('{{__("messages.want_to_delete")}}')){

                $.ajax({
                    url: "{{ url('/customers') }}/"+id,
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
                url: "{{ url('/customers') }}/"+id,
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

                "processing": true,
                "serverSide": true,
                "searchable" : true,
                "pageLength": 10,
                "bLengthChange" : false,
                "aoColumnDefs": [{

                    "aTargets": [6],
                    "mData": "",
                    "mRender": function (data, type, row) {

                        var edit = '';  var trash = '';  var view = ''; var status=''; var buttons = '';

                        // console.log(row.status);
                        status  = '<a class="danger p-0" data-original-title="Change Status" title="Change Status" ';
                        if(row.status == '1'){
                            status  = '<a class="success p-0" data-original-title="Change Status" title="Change Status" ';
                        }

                        status += 'href="{!! url("/customers/change-status/'+row.id+'") !!}">';
                        status += '<i class="icon-power font-medium-3 mr-2"></i></a>';


                        edit  = '<a class="info p-0" data-original-title="Edit" title="Edit" ';
                        edit += 'href="{!! url("/customers/'+row.id+'/edit") !!}">';
                        edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';

                        trash  = '<a class="danger p-0" data-original-title="Delete" title="Delete" ';
                        trash += ' href="javascript:;" onclick="deleteMe('+row.id+')" >';
                        trash += '<i class="icon-trash font-medium-3 mr-2"></i></a>';

                        view  = '<a class="p-0" data-original-title="View" title="View" ';
                        view += ' href="javascript:;" onclick="viewCustomer('+row.id+');" >';
                        view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';

                        buttons = status+edit+trash+view;
                        return buttons;
                        // return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
                    }
                }],
                "ajax": "{{ url('/customer-list') }}",
                'rowId': 'id',
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "phone" },
                    { "data": "address" },
                    { "data": "url" },

                    // { "data": "actions" }
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