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
								<h4 class="card-title">{{__('vehicle_type.heading.index')}}</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter">
								<a href="{{ route('vehicle-type.create') }}" id="addRow" class="btn btn-info ml-2 mt-2">{{__('vehicle_type.heading.add')}}</a>
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
										<th class="border-top-0" width="10%">ID</th>
										<th class="border-top-0" width="80%">{{__('vehicle_type.name')}}</th>
										<th class="border-top-0" width="10%">{{__('tour.action')}}</th>
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
	<script>
		var deleteMe = function(id){

			if(confirm('{{__("messages.want_to_delete")}}')){

				$.ajax({
					url: 'vehicle-type/'+id,
					data: "_token={{ csrf_token() }}",
					type: 'DELETE',  // user.destroy
					success: function(result) {
						// console.log(result);
						$('#'+id).remove();
					}
				});
			}
		};

		$(document).ready(function() {


			var tableDiv = $('#listingTable').DataTable({

				"bInfo": false,
				"processing": true,
				"serverSide": true,
				"searchable": true,
				"language": {
					"search": "{{__('messages.search')}}",
					"emptyTable": "{{__('messages.no_record')}}"
				},
				"pageLength": 10,
				"bLengthChange" : false,
				"aoColumnDefs": [{

					"aTargets": [2],
					"mData": "",
					"mRender": function (data, type, row) {

						var edit = '';  var trash = '';  var view = ''; var status=''; var buttons = '';

						status  = '<a class="danger p-0" data-original-title="Change Status" title="Change Status" ';
						if(row.status == '1'){
							status  = '<a class="success p-0" data-original-title="Change Status" title="Change Status" ';
						}

						status += 'href="{!! url("/vehicle-type/change-status/'+row.id+'") !!}">';
						status += '<i class="icon-power font-medium-3 mr-2"></i></a>';


						edit  = '<a class="info p-0" data-original-title="Edit" title="Edit" ';
						edit += 'href="vehicle-type/'+row.id+'/edit">';
						edit += '<i class="icon-pencil font-medium-3 mr-2"></i></a>';

						trash  = '<a class="danger p-0" data-original-title="Delete" title="Delete" ';
						trash += ' href="javascript:;" onclick="deleteMe('+row.id+')" >';
						trash += '<i class="icon-trash font-medium-3 mr-2"></i></a>';

						buttons = status+edit;
						return buttons;
						// return '<a href="#" onclick="alert(\''+ full[0] +'\');">Edit</a>';
					}
				}],
				"ajax": "{{ url('/vehicle-type-list') }}",
				'rowId': 'id',
				"columns": [
					{ "data": "id" },
					{ "data": "name" }
					// { "data": "actions" }
				],
				// drawCallback: deleteMe,
				"fnDrawCallback": function(oSettings) {
					if ($('#listingTable tr').length < 11) {
						// $('.dataTables_paginate').hide();
					}
				},
				'bSortable': true,
				'bProcessing': true,
				"order": [[ 0, "desc" ]],

			});
			tableDiv.sPaging = 'btn btn-info ml-2 mt-2';
		} );
	</script>
@endsection