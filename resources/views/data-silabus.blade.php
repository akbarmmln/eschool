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
				<h3 class="page-title mb-1">Pembelajaran</h3>
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Akademik</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Item Penilaian</li>
					</ol>
				</nav>
			</div>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
				<div class="mb-2">
					<a href="{{ route('materi-tambah') }}" class="btn btn-primary"><i
						class="ti ti-square-rounded-plus-filled me-2"></i>Tambah Data
                    </a>
				</div>
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
                <div id="documents-container"></div>

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

<!-- Delete Modal -->
	<div class="modal fade" id="delete-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body text-center">
					<span class="delete-icon">
						<i class="ti ti-trash-x"></i>
					</span>
					<h4>Konfirmasi Penghapusan</h4>
					<p>Anda akan menghapus data yang dipilih, tindakan ini tidak dapat dibatalkan setelah Anda menghapusnya..</p>
					<div class="d-flex justify-content-center">
						<a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Batalkan</a>
						<button type="submit" class="btn btn-danger btn_delete">Ya, Hapus</button>
					</div>
				</div>				
			</div>
		</div>
	</div>
<!-- /Delete Modal -->
 
<script>
    let isLoading = false;
    let currentKeyword = "";
    let debounceTimer = null;

    const delModal = document.getElementById('delete-modal');
    const btnDel = delModal.querySelector('.btn_delete');

    delModal.addEventListener('hidden.bs.modal', function () {
        selectedId = null
    })
    delModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // tombol yang diklik
        selectedId = button.getAttribute('data-id');
    });

    btnDel.addEventListener('click', function () {
        if (!selectedId) {
            showToast('Pilih data yang akan dihapus', 'error');
            return;
        };

        btnDel.disabled = true;
        btnDel.innerHTML = 'Deleting...';

        fetch('/_backend/logic/data-silabus-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                id: selectedId
            })
        })
        .then(async res => {
            const statusCode = res.status;
            const data = await res.json();
            
            if (!statusCode || statusCode != 200) {
                showToast('Terjadi kegagalan hapus data', 'error');
                return;
            } else {
                showToast('Data berhasil dihapus', 'success');
                renderDocuments(1);
            }
        })
        .finally(() => {
            btnDel.disabled = false;
            btnDel.innerHTML = 'Ya, Hapus';

            const modal = bootstrap.Modal.getInstance(
                document.getElementById('delete-modal')
            );
            modal.hide();
        });
    })

    function renderDocuments(page) {
        if (isLoading) return;
        isLoading = true;

        const spinner = document.getElementById("loadingSpinner");
        const container = document.getElementById('documents-container');
        const pagination = document.getElementById("paginationContainer");

        spinner.style.display = "block";
        pagination.classList.add("loading");
        container.innerHTML = '';

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
        .then(res => res.json())
        .then(result => {
            if (!result.data.rows.length) {
                container.innerHTML = `Data tidak tersedia`;
            } else {
                result.data.rows.forEach(doc => {
                    let itemsHtml = '';
                                doc.items.forEach(item => {
                                    itemsHtml += `
                                        <div class="bg-light-300 border rounded d-flex align-items-center justify-content-between mb-3 p-2">
                                            <div class="d-flex align-items-center overflow-hidden">
                                                <div class="ms-2">
                                                    <p class="text-truncate fw-medium text-dark mb-0">${item.name}</p>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                });
                                container.innerHTML += `
                                    <div class="d-flex mb-3">
                                        <div class="card flex-fill">
                                            <div class="card-header">
                                                <div class="rounded d-flex align-items-center justify-content-between">
                                                    <div class="ms-2">
                                                        <h5>${doc.title}</h5>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-primary btn-icon btn-sm"
                                                            onclick="window.location.href='/akademik/ubah-materi/${doc.id}'">
                                                            <i class="ti ti-edit"></i>
                                                        </button>
                                                        <button class="btn btn-dark btn-icon btn-sm"
                                                            href="#"
                                                            data-id="${doc.id}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete-modal">
                                                                <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                ${itemsHtml}
                                            </div>
                                        </div>
                                    </div>
                                `;
                })
            }
            renderPagination(result.data.currentPage, result.data.totalPage);
        })
        .catch(() => {
            container.innerHTML = `Gagal mengambil data`;
        })
        .finally(() => {
            spinner.style.display = "none";
            pagination.classList.remove("loading");
            isLoading = false;
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        renderDocuments(1);
        const searchInput = document.getElementById("searchInput");
        searchInput.addEventListener("keyup", function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const value = this.value.trim();

                // Kalau kosong → reset keyword
                if (value === "") {
                    currentKeyword = "";
                    renderDocuments(1);
                } else {
                    currentKeyword = value;
                    renderDocuments(1);
                }
            }, 300); // 🔥 debounce in ms
        });
    });

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
                    renderDocuments(page);
                }
            });
        });
    }

    function showToast(message, type = 'success', redirectUrl = null) {
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

        if (redirectUrl) {
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 1600);
        }
    }
</script>
@endsection