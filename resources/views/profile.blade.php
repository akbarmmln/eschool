@extends(
    $role == '0' ? 'admin.app' : 
    ($role == '1' ? 'guru.app' : 'ortu.app')
)
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Profile</h3>
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Akademik</a>
						</li>
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Pengaturan</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Profile</li>
					</ol>
				</nav>
			</div>
		</div>
		<!-- /Page Header -->

                <div id="pagefailed" style="display: none;">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div id="status_page" class="col-xxl-6 col-xl-6 col-lg-8 col-md-10 col-sm-12">
                                <div class="card bg-white border-0">
                                    <div class="alert custom-alert1 alert-warning">
                                        <div class="text-center px-5 pb-0">
                                            <div class="custom-alert-icon">
                                                <i class="feather-alert-triangle flex-shrink-0"></i>
                                            </div>
                                            <h5 class="fw-bold text-uppercase text-warning mb-3">WARNING</h5>
                                            <p id="text_result" class="text-black mb-1"></p>
                                            <a href="#" id="btnRefresh" class="btn btn-sm btn-warning m-1">Coba kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div id="loadingSpinner" class="text-center my-3" style="display: block;">
                    <button id="loadingSpinner" class="btn btn-info-light" type="button" disabled="">
                        <span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
                            Memuat data...
                    </button>
                </div>

				<div class="d-md-flex d-block mt-3">
					<div id="admin_guru_app" class="d-none flex-fill ps-0 border-0">
							<div class="d-md-flex">
								<div class="flex-fill">
									<div class="card">
										<div class="card-header d-flex justify-content-between align-items-center">
											<h5><b>Informasi Pribadi</b></h5>
											<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_personal_information_admin_guru"><i class="ti ti-edit me-2"></i>Ubah</a>
										</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-id"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">NIY</h6>
                                                            <p id="niy" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-calendar-time"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Tanggal Lahir</h6>
                                                            <p id="tgl_lahir" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-id-badge"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Nama Lengkap</h6>
                                                            <p id="nama_lengkap" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-friends"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Jenis Kelamin</h6>
                                                            <p id="jenis_kelamin" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-school"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Pendidikan</h6>
                                                            <p id="pendidikan" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-phone"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Nomor Telepon</h6>
                                                            <p id="no_telp" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="card">
										<div class="card-header d-flex justify-content-between align-items-center">
											<h5><b>Informasi Alamat</b></h5>
											<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_address_information_admin_guru"><i class="ti ti-edit me-2"></i>Ubah</a>
										</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-map-2"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Alamat / Nama Jalan</h6>
                                                            <p id="alamat" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-home-link"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">RT / RW</h6>
                                                            <p id="rt_rw" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-layout-distribute-horizontal"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Kecamatan</h6>
                                                            <p id="kecamatan" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="bg-light-300 d-flex align-items-center p-3 mb-3">
                                                        <div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
                                                            <i class="ti ti-layout-distribute-horizontal"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Kelurahan</h6>
                                                            <p id="kelurahan" class="mb-0">-</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="card">
										<div class="card-header d-flex justify-content-between align-items-center">
											<h5>Email</h5>
											<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_email"><i class="ti ti-edit me-2"></i>Ubah</a>
										</div>
									</div>
									<div class="card">
										<div class="card-header d-flex justify-content-between align-items-center">
											<h5>Password</h5>
											<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_password"><i class="ti ti-edit me-2"></i>Ubah</a>
										</div>
									</div>
								</div>
							</div>
					</div>

                    <div id="ortu_app" class="d-none flex-fill ps-0 border-0">
                        <div class="d-md-flex">
                            <div class="flex-fill">
									<div class="card">
										<div class="card-header d-flex justify-content-between align-items-center">
											<h5><b>Detail Wali Murid</b></h5>
											<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ubah_personal_wali_murid"><i class="ti ti-edit me-2"></i>Ubah</a>
										</div>
                                        <div class="card-body">
                                            <div class="border rounded p-3 pb-0 mb-3">
                                                <div class="row">
                                                    <div class="col-sm-6 col-lg-4">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="ms-2 overflow-hidden">
                                                                <h6 id="ortu_ayah" class="text-truncate">-</h6>
                                                                <p class="text-primary">Ayah</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-lg-4">
                                                        <div class="mb-3">
                                                            <p class="text-dark fw-medium mb-1">Pekerjaan</p>
                                                            <p id="ocup_ayah">-</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-lg-4">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="mb-3 overflow-hidden me-3">
                                                                <p class="text-dark fw-medium mb-1">Email</p>
                                                                <p id="ortu_email1" class="text-truncate">-</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border rounded p-3 pb-0 mb-3">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-6 ">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="ms-2 overflow-hidden">
                                                                <h6 id="ortu_ibu" class="text-truncate">-</h6>
                                                                <p class="text-primary">Ibu</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6 ">
                                                        <div class="mb-3">
                                                            <p class="text-dark fw-medium mb-1">Pekerjaan</p>
                                                            <p id="ocup_ibu">-</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="mb-3 overflow-hidden me-3">
                                                                <p class="text-dark fw-medium mb-1">Email</p>
                                                                <p id="ortu_email2" class="text-truncate">-</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
									</div>
									<div class="card">
										<div class="card-header d-flex justify-content-between align-items-center">
											<h5>Email</h5>
											<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_email"><i class="ti ti-edit me-2"></i>Ubah</a>
										</div>
									</div>
									<div class="card">
										<div class="card-header d-flex justify-content-between align-items-center">
											<h5>Password</h5>
											<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_password"><i class="ti ti-edit me-2"></i>Ubah</a>
										</div>
									</div>
                            </div>
                        </div>
                    </div>
				</div>
	</div>
</div>
<!-- /Page Wrapper -->
 
		<!-- Edit Profile -->
		<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="edit_personal_information_admin_guru">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Informasi Pribadi</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">Nama Lengkap</label>
									<input type="text" class="form-control nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap">
								</div>
								<div class="mb-3">
									<label class="form-label">Jenis Kelamin</label>
									<select name="jenis_kelamin" class="form-control jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
										<option value="L">Laki-Laki</option>
										<option value="P">Perempuan</option>
									</select>
                                </div>
								<div class="mb-3">
									<label class="form-label">Tanggal Lahir</label>
									<div class="input-icon position-relative">
										<span class="input-icon-addon">
											<i class="ti ti-calendar"></i>
										</span>
										<input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control datepickerBuatan">
									</div>
								</div>
								<div class="mb-3">
									<label class="form-label">Pendidikan</label>
									<input type="text" class="form-control pendidikan" name="pendidikan" placeholder="Pendidikan">
								</div>
								<div class="mb-3">
									<label class="form-label">Nomor Telepon</label>
									<input type="text" class="form-control nomot_telp" name="nomot_telp" placeholder="Nomor Telepon">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-light me-2 btn_tutup" data-bs-dismiss="modal">Tutup</a>
						<button type="submit" class="btn btn-primary btn_simpan">Simpan Perubahan</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /Edit Profile -->

		<!-- Edit Profile -->
		<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="edit_address_information_admin_guru">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Informasi Alamat</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat / Nama Jalan</label>
                                    <input type="text" name="alamat" class="form-control alamat" placeholder="Alamat / Nama Jalan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No RT</label>
                                    <input type="text" name="no_rt" class="form-control no_rt" placeholder="No RT">
                                </div>											
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No RW</label>
                                    <input type="text" name="no_rw" class="form-control no_rw" placeholder="No RW">
                                </div>											
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control kecamatan" placeholder="Kecamatan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kelurahan</label>
                                    <input type="text" name="kelurahan" class="form-control kelurahan" placeholder="Kelurahan">
                                </div>
                            </div>
                        </div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-light me-2 btn_tutup" data-bs-dismiss="modal">Tutup</a>
						<button type="submit" class="btn btn-primary btn_simpan">Simpan Perubahan</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /Edit Profile -->

		<!-- Change Password -->
		<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="edit_password">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Password</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">Password lama</label>
									<div class="pass-group d-flex">
										<input type="password" class="pass-input form-control pass_lama">
										<span class="ti toggle-password ti-eye-off"></span>
									</div>
								</div>
								<div class="mb-3">
									<label class="form-label">Password baru</label>
									<div class="pass-group d-flex">
										<input type="password" class="pass-inputs form-control pass_baru">
										<span class="ti toggle-passwords ti-eye-off"></span>
									</div>
								</div>
								<div class="mb-0">
									<label class="form-label">Konfirmasi password baru</label>
									<div class="pass-group d-flex">
										<input type="password" class="pass-inputa form-control pass_baru_konfirm">
										<span class="ti toggle-passworda ti-eye-off"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Tutup</a>
						<button type="submit" class="btn btn-primary btn_simpan">Simpan Perubahan</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /Change Password -->

		<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="ubah_personal_wali_murid">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Informasi Pribadi</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">Nama Ayah</label>
									<input type="text" class="form-control nama_ayah" name="nama_ayah" placeholder="Nama Lengkap">
								</div>
								<div class="mb-3">
									<label class="form-label">Nama Ibu</label>
									<input type="text" class="form-control nama_ibu" name="nama_ibu" placeholder="Nama Lengkap">
								</div>
								<div class="mb-3">
									<label class="form-label">Pekerjaan Ayah</label>
									<input type="text" class="form-control ocup_ayah" name="ocup_ayah" placeholder="Pekerjaan">
								</div>
								<div class="mb-3">
									<label class="form-label">Pekerjaan Ayah</label>
									<input type="text" class="form-control ocup_ibu" name="ocup_ibu" placeholder="Pekerjaan">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-light me-2 btn_tutup" data-bs-dismiss="modal">Tutup</a>
						<button type="submit" class="btn btn-primary btn_simpan">Simpan Perubahan</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="edit_email">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Email</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">Email Saat Ini</label>
									<input type="text" readonly class="form-control email_now" name="email_now" placeholder="Email">
								</div>
								<div class="mb-3">
									<label class="form-label">Email Baru</label>
									<input type="text" class="form-control email_new" name="email_new" placeholder="Email">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-light me-2 btn_tutup" data-bs-dismiss="modal">Tutup</a>
						<button type="submit" class="btn btn-primary btn_simpan">Simpan Perubahan</button>
					</div>
				</div>
			</div>
		</div>

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.js"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    const role = @json($role);
    const pagefailed = document.getElementById("pagefailed");
    const spinner = document.getElementById("loadingSpinner");
    const admin_guru_app = document.getElementById('admin_guru_app')
    const ortu_app = document.getElementById('ortu_app')
    
    const editPiAdminGuruModals = document.getElementById('edit_personal_information_admin_guru')
    const btnSimpanPiAdminGuru = editPiAdminGuruModals.querySelector('.btn_simpan')

    const editPiWalMurModals = document.getElementById('ubah_personal_wali_murid')
    const btnSimpanPiWalMur = editPiWalMurModals.querySelector('.btn_simpan')
    
    const editAiAdminGuruModals = document.getElementById('edit_address_information_admin_guru')
    const btnSimpanAiAdminGuru = editAiAdminGuruModals.querySelector('.btn_simpan')

    const editEmailModals = document.getElementById('edit_email')
    const btnSimpanEditEmail = editEmailModals.querySelector('.btn_simpan')
    
    const editPassword = document.getElementById('edit_password')
    const btnSimpanEp = editPassword.querySelector('.btn_simpan')

    let temp = {
        niy: null,
        tanggal_lahir: null,
        nama: null,
        jenis_kelamin: null,
        pendidikan: null,
        nomor_handphone: null,
        alamat: null,
        rt: null,
        rw: null,
        kecamatan: null,
        kelurahan: null,
        email: null
    }

    let tempD2 = {
        nama_ayah: null,
        nama_ibu: null,
        pekerjaan_ayah: null,
        pekerjaan_ibu: null,
        email: null
    }

    document.querySelector(".datepickerBuatan").addEventListener("keydown", function(e){
        e.preventDefault();
    });

    editPassword.addEventListener('hidden.bs.modal', function () {
        const passLamaValue = editPassword.querySelector('.pass_lama');
        const passBaruValue = editPassword.querySelector('.pass_baru');
        const passBaruKonfirmValue = editPassword.querySelector('.pass_baru_konfirm');

        if (passLamaValue) passLamaValue.value = ''
        if (passBaruValue) passBaruValue.value = ''
        if (passBaruKonfirmValue) passBaruKonfirmValue.value = ''
    })
    editPassword.addEventListener('show.bs.modal', function () {
        const validator = initFormValidation(editPassword, {
            btnSelector: '.btn_simpan',
            fields: [
                '.pass_lama',
                '.pass_baru',
                '.pass_baru_konfirm'
            ]
        });
        editPassword._validator = validator;
    })

    editAiAdminGuruModals.addEventListener('hidden.bs.modal', function () {})
    editAiAdminGuruModals.addEventListener('show.bs.modal', function () {
        const alamatValue = editAiAdminGuruModals.querySelector('.alamat');
        const noRtValue = editAiAdminGuruModals.querySelector('.no_rt');
        const noRwValue = editAiAdminGuruModals.querySelector('.no_rw');
        const kecamatanValue = editAiAdminGuruModals.querySelector('.kecamatan');
        const kelurahanValue = editAiAdminGuruModals.querySelector('.kelurahan');

        alamatValue.value = temp.alamat
        noRtValue.value = temp.rt
        noRwValue.value = temp.rw
        kecamatanValue.value = temp.kecamatan
        kelurahanValue.value = temp.kelurahan

        const validator = initFormValidation(editAiAdminGuruModals, {
            btnSelector: '.btn_simpan',
            fields: [
                '.alamat',
                '.no_rt',
                '.no_rw',
                '.kecamatan',
                '.kelurahan'
            ]
        });
        editAiAdminGuruModals._validator = validator;
    })

    editPiAdminGuruModals.addEventListener('hidden.bs.modal', function () {})
    editPiAdminGuruModals.addEventListener('show.bs.modal', function () {
        const namaLengkapValue = editPiAdminGuruModals.querySelector('.nama_lengkap');
        const JKValue = editPiAdminGuruModals.querySelector('.jenis_kelamin');
        const TglLahirValue = editPiAdminGuruModals.querySelector('#tanggal_lahir');
        const pendidikanValue = editPiAdminGuruModals.querySelector('.pendidikan');
        const noTelpValue = editPiAdminGuruModals.querySelector('.nomot_telp');

        namaLengkapValue.value = temp.nama ?? "";
        JKValue.value = temp.jenis_kelamin ?? "";

        const dateStr = temp.tanggal_lahir?.substring(0, 10) || "";
        const [year = "", month = "", day = ""] = dateStr.split('-');
        TglLahirValue.value = dateStr ? `${day}-${month}-${year}` : "";
        pendidikanValue.value = temp.pendidikan ?? ""
        noTelpValue.value = temp.nomor_handphone ?? ""

        const validator = initFormValidation(editPiAdminGuruModals, {
            btnSelector: '.btn_simpan',
            fields: [
                '.nama_lengkap',
                '.jenis_kelamin',
                '#tanggal_lahir',
                '.pendidikan',
                '.nomot_telp'
            ]
        });
        editPiAdminGuruModals._validator = validator;
    });

    editPiWalMurModals.addEventListener('hidden.bs.modal', function () {})
    editPiWalMurModals.addEventListener('show.bs.modal', function () {
        const namaAyahValue = editPiWalMurModals.querySelector('.nama_ayah');
        const namaIbuValue = editPiWalMurModals.querySelector('.nama_ibu');
        const ocupAyahValue = editPiWalMurModals.querySelector('.ocup_ayah');
        const ocupIbuValue = editPiWalMurModals.querySelector('.ocup_ibu');

        namaAyahValue.value = tempD2.nama_ayah ?? "";
        namaIbuValue.value = tempD2.nama_ibu ?? "";
        ocupAyahValue.value = tempD2.pekerjaan_ayah ?? "";
        ocupIbuValue.value = tempD2.pekerjaan_ibu ?? "";


        const validator = initFormValidation(editPiWalMurModals, {
            btnSelector: '.btn_simpan',
            fields: [
                '.nama_ayah',
                '.nama_ibu',
                '.ocup_ayah',
                '.ocup_ibu'
            ]
        });
        editPiWalMurModals._validator = validator;
    });

    editEmailModals.addEventListener('hidden.bs.modal', function () {
        const emailNewValue = editEmailModals.querySelector('.email_new');

        if (emailNewValue) emailNewValue.value = '';
    })
    editEmailModals.addEventListener('show.bs.modal', function () {
        const emailNowValue = editEmailModals.querySelector('.email_now');
        
        if (role == 0 || role == 1) {
            emailNowValue.value = temp.email ?? "";
        } else {
            emailNowValue.value = tempD2.email ?? "";
        }

        const validator = initFormValidation(editEmailModals, {
            btnSelector: '.btn_simpan',
            fields: [
                '.email_now',
                '.email_new'
            ]
        });
        editEmailModals._validator = validator;
    });
    
    document.addEventListener("DOMContentLoaded", async function () {
        document.querySelectorAll('.datepickerBuatan').forEach(el => {
            const modal = el.closest('.modal');
            const dp = new AirDatepicker(el, {
                container: el.closest('.modal'),
                autoClose: true,
                dateFormat: 'dd-MM-yyyy',
                locale: {
                    days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                    daysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    daysMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    today: 'Hari ini',
                    clear: 'Hapus',
                    dateFormat: 'dd-MM-yyyy',
                    firstDay: 1
                },
                onSelect({ date, formattedDate, datepicker }) {
                    if (modal.id === 'edit_personal_information_admin_guru') {
                        modal?._validator?.validate();
                    }
                },
                buttons: [
                    {
                        content: 'Hari ini',
                        onClick(dp) {
                            const today = new Date();
                            dp.selectDate(today);
                            dp.hide();
                        }
                    },
                    {
                        content: 'Hapus',
                        onClick(dp) {
                            dp.clear();
                            dp.hide();
                        }
                    }
                ]
            });
            el._dp = dp;
        });

        if (role == 0 || role == 1) {
            await loadProfileGroup01();
        } else {
            await loadProfileGroup02();
        }
    })

    btnSimpanPiAdminGuru.addEventListener("click", async function () {
        try {
            btnSimpanPiAdminGuru.disabled = true;
            btnSimpanPiAdminGuru.innerHTML = 'Menyimpan...';
            let payload;
            if (role == 0 || role == 1) {
                payload = {
                    uri: '/_backend/profile/ds1-update',
                    body: {
                        object_update: {
                            nama: editPiAdminGuruModals.querySelector('.nama_lengkap').value,
                            tanggal_lahir: editPiAdminGuruModals.querySelector('#tanggal_lahir').value ? formatToISO(editPiAdminGuruModals.querySelector('#tanggal_lahir').value) : null,
                            pendidikan: editPiAdminGuruModals.querySelector('.pendidikan').value,
                            jenis_kelamin: editPiAdminGuruModals.querySelector('.jenis_kelamin').value,
                            nomor_handphone: editPiAdminGuruModals.querySelector('.nomot_telp').value,
                        }
                    }
                }
            }
            const result = await fetchJson(payload.uri, {
                method: 'POST',
                body: payload.body
            });

            if (!result.ok) {
                showToast('Terjadi kegagalan perbarui data', 'success');
            }

            showToast('Data berhasil diperbarui', 'success');    
            if (role == 0 || role == 1) {
                await loadProfileGroup01();
            }
        } catch(e) {
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error');
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('edit_personal_information_admin_guru')
            );
            modal.hide();

            btnSimpanPiAdminGuru.disabled = false;
            btnSimpanPiAdminGuru.innerHTML = 'Simpan Perubahan';
        }
    })

    btnSimpanAiAdminGuru.addEventListener("click", async function () {
        try {
            btnSimpanAiAdminGuru.disabled = true;
            btnSimpanAiAdminGuru.innerHTML = 'Menyimpan...';
            let payload;
            if (role == 0 || role == 1) {
                payload = {
                    uri: '/_backend/profile/ds1-update',
                    body: {
                        object_update: {
                            alamat: editAiAdminGuruModals.querySelector('.alamat').value,
                            rt: editAiAdminGuruModals.querySelector('.no_rt').value,
                            rw: editAiAdminGuruModals.querySelector('.no_rw').value,
                            kelurahan: editAiAdminGuruModals.querySelector('.kelurahan').value,
                            kecamatan: editAiAdminGuruModals.querySelector('.kecamatan').value
                        }
                    }
                }
            }
            const result = await fetchJson(payload.uri, {
                method: 'POST',
                body: payload.body
            });
            if (!result.ok) {
                showToast('Terjadi kegagalan perbarui data', 'success');
            }

            showToast('Data berhasil diperbarui', 'success');    
            if (role == 0 || role == 1) {
                await loadProfileGroup01();
            }
        } catch(e) {
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'success');
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('edit_address_information_admin_guru')
            );
            modal.hide();

            btnSimpanAiAdminGuru.disabled = false;
            btnSimpanAiAdminGuru.innerHTML = 'Simpan Perubahan';
        }
    })

    btnSimpanEp.addEventListener("click", async function () {
        const passLamaValue = editPassword.querySelector('.pass_lama');
        const passBaruValue = editPassword.querySelector('.pass_baru');
        const passBaruKonfirmValue = editPassword.querySelector('.pass_baru_konfirm');

        if (passBaruValue.value != passBaruKonfirmValue.value) {
            showToast('password baru tidak sama dengan konfirmasi password baru')
            return;
        }

        try {
            btnSimpanEp.disabled = true;
            btnSimpanEp.innerHTML = 'Menyimpan...';

            const result = await fetchJson('/_backend/profile/change-password', {
                method: 'POST',
                body: {
                    password_lama: passLamaValue.value,
                    password_baru: passBaruKonfirmValue.value
                }
            });
            if (!result.ok) {
                throw result
            }

            const modal = bootstrap.Modal.getInstance(
                document.getElementById('edit_password')
            );
            modal.hide();

            showToast('password berhasil dilakukan perubahan')
        } catch(e) {
            const code = e?.code
			const message = e?.message

            if (code == '70008' || code == '70015') {
                showToast('password lama anda tidak sesuai')
            } else {
                showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'success');
            }
        } finally {
            btnSimpanEp.disabled = false;
            btnSimpanEp.innerHTML = 'Simpan Perubahan';
        }
    })

    btnSimpanPiWalMur.addEventListener("click", async function () {
        try {
            btnSimpanPiWalMur.disabled = true;
            btnSimpanPiWalMur.innerHTML = 'Menyimpan...';
            let payload;
            if (role == 2) {
                payload = {
                    uri: '/_backend/profile/ds2-update',
                    body: {
                        object_update: {
                            nama_ayah: editPiWalMurModals.querySelector('.nama_ayah').value,
                            nama_ibu: editPiWalMurModals.querySelector('.nama_ibu').value,
                            pekerjaan_ayah: editPiWalMurModals.querySelector('.ocup_ayah').value,
                            pekerjaan_ibu: editPiWalMurModals.querySelector('.ocup_ibu').value
                        }
                    }
                }
            }
            const result = await fetchJson(payload.uri, {
                method: 'POST',
                body: payload.body
            });
            if (!result.ok) {
                showToast('Terjadi kegagalan perbarui data', 'success');
            }

            showToast('Data berhasil diperbarui', 'success');    
            if (role == 2) {
                await loadProfileGroup02();
            }
        } catch(e) {
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'success');
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('ubah_personal_wali_murid')
            );
            modal.hide();

            btnSimpanPiWalMur.disabled = false;
            btnSimpanPiWalMur.innerHTML = 'Simpan Perubahan';
        }
    })

    btnSimpanEditEmail.addEventListener("click", async function () {
        try {
            btnSimpanEditEmail.disabled = true;
            btnSimpanEditEmail.innerHTML = 'Menyimpan...';
            let payload;
            payload = {
                uri: '/_backend/profile/update-email',
                body: {
                    email_baru: editEmailModals.querySelector('.email_new').value
                }
            }
            const result = await fetchJson(payload.uri, {
                method: 'POST',
                body: payload.body
            });
            
            if (!result.ok) {
                throw result;
            }

            showToast('Data berhasil diperbarui', 'success');
            if (role == 0 || role == 1) {
                await loadProfileGroup01();
            } else {
                await loadProfileGroup02();
            }
        } catch(e) {
			const code = e?.code;
			const message = e?.message;
			if (code === '70017' || code === '70004') {
                showToast(`Proses gagal dilakukan: ${message}`, 'error');
			} else {
				showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'success');
			}
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('edit_email')
            );
            modal.hide();

            btnSimpanEditEmail.disabled = false;
            btnSimpanEditEmail.innerHTML = 'Simpan Perubahan';
        }
    })

    async function loadProfileGroup01() {
        pagefailed.style.display = "none";
        spinner.style.display = "block";
        admin_guru_app.classList.add('d-none');

        try {
            const result = await fetchJson('/_backend/profile', {
                method: 'POST'
            });

            temp.niy = result.data.niy
            temp.tanggal_lahir = result.data.tanggal_lahir
            temp.nama = result.data.nama
            temp.jenis_kelamin = result.data.jenis_kelamin
            temp.pendidikan = result.data.pendidikan
            temp.nomor_handphone = result.data.nomor_handphone
            temp.alamat = result.data.alamat
            temp.rt = result.data.rt
            temp.rw = result.data.rw
            temp.kecamatan = result.data.kecamatan
            temp.kelurahan = result.data.kelurahan
            temp.email = result.data.email

            const niy = admin_guru_app.querySelector('#niy');
            niy.innerHTML = temp.niy ?? '-';
            const tgl_lahir = admin_guru_app.querySelector('#tgl_lahir');
            tgl_lahir.innerHTML = temp.tanggal_lahir ? moment(temp.tanggal_lahir).format('DD / MM / YYYY') : '-'
            const nama = admin_guru_app.querySelector('#nama_lengkap');
            nama.innerHTML = temp.nama;
            const jenis_kelamin = admin_guru_app.querySelector('#jenis_kelamin');
            jenis_kelamin.innerHTML = temp.jenis_kelamin == 'L' ? 'Laki-Laki' :
                                     temp.jenis_kelamin == 'P' ? 'Perempuan' : '-'
            const pendidikan = admin_guru_app.querySelector('#pendidikan');
            pendidikan.innerHTML = temp.pendidikan ?? '-';
            const no_telp = admin_guru_app.querySelector('#no_telp');
            no_telp.innerHTML = temp.nomor_handphone ?? '-';

            const alamat = admin_guru_app.querySelector('#alamat');
            alamat.innerHTML = temp.alamat ?? '-';
            const rt_rw = admin_guru_app.querySelector('#rt_rw');
            rt_rw.innerHTML = `${temp.rt ?? '-'} / ${temp.rw ?? '-'}`

            const kecamatan = admin_guru_app.querySelector('#kecamatan');
            kecamatan.innerHTML = temp.kecamatan ?? '-';
            const kelurahan = admin_guru_app.querySelector('#kelurahan');
            kelurahan.innerHTML = temp.kelurahan ?? '-';

            admin_guru_app.classList.remove('d-none');
        } catch(e) {
            pagefailed.style.display = "block";
            admin_guru_app.classList.add('d-none');
        } finally {
            spinner.style.display = "none";
        }
    }

    async function loadProfileGroup02() {
        pagefailed.style.display = "none";
        spinner.style.display = "block";
        ortu_app.classList.add('d-none');

        try {
            const result = await fetchJson('/_backend/profile/d2', {
                method: 'POST'
            });
            tempD2.nama_ayah = result.data.nama_ayah
            tempD2.nama_ibu = result.data.nama_ibu
            tempD2.pekerjaan_ayah = result.data.pekerjaan_ayah
            tempD2.pekerjaan_ibu = result.data.pekerjaan_ibu
            tempD2.email = result.data.email

            const ortu_ayah = ortu_app.querySelector('#ortu_ayah');
            ortu_ayah.innerHTML = tempD2.nama_ayah ?? '-';
            const ortu_ibu = ortu_app.querySelector('#ortu_ibu');
            ortu_ibu.innerHTML = tempD2.nama_ibu ?? '-';
            const ocup_ayah = ortu_app.querySelector('#ocup_ayah');
            ocup_ayah.innerHTML = tempD2.pekerjaan_ayah ?? '-';
            const ocup_ibu = ortu_app.querySelector('#ocup_ibu');
            ocup_ibu.innerHTML = tempD2.pekerjaan_ibu ?? '-';
            const ortu_email1 = ortu_app.querySelector('#ortu_email1');
            ortu_email1.innerHTML = tempD2.email ?? '-';
            const ortu_email2 = ortu_app.querySelector('#ortu_email2');
            ortu_email2.innerHTML = tempD2.email ?? '-';
            
            ortu_app.classList.remove('d-none');
        } catch(e) {
            pagefailed.style.display = "block";
            ortu_app.classList.add('d-none');
        } finally {
            spinner.style.display = "none";
        }
    }

    function initFormValidation(modal, config) {
        const btn = modal.querySelector(config.btnSelector);

        const fields = config.fields.map(selector => modal.querySelector(selector));

        const validate = () => {
            let isValid = fields.every(el => {
                if (!el) return false;
                return el.value?.toString().trim() !== "";
            });

            if (config.customValidate) {
                isValid = isValid && config.customValidate(fields);
            }

            btn.disabled = !isValid;
        };

        if (!modal.dataset.validationAttached) {
            fields.forEach(el => {
                if (!el) return;
                el.addEventListener('input', validate);
                el.addEventListener('change', validate);
            });

            modal.dataset.validationAttached = "true";
        }

        validate();

        return { validate };
    }

    const formatToISO = (dateStr) => {
        if (!dateStr) return "";

        const parts = dateStr.split("-");
        if (parts.length !== 3) return "";

        const [day, month, year] = parts;

        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    };

    function showToast(message, type = 'success') {
        const toastElement = document.getElementById('globalToast');
        const toastBody = document.getElementById('globalToastBody');

        // reset class
        toastElement.className = 'toast align-items-center border-0';

        // set warna berdasarkan type
        if (type === 'success') {
            toastElement.classList.add('text-bg-primary');
        } else if (type === 'error') {
            toastElement.classList.add('text-bg-danger');
        } else if (type === 'warning') {
            toastElement.classList.add('text-bg-warning');
        } else {
            toastElement.classList.add('text-bg-success');
        }

        toastBody.innerHTML = message;

        const toast = new bootstrap.Toast(toastElement, {
            delay: 1500
        });

        toast.show();
    }
</script>
@endsection