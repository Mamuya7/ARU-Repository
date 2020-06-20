	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">

	<!-- Icons -->
	<link href="{{ asset('ansta/css/icons.css') }}" rel="stylesheet">

	<!--Bootstrap.min css-->
	<link rel="stylesheet" href="{{ asset('ansta/plugins/bootstrap/css/bootstrap.min.css') }}">

	<!-- Dashboard CSS -->
	<link href="{{ asset('ansta/css/dashboard.css') }}" rel="stylesheet" type="text/css">

	<!-- Tabs CSS -->
	<link href="{{ asset('ansta/plugins/tabs/style.css') }}" rel="stylesheet" type="text/css">

	<!-- Custom scroll bar css-->
	<link href="{{ asset('ansta/plugins/customscroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />

	<!-- Sidemenu Css -->
	<link href="{{ asset('ansta/plugins/toggle-sidebar/css/sidemenu.css') }}" rel="stylesheet">
    <!-- Preloader CSS
		============================================ -->
	<link rel="stylesheet" href="{{ asset('css/preloader/preloader-style.css')}}">
	<link rel="stylesheet" href="{{ asset('css/top-nav.css')}}">
	@guest
	<link href="{{ asset('fonts/montserrat/css2?family=Montserrat:wght@200;300;400;500;600;700;800;900&display=swap')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/login.css')}}">
	@endguest