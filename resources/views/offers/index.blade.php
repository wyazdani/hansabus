@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')
    <div class="row match-height">
        <div class="col-md-12" id="recent-sales">
            <div class="card">
                <div class="card-header d-print-none">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="card-title-wrap bar-primary">
                                <h4 class="card-title">{{__('offer.heading.index')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div id="DataTables_Table_0_filter" class="dataTable">
                                <a href="{{ route('offers.create') }}" id="addRow" class="btn btn-info ml-2 mt-2">{{__('offer.heading.add')}}</a>
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
                                        <th class="border-top-0" width="14%">{{__('offer.customer')}}</th>
                                        <th class="border-top-0" width="14%">{{__('offer.from')}}</th>
                                        <th class="border-top-0" width="14%">{{__('offer.to')}}</th>
                                        <th class="border-top-0" width="15%">{{__('offer.departure')}}</th>
                                        <th class="border-top-0" width="15%">{{__('offer.arrival')}}</th>
                                        <th class="border-top-0" width="7%">{{__('offer.type')}}</th>
                                        <th class="border-top-0" width="8%">{{__('offer.email')}}</th>
                                        <th class="border-top-0" width="3%">{{__('offer.web')}}</th>
                                        <th class="border-top-0 d-print-none" width="16%">{{__('offer.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($inquiries)>0)
                                        @foreach($inquiries  as $inquiry)
                                            <tr>
                                                <td>{!! $inquiry->id !!}</td>
                                                <td>{!! $inquiry->name !!}</td>
                                                <td>{!! $inquiry->inquiryaddresses[0]->from_address !!}</td>
                                                <td>{!! $inquiry->inquiryaddresses[0]->to_address !!}</td>
                                                <td>{!! !empty($inquiry->inquiryaddresses[0]->time)?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[0]->time)):'' !!}</td>
                                                <td>{!! !empty($inquiry->inquiryaddresses[1])?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[1]->time)):'' !!}</td>
                                                <td>{!! !empty($inquiry->inquiryaddresses[1])?__('offer.two_way'):__('offer.one_way') !!}</td>
                                                <td>{!! $inquiry->email !!}</td>
                                                <td>{!! !empty($inquiry->is_web)?__('messages.yes'):__('messages.no') !!}</td>
                                                <td>
                                                    @if($inquiry->status)
                                                        {{__('offer.ofer_sent')}}
                                                    @else
                                                    <div class="btn-group">
                                                        <a class="btn" href="{!! route('offers.edit',$inquiry->id) !!}"><i class="icon-pencil font-medium-3 mr-2"></i></a>
                                                        <a class="btn" href="javascript:void(0)" data-inquiry_id="{!! $inquiry->id !!}" id="send_mail_popup" ><i class="icon-envelope font-medium-3 mr-2"></i></a>
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">No data available in table</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="pull-right">
                                    {!! $inquiries->links() !!}
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
    <div class="modal fade text-left" tabindex="-1" id="default_model"
         role="dialog" aria-labelledby="myModalLabel17"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('body').on('click', '#send_mail_popup', function () {
                var elem        =   $(this);
                var inquiry_id  =   elem.data('inquiry_id');
                $.ajax({
                    type:   "POST",
                    url:    "{!! route('offers.modal_mail') !!}",
                    data:   {
                        inquiry_id:inquiry_id,

                        _token:'{!! csrf_token() !!}',

                    },
                    success: function(data){
                        $("#default_model .modal-dialog").html(data);
                        $("#default_model").modal('show');



                    }
                });

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