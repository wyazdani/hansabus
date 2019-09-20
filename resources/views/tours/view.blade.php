<div class="modal fade text-left" tabindex="-1" id="viewModel"
	 role="dialog" aria-labelledby="myModalLabel17"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<form method="post" action="{!! route('tour-driver-form') !!}">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="v_name"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="ft-x blue-grey darken-4"></i>
					</button>
				</div>
				<div class="modal-body row">
					<input type="hidden" value="" id="v_tour_id" name="tour_id">
					<input type="hidden" value="" id="v_driver_id" name="driver_id">
					<div class="col-md-6">
						<dl>
							<dt>{{__('tour.driver')}}:</dt>
							<dd id="v_driver"></dd>
							<dt>{{__('tour.passengers')}}:</dt>
							<dd id="v_passengers"></dd>

							<dt>{{__('tour.vehicle')}}:</dt>
							<dd id="v_vehicle"></dd>
							<dt>{{__('tour.guide')}}:</dt>
							<dd id="v_guide"></dd>
							<dt>{{__('tour.price')}}:</dt>
							<dd id="v_price"></dd>
							<dt>Status:</dt>
							<dd id="v_status"></dd>
						</dl>
					</div>
					<div class="col-md-6">
						{{--<span> Want to share this info with customer</span>
						<label>Enter Customer Email</label>
						<input type="email" class="form form-control">
						<button class="btn btn-light-blue" onclick="function f() {

								}">Send Email</button>--}}
					</div>
					<div class="col-md-12">
						<h4>{{__('tour.description')}} :</h4>
					</div>
					<div class="col-md-12" id="v_description">
					</div>
					<div class="col-md-12" id="v_attachments">
					</div>
					<div class="col-md-12">
						<label>{{__('tour.driver_details')}} :</label>
						<textarea name="details" class="form-control"></textarea>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-labeled btn-xxs btn-success">{{__('tour.driver')}} Form</button>
				</div>

			</div>
		</form>
	</div>
</div>