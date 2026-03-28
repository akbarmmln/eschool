@extends('admin.app')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Form Penambahan Materi Pembelajaran & Item Penilaian</h3>
			</div>
		</div>
		<!-- /Page Header -->

		<div class="card">
            <div id="alertContainer"></div>
            <div class="card-body">
                <!-- Judul -->
                <div class="mb-3">
                    <label class="form-label">Grup/Judul Pembelajaran</label>
                    <input type="text" name="judul" class="form-control" placeholder="Masukkan Grup/Judul pembelajaran">
                </div>

                <!-- Item Container -->
                <div id="itemContainer"></div>

                <!-- Tombol Tambah Item -->
                <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
                    <i class="ti ti-plus"></i> Tambah Item
                </button>

                <button type="button" class="btn btn-sm btn-primary simpanData">
                    <i class="ti ti-device-floppy"></i> Simpan Data
                </button>  
            </div>
        </div>
    </div>
</div>
<!-- /Page Wrapper -->

	<div id="success-alert-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content modal-filled bg-success">
				<div class="modal-body p-4">
					<div class="text-center">
						<i class="dripicons-checkmark h1 text-white"></i>
						<h5 class="fw-bold text-white text-uppercase text-warning mb-3">BERHASIL</h5>
						<p class="mt-3 text-white">Data berhasil dibuat
						</p>
						<button type="button" id="btnContinueSuccess" class="btn btn-light me-2 my-2" data-bs-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
    let itemIndex = 0;

    const btnSimpan = document.querySelector('.simpanData');

    function createItemField(index) {
        return `
            <div class="bg-light-300 border rounded p-3 mb-3 item-row">
                <div class="d-flex align-items-center gap-2">

                    <input type="text" 
                        name="items[${index}]" 
                        class="form-control" 
                        placeholder="Isi item Penilaian">

                    <button type="button" 
                            class="btn btn-sm btn-dark removeItemBtn">
                        <i class="ti ti-trash"></i>
                    </button>

                </div>
            </div>
        `;
    }

    document.getElementById("addItemBtn").addEventListener("click", function () {
        const container = document.getElementById("itemContainer");
        container.insertAdjacentHTML("beforeend", createItemField(itemIndex));
        itemIndex++;
    });

    document.addEventListener("click", function(e) {
        if (e.target.closest(".removeItemBtn")) {
            e.target.closest(".item-row").remove();
        }
    });

    btnSimpan.addEventListener("click", function () {
        const judul = document.querySelector('input[name="judul"]').value;
        const itemInputs = document.querySelectorAll('#itemContainer input[name^="items"]');
        let items = [];
        itemInputs.forEach(input => {
            if (input.value.trim() !== "") {
                items.push(input.value.trim());
            }
        });

        if (!judul) {
            showAlert('Grup/Judul wajib diisi', 'success');
            return;
        }
        
        btnSimpan.disabled = true;
        btnSimpan.innerHTML = 'Menyimpan...';

        fetch('/_backend/logic/data-silabus-create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                judul: judul,
                items: items
            })
        })
        .then(async res => {
            const statusCode = res.status;
            const data = await res.json();

            if (!statusCode || statusCode != 200) {
                showToast('Data gagal ditambahkan', 'error');
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
            btnSimpan.innerHTML = 'Simpan Data';
        });
    })

    document.getElementById("btnContinueSuccess").addEventListener("click", function () {
        const modalElement = document.getElementById("success-alert-modal");
        const id = modalElement.dataset.id;

        window.location.href = "{{ route('materi') }}";
    });

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