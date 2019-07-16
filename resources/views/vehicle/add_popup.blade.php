<div class="modal fade text-left"  id="addVehiclePopup" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">{{ __('vehicle.heading.add') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ft-x blue-grey darken-4"></i>
                </button>
            </div>
            <form class="form" method="POST" action="" id="vehicleAddForm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="px-3">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectinput1">{{__('vehicle.name')}} <span class="{{($errors->has('name')) ?'errorStar':''}}">*</span></label>
                                            <input type="text" name="name" class="{{($errors->has('name')) ?'form-control error_input':'form-control'}}"  >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-left">
                    <div class="form-actions">
                        <button type="button" onclick="_addVehicle();" class="btn btn-success">
                            <i class="icon-note"></i> {{__('messages.save')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function _addVehicle(){

        $('#vehicleAddForm input').removeClass('error_input');
        // console.log('clicked');
        $.ajax({
            url: "{{ route('customers.store') }}",
            data: $('#vehicleAddForm').serialize()+"&_token={{ csrf_token() }}&key=popup",
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

                    $( "#vehicle_search" ).val(res.name);
                    $( "#vehicle_id" ).val(res.id);
                    $('#addVehiclePopup').modal('hide');
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
    function addVehicle(){

        $('#vehicleAddForm input').removeClass('error_input');
        $('#addVehiclePopup').modal('show');
    }
</script>