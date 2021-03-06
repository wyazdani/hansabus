<!-- Modal -->
<div class="modal fade text-left" tabindex="-1" id="viewModel"
     role="dialog" aria-labelledby="myModalLabel17"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="v_name"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ft-x blue-grey darken-4"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12">
                    <dl>
                        <dt style="width:25%">Email:</dt>
                        <dd id="v_email"></dd>

                        <dt style="width:25%">{{__('customer.mobile')}}:</dt>
                        <dd id="v_phone"></dd>

                        <dt style="width:25%">{{__('customer.address')}}:</dt>
                        <dd id="v_address"></dd>

                        <dt style="width:25%">{{__('customer.web')}}:</dt>
                        <dd id="v_url"></dd>

                        <dt style="width:25%">{{__('customer.is_active')}}:</dt>
                        <dd id="v_status"></dd>

                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>