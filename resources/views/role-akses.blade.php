@extends('admin.app')
@section('content')
<style>
	.tooltip-wrapper {
		position: relative;
		display: inline-block;
		color: #0d6efd;
		font-size: 14px;
		text-decoration: none;
	}

	/* tooltip box */
	.custom-tooltip {
		position: absolute;
		bottom: 130%;
		left: 50%;
		transform: translateX(-50%);
		
		background: #5bb3bb;
		color: white;
		padding: 6px 12px;
		border-radius: 8px;
		font-size: 12px;
		white-space: nowrap;

		opacity: 0;
		visibility: hidden;
		transition: 0.2s ease;
		box-shadow: 0 4px 10px rgba(0,0,0,0.1);
	}

	/* arrow */
	.custom-tooltip::after {
		content: "";
		position: absolute;
		top: 100%;
		left: 50%;
		transform: translateX(-50%);
		
		border-width: 6px;
		border-style: solid;
		border-color: #5bb3bb transparent transparent transparent;
	}

	/* show on hover */
	.tooltip-wrapper:hover .custom-tooltip {
		opacity: 1;
		visibility: visible;
		transform: translateX(-50%) translateY(-4px);
	}
	.tooltip-wrapper:hover {
		transform: scale(1.2);
	}
</style>

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
                                <th>Aksi</th>
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

<!-- Edit Role Akses -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="edit_access">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ubah Role Akses</h4>
				<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
					<i class="ti ti-x"></i>
				</button>
			</div>
			<div id="alertContainerModal"></div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label class="form-label">NIY</label>
								<input type="text" id="niy" class="form-control"  disabled="disabled">
							</div>
							<div class="mb-3">
								<label class="form-label">Nama</label>
								<input type="text" id="nama" class="form-control" disabled="disabled">
							</div>
							<div class="mb-3">
								<label class="form-label">Role Akses Saat ini:</label>
								<input type="text" id="rl_now" class="form-control" disabled="disabled">
							</div>
							<div class="mb-3">
								<label class="form-label">Role Akses Baru:</label>
								<select class="form-control rl_new" id="rl_new">
									<option value="">Pilih</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batalkan</a>
					<button type="submit" disabled class="btn btn-primary btn_simpan">Simpan Perubahan</button>
				</div>
			
		</div>
	</div>
</div>
<!-- Edit Role Akses -->

<!-- Edit Jabatan -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="edit_jabatan">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ubah Role Akses</h4>
				<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
					<i class="ti ti-x"></i>
				</button>
			</div>
			<div id="alertContainerModal"></div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label class="form-label">NIY</label>
								<input type="text" id="niy" class="form-control"  disabled="disabled">
							</div>
							<div class="mb-3">
								<label class="form-label">Nama</label>
								<input type="text" id="nama" class="form-control" disabled="disabled">
							</div>
							<div class="mb-3">
								<label class="form-label">Jabatan Saat ini:</label>
								<input type="text" id="jb_now" class="form-control" disabled="disabled">
							</div>
							<div class="mb-3">
								<label class="form-label">Jabatan Baru:</label>
								<select class="form-control jb_new" id="jb_new">
									<option value="">Pilih</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batalkan</a>
					<button type="submit" disabled class="btn btn-primary btn_simpan">Simpan Perubahan</button>
				</div>
			
		</div>
	</div>
</div>
<!-- Edit Jabatan -->

<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    let isLoading = false;
    const id_account = @json($id_account);
    const editAccess = document.getElementById('edit_access');
    const btnSimpanAccess = editAccess.querySelector('.btn_simpan');

    const editJabatan = document.getElementById('edit_jabatan');
    const btnSimpanJabatan = editJabatan.querySelector('.btn_simpan');

    document.addEventListener("DOMContentLoaded", async function () {
        await loadData(1);
    })

    editJabatan.addEventListener('hidden.bs.modal', function () {
        const niyInput = editJabatan.querySelector('#niy');
        const namaInput = editJabatan.querySelector('#nama');
        const jabNowInput = editJabatan.querySelector('#jb_now');
        const jabNewInput = editJabatan.querySelector('#jb_new');

        if (niyInput) niyInput.value = '';
        if (namaInput) namaInput.value = '';
        if (jabNowInput) jabNowInput.value = '';
        if (jabNewInput) jabNewInput.value = '';
    })
    editJabatan.addEventListener('show.bs.modal', function () {
        const button = event.relatedTarget; // element yang klik
        const niy = button.getAttribute('data-niy');
        const nama = button.getAttribute('data-nama');
        const jab_now = button.getAttribute('data-jab-now');

        const niyInput = editJabatan.querySelector('#niy');
        const namaInput = editJabatan.querySelector('#nama');
        const jabNowInput = editJabatan.querySelector('#jb_now');
        const optionsJabNew = editJabatan.querySelector('.jb_new');
        loadJabatanData(optionsJabNew);

        niyInput.value = niy;
        namaInput.value = nama;
        jabNowInput.value = jab_now;

        initFormValidation(editJabatan, {
            btnSelector: '.btn_simpan',
            fields: [
                '#niy',
                '#nama',
                '#jb_now',
                '#jb_new'
            ]
        });
    })
    btnSimpanJabatan.addEventListener('click', async function () {
        const niy = editJabatan.querySelector('#niy').value;
        const nama = editJabatan.querySelector('#nama').value.trim();
        const jb_new = editJabatan.querySelector('#jb_new').value.trim();

        console.log('sdassad', niy, nama, jb_new)
    })

    editAccess.addEventListener('hidden.bs.modal', function () {
        const niyInput = editAccess.querySelector('#niy');
        const namaInput = editAccess.querySelector('#nama');
        const roleNowInput = editAccess.querySelector('#rl_now');
        const roleNewInput = editAccess.querySelector('#rl_new');

        if (niyInput) niyInput.value = '';
        if (namaInput) namaInput.value = '';
        if (roleNowInput) roleNowInput.value = '';
        if (roleNewInput) roleNewInput.value = '';
    })
    editAccess.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // element yang klik
        const niy = button.getAttribute('data-niy');
        const nama = button.getAttribute('data-nama');
        const role_now = button.getAttribute('data-role-now');

        const niyInput = editAccess.querySelector('#niy');
        const namaInput = editAccess.querySelector('#nama');
        const roleNowInput = editAccess.querySelector('#rl_now');
        const optionsRoleNew = editAccess.querySelector('.rl_new');
        loadRoleData(optionsRoleNew);

        niyInput.value = niy;
        namaInput.value = nama;
        roleNowInput.value = role_now;

        initFormValidation(editAccess, {
            btnSelector: '.btn_simpan',
            fields: [
                '#niy',
                '#nama',
                '#rl_now',
                '#rl_new'
            ]
        });
    })
    btnSimpanAccess.addEventListener('click', async function () {
        const niy = editAccess.querySelector('#niy').value;
        const nama = editAccess.querySelector('#nama').value.trim();
        const role_code = editAccess.querySelector('#rl_new').value.trim();

        btnSimpanAccess.disabled = true;
        btnSimpanAccess.innerHTML = 'Menyimpan...';

        try {
            const result = await fetchJson('/_backend/logic/data-acl/update', {
                method: 'POST',
                body: {
                    niy: niy,
                    role_code: role_code
                }
            });
            const statusCode = result.statusCode;
            if (!statusCode || statusCode != 200) {
                throw result;
            } else {
                showToast('Data berhasil diperbarui', 'success');
                loadData(1);
            }
        } catch (e) {
			const code = e?.code;
			const message = e?.message ? e.message : 'Terjadi kesalahan pada sistem. Silahkan coba kembali';

            showToast(`Proses gagal dilakukan: ${message}`, 'error');
        } finally {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('edit_access')
            );
            modal.hide();

            btnSimpanAccess.disabled = false;
            btnSimpanAccess.innerHTML = 'Simpan Perubahan';
        }
    })

    async function loadRoleData(optionsRoleNew) {
        try {
            const result = await fetchJson('/_backend/logic/data-acl', {
                method: 'POST'
            });
            optionsRoleNew.innerHTML = '<option value="">Pilih</option>';
            result.data.forEach(item => {
                let option = document.createElement("option");
                option.value = item.code;
                option.text = item.nama;
                optionsRoleNew.appendChild(option);
            });
        } catch (e) {
            optionsRoleNew.innerHTML = '<option value="">Pilih</option>';
        }
    }
    
    async function loadJabatanData(optionsJabatanNew) {
        try {
            const result = await fetchJson('/_backend/logic/data-jabatan', {
                method: 'POST'
            });
            optionsJabatanNew.innerHTML = '<option value="">Pilih</option>';
            result.data.forEach(item => {
                let option = document.createElement("option");
                option.value = item.nama;
                option.text = item.nama;
                optionsJabatanNew.appendChild(option);
            });
        } catch (e) {
            optionsJabatanNew.innerHTML = '<option value="">Pilih</option>';
        }
    }

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
                        const accountId = item.adr_teacher.id;
                        const role =
                            item.role == 0 ? 'Admin' :
                            item.role == 1 ? 'User' :
                            '-';

                        tbody.innerHTML += `
                            <tr>
                                <td class="link-primary">${item.adr_teacher.niy}</td>
                                <td>${item.adr_teacher.nama ?? '-'}</td>
                                <td>${item.adr_teacher.email ?? '-'}</td>
                                <td>${role ?? '-'}</td>
                                <td>${item.adr_teacher.jabatan ?? '-'}</td>
                                <td>
                                    ${accountId == id_account ? '' : `
                                    <div class="hstack gap-2 fs-15">
                                        <a class="btn btn-icon btn-sm btn-soft-info rounded-pill tooltip-wrapper"
                                            data-niy="${item.adr_teacher.niy}"
                                            data-nama="${item.adr_teacher.nama}"
                                            data-role-now="${role}"
                                            data-bs-toggle="modal" data-bs-target="#edit_access">
                                                <i class="feather-unlock"></i>
                                                <span class="custom-tooltip">Ubah Akses</span>
                                        </a>
                                    </div>
                                    `}
                                </td>
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

    function initFormValidation(modal, config) {
        const btn = modal.querySelector(config.btnSelector);

        const fields = config.fields.map(selector => modal.querySelector(selector));

        const validate = () => {
            let isValid = fields.every(el => {
                if (!el) return false;
                return el.value?.toString().trim() !== "";
            });

            if (config.customValidate) {
                isValid = isValid && config.customValidate(fields);
            }

            btn.disabled = !isValid;
        };

        if (!modal.dataset.validationAttached) {
            fields.forEach(el => {
                if (!el) return;
                el.addEventListener('input', validate);
                el.addEventListener('change', validate);
            });

            modal.dataset.validationAttached = "true";
        }

        validate();

        return { validate };
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