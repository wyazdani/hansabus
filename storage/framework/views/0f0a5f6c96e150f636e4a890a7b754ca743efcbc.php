<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6 col-md-8">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title">Tour Details</h4>
							</div>
						</div>
						<div class="col-sm-6 col-md-4 text-right">
							<div class="dataTables_filter"><a href="<?php echo e(route('tours.index')); ?>" class="btn btn-info ml-2 mt-2">Tours List
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>
					</div>
					<div class="row"><div class="col-12"><?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div></div>

				</div>

				<div class="card-content mt-1">


					<?php if(!empty($tour->id)): ?>
						<form class="form" method="POST" action="<?php echo e(route('tours.update',$tour->id)); ?>" id="tourForm" enctype="multipart/form-data" >
						<?php echo method_field('PUT'); ?>
							<input type="hidden" id="id" name="id" value="<?php echo e($tour->id); ?>">
					<?php else: ?>
						<form class="form" method="POST" action="<?php echo e(route('tours.store')); ?>" id="tourForm" enctype="multipart/form-data" >
					<?php endif; ?>


					<?php echo csrf_field(); ?>
					<input type="hidden" name="temp_key" value="<?php echo e($randomKey); ?>">
					<?php if(!empty($attachments)): ?>
						<?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<input type="hidden" name="old_attachments[]" value="<?php echo e($attachment->file); ?>">
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>


						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="px-3">
											<div class="form-body">
												<div class="row">
													<div class="col-md-2">
														<div class="form-group">
															<label for="projectinput3">Status</label>
															<select name="status" class="form-control">
																<?php $__currentLoopData = $tour_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<option value="<?php echo e($status->id); ?>"
																	<?php if(!empty($tour->status) && $tour->status==$status->id): ?>
																		<?php echo e('Selected'); ?>

																			<?php endif; ?>
																	><?php echo e($status->name); ?></option>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="customSelect">Customer</label>
															<select name="customer_id" class="form-control">
																<?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<option value="<?php echo e($customer->id); ?>"
																	<?php if(!empty($tour->customer_id) && $tour->customer_id==$customer->id): ?>
																		<?php echo e('Selected'); ?>

																			<?php endif; ?>
																	><?php echo e($customer->name); ?></option>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															</select>

														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Vehicle</label>
															<select name="vehicle_id" class="form-control">
																<?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<option value="<?php echo e($vehicle->id); ?>"
																	<?php if(!empty($tour->vehicle_id) && $tour->vehicle_id==$vehicle->id): ?>
																		<?php echo e('Selected'); ?>

																			<?php endif; ?>
																	><?php echo e($vehicle->name.' - '.$vehicle->make.' - '.$vehicle->year.' - '.
																	$vehicle->licensePlate.' - '.$vehicle->transmission); ?></option>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															</select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="issueinput3">From Date</label>
															<input type="datetime-local" name="from_date" id="from_date"
																   class="form-control"
																   data-toggle="tooltip"
																   data-trigger="hover"
																   data-placement="top"
																   data-title="Date Opened"
																   value="<?php echo e((!empty($tour->from_date))?$tour->from_date:old('from_date')); ?>" >
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="issueinput3">To Date</label>
															<input type="datetime-local" name="to_date" id="to_date"
																   class="form-control"
																   data-toggle="tooltip"
																   data-trigger="hover"
																   data-placement="top"
																   data-title="Date Opened"
																   value="<?php echo e((!empty($tour->to_date))?$tour->to_date:old('to_date')); ?>" >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="customSelect">Driver</label>
															<select name="driver_id" class="form-control">
																<?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<option value="<?php echo e($driver->id); ?>"
																	<?php if(!empty($tour->driver_id) && $tour->driver_id==$driver->id): ?>
																		<?php echo e('Selected'); ?>

																			<?php endif; ?>
																	><?php echo e($driver->driver_name); ?></option>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3"># of Passengers</label>
															<input type="number" name="passengers" class="form-control" value="<?php echo e((!empty($tour->passengers))?$tour->passengers:old('passengers')); ?>" >
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3">Guide Name</label>
															<input type="text" name="guide" class="form-control" value="<?php echo e((!empty($tour->guide))?$tour->guide:old('guide')); ?>" >
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="projectinput3">Price</label>
															<input type="number" name="price" class="form-control" value="<?php echo e((!empty($tour->price))?$tour->price:old('price')); ?>" >
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>



					<?php if(!empty($attachments)): ?>
							<div class="col-sm-12"><h5>Attachments:</h5></div>
							<div class="row">
							<div class="col-lg-12">
								<ul class="upload-list">
									<?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); ?>
										<?php if(in_array($ext,['png','jpg','jpeg','gif'])): ?>
											<li>
												<a href="<?php echo e(url('/attachments/'.$attachment->file)); ?>" target="_blank">
													<img src="<?php echo e(url('/attachments/'.$attachment->file)); ?>" border="0">
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
								<?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); ?>
									<?php if(!in_array($ext,['png','jpg','jpeg','gif'])): ?>
										<div class="col-md-3"><a href="<?php echo e(url('/attachments/'.$attachment->file)); ?>" target="_blank">
												<?php echo e($attachment->file); ?>

											</a></div>
									<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					<?php endif; ?>



				</div>
				<div class="row">
					<div class="col-md-12">
						<?php echo $__env->make('layouts.upload_files', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
				</div>

				<div class="col-md-12 text-left">
					<div class="form-actions">
						<a href="<?php echo e(route('drivers.index')); ?>" class="btn btn-danger mr-1"><b>
								<i class="icon-trash"></i></b> Cancel</a>
						<button type="button" onclick="$('#tourForm').submit()" class="btn btn-success"><b>
								<i class="icon-note"></i></b> Save</button>
						<button type="button" class="btn btn-info">
							<i class="icon-note"></i> Save & add another
						</button>
					</div>
				</div>


			</div>

		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagejs'); ?>
	<script>
		// Start jQuery stuff
		$(function() {
			// Call Dropzone manually
			$(".dropzone").dropzone({
				paramName: "file",
				maxFilesize: 8, // MB
				queuecomplete: function() {
					// Some more jQuery stuff inside Dropzone's callback
					// $("#some_id").somejQueryMethod();

					console.log('++');
				}
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ecoach/resources/views/tours/add.blade.php ENDPATH**/ ?>