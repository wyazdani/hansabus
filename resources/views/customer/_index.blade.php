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
                            <form class="form" method="GET" action="{{ route('customers.index') }}" id="theForm">
                            <label>
                                <input type="search" name="q" class="form-control form-control-sm" placeholder="Search"></label>
                                <input type="submit" value="Search" class="btn btn-sm btn-info ml-2 mt-2">

                                <a href="{{ url('/customers/create') }}" id="addRow" class="btn btn-sm btn-info ml-2 mt-2"><i class="ft-plus"></i> Add customer</a>
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
                                <th class="border-top-0" width="5%">ID</th>
                                <th class="border-top-0" width="20%">Customer Name</th>
                                <th class="border-top-0" width="20%">Email</th>
                                <th class="border-top-0" width="10%">Phone</th>
                                <th class="border-top-0" width="20%">Address</th>
                                <th class="border-top-0" width="13%">Web</th>
                                <th class="border-top-0" width="12%">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($customers as $customer)
                            <tr id="row_{{ $customer->id }}">
                                <td class="text-truncate">{{ $customer->id }}</td>
                                <td class="text-truncate">{{ str_limit($customer->name,15) }}</td>
                                <td class="text-truncate">{{ $customer->email }}</td>
                                <td class="text-truncate">{{ $customer->phone }}</td>
                                <td class="text-truncate">{{ $customer->address }}</td>
                                <td class="text-truncate">{{ $customer->url }}</td>
                                <td>
                                    {{-- edit --}}
                                    <a class="info p-0" data-original-title="" title="Edit"
                                       href="{{ url('/customers/'.$customer->id.'/edit') }}">
                                        <i class="icon-pencil font-medium-3 mr-2"></i>
                                    </a>
                                    {{-- change status--}}
                                    <a href="{{ url('/customers/change-status/'.$customer->id) }}"
                                       class="{{ (!$customer->status)?'danger':'success' }} p-0"
                                       data-original-title="" title="{{ ($customer->status)?'Click to in-activate':'Click to activate' }}">
                                        <i class="icon-power font-medium-3 mr-2"></i>
                                    </a>
                                    {{-- delete --}}
                                    <a class="danger p-0"  href="javascript:;" onclick="deleteMe('{{ $customer->id }}')"
                                       class="p-0" data-original-title="Delete" >
                                        <i class="icon-trash font-medium-3 mr-2"></i>
                                    </a>
                                    {{-- view --}}
                                    <a href="javascript:;" onclick="viewCustomer('{{ $customer->id }}')"
                                       class="p-0" data-original-title="Delete" >
                                        <i class="icon-eye font-medium-3 mr-2"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-12">{{ $customers->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('pagejs')
    @include('customer.view')
    <script>
        function deleteMe(id){
            if(confirm('Are you sure you want to delete?')) {

                $.ajax({
                    url: '/customers/' + id,
                    data: "_token={{ csrf_token() }}",
                    type: 'DELETE',  // user.destroy
                    success: function (result) {
                        // console.log(result);
                        $('#row_' + id).remove();
                    }
                });
            }
        }
        function viewCustomer(id){

            $.ajax({
                url: "{{ url('/customers') }}/"+id,
                cache: false,
                success: function(customer){

                    // console.log(customer);

                    $('#v_name').html(customer.name);
                    $('#v_email').html(customer.email);
                    $('#v_phone').html(customer.phone);
                    $('#v_url').html(customer.url);
                    $('#v_address').html(customer.address);

                    if(customer.status == 1) $('#v_status').html('Yes'); else $('#v_status').html('No');

                    $('#viewModel').modal('show');

                }
            });
        }
    </script>
@endsection