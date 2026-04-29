@extends('ortu.app')
@section('content')
<style>
    .keterangan-view {
        border-radius: 12px;
    }

    .keterangan-bg {
        padding: 12px;
        min-height: 80px;
        background: #f1f5f9;
    }
    .keterangan-view ul {
        list-style: disc;
        padding-left: 20px;
        margin: 0;
    }

    .keterangan-view ol {
        list-style: decimal;
        padding-left: 20px;
        margin: 0;
    }

    .keterangan-view li {
        margin-bottom: 4px;
    }

    .error {
        color: red;
        font-size: 13px;
        margin-top: 10px;
        text-align: center;
    }

    /* ===== GLOBAL ===== */
    body {
        font-family: Tahoma, sans-serif;
        background: #f5f7fb;
    }

    /* ===== GRID ===== */
    .grid {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* ===== CARD (CUSTOM, NO BOOTSTRAP CONFLICT) ===== */
    .custom-card {
        width: 320px;
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* ===== HEADER ===== */
    .custom-card .card-header {
        padding: 0;
        margin-bottom: 10px;
        border: none;
        background: transparent;
    }

    .custom-card .card-header small {
        color: #94a3b8;
        font-size: 12px;
        letter-spacing: 1px;
    }

    .custom-card .card-header h3 {
        margin: 5px 0 15px;
        font-size: 18px;
    }

    /* ===== SECTION ===== */
    .section {
        margin-bottom: 20px;
    }

    .section label {
        font-size: 13px;
        color: #64748b;
        display: block;
        margin-bottom: 8px;
        letter-spacing: 2px;
    }

    /* ===== ACHIEVEMENT ===== */
    .achievement {
        display: flex;
        gap: 10px;
    }

    .badge {
        padding: 10px 12px;
        border-radius: 12px;
        background: #f1f5f9;
        cursor: pointer;
        transition: 0.2s;
        color: #16a34a;
    }

    .badge.active {
        background: #e0f2fe;
        color: #2563eb;
        border: 2px solid #2563eb;
    }

    .badge.green.active {
        background: #dcfce7;
        color: #16a34a;
    }

    .badge.yellow.active {
        background: #fef9c3;
        color: #ca8a04;
    }

    /* ===== TEXTAREA ===== */
    textarea {
        width: 100%;
        border: none;
        border-radius: 12px;
        padding: 10px;
        background: #f1f5f9;
        resize: none;
        font-size: 14px;

        min-height: 100px;
        max-height: 00px;
        overflow-y: auto;
    }
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 id="title" class="page-title mb-1">Detail Jurnal...</h3>
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Akademik</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Jurnal Mengajar</li>
					</ol>
				</nav>
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
					<div id="status_page" class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
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

		<div id="pagesuccess1" style="display: none;" class="card col-md-12">
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-calendar-time"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Tanggal dan Jam Mengajar</h6>
								<p id="tgl_jam_mengajar" class="mb-0">-</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-door"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Kelas</h6>
								<p id="nama_kelas" class="mb-0">-</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-book"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Materi</h6>
                                <div id="materi" class="keterangan-view"></div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-brand-socket-io"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Refleksi</h6>
                                <div id="refleksi" class="keterangan-view"></div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-user"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Pengajar</h6>
								<p id="pengajar" class="mb-0">-</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-bookmark-edit me-2"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Kehadiran</h6>
								<p id="kehadiran" class="mb-0">-</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <div id="pagesuccess2" class="col-xxl-12 col-xl-12" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
						<div class="card-header">
							<h5>Kegitan Belajar</h5>
						</div>
                        <div id="renderSuccess" style="display: none;" class="card-body">
                            <div class="custom-datatable-filter table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
											<th style="width:10%">No</th>
                                            <th style="width:40%">Tema Pembelajaran</th>
                                            <th style="width:20%">Materi Belajar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemPembelajaran">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="renderError" style="display: none;" class="card-body">
                            <div class="error" id="text_render_error"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid" id="cardContainer"></div>
        </div>
	</div>
</div>
<!-- /Page Wrapper -->

<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    const id_jurnal = @json($id_jurnal);
    const id_siswa = @json($id_siswa);
    const loadingSpinner = document.getElementById('loadingSpinner')
    const pagefailed = document.getElementById('pagefailed')
    const pagesuccess1 = document.getElementById('pagesuccess1')
    const pagesuccess2 = document.getElementById('pagesuccess2')
    const renderSuccess = pagesuccess2.querySelector('#renderSuccess');
    const renderError = pagesuccess2.querySelector('#renderError');
    const textRenderError = renderError.querySelector('#text_render_error');

    const tBodyitemPembelajaran = document.getElementById("itemPembelajaran");

    const title = document.getElementById('title')
    const tglJamMengajar = document.getElementById('tgl_jam_mengajar')
    const namaKelas = document.getElementById('nama_kelas')
    const materi = document.getElementById('materi')
    const refleksi = document.getElementById('refleksi')
    const pengajar = document.getElementById('pengajar')
    const kehadiran = document.getElementById('kehadiran')
    
    document.addEventListener("DOMContentLoaded", async function () {
        loadingSpinner.style.display = "block"
        pagefailed.style.display = "none"
        pagesuccess1.style.display = "none"
        pagesuccess2.style.display = "none"

        const dataSilabus = await callData();
        renderSilabus(dataSilabus);
    })

    async function renderSilabus(dataSilabus) {
        pagesuccess2.style.display = "block"
        try {
            let hasil;
            const tema = dataSilabus[0]?.title_silabus
            const result = {};
            if (dataSilabus.length == 0) {
                hasil = {
                    title: null,
                    item: []
                }
            } else {
                dataSilabus.forEach(item => {
                    const key = item.id_silabus;

                    if (!result[key]) {
                        result[key] = {
                            title: item.title_silabus,
                            item: []
                        };
                    }

                    result[key].item.push({
                        item_silabus: item.item_silabus,
                        nilai: item.nilai,
                        keterangan: item.keterangan
                    });
                });
                hasil = Object.values(result);
                hasil = hasil[0]
            }
            
            const title = hasil.title;
            const item = hasil.item

            tBodyitemPembelajaran.innerHTML = `
                <tr>
                </tr>
            `;
            if (item.length == 0) {
                tBodyitemPembelajaran.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center">
                        Data tidak tersedia
                    </td>
                </tr>
                `;
            } else {
                let no = 1;
                item.forEach(lineItem => {
                    tBodyitemPembelajaran.innerHTML += `
                    <tr>
                        <td>${no++}.</td>
                        <td>${tema}</td>
                        <td>${lineItem.item_silabus}</td>
                    </tr>`;
                })
            }

            const container = document.getElementById("cardContainer");
            container.innerHTML = "";
            dataSilabus.forEach(item => {
                const badgeMap = {
                    "1": "BSB",
                    "2": "BSH",
                    "3": "MB",
                    "4": "BB"
                };
                const active = badgeMap[item.nilai];
                const card = document.createElement("div");
                card.className = "custom-card";
                card.innerHTML = `
                    <div class="card-header">
                        <small>Aktifitas dan Pembelajaran pada</small>
                        <h3>${item.item_silabus}</h3>
                    </div>

                    <div class="section">
                        <label>PENCAPAIAN NILAI</label>
                        <div class="achievement">
                            <div class="badge ${active === 'BSB' ? 'active' : ''}">BSB</div>
                            <div class="badge ${active === 'BSH' ? 'active' : ''}">BSH</div>
                            <div class="badge ${active === 'MB' ? 'active' : ''}">MB</div>
                            <div class="badge ${active === 'BB' ? 'active' : ''}">BB</div>
                        </div>
                    </div>

                    <div class="section">
                        <label>Keterangan Tambahan</label>
                        <div class="keterangan-view keterangan-bg">${item.keterangan ?? ''}</div>
                    </div>
                `;
                container.appendChild(card);
            })

            renderSuccess.style.display = "block"
            renderError.style.display = "none"
        } catch(e) {
            textRenderError.innerHTML = 'Kegiatan pembelajaran gagal ditampilkan. Silahkan coba untuk refresh halaman.'
            renderSuccess.style.display = "none"
            renderError.style.display = "block"
        }
    }

    async function callData() {
        try {
            const result = await fetchJson('/_backend/logic/siswa/jurnal/detail', {
                method: 'POST',
                body: {
                    idjurnal: id_jurnal,
                    idsiswa: id_siswa,
                }
            });
            pagefailed.style.display = "none"
            pagesuccess1.style.display = "block"

            const tanggal = result.data.parent.tanggal_jurnal;
            const jam_mulai = result.data.parent.jam_mulai;
            const jam_selesai = result.data.parent.jam_selesai;
            const nama_kelas = result.data.parent.nama_kelas;
            const materi_ = result.data.parent.materi;
            const refleksi_ = result.data.parent.refleksi;
            const nama_guru = result.data.parent.nama_guru;
            const nama_siswa = toTitleCase(result.data.subParent.nama_siswa);
            const absensi = result.data.subParent.absensi;
            const dataSilabus = result.data.child;

            title.innerHTML = `Detail Jurnal ${nama_siswa ?? ''}`;
            tglJamMengajar.innerHTML = `${dateFormatIndo(tanggal)} • ${moment(jam_mulai, 'HH:mm').format('HH:mm')} - ${moment(jam_selesai, 'HH:mm').format('HH:mm')} WIB`;
            namaKelas.innerHTML = nama_kelas;
            materi.innerHTML = materi_;
            refleksi.innerHTML = refleksi_;
            pengajar.innerHTML = nama_guru;
            kehadiran.innerHTML =
                absensi == 1 ? 'Hadir' :
                absensi == 2 ? 'Izin' :
                absensi == 3 ? 'Sakit' :
                absensi == 4 ? 'Alfa' :
                '-';
            
            return dataSilabus;
        } catch(e) {
            pagefailed.style.display = "block"
            pagesuccess1.style.display = "none"
            pagesuccess2.style.display = "none"
            return null;
        } finally {
            loadingSpinner.style.display = "none"
        }
    }

    function toTitleCase(text) {
        return text
            .toLowerCase()
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
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
</script>
@endsection