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

		<div class="card" id="pagefailed" style="display: none;">
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
                                            <div class="shimmer shimmer-text" id="tgl_lahir_loading"></div>
                                            <span id="tgl_lahir" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Siswa Perempuan</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="alamat_loading"></div>
                                            <span id="alamat" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Jumlah Siswa</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="jenis_kelamin_loading"></div>
                                            <span id="jenis_kelamin" class="d-none"></span>
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
                                <a href="#materi"
                                class="nav-link active"
                                data-bs-toggle="tab">
                                    <i class="ti ti-table-options me-2"></i>
                                    Materi Belajar dan Penilaian
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="materi">
                                <div class="card">
                                    <div class="card-body">
                                        <h5><span id="status"></span></h5>
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <tbody id="guruTable">
                                                </tbody>
                                            </table>
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
</div>
<!-- /Page Wrapper -->

<script>
    const id = @json($id);
    const pagefailed = document.getElementById("pagefailed");
    const textResult = document.getElementById('text_result')
    const pagesuccess = document.getElementById("pagesuccess");

    document.addEventListener("DOMContentLoaded", function () {
        fetch('/_backend/logic/detail-kelas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                id: id
            })
        })
        .then(async res => {
            const statusCode = res.status;
            const data = await res.json();

            if(statusCode != 200) {
				const error_code = data.err_code
				const err_msg = data.err_msg
				throw {
					code: error_code,
					message: err_msg
				};
			}
            const ruang_kelas = data?.data?.ruang_kelas;
            const tingkat_kelas = data?.data?.tingkat_kelas;
            const wali_kelas = data?.data?.wali_kelas;
            const silabus = data?.data?.silabus;
            
            setData('nama_kelas', ruang_kelas ? ruang_kelas['nama_kelas'] : '-');
            setData('jenjang_kelas', tingkat_kelas ? tingkat_kelas['nama'] : '-');
            setData('wali_kelas', wali_kelas ? wali_kelas['nama'] : '-');

            const tbody = document.getElementById("guruTable");
            tbody.innerHTML = "";

            if (silabus.length == 0) {
                const status = document.getElementById('status');
                status.innerHTML = 'Tidak ditemukan data materi pembelajaran pada kelas ini.'
                status.style.display = 'block';
            } else {
                const status = document.getElementById('status');
                status.innerHTML = ''
                status.style.display = 'none';
                renderTable(data.data.silabus, tbody);
            }
        })
        .catch(error => {
			const code = error?.code
			const message = error?.message
			if (code === '70008'){
				textResult.textContent = `Proses gagal dilakukan: ${message}`;
			} else {
				textResult.textContent = `Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`;
			}
			pagesuccess.style.display = "none";
            pagefailed.style.display = "block";
        })
    })

    function renderTable(data, tbody) {
        data.forEach((parent, parentIndex) => {
            const parentNumber = parentIndex + 1;
            const hasChildren = parent.items && parent.items.length > 0;

            // Parent Row
            tbody.innerHTML += `
                <tr class="table-primary parent-row" data-id="${parent.id}">
                    <td>
                        ${hasChildren ? 
                            `<button class="btn btn-sm btn-link toggle-btn" data-id="${parent.id}">
                                <i class="ti ti-chevron-right"></i>
                            </button>`
                            : `<button class="btn btn-sm btn-link toggle-btn" data-id="${parent.id}">
                                <i class="ti ti-x"></i>
                            </button>` }
                         <strong>${parentNumber}. ${parent.title}</strong>
                    </td>
                    <td><strong>Subject Materi</strong></td>
                </tr>
            `;

            // Child Rows (default hidden)
            if (hasChildren) {
                parent.items.forEach(child => {
                    tbody.innerHTML += `
                        <tr class="child-row child-of-${parent.id}" style="display:none;">
                            <td style="padding-left:40px;">
                                └── ${child.nama_item}
                            </td>
                            <td>Item Penilaian</td>
                        </tr>
                    `;
                });
            }
        });
    }

    function setData(field, value){
        document.getElementById(field+"_loading").style.display = "none";

        let el = document.getElementById(field);
        el.classList.remove("d-none");
        el.innerText = value ?? "-";
    }

    document.addEventListener("click", function (e) {
        if (e.target.closest(".toggle-btn")) {
            const btn = e.target.closest(".toggle-btn");
            const parentId = btn.getAttribute("data-id");
            const icon = btn.querySelector("i");

            const childRows = document.querySelectorAll(`.child-of-${parentId}`);

            const isHidden = childRows[0].style.display === "none";

            childRows.forEach(row => {
                row.style.display = isHidden ? "table-row" : "none";
            });

            // Ganti icon
            icon.className = isHidden 
                ? "ti ti-chevron-down" 
                : "ti ti-chevron-right";
        }
    });

	document.getElementById("btnRefresh").addEventListener("click", function(e){
		e.preventDefault();
		location.reload();
	});
</script>
@endsection