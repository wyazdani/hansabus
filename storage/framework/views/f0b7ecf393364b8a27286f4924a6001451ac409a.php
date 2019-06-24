<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row match-height">
        <div class="col-md-12" id="recent-sales">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-sm-6 col-md-6">
                            <div class="card-title-wrap bar-primary">
                                <h4 class="card-title"><?php echo e((!empty($customer->id))?'Update':'Add'); ?> <?php echo e(__('messages.customers')); ?></h4>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 text-right">
                            <div class="dataTables_filter"><a href="<?php echo e(route('customers.index')); ?>" class="btn btn-info ml-2 mt-2"><?php echo e(__('messages.customer_list')); ?>

                                    <i class="ft-arrow-right mt-3"></i></a>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-content mt-1">

                    <?php if(!empty($customer->id)): ?>
                        <form class="form" method="POST" action="<?php echo e(route('customers.update',$customer->id)); ?>"
                              id="theForm">
                            <?php echo method_field('PUT'); ?>
                            <input type="hidden" id="id" name="id" value="<?php echo e($customer->id); ?>">
                            <?php else: ?>
                                <form class="form" method="POST" action="<?php echo e(route('customers.store')); ?>" id="theForm">
                                    <?php endif; ?>


                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" id="returnFlag" name="returnFlag" value="">


                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="card">

                                                <div class="card-body">
                                                    <div class="px-3">

                                                        <div class="form-body">


                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput1">Name</label>

                                                                        <input type="text" name="name" class="<?php echo e(($errors->has('name')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($customer->name))?$customer->name:old('name')); ?>" >
                                                                        <?php if($errors->has('name')): ?>
                                                                            <div class="error"><?php echo e($errors->first('name')); ?></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput2">Email</label>
                                                                        <input type="email" name="email" class="<?php echo e(($errors->has('email')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($customer->email))?$customer->email:old('email')); ?>"
                                                                        <?php if(!empty($customer->id)): ?> <?php echo e('readonly="readonly"'); ?> <?php endif; ?> >
                                                                        <?php if($errors->has('email')): ?>
                                                                            <div class="error"><?php echo e($errors->first('email')); ?></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput3"><?php echo e(__('messages.company_web')); ?></label>
                                                                        <input type="text" name="url" class="<?php echo e(($errors->has('url')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($customer->url))?$customer->url:old('url')); ?>">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput4"><?php echo e(__('messages.cell_number')); ?></label>
                                                                        <input type="text" name="phone" class="<?php echo e(($errors->has('phone')) ?'form-control error_input':'form-control'); ?>" maxlength = "11"  value="<?php echo e((!empty($customer->phone))?$customer->phone:old('phone')); ?>">
                                                                        <?php if($errors->has('phone')): ?>
                                                                            <div class="error"><?php echo e($errors->first('phone')); ?></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput4"><?php echo e(__('messages.address')); ?></label>
                                                                        <input type="text" name="address" class="<?php echo e(($errors->has('address')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($customer->address))?$customer->address:old('address')); ?>">
                                                                        <?php if($errors->has('address')): ?>
                                                                            <div class="error"><?php echo e($errors->first('address')); ?></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label><?php echo e(__('messages.is_active')); ?></label>
                                                <div class="form-group">
                                                    <div class="display-inline-block">
                                                        <label class="switch">
                                                            <input type="checkbox" name="status"
                                                            <?php if(!empty(old('status')) && old('status')): ?>
                                                                <?php echo e('checked'); ?>

                                                                    <?php elseif(!empty($customer->status) && $customer->status): ?>
                                                                <?php echo e('checked'); ?>

                                                                    <?php elseif(empty($customer->status)): ?>
                                                                <?php echo e('checked'); ?>

                                                                    <?php endif; ?> >
                                                            <span class="slider round"></span>
                                                            <p>Yes / No</p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-actions">
                                                <a href="<?php echo e(url('/customers')); ?>" class="btn btn-danger mr-1">
                                                    <i class="fa fa-times"></i> <?php echo e(__('messages.cancel')); ?>

                                                </a>
                                                <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                                    <i class="icon-note"></i> <?php echo e(__('messages.save')); ?>

                                                </button>
                                                <button type="button" onclick="$('#returnFlag').val('0'); $('#theForm').submit();" class="btn btn-info">
                                                    <i class="icon-note"></i> <?php echo e(__('messages.save_add_another')); ?>

                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/customer/add.blade.php ENDPATH**/ ?>