@extends('user.layouts.app')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: #007A3E;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 9999;
            transition: opacity 0.3s, transform 0.3s;
        }

        .back-to-top:hover {
            background-color: #09522e;
        }

        .back-to-top i {
            font-size: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="text-center my-4">
        <h1>Selamat Datang Calon Peserta Didik Baru</h1>
        <p>di PPDB SMP Muhammadiyah 2 Kalianda</p>
    </div>
    <div class="card mb-4 shadow-sm" id="info">
        <div class="card-header text-white" style="background-color: #007A3E">
            <h5 class="card-title mb-0">Info Penting</h5>
        </div>
        <div class="card-body">
            @if ($isRegistrationOpen)
                <div class="alert alert-info" role="alert">
                    Pendaftaran sedang dibuka. Silakan lakukan pendaftaran.
                </div>
                <div class="alert alert-warning" role="alert">
                    Harap <strong>membaca seluruh informasi</strong> yang ada di halaman dashboard calon
                    peserta didik baru ini dengan seksama <strong>sebelum melakukan pendaftaran</strong>!
                </div>
            @else
                <div class="alert alert-danger" role="alert">
                    Saat ini belum ada periode pendaftaran yang dibuka.
                </div>
            @endif
        </div>
    </div>

    <!-- Persyaratan PPDB -->
    <div class="card mb-4 shadow-sm" id="persyaratan">
        <div class="card-header text-white" style="background-color: #007A3E">
            <h5 class="card-title mb-0">Persyaratan PPDB</h5>
        </div>
        <div class="card-body">
            <ol>
                <li>Telah dinyatakan lulus dari SD/MI/Sederajat dan memiliki Ijazah/Surat Keterangan Lulus</li>
                <li>Berusia paling tinggi 17 tahun</li>
                <li>Mengisi formulir pendaftaran dan mengunggah scan dokumen berupa:</li>
                <ul>
                    <li>Kartu Keluarga dan KTP orang tua/ wali</li>
                    <li>Ijazah/Surat Keterangan Lulus</li>
                    <li>Pas foto berwarna 3 x 4</li>
                </ul>
            </ol>
        </div>
    </div>

    <!-- Panduan Pendaftaran -->
    <div class="card mb-4 shadow-sm" id="panduan">
        <div class="card-header text-white" style="background-color: #007A3E">
            <h5 class="card-title mb-0">Panduan Pendaftaran</h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fas fa-file-alt mr-2 text-success me-2"></i>
                    <span>Calon peserta didik baru menyiapkan berkas persyaratan.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fas fa-globe mr-2 text-success me-2"></i>
                    <span>Calon peserta didik baru akses laman situs PPDB Online SMP Muhammadiyah 2 Kalianda.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fas fa-edit mr-2 text-success me-2"></i>
                    <span>Calon peserta didik baru melakukan <a href="/user/pendaftaran">pendaftaran</a> mandiri dengan
                        mengisi formulir dan mengunggah dokumen persyaratan secara online.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fas fa-clock mr-2 text-success me-2"></i>
                    <span>Calon peserta didik baru menunggu verifikasi pendaftaran oleh admin yang dapat dilihat pada
                        laman <a href="/user/informasi">Informasi Pendaftaran</a>.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fa-solid fa-circle-xmark mr-2 text-success me-2"></i>
                    <span>Jika status pendaftaran perlu perbaikan, calon peserta didik baru dapat melakukan edit data
                        pendaftaran sesuai dengan catatan perbaikan dari admin.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fas fa-check-circle mr-2 text-success me-2"></i>
                    <span>Jika pendaftaran calon peserta didik baru sudah terverifikasi, calon peserta didik baru dapat
                        mencetak bukti pendaftaran.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fas fa-calendar-alt mr-2 text-success me-2"></i>
                    <span>Calon peserta didik baru mendapat jadwal Tes Tertulis dan Praktek yang dapat dilihat <a
                            href="/user/informasi">disini</a>.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fas fa-clipboard-check mr-2 text-success me-2"></i>
                    <span>Calon peserta didik baru melakukan Tes Tertulis dan Praktek di SMP Muhammadiyah 2 Kalianda sesuai
                        jadwal dan
                        dengan tata cara yang dapat dilihat <a href="/user/informasi">disini</a>.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fa-solid fa-eye mr-2 text-success me-2"></i>
                    <span>Calon peserta didik baru melihat hasil seleksi dan pengumuman secara online di laman <a
                            href="/user/informasi">Informasi Pendaftaran</a>.</span>
                </li>
                <li class="mb-3 d-flex justify-content-start align-items-center">
                    <i class="fas fa-bullhorn mr-2 text-success me-2"></i>
                    <span>Calon peserta didik baru yang dinyatakan "Lulus" seleksi harap melakukan daftar ulang yang
                        dilaksanakan di sekolah. Informasi terkait daftar ulang dan info lainnya dapat dicek di halaman <a
                            href="/user/pengumuman">Pengumuman</a>.</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Jadwal Pelaksanaan Umum -->
    <div class="card mb-4 shadow-sm" id="jadwal">
        <div class="card-header text-white" style="background-color: #007A3E">
            <h5 class="card-title mb-0">Jadwal Pelaksanaan PPDB SMK Negeri 2 Kalianda</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>KEGIATAN</th>
                            <th>LOKASI</th>
                            <th>TANGGAL</th>
                            <th>WAKTU</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Array warna yang bisa dipilih secara acak
                            $colors = ['red', 'blue', 'green', 'orange', 'purple', 'brown'];
                            $usedColors = [];
                        @endphp
                        @foreach ($jadwals as $jadwal)
                            @php
                                // Filter warna yang belum digunakan
                                $availableColors = array_diff($colors, $usedColors);

                                // Pilih warna dari warna yang belum digunakan
                                if (count($availableColors) > 0) {
                                    $colorToUse = array_shift($availableColors); // Ambil warna pertama dari yang tersedia
                                } else {
                                    $colorToUse = 'black'; // Jika semua warna sudah digunakan, gunakan warna default
                                }

                                // Simpan warna yang sudah digunakan
                                $usedColors[] = $colorToUse;
                            @endphp
                            <tr>
                                <td style="color: {{ $colorToUse }}">{{ $jadwal->kegiatan }}</td>
                                <td>{{ $jadwal->lokasi }}</td>
                                <td>
                                    {{ $jadwal->tanggal_mulai->format('d M Y') }}
                                    @if ($jadwal->tanggal_selesai)
                                        - {{ $jadwal->tanggal_selesai->format('d M Y') }}
                                    @endif
                                </td>
                                <td>{{ $jadwal->waktu }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kontak Panitia -->
    <div class="card mb-4 shadow-sm" id="kontak">
        <div class="card-header text-white" style="background-color: #007A3E">
            <h5 class="card-title mb-0">Kontak Panitia</h5>
        </div>
        <div class="card-body">
            <p>Jika memiliki pertanyaan atau kendala dapat menghubungi panitia PPDB SMK Negeri 2 Kalianda melalui:</p>
            @if (!empty($profile->call_center))
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-whatsapp me-2" style="font-size: 1.5rem; color: #25D366;"></i>
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $profile->call_center) }}"
                        target="_blank">{{ $profile->call_center }}</a></li>
                </div>
            @else
                Belum ada nomor call center.
            @endif
        </div>
    </div>
    <div id="backToTop" class="back-to-top d-none">
        <i class="fas fa-arrow-up"></i>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const backToTopButton = document.getElementById('backToTop');

            // Logika tampilkan tombol saat scroll ke bawah
            window.addEventListener('scroll', () => {
                if (window.scrollY > 200) {
                    backToTopButton.classList.remove('d-none');
                    backToTopButton.style.opacity = '1';
                    backToTopButton.style.transform = 'scale(1)';
                } else {
                    backToTopButton.style.opacity = '0';
                    backToTopButton.style.transform = 'scale(0.9)';
                    setTimeout(() => backToTopButton.classList.add('d-none'), 300);
                }
            });

            // Scroll halus ke atas saat tombol diklik
            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
