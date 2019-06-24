<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-6 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title">Edit Vehicle Type</h4>
							</div>
						</div>

						

					</div>

				</div>

				<div class="card-content mt-1">
					<form method="post" action="<?php echo e(route('vehicle-type.update', $vehicleType->id)); ?>">
						<?php echo method_field('PATCH'); ?>
						<?php echo csrf_field(); ?>
						<div class="row">

							<div class="col-md-8">
								<div class="card">

									<div class="card-body">
										<div class="px-3">

											<div class="form-body">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															
															<label for="projectinput1">Vehicle Type Name</label>
															<?php echo e(Form::text("name",
  													           old("name") ? old("name") : (!empty($vehicleType->name) ? $vehicleType->name : null),
             													[
												                "class" => ($errors->has('name')) ?'form-control error_input':'form-control',
                												"placeholder" => "Name",
            													 ])); ?>

														</div>
													</div>

												</div>

												<div class="row">
													<div class="col-md-12 text-center">
														<div class="form-actions">
															<a href="<?php echo e(route('vehicle-type.index')); ?>" class="btn btn-danger mr-1">
																<i class="icon-trash"></i> Cancel</a>
															<button type="submit" class=" btn btn-success"><i class="icon-note"> Update</i> </button>
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
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/vehicle_type/edit.blade.php ENDPATH**/ ?>