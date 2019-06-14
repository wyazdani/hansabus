@extends('layouts.app')
@section('page_title') {{ $pageTitle }} @endsection
@section('content')
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title">Vehicle Type Details</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter">
								<a  href="{{ route('vehicle-type.create') }}" class="btn btn-info ml-2 mt-2">Add New Type
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						@if(session()->get('success'))
							<div class="btn btn-info ml-2 mt-2">
								{{ session()->get('success') }}
							</div><br />
						@endif
					</div>
					<div class="col-md-4"></div>
				</div>
				{{--<div class="row"><div class="col-12">@include('layouts.errors')</div></div>--}}
				<div class="card-content mt-1">
					<div class="table-responsive">
						<table class="table table-hover table-xl mb-0" id="recent-orders">
							<thead>
							<tr>
								<th class="border-top-0">ID</th>
								<th class="border-top-0">Name</th>
								<th class="border-top-0">Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach($vehicle_type as $type)
								<tr>
									<td>{!! $type->id?$type->id:'' !!}</td>
									<td>{!! $type->name?$type->name:'' !!}</td>
									<td>
										<a href="{{ route('vehicle-type.edit',$type->id)}}" class="success p-0">
											<i class="icon-pencil font-medium-3 mr-2"></i>
										</a>

										<a href="{{ route('vehicle-type.destroy',$type->id)}}" class="danger p-0">
											<i class="icon-trash font-medium-3 mr-2"></i>
										</a>

								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
