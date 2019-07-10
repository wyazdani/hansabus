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
                                    {{ (!empty($service->id))?__('service.heading.edit'):__('service.heading.add') }}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-right">
                            <div class="dataTables_filter"><a href="{{ route('bus-services.index') }}" class="btn btn-info ml-2 mt-2">{{__('service.heading.index')}}
                                    <i class="ft-arrow-right mt-3"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-content mt-1">

                    @if(!empty($service->id))
                        <form class="form" method="POST" action="{{ route('bus-services.update',$service->id) }}"
                              id="theForm">
                            @method('PUT')
                            <input type="hidden" id="id" name="id" value="{{ $service->id }}">
                            @else
                                <form class="form" method="POST" action="{{ route('bus-services.store') }}" id="theForm">
                                    @endif

                                    @csrf
                                    <input type="hidden" id="returnFlag" name="returnFlag" value="">

                                    <div class="row">

                                        <div class="col-md-10">
                                            <div class="card">

                                                <div class="card-body">
                                                    <div class="px-3">

                                                        <div class="form-body servicesDiv">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput3">{{__('service.customer')}}</label>
                                                                        <input type="text" name="customer"
                                                                               class="{{($errors->has('customer')) ?' error_input':'form-control'}}"
                                                                               value="{{ $customer }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if(!empty($details))
                                                                @foreach($details as $detail)
                                                                    <div class="row">
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <label for="projectinput1">{{__('service.title')}}</label>
                                                                                <input type="text" name="title[]" value="{{$detail->title}}" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                <label for="projectinput2">{{__('service.price')}}</label>
                                                                                <input type="number" name="price[]"  value="{{$detail->price}}" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">{{__('service.title')}}</label>
                                                                            <input type="text" name="title[]" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="projectinput2">{{__('service.price')}}</label>
                                                                            <input type="number" name="price[]" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right mt-0 pr-5"><a href="javascript:;" onclick="addRow()">[add row]</a> </div>
                                    </div>

                                    <div class="col-md-12 text-left">
                                        <div class="form-actions">
                                            <a href="{{ route('bus-services.index') }}" class="btn btn-danger mr-1">
                                                <i class="fa fa-times"></i> {{__('messages.cancel')}}
                                            </a>
                                            @if(!empty($service->id))
                                                <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                                    <i class="icon-note"></i> {{__('messages.update')}}
                                                </button>
                                            @else
                                                <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                                    <i class="icon-note"></i> {{__('messages.save')}}
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagejs')
    <script>
        function generateInvoice(){

            $.ajax({
                @if(!empty($service->id))
                url: "{{ route('bus-services.update',$service->id) }}",
                @else
                url: "{{ route('bus-services.store') }}",
                @endif
                data: "_token={{ csrf_token() }}",
                type: 'POST',  // user.destroy
                success: function(invoice) {


                    /*var win = window.open('http://stackoverflow.com/', '_blank');
                    if (win) {
                        //Browser has allowed it to be opened
                        win.focus();
                    } else {

                    }*/

                }
            });
        }
        function addRow(){
            const row = '<div class="row">\n' +
                '<div class="col-md-10">\n' +
                '    <div class="form-group">\n' +
                '        <label for="projectinput1">{{__("service.title")}}</label>\n' +
                '        <input type="text" name="title[]" class="form-control">\n' +
                '    </div>\n' +
                '</div>\n' +
                '<div class="col-md-2">\n' +
                '    <div class="form-group">\n' +
                '        <label for="projectinput2">{{__("service.price")}}</label>\n' +
                '        <input type="number" name="price[]" class="form-control">\n' +
                '    </div>\n' +
                '</div>\n' +
                '</div>';
            $('.servicesDiv').append(row);
        }
    </script>
@endsection