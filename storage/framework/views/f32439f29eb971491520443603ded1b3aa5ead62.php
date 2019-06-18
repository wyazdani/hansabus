<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
								<a  href="<?php echo e(route('tours.create')); ?>" class="btn btn-info ml-2 mt-2">Add New Tour
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>
				<div class="row ">
					<div class="col-md-4"></div>
					<div class="col-md-4">
					<?php if(session()->get('success')): ?>
						<div class="btn btn-info ml-2 mt-2">
						<?php echo e(session()->get('success')); ?>

						</div><br />
					<?php endif; ?>
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
							<?php $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

								<tr>
									<td><?php echo !empty($tour->id)?$tour->id:''; ?></td>
									<td><?php echo !empty($tour->tour_name)?$tour->tour_name:''; ?></td>
									<td><?php echo !empty($tour->vehicle_id)?$tour->vehicle_id:''; ?></td>
									<td><?php echo !empty($tour->driver_id)?$tour->driver_id:''; ?></td>
									<td><?php echo !empty($tour->destination)?$tour->destination:''; ?></td>
									<td><?php echo !empty($tour->departure_date)?$tour->departure_date:''; ?></td>
									<td>$ <?php echo !empty($tour->price)?$tour->price:''; ?></td>
									<td>
										<a href="<?php echo e(route('tours.edit',$tour->id)); ?>" class="success p-0">
											<i class="icon-pencil font-medium-1 mr-1"></i>
										</a>

										

										<a href="<?php echo e(route('tours.destroy',$tour->id)); ?>" class="danger p-0">
											<i class="icon-trash font-medium-1 mr-1"></i>
										</a>
									</td>

								</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo $__env->make('tours.view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagejs'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ecoach/resources/views/tours/index.blade.php ENDPATH**/ ?>