<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/education_2.svg') }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .forgot-password {
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: #4713cb;
        }
        
        .options {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-top: 15px;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .input-group-custom {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 0 10px;
        }

        .input-group-custom input {
            background: transparent !important;
            border: none !important;
            color: #fff;
            flex: 1;
            padding: 10px;
        }

        .input-group-custom input:focus {
            outline: none;
            box-shadow: none;
        }

        .toggle-password {
            cursor: pointer;
            color: rgba(255,255,255,0.8);
        }

        body {
            height: 100vh;
            background: url('https://s3.nevaobjects.id/bucket-sit/background_school.png') no-repeat center center/cover;
            background-size: 100% 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }

        .login-card input {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
        }

        .login-card input::placeholder {
            color: #eee;
        }

        .login-card input:focus {
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            box-shadow: none;
        }

        .logo {
            width: 150px;
            height: auto; /* 🔥 fix distorsi */
            margin-bottom: 20px;
        }

        .btn-login {
            background-color: #0d6efd;
            border: none;
        }

        .btn-login:hover {
            background-color: #0b5ed7;
        }

        .btn-login:disabled {
            opacity: 0.60 !important;
            background-color: #0d6efd;
            color: #ffffff;
            cursor: not-allowed;
        }

        .title {
            font-weight: bold;
            text-align: left;
            line-height: 1.1;
            margin: 0;
            margin-bottom: 20px;
        }

        .title-main {
            font-size: 16px;
            color: rgba(255,255,255,0.85);
        }

        /* bawah (lebih kecil) */
        .title-sub {
            font-size: 17.8px;
            color: #ffffff;
        }

        .btn-login:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(255,255,255,0.3);
        }
        
        /* overlay desktop */
        /* body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.3);
        } */

        /* =========================
        MOBILE VERSION
        ========================= */
        @media (max-width: 576px) {
            body {
                background: #000;
            }

            .login-card {
                max-width: 100%;
                height: 100vh;
                border-radius: 0;
                box-shadow: none;

                background: url('https://s3.nevaobjects.id/bucket-sit/background_school.png') no-repeat center/cover;
                background-size: 100% 100%;

                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;

                padding: 25px;
                overflow: hidden;
                text-align: center;
            }

            .login-card form {
                width: 100%;
            }

            .login-card::before {
                content: '';
                position: absolute;
                inset: 0;
                background: rgba(0,0,0,0.25);
                backdrop-filter: blur(3px);
                z-index: 0;
            }

            .login-card * {
                position: relative;
                z-index: 1;
            }

            .logo {
                width: 80px;
                height: auto; /* 🔥 fix distorsi */
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div id="loginToast" class="toast align-items-center text-bg-danger border-0" role="alert">
            <div class="d-flex">
            <div class="toast-body" id="toastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <div class="login-card text-center">
        <img src="https://s3.nevaobjects.id/bucket-sit/logo_tp.png" class="logo" alt="Logo">
        <h4 class="title">
            <span class="title-main">Welcome to daily dan weekly report</span><br>
            <span class="title-sub">Khalifa IMS Nursery&Kindergarten</span>
        </h4>
        <form id="form-login">
            <div class="mb-3 text-start">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" id="email" placeholder="Masukkan email">
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Password</label>

                <div class="input-group-custom">
                    <input type="password" class="form-control" id="password" placeholder="Masukkan password">

                    <span class="toggle-password" onclick="togglePassword()">
                    <i class="fa fa-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
            </div>
        </form>
            <button type="submit" id="btn_login" class="btn btn-login w-100 ">Masuk</button>
            <div class="options">
                <label></label>
                <a class="forgot-password" href="{{ route('lupa-password') }}">Lupa Password ?</a>
            </div>
    </div>

    {{-- Flash Message --}}
    @if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showToast("{{ session('error') }}");
        });
    </script>
    @endif

    @if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showToast("{{ session('success') }}");
        });
    </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/fetchJson.js') }}"></script>
    <script>
        const toastEl = document.getElementById("loginToast");
        const toastMessage = document.getElementById("toastMessage");
        const toast = new bootstrap.Toast(toastEl);
        const btnLogin = document.getElementById('btn_login');

        btnLogin.addEventListener("click", async function () {
            const username = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            if (!username && !password) {
                showToast("Username dan Password wajib diisi");
                return;
            }

            btnLogin.disabled = true;
            btnLogin.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Memproses masuk...`;

            try {
                const result = await fetchJson('/_backend/auth/login-process', {
                    method: 'POST',
                    body: {
                        email: username,
                        password: password
                    }
                });
                if (!result.ok) {
                    showToast(result.message);
                    return;
                }
                window.location.href = "/";
            } finally {
                btnLogin.disabled = false;
                btnLogin.innerHTML = "Masuk";
            }
        })

        function showToast(message) {
            toastMessage.textContent = message;
            toast.show();
        }

        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");

            if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
            } else {
            input.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>
</html>