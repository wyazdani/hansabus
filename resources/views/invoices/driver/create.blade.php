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
                                <select id="customerID" name="customer_id" onchange="$('#searchForm').submit()" class="form-control filterBox">
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
                        {{--<div class="col-md-6" >
                            <div class="form-group text-left">
                                <a href="javascript:void(0);"
                                   class="btn btn-info disabled generate_invoice"
                                   id="generate_invoice">{{ __('messages.generate_invoice') }}</a>
                            </div>
                        </div>--}}
                    </div>
                    </form>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class=" mb-4">
                            <div class="table-responsive">
                                <input type="hidden" name="customer_ids" id="customerIDs" >
                                <input type="hidden" name="hire_ids" id="hire_ids" >

                                <input type="hidden" name="grand_total" id="grand_total" value="">
                                <form class="form" method="POST" action="{{ route('generate-driver-invoice') }}"
                                      id="theForm">
                                    @csrf
                                <input type="hidden" name="customer_id" id="customer_id" value="{{request()->get('customer_id')}}">
                                <input type="hidden" name="total" id="total" value="">
                                    <input type="hidden" name="vat" id="vat">

                                <table class="table table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" width="5%">
                                            <div class="custom-control custom-checkbox" style="top: -5px;">
                                                <input type="checkbox" class="custom-control-input" id="isSelected">
                                                <label class="custom-control-label" for="isSelected">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th class="border-top-0" >{{__('driver_invoice.hire_id')}}</th>
                                        <th class="border-top-0" >{{__('tour.customer')}}</th>
                                        <th class="border-top-0" >{{__('tour.driver')}}</th>
                                        <th class="border-top-0">{{__('tour.from')}}</th>
                                        <th class="border-top-0">{{__('tour.to')}}</th>
                                        <th class="border-top-0">{{__('tour.price')}}</th>
                                        <th class="border-top-0" >&nbsp;</th>
                                        <th class="border-top-0">{{ __('tour_invoice.vat') }}</th>
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
                                            <input type="hidden" id="customer_id_{!! $row->id !!}" value="{!! $row->customer_id !!}">
                                            <input type="hidden" id="hire_id_{!! $row->id !!}" value="{!! $row->id !!}">
                                            <td>{{$row->customer->name}}</td>
                                            <td>{{$row->driver->driver_name}}</td>
                                            <td>{{$row->from_date}}</td>
                                            <td>{{$row->to_date}}</td>
                                            <td id="price_{{$row->id}}">{{$row->price}}</td>
                                            <td><a href="javascript:;" onclick="generateSingleInvoice('{{$row->id}}')" class="btn-sm btn btn-outline-primary">{{__("messages.generate_invoice")}}</a></td>
                                            <td><input style="width: 64px" type="number" id="vat_single_{!! $row->id !!}"
                                                       class="form-control has_numeric_value" value=0 min="0" max="99"></td>
                                        </tr>
                                    @endforeach

                                    @if(!count($rows))
                                        <tr><td colspan="9" class="text-center">{{__("messages.no_record")}}.</td></tr>
                                    @endif

                                    <tr><td colspan="9">{{$rows->appends(request()->input())->links()}}</td> </tr>

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
            var vat   = $('#vat_single_'+id).val();
            $('#vat').val(vat);
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
                var totals = getTotal();
                $('#grand_total').val(totals);
                var customers   =   getCustomers();

                $('#customerIDs').val(customers);
                if($('#customerIDs').val() != '') {

                    console.log(total);
                    $('#generate_invoice').removeClass('disabled');

                }
            }
            else {
                console.log('No');
                $('#generate_invoice').addClass('disabled');
            }
        }

        function getCustomers(){

            var checkboxs= document.getElementsByName("ids[]");
            var customers='';
            for(var i=0; i<checkboxs.length; i++)
            {
                if(checkboxs[i].checked)
                {
                    customers= parseInt($('#customer_id_'+checkboxs[i].value).val());
                    /*customers.push(parseInt($('#customer_id_'+checkboxs[i].value).val()));*/
                }
            }
            return customers;
        }
        function getHires(){

            var checkboxs= document.getElementsByName("ids[]");
            var tours=[];
            for(var i=0; i<checkboxs.length; i++)
            {
                if(checkboxs[i].checked)
                {
                    /*customers= parseInt($('#customer_id_'+checkboxs[i].value).val());*/
                    tours.push(parseInt($('#hire_id__'+checkboxs[i].value).val()));
                }
            }
            return tours;
        }
        $(document).ready(function() {

            $('body').on('click','.generate_invoice',function () {

                var customer_id  =   $('#customerIDs').val();
                var grand_total     =   $('#grand_total').val();
                var hire_ids     =   getHires();
                console.log(hire_ids);
                $.ajax({
                    type:   "POST",
                    url:    "{!! route('generate-bulk-driver-invoice') !!}",
                    data:   {
                        customer_id:customer_id,
                        grand_total:grand_total,
                        hire_ids:hire_ids,
                        _token:'{!! csrf_token() !!}',
                    },
                    success: function(data){
                        toastr.success("{!! __('driver_invoice.generated') !!}");
                        /*window.location = "{!! url('/tour-invoices') !!}";*/
                    }
                });
            });
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