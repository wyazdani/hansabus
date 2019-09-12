<div class="modal fade text-left" tabindex="-1" id="default_model"
	 role="dialog" aria-labelledby="myModalLabel17"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<form method="post" action="{!! route('tour-customer-email') !!}">
			@csrf
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="v_name_e"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i class="ft-x blue-grey darken-4"></i>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="tour_id_email" name="tour_id_email">
				<input type="hidden" id="customer_id_email" name="customer_id_email">
				<div class="col-md-6">
					<dl>
						<dt>{{__('tour.driver')}}:</dt>
						<dd id="v_driver_e"></dd>
						<dt>{{__('tour.passengers')}}:</dt>
						<dd id="v_passengers"></dd>

						<dt>{{__('tour.vehicle')}}:</dt>
						<dd id="v_vehicle_e"></dd>
						<dt>{{__('tour.guide')}}:</dt>
						<dd id="v_guide_e"></dd>
						<dt>{{__('tour.price')}}:</dt>
						<dd id="v_price_e"></dd>
						<dt>Status:</dt>
						<dd id="v_status_e"></dd>
					</dl>
				</div>
				<div class="col-md-6">
				</div>
				<div class="col-md-12" id="v_attachments_e">
				</div>
				<div class="form-group">
					<label>{{__('tour.send_invoice')}}</label>
					<div class="form-group">
						<div class="display-inline-block">
							<label class="switch">
								<input type="checkbox" name="send_invoice">
								<span class="slider round"></span>
								<p>{{__('messages.no/yes')}}</p>
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-labeled btn-xxs btn-success"> Send Mail</button>
			</div>
		</div>
		</form>
	</div>
</div>
