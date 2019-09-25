<div class="modal fade text-left"  id="addDriverPopup" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">{{ __('driver.heading.add') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ft-x blue-grey darken-4"></i>
                </button>
            </div>
            <form class="form" method="POST" action="" id="driverAddForm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="px-3">
                            <div class="form-body">


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">{{__('driver.name') }} *</label>
                                            <input type="text" name="driver_name"
                                                   class="{{($errors->has('driver_name')) ?'form-control error_input':'form-control'}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput2">{{__('driver.mobile') }} *</label>
                                            <input type="text" name="mobile_number"
                                                   class="{{($errors->has('mobile_number')) ?'form-control error_input has_numeric':'form-control has_numeric'}}" maxlength="11">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput3">{{__('driver.license') }} *</label>
                                            <input type="text" name="driver_license"
                                                   class="{{($errors->has('driver_license')) ?'form-control error_input':'form-control'}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput4">{{__('driver.nin') }} *</label>
                                            <input type="text" name="nic"
                                                   class="{{($errors->has('nic')) ?'form-control error_input has_numeric':'form-control has_numeric'}}" maxlength="15">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label
                                                    for="projectinput3">{{__('driver.address') }} *</label>
                                            <input type="text" name="address"
                                                   class="{{($errors->has('address')) ?'form-control error_input':'form-control'}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput4">{{__('driver.phone') }} *</label>
                                            <input type="text"  name="phone"
                                                   class="{{($errors->has('phone')) ?'form-control error_input has_numeric':'form-control has_numeric'}}" maxlength="11">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="projectinput8">{{__('driver.other_details') }}</label>
                                    <textarea rows="5" name="other_details"
                                              class="{{($errors->has('other_details')) ?'form-control error_input':'form-control'}}"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-left">
                    <div class="form-actions">
                        <button type="button" onclick="_addDriver();"  class="btn btn-success btn_click">
                            <i class="icon-note"></i> {{__('messages.save')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    /*$(".btn_click").one('click', function() {
        $('#driverAddForm input').removeClass('error_input');
        $.ajax({
            url: "{{ route('v-drivers.store') }}",
            data: $('#driverAddForm').serialize()+"&_token={{ csrf_token() }}&key=popup",
            type: 'POST',
            cache: false,
            success: function(res){

                if(res.errors){

                    $.each(res.errors, function (key, val) {
                        // console.log(key+'=>'+val);
                        $( "input[name="+key+"]" ).addClass('error_input');
                    });
                    $("#btn_click").unbind('click');
                }else{

                    console.log(res.name+'=>'+res.id);

                    $( "#driver_search" ).val(res.driver_name);
                    $( "#driver_id" ).val(res.id);
                    $('#driverAddForm')[0].reset();
                    $('#addDriverPopup').modal('hide');
                    var newOption = new Option(res.driver_name, res.id);
                    $('#driver_id').append(newOption);
                    $('#driver_id').val(res.id).trigger('change');
                    $("#btn_click").unbind('click');
                    $('.selectpicker').selectpicker('refresh');

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
    });*/
    function _addDriver(){
        $(".btn_click").attr("disabled", true);
        $('#driverAddForm input').removeClass('error_input');
        $.ajax({
            url: "{{ route('v-drivers.store') }}",
            data: $('#driverAddForm').serialize()+"&_token={{ csrf_token() }}&key=popup",
            type: 'POST',
            cache: false,
            success: function(res){

                if(res.errors){
                    alert('here');
                    $(".btn_click").attr("disabled", false);
                    $.each(res.errors, function (key, val) {
                        // console.log(key+'=>'+val);
                        $( "input[name="+key+"]" ).addClass('error_input');
                    });

                }else{

                    console.log(res.name+'=>'+res.id);

                    $( "#driver_search" ).val(res.driver_name);
                    $( "#driver_id" ).val(res.id);
                    $('#addDriverPopup').modal('hide');
                    var newOption = new Option(res.driver_name, res.id);
                    $('#driver_id').append(newOption);
                    $('#driver_id').val(res.id).trigger('change');
                    $('#driverAddForm')[0].reset();
                    $('.selectpicker').selectpicker('refresh');
                    $(".btn_click").attr("disabled", false);

                }
            },
            error: function (reject) {
                $(".btn_click").attr("disabled", false);
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
    function addDriver(){

        $('#driverAddForm input').removeClass('error_input');
        $('#addDriverPopup').modal('show');
    }
</script>