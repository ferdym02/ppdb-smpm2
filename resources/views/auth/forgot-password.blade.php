@extends('layouts.app')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt my-auto" data-tilt>
                    <img src="{{ asset('storage/' . $profilSekolah->logo_sekolah) }}" alt="IMG">
                </div>

                <form id="forgotPassword" class="login100-form validate-form" method="POST"
                    action="{{ route('forgot.password.act') }}">
                    @csrf

                    <span class="login100-form-title">
                        Lupa Password
                    </span>

                    <p>Masukkan email Anda untuk menerima link reset password</p>

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

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                            role="alert" style="font-size: 14px;">
                            <div>{{ session('success') }}</div>
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

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn" style="background: #007A3E">
                            Reset Password
                        </button>
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

<script>
    document.getElementById('forgotPassword').addEventListener('submit', function(e) {

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
</script>
