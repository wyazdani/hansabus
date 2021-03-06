@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-4 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title">{{ $pageTitle }}</h4>
							</div>
						</div>
						<div class="col-sm-4 col-md-6 text-right">
							<div class="dataTables_filter"><a href="{{ route('hire-drivers.index') }}" class="btn btn-info ml-2 mt-2">{{ __('messages.hire_drivers') }}
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
							<div class="dataTables_filter"><a href="{{ route('hire-driver-calendar') }}" class="btn btn-info ml-2 mt-2">{{ __('messages.drivers_calendar') }}
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-content mt-1">
					<div class="modal-body row">
						<div class="col-md-6">
							<dl>
								<dt width="30%">Status:</dt>
								<dd>{{ ($HireDriver->status)?'Yes':'No' }}</dd>
								<dt>{{ __('tour.customer') }}:</dt>
								<dd>{{ $HireDriver->customer->name }}</dd>
								<dt>{{ __('tour.driver') }}:</dt>
								<dd>{{ $HireDriver->driver->driver_name }}</dd>
							</dl>
						</div>
						<div class="col-md-6">
							<dl>
								<dt>{{ __('tour.from') }}:</dt>
								<dd>{{ date('d.m.Y H:i',strtotime($HireDriver->from_date)) }}</dd>
								<dt>{{ __('tour.to') }}:</dt>
								<dd>{{ date('d.m.Y H:i',strtotime($HireDriver->to_date)) }}</dd>

								<dt>{{ __('tour.price') }}:</dt>
								<dd>{{ $HireDriver->price }}</dd>
							</dl>
						</div>
					</div>
					@if(count($HireDriver->attachments))
						<div class="col-sm-12"><h5>{{ __('hire.attachments') }}:</h5></div>
						<div class="row">
							<div class="col-lg-12">
								<ul class="upload-list">
									@foreach($HireDriver->attachments as $attachment)
										@php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); @endphp
										@if(in_array($ext,['png','jpg','jpeg','gif']))
										<li>
											<a href="javascript:;" onclick="showImg('{{ url('/attachments/'.$attachment->file) }}')">
												<img src="{{ url('/attachments/'.$attachment->file) }}" border="0">
											</a>
										</li>
										@endif
									@endforeach
								</ul>
								@foreach($HireDriver->attachments as $attachment)
									@php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); @endphp
										@if(!in_array($ext,['png','jpg','jpeg','gif']))
											<div class="col-md-3"><a href="{{ url('/attachments/'.$attachment->file) }}" target="_blank">
												{{ $attachment->file }}
										</a></div>
										@endif
								@endforeach
							</div>
						</div>
					@endif
					<p>&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('pagejs')
	@include('tours.img_view')
	<script>
		function showImg(url){
			$('#imgDiv').html('<img src="'+url+'"  style="display: block;width: 100%;height: auto;">');
			$('#viewModel').modal('show');
		}
	</script>
@endsection