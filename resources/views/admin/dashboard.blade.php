@extends('admin.app')
@section('content')
<style>
.shimmer {
    position: relative;
    overflow: hidden;
    background: rgba(255,255,255,0.25);
    border-radius: 6px;
}

.shimmer::after {
    content: "";
    position: absolute;
    top: 0;
    left: -150px;
    height: 100%;
    width: 150px;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,0.6),
        transparent
    );
    animation: shimmer 1.2s infinite;
}

@keyframes shimmer {
    100% {
        left: 100%;
    }
}

.shimmer-text-lg {
    height: 28px;
    width: 260px;
    margin-bottom: 10px;
}

.shimmer-text-md {
    height: 18px;
    width: 200px;
    margin-bottom: 10px;
}

.shimmer-text-sm {
    height: 16px;
    width: 320px;
}

.spin {
    display: inline-block;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
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
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Beranda</h3>
			</div>
		</div>
		<!-- /Page Header -->

        <!-- Greeting Section -->
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="card flex-fill bg-info bg-03 position-relative overflow-hidden">

                    <svg class="float-icon f1" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"></path>
                    </svg>

                    <svg class="float-icon f2" viewBox="0 0 24 24">
                        <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"></path>
                    </svg>

                    <svg class="float-icon f3" viewBox="0 0 24 24">
                        <path d="M19.5 3.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2v14H3v3c0 1.66 1.34 3 3 3h12c1.66 0 3-1.34 3-3V2l-1.5 1.5zM19 19c0 .55-.45 1-1 1s-1-.45-1-1v-3H8V5h11v14z"></path>
                    </svg>

                    <div class="card-body position-relative" style="z-index: 2;">
                        <div id="nama_loading" class="shimmer shimmer-text-lg"></div>
                        <div id="detail_loading" class="shimmer shimmer-text-md"></div>
                        <div id="kelas_loading" class="shimmer shimmer-text-sm"></div>

                        <h1 id="nama" class="text-white mb-1 d-none"></h1>
                        <p id="detail" class="text-white mb-3 d-none"></p>
                        <p id="kelas" class="text-light d-none"></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Greeting Section -->

        <div class="row">
            <!-- <div class="d-flex align-items-center flex-wrap justify-content-end">
                <div class="input-icon-start mb-3 me-2 position-relative d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_jurnal">
                        <i class="ti ti-square-rounded-plus-filled me-2"></i>Tambah Jurnal
                    </a>
                    <div id="hapus_filter" class="d-none d-inline-flex border align-items-center rounded bg-white px-2">
                        <a href="#" class="btn fw-normal bg-white" data-bs-toggle="modal" data-bs-target="#cari_jurnal">
                            <i class="ti ti-calendar-due me-1"></i><span id="text_cari"></span>
                        </a>
                        <button id="button_hapus_filter" class="btn btn-sm p-0 text-danger border-0">
                            <i class="ti ti-x fw-bold"></i>
                        </button>
                    </div>
                    <a id="cari_filter" href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cari_jurnal"><i
                        class="ti ti-search me-2"></i>Cari Jurnal
                    </a>
                </div>
            </div> -->
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 gap-2">
                <!-- KIRI -->
                <div class="d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#laporan_mingguan">
                        <i class="ti ti-report-analytics me-2"></i>Laporan Mingguan
                    </a>
                </div>

                <!-- KANAN -->
                <div class="d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_jurnal">
                        <i class="ti ti-square-rounded-plus-filled me-2"></i>Tambah Jurnal
                    </a>

                    <div id="hapus_filter" class="d-none d-inline-flex border align-items-center rounded bg-white px-2">
                        <a href="#" class="btn fw-normal bg-white" data-bs-toggle="modal" data-bs-target="#cari_jurnal">
                            <i class="ti ti-calendar-due me-1"></i><span id="text_cari"></span>
                        </a>
                        <button id="button_hapus_filter" class="btn btn-sm p-0 text-danger border-0">
                            <i class="ti ti-x fw-bold"></i>
                        </button>
                    </div>

                    <a id="cari_filter" href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cari_jurnal">
                        <i class="ti ti-search me-2"></i>Cari Jurnal
                    </a>
                </div>
            </div>
            <div class="card-body">
				<nav aria-label="Page navigation" class="pagination-style-2">
					<ul class="pagination justify-content-end mb-0" id="paginationContainer">
					</ul>
				</nav>
            </div>
            <div id="jurnal_history_not_found_page" class="container mt-1" style="display:none">
                <div class="overflow-hidden d-flex justify-content-center align-items-center flex-column" style="min-height:300px;">
					<div class="mb-3 text-center">
						<img src="{{ asset('assets/img/empty_journal.svg') }}" class="error-img img-fluid" alt="Img" style="width: 50%">
					</div>
                    <h5 class="text-black mb-1 fw-bold">Belum ada jurnal</h5>
                    <p id="text_result" class="mb-1 text-black"></p>
                </div>
            </div>
            <div id="jurnal_history_found_page" class="container mt-1" style="display:none">
                <div class="row g-3">
                </div>
            </div>
            <div id="loading_page" class="container mt-1" style="display:none">
                <div class="text-center my-3">
                    <button id="loadingSpinner" class="btn btn-info-light" type="button" disabled="">
                        <span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
                            Memuat data...
                    </button>
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
    
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="add_jurnal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah Jurnal Mengajar</h4>
					<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
						<i class="ti ti-x"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
                                <label class="form-label">Hari / Tanggal Mengajar</label>
                                <div class="date-pic">
									<input type="text" autocomplete="off" id="tanggal" class="form-control datepickerBuatan" placeholder="">
									<span class="cal-icon"><i class="ti ti-calendar"></i></span>
								</div>
							</div>
							<div class="mb-3">
								<label class="form-label">Kelas</label>
								<select id="kelas" class="form-control kelas">
									<option value="">Pilih</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Jam Mulai</label>
								<div class="date-pic">
									<input type="time" id="jam_mulai" class="form-control jam_mulai">
								</div>
							</div>											
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Jam Selesai</label>
								<div class="date-pic">
									<input type="time" id="jam_selesai" class="form-control jam_selesai">
								</div>
							</div>											
						</div>
						<div class="mb-3">
							<label class="form-label">Materi Pembelajaran</label>
                            <textarea rows="3" id="materi" class="form-control editor" placeholder="Tuliskan materi yang diajarkan..."></textarea>
						</div>
						<div class="mb-3">
							<label class="form-label">Refleksi Pembelajaran</label>
                            <textarea rows="3" id="refleksi" class="form-control editor" placeholder="Tuliskan refleksi pembelajaran..."></textarea>
						</div>
                    </div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batalkan</a>
					<button type="submit" class="btn btn-primary btn_simpan_edit">Lanjutkan</button>
				</div>	
			</div>
		</div>
	</div>

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="cari_jurnal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Cari Jurnal Mengajar</h4>
					<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
						<i class="ti ti-x"></i>
					</button>
				</div>
                <div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Dari</label>
                                <div class="date-pic">
									<input type="text" id="dari" class="form-control datepickerBuatan" placeholder="">
                                    <span class="cal-icon"><i class="ti ti-calendar"></i></span>
								</div>
							</div>											
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Sampai</label>
                                <div class="date-pic">
									<input type="text" id="sampai" class="form-control datepickerBuatan" placeholder="">
                                    <span class="cal-icon"><i class="ti ti-calendar"></i></span>
								</div>
							</div>											
						</div>
                    </div>
                </div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batalkan</a>
					<button type="submit" class="btn btn-primary btn_cari">Cari</button>
				</div>	
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.6/dist/purify.min.js"></script>
<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.js"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    let idSukses;
    let isLoading = false;
    let tglDari = "";
    let tglSampai = ""
    const idAccount = @json($id_account);
    const tipeAccount = @json($tipe_account);
    const today = new Date();
    
    const textResult = document.getElementById('text_result');
    const buttonHapusFilter = document.getElementById('button_hapus_filter');
    const hapusFilter = document.getElementById('hapus_filter');
    const cariFilter = document.getElementById('cari_filter');
    const textCari = document.getElementById('text_cari');
    
    const addModal = document.getElementById('add_jurnal');
    const cariModal = document.getElementById('cari_jurnal');
    const btnLanjutkan = addModal.querySelector('.btn_simpan_edit');
    const btnCari = cariModal.querySelector('.btn_cari');

    const loading_page = document.getElementById('loading_page');
    const jurnal_history_found_page = document.getElementById('jurnal_history_found_page');
    const jurnal_history_not_found_page = document.getElementById('jurnal_history_not_found_page');

    const options = { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric' 
    };
    const formattedDate = today.toLocaleDateString('id-ID', options);

    buttonHapusFilter.addEventListener('click', function (event) {
        tglDari = null;
        tglSampai = null;

        hapusFilter.classList.add("d-none");
        cariFilter.classList.remove("d-none");
        loadDataJurnal(1)
    })

    addModal.addEventListener('hidden.bs.modal', function () {
        const tanggal = addModal.querySelector('#tanggal');
        const jam_mulai = addModal.querySelector('#jam_mulai');
        const jam_selesai = addModal.querySelector('#jam_selesai');
        const materi = addModal.querySelector('#materi');
        const refleksi = addModal.querySelector('#refleksi');

        if (tanggal) tanggal.value = '';
        if (jam_mulai) jam_mulai.value = '';
        if (jam_selesai) jam_selesai.value = '';
        if (materi) materi.value = '';
        if (refleksi) refleksi.value = '';
    })
    addModal.addEventListener('show.bs.modal', async function (event) {
        const tanggalInput = addModal.querySelector("#tanggal");
        const kelasInput = addModal.querySelector('#kelas');
        const jamMulaiInput = addModal.querySelector('#jam_mulai');
        const jamSelesaiInput = addModal.querySelector('#jam_selesai');
        const materiInput = addModal.querySelector('#materi');
        const refleksiInput = addModal.querySelector('#refleksi');
        const btn = addModal.querySelector('.btn_simpan_edit');
        btn.disabled = true;

        tanggalInput.placeholder = formattedDate;
        tanggalInput.addEventListener("keydown", function(e){
            e.preventDefault();
        });

        await loadKelas(kelasInput);

        const validator = initFormValidation(addModal, {
            btnSelector: '.btn_simpan_edit',
            fields: [
                '#tanggal',
                '#kelas',
                '#jam_mulai',
                '#jam_selesai',
                '#materi',
                '#refleksi'
            ]
        });
        addModal._validator = validator;
        window.currentValidator = validator;
    })

    btnLanjutkan.addEventListener('click', async function (event) {
        const tanggalInput = addModal.querySelector("#tanggal").value;
        const kelasInput = addModal.querySelector('#kelas').value;
        const jamMulaiInput = addModal.querySelector('#jam_mulai').value;
        const jamSelesaiInput = addModal.querySelector('#jam_selesai').value;
        const materiInput = addModal.querySelector('#materi').value;
        const refleksiInput = addModal.querySelector('#refleksi').value;

        if (isEmpty(tanggalInput)) {
            showToast('Hari / Tanggal pembelajaran wajib terisi', 'error')
            return;
        } else if (isEmpty(kelasInput)) {
            showToast('Kelas wajib terisi', 'error')
            return;
        } else if (isEmpty(jamMulaiInput)) {
            showToast('Jam mulai wajib terisi', 'error')
            return;
        } else if (isEmpty(jamSelesaiInput)) {
            showToast('Jam selesai wajib terisi', 'error')
            return;
        } else if (isEmpty(materiInput)) {
            showToast('Materi yang diajarkan wajib terisi', 'error')
            return;
        } else if (isEmpty(refleksiInput)) {
            showToast('Refleksi dari pembelajaran wajib terisi', 'error')
            return;
        }

        btnLanjutkan.disabled = true;
        btnLanjutkan.innerHTML = 'Memproses...';

        try {
            const result = await fetchJson('/_backend/logic/jurnal-create', {
                method: 'POST',
                body: {
                    tanggal: tanggalInput,
                    mulai: jamMulaiInput,
                    selesai: jamSelesaiInput,
                    materi: materiInput,
                    refleksi: refleksiInput,
                    kelas: kelasInput,
                    guru: idAccount
                }
            });

            if (!result.ok) {
                showToast('Jurnal baru gagal dibuat', 'error')
            } else {
                idSukses = result.data.id;
                const modalElement = document.getElementById("success-alert-modal");
                modalElement.dataset.id = idSukses;
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
                
                const modalAddInstance = bootstrap.Modal.getInstance(addModal);
                modalAddInstance.hide();
            }
        } catch(e) {
            btnLanjutkan.disabled = false;
            btnLanjutkan.innerHTML = 'Simpan';
        } finally {
            btnLanjutkan.disabled = false;
            btnLanjutkan.innerHTML = 'Simpan';
        }
    })

    cariModal.addEventListener('hidden.bs.modal', function () {
        const dariInput = cariModal.querySelector("#dari");
        const sampaiInput = cariModal.querySelector("#sampai");
        const submit = cariModal.querySelector(".btn_cari");
        submit.disabled = true;

        if (dariInput) dariInput.value = '';
        if (sampaiInput) sampaiInput.value = '';
    })
    cariModal.addEventListener('show.bs.modal', function (event) {
        const dariInput = cariModal.querySelector("#dari");
        const sampaiInput = cariModal.querySelector("#sampai");
        const submit = cariModal.querySelector(".btn_cari");
        submit.disabled = true;
        
        dariInput.placeholder = formattedDate;
        sampaiInput.placeholder = formattedDate;

        dariInput.addEventListener("keydown", function(e){
            e.preventDefault();
        });
        sampaiInput.addEventListener("keydown", function(e){
            e.preventDefault();
        });

        const validator = initFormValidation(cariModal, {
            btnSelector: '.btn_cari',
            fields: [
                '#dari',
                '#sampai'
            ]
        });
        cariModal._validator = validator;
    })

    btnCari.addEventListener('click', function (event) {
        const dariInput = cariModal.querySelector("#dari").value;
        const sampaiInput = cariModal.querySelector("#sampai").value;

        tglDari = dariInput;
        tglSampai = sampaiInput;

        hapusFilter.classList.remove("d-none");
        cariFilter.classList.add("d-none");

        textCari.innerHTML = `${dariInput} - ${sampaiInput}`
        const modal = bootstrap.Modal.getInstance(cariModal);
        modal.hide();
        loadDataJurnal(1);
    })

    document.getElementById("btnContinueSuccess").addEventListener("click", function () {
        const modalElement = document.getElementById("success-alert-modal");
        const id = modalElement.dataset.id;

        window.location.href = `/akademik/aktifitas-jurnal/${id}`;
    });

    async function loadKelas(loadKelas, hasValue = null) {
        try {
            const result = await fetchJson('/_backend/logic/data-kelas-level', {
                method: 'POST'
            });
            loadKelas.innerHTML = '<option value="">Pilih</option>';
            result.data.forEach(item => {
                let option = document.createElement("option");
                option.value = item.id;
                option.text = item.nama_kelas;
                loadKelas.appendChild(option);
            });

            if (hasValue) {
                loadKelas.value = hasValue
            }
        } catch (e) {
            loadKelas.innerHTML = '<option value="">Pilih</option>';
        }
    }

    function parseDateDMY(str) {
        if (!str) return null;
        const [d, m, y] = str.split('-');
        return new Date(y, m - 1, d);
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.datepickerBuatan').forEach(el => {
            const modal = el.closest('.modal');
            const dp = new AirDatepicker(el, {
                container: el.closest('.modal'),
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
                    if (modal.id === 'add_jurnal') {
                        modal?._validator?.validate();
                    } else if (modal.id === 'cari_jurnal') {
                        const btn = modal.querySelector(".btn_cari");
                        const dariInput = modal.querySelector('#dari');
                        const sampaiInput = modal.querySelector('#sampai');
                        const sampaiDp = sampaiInput._dp;

                        const minDate = datepicker.opts.minDate;
                        if (date && minDate && date < minDate) {
                            datepicker.clear();
                            return;
                        }

                        if (el.id === 'dari') {
                            const minDate = parseDateDMY(formattedDate);
                            if (sampaiDp && minDate) {
                                sampaiDp.update({
                                    minDate: minDate
                                });
                            }            
                            sampaiInput.value = "";
                            sampaiDp.clear();
                        }
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
        
        tinymce.init({
            selector: '.editor',
            min_height: 250,
            max_height: 250,
            license_key: 'gpl',
            menubar: false,
            plugins: [
                'lists', 'link', 'autolink'
            ],
            toolbar: 'bold italic underline | bullist numlist outdent indent | undo redo',
            branding: false,
            skin_url: "{{ asset('assets/js/tinymce/skins/ui/oxide') }}",
            content_css: "{{ asset('assets/js/tinymce/skins/content/default/content.min.css') }}",

            setup: function (editor) {
                editor.on('input change keyup', function () {
                    editor.save();
                    // trigger validation manual
                    if (window.currentValidator) {
                        window.currentValidator.validate();
                    }
                });
            },
            
            content_style: `
                body { 
                    font-family: Inter, sans-serif; 
                    font-size:14px;
                }
            `
        });

        hapusFilter.classList.add("d-none");
        cariFilter.classList.remove("d-none");

        loadProfile()
        loadDataJurnal(1)
    })

    async function loadProfile() {
        try {
            const result = await fetchJson('/_backend/profile', {
                method: 'POST'
            });
            console.log('1')
            const nama = result?.data?.nama
            const nama_kelas = result?.data?.nama_kelas ?? ''
            setData('nama', `${getGreeting()}, ${nama}`);
            setData('detail', 'Have a Good day at work');
            setData('kelas', `Admin & Guru wali kelas ${nama_kelas}`);
        } catch(e) {
            setData('nama', `-`);
            setData('detail', 'Have a Good day at work');
            setData('kelas', `-`);
        }
    }

    async function loadDataJurnal(page) {
        if (isLoading) return;
        isLoading = true;

        loading_page.style.display = "block";
        jurnal_history_found_page.style.display = "none";
        jurnal_history_not_found_page.style.display = "none";
        const pagination = document.getElementById("paginationContainer");
        pagination.classList.add("loading");

        if (!isEmpty(tglDari) && !isEmpty(tglSampai)) {
            textResult.innerHTML = `Tidak ditemukan jurnal dari tanggal ${tglDari} sampai ${tglSampai}`;
        } else {
            textResult.innerHTML = 'Tambahkan jurnal pembelajaran pertama Anda.';
        }

        try {
            const result = await fetchJson('/_backend/logic/data-jurnal', {
                method: 'POST',
                body: {
                    page: page,
                    dari: tglDari,
                    sampai: tglSampai
                }
            });
            console.log('2')
            if (!result.ok) {
                jurnal_history_found_page.style.display = "none";
                jurnal_history_not_found_page.style.display = "block";
            } else {
                const rows = result.data.rows
                const currentPage = result.data.currentPage
                const totalPage = result.data.totalPage
                renderJurnalHtml(rows);
                if (rows.length > 0) {
                    renderPagination(currentPage, totalPage);
                }
            }
        } catch(e) {
            jurnal_history_found_page.style.display = "none";
            jurnal_history_not_found_page.style.display = "block";
        } finally {
            loading_page.style.display = "none";
            pagination.classList.remove("loading");
            isLoading = false;
        }
    }

    function renderJurnalHtml(data, currentPage, totalPage) {
        const container = document.querySelector("#jurnal_history_found_page .row");
        if (data.length == 0) {
            jurnal_history_found_page.style.display = "none";
            jurnal_history_not_found_page.style.display = "block";
            return;
        }

        let html = "";
        data.forEach(item => {
            const dataSiswa = item.detail_siswa;
            let hadir = 0;
            let ijin = 0;
            let sakit = 0;
            let alpha = 0;

            const sakitNama = [];
            const alphaNama = [];
            for (const s of dataSiswa) {
                switch (s.absensi) {
                    case "1":
                    hadir++;
                    break;
                    case "2":
                    ijin++;
                    break;
                    case "3":
                    sakit++;
                    sakitNama.push(s.nama_siswa);
                    break;
                    case "4":
                    alpha++;
                    alphaNama.push(s.nama_siswa);
                    break;
                }
            }
            const result = {
                hadir_count: String(hadir),
                ijin_count: String(ijin),
                sakit_count: String(sakit),
                alpha_count: String(alpha),
                sakit_nama: sakitNama.join(", "),
                alpha_nama: alphaNama.join(", ")
            };
            html += `
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
                        <div class="p-3 text-white" style="background: linear-gradient(90deg,#5f79d8,#d27adf);">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold text-white mb-1">${dateFormatIndo(item.tanggal_jurnal)}</h6>
                                    <small class="opacity-75">${item.nama_kelas} • ${item.jam_mulai} - ${item.jam_selesai}</small>
                                </div>

                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">H:${result.hadir_count}</span>
                                    <span class="badge bg-secondary">S:${result.sakit_count}</span>
                                    <span class="badge bg-danger">A:${result.alpha_count}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <div class="fw-bold text-uppercase text-primary small">
                                        Materi
                                    </div>
                                    <div class="text-black small">
                                        ${DOMPurify.sanitize(item.materi)}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold text-uppercase text-primary small">
                                        Refleksi
                                    </div>
                                    <div class="text-black small">
                                        ${DOMPurify.sanitize(item.refleksi)}
                                    </div>
                                </div>

                                <hr class="border-1 opacity-100">

                                <div class="mb-3">
                                    <div class="fw-bold text-uppercase text-primary small mb-2">
                                        Tidak Hadir
                                    </div>

                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-secondary text-white" style="width: 12%">Sakit</span>
                                        <small>${!isEmpty(result.sakit_nama) ? result.sakit_nama : '0'}</small>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <span class="badge bg-danger text-light" style="width: 12%">Alpa</span>
                                        <small>${!isEmpty(result.alpha_nama) ? result.alpha_nama : '0'}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-auto">
                                <div class="flex-grow-1 border-top"></div>

                                <div class="d-flex gap-2 ms-3">
                                    <button class="btn btn-sm btn_download" style="background:#8ff28f;color:#c2a18d;"
                                        data-id="${item.id}" >
                                            <i class="ti ti-download"></i>
                                    </button>

                                    <button class="btn btn-sm" style="background:#dce7f7;color:#2e5fd3;"
                                        onclick="window.location.href='/akademik/aktifitas-jurnal/${item.id}'">
                                        <i class="ti ti-edit"></i>
                                    </button>

                                    <button class="btn btn-sm" style="background:#f4dada;color:#c93636">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        })
        container.innerHTML = html;
        jurnal_history_found_page.style.display = "block";
        jurnal_history_not_found_page.style.display = "none";
    }
    
    function getGreeting() {
        const hour = new Date().getHours();

        if (hour >= 5 && hour < 11) {
            return "Selamat Pagi";
        } 
        else if (hour >= 11 && hour < 15) {
            return "Selamat Siang";
        } 
        else if (hour >= 15 && hour < 18) {
            return "Selamat Sore";
        } 
        else {
            return "Selamat Malam";
        }
    }

    function setData(field, value){
        document.getElementById(field+"_loading").style.display = "none";

        let el = document.getElementById(field);
        el.classList.remove("d-none");
        el.innerText = value ?? "-";
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

    document.addEventListener('click', async function (e) {
        if (e.target.closest(".btn_download")) {
            const buttonDownload = e.target.closest('.btn_download');
            buttonDownload.disabled = true;
            buttonDownload.innerHTML = `<i class="ti ti-loader-2 spin"></i>`;

            const id = buttonDownload.dataset.id;

            try {
                const result = await fetchJson('/_backend/logic/download-bulk-penilaian-harian', {
                    method: 'POST',
                    body: {
                        id_jurnal: id
                    }
                });
                if(!result.ok) {
                    throw result;
                }
                openPdfFromBase64(result.data);
            } catch(e) {
                const code = e?.code
                const message = e?.message
                showToast('Terjadi kesalahan saat memproses data. Silahkan ulangi kembali');
            } finally {
                buttonDownload.disabled = false;
                buttonDownload.innerHTML = `<i class="ti ti-download"></i>`;
            }
        }
    });

	function openPdfFromBase64(base64) {
		// convert base64 ke binary
		const byteCharacters = atob(base64);
		const byteNumbers = new Array(byteCharacters.length)
			.fill(0)
			.map((_, i) => byteCharacters.charCodeAt(i));

		const byteArray = new Uint8Array(byteNumbers);

		// buat blob PDF
		const blob = new Blob([byteArray], { type: "application/pdf" });

		// buat URL
		const blobUrl = URL.createObjectURL(blob);
		// buka di tab baru
		window.open(blobUrl, "_blank");
	}

    function dateFormatIndo(date) {
        const d = new Date(date);

        return d.toLocaleDateString("id-ID", {
            weekday: "long",
            day: "2-digit",
            month: "long",
            year: "numeric"
        });
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

    function renderPagination(currentPage, totalPage) {
        const pagination = document.getElementById("paginationContainer");
        pagination.innerHTML = "";

        const maxVisible = 1; // jumlah page sekitar current
        const createPageItem = (page, label = null, active = false, disabled = false) => {
            return `
                <li class="page-item ${active ? 'active' : ''} ${disabled ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${page}">
                        ${label ?? page}
                    </a>
                </li>
            `;
        };

        // ===== PREVIOUS =====
        pagination.innerHTML += createPageItem(
            currentPage - 1,
            "Previous",
            false,
            currentPage === 1
        );

        // ===== PAGE 1 selalu tampil =====
        pagination.innerHTML += createPageItem(1, null, currentPage === 1);

        let start = Math.max(2, currentPage - maxVisible);
        let end = Math.min(totalPage - 1, currentPage + maxVisible);

        // ===== Ellipsis kiri =====
        if (start > 2) {
            pagination.innerHTML += `
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `;
        }

        // ===== Page tengah =====
        for (let i = start; i <= end; i++) {
            pagination.innerHTML += createPageItem(i, null, i === currentPage);
        }

        // ===== Ellipsis kanan =====
        if (end < totalPage - 1) {
            pagination.innerHTML += `
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `;
        }

        // ===== Last Page selalu tampil =====
        if (totalPage > 1) {
            pagination.innerHTML += createPageItem(
                totalPage,
                null,
                currentPage === totalPage
            );
        }

        // ===== NEXT =====
        pagination.innerHTML += createPageItem(
            currentPage + 1,
            "Next",
            false,
            currentPage === totalPage
        );

        // ===== Event Click =====
        document.querySelectorAll("#paginationContainer a[data-page]").forEach(link => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const page = parseInt(this.dataset.page);

                if (!this.parentElement.classList.contains("disabled")) {
                    loadDataJurnal(page);
                }
            });
        });
    }
</script>
@endsection