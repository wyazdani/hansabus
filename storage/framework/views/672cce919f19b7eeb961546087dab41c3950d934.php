<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-6 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title">Add Driver</h4>
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
					<form method="post" action="<?php echo e(route('drivers.store')); ?> "  enctype="multipart/form-data">
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
															<input type="text" class="<?php echo e(($errors->has('driver_name')) ?'form-control error_input':'form-control'); ?>" name="driver_name"
																   value="<?php echo e((!empty($driver->driver_name))?$driver->driver_name:old('driver_name')); ?>" >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput2">Mobile
																No.</label>
															<input type="text" id=""
																   class="<?php echo e(($errors->has('mobile_number')) ?'form-control error_input':'form-control'); ?>" maxlength="11" placeholder="Only Numbers"
																   value="<?php echo e((!empty($driver->mobile_number))?$driver->mobile_number:old('mobile_number')); ?>" name="mobile_number">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput3">Driver
																License</label>
															<input type="text" id=""
																   class="<?php echo e(($errors->has('driver_license')) ?'form-control error_input':'form-control'); ?>"
																   name="driver_license" value="<?php echo e((!empty($driver->driver_license))?$driver->driver_license:old('driver_license')); ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">NIN
																No.</label>
															<input type="text" id=""
																   class="<?php echo e(($errors->has('nic')) ?'form-control error_input':'form-control'); ?>" name="nic" maxlength="11"
																   value="<?php echo e((!empty($driver->nic))?$driver->nic:old('nic')); ?>" placeholder="Only Numbers">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label
																	for="projectinput3">Address</label>
															<input type="text" id=""
																   class="<?php echo e(($errors->has('address')) ?'form-control error_input':'form-control'); ?>"
																   value="<?php echo e((!empty($driver->address))?$driver->address:old('address')); ?>" name="address" >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="projectinput4">Phone
																Number</label>
															<input type="text" id=""
																   class="<?php echo e(($errors->has('phone')) ?'form-control error_input':'form-control'); ?>"
																   value="<?php echo e((!empty($driver->phone))?$driver->phone:old('phone')); ?>" name="phone" maxlength="11" placeholder="Only Numbers">
														</div>
													</div>
												</div>

												<div class="form-group">
													<label for="projectinput8">Other Details</label>
													<textarea id="projectinput8" rows="5"
															  class="<?php echo e(($errors->has('other_details')) ?'form-control error_input':'form-control'); ?>"
															  name="other_details" value="<?php echo e((!empty($driver->other_details))?$driver->other_details:old('other_details')); ?>"

													></textarea>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card">
									<div class="card-body collapse show">
										<div class="card-block">
											
											<input type="file" class="dropzone dropzone-area" name="avatar" id="avatar">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<div class="form-actions">
									<a href="<?php echo e(route('drivers.index')); ?>" class="btn btn-danger mr-1"><b>
											<i class="icon-trash"></i></b> Cancel</a>
									<button type="submit" class="btn btn-success"><b>
											<i class="icon-note"></i></b> Save</button>
								</div>
							</div>
						</div>

					</form>
				</div>

			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/drivers/add.blade.php ENDPATH**/ ?>