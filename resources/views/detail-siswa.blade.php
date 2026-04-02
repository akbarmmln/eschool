@extends(
    $role == '0' ? 'admin.app' : 'guru.app'
)
@section('content')
<style>
.shimmer {
    position: relative;
    overflow: hidden;
    background: #e6edf5;
    border-radius: 4px;
}

.shimmer::after {
    content: "";
    position: absolute;
    top: 0;
    left: -150px;
    height: 100%;
    width: 150px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.7), transparent);
    animation: shimmer 1.2s infinite;
}

@keyframes shimmer {
    100% {
        transform: translateX(300px);
    }
}

.shimmer-text {
    height: 100%;
    width: 100%;
}
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Data Siswa</h3>
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

        <div id="pagesuccess" class="row" style="transform: none;">
            <div class="col-xxl-3 col-xl-4 theiaStickySidebar" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
						<div class="theiaStickySidebar"
							style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none;">
							<div class="card border-white">
								<div class="card-header">
									<!-- <div class="d-flex align-items-center flex-wrap row-gap-3"> -->
                                    <div class="d-flex align-items-center flex-wrap row-gap-3">
										<div
											class="d-flex align-items-center justify-content-center avatar avatar-xxl border border-dashed me-2 flex-shrink-0 text-dark frames">
											<img id="student-photo" 
												src="{{ asset('assets/img/icons/student_new.svg') }}" 
												onerror="this.src='{{ asset('assets/img/icons/student_new.svg') }}'"
												class="img-fluid" alt="img">
										</div>
										<div class="overflow-hidden" style="width: 60%;">
											<p class="card-title placeholder-glow">
												<span id="nama_loading" class="placeholder w-100"></span>
                                                <span id="nik_loading" class="placeholder w-100"></span>
											</p>

											<h5 class="mb-1 text-truncate fw-bold"><span id="nama" class="d-none"></span></h5>
                                            <p class="text-primary"><span id="nik" class="d-none"></span></p>
										</div>
									</div>
								</div>

								<!-- Basic Information -->
								<div class="card-body">
									<dl class="row mb-0">
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Jenis Kelamin</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="jenis_kelamin_loading"></div>
                                            <span id="jenis_kelamin" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Tanggal Lahir</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="tgl_lahir_loading"></div>
                                            <span id="tgl_lahir" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Alamat</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="alamat_loading"></div>
                                            <span id="alamat" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">RT / RW</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="rt_rw_loading"></div>
                                            <span id="rt_rw" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">kelurahan</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="kelurahan_loading"></div>
                                            <span id="kelurahan" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Kecamatan</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="kecamatan_loading"></div>
                                            <span id="kecamatan" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Kelas</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="kelas_loading"></div>
                                            <span id="kelas" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Wali Kelas</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="wali_kelas_loading"></div>
                                            <span id="wali_kelas" class="d-none"></span>
                                        </dd>
									</dl>
								</div>
								<!-- /Basic Information -->
							</div>
						</div>
            </div>

            <div class="col-xxl-9 col-xl-8">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs nav-tabs-bottom mb-4">
                            <li class="nav-item">
                                <a href="#kehadiran"
                                class="nav-link active"
                                data-bs-toggle="tab">
                                    <i class="ti ti-calendar-due me-2"></i>
                                    Kehadiran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#infoortu"
                                class="nav-link"
                                data-bs-toggle="tab">
                                    <i class="ti ti-info-octagon me-2"></i>
                                    Informasi Lainnya
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="kehadiran">
                                <div class="card">
									<div class="card-header">
										<div class="row">
											<div id="filterSection" class="row align-items-end">
												<div class="col-md-3">
													<div class="mb-3">
														<label class="form-label fw-bold">Dari</label>
														<div class="date-pic">
															<input type="text" id="dari" class="form-control datepickerBuatan" placeholder="">
															<span class="cal-icon"><i class="ti ti-calendar"></i></span>
														</div>
													</div>											
												</div>
												<div class="col-md-3">
													<div class="mb-3">
														<label class="form-label fw-bold">Sampai</label>
														<div class="date-pic">
															<input type="text" id="sampai" class="form-control datepickerBuatan" placeholder="">
															<span class="cal-icon"><i class="ti ti-calendar"></i></span>
														</div>
													</div>											
												</div>
												<div class="col-md-3">
													<div class="mb-3">
														<button class="btn btn-primary w-50 btn_cari" disabled>
															<i class="ti ti-search me-2"></i>Cari
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
                                    <div class="card-body" id="kehadiranSection">
										<div id="pageinit" style="display: block;">
											<div class="card-body">
												<div class="row justify-content-center">
													<div id="status_page" class="col-xxl-6 col-xl-6 col-lg-8 col-md-10 col-sm-12">
														<div class="card bg-white border-0">
															<div class="alert custom-alert1 alert-warning">
																<div class="text-center px-5 pb-0">
																	<div class="custom-alert-icon">
																		<i class="feather-alert-triangle flex-shrink-0"></i>
																	</div>
																	<h5 class="text-uppercase text-warning mb-3">LAKUKAN PENCARIAN TANGGAL</h5>
																	<p class="text-black mb-1">maksimal filter tanggal yang bisa dilakukan adalah 14 hari</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="pagenotfound" style="display: none;">
											<div class="card-body">
												<div class="row justify-content-center">
													<div id="status_page" class="col-xxl-6 col-xl-6 col-lg-8 col-md-10 col-sm-12">
														<div class="card bg-white border-0">
															<div class="alert custom-alert1 alert-warning">
																<div class="text-center px-5 pb-0">
																	<div class="custom-alert-icon">
																		<i class="feather-alert-triangle flex-shrink-0"></i>
																	</div>
																	<h5 class="text-uppercase text-warning mb-3">DATA TIDAK DITEMUKAN</h5>
																	<p class="text-black mb-1">Tidak ditemukan data pada filter tanggal yang dipilih. Silahkan atur pada tanggal yang lain</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
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
										<div id="loading_page" class="container mt-1" style="display: none">
											<div class="text-center my-3">
												<button id="loadingSpinner" class="btn btn-info-light" type="button" disabled="">
													<span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
														Memuat data...
												</button>
											</div>
										</div>
										<div id="pagesuccess" style="display: none;">
											<div id="tableContainer"></div>
											<div class="card-body p-0 py-3">
												<div class="px-3 text-center">
													<div class="d-flex align-items-center justify-content-center flex-wrap">
														<div class="d-flex align-items-center bg-white border rounded p-2 me-3 mb-3">
															<span class="avatar avatar-sm bg-success rounded me-2 flex-shrink-0 "><i class="ti ti-checks"></i></span>
															<p class="text-dark">Hadir</p>
														</div>
														<div class="d-flex align-items-center bg-white border rounded p-2 me-3 mb-3">
															<span class="avatar avatar-sm bg-pending rounded me-2 flex-shrink-0 "><i class="ti ti-clock-x"></i></span>
															<p class="text-dark">Ijin</p>
														</div>
														<div class="d-flex align-items-center bg-white border rounded p-2 me-3 mb-3">
															<span class="avatar avatar-sm bg-info rounded me-2 flex-shrink-0 "><i class="ti ti-calendar-event"></i></span>
															<p class="text-dark">Sakit</p>
														</div>
														<div class="d-flex align-items-center bg-white border rounded p-2 me-3 mb-3">
															<span class="avatar avatar-sm bg-danger rounded me-2 flex-shrink-0 "><i class="ti ti-x"></i></span>
															<p class="text-dark">Absent</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="infoortu">
								<div class="card">
									<div class="card-header">
										<h5>Orang Tua Siswa</h5>
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

										<a href="#" id="btn_hapus_akses" class="d-none btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#hapus_akses"><i class="ti ti-edit me-2"></i>Hapus Akses</a>
										<a href="#" id="btn_tambah_akses" class="d-none btn btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#tambah_akses" style="background-color:#FFC107;"><i class="ti ti-edit me-2"></i>Tambah Akses</a>
										<a href="#" id="btn_reset_password" class="d-none btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#reset_password"><i class="ti ti-edit me-2"></i>Reset Password</a>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<!-- /Page Wrapper -->

		<div class="modal fade" id="hapus_akses">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body text-center">
							<h4>Konfirmasi Penghapusan</h4>
							<p id="title_konfirmasi">Anda akan menghapus akses login terhadap user ini, tindakan ini tidak dapat dibatalkan setelah Anda menghapusnya..</p>
							<div class="d-flex justify-content-center">
								<a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Batalkan</a>
								<button type="submit" class="btn btn-danger btn_delete">Ya, Hapus</button>
							</div>
						</div>				
					</div>
				</div>
		</div>

		<div class="modal fade" id="tambah_akses">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Pemberian Akses Login</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">Email Baru</label>
									<input type="text" class="form-control email" name="email" placeholder="Masukkan email baru">
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
	let id_access = null, email_access = null, id_siswa = null;
    const id = @json($id);
	const pageInit = document.getElementById("pageinit");
	const pageNotFound = document.getElementById("pagenotfound");
	const pageKehadiran = document.getElementById("filterSection");
	const btnCari = pageKehadiran.querySelector(".btn_cari");
	const kehadiranSection = document.getElementById("kehadiranSection");
    const pagefailed = document.getElementById("pagefailed");
    const textResult = document.getElementById('text_result')
    const pagesuccess = document.getElementById("pagesuccess");
	const ortuAyah = document.getElementById("ortu_ayah");
	const ortuIbu = document.getElementById("ortu_ibu");
	const ocupAyah = document.getElementById("ocup_ayah");
	const ocupIbu = document.getElementById("ocup_ibu");
	const ortuEmail1 = document.getElementById("ortu_email1");
	const ortuEmail2 = document.getElementById("ortu_email2");

	const btnHapusAkses = document.getElementById('btn_hapus_akses')
	const btnTambahAkses = document.getElementById('btn_tambah_akses')
	const btnResetPassword = document.getElementById('btn_reset_password')

	const hapusAksesModals = document.getElementById('hapus_akses')
	const btnSimpanHapusAkses = hapusAksesModals.querySelector('.btn_delete')
	
	const tambahAksesModals = document.getElementById('tambah_akses')
	const btnSimpanTambahAkses = tambahAksesModals.querySelector('.btn_simpan')

	const today = new Date();
    const options = { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric' 
    };
    const formattedDate = today.toLocaleDateString('id-ID', options);

    const dariInput = pageKehadiran.querySelector("#dari");
    const sampaiInput = pageKehadiran.querySelector("#sampai");
	dariInput.placeholder = formattedDate;
	sampaiInput.placeholder = formattedDate;

	const btnRefresh = kehadiranSection.querySelector("#btnRefresh")

    document.addEventListener("DOMContentLoaded", async function () {
		dariInput.addEventListener("keydown", function (e) {
			e.preventDefault();
		});
		sampaiInput.addEventListener("keydown", function (e) {
			e.preventDefault();
		});

		const validator = initFormValidation(pageKehadiran, {
			btnSelector: '.btn_cari',
			fields: [
				'#dari',
				'#sampai'
			]
		});
		pageKehadiran._validator = validator;

		document.querySelectorAll('.datepickerBuatan').forEach(el => {
			const dp = new AirDatepicker(el, {
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
				// onRenderCell({ date, cellType }) {
				// 	if (cellType === 'day') {
				// 		const day = date.getDay(); // 0 = Minggu, 6 = Sabtu

				// 		if (day === 0 || day === 6) {
				// 			return {
				// 				disabled: true
				// 			};
				// 		}
				// 	}
				// },
				onSelect({ date, formattedDate, datepicker }) {
					const container = el.closest('#filterSection');
					const minDate = datepicker.opts.minDate;

					if (date && minDate) {
						const maxDate = new Date(minDate);
						maxDate.setDate(maxDate.getDate() + 13);

						if (date < minDate || date > maxDate) {
							datepicker.clear();
							return;
						}
					}

					if (el.id === 'dari') {
						const minDate = parseDateDMY(formattedDate);
						const sampaiInput = container.querySelector('#sampai');
						const sampaiDp = sampaiInput._dp;

						const maxDate = new Date(minDate);
						maxDate.setDate(maxDate.getDate() + 13);
						if (sampaiDp && minDate) {
							sampaiDp.update({
								minDate: minDate,
								maxDate: maxDate
							});
						}
						sampaiInput.value = "";
						sampaiDp.clear();
					}

					container?._validator?.validate();
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

		loadDataSiswa();
    })

	async function loadDataSiswa() {
		try {
            const result = await fetchJson('/_backend/logic/detail-siswa', {
                method: 'POST',
                body: {
                    id: id
                }
            });
            if(!result.ok) {
				throw result;
			}

			if(result.data.image){
				document.getElementById("student-photo").src = result.data.image;
			}

            setData('nama', result['data']['nama_siswa']);
            setData('nik', result['data']['nik']);
            setData('jenis_kelamin', result['data']['jenis_kelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan');
            setData('tgl_lahir', result['data']['tanggal_lahir'] ? moment(result['data']['tanggal_lahir']).format('DD / MM / YYYY') : '-');
            setData('alamat', result['data']['alamat']);
            setData('rt_rw', `${result['data']['rt']} / ${result['data']['rw']}`);
            setData('kelurahan', result['data']['kelurahan']);
            setData('kecamatan', result['data']['kecamatan']);
            setData('kelas', result['data']['nama_kelas']);
            setData('wali_kelas', result['data']['nama_guru']);
			ortuAyah.innerHTML = result?.data?.nama_ayah
			ortuIbu.innerHTML = result?.data?.nama_ibu
			ocupAyah.innerHTML = result?.data?.pekerjaan_ayah
			ocupIbu.innerHTML = result?.data?.pekerjaan_ibu
			ortuEmail1.innerHTML = result?.data?.email
			ortuEmail2.innerHTML = result?.data?.email
			id_access = result['data']['id_parent']
			email_access = result['data']['email']
			id_siswa = result['data']['id']

			if (result?.data?.email) {
				btnHapusAkses.classList.remove("d-none");
				btnTambahAkses.classList.add("d-none");
				btnResetPassword.classList.remove("d-none");
			} else {
				btnHapusAkses.classList.add("d-none");
				btnTambahAkses.classList.remove("d-none");
				btnResetPassword.classList.add("d-none");
			}
		} catch (e) {
            const code = e?.code
			const message = e?.message
			if (code === '70008'){
				textResult.textContent = `Proses gagal dilakukan: ${message}`;
			} else {
				textResult.textContent = `Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`;
			}
			pagesuccess.style.display = "none";
            pagefailed.style.display = "block";
		}
	}

	const warnaMap = {
		1: '<span class="attendance-range bg-success"></span>',
		2: '<span class="attendance-range bg-pending"></span>',
		3: '<span class="attendance-range bg-info"></span>',
		4: '<span class="attendance-range bg-danger"></span>'
	};
	async function loadKehadiranSiswa(idSiswa, dariInput, sampaiInput) {
		const tableContainer = kehadiranSection.querySelector("#tableContainer");
		const loadingPage = kehadiranSection.querySelector("#loading_page");
		const pageFailed = kehadiranSection.querySelector("#pagefailed");
		const pageSuccess = kehadiranSection.querySelector("#pagesuccess");

		try {
			pageInit.style.display = "none"
			loadingPage.style.display = "block"
			pageNotFound.style.display = "none"
			pageFailed.style.display = "none"
			pageSuccess.style.display = "none"

			const hariIndo = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
			const bulanIndo = [
				'januari','februari','maret','april','mei','juni',
				'juli','agustus','september','oktober','november','desember'
			];

            const result = await fetchJson('/_backend/logic/kehadiran-siswa', {
                method: 'POST',
                body: {
                    id_siswa: idSiswa,
					dari: dariInput,
					sampai: sampaiInput
                }
            });
            if(!result.ok) {
				throw result;
			}

			if (result.data.length == 0) {
				pageNotFound.style.display = "block"
				pageFailed.style.display = "none"
				pageSuccess.style.display = "none"
			} else {
				const data = result.data
				data.sort((a, b) => new Date(a.tanggal_jurnal) - new Date(b.tanggal_jurnal));
				const headers = [...new Map(
					data.map(item => {
						const d = new Date(item.tanggal_jurnal);
						return [
							item.tanggal_jurnal,
							{
								key: item.tanggal_jurnal,
								label: `<div class="text-center">
											<h5>${hariIndo[d.getDay()]}</h5>
											<strong>${String(d.getDate()).padStart(2, '0')}</strong>
										</div>`
							}
						];
					})
				).values()];
				const groupByBulan = {};
				data.forEach(item => {
					const d = new Date(item.tanggal_jurnal);
					const bulanKey = `${d.getFullYear()}-${d.getMonth()}`; // unik per tahun-bulan
				
					if (!groupByBulan[bulanKey]) {
						groupByBulan[bulanKey] = {
							namaBulan: bulanIndo[d.getMonth()],
							map: {}
						};
					}
				
					groupByBulan[bulanKey].map[item.tanggal_jurnal] = item.absensi;
				});

				const html = `
					<div class="table-responsive">
						<table class="table text-center align-middle">
							<thead class="thead-secondary">
								<tr>
									<th>Bulan</th>
									${headers.map(h => `<th>${h.label}</th>`).join('')}
								</tr>
							</thead>
							<tbody>
								${Object.values(groupByBulan).map(bulan => `
									<tr>
										<td class="text-capitalize">${bulan.namaBulan}</td>
										${headers.map(h => {
											const val = bulan.map[h.key];
											const color = warnaMap[val] || '';
											return `<td class="text-center align-middle">
														<div class="d-flex justify-content-center">
														${color || "-"}
														</div>
													</td>`;
										}).join('')}
									</tr>
								`).join('')}
							</tbody>
						</table>
					</div>
				`;
				tableContainer.innerHTML = html;
				pageSuccess.style.display = "block"
			}
		} catch(e) {
			const textResult = kehadiranSection.querySelector("#text_result");
            const code = e?.code
			const message = e?.message
			if (code === '70013'){
				textResult.textContent = `Proses gagal dilakukan: ${message}`;
			} else {
				textResult.textContent = `Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`;
			}
			pageFailed.style.display = "block"
			pageSuccess.style.display = "none"
		} finally {
			loadingPage.style.display = "none"
		}
	}

	
	btnCari.addEventListener("click", function(e){
		loadKehadiranSiswa(id, dariInput.value, sampaiInput.value)
	})

	btnRefresh.addEventListener("click", function(e){
		e.preventDefault();
		location.reload();
	});

    function parseDateDMY(str) {
        if (!str) return null;
        const [d, m, y] = str.split('-');
        return new Date(y, m - 1, d);
    }

	function initFormValidation(container, config) {
		const btn = container.querySelector(config.btnSelector);

		const fields = config.fields.map(selector => container.querySelector(selector));

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

		if (!container.dataset.validationAttached) {
			fields.forEach(el => {
				if (!el) return;

				el.addEventListener('input', validate);
				el.addEventListener('change', validate);
			});

			container.dataset.validationAttached = "true";
		}

		validate();

		return { validate };
	}
	
    function setData(field, value){
        document.getElementById(field+"_loading").style.display = "none";

        let el = document.getElementById(field);
        el.classList.remove("d-none");
        el.innerText = value ?? "-";
    }

    tambahAksesModals.addEventListener('hidden.bs.modal', function () {})
    tambahAksesModals.addEventListener('show.bs.modal', function () {
        const validator = initFormValidation(tambahAksesModals, {
            btnSelector: '.btn_simpan',
            fields: [
                '.email'
            ]
        });
        tambahAksesModals._validator = validator;
    });

    btnSimpanTambahAkses.addEventListener("click", async function () {
        try {
			const emailInput = tambahAksesModals.querySelector('.email').value;

			btnSimpanTambahAkses.disabled = true;
            btnSimpanTambahAkses.innerHTML = 'Menyimpan...';

            const result = await fetchJson('/_backend/logic/ortu/add-access', {
                method: 'POST',
                body: {
					id_siswa: id_siswa,
					email: emailInput
                }
            });
			if (!result.ok) {
				throw result;
			} else {
				showToast('Data akses berhasil dibuat', 'success');
			}
        } catch(e) {
			console.log('sadasdasdsad', e)
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error');
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('tambah_akses')
            );
            modal.hide();
            btnSimpanTambahAkses.disabled = false;
            btnSimpanTambahAkses.innerHTML = 'Simpan Perubahan';
        }
    })

	btnSimpanHapusAkses.addEventListener("click", async function () {
        try {
			btnSimpanHapusAkses.disabled = true;
            btnSimpanHapusAkses.innerHTML = 'Memproses...';

            const result = await fetchJson('/_backend/logic/ortu/remove-access', {
                method: 'POST',
                body: {
					id_siswa: id_siswa,
                    id_access: id_access,
					email: email_access
                }
            });
			if (!result.ok) {
				throw result;
			} else {
				showToast('Data akses berhasil dihapus', 'success');
			}
        } catch(e) {
			console.log('asdasdasd', e)
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error');
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('hapus_akses')
            );
            modal.hide();
            btnSimpanHapusAkses.disabled = false;
            btnSimpanHapusAkses.innerHTML = 'Ya, Hapus';
        }
	})

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