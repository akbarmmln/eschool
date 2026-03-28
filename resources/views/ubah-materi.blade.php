@extends('admin.app')
@section('content')
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Perubahan Materi Pembelajaran & Item Penilaian</h3>
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

        <div class="card" id="pagefailed" style="display: none;">
            <div class="card-body">
                Data tidak tersedia
            </div>
        </div>

		<div class="card" id="page" style="display: none;">
            <div id="alertContainer"></div>
            <div class="card-body">
                <input type="hidden" id="silabusId" value="{{ $id }}"/>

                <!-- Judul -->
                <div class="mb-3">
                    <label class="form-label">Grup/Judul Pembelajaran</label>
                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan Grup/Judul pembelajaran">
                </div>

                <!-- Item Container -->
                <div id="itemContainer"></div>

                <!-- Tombol Tambah Item -->
                <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
                    <i class="ti ti-plus"></i> Tambah Item
                </button>

                <button type="button" class="btn btn-sm btn-primary simpanData">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>  
            </div>
        </div>
    </div>
</div>

	<div id="success-alert-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content modal-filled bg-success">
				<div class="modal-body p-4">
					<div class="text-center">
						<i class="dripicons-checkmark h1 text-white"></i>
						<h5 class="fw-bold text-white text-uppercase text-warning mb-3">BERHASIL</h5>
						<p class="mt-3 text-white">Data berhasil dilakukan perubahan
						</p>
						<button type="button" id="btnContinueSuccess" class="btn btn-light me-2 my-2" data-bs-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
    const materiId = @json($id);
    const spinner = document.getElementById("loadingSpinner");
    const page = document.getElementById("page");
    const pagefailed = document.getElementById("pagefailed");
    const itemsContainer = document.getElementById("itemContainer");
    const addItemBtn = document.getElementById("addItemBtn");
    const btnSimpan = document.querySelector('.simpanData');

    btnSimpan.addEventListener("click", function () {
        const silabusId = document.getElementById("silabusId").value;
        const judul = document.querySelector('input[name="judul"]').value;
        if (!judul) {
            showAlert('Grup/Judul wajib diisi', 'success');
            return;
        }

        btnSimpan.disabled = true;
        btnSimpan.innerHTML = 'Menyimpan...';

        const payload = [];
        document.querySelectorAll(".item-row").forEach(row => {
            const textInput = row.querySelector('input[type="text"]');
            const hiddenInput = row.querySelector('input[type="hidden"]');

            payload.push({
                id: hiddenInput ? hiddenInput.value : null,
                name: textInput.value
            });
        });

        fetch('/_backend/logic/data-silabus-update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                id: silabusId,
                judul: judul,
                items: payload
            })
        })
        .then(async res => {
            const statusCode = res.status;
            const data = await res.json();

            if (!statusCode || statusCode != 200) {
                showToast('Data gagal dilakukan perubahan', 'error');
                return;
            } else {
                const modalElement = document.getElementById("success-alert-modal");
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        })
        .catch(error => {
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error')
            return;
        })
        .finally(() => {
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = 'Simpan Perubahan';
        });
    })

    document.getElementById("btnContinueSuccess").addEventListener("click", function () {
        const modalElement = document.getElementById("success-alert-modal");
        const id = modalElement.dataset.id;

        window.location.href = "{{ route('materi') }}";
    });


    document.addEventListener("DOMContentLoaded", function () {
        spinner.style.display = "block";
        page.style.display = "none";

        fetch('/_backend/logic/data-silabus-search-id', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                materiId: materiId
            })
        })
        .then(async res => {
            const statusCode = res.status;
            const data = await res.json();

            if (!statusCode || statusCode != 200) {
                page.style.display = "none";
                pagefailed.style.display = "block";
            } else {
                page.style.display = "block";
                pagefailed.style.display = "none";

                document.getElementById("silabusId").value = data.data.id;
                document.getElementById("judul").value = data.data.title;

                itemsContainer.innerHTML = "";
                data.data.items.forEach((item, index) => {
                    renderItem(item, index);
                });
            }
        })
        .catch(error => {
            showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error')
        })
        .finally(() => {
            spinner.style.display = "none";
        });
    });
    
    addItemBtn.addEventListener("click", () => {
        const index = document.querySelectorAll(".item-row").length;

        renderItem({}, index);
    });
    
    function renderItem(item = {}, index) {
        const wrapper = document.createElement("div");
        wrapper.classList.add("bg-light-300", "border", "rounded", "p-3", "mb-3", "item-row");

        wrapper.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                
                ${item.id ? `<input type="hidden" name="item_ids[${index}]" value="${item.id}">` : ''}

                <input type="text" 
                    name="items[${index}]" 
                    class="form-control" 
                    value="${item.name || ''}"
                    placeholder="Isi item Penilaian"
                    required>

                <button type="button" 
                        class="btn btn-sm btn-dark removeItemBtn">
                    <i class="ti ti-trash"></i>
                </button>

            </div>
        `;

        wrapper.querySelector(".removeItemBtn").addEventListener("click", () => {
            wrapper.remove();
            reindexItems();
        });

        itemsContainer.appendChild(wrapper);
    }

    function reindexItems() {
        const rows = document.querySelectorAll(".item-row");

        rows.forEach((row, index) => {
            // Update input text
            const textInput = row.querySelector('input[type="text"]');
            if (textInput) {
                textInput.name = `items[${index}]`;
            }

            // Update hidden id jika ada
            const hiddenInput = row.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                hiddenInput.name = `item_ids[${index}]`;
            }
        });
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