

<form class="form" method="POST" action="" id="customerAddForm">
    <div class="row">
        <div class="col-md-12">
            <div class="px-3">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="projectinput1">{{__('customer.name')}} <span class="{{($errors->has('name')) ?'errorStar':''}}">*</span></label>
                                <input value="{!! $offer->name !!}" type="text" name="name" class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}"  >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="projectinput2">{{__('customer.email')}} <span class="{{($errors->has('email')) ?'errorStar':''}}">*</span></label>
                                <input value="{!! $offer->email !!}" type="email" name="email" class="{{($errors->has('email')) ?'form-control error_input':'form-control'}}" >

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
                                <label for="projectinput4">{{__('customer.mobile')}} <span class="{{($errors->has('phone')) ?'errorStar':''}}"></span></label>
                                <input type="text" name="phone" class="{{($errors->has('phone')) ?'form-control error_input has_numeric':'form-control has_numeric'}}" maxlength = "11" >
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-left">
        <div class="form-actions">
            <button type="button" onclick="_addCustomer();" class="btn btn-success btn_submit">
                <i class="icon-note"></i> {{__('messages.save')}}
            </button>
        </div>
    </div>
</form>