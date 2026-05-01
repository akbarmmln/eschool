<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Preskool - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
	<meta name="author" content="Dreams technologies - Bootstrap Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Akademik - Guru</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/education_2.svg') }}">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/icons/feather/feather.css') }}">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.css') }}">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

	<!-- animation CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

	<!-- Owl Carousel CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.theme.default.min.css') }}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.css"/>
</head>

<body>
	<div id="global-loader">
		<div class="page-loader"></div>
	</div>

	<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
		<div id="globalToast" class="toast align-items-center border-0" role="alert">
			<div class="d-flex">
				<div class="toast-body" id="globalToastBody">
					<!-- message here -->
				</div>
				<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
			</div>
		</div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">
        @include('guru.header')
        @include('guru.side')

        @yield('content')
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" ></script>

	<!-- Bootstrap Core JS -->
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" ></script>

	<!-- Daterangepikcer JS -->
	<script src="{{ asset('assets/js/moment.js') }}" ></script>
	<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}" ></script>
	<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" ></script>

	<!-- Feather Icon JS -->
	<script src="{{ asset('assets/js/feather.min.js') }}" ></script>

	<!-- Slimscroll JS -->
	<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}" ></script>

	<!-- Chart JS -->
	<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}" ></script>
	<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}" ></script>

	<!-- Select2 JS -->
	<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" ></script>

	<!-- Counter JS -->
	<script src="{{ asset('assets/plugins/countup/jquery.counterup.min.js') }}" ></script>
	<script src="{{ asset('assets/plugins/countup/jquery.waypoints.min.js') }}" >	</script>

	<!-- Modal JS -->
	<script src="{{ asset('assets/js/modal.js') }}"></script>

	<!-- Custom JS -->
	<script src="{{ asset('assets/js/script.js') }}" ></script>
</html>