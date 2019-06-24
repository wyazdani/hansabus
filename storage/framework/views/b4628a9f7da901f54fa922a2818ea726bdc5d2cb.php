<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-6 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title">Edit Driver</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="<?php echo e(route('drivers.index')); ?>" class="btn btn-info ml-2 mt-2">Drivers List
									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">
					<form method="post" action="<?php echo e(route('drivers.update', $driver->id)); ?>">
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
															
															<label for="projectinput1">Driver Name</label>
															<?php echo e(Form::text("driver_name",
  													           !empty($driver->driver_name) ? $driver->driver_name : null,
             													[
												                "class" => ($errors->has('driver_name')) ?'form-control has-error':'form-control',
                												"placeholder" => "driver_name",
            													 ])); ?>

														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput2">Mobile No.</label>
															<?php echo e(Form::text("mobile_number",
  													           !empty($driver->mobile_number) ? $driver->mobile_number: null,
             													[
												                "class" => ($errors->has('mobile_number')) ?'form-control has-error':'form-control',
                												"placeholder" => "mobile_number",
            													 ])); ?>

														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput3">Driver
																License</label>
															<?php echo e(Form::text("driver_license",
  													           !empty($driver->driver_license) ? $driver->driver_license: null,
             													[
												                "class" => ($errors->has('driver_license')) ?'form-control has-error':'form-control',
                												"placeholder" => "driver_license",
            													 ])); ?>

														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Nic
																No.</label>
															<?php echo e(Form::text("nic",
  													           !empty($driver->nic) ? $driver->nic: null,
             													[
												                "class" => ($errors->has('nic')) ?'form-control has-error':'form-control',
                												"placeholder" => "nic",
            													 ])); ?>

														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label
																	for="projectinput3">Address</label>
															<?php echo e(Form::text("address",
  													           !empty($driver->address) ? $driver->address: null,
             													[
												                "class" => ($errors->has('address')) ?'form-control has-error':'form-control',
                												"placeholder" => "address",
            													 ])); ?>

														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Phone
																Number</label>
															<?php echo e(Form::text("phone",
  													           !empty($driver->phone) ? $driver->phone: null,
             													[
												                "class" => ($errors->has('phone')) ?'form-control has-error':'form-control',
                												"placeholder" => "phone",
            													 ])); ?>

														</div>
													</div>
												</div>

												<div class="form-group">
													<label for="projectinput8">Other Details</label>
													<?php echo e(Form::textarea("other_details",
  													           !empty($driver->other_details) ? $driver->other_details: null,
             													[
												                "class" => ($errors->has('other_details')) ?'form-control has-error':'form-control',
                												"placeholder" => "other_details",
            													 ])); ?>

													
												</div>

												<div class="row">
													<div class="col-md-12 text-center">
														<div class="form-actions">
															<a href="<?php echo e(route('drivers.index')); ?>" class="btn btn-danger mr-1">
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/drivers/edit.blade.php ENDPATH**/ ?>