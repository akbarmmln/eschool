<!-- Header -->
<div class="header">

	<!-- Logo -->
	<div class="header-left active">
		<a href="{{ route('dashboard') }}" class="logo logo-normal logo-title">
			<img src="{{ asset('assets/img/education_1.png') }}" style="width:200px; height:50px; margin-top:5px" alt="Logo">
		</a>
		<a href="{{ route('dashboard') }}" class="logo-small">
			<img src="{{ asset('assets/img/education_2.svg') }}" style="width:50px; height:50px; margin-top:5px"" alt="Logo">
		</a>
		<a href="{{ route('dashboard') }}" class="dark-logo">
			<img src="{{ asset('assets/img/logo-dark.svg') }}" alt="Logo">
		</a>
		<a id="toggle_btn" href="javascript:void(0);">
			<i class="ti ti-menu-deep"></i>
		</a>
	</div>
	<!-- /Logo -->

	<a id="mobile_btn" class="mobile_btn" href="#sidebar">
		<span class="bar-icon">
			<span></span>
			<span></span>
			<span></span>
		</span>
	</a>

	<div class="header-user">
		<div class="nav user-menu">

			<!-- Search -->
			<div class="nav-item nav-search-inputs me-auto">
				<div class="top-nav-search">
				</div>
			</div>
			<!-- /Search -->

			<div class="d-flex align-items-center">
				<div class="dropdown ms-1">
					<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center"
						data-bs-toggle="dropdown">
						<span class="avatar avatar-md rounded">
							<img src="{{ asset('assets/img/profiles/avatar.svg') }}" alt="Img" class="img-fluid">
						</span>
					</a>
					<div class="dropdown-menu">
						<div class="d-block">
							<!-- <div class="d-flex align-items-center p-2">
								<span class="avatar avatar-md me-2 online avatar-rounded">
									<img src="{{ asset('assets/img/profiles/avatar-27.jpg') }}" alt="img">
								</span>
								<div>
									<h6 class="">Kevin Larry</h6>
									<p class="text-primary mb-0">Administrator</p>
								</div>
							</div> -->
							<hr class="m-0">
							<a class="dropdown-item d-inline-flex align-items-center p-2" href="{{ route('profile') }}">
								<i class="ti ti-user-circle me-2"></i>Profile Saya</a>
							<hr class="m-0">
							<a class="dropdown-item d-inline-flex align-items-center p-2" href="{{ route('logout') }}"><i
									class="ti ti-login me-2"></i>Keluar</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!-- Mobile Menu -->
	<div class="dropdown mobile-user-menu">
		<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
			aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
		<div class="dropdown-menu dropdown-menu-end">
			<a class="dropdown-item" href="{{ route('profile') }}">Profile Saya</a>
			<a class="dropdown-item" href="{{ route('logout') }}">Keluar</a>
		</div>
	</div>
	<!-- /Mobile Menu -->
</div>
<!-- /Header -->