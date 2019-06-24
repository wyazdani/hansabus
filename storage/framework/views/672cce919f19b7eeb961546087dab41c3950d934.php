<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-6 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title"><?php if(!empty($driver->id)): ?> <?php echo e('Update'); ?> <?php endif; ?>  Driver</h4>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 text-right">
							<div class="dataTables_filter"><a href="<?php echo e(route('v-drivers.index')); ?>" class="btn btn-info ml-2 mt-2"><?php echo e(__('messages.driver_list')); ?>

									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>

					</div>

				</div>

				<div class="card-content mt-1">

					<?php if(!empty($driver->id)): ?>
						<form class="form" method="POST" action="<?php echo e(route('v-drivers.update',$driver->id)); ?>" id="theForm" enctype="multipart/form-data" >
							<?php echo method_field('PUT'); ?>
							<input type="hidden" id="id" name="id" value="<?php echo e($driver->id); ?>">
							<input type="hidden" name="old_profile_pic" value="<?php echo e($driver->profile_pic); ?>">
					<?php else: ?>
								<form class="form" method="POST" action="<?php echo e(route('v-drivers.store')); ?>" id="theForm" enctype="multipart/form-data" >
					<?php endif; ?>
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
																		<label for="projectinput1"><?php echo e(__('messages.driver_name')); ?></label>
																		<input type="text" name="driver_name"
																			   class="<?php echo e(($errors->has('driver_name')) ?'form-control error_input':'form-control'); ?>"
																			   value="<?php echo e((!empty($driver->driver_name))?$driver->driver_name:old('driver_name')); ?>" >
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="projectinput2"><?php echo e(__('messages.mobile_no')); ?>.</label>
																		<input type="number" name="mobile_number"
																			   class="<?php echo e(($errors->has('mobile_number')) ?'form-control error_input':'form-control'); ?>"
																			   value="<?php echo e((!empty($driver->mobile_number))?$driver->mobile_number:old('mobile_number')); ?>" >
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="projectinput3"><?php echo e(__('messages.driver_license')); ?></label>
																		<input type="text" name="driver_license"
																			   class="<?php echo e(($errors->has('driver_license')) ?'form-control error_input':'form-control'); ?>"
																			   value="<?php echo e((!empty($driver->driver_license))?$driver->driver_license:old('driver_license')); ?>">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="projectinput4">NIN No.</label>
																		<input type="number" name="nic"
																			   class="<?php echo e(($errors->has('nic')) ?'form-control error_input':'form-control'); ?>"
																			   value="<?php echo e((!empty($driver->nic))?$driver->nic:old('nic')); ?>" >
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label
																				for="projectinput3"><?php echo e(__('messages.address')); ?></label>
																		<input type="text" name="address"
																			   class="<?php echo e(($errors->has('address')) ?'form-control error_input':'form-control'); ?>"
																			   value="<?php echo e((!empty($driver->address))?$driver->address:old('address')); ?>" >
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="projectinput4"><?php echo e(__('messages.phone')); ?></label>
																		<input type="number"  name="phone"
																			   class="<?php echo e(($errors->has('phone')) ?'form-control error_input':'form-control'); ?>"
																			   value="<?php echo e((!empty($driver->phone))?$driver->phone:old('phone')); ?>">
																	</div>
																</div>
															</div>

															<div class="form-group">
																<label for="projectinput8"><?php echo e(__('messages.other_details')); ?></label>
																<textarea rows="5" name="other_details"
																		  class="<?php echo e(($errors->has('other_details')) ?'form-control error_input':'form-control'); ?>"
																><?php echo e((!empty($driver->other_details))?$driver->other_details:old('other_details')); ?></textarea>
															</div>
														</div>

													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="card">
												<div class="card-body collapse show">
													<?php if(!empty($driver->profile_pic)): ?>
														<img src="<?php echo e(url('images/drivers/'.$driver->profile_pic)); ?>"
															 style="display:block; width: 90%; height:auto;">
														<?php endif; ?>
													<div class="card-block">
														<input type="file" class="form-control" name="profile_pic">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 text-center">
											<div class="form-actions">
												<a href="<?php echo e(route('v-drivers.index')); ?>" class="btn btn-danger mr-1"><b>
														<i class="icon-trash"></i></b> <?php echo e(__('messages.cancel')); ?></a>

												<?php if(!empty($driver->id)): ?>
												<button type="submit" class="btn btn-success"><b>
														<i class="icon-note"></i></b> <?php echo e(__('messages.update')); ?></button>
												<?php else: ?>
													<button type="submit" class="btn btn-success"><b>
															<i class="icon-note"></i></b> <?php echo e(__('messages.save')); ?></button>
												<?php endif; ?>
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