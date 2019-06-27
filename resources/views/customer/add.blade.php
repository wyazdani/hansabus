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
                                <h4 class="card-title">
                                    {{ (!empty($customer->id))?__('customer.heading.edit'):__('customer.heading.add') }}</h4>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 text-right">
                            <div class="dataTables_filter"><a href="{{ route('customers.index') }}" class="btn btn-info ml-2 mt-2">{{__('customer.heading.index')}}
                                    <i class="ft-arrow-right mt-3"></i></a>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-content mt-1">

                    @if(!empty($customer->id))
                        <form class="form" method="POST" action="{{ route('customers.update',$customer->id) }}"
                              id="theForm">
                            @method('PUT')
                            <input type="hidden" id="id" name="id" value="{{ $customer->id }}">
                            @else
                                <form class="form" method="POST" action="{{ route('customers.store') }}" id="theForm">
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
                                                                        <label for="projectinput1">{{__('customer.name')}}</label>

                                                                        <input type="text" name="name" class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($customer->name))?$customer->name:old('name') }}" >
                                                                        @if ($errors->has('name'))
                                                                            <div class="error">{{ $errors->first('name') }}</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput2">{{__('customer.email')}}</label>
                                                                        <input type="email" name="email" class="{{($errors->has('email')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($customer->email))?$customer->email:old('email') }}"
                                                                        @if(!empty($customer->id)) {{ 'readonly="readonly"'  }} @endif >
                                                                        @if ($errors->has('email'))
                                                                            <div class="error">{{ $errors->first('email') }}</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput3">{{__('customer.web')}}</label>
                                                                        <input type="text" name="url" class="{{($errors->has('url')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($customer->url))?$customer->url:old('url') }}">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput4">{{__('customer.mobile')}}</label>
                                                                        <input type="text" name="phone" class="{{($errors->has('phone')) ?'form-control error_input':'form-control'}}" maxlength = "11"  value="{{ (!empty($customer->phone))?$customer->phone:old('phone') }}">
                                                                        @if ($errors->has('phone'))
                                                                            <div class="error">{{ $errors->first('phone') }}</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput4">{{__('customer.address')}}</label>
                                                                        <input type="text" name="address" class="{{($errors->has('address')) ?'form-control error_input':'form-control'}}" value="{{ (!empty($customer->address))?$customer->address:old('address') }}">
                                                                        @if ($errors->has('address'))
                                                                            <div class="error">{{ $errors->first('address') }}</div>
                                                                        @endif
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
                                                <label>{{__('customer.is_active')}}</label>
                                                <div class="form-group">
                                                    <div class="display-inline-block">
                                                        <label class="switch">
                                                            <input type="checkbox" name="status"
                                                            @if(!empty(old('status')) && old('status'))
                                                                {{ 'checked' }}
                                                                    @elseif(!empty($customer->status) && $customer->status)
                                                                {{ 'checked' }}
                                                                    @elseif(empty($customer->status))
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

                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-actions">
                                                @if(!empty($customer->id))
                                                    <a href="{{ url('/customers') }}" class="btn btn-danger mr-1">
                                                        <i class="fa fa-times"></i> {{__('messages.cancel')}}
                                                    </a>
                                                    <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                                        <i class="icon-note"></i> {{__('messages.update')}}
                                                    </button>
                                                @else
                                                <a href="{{ url('/customers') }}" class="btn btn-danger mr-1">
                                                    <i class="fa fa-times"></i> {{__('messages.cancel')}}
                                                </a>
                                                <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                                    <i class="icon-note"></i> {{__('messages.save')}}
                                                </button>
                                                <button type="button" onclick="$('#returnFlag').val('0'); $('#theForm').submit();" class="btn btn-info">
                                                    <i class="icon-note"></i> {{__('messages.save_add_another')}}
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </form>
                </div>
            </div>
        </div>
    </div>

@endsection