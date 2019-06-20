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
                            <h4 class="card-title">Vehicle Details</h4>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 text-right">
                        <div class="dataTables_filter"><a href="{{ url('/vehicles') }}" class="btn btn-info ml-2 mt-2">Vehicle List
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


                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">Vehicle Name</label>

                                                        <input type="text" name="name" class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->name))?$vehicle->name:old('name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">Year of Manufacture</label>

                                                        <input type="number" name="year" maxlength="4" class=" date-own {{($errors->has('year')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->year))?$vehicle->year:old('year') }}">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3">Make/Model</label>

                                                        <input type="text" name="make" class="{{($errors->has('make')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->make))?$vehicle->make:old('make') }}">


                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">Engine Number</label>

                                                        <input type="text" name="engineNumber" class="{{($errors->has('engineNumber')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->engineNumber))?$vehicle->engineNumber:old('engineNumber') }}">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label for="customSelect">Type of Vehicle</label>

                                                        <select class="{{($errors->has('vehicle_type')) ?'custom-select d-block w-100 error_input':'custom-select d-block w-100'}}"
                                                        id="customSelect" name="vehicle_type">
                                                            <option>Select Vehicle Type</option>
                                                            @foreach($vehicleTypes as $vehicleType)
                                                            
                                                            <option value="{{ $vehicleType->id }}"
                                                            @if(!empty($vehicle->vehicle_type) && $vehicle->vehicle_type == $vehicleType->id)
                                                            {{ 'selected' }}
                                                            @endif    
                                                            >{{ $vehicleType->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">Number of Seats</label>
                                                        <input type="number" name="seats" class="{{($errors->has('seats')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->seats))?$vehicle->seats:old('seats') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">License Plate</label>
                                                        <input type="text" name="licensePlate" class="{{($errors->has('licensePlate')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->licensePlate))?$vehicle->licensePlate:old('licensePlate') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">Vehicle Color</label>

                                                        <input type="text" name="color" class="{{($errors->has('color')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->color))?$vehicle->color:old('color') }}">


                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4">Vehicle Reg Number</label>

                                                        <input type="text" name="registrationNumber" class="{{($errors->has('registrationNumber')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($vehicle->registrationNumber))?$vehicle->registrationNumber:old('registrationNumber') }}">


                                                    </div>
                                                </div>

                                                <div class="col-md-6">



                                                    @if ($errors->has('transmission'))
                                                        <span class="label label-danger">{!! $errors->first('transmission') !!}</span>@endif
                                                    <div class="form-group">
                                                        <label>Transmission</label>
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
                                                                <label class="custom-control-label" for="customRadioInline4">Automatic</label>
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
                                                                <label class="custom-control-label" for="customRadioInline3">Manual</label>
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
                                <label>AC</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="AC" @if(!empty(old('AC')) && old('AC')) {{ 'checked' }} @elseif(!empty($vehicle->AC) && $vehicle->AC)
                                            {{ 'checked' }}
                                            @endif >
                                            <span class="slider round"></span>
                                            <p>Yes / No</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Radio</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="radio" @if(!empty(old('radio')) && old('radio')) {{ 'checked' }} @elseif(!empty($vehicle->radio) && $vehicle->radio)
                                            {{ 'checked' }}
                                            @endif >
                                            <span class="slider round"></span>
                                            <p>Yes / No</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Sunroof</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="sunroof" @if(!empty(old('sunroof')) && old('sunroof')) {{ 'checked' }} @elseif(!empty($vehicle->sunroof) && $vehicle->sunroof)
                                            {{ 'checked' }}
                                            @endif >
                                            <span class="slider round"></span>
                                            <p>Yes / No</p>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Phone Charging Jack</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="phoneCharging" @if(!empty(old('phoneCharging')) && old('phoneCharging')) {{ 'checked' }} @elseif(!empty($vehicle->phoneCharging) && $vehicle->phoneCharging)
                                            {{ 'checked' }}
                                            @endif >
                                            <span class="slider round"></span>
                                            <p>Yes / No</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-actions">
                                <a href="{{ url('/vehicles') }}" class="btn btn-danger mr-1">
                                    <i class="icon-trash"></i> Cancel
                                </a>
                                <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                    <i class="icon-note"></i> Save
                                </button>
                                <button type="button" onclick="$('#returnFlag').val('0'); $('#theForm').submit();" class="btn btn-info">
                                    <i class="icon-note"></i> Save & add another
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.date-own').datepicker({
        minViewMode: 2,
        format: 'yyyy'
    });
</script>

@endsection