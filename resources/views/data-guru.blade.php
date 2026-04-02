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
				<h3 class="page-title mb-1">Data Pengajar</h3>
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Akademik</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Guru</li>
					</ol>
				</nav>
			</div>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                @if($role == '0')
                    <div class="mb-2">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_class_room"><i
                            class="ti ti-square-rounded-plus-filled me-2"></i>Tambah Pengajar
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
								<th>ID Guru</th>
								<th>NIY</th>
								<th>Nama Guru</th>
                                <th>Email</th>
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

<!-- Edit Class Room -->
<div class="modal fade" id="edit_class_room">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ubah Data Pengajar</h4>
				<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
					<i class="ti ti-x"></i>
				</button>
			</div>
			<div id="alertContainerModal"></div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label class="form-label">ID Guru</label>
								<input type="text" id="edit_id" class="form-control"  disabled="disabled">
							</div>
							<div class="mb-3">
								<label class="form-label">NIY</label>
								<input type="number" id="edit_niy" class="form-control" placeholder="NIY">
							</div>
							<div class="mb-3">
								<label class="form-label">Nama Guru</label>
								<input type="text" id="edit_nama_guru" class="form-control" placeholder="Nama Guru">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batalkan</a>
					<button type="submit" disabled class="btn btn-primary btn_simpan_edit">Simpan Perubahan</button>
				</div>
			
		</div>
	</div>
</div>
<!-- /Edit Class Room -->

<!-- Delete Modal -->
<div class="modal fade" id="delete-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body text-center">
					<span class="delete-icon">
						<i class="ti ti-trash-x"></i>
					</span>
					<h4>Konfirmasi Penghapusan</h4>
					<p id="title_konfirmasi">Anda akan menghapus data yang dipilih, tindakan ini tidak dapat dibatalkan setelah Anda menghapusnya..</p>
					<div class="d-flex justify-content-center">
						<a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Batalkan</a>
						<button type="submit" class="btn btn-danger btn_delete">Ya, Hapus</button>
					</div>
				</div>				
			</div>
		</div>
</div>
<!-- /Delete Modal -->

<!-- Add Class Room -->
    <div class="modal fade" id="add_class_room">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah Data Pengajar</h4>
					<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
						<i class="ti ti-x"></i>
					</button>
				</div>
                <div id="alertContainerModalAdd"></div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label class="form-label">NIY</label>
								<input type="number" id="edit_niy" placeholder="NIY" class="form-control">
							</div>
							<div class="mb-3">
								<label class="form-label">Nama Guru</label>
								<input type="text" id="edit_nama_guru" placeholder="Nama Guru" class="form-control">
							</div>
							<div class="mb-3">
								<label class="form-label">Email</label>
								<input type="text" id="edit_email" placeholder="Email Aktif" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batalkan</a>
					<button type="submit" disabled class="btn btn-primary btn_simpan_edit">Simpan Data</button>
				</div>	
			</div>
		</div>
	</div>
<!-- /Add Class Room -->

<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    const id_account = @json($id_account);
    const role = @json($role);
    let isLoading = false;
    let currentKeyword = "";
    let debounceTimer = null;
    let selectedId = null, selectedNama = null;

    const editModal = document.getElementById('edit_class_room');
    const btnSimpan = editModal.querySelector('.btn_simpan_edit');

    const delModal = document.getElementById('delete-modal');
    const btnDel = delModal.querySelector('.btn_delete');

    const addModal = document.getElementById('add_class_room');
    const btnSimpanAdd = addModal.querySelector('.btn_simpan_edit');

    btnSimpan.addEventListener('click', async function() {
        const idInput = editModal.querySelector('#edit_id').value;
        const niyInput = editModal.querySelector('#edit_niy').value;
        const namaInput = editModal.querySelector('#edit_nama_guru').value;

        if (!niyInput) {
            showAlertModal('NIY harus terisi', 'success');
            return;
        }
        if (!namaInput) {
            showAlertModal('Nama Guru harus terisi', 'success');
            return;
        }

        btnSimpan.disabled = true;
        btnSimpan.innerHTML = 'Menyimpan...';

        try {
            const result = await fetchJson('/_backend/logic/data-guru-update', {
                method: 'POST',
                body: {
                    id: idInput,
                    object_update: {
                        niy: niyInput,
                        nama: namaInput
                    }
                }
            });
            const statusCode = result.statusCode;
            if (!statusCode || statusCode != 200) {
                showAlert('Terjadi kegagalan perbarui data', 'success');
            } else {
                showAlert('Data berhasil diperbarui', 'success');
                loadData(1);
            }

            const modal = bootstrap.Modal.getInstance(
                document.getElementById('edit_class_room')
            );
            modal.hide();
        } catch (e) {
            showAlert('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'success');
        } finally {
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = 'Simpan Perubahan';
        }
    })

    btnDel.addEventListener('click', async function () {
        if (!selectedId) {
            showAlert('Pilih data yang akan dihapus', 'success');
        };

        btnDel.disabled = true;
        btnDel.innerHTML = 'Memproses...';

        try {
            const result = await fetchJson('/_backend/logic/data-guru-delete', {
                method: 'POST',
                body: {
                    id: selectedId
                }
            });
            if (!result.ok) {
                throw result;
            } else {
                showAlert('Data berhasil dihapus', 'success');
                loadData(1);
            }
        } catch (e) {
            showAlert('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error');
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('delete-modal')
            );
            modal.hide();

            btnDel.disabled = false;
            btnDel.innerHTML = 'Ya, Hapus';
        }
    })

    btnSimpanAdd.addEventListener('click', async function() {
        const niyInput = addModal.querySelector('#edit_niy').value;
        const namaInput = addModal.querySelector('#edit_nama_guru').value;;
        const emailInput = addModal.querySelector('#edit_email').value;;

        if (!niyInput) {
            showAlertModal('NIY harus terisi', 'success', 'alertContainerModalAdd');
            return;
        }
        if (!namaInput) {
            showAlertModal('Nama Guru harus terisi', 'success', 'alertContainerModalAdd');
            return;
        }
        if (!emailInput) {
            showAlertModal('Email harus terisi', 'success', 'alertContainerModalAdd');
            return;
        }

        btnSimpanAdd.disabled = true;
        btnSimpanAdd.innerHTML = 'Menyimpan...';

        try {
            const result = await fetchJson('/_backend/logic/data-guru-create', {
                method: 'POST',
                body: {
                    niy: niyInput,
                    nama: namaInput,
                    email: emailInput
                }
            });
            const statusCode = result.statusCode;
            if (!statusCode || statusCode != 200) {
                const message = result.message;
                showAlertModal(`Terjadi kegagalan simpan data: ${message}`, 'success', 'alertContainerModalAdd');
            } else {
                showAlert('Data berhasil ditambahkan', 'success');
                loadData(1);

                const modal = bootstrap.Modal.getInstance(
                    document.getElementById('add_class_room')
                );
                modal.hide();
            }
            btnSimpanAdd.innerHTML = 'Simpan Data';
        } catch (e) {
            btnSimpanAdd.disabled = false;
            showAlertModal('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'success');
        }
    })
    
    editModal.addEventListener('hidden.bs.modal', function () {
        // Disable tombol simpan
        btnSimpan.disabled = true;

        // Reset input
        const idInput = editModal.querySelector('#edit_id');
        const niyInput = editModal.querySelector('#edit_niy');
        const namaInput = editModal.querySelector('#edit_nama_guru');

        if (idInput) idInput.value = '';
        if (niyInput) niyInput.value = '';
        if (namaInput) namaInput.value = '';
    });
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // element yang klik
        const id = button.getAttribute('data-id');
        const niy = button.getAttribute('data-niy');
        const nama = button.getAttribute('data-nama');

        const btnSimpan = editModal.querySelector('.btn_simpan_edit');
        const idInput = editModal.querySelector('#edit_id');
        const niyInput = editModal.querySelector('#edit_niy');
        const namaInput = editModal.querySelector('#edit_nama_guru');

        idInput.value = id;
        niyInput.value = niy;
        namaInput.value = nama ?? '';

        const fields = [
            idInput,
            niyInput,
            namaInput
        ];
        const validateHandler = () => validateForm({ btn: btnSimpan, fields });
        if (!editModal.dataset.listenerAttached) {
            fields.forEach(el => {
                el.addEventListener('input', validateHandler);
                el.addEventListener('change', validateHandler);
            });
            editModal.dataset.listenerAttached = "true";
        }

        validateHandler();
    });

    delModal.addEventListener('hidden.bs.modal', function () {
        selectedId = null
    })
    delModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // tombol yang diklik
        const title_konfirmasi = delModal.querySelector('#title_konfirmasi')
        selectedId = button.getAttribute('data-id');
        selectedNama = button.getAttribute('data-nama');

        title_konfirmasi.innerHTML = `Anda akan menghapus <b>${selectedNama}</b>, tindakan ini tidak dapat dibatalkan setelah Anda menghapusnya.`;
    });

    addModal.addEventListener('hidden.bs.modal', function () {
        // Disable tombol simpan
        btnSimpanAdd.disabled = true;

        // Reset input
        const niyInput = addModal.querySelector('#edit_niy');
        const namaInput = addModal.querySelector('#edit_nama_guru');
        const emailInput = addModal.querySelector('#edit_email');

        if (niyInput) niyInput.value = '';
        if (namaInput) namaInput.value = '';
        if (emailInput) emailInput.value = '';
    })
    addModal.addEventListener('show.bs.modal', function (event) {
        const btnSimpanAdd = addModal.querySelector('.btn_simpan_edit');
        const niyInput = addModal.querySelector('#edit_niy');
        const namaInput = addModal.querySelector('#edit_nama_guru');
        const emailInput = addModal.querySelector('#edit_email');

        const fields = [
            niyInput,
            namaInput,
            emailInput
        ];
        const validateHandler = () => validateForm({ btn: btnSimpanAdd, fields });
        if (!addModal.dataset.listenerAttached) {
            fields.forEach(el => {
                el.addEventListener('input', validateHandler);
                el.addEventListener('change', validateHandler);
            });
            addModal.dataset.listenerAttached = "true";
        }
        validateHandler();
    })

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
            const result = await fetchJson('/_backend/logic/data-guru', {
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
                        tbody.innerHTML += `
                            <tr>
                                <td class="link-primary">${item.id}</td>
                                <td>${item.niy ?? '-'}</td>
                                <td>${item.nama ?? '-'}</td>
                                <td>${item.email ?? '-'}</td>
                                ${
                                    role == '0' ? `
                                    <td>
                                        ${item.id == id_account ? '' : `
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-white btn-icon btn-sm d-flex align-items-center justify-content-center rounded-circle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-14"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                    <li>
                                                        <a class="dropdown-item rounded-1" href="#"
                                                            data-id="${item.id}"
                                                            data-niy="${item.niy ?? ''}"
                                                            data-nama="${item.nama ?? ''}"
                                                            data-bs-toggle="modal" data-bs-target="#edit_class_room">
                                                            <i class="ti ti-edit-circle me-2"></i>Ubah
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item rounded-1" href="#"
                                                            data-id="${item.id}" data-nama="${item.nama}"
                                                            data-bs-toggle="modal" data-bs-target="#delete-modal">
                                                            <i class="ti ti-trash-x me-2"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        `}
                                    </td>
                                    ` : ``
                                }
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

    function validateForm({ btn, fields }) {
        const isValid = fields.every(el => el.value.trim() !== "");
        btn.disabled = !isValid;
    }

    function showAlertModal(message, type = 'primary', alertModel = 'alertContainerModal') {
        const container = document.getElementById(alertModel);
        const alertId = 'alert-' + Date.now();
        container.innerHTML = `
            <div id="${alertId}" 
                class="alert alert-solid-${type} alert-dismissible fade show">
                ${message}
                <button type="button" 
                        class="btn-close" 
                        data-bs-dismiss="alert">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        `;

        // Auto hide setelah 3 detik
        setTimeout(() => {
            const alertEl = document.getElementById(alertId);
            if (alertEl) {
                alertEl.classList.remove('show');
                alertEl.classList.add('fade');
                setTimeout(() => alertEl.remove(), 300);
            }
        }, 3000);
    }

    function showAlert(message, type = 'primary') {
        const container = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        container.innerHTML = `
            <div id="${alertId}" 
                class="alert alert-solid-${type} alert-dismissible fade show">
                ${message}
                <button type="button" 
                        class="btn-close" 
                        data-bs-dismiss="alert">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        `;

        // Auto hide setelah 3 detik
        setTimeout(() => {
            const alertEl = document.getElementById(alertId);
            if (alertEl) {
                alertEl.classList.remove('show');
                alertEl.classList.add('fade');
                setTimeout(() => alertEl.remove(), 300);
            }
        }, 3000);
    }
</script>
@endsection