@extends('layouts.app')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">

                {{-- LOGO --}}
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('logo.png') }}" alt="Logo">
                </div>

                {{-- CONTENT --}}
                <div class="login100-form validate-form">

                    <span class="login100-form-title">
                        Verifikasi Email
                    </span>

                    <div class="text-center mb-4" style="font-size:14px;">
                        Terima kasih telah mendaftar! <br>
                        Silakan verifikasi alamat email Anda dengan mengklik tautan
                        yang telah kami kirimkan.
                    </div>

                    <div class="text-center mb-4" style="font-size:14px;">
                        Jika belum menerima email, klik tombol di bawah ini
                        untuk mengirim ulang tautan verifikasi.
                    </div>

                    {{-- ALERT SUCCESS --}}
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                            role="alert" style="font-size: 14px;">
                            <div>{{ session('message') }}</div>
                            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- BUTTON RESEND --}}
                    <div class="container-login100-form-btn">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="login100-form-btn" style="background: #007A3E">
                                Kirim Ulang Email Verifikasi
                            </button>
                        </form>
                        <div class="text-center p-t-12">
                            <a class="txt2" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                &larr; Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
