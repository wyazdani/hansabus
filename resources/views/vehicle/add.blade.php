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
                            <h4 class="card-title">{{ (!empty($vehicle->id))?__('vehicle.heading.edit'):__('vehicle.heading.add') }}</h4>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 text-right">
                        <div class="dataTables_filter"><a href="{{ url('/vehicles') }}" class="btn btn-info ml-2 mt-2">
                                {{__('vehicle.heading.index')}}
                                <i class="ft-arrow-right mt-3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-content mt-1">

                    @if(!empty($vehicle->id))
                    <form class="form" method="POST" action="{{ route('vehicles.update',$vehicle->id) }}" 
                    id="theForm">
                    @method('PUT')
                    <input type="hidden" id="id" name="id" value="{{ $vehicle->id }}">
                    @else
                    <form class="form" method="POST" action="{{ route('vehicles.store') }}" id="theForm">
                    @endif


                    @csrf
                    <input type="hidden" id="returnFlag" name="returnFlag" value="">

                    <div class="row">

                        <div class="col-md-8">
                            <div class="card">

                                <div class="card-body">
                                    <div class="px-3">

                                        <div class="form-body">


                                            @if(count($vehicleTypes) >= 1)

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">{{__('vehicle.name')}}</label>

                                                        <input type="text" name="name" class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->name))?$vehicle->name:old('name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">{{__('vehicle.year')}}</label>

                                                        <select name="year" class="{{($errors->has('year')) ?'form-control error_input':'form-control'}}">
                                                            @for($year=date('Y'); $year>(date('Y')-50); $year--)
                                                            <option value="{{ $year }}"

                                                             @if( (!empty($vehicle->year) && $vehicle->year==$year) ||
                                                             (!empty(old('year')) && old('year') == $year) )
                                                                 {{ 'Selected' }}
                                                             @endif
                                                            >{{ $year }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3">{{__('vehicle.make')}}</label>

                                                        <input type="text" name="make" class="{{($errors->has('make')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->make))?$vehicle->make:old('make') }}">


                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">{{__('vehicle.engine_number')}}</label>

                                                        <input type="text" name="engineNumber" class="{{($errors->has('engineNumber')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->engineNumber))?$vehicle->engineNumber:old('engineNumber') }}">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label for="customSelect">{{__('vehicle.vehicle_type')}}</label>

                                                        <select class="{{($errors->has('vehicle_type')) ?'custom-select d-block w-100 error_input':'custom-select d-block w-100'}}"
                                                        id="customSelect" name="vehicle_type">
                                                            <option>{{__('messages.select_vehicle')}}</option>
                                                            @foreach($vehicleTypes as $vehicleType)
                                                            
                                                            <option value="{{ $vehicleType->id }}"
                                                            @if(
                                                            (!empty($vehicle->vehicle_type) &&
                                                            $vehicle->vehicle_type == $vehicleType->id)
                                                            || old('vehicle_type') == $vehicleType->id )
                                                            {{ 'selected' }}
                                                            @endif    
                                                            >{{ $vehicleType->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">{{__('vehicle.seats')}}</label>
                                                        <input type="number" name="seats" class="{{($errors->has('seats')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->seats))?$vehicle->seats:old('seats') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">{{__('vehicle.license_plate')}}</label>
                                                        <input type="text" name="licensePlate" class="{{($errors->has('licensePlate')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->licensePlate))?$vehicle->licensePlate:old('licensePlate') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">{{__('vehicle.color')}}</label>

                                                        <input type="text" name="color" class="{{($errors->has('color')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->color))?$vehicle->color:old('color') }}">


                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">{{__('vehicle.reg_number')}}</label>

                                                        <input type="text" name="registrationNumber" class="{{($errors->has('registrationNumber')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->registrationNumber))?$vehicle->registrationNumber:old('registrationNumber') }}">


                                                    </div>
                                                </div>

                                                <div class="col-md-6">



                                                    @if ($errors->has('transmission'))
                                                        <span class="label label-danger">{!! $errors->first('transmission') !!}</span>@endif
                                                    <div class="form-group">
                                                        <label>{{__('vehicle.transmission')}}</label>
                                                        <div class="input-group">
                                                            <div class="custom-control custom-radio display-inline-block mr-2">
                                                                <input type="radio" name="transmission" class="custom-control-input"
                                                                id="customRadioInline4"
                                                                value="Automatic"
                                                                @if(old('transmission') == 'Automatic') 
                                                                    {{ 'checked' }} 
                                                                @elseif(!empty($vehicle->transmission) && $vehicle->transmission == 'Automatic')
                                                                    {{ 'checked' }}
                                                                @endif 
                                                                >
                                                                <label class="custom-control-label" for="customRadioInline4">{{__('vehicle.automatic')}}</label>
                                                            </div>
                                                            <div class="custom-control custom-radio display-inline-block">
                                                                <input type="radio" name="transmission" class="custom-control-input"
                                                                id="customRadioInline3"
                                                                value="Manual"
                                                                @if(old('transmission') == 'Manual') 
                                                                    {{ 'checked' }} 
                                                                @elseif(!empty($vehicle->transmission) && $vehicle->transmission == 'Manual')
                                                                    {{ 'checked' }}
                                                                @endif 
                                                                >
                                                                <label class="custom-control-label" for="customRadioInline3">{{__('vehicle.manual')}}</label>
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

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>{{__('vehicle.ac')}}</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="AC"
                                            @if(!empty(old('AC')) && old('AC')) {{ 'checked' }} @elseif(!empty($vehicle->AC) && $vehicle->AC)
                                            {{ 'checked' }}
                                            @endif >
                                            <span class="slider round"></span>
                                            <p>{{__('messages.yes/no')}}</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{__('vehicle.radio')}}</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="radio"
                                            @if(!empty(old('radio')) && old('radio')) {{ 'checked' }} @elseif(!empty($vehicle->radio) && $vehicle->radio)
                                            {{ 'checked' }}
                                            @endif >
                                            <span class="slider round"></span>
                                            <p>{{__('messages.yes/no')}}</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{__('vehicle.sunroof')}}</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="sunroof" @if(!empty(old('sunroof')) && old('sunroof')) {{ 'checked' }} @elseif(!empty($vehicle->sunroof) && $vehicle->sunroof)
                                            {{ 'checked' }}
                                            @endif >
                                            <span class="slider round"></span>
                                            <p>{{__('messages.yes/no')}}</p>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>{{__('vehicle.phone_charging')}}</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="phoneCharging" @if(!empty(old('phoneCharging')) && old('phoneCharging')) {{ 'checked' }} @elseif(!empty($vehicle->phoneCharging) && $vehicle->phoneCharging)
                                            {{ 'checked' }}
                                            @endif >
                                            <span class="slider round"></span>
                                            <p>{{__('messages.yes/no')}}</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                        <div class="col-md-12 text-left">
                            <div class="form-actions">
                                <a href="{{ route('vehicles.index') }}" class="btn btn-danger mr-1">
                                    <i class="fa fa-times"></i> {{__('messages.cancel')}}
                                </a>
                                @if(!empty($vehicle->id))
                                    <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                        <i class="icon-note"></i> {{__('messages.update')}}
                                    </button>
                                @else

                                    <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                        <i class="icon-note"></i> {{__('messages.save')}}
                                    </button>
                                    <button type="button" onclick="$('#returnFlag').val('0'); $('#theForm').submit();" class="btn btn-info">
                                        <i class="icon-note"></i> {{__('messages.save_add_another')}}
                                    </button>
                                @endif
                            </div>
                        </div>

                </form>
                        @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-danger" style="color: #454545 !important">
                                            {{__('messages.add_vehicle_type')}}
                                        </div>
                                    </div>
                                </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection