@extends('admin.app')
@section('content')
<style>
#preview-container {
    width: 75px;     /* atur sesuai desain */
    height: 75px;    /* HARUS ada height */
    overflow: hidden;
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#preview-container img {
    width: 100%;
    height: 100%;
    object-fit: contain;  /* untuk KTP pakai contain */
}

/* Biar lebih modern */
.air-datepicker {
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    font-family: 'Inter', sans-serif;


/* Selected date */
.air-datepicker-cell.-selected- {
    background: #4f46e5 !important;
}

/* Hover */
.air-datepicker-cell:hover {
    background: #eef2ff;
}

/* Today */
.air-datepicker-cell.-current- {
    background: #e0e7ff;
}

.air-datepicker {
    z-index: 9999 !important;
}
</style>

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content content-two">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                    <div class="my-auto mb-2">
                        <h3 class="page-title mb-1">Penambahan Data Peserta Didik</h3>
                    </div>
                </div>
                <!-- /Page Header -->

				<div class="row">
					<div class="col-md-12">
                        <form id="form-siswa">
							<!-- Personal Information -->
							<div class="card">
								<div class="card-header bg-light">
									<div class="d-flex align-items-center">
										<span class="bg-white avatar avatar-sm me-2 text-gray-7 flex-shrink-0">
											<i class="ti ti-info-square-rounded fs-16"></i>
										</span>
										<h4 class="text-dark">Informasi Anak</h4>
									</div>
								</div>
								<div class="card-body pb-1">
									<div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-start gap-2">

                                                <!-- PREVIEW -->
                                                <div id="preview-container" class="upload-frame">
                                                    <i class="ti ti-photo-plus fs-16"></i>
                                                </div>

                                                <!-- BUTTON & TEXT -->
                                                <div class="upload-actions">

                                                    <div class="d-flex gap-0 mb-2">
                                                        <div class="drag-upload-btn">
                                                            Upload
                                                            <input type="file"
                                                                name="image"
                                                                class="form-control image-sign"
                                                                accept="image/jpeg,image/png,image/svg+xml">
                                                        </div>
                                                        <button type="button" id="remove-image" class="drag-upload-btn btn btn-secondary">
                                                            Remove
                                                        </button>
                                                        <input type="hidden" name="image_value" id="base64_image">
                                                    </div>

                                                    <p class="fs-12 text-muted mb-0">
                                                        Maksimal ukuran file 4MB, Format JPG, PNG, SVG
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
									</div>
                                    <br>
									<div class="row row-cols-xxl-5 row-cols-md-6">
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">NIK</label>
												<input type="number" name="nik" class="form-control nik">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Nama Lengkap</label>
												<input type="text" name="nama_lengkap" class="form-control nama_lengkap">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Jenis Kelamin</label>
												<select name="jenis_kelamin" class="form-control jenis_kelamin">
                                                    <option value="">Pilih Jenis Kelamin</option>
													<option value="L">Laki-Laki</option>
													<option value="P">Perempuan</option>
												</select>
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Tanggal Lahir</label>
												<div class="input-icon position-relative">
													<span class="input-icon-addon">
														<i class="ti ti-calendar"></i>
													</span>
													<input type="text" name="tanggal_lahir" class="form-control datepickerBuatan">
												</div>
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Alamat</label>
												<input type="text" name="alamat" class="form-control alamat">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">RT</label>
												<input type="number" name="no_rt" class="form-control no_rt">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">RW</label>
												<input type="number" name="no_rw" class="form-control no_rw">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Kelurahan</label>
												<input type="text" name="kelurahan" class="form-control kelurahan">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Kecamatan</label>
												<input type="text" name="kecamatan" class="form-control kecamatan">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Kelas</label>
                                                <input type="text" 
                                                        class="form-control kelas-search"
                                                        placeholder="Cari Kelas...">

                                                <!-- hidden untuk simpan ID -->
                                                <input type="hidden" name="id_kelas" class="kelas-id">

                                                <!-- dropdown hasil -->
                                                <div class="kelas-dropdown list-group position-absolute w-100 shadow-sm" 
                                                    style="z-index: 999; display: none; max-height:200px; overflow:auto;">
                                                </div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Personal Information -->

							<!-- Parents & Guardian Information -->
							<div class="card">
								<div class="card-header bg-light">
									<div class="d-flex align-items-center">
										<span class="bg-white avatar avatar-sm me-2 text-gray-7 flex-shrink-0">
											<i class="ti ti-user-shield fs-16"></i>
										</span>
										<h4 class="text-dark">Informasi Orang Tua</h4>
									</div>
								</div>
								<div class="card-body pb-1">
									<div class="row row-cols-xxl-5 row-cols-md-6">
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Nama Ayah</label>
												<input type="text" name="nama_ayah" class="form-control nama_ayah">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Nama Ibu</label>
												<input type="text" name="nama_ibu" class="form-control nama_ibu">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Email Aktif</label>
												<input type="text" name="email_aktif" class="form-control email_aktif">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Pekerjaan Ayah</label>
												<input type="text" name="ocup_ayah" class="form-control ocup_ayah">
											</div>
										</div>
										<div class="col-xxl col-xl-3 col-md-6">
											<div class="mb-3">
												<label class="form-label">Pekerjaan Ibu</label>
												<input type="text" name="ocup_ibu" class="form-control ocup_ibu">
											</div>
										</div>
									</div>
								</div>
                            </div>
							<!-- /Parents & Guardian Information -->
                        </form>
						<div class="text-end">
							<button type="button" onclick="window.location.href='{{ route('siswa') }}'" class="btn btn-light me-3">Tutup</button>
							<button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- /Page Wrapper -->

	<div id="success-alert-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content modal-filled bg-success">
				<div class="modal-body p-4">
					<div class="text-center">
						<i class="dripicons-checkmark h1 text-white"></i>
						<h5 class="fw-bold text-white text-uppercase text-warning mb-3">BERHASIL</h5>
						<p class="mt-3 text-white">Data berhasil dibuat
						</p>
						<button type="button" id="btnContinueSuccess" class="btn btn-light me-2 my-2" data-bs-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.js"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    const btnSimpan = document.getElementById('btn-simpan');
    const inputSearch = document.querySelector('.kelas-search');
    const dropdown = document.querySelector('.kelas-dropdown');
    let currentKeyword = "";
    let debounceTimer = null;

    const nikInput = document.querySelector(".nik");
    const namaInput = document.querySelector(".nama_lengkap");
    const jkInput = document.querySelector('.jenis_kelamin');
    const tanggalInput = document.querySelector(".datepickerBuatan");
    const alamatInput = document.querySelector(".alamat");
    const noRTInput = document.querySelector(".no_rt");
    const noRWInput = document.querySelector(".no_rw");
    const kelurahanInput = document.querySelector(".kelurahan");
    const kecamatanInput = document.querySelector(".kecamatan");
    const kelasIdHidden = document.querySelector('.kelas-id');
    const kelasSearch = document.querySelector('.kelas-search');
    const namaAyahInput = document.querySelector('.nama_ayah');
    const namaIbuInput = document.querySelector('.nama_ibu');
    const emailAktifInput = document.querySelector('.email_aktif');
    const ocupAyahInput = document.querySelector('.ocup_ayah');
    const ocupIbuInput = document.querySelector('.ocup_ibu');
    
    document.querySelector('.image-sign').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const maxSize = 4 * 1024 * 1024; // 4MB

        if (file.size > maxSize) {
            showToast('Ukuran file maksimal 4MB', 'error')
            e.target.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            const base64Full = event.target.result;
            const pureBase64 = base64Full.split(",")[1];
            document.getElementById('preview-container').innerHTML = `<img src="${base64Full}"">`;
            document.getElementById('base64_image').value = pureBase64;
            
            // document.getElementById('preview-container').innerHTML =`<img src="${reader.result}">`;
            // document.getElementById('base64_image').value = event.target.result
        }

        reader.readAsDataURL(file);
    });

    document.getElementById('remove-image').addEventListener('click', function() {
        document.querySelector('.image-sign').value = '';
        document.getElementById('preview-container').innerHTML =`<i class="ti ti-photo-plus fs-16"></i>`;
        document.getElementById('base64_image').value = ''
    });

    document.addEventListener("DOMContentLoaded", function () {
        btnSimpan.disabled = true;

        document.querySelectorAll('.datepickerBuatan').forEach(el => {
            const dp = new AirDatepicker(el, {
                autoClose: true,
                dateFormat: 'dd-MM-yyyy',
                locale: {
                    days: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
                    daysShort: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
                    daysMin: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
                    months: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                    monthsShort: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                    today: 'Hari ini',
                    clear: 'Hapus',
                    dateFormat: 'dd-MM-yyyy',
                    firstDay: 1
                },
                onSelect({ date, formattedDate, datepicker }) {
                    validateAddForm();
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

        const validateHandler = () => validateAddForm();
        [
            [nikInput, "input", validateHandler],
            [namaInput, "input", validateHandler],
            [jkInput, "change", validateHandler],
            [alamatInput, "input", validateHandler],
            [noRTInput, "input", validateHandler],
            [noRWInput, "input", validateHandler],
            [kelurahanInput, "input", validateHandler],
            [kecamatanInput, "input", validateHandler],
            [kelasIdHidden, "change", validateHandler],
            [kelasSearch, "input", () => {
                kelasIdHidden.value = '';
                validateAddForm();
            }],
            [namaAyahInput, "input", validateHandler],
            [namaIbuInput, "input", validateHandler],
            [emailAktifInput, "input", validateHandler],
            [ocupAyahInput, "input", validateHandler],
            [ocupIbuInput, "input", validateHandler],
        ].forEach(([el, event, handler]) => {
            el.addEventListener(event, handler);
        });
    })

    btnSimpan.addEventListener('click', async function() {
        const form = document.getElementById('form-siswa');
        const data = {
            image: form.image_value.value,
            nik: form.nik.value,
            nama_lengkap: form.nama_lengkap.value,
            jenis_kelamin: form.jenis_kelamin.value,
            tanggal_lahir: form.tanggal_lahir.value,
            alamat: form.alamat.value,
            no_rt: form.no_rt.value,
            no_rw: form.no_rw.value,
            kelurahan: form.kelurahan.value,
            kecamatan: form.kecamatan.value,
            id_kelas: form.id_kelas.value,
            nama_ayah: form.nama_ayah.value,
            nama_ibu: form.nama_ibu.value,
            email_aktif: form.email_aktif.value,
            ocup_ayah: form.ocup_ayah.value,
            ocup_ibu: form.ocup_ibu.value,
        }

        btnSimpan.disabled = true;
        btnSimpan.innerHTML = 'Menyimpan...';

        try {
            const result = await fetchJson('/_backend/logic/data-siswa-create', {
                method: 'POST',
                body: data
            });
            if (!result.ok) {
                showToast('Data gagal ditambahkan', 'error');
            } else {
                const modalElement = document.getElementById("success-alert-modal");
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        } catch (e) {
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error')
        } finally {
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = 'Simpan Data';
        }
    })

    document.getElementById("btnContinueSuccess").addEventListener("click", function () {
        const modalElement = document.getElementById("success-alert-modal");
        const id = modalElement.dataset.id;

        window.location.href = "{{ route('siswa') }}";
    });
    document.querySelector(".datepickerBuatan").addEventListener("keydown", function(e){
        e.preventDefault();
    });

    inputSearch.addEventListener('input', async function() {
        clearTimeout(debounceTimer);

        const keyword = this.value.trim();
        kelasIdHidden.value = '';

        if (keyword.length < 2) {
            dropdown.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(async () => {
            try {
                const result = await fetchJson('/_backend/logic/search-class-room', {
                    method: 'POST',
                    body: {
                        keyword: keyword
                    }
                });
                dropdown.innerHTML = '';
                if (result.data.length === 0) {
                    dropdown.style.display = 'none';
                    return;
                }
                result.data.forEach(kelas => {
                    const item = document.createElement('a');
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.href = "#";
                    item.innerText = kelas.nama_kelas;

                    item.addEventListener('click', function(e) {
                        e.preventDefault();

                        inputSearch.value = kelas.nama_kelas;
                        kelasIdHidden.value = kelas.id;
                        kelasIdHidden.dispatchEvent(new Event('change'));
                        dropdown.style.display = 'none';
                    })
                    dropdown.appendChild(item);
                })
                dropdown.style.display = 'block';
            } catch (e) {
                dropdown.style.display = 'none';
            }
        }, 300)
    })

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

    function isEmpty(data) {
        if (typeof (data) === 'object') {
            if (JSON.stringify(data) === '{}' || JSON.stringify(data) === '[]') {
            return true;
            } else if (!data) {
            return true;
            }
            return false;
        } else if (typeof (data) === 'string') {
            if (!data.trim()) {
            return true;
            }
            return false;
        } else if (typeof (data) === 'undefined') {
            return true;
        } else {
            return false;
        }
    }

    function validateAddForm() {
        nikValid = nikInput.value.trim() !== '';
        namaValid = namaInput.value.trim() !== '';
        jkValid = jkInput.value.trim() !== '';
        tanggalValid = tanggalInput.value.trim() !== '';
        alamatValid = alamatInput.value.trim() !== '';
        noRTValid = noRTInput.value.trim() !== '';
        noRWValid = noRWInput.value.trim() !== '';
        kelurahanValid = kelurahanInput.value.trim() !== '';
        kecamatanValid = kecamatanInput.value.trim() !== '';
        kelasIdHiddenValid = kelasIdHidden.value.trim() !== '';
        namaAyahValid = namaAyahInput.value.trim() !== '';
        namaIbuValid = namaIbuInput.value.trim() !== '';
        emailAktifValid = emailAktifInput.value.trim() !== '';
        ocupAyahValid = ocupAyahInput.value.trim() !== '';
        ocupIbuValid = ocupIbuInput.value.trim() !== '';

        btnSimpan.disabled = !(nikValid && namaValid && jkValid && tanggalValid 
            && alamatValid && noRTValid && noRWValid && kelurahanValid && kecamatanValid
            && kelasIdHiddenValid && namaAyahValid && namaIbuValid && emailAktifValid && ocupAyahValid && ocupIbuValid);
    }
</script>
@endsection