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
				<h3 class="page-title mb-1">Detail Tingkatan</h3>
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
										<div class="overflow-hidden" style="width: 100%;">
											<p class="card-title placeholder-glow">
												<span id="nama_loading" class="placeholder w-100"></span>
											</p>
											<h5 class="mb-1 text-truncate fw-bold"><span id="nama" class="d-none"></span></h5>
										</div>
									</div>
								</div>

								<!-- Basic Information -->
								<div class="card-body">
									<dl class="row mb-0">
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Relasi Kelas</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="relasi_kelas_loading"></div>
                                            <span id="relasi_kelas" class="d-none"></span>
                                        </dd>
										<dt class="col-6 fw-medium text-dark mb-3 fw-bold">Deskripsi</dt>
										<dd class="col-6 mb-3">
                                            <div class="shimmer shimmer-text" id="deskripsi_loading"></div>
                                            <span id="deskripsi" class="d-none"></span>
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
                                <a href="#relasi-kelas"
                                class="nav-link active"
                                data-bs-toggle="tab">
                                    <i class="ti ti-table-options me-2"></i>
                                    Relasi Kelas
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="relasi-kelas">
                                <div class="card">
                                    <div class="card-body pb-0">
                                        <div class="d-flex flex-nowrap overflow-auto">
                                            <div id="col1" class="d-flex flex-column me-4 flex-fill">
                                            </div>
                                            <div id="col2" class="d-flex flex-column me-4 flex-fill">
                                            </div>
                                            <div id="col3" class="d-flex flex-column me-4 flex-fill">
                                            </div>
                                            <div id="col4" class="d-flex flex-column me-4 flex-fill">
                                            </div>
                                            <div id="col5" class="d-flex flex-column flex-fill">
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
</div>
<!-- /Page Wrapper -->

<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    let tempData;
    let dbSelectedIds, dbSelectedIdsInitial;
    const newSelectedIds = new Set();
    const id = @json($id);

    const pagefailed = document.getElementById("pagefailed");
    const textResult = document.getElementById('text_result')
    const pagesuccess = document.getElementById("pagesuccess");

    document.addEventListener("DOMContentLoaded", async function () {
        await loadFirstPage();
    })

    async function loadFirstPage() {        
        try {
            const result = await fetchJson('/_backend/logic/detail-tingkat-kelas', {
                method: 'POST',
                body: {
                    id: id
                }
            });
            
            const statusCode = result.statusCode;
            if(!result.ok) {
				throw result;
			}
            setData('nama', `Jenjang ${result['data']['nama']}`);
            setData('relasi_kelas', `${result.data.class_room.length} Kelas`);
            setData('deskripsi', result['data']['deskripsi'] ?? '(tidak ada deskripsi)');

            tempData = {
                nama: result.data.nama,
                silabus: result.data.silabus
            }

            relasiKelas(result.data.class_room);
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

    function setData(field, value){
        document.getElementById(field+"_loading").style.display = "none";

        let el = document.getElementById(field);
        el.classList.remove("d-none");
        el.innerText = value ?? "-";
    }

    function relasiKelas(data) {
        resetKolom();
        const bgClasses = [
            "bg-transparent-primary",
            "bg-transparent-danger",
            "bg-transparent-success",
            "bg-transparent-pending",
            "bg-transparent-info",
            "bg-transparent-light",
            "bg-transparent-warning"
        ];

        data.forEach((item, index) => {
            let colNumber = (index % 5) + 1;
            let randomBg = bgClasses[Math.floor(Math.random() * bgClasses.length)];
            let html = `
                <div class="${randomBg} rounded p-3 mb-4">
					<p class="d-flex align-items-center text-nowrap mb-1 link-primary"><i class="ti ti-info-circle me-1"></i>${item.id}</p>
					<p class="text-dark"><i class="ti ti-door me-1"></i>${item.nama_kelas}</p>
                    <div class="bg-white rounded p-1 mt-3 text-center">
                        ${item.wali_kelas ?? '-'}
                    </div>
                </div>
            `;
            document.getElementById("col" + colNumber).insertAdjacentHTML("beforeend", html);
        });
    }

    function resetKolom() {
        for (let i = 1; i <= 5; i++) {
            const col = document.getElementById("col" + i);
            if (col) col.innerHTML = '';
        }
    }
    
    document.addEventListener('change', function(e) {
        if(e.target.classList.contains('parent-check')){
            const id = e.target.value

            if(e.target.checked){
                newSelectedIds.add(id);
            }else{
                newSelectedIds.delete(id);
            }

            checkChanges();
        }
    });

    function checkChanges() {
        const dbChanged = !setsAreEqual(dbSelectedIdsInitial, dbSelectedIds);
        const newChanged = newSelectedIds.size > 0;

        const btnSave = addModal.querySelector('.btn_simpan_edit');

        btnSave.disabled = !(dbChanged || newChanged);
    }

    function setsAreEqual(setA, setB) {
        if (setA.size !== setB.size) return false;
        for (let item of setA) {
            if (!setB.has(item)) return false;
        }
        return true;
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