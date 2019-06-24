<!-- Modal -->
<div class="modal fade text-left" tabindex="-1" id="viewModel"
     role="dialog" aria-labelledby="myModalLabel17"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="v_name">Honda-City Turbo 1.5 <span class="label label-success">Available</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ft-x blue-grey darken-4"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <dl>
                        <dt>{{__('messages.make_model')}}</dt>
                        <dd id="v_make"></dd>

                        <dt>{{__('messages.year_of_manufacture')}}</dt>
                        <dd id="v_year"></dd>

                        <dt>{{__('messages.color')}}:</dt>
                        <dd id="v_color"></dd>


                        <dt>{{__('messages.type_of_vehicle')}}:</dt>
                        <dd id="v_vehicle_type"></dd>
                        <dt>{{__('messages.license_plate')}}:</dt>
                        <dd id="v_licensePlate"></dd>
                        <dt>{{__('messages.vehicle_reg_number')}}:</dt>
                        <dd id="v_registrationNumber"></dd>

                        <dt>{{__('messages.engine_number')}}:</dt>
                        <dd id="v_engineNumber"></dd>
                        <dt>{{__('messages.number_of_seats')}}:</dt>
                        <dd id="v_seats"></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl>
                        <dt>{{__('messages.transmission')}}:</dt>
                        <dd id="v_transmission"></dd>

                        <dt>AC:</dt>
                        <dd id="v_AC"></dd>
                        <dt>Radio:</dt>
                        <dd id="v_radio"></dd>
                        <dt>{{__('messages.sunroof')}}:</dt>
                        <dd id="v_sunroof"></dd>
                        <dt>{{__('messages.Phone_Charging_Jack')}}:</dt>
                        <dd id="v_phoneCharging">{{__('messages.yes')}}</dd>

                        <dt>{{__('messages.is_active')}}:</dt>
                        <dd id="v_status"></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>