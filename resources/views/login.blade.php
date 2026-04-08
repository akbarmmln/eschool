<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Login</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/education_2.svg') }}">

        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&amp;display=swap"
            rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('assets_other_one/plugins/bootstrap/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets_other_one/plugins/feather/feather.css') }}">

        <link rel="stylesheet" href="{{ asset('assets_other_one/plugins/icons/flags/flags.css') }}">

        <link rel="stylesheet" href="{{ asset('assets_other_one/plugins/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_other_one/plugins/fontawesome/css/all.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets_other_one/css/style.css') }}">
    </head>

    <body>
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
                <div class="container">
                    <div class="loginbox">
                        <div class="login-left">
                            <lottie-player src="{{ asset('assets_other_one/img/teacher_classroom.json') }}" background="transparent" speed="1"
                                loop autoplay>
                            </lottie-player>
                        </div>
                        <div id="toast-container" class="position-fixed top-0 end-0 p-3"></div>
                        <div class="login-right">
                            <div class="login-right-wrap">
                                <h1>Selamat Datang di <br> Jurnal Mengajar</h1>
                                <p class="account-subtitle"></p>
                                    <div class="form-group">
                                        <label>Username <span class="login-danger">*</span></label>
                                        <input id="username" class="form-control" type="text">
                                        <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Password <span class="login-danger">*</span></label>
                                        <input id="password" class="form-control pass-input" type="password">
                                        <span class="profile-views feather-eye toggle-password"></span>
                                    </div>
                                    <div class="forgotpass">
                                        <a href="forgot-password.html">Lupa Password?</a>
                                    </div>
                                    <div class="form-group">
                                        <button id="btnLogin" class="btn btn-primary btn-block" type="submit">Login</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets_other_one/js/jquery-3.6.0.min.js') }}"></script>

        <script src="{{ asset('assets_other_one/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('assets_other_one/js/feather.min.js') }}"></script>

        <script src="{{ asset('assets_other_one/js/script.js') }}"></script>

        {{-- Flash Message --}}
        @if(session('error'))
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            showToast("{{ session('error') }}", "error");
        });
        </script>
        @endif

        @if(session('success'))
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            showToast("{{ session('success') }}", "success");
        });
        </script>
        @endif

        <script src="{{ asset('assets/js/fetchJson.js') }}"></script>
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

        <script>
            document.getElementById("btnLogin").addEventListener("click", async function () {
                const username = document.getElementById("username").value;
                const password = document.getElementById("password").value;

                if (!username || !password) {
                    showToast('Username dan Password wajib diisi', 'error');
                    return;
                }

                btnLogin.disabled = true;
                btnLogin.innerHTML = "Memproses Login...";

                try {
                    const result = await fetchJson('/_backend/auth/login-process', {
                        method: 'POST',
                        body: {
                            email: username,
                            password: password
                        }
                    });
                    if (!result.ok) {
                        showToast(result.message, 'success');
                        return;
                    }
                    window.location.href = "/";
                } finally {
                    btnLogin.disabled = false;
                    btnLogin.innerHTML = "Login";
                }
            });

            function showToast(message, type) {
                const toastContainer = document.getElementById('toast-container');

                const toastHTML = `
                    <div class="toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'} border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;

                toastContainer.innerHTML = toastHTML;

                const toastEl = new bootstrap.Toast(toastContainer.querySelector('.toast'));
                toastEl.show();
            }
        </script>
    </body>
</html>