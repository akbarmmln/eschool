<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li>
					<a href="javascript:void(0);" class="d-flex align-items-center border bg-white rounded p-2 mb-4">
						<img src="{{ !empty(session('image')) ? session('image') : asset('assets/img/image-in-picture.svg') }}" 
							class="avatar avatar-md img-fluid rounded"
							alt="Profile">
						<span class="text-dark ms-2 fw-normal">{{ session('nama_sekolah_sidebar') }}</span>
					</a>
				</li>
			</ul>
			<ul>
				<li>
					<ul>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- /Sidebar -->