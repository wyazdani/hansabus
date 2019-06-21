<div data-active-color="white" data-background-color="black"
	 data-image="{{ asset('images/01.jpg') }}"
	 class="app-sidebar">

	<div class="sidebar-header">
		<div class="logo clearfix"><a href="{{ route('home') }}" class="logo-text float-left">
				<div class="logo-img"><img src="{{ asset('images/logo.png') }}" alt="Convex Logo" /></div>
				<span class="text align-middle">E-Coach<br>Managment</span>
			</a>
		</div>
	</div>

	<div class="sidebar-content">
		<div class="nav-container">
			<ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
				<li @if(Request::route()->getName() == 'home') {{ ' class=open' }} @endif ><a href="{{ route('home') }}" class="menu-item">Dashboard</a></li>

				<li @if(in_array(Request::route()->getName(),[
				'vehicles.index','vehicles.create','vehicles.edit',
				'vehicle-type.index','vehicle-type.create','vehicle-type.edit'
				]))
					{{ ' class=open' }} @endif
					class="has-sub nav-item">
					<a href="javascript:;">
						<span data-i18n="" class="menu-title">Vehicles</span>
					</a>
					<ul class="menu-content">
						<li><a href="{{ route('vehicles.index') }}" class="menu-item">Vehicles</a>
						</li>
						<li><a href="{{ route('vehicle-type.index') }}" class="menu-item">Vehicle Types</a>
						</li>
						<li><a href="javascript:;" class="menu-item">Maintinance</a>
						</li>
{{--						<li><a href="{{ route('vehicle-maintinance.index') }}" class="menu-item">Maintinance</a>--}}
{{--						</li>--}}
					</ul>
				</li>
				<li @if(in_array(Request::route()->getName(),['v-drivers.index','v-drivers.create','v-drivers.edit']))
					{{ ' class=open' }} @endif ><a href="{{ route('v-drivers.index') }}" class="menu-item">Drivers</a></li>

				<li @if(in_array(Request::route()->getName(),['customers.index','customers.create','customers.edit']))
					{{ ' class=open' }} @endif ><a href="{{ route('customers.index') }}" class="menu-item">Customers</a></li>

				<li @if(in_array(Request::route()->getName(),['tours.index','tours.create','tours.edit','tour-detail']))
					{{ ' class=open' }} @endif ><a href="{{ route('tours.index') }}" class="menu-item">Tours</a></li>

				<li @if(in_array(Request::route()->getName(),['tour-calendar']))
					{{ ' class=open' }} @endif ><a href="{{ route('tour-calendar') }}" class="menu-item">Calendar</a></li>

{{--				<li @if(Request::route()->getName() == 'settings') {{ ' class=open' }} @endif ><a href="{{ url('/settings') }}" class="menu-item">Settings</a></li>--}}
{{--				<li @if(Request::route()->getName() == 'reports') {{ ' class=open' }} @endif ><a href="{{ url('/reports') }}" class="menu-item">Reports</a></li>--}}

				<li @if(Request::route()->getName() == 'settings') {{ ' class=open' }} @endif ><a href="javascript:;" class="menu-item">Settings</a></li>
				<li @if(Request::route()->getName() == 'reports') {{ ' class=open' }} @endif ><a href="javascript:;" class="menu-item">Reports</a></li>

			</ul>
		</div>
	</div>

	<div class="sidebar-background"></div>

</div>