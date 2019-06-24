<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-6 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title"><?php echo e(__('messages.add_vehicle_type')); ?></h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="<?php echo e(route('vehicle-type.index')); ?>" class="btn btn-info ml-2 mt-2"><?php echo e(__('messages.vehicle_type_list')); ?>

									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">
						<form method="post" action="<?php echo e(route('vehicle-type.store')); ?>">
						<?php echo csrf_field(); ?>
							<div class="uper">
								<?php if(session()->get('success')): ?>
									<div class="alert alert-success">
										<?php echo e(session()->get('success')); ?>

									</div><br />
								<?php endif; ?>
						<div class="row">

							<div class="col-md-8">
								<div class="card">

									<div class="card-body">
										<div class="px-3">

											<div class="form-body">
												<div class="row">

													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput1"><?php echo e(__('messages.vehicle_type_name')); ?></label>

															<input type="text" name="name"  class="<?php echo e(($errors->has('name')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($vehicle_types->name))?$vehicle_types->name:old('name')); ?>">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<div class="form-actions">
								<a href="<?php echo e(route('vehicle-type.index')); ?>" class="btn btn-danger mr-1"><b>
										<i class="fa fa-times"></i></b> <?php echo e(__('messages.cancel')); ?></a>
							<button type="submit" class="btn btn-success"><b>
									<i class="icon-note"></i></b> <?php echo e(__('messages.save')); ?></button>
						</div>
							</div>
						</div>

					</form>
				</div>

			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/vehicle_type/add.blade.php ENDPATH**/ ?>