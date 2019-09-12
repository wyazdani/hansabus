<!DOCTYPE html>
<html lang="de" class="loading">
@include('layouts.head')

@if(Auth::check())
<body data-col="2-columns" class=" 2-columns ">
	<div class="wrapper">		
		@if(Auth::check())
			@include('layouts.sidebar')	
		@endif

		@include('layouts.header')
		<div class="main-panel">
			<div class="main-content">
				<div class="content-wrapper">
					<div class="container-fluid" id="app8">
						@yield('content')                    
					</div>
				</div>
			</div>
			@include('layouts.footer')
		</div>		
	</div>
	@include('layouts.js')
	@yield('pagejs')
</body>
@else
<body data-col="1-column" class=" 1-column  blank-page blank-page">
	@yield('content')
</body>		
@endif
</html>