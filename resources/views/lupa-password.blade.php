<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Lupa Password</title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/education_2.svg') }}">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

        <!-- Feather CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/icons/feather/feather.css') }}">

        <!-- Tabler Icon CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.css') }}">

        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

        <!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    </head>
    
    <body class="account-page">
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
            <div id="globalToast" class="toast align-items-center border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body" id="globalToastBody">
                        <!-- message here -->
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <form id="action-page">
                            <div class="d-flex flex-column justify-content-between vh-100">
                                <div class=" mx-auto p-4 text-center"></div>
                                <div class="card">
                                    <div class="card-body p-4">
                                        <div class=" mb-4">
                                            <h2 class="mb-2">Lupa Password?</h2>
                                            <p class="mb-0" style="text-align: justify;">Jika Anda lupa kata sandi Anda, kami akan mengirimkan petunjuk melalui email untuk mengatur ulang kata sandi Anda.</p>
                                        </div>
                                        <div class="mb-3 ">
                                            <label class="form-label">Alamat Email</label>
                                            <div class="input-icon mb-3 position-relative">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-mail"></i>
                                                </span>
                                                <input type="text" name="email" value="" class="form-control email">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" id="btn-lanjutkan" class="btn btn-primary w-100 btn_lanjutkan">Lanjutkan</button>
                                        </div>
                                        <div class="text-center">
                                            <h6 class="fw-normal text-dark mb-0">Kembali ke <a href="{{ route('login') }}" class="hover-a "> Login</a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 text-center"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="text/javascript"></script>

        <!-- Bootstrap Core JS -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

        <!-- Feather Icon JS -->
        <script src="{{ asset('assets/js/feather.min.js') }}" type="text/javascript"></script>

        <!-- Slimscroll JS -->
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <!-- Custom JS -->
        <script src="{{ asset('assets/js/script.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/fetchJson.js') }}"></script>
        <script>
            const filedInput = document.getElementById('action-page');
            const btnLanjutkan = document.getElementById('btn-lanjutkan');

            document.addEventListener("DOMContentLoaded", function () {
                btnLanjutkan.disabled = true;

                const validator = initFormValidation(filedInput, {
                    btnSelector: '.btn_lanjutkan',
                    fields: [
                        '.email'
                    ]
                });
                filedInput._validator = validator;
            })

            btnLanjutkan.addEventListener("click", async function () {
                const form = document.getElementById('action-page');
                const data = {
                    email: form.email.value
                }
                btnLanjutkan.disabled = true;
                btnLanjutkan.innerHTML = 'Memproses...';

                try {
                    const result = await fetchJson('/_backend/auth/invalidate-reset-password', {
                        method: 'POST',
                        body: data
                    });

                    if (!result.ok) {
                        showToast('Proses gagal dilakukan. Silakan ulangi kembali.', 'error');
                    } else {
                        //redirect halaman    
                        const jwt = result.data.jwt;    
                        window.location.href = `/akademik/invalidate-password?jwt=${jwt}`;
                    }
                } catch (e) {
                    showToast('Terjadi kesalahan pada sistem. Silahkan coba kembali', 'error')
                } finally {
                    btnLanjutkan.disabled = false;
                    btnLanjutkan.innerHTML = 'Lanjutkan';
                }
            })

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
    </body>
</html>