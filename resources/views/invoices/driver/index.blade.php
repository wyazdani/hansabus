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
                                <h4 class="card-title">{{__('messages.tour_invoices')}}</h4>
                            </div>
                        </div>
                    </div>
                    <div>&nbsp;</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="customer_id" class="form-control filterBox">
                                    <option value="">{{__('tour.select_customer')}}</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' id="from_date" placeholder="{{__('tour.from')}}" class="form-control datetimepicker1" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' id="to_date" placeholder="{{__('tour.to')}}" class="form-control datetimepicker2" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type='text' id="tourID" placeholder="Tour ID" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <a href="javascript:;" id="searchBtn" class="btn btn-warning ml-2 bg-warning"><i class="ft-search"></i> {{__('messages.search')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content mt-1">
                    <div class="card-body">
                        <div class="px-3 mb-4">

                            <div class="table-responsive">
                                <form class="form" method="POST" action="{{ route('generate-invoice') }}" >
                                    @csrf

                                <table class="table table-hover table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" width="5%">

                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       id="isSelected">
                                            </div>

                                        </th>
                                        <th class="border-top-0" width="5%">Tour #</th>
                                        <th class="border-top-0" width="20%">{{__('tour.vehicle')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.from')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.to')}}</th>
                                        <th class="border-top-0" width="19%">{{__('tour.driver')}}</th>
                                        <th class="border-top-0" width="8%">{{__('tour.price')}}</th>
                                        <th class="border-top-0" width="8%">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody id="toursDiv">
                                    </tbody>
                                    <tr id="generate_invoice" style="display: none"><td colspan="7" class="text-left"><input type="submit" value="{{__('messages.generate_invoice')}}" class="btn btn-success ml-2"></td></tr>
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
    @include('tours.view')
    <script>
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
                $('#generate_invoice').show();
            }
            else {
                $('#generate_invoice').hide();
            }
        }

        function getTours(){

            if($('#customer_id').val() == ''){
                $('#toursDiv').html('');
            }

            var data =  {
                'status':2,
                'customer_id' : $('#customer_id').val(),
                'from_date' : $('#from_date').val(),
                'to_date' : $('#to_date').val(),
                'id' : $('#tourID').val(),
            };
            $.ajax({
                url: '{{ url('/tours-list') }}',
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
                            '<td><div class="form-check"><input class="form-check-input ids" type="checkbox" ' +
                            ' onclick="addTours();" value="' + r.data[i].id + '" name="ids[]"></div></td>' +
                            '<td>' + r.data[i].id + '</td>' +
                            '<td>' + r.data[i].vehicle.name + '</td>' +
                            '<td>' + r.data[i].from_date + '</td>' +
                            '<td>' + r.data[i].to_date + '</td>' +
                            '<td>' + r.data[i].driver.driver_name + '</td>' +
                            '<td>' + r.data[i].price + '</td>' +
                            '<td><a href="javascript:;" class="btn-info btn-sm btn">{{__("messages.generate_invoice")}}</a></td>' +
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
                addTours();
            });


            /* filter by customer, from/to dates change */
            $('.filterBox ').on('change', function(){
                getTours();
            });
            /* filter by search button click */
            $('#searchBtn').on('click', function(){
                getTours();
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

            getTours();

        });

    </script>
@endsection