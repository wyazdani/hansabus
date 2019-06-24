<nav class="navbar navbar-expand-lg navbar-light bg-faded">
	<div class="container-fluid">


		<div class="navbar-header">
			<?php if(Auth::check()): ?>
			<button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a class="open-navbar-container"><i class="ft-more-vertical"></i></a></span>
			<?php endif; ?>


		</div>

		<div class="navbar-container">
			<div id="navbarSupportedContent" class="collapse navbar-collapse">

				<?php if(Auth::check()): ?>
				<ul class="navbar-nav">

					<li class="nav-item mt-1 navbar-search text-left dropdown"><a id="search" href="#" data-toggle="dropdown" class="nav-link dropdown-toggle"><i class="ft-search blue-grey darken-4"></i></a>
						<div aria-labelledby="search" class="search dropdown-menu dropdown-menu-right">
							<div class="arrow_box_right">
								<form role="search" class="navbar-form navbar-right">
									<div class="position-relative has-icon-right mb-0">
										<input id="navbar-search" type="text" placeholder="Search" class="form-control" />
										<div class="form-control-position navbar-search-close"><i class="ft-x"></i>
										</div>
									</div>
								</form>
							</div>
						</div>
					</li>

					<li class="dropdown nav-item mt-1"><a id="dropdownBasic" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle"><i class="ft-flag blue-grey darken-4"></i><span class="selected-language d-none"></span></a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="arrow_box_right">
								<a href="<?php echo e(url('locale/en')); ?>" class="dropdown-item py-1"><img src="<?php echo e(asset('images/us.png')); ?>" alt="English Flag" class="langimg" /><span>
										English</span></a>
								<a href="<?php echo e(url('locale/de')); ?>" class="dropdown-item py-1"><img src="<?php echo e(asset('images/es.png')); ?>" alt="Spanish Flag" class="langimg" /><span>
										German</span></a>
								
						</div>
					</li>

					<li class="dropdown nav-item mr-0"><a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-user-link dropdown-toggle"><span class="avatar avatar-online">
								<img id="navbar-avatar" src="<?php echo e(asset('images/avatar-s-3.jpg')); ?>" alt="avatar" /></span>
							<p class="d-none">User Settings</p>
						</a>
						<div aria-labelledby="dropdownBasic3" class="dropdown-menu dropdown-menu-right">
							<div class="arrow_box_right">
								<a href="user-profile-page.html" class="dropdown-item py-1"><i class="ft-edit mr-2"></i><span><?php echo e(__('messages.my_profile')); ?></span></a>
								<a href="javascript:;" class="dropdown-item py-1"><i class="ft-settings mr-2"></i><span><?php echo e(__('messages.settings')); ?></span></a>
								<div class="dropdown-divider"></div>
								
								<a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
             document.getElementById('logout-form').submit();" role="menuitem">
									<i class="ft-power mr-2"></i> <?php echo e(__('messages.logout')); ?></a>
								<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
									<?php echo csrf_field(); ?>
								</form>

							</div>
						</div>
					</li>
				</ul>
				<?php endif; ?>

			</div>
		</div>

	</div>
</nav><?php /**PATH D:\laragon\www\new_ecoach\ecoach\resources\views/layouts/header.blade.php ENDPATH**/ ?>