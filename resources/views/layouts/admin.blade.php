<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Favicon -->
    <link href="{{ asset('img/logo/aruLogo.png') }}" rel="icon" type="image/png">
    
    @guest
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    @endguest
	
    @include('layouts.basics.admin.header')
</head>
<body>
    <div id="global-loader" >
        <div class="preloader-single shadow-inner">
            <div class="ts_preloading_box">
                <div id="ts-preloader-absolute17">
                    <div class="tsperloader17" id="tsperloader17_one"></div>
                    <div class="tsperloader17" id="tsperloader17_two"></div>
                    <div class="tsperloader17" id="tsperloader17_three"></div>
                    <div class="tsperloader17" id="tsperloader17_four"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="page">
		<div class="page-main">
			@auth
            <!-- Sidebar menu-->
            <aside class="app-sidebar">
                @include('layouts.basics.admin.side-nav')
            </aside>
            <!-- Sidebar menu-->
			@endauth

			<!-- Top navbar -->
			<nav class="navbar navbar-top  navbar-expand-md navbar-dark" id="navbar-main">
				@include('layouts.basics.top-nav')
			</nav>
			<!-- Top navbar-->

			@guest
				<div class="container-fluid pt-8">
					@yield('content')
				</div>
			@endguest

			@auth
			<!-- app-content-->
			<div class="app-content ">
				<div class="side-app">
					<div class="main-content">

						<!-- Page content -->
						<div class="container-fluid pt-6" style="margin-top: 20px">
                            @yield('content')
							<!-- Footer -->
							<!-- <footer class="footer">
								<div class="row align-items-center justify-content-xl-between">
									<div class="col-xl-6">
										<div class="copyright text-center text-xl-left text-muted">
											<p class="text-sm font-weight-500">Copyright 2018 © All Rights Reserved.Dashboard Template</p>
										</div>
									</div>
									<div class="col-xl-6">
										<p class="float-right text-sm font-weight-500"><a href="www.templatespoint.net">Templates Point</a></p>
									</div>
								</div>
							</footer> -->
							<!-- Footer -->
						</div>
					</div>
				</div>
			</div>
			<!-- app-content-->
    		@endauth
		</div>
	</div>
    @include('layouts.basics.admin.footer')

	@yield('scripts')
</body>
</html>
