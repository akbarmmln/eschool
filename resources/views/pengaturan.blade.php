@extends('admin.app')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Pengaturan</h3>
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item">
							<a href="javascript:void(0);">Akademik</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Pengaturan Website</li>
					</ol>
				</nav>
			</div>
		</div>
		<!-- /Page Header -->

						<div id="pagesuccess" class="flex-fill border-start ps-3" style="display: none;">
							<form id="form-pengaturan">
								<div class="d-flex align-items-center justify-content-between flex-wrap border-bottom pt-3 mb-3">
									<div class="mb-3">
										<h5></h5>
										<p></p>
									</div>
									<div class="mb-3">
                                        <a id="batalkan" class="d-none btn btn-light me-2" type="button">Batalkan</a>
										<a id="simpan" class="d-none btn btn-primary me-2" type="button">Simpan</a>
										<a id="ubah" class="btn btn-primary" type="submit">Ubah</a>
									</div>
								</div>
								<div class="d-md-flex d-block">
									<div class="flex-fill">
										<div class="card">
											<div class="card-header">
												<h5><b>Informasi Dasar</b></h5>
											</div>
											<div class="card-body pb-1">
												<div class="d-block d-xl-flex">
													<div class="mb-3 flex-fill me-xl-3 me-0">
														<label class="form-label">Nama Yayasan</label>
														<input id="nama_yayasan" type="text" class="form-control">
													</div>
													<div class="mb-3 flex-fill">
														<label class="form-label">Nomor telepon</label>
														<input id="no_telp" type="number" class="form-control">
													</div>
												</div>
												<div class="d-block d-xl-flex">
													<div class="mb-3 flex-fill me-xl-3 me-0">
														<label class="form-label">Alamat Email</label>
														<input id="email" type="text" class="form-control">
													</div>
													<div class="mb-3 flex-fill">
														<label class="form-label">Website</label>
														<input id="website" type="text" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header">
												<h5><b>Informasi Alamat</b></h5>
											</div>
											<div class="card-body pb-1">
												<div class="mb-3">
													<label class="form-label">Alamat</label>
													<input id="alamat" type="text" class="form-control">
												</div>
												<div class="d-block d-xl-flex">
													<div class="mb-3 flex-fill me-xl-3 me-0">
														<label class="form-label">Negara</label>
														<input id="negara" type="text" class="form-control">
													</div>
													<div class="mb-3 flex-fill">
														<label class="form-label">Provinsi</label>
														<input id="provinsi" type="text" class="form-control">
													</div>
												</div>
												<div class="d-block d-xl-flex">
													<div class="mb-3 flex-fill me-xl-3 me-0">
														<label class="form-label">Kota / Kabupaten</label>
														<input id="kota_kab" type="text" class="form-control">
													</div>
													<div class="mb-3 flex-fill">
														<label class="form-label">Kode Pos</label>
														<input id="kodepos" type="number" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header">
												<h5><b>Informasi Kepengurusan</b></h5>
											</div>
                                            <div class="card-body pb-1">
                                                <div class="mb-3">
                                                    <label class="form-label">Kepala Yayasan</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="kepalaSekolah">
                                                        <!-- <input type="hidden" readonly class="form-control" id="idHidden">
                                                        <button class="btn btn-primary" type="button"
                                                            data-bs-toggle="modal" data-bs-target="#modalKepsek">
                                                                <i class="ti ti-search"></i> Cari
                                                        </button> -->
                                                    </div>
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
							</form>
						</div>

                        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalKepsek" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pilih Kepala Sekolah</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listGuru">
                                                <!-- diisi via JS / backend -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

		<div id="loadingSpinner" style="display: none;" class="card">
			<div class="card-body">
                <div class="text-center my-3">
                    <button id="loadingSpinner" class="btn btn-info-light" type="button" disabled="">
                        <span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
                            Memuat data...
                    </button>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- /Page Wrapper -->

<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
    let temp;
    const modals = document.getElementById('modalKepsek');
    const pagesuccess = document.getElementById('pagesuccess');
    const loadingSpinner = document.getElementById('loadingSpinner');

    const namaYayasan = document.getElementById('nama_yayasan');
    const noTelp = document.getElementById('no_telp');
    const emailN = document.getElementById('email');
    const websiteN = document.getElementById('website');
    const alamatN = document.getElementById('alamat');
    const negaraN = document.getElementById('negara');
    const provinsiN = document.getElementById('provinsi');
    const kotaKab = document.getElementById('kota_kab');
    const kodePos = document.getElementById('kodepos');
    const kepalaSekolah = document.getElementById('kepalaSekolah');

    const buttonUbah = document.getElementById('ubah');
    const buttonSimpan = document.getElementById('simpan');
    const buttonBatalkan = document.getElementById('batalkan');

    buttonUbah.addEventListener('click', function () {
        buttonUbah.classList.add("d-none");
        buttonSimpan.classList.remove("d-none");
        buttonBatalkan.classList.remove("d-none");

        namaYayasan.readOnly = false;
        noTelp.readOnly = false;
        emailN.readOnly = false;
        websiteN.readOnly = false;
        alamatN.readOnly = false;
        negaraN.readOnly = false;
        provinsiN.readOnly = false;
        kotaKab.readOnly = false;
        kodePos.readOnly = false;
        kepalaSekolah.readOnly = true;
    })
    buttonBatalkan.addEventListener('click', function () {
        buttonUbah.classList.remove("d-none");
        buttonSimpan.classList.add("d-none");
        buttonBatalkan.classList.add("d-none");

        namaYayasan.value = temp.settings.nama_yayasan
        namaYayasan.readOnly = true;
        noTelp.value = temp.settings.nomor_telepon
        noTelp.readOnly = true;
        emailN.value = temp.settings.alamat_email
        emailN.readOnly = true;
        websiteN.value = temp.settings.website
        websiteN.readOnly = true;
        alamatN.value = temp.settings.alamat
        alamatN.readOnly = true;
        negaraN.value = temp.settings.negara
        negaraN.readOnly = true;
        provinsiN.value = temp.settings.provinsi
        provinsiN.readOnly = true;
        kotaKab.value = temp.settings.kota_kab
        kotaKab.readOnly = true;
        kodePos.value = temp.settings.kode_pos
        kodePos.readOnly = true;
        kepalaSekolah.value = `${temp.teacher.niy} - ${temp.teacher.nama}`
        kepalaSekolah.readOnly = true;
    })

    modals.addEventListener('hidden.bs.modal', function () {
        console.log('1')
    });
    modals.addEventListener('show.bs.modal', function (event) {
        console.log('2')
    });

    document.addEventListener("DOMContentLoaded", async function () {
        namaYayasan.readOnly = true;
        noTelp.readOnly = true;
        emailN.readOnly = true;
        websiteN.readOnly = true;
        alamatN.readOnly = true;
        negaraN.readOnly = true;
        provinsiN.readOnly = true;
        kotaKab.readOnly = true;
        kodePos.readOnly = true;
        kepalaSekolah.readOnly = true;

        buttonUbah.classList.remove("d-none");
        buttonSimpan.classList.add("d-none");
        buttonBatalkan.classList.add("d-none");

        pagesuccess.style.display = 'none';
        loadingSpinner.style.display = 'block';

        try {
            const result = await fetchJson('/_backend/logic/settings', {
                method: 'POST'
            });
            pagesuccess.style.display = 'block';
            temp = result.data

            namaYayasan.value = temp.settings.nama_yayasan
            noTelp.value = temp.settings.nomor_telepon
            emailN.value = temp.settings.alamat_email
            websiteN.value = temp.settings.website
            alamatN.value = temp.settings.alamat
            negaraN.value = temp.settings.negara
            provinsiN.value = temp.settings.provinsi
            kotaKab.value = temp.settings.kota_kab
            kodePos.value = temp.settings.kode_pos
            kepalaSekolah.value = `${temp.teacher.niy} - ${temp.teacher.nama}`
        } catch (e) {

        } finally {
            loadingSpinner.style.display = 'none';
        }
    })
</script>
@endsection