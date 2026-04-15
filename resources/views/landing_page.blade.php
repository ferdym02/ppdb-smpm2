<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>PPDB - SMP Muhammadiyah 2 Kalianda</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Swiper -->
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">

    <!-- GLightbox -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <style>
        .btn-login {
            background-color: #007A3E;
            color: #fff;
            padding: 8px 22px;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            font-family: var(--nav-font);
        }

        .btn-login:hover {
            background-color: #00994d;
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 122, 62, 0.3);
        }

        .logo-text {
            line-height: 1.1;
        }

        .ppdb-title {
            font-family: var(--heading-font);
            font-size: 20px;
            font-weight: 600;
            color: #007A3E;
        }

        .ppdb-subtitle {
            font-family: var(--default-font);
            font-size: 13px;
            font-weight: 500;
            color: #444;
        }

        /* ==============================
   HERO OVERLAY
============================== */

        .hero-overlay {
            position: absolute;
            inset: 0;
            z-index: 5;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            text-align: center;
            padding: 0 20px;
            color: #fff;

            pointer-events: none;
            background: rgba(0, 0, 0, 0.4);
            padding: 40px;
            border-radius: 20px;
        }

        .hero-overlay h1 {
            font-family: var(--heading-font);
            font-size: 42px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .hero-overlay p {
            font-family: var(--default-font);
            font-size: 18px;
            margin-bottom: 25px;
        }

        .btn-daftar {
            background-color: #007A3E;
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-daftar {
            background-color: #007A3E;
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;

            pointer-events: auto;
        }

        #hero-carousel {
            position: relative;
        }

        .service-item-icon i {
            font-size: 48px;
            color: #007A3E;
            margin-bottom: 15px;
        }

        .service-heading {
            font-family: var(--heading-font);
            font-weight: 600;
        }

        /* ======================
   JADWAL TABLE MODERN
====================== */

        .jadwal-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .jadwal-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .jadwal-table thead {
            background: #007A3E;
            color: #fff;
        }

        .jadwal-table thead th {
            border: none;
            font-weight: 600;
            padding: 15px;
        }

        .jadwal-table tbody tr td {
            transition: background 0.25s ease;
        }

        .jadwal-table tbody tr:hover td {
            background: #dbf0e4;
        }

        .jadwal-table td {
            padding: 14px;
            vertical-align: middle;
        }

        .jadwal-kegiatan {
            font-weight: 600;
        }

        .jadwal-badge {
            background: #e8f7ef;
            color: #007A3E;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
        }

        /* ======================
   CONTACT SECTION
====================== */

        .contact-card {
            background: #fff;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .contact-item i {
            font-size: 22px;
            color: #007A3E;
            margin-right: 15px;
            margin-top: 4px;
        }

        .contact-item strong {
            display: block;
            font-weight: 600;
        }

        .contact-item p {
            margin: 0;
            color: #555;
        }

        .contact-item a {
            color: #007A3E;
            text-decoration: none;
        }

        .contact-item a:hover {
            text-decoration: underline;
        }

        .map-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        @media (max-width: 1199px) {
            .btn-login {
                font-size: 14px;
                padding: 6px 18px;
            }

            .mobile-nav-toggle {
                font-size: 28px;
                cursor: pointer;
            }
        }
    </style>
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center position-relative">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <!-- Logo -->
            <a href="/" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="Logo">

                <div class="ms-2 logo-text">
                    <div class="ppdb-title">PPDB</div>
                    <div class="ppdb-subtitle">SMP Muhammadiyah 2 Kalianda</div>
                </div>
            </a>

            <!-- Right Section (Nav + Login + Burger) -->
            <div class="d-flex align-items-center gap-3">

                <!-- Navbar -->
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="#" class="active">Home</a></li>
                        <li><a href="#services">Profil</a></li>
                        <li><a href="#syarat">Syarat & Alur</a></li>
                        <li><a href="#jadwal">Jadwal</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                    </ul>
                </nav>

                <!-- Login Button -->
                <a class="btn-login" href="/login">Login</a>

                <!-- Burger Menu -->
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

            </div>
        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel"
                data-bs-interval="5000">

                <div class="carousel-item active">
                    <img src="assets/img/hero_1.jpeg" alt="">
                </div>

                <div class="carousel-item">
                    <img src="assets/img/hero_2.jpeg" alt="">
                </div>

                <div class="carousel-item">
                    <img src="assets/img/hero_3.jpeg" alt="">
                </div>

                <div class="carousel-item">
                    <img src="assets/img/hero_4.jpeg" alt="">
                </div>

                <div class="carousel-item">
                    <img src="assets/img/hero_5.jpeg" alt="">
                </div>
                <div class="hero-overlay text-center">
                    <h1>Selamat Datang di Website PPDB</h1>
                    <p>
                        Penerimaan Peserta Didik Baru<br>
                        SMP Muhammadiyah 2 Kalianda<br>
                        <strong>Tahun Pelajaran <span id="tahun-ajaran"></span></strong>
                    </p>

                    <a href="/register" class="btn-daftar">Daftar Sekarang</a>
                </div>

                <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>

                <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>

                <ol class="carousel-indicators"></ol>

            </div>

        </section><!-- /Hero Section -->

        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>INFORMASI PPDB</h2>
                <p>Informasi dan Keunggulan Penerimaan Peserta Didik Baru</p>
            </div><!-- End Section Title -->
            <div class="content">
                <div class="container">
                    <div class="row g-4">

                        <!-- 01 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="service-item">
                                <span class="number">01</span>
                                <div class="service-item-icon">
                                    <i class="bi bi-journal-check"></i>
                                </div>
                                <div class="service-item-content">
                                    <h3 class="service-heading">Pendaftaran Online</h3>
                                    <p>
                                        Proses pendaftaran mudah dan cepat melalui sistem online tanpa harus datang ke
                                        sekolah.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 02 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="service-item">
                                <span class="number">02</span>
                                <div class="service-item-icon">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div class="service-item-content">
                                    <h3 class="service-heading">Syarat & Ketentuan</h3>
                                    <p>
                                        Informasi lengkap mengenai persyaratan administrasi dan dokumen yang dibutuhkan
                                        calon peserta didik.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 03 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="service-item">
                                <span class="number">03</span>
                                <div class="service-item-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div class="service-item-content">
                                    <h3 class="service-heading">Jadwal PPDB</h3>
                                    <p>
                                        Jadwal resmi pendaftaran, seleksi, dan pengumuman hasil penerimaan siswa baru.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 04 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="service-item">
                                <span class="number">04</span>
                                <div class="service-item-icon">
                                    <i class="bi bi-stars"></i>
                                </div>
                                <div class="service-item-content">
                                    <h3 class="service-heading">Program Unggulan</h3>
                                    <p>
                                        Berbagai program akademik dan non-akademik untuk mendukung potensi dan prestasi
                                        siswa.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 05 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="service-item">
                                <span class="number">05</span>
                                <div class="service-item-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="service-item-content">
                                    <h3 class="service-heading">Fasilitas Sekolah</h3>
                                    <p>
                                        Lingkungan belajar yang nyaman dengan fasilitas penunjang pendidikan yang
                                        lengkap dan modern.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 06 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="service-item">
                                <span class="number">06</span>
                                <div class="service-item-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div class="service-item-content">
                                    <h3 class="service-heading">Kontak & Bantuan</h3>
                                    <p>
                                        Hubungi panitia PPDB untuk mendapatkan bantuan serta informasi lebih lanjut
                                        mengenai pendaftaran.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section><!-- /Services Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <img src="assets/img/img_long_5.jpeg" alt="Image " class="img-fluid img-overlap"
                                data-aos="zoom-out">
                        </div>
                        <!-- Konten Visi Misi -->
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

                            <h3 class="content-subtitle text-white opacity-75">
                                Visi & Misi Sekolah
                            </h3>

                            <h2 class="content-title mb-4 text-white">
                                Mewujudkan Generasi Muslim yang Unggul dan Berkarakter
                            </h2>

                            <!-- VISI -->
                            <div class="mb-4">
                                <h4 class="text-white">Visi</h4>
                                <p class="text-white opacity-75">
                                    Terbentuknya manusia muslim yang bertakwa, cerdas, kreatif,
                                    cinta tanah air, berwawasan lingkungan dan budaya serta
                                    bergerak menuju kemajuan.
                                </p>
                            </div>

                            <!-- MISI -->
                            <div>
                                <h4 class="text-white mb-3">Misi</h4>

                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle me-3 text-success"></i>
                                    <p class="text-white opacity-75 mb-0">
                                        Menumbuhkan sikap penghayatan dan pengamalan ajaran agama dalam kehidupan
                                        sehari-hari.
                                    </p>
                                </div>

                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle me-3 text-success"></i>
                                    <p class="text-white opacity-75 mb-0">
                                        Melaksanakan pembelajaran dan bimbingan secara efektif, inovatif dan kreatif.
                                    </p>
                                </div>

                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle me-3 text-success"></i>
                                    <p class="text-white opacity-75 mb-0">
                                        Menumbuhkan semangat belajar dan berkarya dengan memanfaatkan teknologi.
                                    </p>
                                </div>

                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle me-3 text-success"></i>
                                    <p class="text-white opacity-75 mb-0">
                                        Menumbuhkan rasa cinta dan bangga terhadap tanah air Indonesia.
                                    </p>
                                </div>

                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle me-3 text-success"></i>
                                    <p class="text-white opacity-75 mb-0">
                                        Melaksanakan gerakan penghijauan, hemat energi, serta peduli terhadap
                                        lingkungan.
                                    </p>
                                </div>

                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle me-3 text-success"></i>
                                    <p class="text-white opacity-75 mb-0">
                                        Mendorong warga sekolah terus bergerak menjadi lebih baik dan berkualitas dalam
                                        segala bidang.
                                    </p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Syarat & Alur Pendaftaran -->
        <section id="syarat" class="about-3 section">

            <div class="container">
                <div class="row gy-5">

                    <!-- SYARAT PENDAFTARAN -->
                    <div class="col-lg-6" data-aos="fade-up">
                        <h2 class="content-title mb-4">Syarat Pendaftaran</h2>

                        <ul class="list-unstyled">

                            <li class="mb-3 d-flex">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>
                                    Telah dinyatakan lulus dari SD/MI/Sederajat dan memiliki
                                    Ijazah/Surat Keterangan Lulus.
                                </span>
                            </li>

                            <li class="mb-3 d-flex">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>
                                    Berusia paling tinggi 17 tahun.
                                </span>
                            </li>

                            <li class="mb-3 d-flex">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>
                                    Mengisi formulir pendaftaran dan mengunggah scan dokumen berupa:
                                </span>
                            </li>

                            <li class="ms-4 mb-2 d-flex">
                                <i class="bi bi-dot me-2"></i>
                                <span>Kartu Keluarga dan KTP Orang Tua/Wali</span>
                            </li>

                            <li class="ms-4 mb-2 d-flex">
                                <i class="bi bi-dot me-2"></i>
                                <span>Ijazah/Surat Keterangan Lulus</span>
                            </li>

                            <li class="ms-4 d-flex">
                                <i class="bi bi-dot me-2"></i>
                                <span>Pas foto berwarna ukuran 3x4</span>
                            </li>

                        </ul>
                    </div>


                    <!-- ALUR PENDAFTARAN -->
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="content-title mb-4">Alur Pendaftaran</h2>

                        <div class="mb-4 d-flex">
                            <div class="me-3 fw-bold text-success">01</div>
                            <div>Buat akun PPDB dengan klik tombol <strong>"Daftar Sekarang"</strong>.</div>
                        </div>

                        <div class="mb-4 d-flex">
                            <div class="me-3 fw-bold text-success">02</div>
                            <div>Isi formulir pendaftaran dengan data diri yang sesuai.</div>
                        </div>

                        <div class="mb-4 d-flex">
                            <div class="me-3 fw-bold text-success">03</div>
                            <div>Upload dokumen yang diperlukan sesuai ketentuan.</div>
                        </div>

                        <div class="mb-4 d-flex">
                            <div class="me-3 fw-bold text-success">04</div>
                            <div>Verifikasi data pendaftaran oleh panitia PPDB.</div>
                        </div>

                        <div class="mb-4 d-flex">
                            <div class="me-3 fw-bold text-success">05</div>
                            <div>Melakukan Tes Tertulis dan Praktik.</div>
                        </div>

                        <div class="d-flex">
                            <div class="me-3 fw-bold text-success">06</div>
                            <div>Pengumuman hasil seleksi melalui website PPDB.</div>
                        </div>

                    </div>

                </div>
            </div>

        </section>

        <!-- Jadwal PPDB Section -->
        <section id="jadwal" class="services-2 section dark-background mb-5">

            <div class="container section-title text-center" data-aos="fade-up">
                <h2>Jadwal PPDB</h2>
                <p>Informasi Jadwal Penerimaan Peserta Didik Baru</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="jadwal-card">

                    <div class="table-responsive">
                        <table class="table jadwal-table text-center align-middle">

                            <thead>
                                <tr>
                                    <th><i class="bi bi-list-task"></i> Kegiatan</th>
                                    <th><i class="bi bi-geo-alt"></i> Lokasi</th>
                                    <th><i class="bi bi-calendar-event"></i> Tanggal</th>
                                    <th><i class="bi bi-clock"></i> Waktu</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($jadwals as $jadwal)
                                    <tr>

                                        <td class="text-start jadwal-kegiatan">
                                            {{ $jadwal->kegiatan }}
                                        </td>

                                        <td>
                                            {{ $jadwal->lokasi }}
                                        </td>

                                        <td>
                                            <span class="jadwal-badge">
                                                {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}

                                                @if ($jadwal->tanggal_selesai)
                                                    -
                                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}
                                                @endif
                                            </span>
                                        </td>

                                        <td>
                                            <i class="bi bi-clock"></i> {{ $jadwal->waktu }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="bi bi-calendar-x fs-2 text-muted"></i>
                                            <p class="mt-2 text-muted mb-0">
                                                Jadwal PPDB belum tersedia
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>

            </div>

        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-12 testimonials section" id="kontak">
            <!-- Section Title -->
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak Sekolah</h2>
                <p>Informasi alamat dan kontak SMP Muhammadiyah 2 Kalianda</p>
            </div>

            <div class="container" data-aos="fade-up">

                <div class="row g-4 align-items-stretch">

                    <!-- Kontak -->
                    <div class="col-lg-5">

                        <div class="contact-card">

                            <h4 class="mb-4">Hubungi Kami</h4>

                            <div class="contact-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <div>
                                    <strong>Alamat</strong>
                                    <p>{{ $profil->alamat_sekolah }}</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <i class="bi bi-telephone-fill"></i>
                                <div>
                                    <strong>Telepon</strong>
                                    <p>{{ $profil->telepon_sekolah }}</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <i class="bi bi-whatsapp"></i>
                                <div>
                                    <strong>Call Center</strong>
                                    <p>
                                        <a href="https://wa.me/{{ $profil->call_center }}" target="_blank">
                                            {{ $profil->call_center }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <i class="bi bi-envelope-fill"></i>
                                <div>
                                    <strong>Email</strong>
                                    <p>{{ $profil->email_sekolah }}</p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Google Maps -->
                    <div class="col-lg-7">

                        <div class="map-card">

                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3437.665133118882!2d105.586484!3d-5.696445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e41101ba4f8aa0b%3A0x9bac114a6fb1c33b!2sSMP%20Muhammadiyah%202%20Kalianda!5e1!3m2!1sen!2sid!4v1772722218835!5m2!1sen!2sid"
                                width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>

                        </div>

                    </div>

                </div>

            </div>
        </section><!-- /Testimonials Section -->
    </main>

    <footer id="footer" class="footer dark-background">

        <div class="copyright text-center">
            <div
                class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div>
                        © Copyright <strong><span>PPDB SMP Muhammadiyah 2 Kalianda</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>

                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                </div>

            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- GLightbox -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        const now = new Date();
        let year = now.getFullYear();

        if (now.getMonth() < 6) {
            year = year - 1;
        }

        const nextYear = year + 1;

        document.getElementById("tahun-ajaran").textContent = year + "/" + nextYear;
    </script>
</body>

</html>
