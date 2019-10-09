<nav class="navbar navbar-expand-lg navbar-light bg-faded d-print-none">
	<div class="container-fluid">
		<div class="navbar-header">
			@if(Auth::check())
			<button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a class="open-navbar-container"><i class="ft-more-vertical"></i></a></span>
			@endif
		</div>
		<div class="navbar-container">
			<div id="navbarSupportedContent" class="collapse navbar-collapse">

				@if(Auth::check())
				<ul class="navbar-nav">

					<li class="dropdown nav-item mt-1"><a id="dropdownBasic" href="javascript:void(0)" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle"><i class=" blue-grey darken-4"></i><span class="selected-language d-none"></span>{{__('messages.lang')}}</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="arrow_box_right">
								<a href="{{ url('locale/en') }}" class="dropdown-item py-1"><img src="{{asset('images/us.png')}}" alt="English Flag" class="langimg" /><span>
										English</span></a>
								<a href="{{ url('locale/de') }}" class="dropdown-item py-1"><img src="{{asset('images/de.png')}}" alt="Spanish Flag" class="langimg" /><span>
										German</span></a>
							</div>
						</div>
					</li>
					<li class="dropdown nav-item mr-0"><a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-user-link dropdown-toggle"><span class="avatar avatar-online">
								<img id="navbar-avatar" src="{{asset('images/avatar-s-3.jpg')}}" alt="avatar" /></span>
							<p class="d-none">User Settings</p>
						</a>
						<div aria-labelledby="dropdownBasic3" class="dropdown-menu dropdown-menu-right">
							<div class="arrow_box_right">
								<a class="dropdown-item" href="{{ route('logout') }}"
								   		onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="menuitem">
									<i class="ft-power mr-2"></i> {{__('messages.logout')}}</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>

							</div>
						</div>
					</li>
				</ul>
				@endif
			</div>
		</div>
	</div>
</nav>