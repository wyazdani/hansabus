<div class="modal fade text-left"  id="addCustomerPopup" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">{{ __('customer.heading.add') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ft-x blue-grey darken-4"></i>
                </button>
            </div>
            <form class="form" method="POST" action="" id="customerAddForm">
                <div class="row">
                    <div class="col-md-12">
                    <div class="px-3">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="projectinput1">{{__('customer.name')}} <span class="{{($errors->has('name')) ?'errorStar':''}}">*</span></label>
                                        <input type="text" name="name" class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="projectinput2">{{__('customer.email')}} <span class="{{($errors->has('email')) ?'errorStar':''}}">*</span></label>
                                        <input type="email" name="email" class="{{($errors->has('email')) ?'form-control error_input':'form-control'}}" >

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="projectinput3">{{__('customer.web')}}</label>
                                        <input type="text" name="url" class="{{($errors->has('url')) ?'form-control error_input':'form-control'}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="projectinput4">{{__('customer.mobile')}} <span class="{{($errors->has('phone')) ?'errorStar':''}}">*</span></label>
                                        <input type="text" name="phone" class="{{($errors->has('phone')) ?'form-control error_input':'form-control'}}" maxlength = "11" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="projectinput4">{{__('customer.address')}} <span class="{{($errors->has('address')) ?'errorStar':''}}">*</span></label>
                                        <input type="text" name="address" class="{{($errors->has('address')) ?'form-control error_input':'form-control'}}" >
                                    </div>
                                </div>
                                <input type="hidden" name="status" value="true">
                                {{--<div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('customer.is_active')}}</label>
                                        <div class="form-group">
                                            <div class="display-inline-block">
                                                <label class="switch">
                                                    <input type="checkbox" name="status"
                                                    @if(!empty(old('status')) && old('status'))
                                                        {{ 'checked' }}
                                                            @endif >
                                                    <span class="slider round"></span>
                                                    <p>{{__('messages.yes/no')}}</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-12 text-left">
                    <div class="form-actions">
                        <button type="button" onclick="_addCustomer();" class="btn btn-success">
                            <i class="icon-note"></i> {{__('messages.save')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function _addCustomer(){

        $('#customerAddForm input').removeClass('error_input');
        // console.log('clicked');
        $.ajax({
            url: "{{ route('customers.store') }}",
            data: $('#customerAddForm').serialize()+"&_token={{ csrf_token() }}&key=popup",
            type: 'POST',
            cache: false,
            success: function(res){

                if(res.errors){

                    $.each(res.errors, function (key, val) {
                        // console.log(key+'=>'+val);
                        $( "input[name="+key+"]" ).addClass('error_input');
                    });
                }else{

                    // console.log(res.name+'=>'+res.id);

                    $( "#customer_search" ).val(res.name);
                    $( "#customer_id" ).val(res.id);
                    location.reload();
                    $('#addCustomerPopup').modal('hide');
                }
            },
            error: function (reject) {
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function (key, val) {
                        console.log(key+'=>'+val);
                        $( "input[name="+key+"]" ).addClass('error_input');
                    });
                }
            }
        });
        return false;
    }
    function addCustomer(){

        $('#customerAddForm input').removeClass('error_input');
        $('#addCustomerPopup').modal('show');
    }
</script>