<div data-active-color="white" data-background-color="black"
	 data-image="{{ asset('images/01.jpg') }}"
	 class="app-sidebar">

	<div class="sidebar-header">
		<div class="logo clearfix"><a href="{{ url('/') }}" class="logo-text float-left">
				<div class="logo-img"><img src="{{ asset('images/logo.png') }}" alt="Convex Logo" /></div>
				<span class="text align-middle">E-Coach<br>Managment</span>
			</a>
		</div>
	</div>

	<div class="sidebar-content">
		<div class="nav-container">
			<ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
				<li @if(Request::route()->getName() == 'home') {{ ' class=open' }} @endif ><a href="{{ url('/') }}" class="menu-item">Dashboard</a></li>
				<li @if(in_array(Request::route()->getName(),['vehicles.index','vehicles.create','vehicles.edit']))
					{{ ' class=open' }} @endif
					class="has-sub nav-item">
					<a href="javascript:;">
						<span data-i18n="" class="menu-title">Vehicles</span>
					</a>
					<ul class="menu-content">
						<li><a href="{{ url('/vehicles') }}" class="menu-item">Vehicles</a>
						</li>
						<li><a href="{{ url('/vehicle-type') }}" class="menu-item">Vehicle Types</a>
						</li>
						<li><a href="{{ url('/vehicle-maintinance') }}" class="menu-item">Maintinance</a>
						</li>
					</ul>
				</li>
				<li @if(in_array(Request::route()->getName(),['drivers.index','drivers.create','drivers.edit']))
					{{ ' class=open' }} @endif ><a href="{{ url('/drivers') }}" class="menu-item">Drivers</a></li>

				<li @if(in_array(Request::route()->getName(),['customers.index','customers.create','customers.edit']))
					{{ ' class=open' }} @endif ><a href="{{ url('/customers') }}" class="menu-item">Customers</a></li>
				<li @if(in_array(Request::route()->getName(),['tours.index','tours.create','tours.edit']))
					{{ ' class=open' }} @endif ><a href="{{ url('/tours') }}" class="menu-item">Tours</a></li>
				<li @if(Request::route()->getName() == 'settings') {{ ' class=open' }} @endif ><a href="{{ url('/settings') }}" class="menu-item">Settings</a></li>
				<li @if(Request::route()->getName() == 'reports') {{ ' class=open' }} @endif ><a href="{{ url('/reports') }}" class="menu-item">Reports</a></li>
			</ul>
		</div>
	</div>

	<div class="sidebar-background"></div>

</div>