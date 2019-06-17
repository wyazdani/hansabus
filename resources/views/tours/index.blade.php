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
								<h4 class="card-title">Tours List</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter">
								<a  href="{{ route('tours.create') }}" class="btn btn-info ml-2 mt-2">Add New Tour
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>
				<div class="row ">
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
				<div class="card-content mt-1">
					<div class="table-responsive">
						<table class="table table-hover table-xl mb-0" id="recent-orders">
							<thead>
							<tr>
								<th class="border-top-0">ID</th>
								<th class="border-top-0">Trip Name</th>
								<th class="border-top-0">Vehicle</th>
								<th class="border-top-0">Driver</th>
								<th class="border-top-0">Destination</th>
								<th class="border-top-0">Time & Date</th>
								<th class="border-top-0">Price</th>
								<th class="border-top-0">Action</th>
							</tr>
							</thead>
							<tbody>
							@foreach($tours as $tour)

								<tr>
									<td>{!! !empty($tour->id)?$tour->id:'' !!}</td>
									<td>{!! !empty($tour->tour_name)?$tour->tour_name:'' !!}</td>
									<td>{!! !empty($tour->vehicle_id)?$tour->vehicle_id:'' !!}</td>
									<td>{!! !empty($tour->driver_id)?$tour->driver_id:'' !!}</td>
									<td>{!! !empty($tour->destination)?$tour->destination:'' !!}</td>
									<td>{!! !empty($tour->departure_date)?$tour->departure_date:'' !!}</td>
									<td>$ {!! !empty($tour->price)?$tour->price:'' !!}</td>
									<td>
										<a href="{{ route('tours.edit',$tour->id)}}" class="success p-0">
											<i class="icon-pencil font-medium-1 mr-1"></i>
										</a>

										{{--<a
												class="icon-eye font-medium-1 mr-1"
												onclick="viewTour('{{ $tour->id }}')"
												type="button" data-toggle="modal"
										>View</a>--}}

										<a href="{{ route('tours.destroy',$tour->id)}}" class="danger p-0">
											<i class="icon-trash font-medium-1 mr-1"></i>
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
	@include('tours.view')
@endsection
@section('pagejs')
	<script>
        function viewTour(id){

            $.ajax({
                url: "tour",
                cache: false,
                success: function(html){
                    $("#results").append(html);
                }
            });

        }
	</script>
@endsection
