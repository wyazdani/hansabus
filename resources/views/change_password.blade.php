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
                                <h4 class="card-title">{{__('messages.change_password') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content mt-1">

                        <form class="form" method="POST" action="{{ route('change-password') }}"
                              id="theForm">

                                    @csrf
                                    <input type="hidden" id="returnFlag" name="returnFlag" value="">

                                    <div class="uper">

                                        <div class="row">

                                            <div class="col-md-8">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <div class="px-3">

                                                            <div class="form-body">
                                                                <div class="row">

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">{{__('messages.new_password')}}
                                                                                <span class="{{($errors->has('password')) ?'errorStar':''}}">*</span>
                                                                            </label>

                                                                            <input type="password" name="password"
                                                                                   class="{{($errors->has('password')) ?'form-control error_input':'form-control'}}"
                                                                                   value="">
                                                                            @error('password')
                                                                            {{--<span class="text-danger" role="alert">
                    <strong>{{__('messages.password_dont_match')}}</strong>--}}
                                                                                <span class="text-danger">{!! $errors->first('password') !!}</span>
                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">{{__('messages.confirm_password')}}
                                                                                <span class="{{($errors->has('password_confirmation')) ?'errorStar':''}}">*</span>
                                                                            </label>

                                                                            <input type="password" name="password_confirmation"
                                                                                   class="{{($errors->has('password_confirmation')) ?'form-control error_input':'form-control'}}"
                                                                                   value="">
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
                                                <button  type="submit" class="btn btn-success">
                                                    <i class="icon-note"></i> {{__('messages.update')}}
                                                </button>
                                            </div>
                                        </div>

                                </form>
                </div>

            </div>
        </div>
    </div>
@endsection
