<!DOCTYPE html>
<html lang="en">

<head>
    <title>Daftar Akun Calon Siswa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login_assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login_assets/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login_assets/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login_assets/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login_assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="login_assets/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="login_assets/images/img-01.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="POST" action="/register">
                    @csrf

                    <span class="login100-form-title">
                        Daftar Akun Calon Siswa
                    </span>

                    <!-- Nama Lengkap -->
                    <div class="wrap-input100 validate-input" data-validate="Nama lengkap wajib diisi">
                        <input class="input100" type="text" name="name" placeholder="Nama Lengkap">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <!-- Email -->
                    <div class="wrap-input100 validate-input" data-validate="Email yang valid wajib diisi">
                        <input class="input100" type="email" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <!-- Password -->
                    <div class="wrap-input100 validate-input" data-validate="Password wajib diisi">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="wrap-input100 validate-input" data-validate="Konfirmasi password harus sama">
                        <input class="input100" type="password" name="password_confirmation"
                            placeholder="Konfirmasi Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Daftar Akun
                        </button>
                    </div>

                    <div class="text-center p-t-50">
                        <span class="txt1">
                            Sudah Memiliki Akun?
                        </span>
                        <a class="txt2" href="/login">
                            Login
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="login_assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="login_assets/vendor/bootstrap/js/popper.js"></script>
    <script src="login_assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="login_assets/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="login_assets/vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="login_assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Jika ada sesi login sukses, tampilkan SweetAlert
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Daftar Akun Berhasil',
                text: '{{ session('success') }}',
                timer: 1000, // Durasi 1 detik sebelum dialihkan
                showConfirmButton: false,
                didClose: () => {
                    // Redirect setelah SweetAlert ditutup
                    window.location.href = "{{ url('/login') }}";
                }
            });
        @endif
    </script>

</body>

</html>
