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
								<h4 class="card-title">Drivers</h4>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 text-right">
							<div id="DataTables_Table_0_filter" class="dataTables_filter">
								<label><input type="search" class="form-control form-control-sm" placeholder="Search:" aria-controls="DataTables_Table_0"></label>
								<a href="{{ route('/drivers/create') }}" id="addRow" class="btn btn-info ml-2 mt-2"><i class="ft-plus"></i> Add Driver</a>
							</div>
						</div>

					</div>
					<div class="row"><div class="col-12">@include('layouts.errors')</div></div>
				</div>
			</div>
		</div>
	</div>