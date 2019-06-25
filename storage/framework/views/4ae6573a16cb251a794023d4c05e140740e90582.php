<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div class="row match-height">
		<div class="col-md-12" id="recent-sales">
			<div class="card">
				<div class="card-header">
					<div class="row">

						<div class="col-sm-4 col-md-6">
							<div class="card-title-wrap bar-primary">
								<h4 class="card-title"><?php echo e($pageTitle); ?></h4>
							</div>
						</div>
						<div class="col-sm-4 col-md-6 text-right">
							<div class="dataTables_filter"><a href="<?php echo e(route('tours.index')); ?>" class="btn btn-info ml-2 mt-2"><?php echo e(__('messages.tour_list')); ?>

									<i class="ft-arrow-right mt-3"></i></a>
							</div>
							<div class="dataTables_filter"><a href="<?php echo e(route('tour-calendar')); ?>" class="btn btn-info ml-2 mt-2"><?php echo e(__('messages.calendar')); ?>

									<i class="ft-arrow-right mt-3"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-content mt-1">
					<div class="modal-body row">
						<div class="col-md-6">
							<dl>
								<dt>Status:</dt>
								
								<dd>
									<?php if(!empty($Tour->status)): ?>
										<span><?php echo e(__('messages.yes')); ?></span>
										<?php else: ?>
										<span><?php echo e(__('messges.no')); ?></span>
										<?php endif; ?>
								</dd>
								<dt><?php echo e(__('messages.customers')); ?>:</dt>
								<dd><?php echo e($Tour->customer->name); ?></dd>
								<dt><?php echo e(__('messages.vehicle')); ?>:</dt>
								<dd><?php echo e($Tour->vehicle->name); ?></dd>
								<dt><?php echo e(__('messages.drivers')); ?>:</dt>
								<dd><?php echo e($Tour->driver->driver_name); ?></dd>
								<dt><?php echo e(__('messages.passengers')); ?>:</dt>
								<dd><?php echo e($Tour->passengers); ?></dd>
							</dl>
						</div>
						<div class="col-md-6">
							<dl>
								<dt><?php echo e(__('messages.from')); ?>:</dt>
								<dd><?php echo e(date('m/d/Y h:i A',strtotime($Tour->from_date))); ?></dd>
								<dt><?php echo e(__('messages.to')); ?>:</dt>
								<dd><?php echo e(date('m/d/Y h:i A',strtotime($Tour->to_date))); ?></dd>

								<dt><?php echo e(__('messages.guide')); ?>:</dt>
								<dd><?php echo e($Tour->guide); ?></dd>

								<dt><?php echo e(__('messages.price')); ?>:</dt>
								<dd><?php echo e($Tour->price); ?></dd>
							</dl>
						</div>
					</div>
					<?php if(count($Tour->attachments)): ?>
						<div class="col-sm-12"><h5><?php echo e(__('messages.attachments')); ?>:</h5></div>
						<div class="row">
							<div class="col-lg-12">
								<ul class="upload-list">
									<?php $__currentLoopData = $Tour->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php $ext = explode('.',$attachment->file); $ext = strtolower($ext[count($ext)-1]); ?>
										<?php if(in_array($ext,['png','jpg','jpeg','gif'])): ?>
										<li>
											<a href="javascript:;" onclick="showImg('<?php echo e(url('/attachments/'.$attachment->file)); ?>')">
												<img src="<?php echo e(url('/attachments/'.$attachment->file)); ?>" border="0">
											</a>
										</li>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
								<?php $__currentLoopData = $Tour->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
					<p>&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagejs'); ?>
	<?php echo $__env->make('tours.img_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<script>
		function showImg(url){
			$('#imgDiv').html('<img src="'+url+'"  style="display: block;width: 100%;height: auto;">');
			$('#viewModel').modal('show');
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/tours/detail.blade.php ENDPATH**/ ?>