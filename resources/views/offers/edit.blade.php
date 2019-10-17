@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')
    <div class="row match-height">
        <div class="col-md-12" id="recent-sales">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6 col-md-8">
                            <div class="card-title-wrap bar-primary">
                                <h4 class="card-title">{{__('offer.heading.add')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 text-right">
                            <div class="dataTables_filter"><a href="{{ route('offers.index') }}" class="btn btn-info ml-2 mt-2">{{__('offer.heading.index')}}
                                    <i class="ft-arrow-right mt-3"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                    {{ Form::open(['route' => ['offers.update',$inquiry->id], 'method' => 'PUT']) }}
                    <div class="card-content mt-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="px-3">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>{{__('offer.customer_name')}}<span class="{{($errors->has('name')) ?'errorStar':''}}">*</span></label>
                                                        <input type='text' name="name" class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}"
                                                               value="{{!empty($inquiry->name)?$inquiry->name:old('name') }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>{{__('offer.email')}}<span class="{{($errors->has('email')) ?'errorStar':''}}">*</span></label>
                                                        <input type='text' name="email" class="{{($errors->has('email')) ?'form-control error_input':'form-control'}}"
                                                               value="{{!empty($inquiry->email)?$inquiry->email:old('email') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>{{__('offer.from_address')}}<span class="{{($errors->has('from_address')) ?'errorStar':''}}">*</span></label>
                                                        <input type='text' id="from_address" name="from_address" class="{{($errors->has('from_address')) ?'form-control error_input':'form-control'}}"
                                                               value="{{!empty($inquiry->inquiryaddresses[0]->from_address)?$inquiry->inquiryaddresses[0]->from_address:old('from_address') }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label >{{__('offer.to_address')}}<span class="{{($errors->has('to_address')) ?'errorStar':''}}">*</span></label>
                                                        <input type='text' id="to_address" name="to_address" class="{{($errors->has('to_address')) ?'form-control error_input':'form-control'}}"
                                                               value="{{!empty($inquiry->inquiryaddresses[0]->to_address)?$inquiry->inquiryaddresses[0]->to_address:old('to_address') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>{{__('offer.one_way/two_way')}}</label>
                                                            <div class="form-group">
                                                                <div class="display-inline-block">
                                                                    <label class="switch">
                                                                        <input type="checkbox" name="trip_type" id="trip_type"
                                                                        @if(!empty($inquiry->inquiryaddresses[1])) checked @endif>
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="fromDate">{{__('offer.departure_time')}}<span class="{{($errors->has('departure_date')) ?'errorStar':''}}">*</span></label>
                                                            <div class='input-group date'>
                                                                <input type='text' name="departure_date" autocomplete="off"
                                                                       class="{{($errors->has('departure_date')) ?'form-control error_input':'form-control'}} datetimepicker1"
                                                                       value="{{!empty($inquiry->inquiryaddresses[0]->time)?date('d.m.Y H:i',strtotime($inquiry->inquiryaddresses[0]->time)):old('departure_date') }}"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="toDate">{{__('offer.arrival_time')}}<span class="{{($errors->has('arrival_date')) ?'errorStar':''}}">*</span></label>
                                                            <div class='input-group date'>
                                                                <input type='text' name="arrival_date" id="arrival_date" autocomplete="off"
                                                                       class="{{($errors->has('arrival_date')) ?'form-control error_input':'form-control'}} datetimepicker2"
                                                                       value="{{!empty($inquiry->inquiryaddresses[1])?date('d.m.Y H:i',strtotime($inquiry->inquiryaddresses[1]->time)):old('arrival_date') }}"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="projectinput3"># {{__('offer.seats')}}<span class="{{($errors->has('seats')) ?'errorStar':''}}">*</span></label>
                                                            <input type="number" name="seats" id="seats"
                                                                   class="{{($errors->has('seats')) ?'error_input form-control':'form-control'}}"
                                                                   value="{{ !empty($inquiry->seats)?$inquiry->seats:old('seats') }}" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="projectinput3"> {{__('offer.description')}}<span class="{{($errors->has('description')) ?'errorStar':''}}"></span></label>
                                                            <textarea  name="description" id="description"
                                                                       class="{{($errors->has('description')) ?'error_input form-control':'form-control'}}"
                                                            >{{ !empty($inquiry->description)?$inquiry->description:old('description') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 text-left">
                        <div class="form-actions">
                            <a href="{{ route('offers.index')}}" class="btn btn-danger mr-1"><b>
                                    <i class="fa fa-times"></i></b> {{__('messages.cancel')}}</a>
                            <button type="submit" class="btn btn-success"><b>
                                    <i class="icon-note"></i></b> {{__('messages.update')}}</button>
                        </div>
                    </div>
                {{ Form::close() }}

            </div>


        </div>
    </div>
@endsection
@section('pagejs')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrPi8W87YGBfBsNwR6KytqCD_y5N3r5Zs&libraries=places&callback=initAutocomplete" async defer></script>
    <script type="text/javascript">
        function initAutocomplete() {
            var data_input  =   ['from_address','to_address'];
            for (var i=0;i<data_input.length;i++){
                var input_place     =   document.getElementById(data_input[i]);
                var autocomplete = new google.maps.places.Autocomplete(input_place);
                autocomplete.setFields([
                    'address_components', 'geometry', 'icon', 'name'
                ]);
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#arrival_date").prop('disabled', true);
            @if(!empty($inquiry->inquiryaddresses[1]))
                $("#arrival_date").prop('disabled', false);
            @endif

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
            $('body').on('change', '#trip_type', function () {
                if (this.checked){
                    $("#arrival_date").prop('disabled', false);
                }else{
                    $("#arrival_date").prop('disabled', true);
                }
            });
        });
    </script>
@endsection