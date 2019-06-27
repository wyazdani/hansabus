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
                                <h4 class="card-title">Customers</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <a href="{{ url('/customers/create') }}" id="addRow" class="btn btn-info ml-2 mt-2"><i class="ft-plus"></i> Add Customer</a>
                            </div>
                        </div>

                    </div>
                    <div class="row"><div class="col-12">@include('layouts.errors')</div></div>
                </div>
                <div class="card-content mt-1">
                    <div class="table-responsive">
                        <table class="table table-hover table-xl mb-0" id="listingTable">
                            <thead>
                                <tr>
                                    <th class="border-top-0" width="5%">ID</th>
                                    <th class="border-top-0" width="20%">Name</th>
                                    <th class="border-top-0" width="20%">Email</th>
                                    <th class="border-top-0" width="10%">Phone</th>
                                    <th class="border-top-0" width="20%">Address</th>
                                    <th class="border-top-0" width="13%">Web</th>
                                    <th class="border-top-0" width="12%">Action</th>
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

@endsection
@section('pagejs')
    @include('customer.view')
    <script>
        var deleteMe = function(id){

            if(confirm('Are you sure you want to delete?')){

                $.ajax({
                    url: '/customers/'+id,
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

                        status += 'href="/customers/change-status/'+row.id+'">';
                        status += '<i class="icon-power font-medium-3 mr-2"></i></a>';


                        edit  = '<a class="info p-0" data-original-title="Edit" title="Edit" ';
                        edit += 'href="/customers/'+row.id+'/edit">';
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

            });

        } );

    </script>
@endsection