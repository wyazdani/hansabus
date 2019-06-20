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
								<h4 class="card-title">Tours</h4>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 text-right">
							<div id="DataTables_Table_0_filter" class="dataTables_filter">
								<a href="{{ url('/tours/create') }}" id="addRow" class="btn btn-info ml-2 mt-2"><i class="ft-plus"></i> Add Tour</a>
							</div>
						</div>

					</div>
					<div class="row"><div class="col-12">@include('layouts.errors')</div></div>
				</div>
				<div class="card-content mt-1">
					<div class="card-body">
						<div class="px-3 mb-4">

							<div class="table-responsive">
								<table class="table table-hover table-xl mb-0" id="listingTable">
									<thead>
									<tr>
										<th class="border-top-0" width="5%">ID</th>
										<th class="border-top-0" width="15%">Vehicle</th>
										<th class="border-top-0" width="8%">Passengers</th>
										<th class="border-top-0" width="15%">Driver</th>
										<th class="border-top-0" width="12%">From</th>
										<th class="border-top-0" width="12%">To</th>

										<th class="border-top-0" width="10%">Guide</th>
										<th class="border-top-0" width="8%">Price</th>
										<th class="border-top-0" width="10%">&nbsp;</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('pagejs')
	@include('tours.view')
	<script>
		var deleteMe = function(id){

			if(confirm('Are you sure you want to delete?')){

				$.ajax({
					url: '/tours/'+id,
					data: "_token={{ csrf_token() }}",
					type: 'DELETE',  // user.destroy
					success: function(result) {
						// console.log(result);
						$('#'+id).remove();
					}
				});
			}
		};
		var viewTour = function(id){

			$.ajax({
				url: "{{ url('/tours') }}/"+id,
				cache: false,
				success: function(t){

					$('#v_name').html(t.customer.name+': <small>'+t.from_date+' - '+t.to_date+'</small>');

					$('#v_driver').html(t.driver.driver_name);
					$('#v_vehicle').html(t.vehicle.name);

					$('#v_passengers').html(t.passengers);
					$('#v_guide').html(t.guide);
					$('#v_price').html(t.price);


						 if(t.status == 1) $('#v_status').html('Draft');
					else if(t.status == 2) $('#v_status').html('Confirmed');
					else if(t.status == 3) $('#v_status').html('Invoiced');
					else if(t.status == 4) $('#v_status').html('Paid');
					else if(t.status == 5) $('#v_status').html('Canceled');

					var attachments = '<ul>';
				$.each(t.attachments, function(index, item) {
						attachments += '<li><a href="/attachments/'+item.file+'" target="_blank">'+item.file+'</a></li>';
					});
					attachments += '</ul>';

					$('#v_attachments').html(attachments);

					$('#viewModel').modal('show');
				}
			});
		};
		$(document).ready(function() {


			var tableDiv = $('#listingTable').DataTable({

				"processing": true,
				"serverSide": true,
				// "searchable" : true,
				'searching':false,
				"pageLength": 10,
				"bLengthChange" : false,
				"aoColumnDefs": [{

					"aTargets": [8],
					"mData": "",
					"mRender": function (data, type, row) {

						var edit = '';  var trash = '';  var view = ''; var status=''; var buttons = '';

						// console.log(row.status);
						status  = '<a class="danger p-0" data-original-title="Change Status" title="Change Status" ';
						if(row.status == '1'){
							status  = '<a class="success p-0" data-original-title="Change Status" title="Change Status" ';
						}

						status += 'href="/tours/change-status/'+row.id+'">';
						status += '<i class="icon-power font-medium-3 mr-2"></i></a>';


						edit  = '<a class="info p-0" data-original-title="Edit" title="Edit" ';
						edit += 'href="/tours/'+row.id+'/edit">';
						edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';

						trash  = '<a class="danger p-0" data-original-title="Delete" title="Delete" ';
						trash += ' href="javascript:;" onclick="deleteMe('+row.id+')" >';
						trash += '<i class="icon-trash font-medium-3 mr-2"></i></a>';

						view  = '<a class="p-0" data-original-title="View" title="View" ';
						view += ' href="javascript:;" onclick="viewTour('+row.id+');" >';
						view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';

						buttons = edit+trash+view;
						return buttons;
						// return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
					}
				}],
				"ajax": "{{ url('/tours-list') }}",
				'rowId': 'id',
				"columns": [
					{ "data": "id" },
					{ "data": "vehicle.name" },
					{ "data": "passengers" },
					{ "data": "driver.driver_name" },
					{ "data": "from_date" },
					{ "data": "to_date" },

					{ "data": "guide" },
					{ "data": "price" }
					// { "data": "actions" }
				],
				drawCallback: deleteMe|viewTour,
				"fnDrawCallback": function(oSettings) {
					if ($('#listingTable tr').length < 11) {
						$('.dataTables_paginate').hide();
					}
				}
			});

			tableDiv.sPaging = 'btn btn-info ml-2 mt-2';

		} );

	</script>
@endsection