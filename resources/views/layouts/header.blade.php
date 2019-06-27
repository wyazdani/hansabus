<nav class="navbar navbar-expand-lg navbar-light bg-faded">
	<div class="container-fluid">


		<div class="navbar-header">
			@if(Auth::check())
			<button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a class="open-navbar-container"><i class="ft-more-vertical"></i></a></span>{{--<a id="navbar-fullscreen" href="javascript:;" class="mr-2 display-inline-block apptogglefullscreen"><i class="ft-maximize blue-grey darken-4 toggleClass"></i>
				<p class="d-none">fullscreen</p>
			</a>--}}
			@endif
		</div>
		<div class="navbar-container">
			<div id="navbarSupportedContent" class="collapse navbar-collapse">

				@if(Auth::check())
				<ul class="navbar-nav">

{{--					<li class="nav-item mt-1 navbar-search text-left dropdown"><a id="search" href="#" data-toggle="dropdown" class="nav-link dropdown-toggle"><i class="ft-search blue-grey darken-4"></i></a>--}}
{{--						<div aria-labelledby="search" class="search dropdown-menu dropdown-menu-right">--}}
{{--							<div class="arrow_box_right">--}}
{{--								<form role="search" class="navbar-form navbar-right">--}}
{{--									<div class="position-relative has-icon-right mb-0">--}}
{{--										<input id="navbar-search" type="text" placeholder="Search" class="form-control" />--}}
{{--										<div class="form-control-position navbar-search-close"><i class="ft-x"></i>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</form>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</li>--}}

					<li class="dropdown nav-item mt-1"><a id="dropdownBasic" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle"><i class="ft-flag blue-grey darken-4"></i><span class="selected-language d-none"></span></a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="arrow_box_right">
								<a href="{{ url('locale/en') }}" class="dropdown-item py-1"><img src="{{asset('images/us.png')}}" alt="English Flag" class="langimg" /><span>
										English</span></a>
								<a href="{{ url('locale/de') }}" class="dropdown-item py-1"><img src="{{asset('images/es.png')}}" alt="Spanish Flag" class="langimg" /><span>
										German</span></a>
								{{--<a href="javascript:;" class="dropdown-item py-1"><img src="{{asset('images/br.png')}}" alt="Portuguese Flag" class="langimg" /><span>
										Portuguese</span></a>
								<a href="javascript:;" class="dropdown-item"><img src="{{asset('images/de.png')}}" alt="French Flag" class="langimg" /><span>
										French</span></a></div>--}}
						</div>
					</li>

					<li class="dropdown nav-item mr-0"><a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-user-link dropdown-toggle"><span class="avatar avatar-online">
								<img id="navbar-avatar" src="{{asset('images/avatar-s-3.jpg')}}" alt="avatar" /></span>
							<p class="d-none">User Settings</p>
						</a>
						<div aria-labelledby="dropdownBasic3" class="dropdown-menu dropdown-menu-right">
							<div class="arrow_box_right">
{{--								<a href="user-profile-page.html" class="dropdown-item py-1"><i class="ft-edit mr-2"></i><span>{{__('messages.my_profile')}}</span></a>--}}
{{--								<a href="javascript:;" class="dropdown-item py-1"><i class="ft-settings mr-2"></i><span>{{__('messages.settings')}}</span></a>--}}
{{--								<div class="dropdown-divider"></div>--}}
								
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
             document.getElementById('logout-form').submit();" role="menuitem">
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