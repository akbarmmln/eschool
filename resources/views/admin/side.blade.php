<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li>
					<a href="javascript:void(0);" class="d-flex align-items-center border bg-white rounded p-2 mb-4">
						<img src="{{ asset('assets/img/education_2.svg') }}" 
							class="avatar avatar-md img-fluid rounded"
							alt="Profile">
						<span class="text-dark ms-2 fw-normal">JURNAL MENGAJAR</span>
					</a>
				</li>
			</ul>
			<ul>
				<li>
					<ul>
						<li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="ti ti-layout-dashboard"></i><span>Beranda</span></a></li>
						<li class="{{ request()->routeIs('siswa*') ? 'active' : '' }}"><a href="{{ route('siswa') }}"><i class="ti ti-school"></i><span>Siswa</span></a></li>
						<li class="{{ request()->routeIs('guru') ? 'active' : '' }}"><a href="{{ route('guru') }}"><i class="ti ti-users"></i><span>Guru</span></a></li>
						<li class="{{ request()->routeIs('tingkat-kelas*') ? 'active' : '' }}"><a href="{{ route('tingkat-kelas') }}"><i class="ti ti-star"></i><span>Tingkat Kelas</span></a></li>
						<li class="{{ request()->routeIs('kelas*') ? 'active' : '' }}"><a href="{{ route('kelas') }}"><i class="ti ti-building"></i><span>Kelas</span></a></li>
						<li class="{{ request()->routeIs('role-akses') ? 'active' : '' }}"><a href="{{ route('role-akses') }}"><i class="ti ti-shield-lock"></i><span>Role Akses</span></a></li>
						<li class="{{ request()->routeIs('pengaturan') ? 'active' : '' }}"><a href="{{ route('pengaturan') }}"><i class="ti ti-settings"></i><span>Pengaturan</span></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- /Sidebar -->