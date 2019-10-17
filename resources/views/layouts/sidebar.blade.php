<div data-active-color="white" data-background-color="black"
	 data-image="{{ asset('images/01.jpg') }}"
	 class="app-sidebar d-print-none">
	<div class="sidebar-header">
		<div class="logo clearfix"><a href="{{ route('home') }}" class="logo-text float-left">
				<div class="logo-img2"><img src="{{ asset('images/hansa_logo.png') }}" alt="Convex Logo" width="220" /></div>
{{--				<span class="text align-middle">E-Coach</span>--}}
			</a>
		</div>
	</div>
	<div class="sidebar-content">
		<div class="nav-container">
			<ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
				<li @if(Request::route()->getName() == 'home') {{ ' class=open' }} @endif ><a href="{{ route('home') }}" class="menu-item">{{ __('messages.dashboard') }}</a></li>
				<li class="has-sub nav-item {{ (in_array(Request::route()->getName(),[
				'vehicles.index','vehicles.create','vehicles.edit',
				'vehicle-type.index','vehicle-type.create','vehicle-type.edit'
				])) ? 'open' : '' }}">
					<a href="javascript:;">
						<span data-i18n="" class="menu-title">{{ __('messages.vehicles') }}</span>
					</a>
					<ul class="menu-content">
						<li><a href="{{ route('vehicles.index') }}" class="menu-item">{{ __('messages.vehicles') }}</a></li>
						<li><a href="{{ route('vehicle-type.index') }}" class="menu-item">{{ __('messages.vehicle_types') }}</a></li>
						<li><a href="{{ route('vehicles.index',['deleted' => '1']) }}" class="menu-item">{{ __('messages.trash') }}</a></li>
					</ul>
				</li>
				<li class="has-sub nav-item {{(in_array(Request::route()->getName(),['customers.index','customers.create','customers.edit']))
					? ' class=open':'' }}"  >
					<a href="javascript:void(0);" class="menu-item">{{ __('messages.customers') }}</a>
					<ul class="menu-content">
						<li><a href="{{ route('customers.index') }}" class="menu-item">{{ __('messages.customers') }}</a></li>

						<li><a href="{{ route('customers.index',['deleted' => '1']) }}" class="menu-item">{{ __('messages.trash') }}</a></li>
					</ul>
				</li>
				<li class="has-sub nav-item {{ (in_array(Request::route()->getName(),[
				'tours.index','tours.create','tours.edit','tour-detail',
				'tour-invoices','tour-invoice-create','tour-calendar'
				])) ? 'open' : '' }}">
					<a href="javascript:;">
						<span data-i18n="" class="menu-title">{{ __('messages.tours') }}</span>
					</a>
					<ul class="menu-content">
						<li><a href="{{ route('tours.index') }}" class="menu-item">{{ __('messages.tours') }}</a></li>
						<li><a href="{{ route('tour-calendar') }}" class="menu-item">{{__('tour.heading.calendar')}}</a></li>
						<li><a href="{{ route('tour-invoices') }}" class="menu-item">{{ __('tour_invoice.heading.index') }}</a></li>
						<li><a href="{{ route('tour-invoice-create') }}" class="menu-item">{{ __('tour.create_invoices') }}</a></li>
					</ul>
				</li>
				<li @if(Request::route()->getName() == 'offers.index') {{ ' class=open' }} @endif ><a href="{{ route('offers.index') }}" class="menu-item">{{ __('messages.offers') }}</a></li>
				<li class="{{ (in_array(Request::route()->getName(),[
				'bus-services.index','bus-services.create','bus-services.edit'])) ? 'open' : '' }}">
					<a href="{{ route('bus-services.index') }}" class="menu-item">{{ __('service.heading.index') }}</a>
				</li>
				<li class="has-sub nav-item {{ (in_array(Request::route()->getName(),[
				'v-drivers.index','v-drivers.create','v-drivers.edit',
				'hire-drivers.index','hire-drivers.create','hire-drivers.edit','hire-driver-calendar',
				'driver-invoices','driver-invoice-create'
				])) ? 'open' : '' }}">
					<a href="javascript:;">
						<span data-i18n="" class="menu-title">{{ __('messages.drivers') }}</span>
					</a>
					<ul class="menu-content">
						<li><a href="{{ route('v-drivers.index') }}" class="menu-item">{{ __('messages.drivers') }}</a></li>
						<li><a href="{{ route('hire-drivers.index') }}" class="menu-item">{{ __('messages.hire_drivers') }}</a></li>
						<li><a href="{{ route('hire-driver-calendar') }}" class="menu-item">{{ __('messages.drivers_calendar') }}</a></li>
						<li><a href="{{ route('driver-invoices') }}" class="menu-item">{{ __('driver_invoice.heading.index') }}</a></li>
						<li><a href="{{ route('driver-invoice-create') }}" class="menu-item">{{ __('tour.create_invoices') }}</a></li>
					</ul>
				</li>
				<li @if(Request::route()->getName() == 'reports') {{ ' class=open' }} @endif ><a href="{{ route('change-password') }}" class="menu-item">{{__('messages.change_password')}}</a></li>
{{--				<li @if(Request::route()->getName() == 'reports') {{ ' class=open' }} @endif ><a href="javascript:;" class="menu-item">{{__('messages.reports')}}</a></li>--}}
{{--				<li @if(Request::route()->getName() == 'settings') {{ ' class=open' }} @endif ><a href="javascript:;" class="menu-item">{{__('messages.settings')}}</a></li>--}}
			</ul>
		</div>
	</div>
	<div class="sidebar-background"></div>
</div>