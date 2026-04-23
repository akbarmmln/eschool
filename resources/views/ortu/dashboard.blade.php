@extends('ortu.app')
@section('content')
<style>
.shimmer {
    position: relative;
    overflow: hidden;
    background: #1dae65;
    border-radius: 6px;
}

.shimmer::before {
    content: '';
    position: absolute;
    top: 0;
    left: -150px;
    height: 100%;
    width: 150px;
    background: linear-gradient(90deg, transparent, rgba(44, 17, 141, 0.2), transparent);
    animation: shimmer 1s infinite;
}

@keyframes shimmer {
    100% {
        left: 100%;
    }
}

.student-card {
    cursor: pointer;
    transition: all 0.2s ease;
	opacity: 0.9;
}

.student-card:hover {
	opacity: 1;
    transform: scale(1.02);
}

.student-card.active {
    border: 2px solid #0d6efd !important;
    background: rgba(13, 110, 253, 0.1);
	transform: scale(0.98);
}

.student-card.disabled {
    pointer-events: none;
    opacity: 0.6;
}

.student-card.active.disabled {
    opacity: 1;
}
</style>
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

		<div class="row mb-4">
			<!-- Profile -->
			<div class="col-xxl-12 col-xl-12 d-flex">
				<div class="card bg-dark position-relative flex-fill">
					<div class="card-body">
						<div class="d-flex align-items-center row-gap-3">
							<div class="avatar avatar-xxl rounded flex-shrink-0 me-3">
								<img src="{{ asset('assets/img/icons/student_new.svg') }}" alt="Img">
							</div>
							<div id="shimmer_profile" class="d-none">
								<div class="shimmer mb-2" style="width: 220px; height: 18px;"></div>
								<div class="shimmer mb-2" style="width: 160px; height: 20px;"></div>
								<div class="d-flex flex-column gap-2">
									<div class="shimmer" style="width: 180px; height: 14px;"></div>
								</div>
							</div>
							<div id="detail_profile" class="d-none">
								<span id="id_account" class="badge bg-transparent-primary text-primary mb-1">#</span>
								<h4 id="nama" class="text-truncate text-white mb-1">#</h4>
								<div class="d-flex align-items-center flex-wrap row-gap-2 class-info">
									<span id="since">Aktif sejak : #</span>
									<span id="link_child" >Anak : #</span>
								</div>
							</div>
						</div>
						
						<div class="student-card-bg">
							<img src="{{ asset('assets/img/bg/circle-shape.png') }}" alt="Bg">
							<img src="{{ asset('assets/img/bg/shape-02.png.webp') }}" alt="Bg">
							<img src="{{ asset('assets/img/bg/shape-04.webp') }}" alt="Bg">
							<img src="{{ asset('assets/img/bg/blue-polygon.png') }}" alt="Bg">
						</div>
					</div>
				</div>
			</div>
			<!-- /Profile -->

			<div class="col-xxl-7 col-xl-12 d-flex">
				<div class="row flex-fill" id="list_anak"></div>
			</div>
		</div>

		<div class="row mb-4">
			<div class="col-xxl-12 col-xl-12 d-flex">
				<div class="card flex-fill">
					<div id="page_selected" class="d-none row">
						<div class="col-md-6">
							<div class="d-flex align-items-center p-3 mb-3">
								<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
									<i class="ti ti-id-badge-2"></i>
								</div>
								<div>
									<h6 class="mb-1 fw-bold">ID Siswa</h6>
									<p class="mb-0 id_siswa">-</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class=" d-flex align-items-center p-3 mb-3">
								<div class="avatar avatar-lg bg-danger-transparent flex-shrink-0 me-2">
									<i class="ti ti-school"></i>
								</div>
								<div>
									<h6 class="mb-1 fw-bold">Nama Siswa</h6>
									<p class="mb-0 nama_siswa">-</p>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="custom-datatable-filter table-responsive">
								<table class="table">
									<thead class="thead-light">
										<tr>
											<th>No</th>
											<th>Tanggal</th>
											<th>Materi</th>
											<th>Refleksi</th>
											<th>Kelas</th>
											<th>Pengajar</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="itemData">
									</tbody>
								</table>
								<div id="loadingSpinnerTabel" class="text-center my-3" style="display: none;">
									<button id="loadingSpinnerTabel" class="btn btn-info-light" type="button" disabled="">
										<span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
											Memuat data...
									</button>
								</div>
							</div>

							<nav aria-label="Page navigation" class="pagination-style-2">
								<ul class="pagination justify-content-end mb-0" id="paginationContainer">
								</ul>
							</nav>
						</div>
					</div>
					<div id="loadingSpinner" class="text-center my-3" style="display: none;">
						<button id="loadingSpinner" class="btn btn-info-light" type="button" disabled="">
							<span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
								Memuat data...
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Page Wrapper -->

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.js"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
	let selectedID = null, selectedNama = null;
	let public_date_to, public_date_from;
	const shimmerProfile = document.getElementById('shimmer_profile');
	const detailProfile = document.getElementById('detail_profile');

	const pageSelected = document.getElementById('page_selected');
	const idSiswaContent = pageSelected.querySelector(".id_siswa");
	const namaSiswaContent =  pageSelected.querySelector(".nama_siswa");

	const loadingSpinnerTabel = document.getElementById('loadingSpinnerTabel');
	const loadingSpinner = document.getElementById('loadingSpinner');
	
	const id_account = document.getElementById('id_account');
	const nama = document.getElementById('nama');
	const since = document.getElementById('since');
	
	let isLoadingTabel = false;
	let isLoadingCard = false;

	document.addEventListener("DOMContentLoaded", async function () {
		shimmerProfile.classList.remove("d-none");
		shimmerProfile.classList.add("d-block");

		detailProfile.classList.remove("d-block");
		detailProfile.classList.add("d-none");

		try {
            const result = await fetchJson('/_backend/profile/d2', {
                method: 'POST'
            });
			
			let nama_ortu;
			const namaAyah = result.data.nama_ayah;
			const namaIbu = result.data.nama_ibu;
			const created_date = dateFormatIndo(result.data.created_dt);
			const child = result.data.child;
			const joinChild = formatAnak(child);

			if (isEmpty(namaAyah) && isEmpty(namaIbu)) {
				nama_ortu = 'Wali Murid'
			} else if (!isEmpty(namaAyah)) {
				nama_ortu = result.data.nama_ayah
			} else if (!isEmpty(namaIbu)) {
				nama_ortu = result.data.nama_ibu
			}

			id_account.textContent = `#${result.data.id}`
			nama.textContent = nama_ortu
			since.textContent = `Aktif sejak : ${created_date}`
			link_child.textContent = `Anak : ${joinChild}`

			renderDataAnak(child);
		} catch(e) {
			console.log('error while DOMContentLoaded', e)
		} finally {
			shimmerProfile.classList.remove("d-block");
			shimmerProfile.classList.add("d-none");

			detailProfile.classList.remove("d-none");
			detailProfile.classList.add("d-block");
		}
	})

	function renderDataAnak(child) {
		const container = document.getElementById("list_anak");
		container.innerHTML = child.map((item, index) => `
				<div class="col-xl-4 col-md-6 d-flex">
					<div class="card student-card bg-primary-transparent border-3 
						border-white text-center p-3 w-100 h-100" data-id="${item.id}" data-nama="${item.nama}">
						<h6 class="mb-2">${toTitleCase(item.nama)}</h6>
						<div class="mt-auto d-flex align-items-center justify-content-between text-default">
							<p class="border-end mb-0 pe-2">${item.nama_kelas ?? '-'}</p>
							<p class="mb-0 ps-2">${hitungUsiaDetail(item.tanggal_lahir)}</p>
						</div>
					</div>
				</div>
			`).join("");
	}

	function hitungUsiaDetail(tanggalLahir) {
		if (!isEmpty(tanggalLahir)) {
			const today = new Date();
			const birthDate = new Date(tanggalLahir);
			let tahun = today.getFullYear() - birthDate.getFullYear();
			let bulan = today.getMonth() - (birthDate.getMonth() + 1);		

			if (bulan < 0) {
				tahun--;
				bulan += 12;
			}

			return `${tahun} tahun ${bulan} bulan`;
		} else {
			return `- tahun`;
		}
	}

	document.addEventListener("click", async function(e) {
		const card = e.target.closest(".student-card");
		if (!card) return;

		if (isLoadingCard) return;
	    if (card.classList.contains("active")) return;

		isLoadingCard = true;

		document.querySelectorAll(".student-card").forEach(el => {
			el.classList.add("disabled");
			el.classList.remove("active");
		});

		card.classList.add("active");
		selectedID = card.dataset.id;
		selectedNama = card.dataset.nama;

		try {
			pageSelected.classList.add("d-none");
			loadingSpinner.style.display = "block"

			const today = new Date();
			const sevenDaysAgo = new Date();
			sevenDaysAgo.setDate(today.getDate() - 20);
			public_date_to = moment(today).format('DD-MM-YYYY')
			public_date_from = moment(sevenDaysAgo).format('DD-MM-YYYY')

			await renderDetailsCard(1);
			idSiswaContent.textContent = selectedID
			namaSiswaContent.textContent = selectedNama
		} catch (e) {
			console.log("error", e);
		} finally {
			document.querySelectorAll(".student-card").forEach(el => {
				el.classList.remove("disabled");
			});
			loadingSpinner.style.display = "none"
			pageSelected.classList.remove("d-none");
			isLoadingCard = false;
		}
	});

	async function renderDetailsCard(page) {
        if (isLoadingTabel) return;
        isLoadingTabel = true;

		const body = {
			page: page,
			id_siswa: selectedID,
			dari: public_date_from,
			sampai: public_date_to
        }

		loadingSpinnerTabel.style.display = "block";
		const pagination = document.getElementById("paginationContainer");
		const tbody = document.getElementById("itemData");
        tbody.innerHTML = `
            <tr>
            </tr>
        `;
		pagination.classList.add("loading");

        const result = await fetchJson('/_backend/logic/siswa/jurnal', {
            method: 'POST',
            body: body
        });
		if (!result.ok) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        Gagal mengambil data
                    </td>
                </tr>
            `;
		}

		const rows = result.data.rows
		const currentPage = result.data.currentPage
		const totalPage = result.data.rowtotalPages

		if (rows.length == 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center">
                        Data tidak tersedia
                    </td>
                </tr>
            `;
		} else {
			let no = 1;
			rows.forEach(item => {
				const jurnalRoute = "{{ route('wali-jurnal', ['id_jurnal' => ':id_jurnal', 'id_siswa' => ':id_siswa']) }}";
				const url = jurnalRoute.replace(':id_jurnal', item.id).replace(':id_siswa', selectedID);
				tbody.innerHTML += `
					<tr>
						<td>${no++}.</td>
						<td>${dateFormatIndo(item.tanggal_jurnal)} ${item.jam_mulai.slice(0, 5)} - ${item.jam_selesai.slice(0, 5)}</td>
						<td>${item.materi}</td>
						<td>${item.refleksi}</td>
						<td>${item.nama_kelas}</td>
						<td>${item.nama_guru}</td>
						<td><a href="${url}" class="link-primary">Detail</a></td>
					</tr>
				`
			})
			renderPagination(currentPage, totalPage);
		}

		loadingSpinnerTabel.style.display = "none";
		pagination.classList.remove("loading");
		isLoadingTabel = false;
	}

	function formatAnak(child) {
		const names = child.map(item => item.nama);
		if (names.length > 2) {
			const sisa = names.length - 2;
			return `${toTitleCase(names[0])}, ${toTitleCase(names[1])} +${sisa} lainnya`;
		}
		return names.map(toTitleCase).join(", ");
	}

	function toTitleCase(text) {
		return text
			.toLowerCase()
			.replace(/\b\w/g, char => char.toUpperCase());
	}

    function isEmpty(data) {
        if (typeof (data) === 'object') {
            if (JSON.stringify(data) === '{}' || JSON.stringify(data) === '[]') {
            return true;
            } else if (!data) {
            return true;
            }
            return false;
        } else if (typeof (data) === 'string') {
            if (!data.trim()) {
            return true;
            }
            return false;
        } else if (typeof (data) === 'undefined') {
            return true;
        } else {
            return false;
        }
    }

    function dateFormatIndo(date) {
        const d = new Date(date);

        return d.toLocaleDateString("id-ID", {
            // weekday: "long",
            day: "2-digit",
            month: "long",
            year: "numeric"
        });
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
                    renderDetailsCard(page);
                }
            });
        });
    }
</script>
@endsection