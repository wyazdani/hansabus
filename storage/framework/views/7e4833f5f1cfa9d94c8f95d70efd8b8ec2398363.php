<div data-active-color="white" data-background-color="black"
	 data-image="<?php echo e(asset('images/01.jpg')); ?>"
	 class="app-sidebar">

	<div class="sidebar-header">
		<div class="logo clearfix"><a href="<?php echo e(route('home')); ?>" class="logo-text float-left">
				<div class="logo-img"><img src="<?php echo e(asset('images/logo.png')); ?>" alt="Convex Logo" /></div>
				<span class="text align-middle">E-<?php echo e(__('messages.coach')); ?><br><?php echo e(__('messages.management')); ?></span>
			</a>
		</div>
	</div>

	<div class="sidebar-content">
		<div class="nav-container">
			<ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
				<li <?php if(Request::route()->getName() == 'home'): ?> <?php echo e(' class=open'); ?> <?php endif; ?> ><a href="<?php echo e(route('home')); ?>" class="menu-item"><?php echo e(__('messages.dashboard')); ?></a></li>

				<li <?php if(in_array(Request::route()->getName(),[
				'vehicles.index','vehicles.create','vehicles.edit',
				'vehicle-type.index','vehicle-type.create','vehicle-type.edit'
				])): ?>
					<?php echo e(' class=open'); ?> <?php endif; ?>
					class="has-sub nav-item">
					<a href="javascript:;">
						<span data-i18n="" class="menu-title"><?php echo e(__('messages.vehicle')); ?></span>
					</a>
					<ul class="menu-content">
						<li><a href="<?php echo e(route('vehicles.index')); ?>" class="menu-item"><?php echo e(__('messages.vehicle')); ?></a>
						</li>
						<li><a href="<?php echo e(route('vehicle-type.index')); ?>" class="menu-item"><?php echo e(__('messages.vehicle_type')); ?></a>
						</li>
						<li><a href="javascript:;" class="menu-item"><?php echo e(__('messages.maintenance')); ?></a>
						</li>


					</ul>
				</li>
				<li <?php if(in_array(Request::route()->getName(),['drivers.index','drivers.create','drivers.edit'])): ?>
					<?php echo e(' class=open'); ?> <?php endif; ?> ><a href="<?php echo e(route('v-drivers.index')); ?>" class="menu-item"><?php echo e(__('messages.drivers')); ?></a></li>

				<li <?php if(in_array(Request::route()->getName(),['customers.index','customers.create','customers.edit'])): ?>
					<?php echo e(' class=open'); ?> <?php endif; ?> ><a href="<?php echo e(route('customers.index')); ?>" class="menu-item"><?php echo e(__('messages.customers')); ?></a></li>

				<li <?php if(in_array(Request::route()->getName(),['tours.index','tours.create','tours.edit','tour-detail'])): ?>
					<?php echo e(' class=open'); ?> <?php endif; ?> ><a href="<?php echo e(route('tours.index')); ?>" class="menu-item"><?php echo e(__('messages.tours')); ?></a></li>


				<li <?php if(in_array(Request::route()->getName(),['invoices'])): ?>
					<?php echo e(' class=open'); ?> <?php endif; ?>><a href="<?php echo e(route('invoices')); ?>" class="menu-item"><?php echo e(__('messages.invoices')); ?></a></li>


				<li <?php if(in_array(Request::route()->getName(),['tour-calendar'])): ?>
					<?php echo e(' class=open'); ?> <?php endif; ?> ><a href="<?php echo e(route('tour-calendar')); ?>" class="menu-item"><?php echo e(__('messages.calendar')); ?></a></li>




				<li <?php if(Request::route()->getName() == 'settings'): ?> <?php echo e(' class=open'); ?> <?php endif; ?> ><a href="javascript:;" class="menu-item"><?php echo e(__('messages.settings')); ?></a></li>
				<li <?php if(Request::route()->getName() == 'reports'): ?> <?php echo e(' class=open'); ?> <?php endif; ?> ><a href="javascript:;" class="menu-item"><?php echo e(__('messages.reports')); ?></a></li>

			</ul>
		</div>
	</div>

	<div class="sidebar-background"></div>

</div><?php /**PATH /var/www/html/ecoach/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>