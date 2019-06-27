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
								<h4 class="card-title">{{__('driver.heading.index')}}</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter">
								<a href="{{ route('v-drivers.create') }}" id="addRow" class="btn btn-info ml-2 mt-2"><i class="ft-plus"></i>{{__('driver.heading.add')}}</a>
							</div>
						</div>
					</div>
					<div class="row"><div class="col-12">@include('layouts.errors')</div></div>
				</div>

				<div class="card-content mt-1">

					<div class="card-body">
						<div class="px-3 mb-4">
							<div class="table-responsive">
								<table class=" table table-hover datatable-basic table-xl mb-0" id="listingTable">
									<thead>
										<tr>
											<th class="border-top-0" width="5%">ID</th>
											<th class="border-top-0" width="20%">Name</th>
											<th class="border-top-0" width="15%">{{__('driver.mobile')}}</th>
											<th class="border-top-0" width="15%">{{__('driver.license')}}</th>
											<th class="border-top-0" width="10%">{{__('driver.nin')}}</th>
											<th class="border-top-0" width="10%">{{__('driver.phone')}}</th>
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
	@include('drivers.view')
	<script>
		var deleteMe = function(id){

			if(confirm('{{__("messages.want_to_delete")}}')){

				$.ajax({
					url: '/v-drivers/'+id,
					data: "_token={{ csrf_token() }}",
					type: 'DELETE',  // user.destroy
					success: function(result) {
						// console.log(result);
						$('#'+id).remove();
					}
				});
			}
		};
		var viewDriver = function(id){

			$.ajax({
				url: "{{ route('v-drivers.index') }}/"+id,
				cache: false,
				success: function(d){

					$('#v_driver_name').html(d.driver_name);
					$('#v_mobile_number').html(d.mobile_number);
					$('#v_driver_license').html(d.driver_license);
					$('#v_nic').html(d.nic);
					$('#v_address').html(d.address);
					$('#v_phone').html(d.phone);
					$('#v_other_details').html(d.other_details);


					if(d.status == 1) $('#v_status').html('Yes'); else $('#v_status').html('No');

					$('#viewModel').modal('show');
				}
			});
		};
		$(document).ready(function() {


			var tableDiv = $('#listingTable').DataTable({

				"processing": true,
				"serverSide": true,
				"searchable" : true,
				"pageLength": 10,
				"bLengthChange" : false,
				"aoColumnDefs": [{

					"aTargets": [6],
					"mData": "",
					"mRender": function (data, type, row) {

						var edit = '';  var trash = '';  var view = ''; var status=''; var buttons = '';

						// console.log(row.status);
						status  = '<a class="danger p-0" data-original-title="Change Status" title="Change Status" ';
						if(row.status == '1'){
							status  = '<a class="success p-0" data-original-title="Change Status" title="Change Status" ';
						}

						status += 'href="v-drivers/change-status/'+row.id+'">';
						status += '<i class="icon-power font-medium-3 mr-2"></i></a>';


						edit  = '<a class="info p-0" data-original-title="Edit" title="Edit" ';
						edit += 'href="v-drivers/'+row.id+'/edit">';
						edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';

						trash  = '<a class="danger p-0" data-original-title="Delete" title="Delete" ';
						trash += ' href="javascript:;" onclick="deleteMe('+row.id+')" >';
						trash += '<i class="icon-trash font-medium-3 mr-2"></i></a>';

						view  = '<a class="p-0" data-original-title="View" title="View" ';
						view += ' href="javascript:;" onclick="viewDriver('+row.id+');" >';
						view += '<i class="icon-eye font-medium-3 mr-2"></i></a>';

						buttons = status+edit+trash+view;
						return buttons;
						// return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
					}
				}],
				"ajax": "{{ route('drivers-list') }}",
				'rowId': 'id',
				"columns": [
					{ "data": "id" },
					{ "data": "driver_name" },
					{ "data": "mobile_number" },
					{ "data": "driver_license" },
					{ "data": "nic" },
					{ "data": "phone" },

					// { "data": "actions" }
				],
				drawCallback: deleteMe|viewDriver,
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