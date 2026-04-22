@extends('ortu.app')
@section('content')
<style>
.error {
    color: red;
    font-size: 13px;
    margin-top: 10px;
    text-align: center;
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
								<p id="materi" class="mb-0">-</p>
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
								<p id="refleksi" class="mb-0">-</p>
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
                                            <th style="width:40%">Nama Pembelajaran</th>
                                            <th style="width:20%">Nilai</th>
                                            <th style="width:20%">Keterangan</th>
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
        </div>

	</div>
</div>
<!-- /Page Wrapper -->

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
                    const keteranganNilai =
                        lineItem.nilai == 1 ? 'Berkembang Sangat Baik' :
                        absensi == 2 ? 'Berkembang Sesuai Harapan' :
                        absensi == 3 ? 'Mulai Berkembang' :
                        absensi == 4 ? 'Belum Berkembang' :
                        '-';
                    tBodyitemPembelajaran.innerHTML += `
                    <tr>
                        <td>${no++}.</td>
                        <td>${lineItem.item_silabus}</td>
                        <td>${keteranganNilai}</td>
                        <td>${lineItem.keterangan ?? '-'}</td>
                    </tr>`;
                })
            }
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