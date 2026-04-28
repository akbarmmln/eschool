@extends(
    $role == '0' ? 'admin.app' : 'guru.app'
)
@section('content')

<style>
	.preview-container {
		width: 150px;
		height: 150px;
		overflow: hidden;
		border: 2px dashed #d1d5db;
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		background: #f3f4f6;
		position: relative;
	}

	.preview-container img {
		width: 100%;
		height: 100%;
		object-fit: contain;
	}
	
	.upload-box {
		width: 150px;
		height: 150px;
		border: 2px dashed #9ca3af;
		border-radius: 15px;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		overflow: hidden;
		position: relative;
		background: white;
	}
	.upload-box {
		z-index: 1;
	}
	.upload-box {
		box-shadow: 0 2px 6px rgba(0,0,0,0.05);
	}
	.upload-box:hover {
		border-color: #6366f1;
		background: #f9fafb;
	}

	.upload-placeholder {
		font-size: 40px;
		color: #aaa;
	}

	.preview-item {
		width: 150px;
		height: 150px;
		border-radius: 15px;
		overflow: hidden;
		position: relative;
		background: #f3f4f6;
	}

	.preview-item img {
		width: 100%;
		height: 100%;
		object-fit: contain;
	}

	.remove-btn {
		position: absolute;
		top: 6px;
		right: 6px;
		width: 26px;
		height: 26px;
		border-radius: 50%;
		border: none;
		background: rgba(0,0,0,0.6);
		color: white;
		font-size: 16px;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	/* hover biar keren */
	.remove-btn:hover {
		background: red;
	}
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Detail Jurnal</h3>
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Akademik</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Jurnal Mengajar</li>
					</ol>
				</nav>
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

		<div id="pagefailed" style="display: none;">
			<div class="card-body">
				<div class="row justify-content-center">
					<div id="status_page" class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
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

		<div id="pagesuccess1" style="display: none;" class="card col-md-12">
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-calendar-time"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Tanggal dan Jam Mengajar</h6>
								<p id="tgl_jam_mengajar" class="mb-0">-</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-door"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Kelas</h6>
								<p id="nama_kelas" class="mb-0">-</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-book"></i>
							</div>
							<div>
								<h6 class="materi-html mb-1 fw-bold">Materi</h6>
								<p id="materi" class="mb-0">-</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-school"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Jumlah Siswa</h6>
								<p id="jumlah_siswa" class="mb-0">-</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-brand-socket-io"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Refleksi</h6>
								<p id="refleksi" class="mb-0">-</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="bg-light-300 d-flex align-items-center p-3 mb-3">
							<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
								<i class="ti ti-user"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold">Pengajar</h6>
								<p id="pengajar" class="mb-0">-</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <div id="pagesuccess2" class="col-xxl-12 col-xl-12" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs nav-tabs-bottom mb-4">
                        <li class="nav-item">
                            <a href="#absensi" class="nav-link active" data-bs-toggle="tab">
                                <i class="ti ti-bookmark-edit me-2"></i>
                                Absensi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#penilaian" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-file-star me-2"></i>
                                Penilaian
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="absensi">
                            <div class="card">
								<div class="card-header">
									<h5>Daftar Kehadiran</h5>
								</div>
                                <div class="card-body">
                                    <div class="custom-datatable-filter table-responsive">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
													<th style="width:10%">No</th>
                                                    <th style="width:60%">Nama</th>
                                                    <th style="width:30%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemKehadiran">
                                            </tbody>
                                        </table>
										<div class="text-end mt-3">
											<button id="btnSubmitAbsensi" class="btn btn-primary">
												Simpan Absensi
											</button>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="penilaian">
                            <div class="card">
								<div class="card-header">
									<h5>Penilaian</h5>
								</div>
                                <div class="card-body">
									<div class="row justify-content-center">
										<div id="layout1" class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" style="display: block">
											<div class="card bg-white border-0">
												<div class="alert custom-alert1 alert-warning">
													<div class="text-center px-5 pb-0">
														<div class="custom-alert-icon">
															<i class="feather-alert-triangle flex-shrink-0"></i>
														</div>
														<h5 class="fw-bold text-uppercase text-warning mb-3">WARNING</h5>
														<p id="text_result" class="text-black mb-1">Silahkan lakukan absensi terlebih dahulu</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="layout2" class="custom-datatable-filter table-responsive" style="display: none;">
										<table class="table">
											<thead class="thead-light">
												<tr>
													<th style="width:10%">No</th>
													<th style="width:60%">Nama</th>
													<th style="width:30%">Aksi</th>
												</tr>
											</thead>
											<tbody id="itemPenilaian">
											</tbody>
										</table>
									</div>
                                    <div id="layout3" style="display: none;">
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
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<!-- /Page Wrapper -->

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalInputNilai" tabindex="-1"
	aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-fullscreen">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalFullscreenLabel"></h4>
			</div>
			<div class="modal-body">
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
											<a href="#" id="btnRefresh" class="btn btn-sm btn-warning m-1">Coba
												kembali</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="loadingSpinner" class="text-center my-3" style="display: none;">
					<button id="loadingSpinner" class="btn btn-info-light" type="button" disabled="">
						<span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
						Memuat data...
					</button>
				</div>
				<div id="pagesuccess" style="display: none;">
					<table class="table table-bordered align-middle">
						<thead class="table-light text-center">
							<tr>
								<th style="width:5%" rowspan="2">No</th>
								<th style="width:55%" rowspan="2">Aktifitas</th>
								<th style="width:10%" colspan="4">Hasil</th>
								<th style="width:30%" rowspan="2">Keterangan</th>
							</tr>
							<tr class="text-center">
								<th>BSB</th>
								<th>BSH</th>
								<th>MB</th>
								<th>BB</th>
							</tr>
						</thead>
						<tbody id="inputNilai">
						</tbody>
					</table>
					<div class="mt-4">
						<h4 class="mb-3">Upload Foto Tugas (Attachments)</h4>
						<div class="d-flex flex-wrap gap-3 align-items-start">
							<div id="imagePreviewContainerFromUpload" class="d-flex flex-wrap gap-3"></div>
							<div id="imagePreviewContainer" class="d-flex flex-wrap gap-3">
								<label class="upload-box">
									<input type="file" id="fileInput" multiple accept="image/*" hidden>
									<div class="upload-placeholder">+</div>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer d-flex gap-2">
				<button id="batal_input_nilai" type="button" class="btn btn-secondary">Tutup</button>
				<button id="simpan_input_nilai" type="button" class="btn btn-primary">Simpan</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalFile" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
			<div class="modal-header">
			    <h4 class="modal-title" id="exampleModalFullscreenLabel"></h4>
			</div>
			<div class="modal-body">
			    ....
			</div>
			<div class="modal-footer d-flex gap-2">
			    <button id="batal_input_file" type="button" class="btn btn-secondary">Batalkan</button>
				<button type="button" class="btn btn-primary">Simpan</button>
			</div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.6/dist/purify.min.js"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
	const id = @json($id);
    let itemIndex = 0;
	const spinner = document.getElementById("loadingSpinner");
	const pagefailed = document.getElementById("pagefailed");
	const pagesuccess1 = document.getElementById("pagesuccess1");
	const pagesuccess2 = document.getElementById("pagesuccess2");
	const layout1 = document.getElementById("layout1");
	const layout2 = document.getElementById("layout2");
    const layout3 = document.getElementById("layout3");
	const textResult = document.getElementById('text_result')

	const tglJamMengajar = document.getElementById('tgl_jam_mengajar')
	const namaKelas = document.getElementById('nama_kelas')
	const materiX = document.getElementById('materi')
	const refleksiX = document.getElementById('refleksi')
	const jumlahSiswa = document.getElementById('jumlah_siswa')
	const pengajar = document.getElementById('pengajar')

    let attr_id_diajar;
	let public_id_jurnal, public_id_diajar, public_id_siswa, public_nama_siswa;
	const modalInputNilai = document.getElementById('modalInputNilai')
	const modalFile = document.getElementById('modalFile')
	const btnRefresh = modalInputNilai.querySelector("#btnRefresh");
	const batalInputNilai = modalInputNilai.querySelector("#batal_input_nilai");
	const batalInputFile = modalFile.querySelector("#batal_input_file");
	const simpanInputNilai = modalInputNilai.querySelector("#simpan_input_nilai");

	const fileInput = document.getElementById('fileInput');
	const container = document.getElementById('imagePreviewContainer');
	let selectedFiles = [], deletedFiles = [];
	fileInput.addEventListener('change', async function (e) {
		const files = Array.from(e.target.files);
		for (const file of files) {
			let finalBase64;
			if (file.size > 2 * 1024 * 1024) {
				console.log('kena compress');
				finalBase64 = await compressToMaxSize(file, 2);
			} else {
				console.log('tidak kena compress');
				finalBase64 = await new Promise((resolve) => {
					const reader = new FileReader();
					reader.onload = (event) => resolve(event.target.result);
					reader.readAsDataURL(file);
				});
			}
			// ambil pure base64
			const pureBase64 = finalBase64.split(',')[1];
			selectedFiles.push(pureBase64);

			// preview
			const wrapper = document.createElement('div');
			wrapper.classList.add('preview-item');

			wrapper.innerHTML = `
				<img src="${finalBase64}">
				<button class="remove-btn">&times;</button>
			`;

			wrapper.querySelector('.remove-btn').addEventListener('click', () => {
				wrapper.remove();
				selectedFiles = selectedFiles.filter(f => f !== pureBase64);
			});

			container.insertBefore(wrapper, container.lastElementChild);
		}
		fileInput.value = "";
	});

	async function compressToMaxSize(file, maxSizeMB = 1, maxWidth = 1280) {
		const maxSize = maxSizeMB * 1024 * 1024;
		return new Promise((resolve) => {
			const reader = new FileReader();

			reader.onload = function (e) {
				const img = new Image();
				img.src = e.target.result;

				img.onload = function () {
					const canvas = document.createElement('canvas');
					const ctx = canvas.getContext('2d');

					let scale = Math.min(maxWidth / img.width, 1);
					canvas.width = img.width * scale;
					canvas.height = img.height * scale;

					ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

					let quality = 0.9;
					let base64;

					do {
						base64 = canvas.toDataURL('image/jpeg', quality);
						const size = Math.round((base64.length * 3) / 4); // estimasi size byte

						if (size <= maxSize || quality <= 0.3) break;

						quality -= 0.1; // turunin kualitas
					} while (true);

					resolve(base64);
				};
			};
			reader.readAsDataURL(file);
		});
	}

	batalInputNilai.addEventListener("click", function(){
		const modalInstance = bootstrap.Modal.getInstance(modalInputNilai);
		modalInstance.hide();
	});
	batalInputFile.addEventListener("click", function(){
		const modalInstance = bootstrap.Modal.getInstance(modalFile);
		modalInstance.hide();
	});
	simpanInputNilai.addEventListener("click", async function(){
		const btn = this;
		const result = [];
		const radios = modalInputNilai.querySelectorAll("input[type=radio]:checked");
		radios.forEach(radio => {
			const id = radio.dataset.id;
			const ketInput = modalInputNilai.querySelector(`input[type="text"][data-id="${id}"]`);

			result.push({
				id_mengajar: id,
				status: radio.value,
				keterangan: ketInput ? ketInput.value : null
			});
		});

		btn.disabled = true;
		btn.innerText = "Menyimpan data...";

		try {
            const hasil = await fetchJson('/_backend/logic/update-penilaian', {
                method: 'POST',
                body: {
					data: result,
					id_jurnal: public_id_jurnal,
					id_siswa: public_id_siswa,
					files: selectedFiles,
					filesDeleted: deletedFiles
				}				
            });
			if(!hasil.ok) {
				throw hasil;
			}

			showToast('Input penilaian berhasil dilakukan', 'success');
			const modalInstance = bootstrap.Modal.getInstance(modalInputNilai);
			modalInstance.hide();
		} catch(e) {
			const code = e?.code
			const message = e?.message
			if (code === '70011') {
				showToast(`Proses gagal dilakukan: ${message}`, 'success');
			} else {
				showToast(`Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`, 'success');
			}
		} finally {
			btn.disabled = false;
			btn.innerText = "Simpan";
		}
	});

	btnRefresh.addEventListener("click", async function(e){
		await loadDataModal(public_id_jurnal, public_id_diajar, public_id_siswa, public_nama_siswa);
	});

	modalInputNilai.addEventListener('hidden.bs.modal', function () {
		const judulModal = modalInputNilai.querySelector('#exampleModalFullscreenLabel');
		const loading = modalInputNilai.querySelector('#loadingSpinner');
		const pagefailed = modalInputNilai.querySelector("#pagefailed");
		const textResult = modalInputNilai.querySelector('#text_result')
		const tbody = modalInputNilai.querySelector("#inputNilai");

		tbody.innerHTML = "";
		pagesuccess.style.display = "none";
		pagefailed.style.display = "none";
		loading.style.display = "none";
		judulModal.innerText = "";
		textResult.textContent = '';
		public_id_jurnal = null;
		public_id_diajar  = null;
		public_nama_siswa  = null;
		selectedFiles = [];
		deletedFiles = [];
		container.querySelectorAll('.preview-item').forEach(el => el.remove());
		container.querySelectorAll('.preview-container').forEach(el => el.remove());
		fileInput.value = "";
	})
	modalInputNilai.addEventListener('show.bs.modal', async function (event) {
		const button = event.relatedTarget;
		public_id_jurnal = button.getAttribute('data-idJurnal');
		public_id_diajar = button.getAttribute('data-idDiajar');
		public_id_siswa = button.getAttribute('data-idSiswa');
		public_nama_siswa = button.getAttribute('data-namaSiswa');

		await loadDataModal(public_id_jurnal, public_id_diajar, public_id_siswa, public_nama_siswa);
	})

	async function loadDataModal(id_jurnal, id_diajar, id_siswa, nama_siswa) {
		const judulModal = modalInputNilai.querySelector('#exampleModalFullscreenLabel');
		const pagesuccess = modalInputNilai.querySelector("#pagesuccess");
		const pagefailed = modalInputNilai.querySelector("#pagefailed");
		const textResult = modalInputNilai.querySelector('#text_result')
		const loading = modalInputNilai.querySelector('#loadingSpinner');

		pagesuccess.style.display = "none";
		pagefailed.style.display = "none";
		loading.style.display = "block";

		judulModal.innerText = "Input Nilai - " + nama_siswa;

		try {
            const result = await fetchJson('/_backend/logic/inisiasi-penilaian', {
                method: 'POST',
                body: {
					id_jurnal: id_jurnal,
					id_siswa: id_siswa,
					id_diajar: id_diajar
                }
            });
            if(!result.ok) {
				throw result;
			}
			pagesuccess.style.display = "block";
			renderPenilaian(result.data);
		} catch(e) {
			const code = e?.code
			const message = e?.message
			textResult.textContent = `Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`;
			pagefailed.style.display = "block";
			pagesuccess.style.display = "none";
		} finally {
			loading.style.display = "none";
		}
	}

	function renderPenilaian(data) {
		const dataNilai = data.silabus;
		const dataImages = data.attachments;
		const tbody = modalInputNilai.querySelector("#inputNilai");
		let html = "";
		let no = 1;
		dataNilai.forEach(subject => {
			subject.items.forEach(item => {
				const bsb = item.nilai == '1' ? "checked" : "";
				const bsh = item.nilai == '2' ? "checked" : "";
				const mb  = item.nilai == '3' ? "checked" : "";
				const bb  = item.nilai == '4' ? "checked" : "";

				html += `
				<tr>
					<td class="text-center">${no++}</td>
					<td>${item.nama_item}</td>

					<td class="text-center">
						<input type="radio" name="nilai_${item.id}" data-id="${item.id}" value="1" ${bsb}>
					</td>

					<td class="text-center">
						<input type="radio" name="nilai_${item.id}" data-id="${item.id}" value="2" ${bsh}>
					</td>

					<td class="text-center">
						<input type="radio" name="nilai_${item.id}" data-id="${item.id}" value="3" ${mb}>
					</td>

					<td class="text-center">
						<input type="radio" name="nilai_${item.id}" data-id="${item.id}" value="4" ${bb}>
					</td>
					<td>
						<input 
							type="text" 
							class="form-control form-control-sm" 
							name="ket_${item.id}"
							data-id="${item.id}"
							value="${item.keterangan ?? ''}">
					</td>
				</tr>
				`;
			})
		})
		tbody.innerHTML = html;
		renderUploadedImages(dataImages)
	}
	
	function renderUploadedImages(imageUrls = []) {
		const container = document.getElementById('imagePreviewContainerFromUpload');
		container.innerHTML = '';
		imageUrls.forEach(url => {
			const id_img = url.id
			const img = url.url_image;
			const wrapper = document.createElement('div');
			wrapper.classList.add('preview-container');

			wrapper.innerHTML = `
				<img src="${img}">
				<button class="remove-btn">&times;</button>
			`;

			// tombol hapus (optional)
			wrapper.querySelector('.remove-btn').addEventListener('click', () => {
				wrapper.remove();
				deletedFiles.push(id_img);
			});
			container.appendChild(wrapper);
		});
	}

	document.getElementById("btnRefresh").addEventListener("click", function(e){
		e.preventDefault();
		location.reload();
	});

	document.addEventListener("DOMContentLoaded", async function () {
		spinner.style.display = "block";
		pagefailed.style.display = "none";

		try {
            const result = await fetchJson('/_backend/logic/jurnal-detail', {
                method: 'POST',
                body: {
                    id: id
                }
            });
			if(!result.ok) {
				throw result
			}

			const id_jurnal = result.data.jurnal.id;
			const tanggal = result.data.jurnal.tanggal_jurnal;
			const jam_mulai = result.data.jurnal.jam_mulai;
			const jam_selesai = result.data.jurnal.jam_selesai;
			const materi = result.data.jurnal.materi;
			const refleksi = result.data.jurnal.refleksi;
			const nama_kelas = result.data.jurnal.nama_kelas;
			const nama_guru = result.data.jurnal.nama_guru;
			const initiate_absensi = result.data.jurnal.initiate_absensi;
			const initiate_nilai = result.data.jurnal.initiate_nilai;
			const data_siswa = result.data.siswa;
            attr_id_diajar = [...new Set(data_siswa.map(item => item.id))];

			if (initiate_absensi == 0 && initiate_nilai == 0) {
				layout1.style.display = "block";
				layout2.style.display = "none";
                layout3.style.display = "none";
			} else if (initiate_absensi == 1 && initiate_nilai == 0) {
				layout1.style.display = "none";
				layout2.style.display = "none";
                layout3.style.display = "block";
			} else {
				layout1.style.display = "none";
				layout2.style.display = "block";
                layout3.style.display = "none";
			}

			pagesuccess1.style.display = "block";
			pagesuccess2.style.display = "block";
			pagefailed.style.display = "none";

			const tbody = document.getElementById("itemKehadiran");
            tbody.innerHTML = "";
			const tbodyItemPenilaian = document.getElementById("itemPenilaian");
            tbodyItemPenilaian.innerHTML = "";

			tglJamMengajar.innerHTML = `${dateFormatIndo(tanggal)} • ${jam_mulai} - ${jam_selesai} WIB`
			namaKelas.innerHTML = `${nama_kelas}`
			materiX.innerHTML = `${DOMPurify.sanitize(materi)}`
			refleksiX.innerHTML = `${refleksi}`
			jumlahSiswa.innerHTML = `${data_siswa.length} Siswa`
			pengajar.innerHTML = `${nama_guru}`

			loadItemKehadiran(data_siswa, tbody);
			loadItemSilabus(id_jurnal, data_siswa, tbodyItemPenilaian)
		} catch(e) {
			const code = e?.code
			const message = e?.message
			if (code === '70008') {
				textResult.textContent = `Proses gagal dilakukan: ${message}`;
			} else {
				textResult.textContent = `Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`;
			}
			
			pagesuccess1.style.display = "none";
			pagesuccess2.style.display = "none";
			pagefailed.style.display = "block";
		} finally {
			spinner.style.display = "none";
		}
	});

	function loadItemKehadiran(dataSiswa, tbody) {
		let no = 1;
		dataSiswa.forEach((item) => {
			const hadirChecked = item.absensi === '1' ? "checked" : "";
			const ijinChecked  = item.absensi === '2' ? "checked" : "";
			const sakitChecked = item.absensi === '3' ? "checked" : "";
			const alphaChecked = item.absensi === '4' ? "checked" : "";

			const row = `
				<tr>
					<td>${no++}.</td>
					<td>${item.nama_siswa}</td>
					<td>
						<div class="d-flex align-items-center check-radio-group flex-nowrap">
							<label class="custom-radio">
								<input type="radio" name="student_${item.id}" data-id="${item.id}" value="1" ${hadirChecked}>
								<span class="checkmark"></span>
								Hadir
							</label>

							<label class="custom-radio">
								<input type="radio" name="student_${item.id}" data-id="${item.id}" value="2" ${ijinChecked}>
								<span class="checkmark"></span>
								Ijin
							</label>

							<label class="custom-radio">
								<input type="radio" name="student_${item.id}" data-id="${item.id}" value="3" ${sakitChecked}>
								<span class="checkmark"></span>
								Sakit
							</label>

							<label class="custom-radio">
								<input type="radio" name="student_${item.id}" data-id="${item.id}" value="4" ${alphaChecked}>
								<span class="checkmark"></span>
								Alpha
							</label>
						</div>
					</td>
				</tr>
			`;
			tbody.insertAdjacentHTML("beforeend", row);
		})
	}

	function loadItemSilabus(idJurnal, dataSiswa, tbody) {
		let no = 1;
		dataSiswa.forEach((item) => {
			const idSiswa = item.id_siswa
			const row = `
				<tr>
					<td>${no++}.</td>
					<td>${item.nama_siswa}</td>
					<td>
						<div class="d-flex gap-2">
							<button class="btn btn-sm btn-success btn-wave waves-effect waves-light btn_download"
								data-idJurnal="${idJurnal}" 
								data-idDiajar="${item.id}" 
								data-namaSiswa="${item.nama_siswa}">
									<i class="ti ti-download align-middle me-2 d-inline-block"></i>Download
							</button>
							<a class="btn btn-sm btn-info btn-wave waves-effect waves-light btn-input-nilai"
								data-bs-toggle="modal" data-bs-target="#modalInputNilai"
								data-idJurnal="${idJurnal}" data-idSiswa="${idSiswa}" data-idDiajar="${item.id}" data-namaSiswa="${item.nama_siswa}">
									<i class="ti ti-edit align-middle me-2 d-inline-block"></i>Input Nilai
							</a>
							<a class="btn btn-sm btn-secondary btn-wave waves-effect waves-light btn-file"
								data-bs-toggle="modal" data-bs-target="#modalFile"
								data-idJurnal="${idJurnal}" data-idDiajar="${item.id}" data-namaSiswa="${item.nama_siswa}">
									<i class="text-black ti ti-brand-appgallery align-middle me-2 d-inline-block"></i><span class="text-black">File lainnya</span>
							</a>
						</div>
					</td>
				</tr>
			`;
			tbody.insertAdjacentHTML("beforeend", row);
		})
	}

	document.getElementById("btnSubmitAbsensi").addEventListener("click", async function() {
		const btn = this;
    	btn.disabled = true;
		btn.innerText = "Menyimpan data...";

		const result = [];
		const radios = document.querySelectorAll("input[type=radio]:checked");
		radios.forEach(radio => {
			result.push({
				id_detail_diajar: radio.dataset.id,
				status: radio.value
			});
		});

		try {
            const hasil = await fetchJson('/_backend/logic/jurnal-update-absensi', {
                method: 'POST',
                body: {
                    id: id,
                    absensi: result
                }
            });
			if(!hasil.ok) {
				throw hasil;
			}
			showToast('Data absensi berhasil disimpan', 'success');
			const initiate_nilai = hasil.data.initiate_nilai;
			if (initiate_nilai == 0) {
				layout1.style.display = "none";
				layout2.style.display = "none";
				layout3.style.display = "block";
			} else {
				layout1.style.display = "none";
				layout2.style.display = "block";
				layout3.style.display = "none";
			}
		} catch(e) {
			const code = e?.code
			const message = e?.message
			if (code === '70011') {
				showToast(`Proses gagal dilakukan: ${message}`, 'success');
			} else {
				showToast(`Terjadi kesalahan saat memproses data. Silahkan ulangi kembali`, 'success');
			}
			layout1.style.display = "block";
			layout2.style.display = "none";
            layout3.style.display = "none";
		} finally {
            btn.disabled = false;
			btn.innerText = "Simpan Absensi";
		}
	});

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
    document.querySelector('.simpanData').addEventListener("click", async function () {
        const btn = this;
    	btn.disabled = true;
		btn.innerText = "Menyimpan data...";

        const judul = document.querySelector('input[name="judul"]').value;
        const itemInputs = document.querySelectorAll('#itemContainer input[name^="items"]');
        let items = [];
        itemInputs.forEach(input => {
            if (input.value.trim() !== "") {
                items.push(input.value.trim());
            }
        });

        if (!judul) {
            showToast('Grup/Judul wajib diisi', 'success');
            return;
        }
        if (items.length == 0) {
            showToast('Item aktivitas penilaian minimal 1 dilakukan', 'success');
            return;
        }
        
		try {
            const result = await fetchJson('/_backend/logic/submit-item-penilaian', {
                method: 'POST',
                body: {
					id_jurnal: id,
					id_diajar: attr_id_diajar,
					judul: judul,
					item_penilaian: items
				}
            });
			if(!result.ok) {
				throw result
			}
			showToast('Data Item Penilaian berhasil disimpan', 'success');
			layout1.style.display = "none";
			layout2.style.display = "block";
            layout3.style.display = "none";
		} catch(e) {
			const code = e?.code
			const message = e?.message
            showToast('Terjadi kesalahan saat memproses data. Silahkan ulangi kembali');
			layout1.style.display = "none";
			layout2.style.display = "none";
            layout3.style.display = "block";
		} finally {
            btn.disabled = false;
			btn.innerText = "Simpan Data";
		}
    })

	document.addEventListener("click", async function(e) {
		const btn = e.target.closest(".btn_download");
		if (!btn) return;

		btn.disabled = true;
		btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Menyiapkan file...`;

		const idJurnal = btn.dataset.idjurnal;
		const idDiajar = btn.dataset.iddiajar;
		const namaSiswa = btn.dataset.namasiswa;
		
		try {
            const result = await fetchJson('/_backend/logic/download-single-penilaian-harian', {
                method: 'POST',
                body: {
					id_jurnal: idJurnal,
					id_detail_diajar: idDiajar,
					nama_siswa: namaSiswa
                }
            });
			if(!result.ok) {
				throw result;
			}
			downloadPdfFromBase64(result.data);
		} catch (e) {
			const code = e?.code
			const message = e?.message
            showToast('Terjadi kesalahan saat memproses data. Silahkan ulangi kembali');
		} finally {
			btn.disabled = false;
			btn.innerHTML = `<i class="ti ti-download align-middle me-2 d-inline-block"></i>Download`;
		}
	});

	//not open window
	function downloadPdfFromBase64(base64, filename = 'file.pdf') {
		const byteCharacters = atob(base64);
		const byteNumbers = new Array(byteCharacters.length)
			.fill(0)
			.map((_, i) => byteCharacters.charCodeAt(i));

		const byteArray = new Uint8Array(byteNumbers);

		const blob = new Blob([byteArray], { type: "application/pdf" });

		const url = URL.createObjectURL(blob);

		// 🔥 buat link download
		const a = document.createElement("a");
		a.href = url;
		a.download = filename;
		document.body.appendChild(a);
		a.click();

		// cleanup
		a.remove();
		URL.revokeObjectURL(url);
	}

	//open window
	function openPdfFromBase64(base64) {
		// convert base64 ke binary
		const byteCharacters = atob(base64);
		const byteNumbers = new Array(byteCharacters.length)
			.fill(0)
			.map((_, i) => byteCharacters.charCodeAt(i));

		const byteArray = new Uint8Array(byteNumbers);

		// buat blob PDF
		const blob = new Blob([byteArray], { type: "application/pdf" });

		// buat URL
		const blobUrl = URL.createObjectURL(blob);
		// buka di tab baru
		window.open(blobUrl, "_blank");
	}

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

    function dateFormatIndo(date) {
        const d = new Date(date);

        return d.toLocaleDateString("id-ID", {
            weekday: "long",
            day: "2-digit",
            month: "long",
            year: "numeric"
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


