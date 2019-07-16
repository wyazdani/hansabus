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
                                <h4 class="card-title">{{__('driver_invoice.heading.add')}}</h4>
                            </div>
                        </div>
                    </div>
                    <div>&nbsp;</div>

                    <form class="form" method="GET" action="{{ route('driver-invoice-create') }}" id="searchForm">
                        @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="customerID" name="customer_id" class="form-control filterBox">
                                    <option value="">{{__('tour.select_customer')}}</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"
                                        @if($customer->id == request()->get('customer_id') )
                                            {{ 'Selected' }}
                                        @endif
                                        >{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' value="{{ request()->get('from_date') }}" id="from_date" name="from_date" autocomplete="off" placeholder="{{__('tour.from')}}" class="form-control datetimepicker1" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' value="{{ request()->get('to_date') }}" id="to_date" name="to_date" autocomplete="off" placeholder="{{__('tour.to')}}" class="form-control datetimepicker2" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' value="{{ request()->get('id') }}"  id="hireID" name="id" placeholder="ID" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <a href="javascript:;" onclick="$('#searchForm').submit()" id="searchBtn" class="btn btn-warning ml-2 bg-warning"><i class="ft-search"></i> {{__('messages.search')}}</a>
                            </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="form-group text-left">
                                <a href="javascript:;" onclick="$('#theForm').submit()"
                                   class="btn btn-info disabled"
                                   id="generate_invoice">{{ __('messages.generate_invoice') }}</a>
                            </div>
                        </div>
                    </div>
                    </form>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class=" mb-4">
                            <div class="table-responsive">
                                <form class="form" method="POST" action="{{ route('generate-driver-invoice') }}"
                                      id="theForm">
                                    @csrf
                                <input type="hidden" name="customer_id" id="customer_id" value="">
                                <input type="hidden" name="total" id="total" value="">

                                <table class="table table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" width="5%">
                                            <div class="custom-control custom-checkbox" style="top: -5px;">
                                                <input type="checkbox" class="custom-control-input" id="isSelected">
                                                <label class="custom-control-label" for="isSelected">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th class="border-top-0" width="5%">{{__('driver_invoice.hire_id')}}</th>
                                        <th class="border-top-0" width="19%">{{__('tour.customer')}}</th>
                                        <th class="border-top-0" width="19%">{{__('tour.driver')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.from')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.to')}}</th>
                                        <th class="border-top-0" width="8%">{{__('tour.price')}}</th>
                                        <th class="border-top-0" width="8%">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody id="hiresDiv">
                                    @foreach($rows as $row)
                                        <tr>
                                            <td><div class="custom-control custom-checkbox" style="top: -5px;">
                                                    <input type="checkbox" id="a{{$row->id}}"
                                                           class="custom-control-input form-check-input ids" onclick="addHires();"
                                                           value="{{$row->id}}"
                                                           name="ids[]">
                                                    <label class="custom-control-label" for="a{{$row->id}}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->customer->name}}</td>
                                            <td>{{$row->driver->driver_name}}</td>
                                            <td>{{$row->from_date}}</td>
                                            <td>{{$row->to_date}}</td>
                                            <td id="price_{{$row->id}}">{{$row->price}}</td>
                                            <td><a href="javascript:;" onclick="generateSingleInvoice('{{$row->id}}')" class="btn-sm btn btn-outline-primary">{{__("messages.generate_invoice")}}</a></td>
                                        </tr>
                                    @endforeach

                                    @if(!count($rows))
                                        <tr><td colspan="8" class="text-center">{{__("messages.no_record")}}.</td></tr>
                                    @endif

                                    <tr><td colspan="8">{{$rows->appends(request()->input())->links()}}</td> </tr>

                                    </tbody>
                                </table>
                                </form>
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

        function generateSingleInvoice(id){

            var checkboxs = document.getElementsByName("ids[]");
            for(var i=0; i<checkboxs.length; i++)
            {
                if(checkboxs[i].value == id){
                    checkboxs[i].checked = true;
                }else{
                    checkboxs[i].checked = false;
                }
            }
            var total = getTotal();
            $('#total').val(total);

            $.ajax({
                url: '{{ url('/hire-drivers') }}/'+id,
                type: 'GET',  // user.destroy
                success: function(r) {
                    console.log(r.customer_id);
                    $('#customer_id').val(r.customer_id);
                    $('#theForm').submit();
                }
            });
        }

        function getTotal(){

            var checkboxs= document.getElementsByName("ids[]");
            var total=0;
            for(var i=0; i<checkboxs.length; i++)
            {
                if(checkboxs[i].checked)
                {
                    total += parseInt($('#price_'+checkboxs[i].value).html());
                }
            }
            return total;
        }
        function addHires()
        {
            var checkboxs = document.getElementsByName("ids[]");
            var okay=false;
            for(var i=0; i<checkboxs.length; i++)
            {
                if(checkboxs[i].checked)
                {
                    okay=true;
                    break;
                }
            }
            if(okay){
                console.log('OK');
                var total = getTotal();
                $('#total').val(total);

                if($('#customerID').val() != '') {

                    console.log(total);
                    $('#generate_invoice').removeClass('disabled');

                }
            }
            else {
                console.log('No');
                $('#generate_invoice').addClass('disabled');
            }
        }

        function getHires(){

            if($('#customerID').val() == ''){
                $('#hiresDiv').html('');
            }

            var data =  {
                'status':2,
                'customer_id' : $('#customerID').val(),
                'from_date' : $('#from_date').val(),
                'to_date' : $('#to_date').val(),
                'id' : $('#hireID').val(),
            };
            $.ajax({
                url: '{{ url('/hire-driver-list') }}',
                data: data,
                type: 'GET',  // user.destroy
                success: function(r) {
                    var html = '';

                    var i;
                    var total = 0;

                    if (r.data.length) {

                    for (i = 0; i < r.data.length; ++i) {

                        total += parseInt(r.data[i].price);

                        html +=
                            '<tr>' +
                            '<td><div class="custom-control custom-checkbox" style="top: -5px;">' +
                            '<input type="checkbox" id="a' + r.data[i].id + '" ' +
                            'class="custom-control-input form-check-input ids" onclick="addHires();" ' +
                            'value="' + r.data[i].id + '" name="ids[]">' +
                            '<label class="custom-control-label" for="a' + r.data[i].id + '">&nbsp;</label></div></td>' +
                            '<td>' + r.data[i].id + '</td>' +
                            '<td>' + r.data[i].driver.driver_name + '</td>' +
                            '<td>' + r.data[i].from_date + '</td>' +
                            '<td>' + r.data[i].to_date + '</td>' +
                            '<td id="price_' + r.data[i].id + '">' + r.data[i].price + '</td>' +
                            '<td><a href="javascript:;" onclick="generateSingleInvoice(' + r.data[i].id + ')" class="btn-sm btn btn-outline-primary">{{__("messages.generate_invoice")}}</a></td>' +
                            '</tr>';
                    }
                        $('#hiresDiv').html(html);

                    }else{
                        $('#hiresDiv').html('<tr><td colspan="8" class="text-center">{{__("messages.no_record")}}.</td></tr>');
                    }
                    // console.log(html);
                }
            });
        }
        $(document).ready(function() {


            /* check / uncheck all tours */
            /* check / uncheck all tours */
            $('#isSelected').click(function() {

                var checkboxs = document.getElementsByName("ids[]");

                if(this.checked){

                    for(var i=0; i<checkboxs.length; i++)
                    {
                        checkboxs[i].checked = true;
                    }

                }else{

                    for(var i=0; i<checkboxs.length; i++)
                    {
                        checkboxs[i].checked = false;
                    }
                }
                addHires();
            });


            /* filter by customer, from/to dates change */
            $('.filterBox ').on('change', function(){

                $('#customer_id').val($('#customerID').val());
                // getHires();
            });
            /* filter by search button click */
            $('#searchBtn').on('click', function(){
                // getHires();
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

            // getHires();

        });

    </script>
@endsection