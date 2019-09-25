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
				<input type="hidden" id="tour_id_email" name="tour_id_email" value="{!! !empty($tour)?$tour->id:0 !!}">
				<input type="hidden" id="customer_id_email" name="customer_id_email" value="{!! !empty($tour)?$tour->customer_id:0 !!}">
				<input type="hidden" id="e_status" name="e_status" value="{!! !empty($tour)?$tour->status:0 !!}">
				<div class="col-md-6">
					<dl>
						<dt>{{__('tour.driver')}}:</dt>
						<dd id="v_driver_e">{!! !empty($tour->driver)?$tour->driver->driver_name:'None' !!}</dd>
						<dt>{{__('tour.passengers')}}:</dt>
						<dd id="v_passengers"> {!! !empty($tour->passengers)?$tour->passengers:0 !!}</dd>

						<dt>{{__('tour.vehicle')}}:</dt>
						<dd id="v_vehicle_e">{!! !empty($tour->vehicle)?$tour->vehicle->name:'None' !!}</dd>
						<dt>{{__('tour.guide')}}:</dt>
						<dd id="v_guide_e">{!! !empty($tour->guide)?$tour->guide:'None' !!}</dd>
						<dt>{{__('tour.price')}}:</dt>
						<dd id="v_price_e">{!! !empty($tour->price)?$tour->price:0 !!}</dd>
						<dt>Status:</dt>
						<dd id="v_status_e">@if($tour->status==1) Draft
							@elseif($tour->status==2)
								Confirmed
							@elseif($tour->status==3)
								Invoiced
							@elseif($tour->status==4)
								Paid
							@elseif($tour->status==5)
								Canceled
							@else
								None
							@endif
						</dd>
					</dl>
				</div>
				<div class="col-md-12">
					<h4>{{__('tour.description')}} :</h4>
					<p>{!! !empty($tour->description)?$tour->description:'' !!}</p>
				</div>

				<div class="col-md-12" id="v_description_e">
				</div>
				<div class="col-md-12" id="v_attachments_e">
					<h4>Attachments :</h4>
					<ul>
						@foreach($tour->attachments as $attachment)
							@if(pathinfo($attachment->path, PATHINFO_EXTENSION) == 'doc' || pathinfo($attachment->path, PATHINFO_EXTENSION) == 'txt' || pathinfo($attachment->path, PATHINFO_EXTENSION) == 'pdf')
								<li><a href="{{ url('/attachments/'.$attachment->file) }}" target="_blank"><i class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i></a></li>
							@else
								<li><img src="{{ url('/attachments/'.$attachment->file) }}" style="display:block; width: 100%; height:auto;"></li>
							@endif
						@endforeach

					</ul>
				</div>
				{{--<div class="col-md-12 generate_invoice" >
					<a href="javascript:void(0)" class="btn btn-success ml-2 mt-2 generate_invoice_click">{{__("messages.generate_invoice")}}</a>
				</div>--}}
				<div class="form-group" >
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
		{{--<form class="form" method="POST" action="{{ route('generate-tour-invoice') }}" id="theForm">
			@csrf
			<input type="hidden" id="e_customer_id" name="customer_id">
			<input type="hidden" name="total" id="total" value="1">
			<input type="hidden" name="ids[]" id="e_ids">
		</form>--}}
<script type="text/javascript">
	function generateSingleInvoice(id){
		$.ajax({
			url: '{{ url('/tours') }}/'+id,
			type: 'GET',  // user.destroy
			success: function(r) {

				console.log(r.customer_id);
				$('#e_customer_id').val(r.customer_id);
				$('#theForm').submit();
			}
		});
	}

	//
	$(document).ready(function () {
		$('body').on('click','.generate_invoice_click',function () {
			$('#theForm').submit();
		});

		var status = $("input[name=e_status]").val();

		/*if(status===3){
			$(".generate_invoice").hide();
		}else{
			$(".generate_invoice_show").hide();
		}*/
	});

</script>