
<?php if(session()->has('message')): ?>
    <div class="alert alert-info" role="info">
        <?php echo e(session()->get('message')); ?>

    </div>
<?php elseif(session()->has('success')): ?>
    <div class="alert alert-info" role="success">
        <?php echo e(session()->get('success')); ?>

    </div>
<?php elseif(session()->has('info')): ?>
    <div class="alert alert-info" role="info">
        <?php echo e(session()->get('info')); ?>

    </div>
<?php elseif($errors->any()): ?>
<div class="alert alert-info" role="alert">
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p><?php echo e($error); ?> &nbsp; </p>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?><?php /**PATH /var/www/html/ecoach/resources/views/layouts/errors.blade.php ENDPATH**/ ?>