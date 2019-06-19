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
								<h4 class="card-title">Drivers List</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter">
								<a  href="{{ route('drivers.create') }}" class="btn btn-info ml-2 mt-2">Add New Driver
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>
				<div class="row">

					@if(session()->get('success'))
						<div class="alert alert-success">
							{{ session()->get('success') }}
						</div><br />
					@endif
				</div>
				<div class="card-content mt-1">
					<div class="table-responsive">
						<table class=" table table-hover datatable-basic table-xl mb-0" id="recent-orders">
							<thead>
							<tr>
								<th class="border-top-0">ID</th>
								<th class="border-top-0">Name</th>
								<th class="border-top-0">License</th>
								<th class="border-top-0">NIC No.</th>
								<th class="border-top-0">Address</th>
								<th class="border-top-0">Phone</th>
								<th class="border-top-0">Mobile No</th>
								<th class="border-top-0">Other Details</th>
								<th class="border-top-0">Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach($drivers as $driver)
								<tr>
									<td>{!! !empty($driver->id)?$driver->id:'' !!}</td>
									<td>{!! !empty($driver->driver_name)?$driver->driver_name:'' !!}</td>
									<td>{!! !empty($driver->driver_license)?$driver->driver_license:'' !!}</td>
									<td>{!! !empty($driver->nic)?$driver->nic:'' !!}</td>
									<td>{!! !empty($driver->address)?$driver->address:'' !!}</td>
									<td>{!! !empty($driver->phone)?$driver->phone:'' !!}</td>
									<td>{!! !empty($driver->mobile_number)?$driver->mobile_number:'' !!}</td>
									<td>{!! !empty($driver->other_details)?$driver->other_details:'' !!}</td>
									<td>
										<a href="{{ route('drivers.edit',$driver->id)}}" class="success p-0">
											<i class="icon-pencil font-medium-3 mr-2"></i>
										</a>

										<a href="{{ route('drivers.destroy',$driver->id)}}" class="danger p-0">
											<i class="icon-trash font-medium-3 mr-2"></i>
										</a>

									</td>

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
