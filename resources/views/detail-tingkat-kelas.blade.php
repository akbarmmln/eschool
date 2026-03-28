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
                            <li class="nav-item">
                                <a href="#materi"
                                class="nav-link"
                                data-bs-toggle="tab">
                                    <i class="ti ti-calendar-due me-2"></i>
                                    Materi Belajar dan Penilaian
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

                            <div class="tab-pane fade" id="materi">
                                <div class="card">
									<div class="card-header">
                                        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                                            <div class="mb-2">
                                                <a class="btn btn-primary btnTambah" data-bs-toggle="modal" data-bs-target="#exampleModalLg">
                                                    <i class="ti ti-square-rounded-plus-filled me-2"></i>Ubah atau Tambah Data
                                                </a>
                                            </div>
                                        </div>
									</div>

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
							<div class="modal fade" id="exampleModalLg" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="exampleModalLgLabel"></h4>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
                                            <div class="card-body px-0">
                                                <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <div class="input-icon-start mb-3 me-2 position-relative">
                                                            <span class="icon-addon">
                                                                <i class="ti ti-search"></i>
                                                            </span>
                                                            <input type="text"
                                                                id="searchInput"
                                                                name="keyword"
                                                                class="form-control"
                                                                placeholder="Pencarian">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                                                        <div class="mb-2">
                                                            <button type="submit" disabled class="btn btn-primary btn_simpan_edit"><i class="ti ti-device-floppy me-2"></i>Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="custom-datatable-filter table-responsive">
                                                    <table class="table">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th style="width:10%">ID</th>
                                                                <th style="width:80%">Nama</th>
                                                                <th style="width:10%">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="itemNilaiBaru">
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="loadingSpinner" class="text-center my-3" style="display: none;">
                                                    <button id="loadingSpinner" class="btn btn-info-light" type="button" disabled="">
                                                        <span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
                                                            Memuat data...
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <nav aria-label="Page navigation" class="pagination-style-2">
                                                        <ul class="pagination justify-content-end mb-0" id="paginationContainer">
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>

<script>
    let tempData;
    let dbSelectedIds, dbSelectedIdsInitial;
    const newSelectedIds = new Set();
    const id = @json($id);
    const addModal = document.getElementById('exampleModalLg');
    const btnSimpanIn = addModal.querySelector('.btn_simpan_edit');

    const pagefailed = document.getElementById("pagefailed");
    const textResult = document.getElementById('text_result')
    const pagesuccess = document.getElementById("pagesuccess");

    btnSimpanIn.addEventListener("click", function (e) {
        const finalIds = new Set([
            ...dbSelectedIds,
            ...newSelectedIds
        ]);
        
        btnSimpanIn.disabled = true;
        btnSimpanIn.innerHTML = 'Menyimpan...';

        fetch('/_backend/logic/update-relasi-silabus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                id: id,
                items: [...finalIds]
            })
        })
        .then(async res => {
            const statusCode = res.status;
            const data = await res.json();

            showToast('Data berhasil dilakukan perubahan', 'success');
            const modalInstance = bootstrap.Modal.getInstance(addModal);
            modalInstance.hide();

            loadFirstPage();
        })
        .catch(error => {
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error')
            return;
        })
        .finally(() => {
            btnSimpanIn.disabled = false;
            btnSimpanIn.innerHTML = 'Simpan';
        });
    })

    addModal.addEventListener('hidden.bs.modal', function () {
        newSelectedIds.clear();
        dbSelectedIds = new Set(dbSelectedIdsInitial);
        const btnSave = addModal.querySelector('.btn_simpan_edit');
        const searchInput = addModal.querySelector("#searchInput");
        if (searchInput) searchInput.value = '';
        btnSave.disabled = true;
    })
    addModal.addEventListener('show.bs.modal', function (event) {
        let debounceTimer = null;
        const searchInput = addModal.querySelector("#searchInput");
        dbSelectedIds = new Set(tempData.silabus.map(x => x.id));
        dbSelectedIdsInitial = new Set(dbSelectedIds);

        loadModulTambahMateri(1);
        if(searchInput) {
            searchInput.onkeyup = function(){
                clearTimeout(debounceTimer);
                const value = this.value.trim();

                debounceTimer = setTimeout(() => {
                    if(value === ""){
                        loadModulTambahMateri(1);
                    }else{
                        loadModulTambahMateri(1, value);
                    }
                },300);
            };
        }
    })

    document.addEventListener("DOMContentLoaded", function () {
        loadFirstPage();
    })

    function loadFirstPage() {
        document.querySelector('.btnTambah').classList.add('disabled');
        document.querySelector('.btnTambah').style.pointerEvents = 'none';
        
        fetch('/_backend/logic/detail-tingkat-kelas', {
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

            setData('nama', `Jenjang ${data['data']['nama']}`);
            setData('relasi_kelas', `${data.data.class_room.length} Kelas`);
            setData('deskripsi', data['data']['deskripsi'] ?? '(tidak ada deskripsi)');

            tempData = {
                nama: data.data.nama,
                silabus: data.data.silabus
            }

            relasiKelas(data.data.class_room);

            const tbody = document.getElementById("guruTable");
            tbody.innerHTML = "";

            if (data.data.silabus.length == 0) {
                const status = document.getElementById('status');
                status.innerHTML = 'Tidak ditemukan data materi pembelajaran pada jenjang kelas ini. Silahkan buat data nya terlebih dahulu'
                status.style.display = 'block';
            } else {
                const status = document.getElementById('status');
                status.innerHTML = ''
                status.style.display = 'none';
                renderTable(data.data.silabus, tbody);
            }

            document.querySelector('.btnTambah').classList.remove('disabled');
            document.querySelector('.btnTambah').style.pointerEvents = 'auto';
        })
        .catch(error => {
            document.querySelector('.btnTambah').classList.add('disabled');
            document.querySelector('.btnTambah').style.pointerEvents = 'none';

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

    document.addEventListener("click", function (e) {
        const btn = e.target.closest('.btn-delete-item');
        
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

        if (e.target.closest(".toggle-btn-in")) {
            const btn = e.target.closest(".toggle-btn-in");
            const parentId = btn.getAttribute("data-id-in");
            const icon = btn.querySelector("i");

            const childRows = document.querySelectorAll(`.child-ofin-${parentId}`);

            const isHidden = childRows[0].style.display === "none";

            childRows.forEach(row => {
                row.style.display = isHidden ? "table-row" : "none";
            });

                // Ganti icon
            icon.className = isHidden 
                ? "ti ti-chevron-down" 
                : "ti ti-chevron-right";
        }

        if(btn){
            const id = btn.dataset.id;
            dbSelectedIds.delete(id);

            const row = btn.closest('tr');
            row.querySelector('.parent-check').disabled = false;
            row.querySelector('.parent-check').checked = false;

            btn.remove();

            const status = row.querySelector('.status-db');
            if(status) status.remove();
            btn.remove();

            checkChanges();
        }
    });

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

    function loadModulTambahMateri(page, currentKeyword = '') {
        let isLoading = false;

        const label = addModal.querySelector('#exampleModalLgLabel');
        const nama = tempData.nama;

        label.innerHTML = `Penambahan / Perubahan <br> item penilaian jenjang ${nama}`

        if (isLoading) return;
        isLoading = true;

        const spinner = addModal.querySelector("#loadingSpinner");
        const tbody = addModal.querySelector("#itemNilaiBaru");
        const pagination = addModal.querySelector("#paginationContainer");

        spinner.style.display = "block";
        pagination.classList.add("loading");

        tbody.innerHTML = `
            <tr>
            </tr>
        `;

        fetch('/_backend/logic/data-silabus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                page: page,
                search: encodeURIComponent(currentKeyword) ?? null
            })
        })
        .then(async res => {
            const statusCode = res.status;
            const data = await res.json();

            tbody.innerHTML = "";
            if (!data.data.rows.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center">
                            Data tidak tersedia
                        </td>
                    </tr>
                `;
            } else {
                data.data.rows.forEach((parent, parentIndex) => {
                    const parentNumber = parentIndex + 1;
                    const hasChildren = parent.items && parent.items.length > 0;

                    const isDbSelected = dbSelectedIds.has(parent.id);
                    const isNewSelected = newSelectedIds.has(parent.id);

                    // Parent Row
                    tbody.innerHTML += `
                        <tr class="table-primary parent-row" data-id-in="${parent.id}">
                            <td>
                                <input 
                                    type="checkbox" 
                                    class="form-check-input me-2 parent-check" 
                                    value="${parent.id}"
                                    ${isDbSelected ? 'checked disabled' : ''}
                                    ${!isDbSelected && isNewSelected ? 'checked' : ''}>
                            </td>
                            <td>
                                ${hasChildren ? 
                                    `<button class="btn btn-sm btn-link toggle-btn-in" data-id-in="${parent.id}">
                                        <i class="ti ti-chevron-right"></i>
                                    </button>`
                                    : `<button class="btn btn-sm btn-link toggle-btn-in" data-id-in="${parent.id}">
                                        <i class="ti ti-x"></i>
                                    </button>` }
                                <strong>${parent.title}</strong>
                            </td>
                            <td>
                                ${isDbSelected ? `
                                    <span class="badge bg-success me-2 status-db"">Item sudah terpilih</span>
                                    <button class="btn btn-sm btn-outline-danger btn-delete-item" data-id="${parent.id}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                ` : ''}

                                ${!isDbSelected && isNewSelected ? `
                                    <span class="text-warning"></span>
                                ` : ''}
                            </td>
                        </tr>
                    `;

                    // Child Rows (default hidden)
                    if (hasChildren) {
                        parent.items.forEach(child => {
                            tbody.innerHTML += `
                                <tr class="child-row child-ofin-${parent.id}" style="display:none;">
                                    <td></td>
                                    <td style="padding-left:40px;">
                                        └── ${child.name}
                                    </td>
                                    <td>Item Penilaian</td>
                                </tr>
                            `;
                        });
                    }
                })
            }
            renderPaginationIn(data.data.currentPage, data.data.totalPage);
        })
        .catch((error) => {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center text-danger">
                        Gagal mengambil data
                    </td>
                </tr>
            `;
        })
        .finally(() => {
            spinner.style.display = "none";
            pagination.classList.remove("loading");
            isLoading = false;
        });
    }

    function renderPaginationIn(currentPage, totalPage) {
        const pagination = addModal.querySelector("#paginationContainer");
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
                    loadModulTambahMateri(page);
                }
            });
        });
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