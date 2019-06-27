<div data-active-color="white" data-background-color="black"
	 data-image="{{ asset('images/01.jpg') }}"
	 class="app-sidebar">

	<div class="sidebar-header">
		<div class="logo clearfix"><a href="{{ route('home') }}" class="logo-text float-left">
				<div class="logo-img"><img src="{{ asset('images/logo.png') }}" alt="Convex Logo" /></div>
				<span class="text align-middle">E-Coach</span>
			</a>
		</div>
	</div>

	<div class="sidebar-content">
		<div class="nav-container">
			<ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
				<li @if(Request::route()->getName() == 'home') {{ ' class=open' }} @endif ><a href="{{ route('home') }}" class="menu-item">{{ __('messages.dashboard') }}</a></li>

				<li @if(in_array(Request::route()->getName(),[
				'vehicles.index','vehicles.create','vehicles.edit',
				'vehicle-type.index','vehicle-type.create','vehicle-type.edit'
				]))
					{{ ' class=open' }} @endif
					class="has-sub nav-item">
					<a href="javascript:;">
						<span data-i18n="" class="menu-title">{{ __('messages.vehicles') }}</span>
					</a>
					<ul class="menu-content">
						<li><a href="{{ route('vehicles.index') }}" class="menu-item">{{ __('messages.vehicles') }}</a>
						</li>
						<li><a href="{{ route('vehicle-type.index') }}" class="menu-item">{{ __('messages.vehicle_types') }}</a>
						</li>
						<li><a href="javascript:;" class="menu-item">{{ __('messages.maintenance') }}</a>
						</li>
{{--						<li><a href="{{ url('/vehicle-maintinance') }}" class="menu-item">Maintinance</a>--}}
{{--						</li>--}}
					</ul>
				</li>
				<li @if(in_array(Request::route()->getName(),['drivers.index','drivers.create','drivers.edit']))
					{{ ' class=open' }} @endif ><a href="{{ route('v-drivers.index') }}" class="menu-item">{{ __('messages.drivers') }}</a></li>

				<li @if(in_array(Request::route()->getName(),['customers.index','customers.create','customers.edit']))
					{{ ' class=open' }} @endif ><a href="{{ route('customers.index') }}" class="menu-item">{{ __('messages.customers') }}</a></li>

				<li @if(in_array(Request::route()->getName(),['tours.index','tours.create','tours.edit','tour-detail']))
					{{ ' class=open' }} @endif ><a href="{{ route('tours.index') }}" class="menu-item">{{ __('messages.tours') }}</a></li>


				<li @if(in_array(Request::route()->getName(),['invoices']))
					{{ ' class=open' }} @endif><a href="{{ route('invoices') }}" class="menu-item">{{__('messages.invoices')}}</a></li>


				<li @if(in_array(Request::route()->getName(),['tour-calendar']))
					{{ ' class=open' }} @endif ><a href="{{ route('tour-calendar') }}" class="menu-item">{{__('messages.calendar')}}</a></li>

{{--				<li @if(Request::route()->getName() == 'settings') {{ ' class=open' }} @endif ><a href="{{ url('/settings') }}" class="menu-item">Settings</a></li>--}}
{{--				<li @if(Request::route()->getName() == 'reports') {{ ' class=open' }} @endif ><a href="{{ url('/reports') }}" class="menu-item">Reports</a></li>--}}

				<li @if(Request::route()->getName() == 'settings') {{ ' class=open' }} @endif ><a href="javascript:;" class="menu-item">{{__('messages.settings')}}</a></li>
				<li @if(Request::route()->getName() == 'reports') {{ ' class=open' }} @endif ><a href="javascript:;" class="menu-item">{{__('messages.reports')}}</a></li>

			</ul>
		</div>
	</div>

	<div class="sidebar-background"></div>

</div>