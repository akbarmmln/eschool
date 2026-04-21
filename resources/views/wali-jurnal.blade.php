@extends('ortu.app')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Detail Jurnal</h3>
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
								<i class="ti ti-door"></i>
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
								<i class="ti ti-book"></i>
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
								<i class="ti ti-school"></i>
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
								<i class="ti ti-calendar-time"></i>
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

        callData();
    })

    async function callData() {
        try {
            const result = await fetchJson('/_backend/logic/siswa/jurnal/detail', {
                method: 'POST',
                body: {
                    idjurnal: id_jurnal,
                    idsiswa: id_siswa,
                }
            });
            console.log('asdasdasd', result)
            pagefailed.style.display = "none"
            pagesuccess1.style.display = "block"

            const tanggal = result.data.parent.tanggal_jurnal;
            const jam_mulai = result.data.parent.jam_mulai;
            const jam_selesai = result.data.parent.jam_selesai;
            const nama_kelas = result.data.parent.nama_kelas;
            const materi_ = result.data.parent.materi;
            const refleksi_ = result.data.parent.refleksi;
            const nama_guru = result.data.parent.nama_guru;
            const absensi = result.data.subParent.absensi;

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
        } catch(e) {
            pagefailed.style.display = "block"
            pagesuccess1.style.display = "none"
        } finally {
            loadingSpinner.style.display = "none"
        }
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