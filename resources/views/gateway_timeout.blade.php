<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Preskool - Bootstrap Admin Template">
        <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
        <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Akses Ditolak</title>

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

    <body class="error-page">
        <!-- Main Wrapper -->
        <div class="main-wrapper ">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-xl-7 col-md-6">
                        <div class="d-flex flex-column justify-content-between vh-100">
                            <div class="text-center p-4">
                                <!-- <img src="{{ asset('assets/img/logo.svg') }}" alt="img" class="img-fluid"> -->
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <div class="mb-4">
                                    <!-- <div class="mb-3">
                                        <lottie-player 
                                            src="https://assets9.lottiefiles.com/packages/lf20_qp1q7mct.json"
                                            background="transparent"
                                            speed="1"
                                            style="width: 250px; height: 250px; margin:auto;"
                                            loop
                                            autoplay>
                                        </lottie-player>
                                    </div> -->
                                    <img src="{{ asset('assets/img/authentication/authentication-408.webp') }}" class="error-img img-fluid" alt="Img">
                                </div>
                                <h3 class="h2 mb-3">Request Waktu Habis</h3>
                                <p class="text-center">Server kehabisan waktu untuk memproses. Silahkan coba kembali.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-arrow-left me-2"></i>Kembali ke Beranda</a>
                            </div>
                        </div>
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

        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <div class="sidebar-overlay">
        </div>
    </body>
</html>