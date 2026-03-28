@extends(
    $role == '0' ? 'admin.app' : 'guru.app'
)
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Data Siswa</h3>
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Akademik</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Peserta Didik</li>
					</ol>
				</nav>
			</div>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                @if($role == '0')
                    <div class="mb-2">
                        <a href="{{ route('siswa-tambah') }}" class="btn btn-primary">
                            <i class="ti ti-square-rounded-plus-filled me-2"></i>Tambah Data
                        </a>
                    </div>
                @endif
			</div>
		</div>
		<!-- /Page Header -->

		<div class="card">
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
			</div>
            <div id="alertContainer"></div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped mb-0">
						<thead>
							<tr>
								<th>NIK</th>
								<th>Nama Siswa</th>
                                <th>Kelas</th>
								<th>Wali Kelas</th>
                                @if($role == '0')
                                    <th>Aksi</th>
                                @endif
							</tr>
						</thead>
						<tbody id="guruTable">
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
<!-- /Page Wrapper -->

<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    const role = @json($role);
	let isLoading = false;
    let currentKeyword = "";
    let debounceTimer = null;
    let selectedId = null;

    document.addEventListener("DOMContentLoaded", async function () {
        await loadData(1);
        const searchInput = document.getElementById("searchInput");
        searchInput.addEventListener("keyup", async function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(async () => {
                const value = this.value.trim();

                // Kalau kosong → reset keyword
                if (value === "") {
                    currentKeyword = "";
                    await loadData(1); // reset ke page 1
                } else {
                    currentKeyword = value;
                    await loadData(1); // selalu mulai dari page 1 saat search
                }

            }, 300); // 🔥 debounce in ms
        });
    });

    async function loadData(page) {
        if (isLoading) return;
        isLoading = true;

        const spinner = document.getElementById("loadingSpinner");
        const tbody = document.getElementById("guruTable");
        const pagination = document.getElementById("paginationContainer");

        spinner.style.display = "block";
        pagination.classList.add("loading");

        tbody.innerHTML = `
            <tr>
            </tr>
        `;

        try {
            const result = await fetchJson('/_backend/logic/data-siswa', {
                method: 'POST',
                body: {
                    page: page,
                    search: encodeURIComponent(currentKeyword) ?? null
                }
            });
            if (!result.data.rows.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">
                            Data tidak tersedia
                        </td>
                    </tr>
                `;
            } else {
                    result.data.rows.forEach(item => {
                        tbody.innerHTML += `<tr>
                                <td><a href="/akademik/detail-siswa/${item.id}" class="link-primary">${item.nik}</a></td>
								<td>${item.nama_siswa}</td>
                                <td>${item.nama_kelas}</td>
								<td>${item.nama_guru ?? '-'}</td>
                                ${
                                    role == '0' ? `
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-white btn-icon btn-sm d-flex align-items-center justify-content-center rounded-circle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-14"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right p-3">
                                                    <li>
                                                        <a class="dropdown-item rounded-1"
                                                            data-id="${item.id}"
                                                            onclick="window.location.href='/akademik/ubah-siswa/${item.id}'">
                                                                <i class="ti ti-edit-circle me-2"></i>Ubah
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item rounded-1" href="#"
                                                        data-id="${item.id}"  data-nama="${item.nama_siswa}" 
                                                        data-bs-toggle="modal" data-bs-target="#delete-modal">
                                                            <i class="ti ti-trash-x me-2"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>` : ``
                                }
                            </tr>`;
                    });
            }
            renderPagination(result.data.currentPage, result.data.totalPage);
        } catch (e) {
            tbody.innerHTML = `<tr>
                <td colspan="5" class="text-center text-danger">
                    Gagal mengambil data
                </td>
            </tr>`;
        } finally {
            spinner.style.display = "none";
            pagination.classList.remove("loading");
            isLoading = false;
        }
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
                    loadData(page);
                }
            });
        });
    }
</script>
@endsection