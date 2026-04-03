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

		<div class="row">
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

			<div class="col-xxl-6 col-xl-12 d-flex">
				<div class="row flex-fill" id="list_anak"></div>
			</div>
		</div>
	</div>
</div>
<!-- /Page Wrapper -->

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.js"></script>
<script src="{{ asset('assets/js/fetchJson.js') }}"></script>
<script>
	const shimmerProfile = document.getElementById('shimmer_profile');
	const detailProfile = document.getElementById('detail_profile');

	const id_account = document.getElementById('id_account');
	const nama = document.getElementById('nama');
	const since = document.getElementById('since');
	
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
						border-white text-center p-3 w-100 h-100" data-id="${item.id}">
						<span class="avatar avatar-sm rounded bg-primary mx-auto mb-3">
							<i class="ti ti-hexagonal-prism-plus fs-15"></i>
						</span>
						<h6 class="mb-2">${toTitleCase(item.nama)}</h6>
						<div class="mt-auto d-flex align-items-center justify-content-between text-default">
							<p class="border-end mb-0 pe-2">${item.nama_kelas ?? '-'}</p>
							<p class="mb-0 ps-2">${item?.usia ?? '-'} tahun</p>
						</div>
					</div>
				</div>
			`).join("");
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
	    const id = card.dataset.id;

		try {
			await renderDetailsCard(id);
		} catch (e) {
			console.log("error", e);
		} finally {
			document.querySelectorAll(".student-card").forEach(el => {
				el.classList.remove("disabled");
			});
			isLoadingCard = false;
		}
	});

	async function renderDetailsCard(id_siswa) {

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
</script>
@endsection