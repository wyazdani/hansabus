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
							<div class="dataTables_filter"><a href="{{ route('tours.index') }}" class="btn btn-info ml-2 mt-2">Tours List
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
							<div class="dataTables_filter"><a href="{{ route('tour-calendar') }}" class="btn btn-info ml-2 mt-2">Calendar
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-content mt-1">
					<div class="modal-body row">
						<div class="col-md-6">
							<dl>
								<dt>Status:</dt>
								<dd>{{ ($Tour->status)?'Yes':'No' }}</dd>
								<dt>Customer:</dt>
								<dd>{{ $Tour->customer->name }}</dd>
								<dt>Vehicle:</dt>
								<dd>{{ $Tour->vehicle->name }}</dd>
								<dt>Driver:</dt>
								<dd>{{ $Tour->driver->driver_name }}</dd>
								<dt>Passengers:</dt>
								<dd>{{ $Tour->passengers }}</dd>
							</dl>
						</div>
						<div class="col-md-6">
							<dl>
								<dt>From:</dt>
								<dd>{{ date('m/d/Y h:i A',strtotime($Tour->from_date)) }}</dd>
								<dt>To:</dt>
								<dd>{{ date('m/d/Y h:i A',strtotime($Tour->to_date)) }}</dd>

								<dt>Guide:</dt>
								<dd>{{ $Tour->guide }}</dd>

								<dt>Price:</dt>
								<dd>{{ $Tour->price }}</dd>
							</dl>
						</div>
					</div>
					@if(!empty($Tour->attachments))
						<div class="col-sm-12"><h5>Attachments:</h5></div>
						<div class="row">
							<div class="col-lg-12">
								<ul class="upload-list">
									@foreach($Tour->attachments as $attachment)
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
								@foreach($Tour->attachments as $attachment)
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