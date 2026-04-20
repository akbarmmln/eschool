<!DOCTYPE html>

<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Reset Password</title>

        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f5f6fa;
                margin: 0;
            }

            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            /* Card */
            .card {
                width: 420px;
                background: #fff;
                border-radius: 10px;
                padding: 40px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            }

            h2 {
                margin-bottom: 10px;
                color: #2f3542;
            }

            p {
                color: #7f8fa6;
                font-size: 14px;
            }

            /* OTP */
            .otp-input {
                display: flex;
                justify-content: space-between;
                margin: 20px 0;
            }

            .otp-input input {
                width: 50px;
                height: 55px;
                text-align: center;
                font-size: 20px;
                border: 1px solid #dcdde1;
                border-radius: 8px;
            }

            /* Input password */
            .input-group {
                margin-top: 20px;
            }

            .input-group input {
                width: 100%;
                padding: 14px;
                border-radius: 8px;
                border: 1px solid #dcdde1;
                margin-bottom: 15px;
            }

            /* Button */
            button {
                width: 100%;
                padding: 14px;
                border: none;
                border-radius: 8px;
                background: #4c6ef5;
                color: #fff;
                font-size: 16px;
                cursor: pointer;
            }

            /* Loader */
            .loader {
                display: none;
                text-align: center;
                margin-top: 15px;
            }

            .spinner {
                width: 30px;
                height: 30px;
                border: 3px solid #ddd;
                border-top: 3px solid #4c6ef5;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: auto;
            }

            @keyframes spin {
                to { transform: rotate(360deg); }
            }

            /* Hide */
            .hidden {
                display: none;
            }

            /* Error */
            .error {
                color: red;
                font-size: 13px;
                margin-top: 10px;
                text-align: center;
            }

            .resend {
                text-align: center;
                margin-top: 20px;
                font-size: 13px;
            }

            .resend a {
                color: #4c6ef5;
                text-decoration: none;
            }

            .toggle-password {
                cursor: pointer;
            }
        </style>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/education_2.svg') }}">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

        <!-- Feather CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/icons/feather/feather.css') }}">

        <!-- Tabler Icon CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.css') }}">

        <!-- Daterangepikcer CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

        <!-- animation CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

        <!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.theme.default.min.css') }}">

        <!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <!-- Feathericon CSS -->
        <link rel="stylesheet" href="{ asset('assets/css/feather.css') }}">
        
    </head>

    <body>
        <div id="success-alert-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content modal-filled bg-success">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-checkmark h1 text-white"></i>
                            <h5 class="fw-bold text-white text-uppercase text-warning mb-3">BERHASIL</h5>
                            <p id="containt_text" class="mt-3 text-white">Data berhasil dibuat
                            </p>
                            <button type="button" id="btnContinueSuccess" class="btn btn-light me-2 my-2" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card">
                <div id="loadingSpinner" class="text-center my-3" style="display: none;">
                    <button id="loadingSpinner" class="btn btn-info-light" type="button" disabled="">
                        <span class="spinner-grow spinner-grow-sm align-middle" role="status" aria-hidden="true"></span>
                            Memuat konten...
                    </button>
                </div>

                <!-- ================= OTP SECTION ================= -->
                <div id="otpSection" style="display: none">
                    <h2 style="
                            max-width:320px;
                            line-height:2;
                            font-size:20px;
                        ">
                        Verifikasi OTP
                    </h2>
                    
                    <p>Masukkan 6 digit kode OTP yang dikirim ke email Anda.</p>

                    <div class="otp-input">
                        <input type="text" maxlength="1">
                        <input type="text" maxlength="1">
                        <input type="text" maxlength="1">
                        <input type="text" maxlength="1">
                        <input type="text" maxlength="1">
                        <input type="text" maxlength="1">
                    </div>

                    <div class="loader" id="otpLoader">
                        <div class="spinner"></div>
                    </div>

                    <div class="error" id="otpError"></div>
                    
                    <div class="resend">
                        Tidak menerima kode?
                        <a href="#" id="resendBtn" style="pointer-events:none;opacity:0.5;">Kirim ulang</a>
                        <div id="countdown" style="margin-top:5px;color:#888;">03:00</div>
                    </div>
                </div>

                <!-- ================= PASSWORD SECTION ================= -->
                <div id="passwordSection" class="hidden" style="display: none">
                    <h2 style="
                            max-width:320px;
                            line-height:2;
                            font-size:20px;
                        ">
                        Password Baru
                    </h2>
                    <p>Silakan masukkan kata sandi baru Anda.</p>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="pass-group">
                                <input type="password" id="password" class="form-control password">
                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi password</label>
                            <div class="pass-group">
                                <input type="password" id="konfirm_password" class="form-control konfirm_password">
                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                        </div>
						<div class="mb-3">
							<button type="submit" id="btn-simpan-password" class="btn btn-primary w-100">Simpan</button>
					    </div>

                    <div class="loader" id="passLoader">
                        <div class="spinner"></div>
                    </div>

                    <div class="error" id="passError"></div>
                </div>

                <div id="invalidateLink" class="text-center my-3" style="display: none;">
                    <div style="padding:40px 20px;">
                        <!-- Icon -->
                        <div style="font-size:60px;margin-bottom:20px;">⏰</div>

                        <!-- Title -->
                        <h2 style="font-weight:600;color:#2f3542;margin-bottom:15px;">
                            Permintaan Tidak Valid
                        </h2>

                        <!-- Description -->
                        <p id="deskripsi" style="
                            max-width:320px;
                            margin:0 auto;
                            line-height:1.7;
                            color:#7f8fa6;
                            font-size:14px;
                            text-align: justify
                        ">
                            Reset kata sandi yang Anda gunakan sudah tidak berlaku atau telah kedaluwarsa atau telah mengalami beberapa kali percobaan.
                            Silakan lakukan permintaan reset kata sandi kembali untuk mendapatkan akses yang baru.
                        </p>

                        <!-- Button -->
                        <div style="margin-top:25px;">
                            <a href="{{ route('lupa-password') }}" style="
                                display:inline-block;
                                padding:10px 18px;
                                background:#4c6ef5;
                                color:#fff;
                                border-radius:8px;
                                text-decoration:none;
                                font-size:14px;
                            ">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/fetchJson.js') }}"></script>
        <script>
            let countTry = 0;
            let timeLeft = 0;
            let countdownInterval, sessionUpdate;

            const resetForm = document.getElementById('resetForm');
            const btnSimpanPassword = document.getElementById('btn-simpan-password');

            const loadingSection = document.getElementById('loadingSpinner')
            const otpSection = document.getElementById('otpSection')
            const passwordSection = document.getElementById('passwordSection')
            const invalidateLink = document.getElementById('invalidateLink')
            const deskripsi = document.getElementById('deskripsi')
            
            const inputs = document.querySelectorAll(".otp-input input");
            const otpLoader = document.getElementById("otpLoader");
            const otpError = document.getElementById("otpError");

            const countdownEl = document.getElementById("countdown");
            const resendBtn = document.getElementById("resendBtn");

            const params = new URLSearchParams(window.location.search);
            const jwt = params.get('jwt');

            document.addEventListener("DOMContentLoaded", async function () {
                loadingSection.style.display = 'block';
                otpSection.style.display = 'none';
                passwordSection.style.display = 'none';
                invalidateLink.style.display = 'none';

                try {
                    const result = await fetchJson('/_backend/auth/invalidate-page', {
                        method: 'POST',
                        body: {
                            jwt: jwt
                        }
                    });
                    if (!result.ok) {
                        throw result;
                    }
                    otpSection.style.display = 'block';
                    passwordSection.style.display = 'none';
                    invalidateLink.style.display = 'none';

                    nextSent = result.data.next_sent;
                    countTry = result.data.counter;
                    otpValidate = result.data.otp_validate;
                    timeLeft = result.data.inSecond;
                    startCountdown();

                    if (countTry <= 0 || otpValidate == 1) {
                        deskripsi.innerHTML = `Anda telah mengalami 3 kali percobaan. Silahkan akses kembali pada tanggal ${moment(nextSent).format('DD/MM/YYYY')} jam ${moment(nextSent).format('HH:mm:ss')}`
                        otpSection.style.display = 'none';
                        passwordSection.style.display = 'none';
                        invalidateLink.style.display = 'block';
                    }
                } catch(e) {
                    otpSection.style.display = 'none';
                    passwordSection.style.display = 'none';
                    invalidateLink.style.display = 'block';
                } finally {
                    loadingSection.style.display = 'none';
                }
            })

            // OTP logic
            function getOTP() {
                return Array.from(inputs).map(i => i.value).join('');
            }
            // input behavior
            inputs.forEach((input, i) => {
                input.addEventListener("input", async () => {
                    if (input.value && i < 5) inputs[i+1].focus();
                    await verifyOTP();
                });

                input.addEventListener("keydown", async (e) => {
                    if (e.key === "Backspace" && !input.value && i > 0) {
                        inputs[i-1].focus();
                    }
                });
            });

            // reset password
            btnSimpanPassword.addEventListener("click", async function(e) {
                const passError = document.getElementById("passError");
                const password = document.getElementById("password").value;
                const konfirm_password = document.getElementById("konfirm_password").value;

                btnSimpanPassword.disabled = true;
                btnSimpanPassword.innerHTML = 'Memproses...';

                passError.innerText = "";

                if (password !== konfirm_password) {
                    passError.innerText = "Password tidak sama dengan Konfirmasi password";
                    btnSimpanPassword.disabled = false;
                    btnSimpanPassword.innerHTML = 'Simpan';
                    return;
                }

                try {
                    const payload = {
                        password: konfirm_password,
                        session: sessionUpdate
                    }
                    const result = await fetchJson('/_backend/auth/invalidate/password', {
                        method: 'POST',
                        body: payload
                    });

                    const modalElement = document.getElementById("success-alert-modal");
                    const containtText = modalElement.querySelector("#containt_text");
                    containtText.innerHTML = 'Perubahan kata sandi berhasil dilakukan'
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                } catch(e) {
                    passError.innerText = "Terjadi kesalahan saat pemrosesan. Silahkan coba kembali";
                } finally {
                    btnSimpanPassword.disabled = false;
                    btnSimpanPassword.innerHTML = 'Simpan';
                }
            })

            async function verifyOTP() {
                const otp = getOTP();

                if (otp.length !== 6) return;

                inputs.forEach(i => i.disabled = true);
                otpLoader.style.display = "block";
                otpError.innerText = "";

                try {
                    const payload = {
                        type: 'reset-password',
                        otp: otp,
                        jwt: jwt
                    };

                    const result = await fetchJson('/_backend/auth/verify-otp', {
                        method: 'POST',
                        body: payload
                    });

                    if (!result.ok) throw result;
                    sessionUpdate = result.data

                    // pindah ke password form
                    otpSection.style.display = 'none';
                    passwordSection.style.display = 'block';
                    invalidateLink.style.display = 'none';
                } catch (e) {
                    inputs.forEach(i => {
                        i.value = "";
                        i.disabled = false;
                    });
                    inputs[0].focus();

                    const code = e?.code
                    const message = e?.message
                    if (code === '70006' || code === '70020' || code === '70023') {
                        otpSection.style.display = 'none';
                        passwordSection.style.display = 'none';
                        invalidateLink.style.display = 'block';
                    } else if (code === '70022') {
                        countTry = countTry - 1
                        otpError.innerText = `kode OTP tidak valid. Batas percobaan ${countTry} kali tersedia`;
                        inputs.forEach(i => {
                            i.value = "";
                            i.disabled = false;
                        });
                        inputs[0].focus();
                    } else {
                        otpError.innerText = `Terjadi kesalahan saat pemrosesan. Silahkan coba kembali`;
                        inputs.forEach(i => {
                            i.value = "";
                            i.disabled = false;
                        });
                        inputs[0].focus();
                    }
                } finally {
                    otpLoader.style.display = "none";
                }
            }

            function formatTime(seconds) {
                const m = String(Math.floor(seconds / 60)).padStart(2, '0');
                const s = String(seconds % 60).padStart(2, '0');
                return `${m}:${s}`;
            }
            
            function startCountdown() {
                countdownInterval = setInterval(() => {
                    timeLeft--;

                    countdownEl.innerText = formatTime(timeLeft);

                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);

                        countdownEl.innerText = "00:00";
                        resendBtn.style.pointerEvents = "auto";
                        resendBtn.style.opacity = "1";
                        inputs.forEach(i => i.disabled = true);
                    }
                }, 1000);
            }

            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const group = this.closest('.pass-group');

                    let input;
                    if (group.querySelector('.password')) {
                        input = group.querySelector('.password');
                    } else if (group.querySelector('.konfirm_password')) {
                        input = group.querySelector('.konfirm_password');
                    }

                    if (!input) return;

                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.replace('ti-eye', 'ti-eye-off');
                    } else {
                        input.type = 'password';
                        this.classList.replace('ti-eye-off', 'ti-eye');
                    }
                });
            });

            document.getElementById("btnContinueSuccess").addEventListener("click", function () {
                window.location.href = '/akademik/login';
            });
        </script>

        <!-- jQuery -->
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" ></script>

        <!-- Bootstrap Core JS -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" ></script>

        <!-- Daterangepikcer JS -->
        <script src="{{ asset('assets/js/moment.js') }}" ></script>
        <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}" ></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" ></script>

        <!-- Feather Icon JS -->
        <script src="{{ asset('assets/js/feather.min.js') }}" ></script>

        <!-- Slimscroll JS -->
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}" ></script>

        <!-- Chart JS -->
        <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}" ></script>
        <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}" ></script>

        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" ></script>

        <!-- Counter JS -->
        <script src="{{ asset('assets/plugins/countup/jquery.counterup.min.js') }}" ></script>
        <script src="{{ asset('assets/plugins/countup/jquery.waypoints.min.js') }}" >	</script>

        <!-- Modal JS -->
        <script src="{{ asset('assets/js/modal.js') }}"></script>

        <!-- Custom JS -->
        <script src="{{ asset('assets/js/script.js') }}" ></script>
    </body>
</html>