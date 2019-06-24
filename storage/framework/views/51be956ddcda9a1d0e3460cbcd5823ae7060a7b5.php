<?php $__env->startSection('page_title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row match-height">
    <div class="col-md-12" id="recent-sales">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <div class="col-sm-6 col-md-6">
                        <div class="card-title-wrap bar-primary">
                            <h4 class="card-title"><?php echo e(__('messages.vehicle_details')); ?></h4>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 text-right">
                        <div class="dataTables_filter"><a href="<?php echo e(url('/vehicles')); ?>" class="btn btn-info ml-2 mt-2">
                                <?php echo e(__('messages.vehicle_list')); ?>

                                <i class="ft-arrow-right mt-3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-content mt-1">

                    <?php if(!empty($vehicle->id)): ?>
                    <form class="form" method="POST" action="<?php echo e(route('vehicles.update',$vehicle->id)); ?>" 
                    id="theForm">
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" id="id" name="id" value="<?php echo e($vehicle->id); ?>">
                    <?php else: ?>
                    <form class="form" method="POST" action="<?php echo e(route('vehicles.store')); ?>" id="theForm">
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
                                                        <label for="projectinput1"><?php echo e(__('messages.vehicle_name')); ?></label>

                                                        <input type="text" name="name" class="<?php echo e(($errors->has('name')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($vehicle->name))?$vehicle->name:old('name')); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2"><?php echo e(__('messages.year_of_manufacture')); ?></label>

                                                        <select name="year" class="<?php echo e(($errors->has('year')) ?'form-control error_input':'form-control'); ?>">
                                                            <?php for($year=date('Y'); $year>(date('Y')-50); $year--): ?>
                                                            <option value="<?php echo e($year); ?>"

                                                             <?php if( (!empty($vehicle->year) && $vehicle->year==$year) ||
                                                             (!empty(old('year')) && old('year') == $year) ): ?>
                                                                 <?php echo e('Selected'); ?>

                                                             <?php endif; ?>
                                                            ><?php echo e($year); ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3"><?php echo e(__('messages.make_model')); ?></label>

                                                        <input type="text" name="make" class="<?php echo e(($errors->has('make')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($vehicle->make))?$vehicle->make:old('make')); ?>">


                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4"><?php echo e(__('messages.engine_number')); ?></label>

                                                        <input type="text" name="engineNumber" class="<?php echo e(($errors->has('engineNumber')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($vehicle->engineNumber))?$vehicle->engineNumber:old('engineNumber')); ?>">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label for="customSelect"><?php echo e(__('messages.type_of_vehicle')); ?></label>

                                                        <select class="<?php echo e(($errors->has('vehicle_type')) ?'custom-select d-block w-100 error_input':'custom-select d-block w-100'); ?>"
                                                        id="customSelect" name="vehicle_type">
                                                            <?php $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            
                                                            <option value="<?php echo e($vehicleType->id); ?>"
                                                            <?php if(!empty($vehicle->vehicle_type) && $vehicle->vehicle_type == $vehicleType->id): ?>
                                                            <?php echo e('selected'); ?>

                                                            <?php endif; ?>    
                                                            ><?php echo e($vehicleType->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4"><?php echo e(__('messages.number_of_seats')); ?></label>
                                                        <input type="number" name="seats" class="<?php echo e(($errors->has('seats')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($vehicle->seats))?$vehicle->seats:old('seats')); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4"><?php echo e(__('messages.license_plate')); ?></label>
                                                        <input type="text" name="licensePlate" class="<?php echo e(($errors->has('licensePlate')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($vehicle->licensePlate))?$vehicle->licensePlate:old('licensePlate')); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4"><?php echo e(__('messages.vehicle_color')); ?></label>

                                                        <input type="text" name="color" class="<?php echo e(($errors->has('color')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($vehicle->color))?$vehicle->color:old('color')); ?>">


                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput4"><?php echo e(__('messages.vehicle_reg_number')); ?></label>

                                                        <input type="text" name="registrationNumber" class="<?php echo e(($errors->has('registrationNumber')) ?'form-control error_input':'form-control'); ?>" value="<?php echo e((!empty($vehicle->registrationNumber))?$vehicle->registrationNumber:old('registrationNumber')); ?>">


                                                    </div>
                                                </div>

                                                <div class="col-md-6">



                                                    <?php if($errors->has('transmission')): ?>
                                                        <span class="label label-danger"><?php echo $errors->first('transmission'); ?></span><?php endif; ?>
                                                    <div class="form-group">
                                                        <label><?php echo e(__('messages.transmission')); ?></label>
                                                        <div class="input-group">
                                                            <div class="custom-control custom-radio display-inline-block mr-2">
                                                                <input type="radio" name="transmission" class="custom-control-input"
                                                                id="customRadioInline4"
                                                                value="Automatic"
                                                                <?php if(old('transmission') == 'Automatic'): ?> 
                                                                    <?php echo e('checked'); ?> 
                                                                <?php elseif(!empty($vehicle->transmission) && $vehicle->transmission == 'Automatic'): ?>
                                                                    <?php echo e('checked'); ?>

                                                                <?php endif; ?> 
                                                                >
                                                                <label class="custom-control-label" for="customRadioInline4"><?php echo e(__('messages.automatic')); ?></label>
                                                            </div>
                                                            <div class="custom-control custom-radio display-inline-block">
                                                                <input type="radio" name="transmission" class="custom-control-input"
                                                                id="customRadioInline3"
                                                                value="Manual"
                                                                <?php if(old('transmission') == 'Manual'): ?> 
                                                                    <?php echo e('checked'); ?> 
                                                                <?php elseif(!empty($vehicle->transmission) && $vehicle->transmission == 'Manual'): ?>
                                                                    <?php echo e('checked'); ?>

                                                                <?php endif; ?> 
                                                                >
                                                                <label class="custom-control-label" for="customRadioInline3"><?php echo e(__('messages.manual')); ?></label>
                                                            </div>
                                                        </div>
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
                                <label>AC</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="AC"
                                            <?php if(!empty(old('AC')) && old('AC')): ?> <?php echo e('checked'); ?> <?php elseif(!empty($vehicle->AC) && $vehicle->AC): ?>
                                            <?php echo e('checked'); ?>

                                            <?php endif; ?> >
                                            <span class="slider round"></span>
                                            <p><?php echo e(__('messages.yes/no')); ?></p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Radio</label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="radio"
                                            <?php if(!empty(old('radio')) && old('radio')): ?> <?php echo e('checked'); ?> <?php elseif(!empty($vehicle->radio) && $vehicle->radio): ?>
                                            <?php echo e('checked'); ?>

                                            <?php endif; ?> >
                                            <span class="slider round"></span>
                                            <p><?php echo e(__('messages.yes/no')); ?></p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('messages.sunroof')); ?></label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="sunroof" <?php if(!empty(old('sunroof')) && old('sunroof')): ?> <?php echo e('checked'); ?> <?php elseif(!empty($vehicle->sunroof) && $vehicle->sunroof): ?>
                                            <?php echo e('checked'); ?>

                                            <?php endif; ?> >
                                            <span class="slider round"></span>
                                            <p><?php echo e(__('messages.yes/no')); ?></p>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label><?php echo e(__('messages.Phone_Charging_Jack')); ?></label>
                                <div class="form-group">
                                    <div class="display-inline-block">
                                        <label class="switch">
                                            <input type="checkbox" name="phoneCharging" <?php if(!empty(old('phoneCharging')) && old('phoneCharging')): ?> <?php echo e('checked'); ?> <?php elseif(!empty($vehicle->phoneCharging) && $vehicle->phoneCharging): ?>
                                            <?php echo e('checked'); ?>

                                            <?php endif; ?> >
                                            <span class="slider round"></span>
                                            <p><?php echo e(__('messages.yes/no')); ?></p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-actions">
                                <?php if(!empty($vehicle->id)): ?>
                                    <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                        <i class="icon-note"></i> <?php echo e(__('messages.update')); ?>

                                    </button>
                                <?php else: ?>
                                    <a href="<?php echo e(url('/vehicles')); ?>" class="btn btn-danger mr-1">
                                        <i class="fa fa-times"></i> <?php echo e(__('messages.cancel')); ?>

                                    </a>
                                    <button type="button" onclick="$('#returnFlag').val('1'); $('#theForm').submit();" class="btn btn-success">
                                        <i class="icon-note"></i> <?php echo e(__('messages.save')); ?>

                                    </button>
                                    <button type="button" onclick="$('#returnFlag').val('0'); $('#theForm').submit();" class="btn btn-info">
                                        <i class="icon-note"></i> <?php echo e(__('messages.save_add_another')); ?>

                                    </button>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/vehicle/add.blade.php ENDPATH**/ ?>