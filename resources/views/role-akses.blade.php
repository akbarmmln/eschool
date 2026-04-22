@extends('admin.app')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Daftar Akses Kontrol</h3>
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Akademik</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">A C L</li>
					</ol>
				</nav>
			</div>
		</div>
		<!-- /Page Header -->

		<div class="card">
			<!-- <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
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
			</div> -->
            <div id="alertContainer"></div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped mb-0">
						<thead>
							<tr>
								<th>NIY</th>
								<th>Nama Guru</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Jabatan</th>
							</tr>
						</thead>
						<tbody id="roleTabel">
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
    let isLoading = false;
    document.addEventListener("DOMContentLoaded", async function () {
        await loadData(1);
    })

    async function loadData(page) {
        if (isLoading) return;
        isLoading = true;

        const spinner = document.getElementById("loadingSpinner");
        const tbody = document.getElementById("roleTabel");
        const pagination = document.getElementById("paginationContainer");

        spinner.style.display = "block";
        pagination.classList.add("loading");

        tbody.innerHTML = `
            <tr>
            </tr>
        `;
        try {
            const result = await fetchJson('/_backend/logic/auth/role/list', {
                method: 'POST',
                body: {
                    page: page
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
                        const role =
                            item.role == 0 ? 'Admin' :
                            item.role == 1 ? 'Non Admin' :
                            '-';

                        tbody.innerHTML += `
                            <tr>
                                <td class="link-primary">${item.adr_teacher.niy}</td>
                                <td>${item.adr_teacher.nama ?? '-'}</td>
                                <td>${item.adr_teacher.email ?? '-'}</td>
                                <td>${role ?? '-'}</td>
                                <td>${item.adr_teacher.jabatan ?? '-'}</td>
                            </tr>
                        `;
                    });
            }
            renderPagination(result.data.currentPage, result.data.totalPage);
        } catch (e) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        Gagal mengambil data
                    </td>
                </tr>
            `;
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