@extends('layouts.app')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('storage/' . $profilSekolah->logo_sekolah) }}" alt="IMG">
                </div>

                <form id="loginForm" class="login100-form validate-form" method="POST" action="{{ route('user.login') }}">
                    @csrf

                    <span class="login100-form-title">
                        Login Calon Siswa
                    </span>

                    {{-- ================= ALERT ERROR UMUM ================= --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center"
                            role="alert">
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif


                    {{-- ================= ALERT VALIDASI ================= --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center"
                            role="alert">
                            <div>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- ================= EMAIL ================= --}}
                    <div class="wrap-input100 validate-input" data-validate="Email wajib diisi dan harus valid">
                        <input class="input100" type="email" name="email" value="{{ old('email') }}"
                            placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    {{-- ================= PASSWORD ================= --}}
                    <div class="wrap-input100 validate-input" data-validate="Password wajib diisi">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn" style="background: #007A3E">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Lupa
                        </span>
                        <a class="txt2" href="{{ route('forgot.password') }}">
                            Password?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                        <span class="txt1">
                            Belum Memiliki Akun?
                        </span>
                        <a class="txt2" href="/register">
                            Daftar Akun
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="loading-overlay">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {

            let isValid = true;

            // Ambil semua input di dalam form
            let inputs = this.querySelectorAll('.input100');

            inputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    isValid = false;
                }
            });

            // Kalau tidak valid → hentikan submit & jangan tampilkan loading
            if (!isValid) {
                e.preventDefault();
                return;
            }

            // Kalau valid → tampilkan loading
            document.querySelector('.loading-overlay').style.display = 'flex';
        });

        @if (session('successLogin'))
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: '{{ session('successLogin') }}',
                timer: 1000, // Durasi 1 detik sebelum dialihkan
                showConfirmButton: false,
                didClose: () => {
                    // Redirect setelah SweetAlert ditutup
                    window.location.href = "{{ url('/user/dashboard') }}";
                }
            });
        @endif
    </script>
@endsection
