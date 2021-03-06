<!-- Modal -->
<div class="modal fade text-left" tabindex="-1" id="viewModel"
     role="dialog" aria-labelledby="myModalLabel17"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="v_driver_name"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ft-x blue-grey darken-4"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12">
                    <dl>
                        <dt style="width:25%">{{__('driver.mobile')}}.:</dt>
                        <dd id="v_mobile_number"></dd>

                        <dt style="width:25%">{{__('driver.license')}}:</dt>
                        <dd id="v_driver_license"></dd>

                        <dt style="width:25%">NIN No.</dt>
                        <dd id="v_nic"></dd>

                        <dt style="width:25%">{{__('driver.address')}}:</dt>
                        <dd id="v_address"></dd>


                        <dt style="width:25%">{{__('driver.phone')}}:</dt>
                        <dd id="v_phone"></dd>

                        <dt style="width:25%">{{__('driver.other_details')}}:</dt>
                        <dd id="v_other_details"></dd>



                        <dt style="width:25%">{{__('driver.is_active')}}:</dt>
                        <dd id="v_status"></dd>

                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>