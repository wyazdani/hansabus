<!DOCTYPE html>
<html lang="en" class="loading">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(Auth::check()): ?>
<body data-col="2-columns" class=" 2-columns ">
	<div class="wrapper">		
		<?php if(Auth::check()): ?>
			<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
		<?php endif; ?>

		<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="main-panel">
			<div class="main-content">
				<div class="content-wrapper">
					<div class="container-fluid" id="app8">
						<?php echo $__env->yieldContent('content'); ?>                    
					</div>
				</div>
			</div>
			<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>		
	</div>
	<?php echo $__env->make('layouts.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldContent('pagejs'); ?>
</body>
<?php else: ?>
<body data-col="1-column" class=" 1-column  blank-page blank-page">
	<?php echo $__env->yieldContent('content'); ?>     
</body>		
<?php endif; ?>
</html><?php /**PATH /var/www/html/ecoach/resources/views/layouts/app.blade.php ENDPATH**/ ?>