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
                                <h4 class="card-title">{{__('tour_invoice.heading.index')}}</h4>
                            </div>
                        </div>
                    </div>
                    <div>&nbsp;</div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select id="customer_id" class="form-control filterBox">
                                    <option value="">{{__('tour.select_customer')}}</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1.5">
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
                                <input type='text' id="invoiceID" placeholder="Invoice ID" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="status" class="form-control filterBox">
                                    <option value="">{{__('tour.select_status')}}</option>
                                    <option value="1">Unpaid</option>
                                    <option value="2">Paid</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <a href="javascript:;" id="searchBtn" class="btn btn-outline-success"><i class="ft-search"></i> {{__('messages.search')}}</a>
                            </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="form-group text-left">
                                <a href="javascript:;" onclick="$('#theForm').submit()"
                                   class="btn btn-info disabled"
                                   id="mark_as_paidDiv">{{ __('tour_invoice.mark_as_paid') }}</a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-6 text-right">
                            <div class="dataTables_filter"><a href="{{ route('tour-invoice-create') }}" class="btn btn-success ml-2 mt-2">
                                    {{ __('tour_invoice.heading.add') }}</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="px-3 mb-4">

                            <div class="table-responsive">
                                <form class="form" method="GET" action="{{ route('mark-as-paid') }}" id="theForm">
                                    @csrf
                                <table class="table table-hover table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" width="5%">
                                            <div class="custom-control custom-checkbox" style="top: -5px;">
                                                <input type="checkbox" class="custom-control-input" id="isSelected" name="example1">
                                                <label class="custom-control-label" for="isSelected">&nbsp;</label>
                                            </div>

{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="checkbox" id="isSelected">--}}
{{--                                            </div>--}}
                                        </th>
                                        <th class="border-top-0" width="10%">{{__('tour_invoice.invoice')}} #</th>
                                        <th class="border-top-0" width="35%">{{__('tour_invoice.customer')}}</th>
                                        <th class="border-top-0" width="10%">{{__('tour_invoice.total')}}</th>
                                        <th class="border-top-0" width="10%">{{__('tour_invoice.status')}}</th>
                                        <th class="border-top-0" width="20%">{{__('tour_invoice.date')}}</th>
                                        <th class="border-top-0" width="7.5%">&nbsp;</th>
                                        <th class="border-top-0" width="7.5%">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody id="toursDiv">
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
        function showButton()
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
                $('#mark_as_paidDiv').removeClass('disabled');
            }
            else {
                $('#mark_as_paidDiv').addClass('disabled');
            }
        }

        function getInvoices(){

            if($('#customer_id').val() == ''){
                $('#toursDiv').html('');
            }

            var data =  {
                'status':$('#status').val(),
                'customer_id' : $('#customer_id').val(),
                'from_date' : $('#from_date').val(),
                'to_date' : $('#to_date').val(),
                'id' : $('#invoiceID').val(),
            };
            $.ajax({
                url: '{{ url('/tour-invoices-list') }}',
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
                            '<tr>';

                        if(r.data[i].status == 'Unpaid'){
                            html += '<td><div class="custom-control custom-checkbox" style="top: -5px;">' +
                                '<input type="checkbox" id="a' + r.data[i].id + '" class="custom-control-input form-check-input ids" onclick="showButton();" value="' + r.data[i].id + '" name="ids[]">' +
                                '<label class="custom-control-label" for="a' + r.data[i].id + '">&nbsp;</label></div></td>';
                        }else{
                            html+= '<td>&nbsp;</td>';
                        }

                        html+= '<td>' + r.data[i].invoice_id + '</td>' +
                            '<td>' + r.data[i].customer.name + '</td>' +
                            '<td>' + r.data[i].total + '</td>' +
                            '<td>' + r.data[i].status+ '</td>' +
                            '<td>' + r.data[i].created_at + '</td>';
                        if(r.data[i].status == 'Unpaid'){
                            html+= '<td><a href="{{ route('mark-as-paid')}}?ids[]='+ r.data[i].id + '" class="btn btn-sm btn-outline-info">{{__('tour_invoice.mark_as_paid')}}</a></td>';
                        }else{
                            html+= '<td>&nbsp;</td>';
                        }
                        html+= '<td><a href="{{ route('download-tours-invoice') }}?id=' + r.data[i].id + '" class="btn btn-sm btn-outline-primary">Download</a></td>' +
                            '</tr>';
                    }
                   /* html +=
                        '<tr>' +
                        '<td colspan="7" style="text-align: right;">Total:</td>' +
                        '<td>' + total + '</td>' +
                        '</tr>';*/
                        $('#toursDiv').html(html);

                    }else{
                        $('#toursDiv').html('<tr><td colspan="8" class="text-center">{{__("messages.no_record")}}.</td></tr>');
                    }
                    // console.log(html);
                }
            });
        }
        $(document).ready(function() {


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
                showButton();
            });


            /* filter by customer, from/to dates change */
            $('.filterBox ').on('change', function(){
                getInvoices();
            });
            /* filter by search button click */
            $('#searchBtn').on('click', function(){
                getInvoices();
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

            getInvoices();
        });

    </script>
@endsection