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
                        <div class="col-sm-6 col-md-6 text-right">
                            <a href="{{ route('tour-invoice-create') }}" class="btn btn-success ml-2 mt-2">
                                {{ __('tour_invoice.heading.add') }}</a>
                        </div>
                    </div>
                    <div>&nbsp;</div>

                    <form class="form" method="GET" action="{{ route('tour-invoices') }}" id="searchForm">
                        @csrf
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {{--<input type='text' name="customer_search" id="customer_search"
                                           placeholder="{{__('tour.customer')}}" class="form-control filterBox" value="{{ request()->get('customer_search') }}" >
                                    <input type="hidden" id="customer_id" name="customer_id" value="{{ request()->get('customer_id') }}" >--}}
                                    <select name="customer_id" id="customer_id" class="{{($errors->has('customer_id')) ?'selectpicker show-tick form-control error_input':'selectpicker show-tick form-control'}}" data-live-search="true">
                                        <option value="">{{__('tour.select_customer')}}</option>
                                        @foreach($customers as $customer)
                                            <option value="{!! $customer->id !!}" >{!! $customer->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
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
                                <div class="form-group"><input type='text' name="id" id="invoiceID" value="{{request()->get('id')}}"
                                                               placeholder="Invoice ID" class="form-control" /></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="status" name="status" class="form-control filterBox"><option value="">{{__('tour.select_status')}}</option>
                                        <option value="1" @if(request()->get('status') == 1) {{ 'Selected' }}  @endif >Unpaid</option>
                                        <option value="2" @if(request()->get('status') == 2) {{ 'Selected' }}  @endif >Paid</option></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <a href="javascript:;" onclick="$('#searchForm').submit()"  class="btn btn-outline-success"><i class="ft-search"></i> {{__('messages.search')}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" >
                                <div class="form-group text-left">
                                    <a href="javascript:;" onclick="$('#theForm').submit()"
                                       class="btn btn-info disabled"
                                       id="mark_as_paidDiv">{{ __('tour_invoice.mark_as_paid') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="px-3 mb-4">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-info" href="{!! route('tour-invoices') !!}">{{ __('tour.single_invoice') }}</a>

                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-info" href="{!! route('tour-invoices',['is_bulk' => '1']) !!}">{{ __('tour.bulk_invoice') }}</a>
                                </li>
                            </ul>
                            <div class="table-responsive">
                                <form class="form" method="GET" action="{{ route('mark-as-paid') }}" id="theForm">
                                    @csrf
                                    <table class="table table-xl mb-0" id="listingTable">
                                        <thead>
                                        <tr>
                                            <th class="border-top-0" width="5%">
                                                <div class="custom-control custom-checkbox" style="top: -5px;">
                                                    <input type="checkbox" class="custom-control-input" id="isSelected" name="example1">
                                                    <label class="custom-control-label" for="isSelected">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th class="border-top-0" width="10%">{{__('tour_invoice.invoice')}} #</th>
                                            <th class="border-top-0" width="35%">{{__('tour_invoice.customer')}}</th>
                                            <th class="border-top-0" width="10%">{{__('tour_invoice.total')}}</th>
                                            <th class="border-top-0" width="10%">{{__('tour_invoice.status')}}</th>
                                            <th class="border-top-0" width="20%">{{__('tour_invoice.date')}}</th>
                                            <th class="border-top-0" width="7.5%">{{__('tour.action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="toursDiv">
                                        @if(count($rows)>0)
                                            @foreach($rows as $row)

                                                <tr>
                                                    @if($row->status == 'Unpaid')
                                                        <td><div class="custom-control custom-checkbox" style="top: -5px;">
                                                                <input type="checkbox" id="a{{$row->id}}" class="custom-control-input form-check-input ids" onclick="showButton();" value="{{$row->id}}" name="ids[]">
                                                                <label class="custom-control-label" for="a{{$row->id}}">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td>&nbsp;</td>
                                                    @endif
                                                    <td>{{ $row->invoice_id }}</td>
                                                    <td>{{ $row->customer->name }}</td>
                                                    <td>{{ $row->total }}</td>
                                                    <td>{{ $row->status }}</td>
                                                    <td>{{ $row->created }}</td>
                                                    <td>
                                                        @if($row->status == 'Unpaid')
                                                            <a href="{{ route('mark-as-paid')}}?ids[]={{$row->id}}" class="btn btn-sm btn-outline-info">{{__('driver_invoice.mark_as_paid')}}</a>
                                                        @else
                                                            <a href="{{ route('download-tours-invoice') }}?id={{$row->id}}" class="btn btn-sm btn-outline-primary">Download</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr><td colspan="7">{{$rows->appends(request()->input())->links()}}</td> </tr>
                                        @else
                                            <tr><td colspan="8" class="text-center">No data available in table.</td></tr>
                                        @endif
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