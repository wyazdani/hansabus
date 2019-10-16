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
                                <h4 class="card-title">{{__('tour_invoice.heading.add')}}</h4>
                            </div>
                        </div>
                    </div>
                    <div>&nbsp;</div>
                    <form class="form" method="GET" action="{{ route('tour-invoice-create') }}" id="searchForm">
                        @csrf
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <select id="customer_id" name="customer_id" onchange="$('#searchForm').submit()" class="form-control filterBox">
                                    <option value="">{{__('tour.select_customer')}}</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"
                                        @if($customer->id == request()->get('customer_id') )
                                            {{ 'Selected' }}
                                                @endif
                                        >{{$customer->name}}</option> @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1.5">
                            <div class="form-group"><input type='text' name="from_date" id="from_date"  value="{{request()->get('from_date')}}"
                                                           autocomplete="off" placeholder="{{__('tour.from')}}" class="form-control datetimepicker1" /></div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' name="to_date" id="to_date" value="{{request()->get('to_date')}}"
                                       autocomplete="off" placeholder="{{__('tour.to')}}" class="form-control datetimepicker2" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group"><input type='text' name="id" id="invoiceID" autocomplete="off" value="{{request()->get('id')}}"
                                                           placeholder="Invoice ID" class="form-control" /></div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <a href="javascript:;" onclick="$('#searchForm').submit()" class="btn btn-outline-success"><i class="ft-search"></i> {{__('messages.search')}}</a>
                            </div>
                        </div>
                        @if($request->customer_id)
                        <div class="col-md-6" >
                            <div class="form-group text-left">
                                <a href="javascript:void(0);" {{--onclick="$('#theForm').submit()"--}}
                                   class="btn btn-info disabled generate_invoice"
                                   id="generate_invoice">{{ __('messages.generate_invoice') }}</a>
                            </div>
                        </div>
                            @else
                            <div class="col-lg-12">
                                <div class="alert alert-danger">
                                    IMPORTANT: Search Customer to generate Bulk Invoice!
                                </div>
                            </div>
                        @endif
                    </div>
                    </form>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="px-3 mb-4">
                            <input type="hidden" name="customer_ids" id="customerIDs" >
                            <input type="hidden" name="tour_ids" id="tour_ids" >
                            <input type="hidden" name="grand_total" id="grand_total" value="">
                            <div class="table-responsive">
                                <form class="form" method="POST" action="{{ route('generate-tour-invoice') }}" id="theForm">
                                    @csrf
                                <input type="hidden" name="customer_id" id="customerID" value="{{request()->get('customer_id')}}">

                                <input type="hidden" name="total" id="total" value="">


                                <table class="table table-hover table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        @if($request->customer_id)
                                        <th class="border-top-0" width="5%">
                                            <div class="custom-control custom-checkbox" style="top: -5px;">
                                                <input type="checkbox" class="custom-control-input" id="isSelected">
                                                <label class="custom-control-label" for="isSelected">&nbsp;</label>
                                            </div>
                                        </th>
                                        @endif
                                        <th class="border-top-0" width="5%">Tour #</th>
                                        <th class="border-top-0" width="20%">{{__('tour.vehicle')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.from')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.to')}}</th>
                                        <th class="border-top-0" width="19%">{{__('tour.customer')}}</th>
                                        <th class="border-top-0" width="19%">{{__('tour.driver')}}</th>
                                        <th class="border-top-0" width="8%">{{__('tour.price')}}</th>
                                        <th class="border-top-0" width="8%">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody id="toursDiv">

                                    @foreach($rows as $row)
                                        <tr>
                                            @if($request->customer_id)
                                            <td><div class="custom-control custom-checkbox" style="top: -5px;">
                                                    <input type="checkbox" id="{{$row->id}}" data-customer_id="{!! $row->customer_id !!}" class="custom-control-input form-check-input ids" onclick="addTours();" value="{{$row->id}}" name="ids[]">
                                                    <label class="custom-control-label" for="{{$row->id}}">&nbsp;</label>
                                                </div>
                                            </td>
                                            @endif
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->vehicle->name }}</td>
                                            <td>{{ $row->from_date }}</td>
                                            <td>{{ $row->to_date }}</td>
                                            <td>{{ $row->customer->name }}</td>
                                            <td>{{ $row->driver->driver_name }}</td>
                                            <input type="hidden" id="customer_id_{!! $row->id !!}" value="{!! $row->customer_id !!}">
                                            <input type="hidden" id="tour_id_{!! $row->id !!}" value="{!! $row->id !!}">
                                            <td id="price_{{$row->id}}">{{ $row->price }}</td>
                                            <td><a href="javascript:void(0);" onclick="generateSingleInvoice('{{ $row->id }}')" class="btn-sm btn btn-outline-primary">{{__("messages.generate_invoice")}}</a></td>
                                        </tr>
                                    @endforeach
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
            $('#total').val(total);

            $.ajax({
                url: '{{ url('/tours') }}/'+id,
                type: 'GET',  // user.destroy
                success: function(r) {

                    console.log(r.customer_id);
                    $('#customerID').val(r.customer_id);
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
        function getTours(){

            var checkboxs= document.getElementsByName("ids[]");
            var tours=[];
            for(var i=0; i<checkboxs.length; i++)
            {
                if(checkboxs[i].checked)
                {
                    /*customers= parseInt($('#customer_id_'+checkboxs[i].value).val());*/
                    tours.push(parseInt($('#tour_id_'+checkboxs[i].value).val()));
                }
            }
            return tours;
        }
        function addTours()
        {

            var checkboxs= document.getElementsByName("ids[]");
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

                var total = getTotal();
                $('#grand_total').val(total);
                var customers   =   getCustomers();

                $('#customerIDs').val(customers);
                var tours   =   getTours();
                $('#tour_ids').val(tours);
                if($('#customerIDs').val() != '') {

                    $('#generate_invoice').removeClass('disabled');
                }
            }
            else {
                $('#generate_invoice').addClass('disabled');
            }
        }


        $(document).ready(function() {

            @if($request->customer_id)
                $('body').on('click','.generate_invoice',function () {
                    var customer_id  =   $('#customerIDs').val();
                    var grand_total     =   $('#grand_total').val();
                    var tours_ids     =   getTours();
                    console.log(tours_ids);
                    $.ajax({
                        type:   "POST",
                        url:    "{!! route('generate-bulk-tour-invoice') !!}",
                        data:   {
                            customer_id:customer_id,
                            grand_total:grand_total,
                            tours_ids:tours_ids,
                            _token:'{!! csrf_token() !!}',
                        },
                        success: function(data){
                            toastr.success("{!! __('driver_invoice.generated') !!}");
                            window.location = "{!! url('/tour-invoices') !!}";
                        }
                    });
                });
            @endif
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
                addTours();
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

            // getTours();

        });

    </script>
@endsection