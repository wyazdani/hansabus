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
                                <h4 class="card-title">{{__('messages.invoices')}}</h4>
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
                                <table class="table table-hover table-xl mb-0" id="listingTable">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" width="5%">ID</th>
                                        <th class="border-top-0" width="20%">{{__('tour.vehicle')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.from')}}</th>
                                        <th class="border-top-0" width="11%">{{__('tour.to')}}</th>
                                        <th class="border-top-0" width="20%">{{__('tour.driver')}}</th>
                                        <th class="border-top-0" width="8%">{{__('tour.passengers')}}</th>
                                        <th class="border-top-0" width="8%">{{__('tour.price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="toursDiv">
                                    </tbody>
                                </table>
                                <div class="downloadForm" style="display: none">
                                    <form class="form" method="GET" action="{{ route('download-invoice') }}" >
                                    @csrf
                                        <input type="hidden" name="customer_id" id="customerID" value="">
                                        <input type="hidden" name="from_date" id="fromDate" value="">
                                        <input type="hidden" name="to_date" id="toDate" value="">
                                        <input type="hidden" name="id" id="ID" value="">
                                        <input type="submit" value="{{__('messages.download')}}" class="btn btn-info ml-2">
                                    </form>
                                </div>
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

        function getTours(){

            if($('#customer_id').val() == ''){
                return false;
            }

            var data =  {
                'customer_id' : $('#customer_id').val(),
                'from_date' : $('#from_date').val(),
                'to_date' : $('#to_date').val()
            };
            $.ajax({
                url: '{{ url('/tours-list') }}',
                data: data,
                type: 'GET',  // user.destroy
                success: function(r) {
                    var html = '';

                    var i; var total=0;
                    for (i=0; i < r.data.length; ++i) {

                        total += parseInt(r.data[i].price);
                        html +=
                            '<tr>' +
                                '<td>'+r.data[i].id+'</td>' +
                                '<td>'+r.data[i].vehicle.name+'</td>' +
                                '<td>'+r.data[i].from_date+'</td>' +
                                '<td>'+r.data[i].to_date+'</td>' +
                                '<td>'+r.data[i].driver.driver_name+'</td>' +
                                '<td>'+r.data[i].passengers+'</td>' +
                                '<td>'+r.data[i].price+'</td>' +
                            '</tr>';
                    }
                    html +=
                        '<tr>' +
                        '<td colspan="6" style="text-align: right;">Total:</td>' +
                        '<td>'+total+'</td>' +
                        '</tr>';

                    $('#toursDiv').html(html);

                    $('#customerID').val($('#customer_id').val());
                    $('#fromDate').val($('#from_date').val());
                    $('#toDate').val($('#to_date').val());
                    $('#ID').val($('#id').val());
                    $('.downloadForm').show();

                    // console.log(html);
                }
            });
        }
        $(document).ready(function() {



            $('.filterBox ').on('change', function(){
                getTours();
            });
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

        });

    </script>
@endsection