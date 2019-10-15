@extends('layouts.app')

@section('content')
<!--Login Page Starts-->
<section id="login">
    <div class="container-fluid">
        <div class="row full-height-vh">
            <div class="col-12 d-flex align-items-center justify-content-center gradient-aqua-marine">
                <div class="card px-4 py-2 box-shadow-2 width-400">
                    <div class="card-header text-center">
                        <img src="{{ asset('images/hansa_logo_colored.png') }}" alt="company-logo" class="mb-3" width="300">
                        <h4 class="text-uppercase text-bold-400 grey darken-1">{{ __('Login') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-block">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf


                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="email" name="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email Address" required email>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="password" required>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{--<div class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0 ml-5">
                                                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label float-left" for="rememberme">{{ __('Remember Me') }}</label>
                                            </div>--}}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="text-center col-md-12">
                                        <button type="submit" class="btn btn-danger px-4 py-2 text-uppercase white font-small-4 box-shadow-2 border-0">{{ __('Login') }}</button>
                                    </div>
                                </div>


                                
                            </form>
                        </div>
                    </div>
                    <div class="card-footer grey darken-1">
                    @if (Route::has('password.request'))
                        <div class="text-center mb-1">Forgot Password? <a><b>Reset</b></a></div>
                        @endif
                        <!-- <div class="text-center">Don't have an account? <a><b>Signup</b></a></div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Login Page Ends-->

@endsection