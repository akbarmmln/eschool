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

.upload-frame {
    width: 120px;
    height: 120px;
    border: 2px dashed #d6dbe1;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    overflow: hidden;
    position: relative;
}

.upload-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.btn-remove-image {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 50%;
    background: #dc3545;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    z-index: 2;
}

.btn-remove-image i {
    font-size: 14px;
    line-height: 1;
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
                        <h3 class="page-title mb-1">Perubahan Data Peserta Didik</h3>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card" id="loadingSpinner" style="display: none;">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-center my-3">
                                <button class="btn btn-info-light" type="button" disabled="">
                                    <span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
                                        Memuat data...
                                </button>
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

                <div id="pagesuccess" style="display: none;">
                    <div class="row">
                        <div id="filed_input" class="col-md-12">
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
                                                <div id="student-photo-view" class="d-none d-flex align-items-center gap-2">
                                                    <div
                                                        class="d-flex align-items-center justify-content-center avatar avatar-xxl border border-dashed me-2 flex-shrink-0 text-dark frames">
                                                        <img id="student-photo" 
                                                            src="{{ asset('assets/img/icons/student_new.svg') }}" 
                                                            onerror="this.src='{{ asset('assets/img/icons/student_new.svg') }}'"
                                                            class="img-fluid" alt="img">
                                                    </div>

                                                    <div class="upload-actions d-flex align-items-center">
                                                        <div class="d-flex gap-0">
                                                            <button type="button" id="button-ubah-gambar" class="btn btn-primary">
                                                                Ubah Gambar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="student-photo-edit" class="d-none d-flex align-items-start gap-2">
                                                    <div class="position-relative">
                                                        <!-- PREVIEW -->
                                                        <div id="preview-container" class="upload-frame">
                                                            <i class="ti ti-photo-plus fs-16"></i>
                                                        </div>

                                                        <!-- BUTTON REMOVE -->
                                                        <button type="button" id="remove-image" class="btn-remove-image d-none">
                                                            <i class="ti ti-x"></i>
                                                        </button>
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
                                                            <button type="button" id="button-batal-gambar" class="drag-upload-btn btn btn-secondary">
                                                                Batalkan
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
                                                    <label class="form-label">Kecamatan</label>
                                                    <input type="text" name="kecamatan" class="form-control kecamatan">
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
                                    <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <span class="bg-white avatar avatar-sm me-2 text-gray-7 flex-shrink-0">
                                                <i class="ti ti-user-shield fs-16"></i>
                                            </span>
                                            <h4 class="text-dark">Informasi Orang Tua</h4>
                                        </div>
                                        <div class="form-check form-switch">
                                            <a href="#" class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#unlink_parent"><i class="ti ti-trash"></i></a>
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

                                <div class="text-end">
                                    <button type="button" onclick="window.location.href='{{ route('siswa') }}'" class="btn btn-light me-3">Tutup</button>
                                    <button type="submit" id="btn-simpan" class="btn btn-primary btn_simpan">Simpan</button>
                                </div>
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
						<p id="containt_text" class="mt-3 text-white">Perubahan data siswa berhasil dirubah</p>
						<button type="button" id="btnContinueSuccess" class="btn btn-light me-2 my-2" data-bs-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="unlink_parent">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body text-center">
					<h4>Konfirmasi Penghapusan</h4>
                    <br>
					<p id="title_konfirmasi">Anda akan menghapus data orang tua yang terhubung dengan siswa ini. Tindakan ini tidak dapat dibatalkan setelah Anda menghapusnya</p>
					<div class="d-flex justify-content-center">
						<a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Batalkan</a>
						<button type="submit" class="btn btn-danger btn_delete">Ya, Hapus</button>
					</div>
				</div>				
			</div>
		</div>
	</div>

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.js"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    const id = @json($id);
    let currentKeyword = "";
    let debounceTimer = null;
    let changeImage = false;
    let id_parent = null;

    const filedInput = document.getElementById('filed_input');

    const unlinkParentModals = document.getElementById('unlink_parent');
    const btnUnlinkParent = unlinkParentModals.querySelector('.btn_delete');

    const dropdown = document.querySelector('.kelas-dropdown');
    const buttonSimpan = document.getElementById('btn-simpan')
    const loadingSpinner = document.getElementById('loadingSpinner')
    const pagefailed = document.getElementById('pagefailed')
    const pagesuccess = document.getElementById('pagesuccess')
    const textResult = document.getElementById('text_result')

    const studentPhotoView = document.getElementById('student-photo-view')
    const studentPhotoEdit = document.getElementById('student-photo-edit')

    const imageInput = document.getElementById('base64_image');
    const nikInput = document.querySelector('.nik');
    const namaLengkapInput = document.querySelector('.nama_lengkap');
    const jkInput = document.querySelector('.jenis_kelamin');
    const tglLahirInput = document.querySelector('.datepickerBuatan');
    const alamatInput = document.querySelector('.alamat');
    const noRtInput = document.querySelector('.no_rt');
    const noRwInput = document.querySelector('.no_rw');
    const kelurahanInput = document.querySelector('.kelurahan');
    const kecamatanInput = document.querySelector('.kecamatan');
    const idKelasInput = document.querySelector('.kelas-id');
    const kelasSearchInput = document.querySelector('.kelas-search');
    const namaAyahInput = document.querySelector('.nama_ayah');
    const namaIbuInput = document.querySelector('.nama_ibu');
    const emailAktifInput = document.querySelector('.email_aktif');
    const ocupAyahInput = document.querySelector('.ocup_ayah');
    const ocupIbuInput = document.querySelector('.ocup_ibu');

    const buttonBatalGambar = document.getElementById('button-batal-gambar')
    const buttonUbahGambar = document.getElementById('button-ubah-gambar')
    const previewContainer = document.getElementById('preview-container');
    const removeButton = document.getElementById('remove-image');
    const inputFile = document.querySelector('.image-sign');
    const base64Image = document.getElementById('base64_image');
    
    btnUnlinkParent.addEventListener('click', async function (e) {
        try {
			btnUnlinkParent.disabled = true;
            btnUnlinkParent.innerHTML = 'Memproses...';

            const result = await fetchJson('/_backend/logic/ortu/unlink', {
                method: 'POST',
                body: {
					id_siswa: id
                }
            });
			if (!result.ok) {
				throw result;
			}

            const modalElement = document.getElementById("success-alert-modal");
            const containtText = modalElement.querySelector("#containt_text");
            containtText.innerHTML = 'Data orang tua/wali murid berhasil dihapus'
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        } catch(e) {
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error');
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('unlink_parent')
            );
            modal.hide();
            btnUnlinkParent.disabled = false;
            btnUnlinkParent.innerHTML = 'Ya, Hapus';
        }
    })

    document.querySelector(".datepickerBuatan").addEventListener("keydown", function(e){
        e.preventDefault();
    });

    inputFile.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const maxSize = 4 * 1024 * 1024; // 4MB

        if (file.size > maxSize) {
            showToast('Ukuran file maksimal 4MB', 'error')
            e.target.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            const base64Full = event.target.result;
            const pureBase64 = base64Full.split(",")[1];

            previewContainer.innerHTML = `<img src="${base64Full}"" alt="Preview">`;
            base64Image.value = pureBase64;
            removeButton.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });

    removeButton.addEventListener('click', function () {
        previewContainer.innerHTML = `<i class="ti ti-photo-plus fs-16"></i>`;
        inputFile.value = '';
        base64Image.value = '';
        removeButton.classList.add('d-none');
    });

    buttonBatalGambar.addEventListener("click", async function () {
        changeImage = false;
        studentPhotoView.classList.remove("d-none");
        studentPhotoEdit.classList.add("d-none");
    })

    buttonUbahGambar.addEventListener("click", async function () {
        changeImage = true;
        studentPhotoView.classList.add("d-none");
        studentPhotoEdit.classList.remove("d-none");
    })

    buttonSimpan.addEventListener("click", async function () {
        const data = {
            id_siswa: id,
            change_image: changeImage,
            image: imageInput.value,
            nik: nikInput.value,
            nama_lengkap: namaLengkapInput.value,
            jenis_kelamin: jkInput.value,
            tanggal_lahir: tglLahirInput.value,
            alamat: alamatInput.value,
            no_rt: noRtInput.value,
            no_rw: noRwInput.value,
            kelurahan: kelurahanInput.value,
            kecamatan: kecamatanInput.value,
            id_kelas: idKelasInput.value,
            id_parent: id_parent,
            nama_ayah: namaAyahInput.value,
            nama_ibu: namaIbuInput.value,
            email_aktif: emailAktifInput.value,
            ocup_ayah: ocupAyahInput.value,
            ocup_ibu: ocupIbuInput.value,
        }
        
        buttonSimpan.disabled = true;
        buttonSimpan.innerHTML = 'Menyimpan...';

        try {
            const result = await fetchJson('/_backend/logic/data-siswa-update', {
                method: 'POST',
                body: data
            });
            if (!result.ok) {
                throw result;
            }

            const modalElement = document.getElementById("success-alert-modal");
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        } catch(e) {
            showToast('Perubahan data siswa gagal dirubah', 'success')
        } finally {
            buttonSimpan.disabled = false;
            buttonSimpan.innerHTML = 'Simpan';
        }
    })
    
    document.getElementById("btnContinueSuccess").addEventListener("click", function () {
        window.location.reload();
    });
    
    document.addEventListener("DOMContentLoaded", async function () {
        try {
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
                        const container = el.closest('#filed_input');
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

            const validator = initFormValidation(filedInput, {
                btnSelector: '.btn_simpan',
                fields: [
                    '.nik',
                    '.nama_lengkap',
                    '.jenis_kelamin',
                    '.datepickerBuatan',
                    '.alamat',
                    '.no_rt',
                    '.no_rw',
                    '.kelurahan',
                    '.kecamatan',
                    '.kelas-id',
                    '.kelas-search',
                    '.nama_ayah',
                    '.nama_ibu',
                    '.email_aktif',
                    '.ocup_ayah',
                    '.ocup_ibu',
                ]
            });
            filedInput._validator = validator;

            studentPhotoView.classList.remove("d-none");
            studentPhotoEdit.classList.add("d-none");
            loadingSpinner.style.display = "block"
            pagefailed.style.display = "none"
            pagesuccess.style.display = "none"

            const result = await fetchJson('/_backend/logic/detail-siswa', {
                method: 'POST',
                body: {
                    id: id
                }
            });
            const statusCode = result.statusCode;
            if(!result.ok) {
				throw result;
			}
			if(result.data.image){
				document.getElementById("student-photo").src = result.data.image;
			}

            pagesuccess.style.display = "block"
            nikInput.value = result.data.nik
            namaLengkapInput.value = result.data.nama_siswa
            jkInput.value = result.data.jenis_kelamin
            const [year, month, day] = result.data.tanggal_lahir.substring(0, 10).split('-');
            tglLahirInput.value = `${day}-${month}-${year}`;
            alamatInput.value = result.data.alamat
            noRtInput.value = result.data.rt
            noRwInput.value = result.data.rw
            kelurahanInput.value = result.data.kelurahan
            kecamatanInput.value = result.data.kecamatan
            idKelasInput.value = result.data.id_kelas
            kelasSearchInput.value = result.data.nama_kelas
            
            id_parent = result.data.id_parent;
            namaAyahInput.value = result.data.nama_ayah;
            namaIbuInput.value = result.data.nama_ibu;
            emailAktifInput.value = result.data.email;
            ocupAyahInput.value = result.data.pekerjaan_ayah;;
            ocupIbuInput.value = result.data.pekerjaan_ibu;
        } catch(e) {
            const code = e?.code
			const message = e?.message
			if (code === '70008') {
				textResult.textContent = `Proses gagal dilakukan: ${message}`;
			} else {
				textResult.textContent = `Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`;
			}
			pagesuccess.style.display = "none";
            pagefailed.style.display = "block";
        } finally {
            loadingSpinner.style.display = "none"
        }
    })

    kelasSearchInput.addEventListener('input', async function() {
        clearTimeout(debounceTimer);

        const keyword = this.value.trim();
        idKelasInput.value = '';

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

                        kelasSearchInput.value = kelas.nama_kelas;
                        idKelasInput.value = kelas.id;
                        idKelasInput.dispatchEvent(new Event('change'));
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