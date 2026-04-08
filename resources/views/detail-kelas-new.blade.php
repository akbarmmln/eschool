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
				<h3 class="page-title mb-1">Detail Kelas</h3>
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

        <div class="row" id="pagesuccess" style="transform: none;">
            <div class="col-xxl-3 col-xl-4 theiaStickySidebar" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
						<div class="theiaStickySidebar"
							style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none;">
							<div class="card border-white">
								<div class="card-header">
									<!-- <div class="d-flex align-items-center flex-wrap row-gap-3"> -->
                                    <div class="d-flex align-items-center flex-wrap row-gap-3">
										<div class="overflow-hidden" style="width: 100%;">
											<p class="card-title placeholder-glow">
												<span id="nama_kelas_loading" class="placeholder w-100"></span>
											</p>
											<h5 class="mb-1 text-truncate fw-bold"><span id="nama_kelas" class="d-none"></span></h5>
										</div>
									</div>
								</div>

								<!-- Basic Information -->
								<div class="card-body">
									<dl class="row mb-0">
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Siswa Laki-Laki</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="jumlah_laki_loading"></div>
                                            <span id="jumlah_laki" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Siswa Perempuan</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="jumlah_perempuan_loading"></div>
                                            <span id="jumlah_perempuan" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Jumlah Siswa</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="jumlah_siswa_loading"></div>
                                            <span id="jumlah_siswa" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Jenjang Kelas</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="jenjang_kelas_loading"></div>
                                            <span id="jenjang_kelas" class="d-none"></span>
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
                                <a href="#daftar-siswa"
                                class="nav-link active"
                                data-bs-toggle="tab">
                                    <i class="ti ti-table-options me-2"></i>
                                   Daftar Siswa
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#aktivitas"
                                class="nav-link"
                                data-bs-toggle="tab">
                                    <i class="ti ti-table-options me-2"></i>
                                    Aktivitas / Pembelajaran
                                </a>
                            </li> -->
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="daftar-siswa">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>NIK</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Jenis Kelamin</th>
                                                        <th>Alamat</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="siswaTable">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="tab-pane fade" id="aktivitas">
                                <div class="card">
                                    <div class="card-body">
                                        <span>kegiatan</span>
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <tbody id="aktivitasTable">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
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
    const id = @json($id);
    const pagefailed = document.getElementById("pagefailed");
    const textResult = document.getElementById('text_result')
    const pagesuccess = document.getElementById("pagesuccess");
    const siswaTable = document.getElementById("siswaTable");
    
    document.addEventListener("DOMContentLoaded", async function () {
        try {
            const result = await fetchJson('/_backend/logic/detail-kelas', {
                method: 'POST',
                body: {
                    id: id
                }
            });
            const statusCode = result.statusCode;
            if(!result.ok) {
				throw result;
			}

            const ruang_kelas = result?.data?.ruang_kelas;
            const tingkat_kelas = result?.data?.tingkat_kelas;
            const wali_kelas = result?.data?.wali_kelas;
            const silabus = result?.data?.silabus;
            const dataSiswa = result?.data?.dataSiswa;
            let laki = 0;
            let perempuan = 0;
            for (const s of dataSiswa) {
                switch (s.jenis_kelamin) {
                    case "L":
                    laki++;
                    break;
                    case "P":
                    perempuan++;
                    break;
                }
            }
            setData('nama_kelas', ruang_kelas ? ruang_kelas['nama_kelas'] : '-');
            setData('jenjang_kelas', tingkat_kelas ? tingkat_kelas['nama'] : '-');
            setData('wali_kelas', wali_kelas ? wali_kelas['nama'] : '-');
            setData('jumlah_siswa', `${dataSiswa.length} Siswa`);
            setData('jumlah_laki', `${laki} Siswa`);
            setData('jumlah_perempuan', `${perempuan} Siswa`);

            renderSiswa(dataSiswa)
        } catch (e) {
			const code = e?.code;
			const message = e?.message;
			if (code === '70008') {
				textResult.textContent = `Proses gagal dilakukan: ${message}`;
			} else {
				textResult.textContent = `Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`;
			}
			pagesuccess.style.display = "none";
            pagefailed.style.display = "block";
        }
    })

    function setData(field, value){
        document.getElementById(field+"_loading").style.display = "none";

        let el = document.getElementById(field);
        el.classList.remove("d-none");
        el.innerText = value ?? "-";
    }

    function renderSiswa(dataSiswa) {
        siswaTable.innerHTML = ``;
        if (dataSiswa.length == 0) {
            siswaTable.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center">
                        Data tidak tersedia
                    </td>
                </tr>`;
        } else {
            dataSiswa.forEach(item => {
                siswaTable.innerHTML += `
                <tr>
                    <td>${item.nik}</td>
                    <td>${item.nama ?? '-'}</td>
                    <td>${item.jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan'}</td>
                    <td>${item.alamat ?? '-'}</td>
                </tr>`;
            })
        }
    }

	document.getElementById("btnRefresh").addEventListener("click", function(e){
		e.preventDefault();
		location.reload();
	});
</script>
@endsection