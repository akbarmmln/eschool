@extends('ortu.app')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
			<div class="my-auto mb-2">
				<h3 class="page-title mb-1">Beranda</h3>
			</div>
		</div>
		<!-- /Page Header -->
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
    
    <div class="modal fade" id="add_jurnal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah Jurnal Mengajar</h4>
					<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
						<i class="ti ti-x"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
                                <label class="form-label">Hari / Tanggal Mengajar</label>
                                <div class="date-pic">
									<input type="text" id="tanggal" class="form-control datepickerBuatan" placeholder="">
									<span class="cal-icon"><i class="ti ti-calendar"></i></span>
								</div>
							</div>
							<div class="mb-3">
								<label class="form-label">Kelas</label>
								<select id="kelas" class="form-control kelas">
									<option value="">Pilih</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Jam Mulai</label>
								<div class="date-pic">
									<input type="time" id="jam_mulai" class="form-control jam_mulai">
								</div>
							</div>											
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Jam Selesai</label>
								<div class="date-pic">
									<input type="time" id="jam_selesai" class="form-control jam_selesai">
								</div>
							</div>											
						</div>
						<div class="mb-3">
							<label class="form-label">Materi Pembelajaran</label>
                            <textarea rows="3" id="materi" class="form-control materi" placeholder="Tuliskan materi yang diajarkan..."></textarea>
						</div>
						<div class="mb-3">
							<label class="form-label">Refleksi Pembelajaran</label>
                            <textarea rows="3" id="reflesi" class="form-control reflesi" placeholder="Tuliskan refleksi pembelajaran..."></textarea>
						</div>
                    </div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batalkan</a>
					<button type="submit" class="btn btn-primary btn_simpan_edit">Lanjutkan</button>
				</div>	
			</div>
		</div>
	</div>

    <div class="modal fade" id="cari_jurnal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Cari Jurnal Mengajar</h4>
					<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
						<i class="ti ti-x"></i>
					</button>
				</div>
                <div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Dari</label>
                                <div class="date-pic">
									<input type="text" id="dari" class="form-control datepickerBuatan" placeholder="">
                                    <span class="cal-icon"><i class="ti ti-calendar"></i></span>
								</div>
							</div>											
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Sampai</label>
                                <div class="date-pic">
									<input type="text" id="sampai" class="form-control datepickerBuatan" placeholder="">
                                    <span class="cal-icon"><i class="ti ti-calendar"></i></span>
								</div>
							</div>											
						</div>
                    </div>
                </div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batalkan</a>
					<button type="submit" class="btn btn-primary btn_cari">Cari</button>
				</div>	
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.js"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
</script>
@endsection