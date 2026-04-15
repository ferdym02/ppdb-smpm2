@extends('user.layouts.app')
@section('content')
    @if ($pendaftar)
        <div class="card my-3 text-dark">
            <div class="card-header text-white" style="background-color: #007A3E">
                <h5 class="card-title mb-0">Informasi Pendaftaran</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    <strong>Tanggal Pendaftaran:</strong> {{ $pendaftar->created_at->format('d-m-Y') }}
                </p>
                <p class="card-text">
                    <strong>Jam Pendaftaran:</strong> {{ $pendaftar->created_at->format('H:i:s') }} WIB
                </p>

                @if ($pendaftar->status_pendaftaran == 'verified')
                    <p class="card-text">
                        <strong>Status Pendaftaran:</strong>
                        <span class="bg-primary text-white px-2 py-1 rounded">Terverifikasi</span>
                    </p>
                    <div class="alert alert-success">
                        Pendaftaran Anda sudah terverifikasi, silakan cek jadwal Tes Tertulis dan Praktek Anda di bawah.
                    </div>
                    <div class="alert alert-info">
                        Silakan menunggu hasil tes pada halaman ini setelah Anda melakukan Tes Tertulis dan Praktek.
                    </div>
                    <a href="{{ route('pendaftar.cetakBukti', $pendaftar->id) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-print"></i> Cetak Bukti Pendaftaran
                    </a>
                @elseif ($pendaftar->status_pendaftaran == 'rejected')
                    <p class="card-text">
                        <strong>Status Pendaftaran:</strong>
                        <span class="bg-warning px-2 py-1 rounded">Perlu Perbaikan</span>
                    </p>
                    <p class="card-text">
                        <strong>Catatan Perbaikan:</strong> {{ $pendaftar->catatan_penolakan }}
                    </p>
                    <div class="alert alert-warning mt-3">
                        <strong>Perhatian:</strong> Segera <a href="{{ route('user.pendaftaran') }}">edit</a> data yang
                        perlu perbaikan sesuai dengan informasi dari
                        catatan
                        perbaikan supaya data pendaftaran Anda dapat segera diverifikasi kembali oleh admin.
                    </div>
                @elseif ($pendaftar->status_pendaftaran == 'pending')
                    <p class="card-text">
                        <strong>Status Pendaftaran:</strong>
                        <span class="bg-secondary text-white px-2 py-1 rounded">Pending</span>
                    </p>
                    <div class="alert alert-info mt-3">
                        Silakan menunggu data pendaftaran Anda diverifikasi oleh admin dan cek secara berkala.
                    </div>
                @elseif ($pendaftar->status_pendaftaran == 'gugur')
                    <p class="card-text">
                        <strong>Status Pendaftaran:</strong>
                        <span class="bg-danger text-white px-2 py-1 rounded">Tidak Lulus</span>
                    </p>
                    <div class="alert alert-info mt-3">
                        Kami menyesal untuk memberitahukan bahwa Anda <strong>tidak lulus</strong> dalam seleksi penerimaan.
                        Kami mengapresiasi usaha dan waktu yang telah Anda berikan. Jangan menyerah, teruslah berusaha dan
                        semoga sukses di kesempatan berikutnya!
                    </div>
                @elseif ($pendaftar->status_pendaftaran == 'diterima')
                    <p class="card-text">
                        <strong>Status Pendaftaran:</strong>
                        <span class="bg-success text-white px-2 py-1 rounded">Lulus</span>
                    </p>
                    <p class="card-text">
                        <strong>Status Daftar Ulang:</strong>
                        @if (is_null($pendaftar->daftar_ulang))
                            <span>Belum</span>
                        @elseif ($pendaftar->daftar_ulang === 'tidak')
                            <span>Tidak</span>
                        @elseif ($pendaftar->daftar_ulang === 'ya')
                            <span>Sudah</span>
                        @endif
                    </p>
                    <div class="alert alert-info mt-3">
                        Selamat! Anda telah lulus dalam proses PPDB. Silakan segera melakukan <strong>daftar ulang</strong>
                        sesuai dengan tanggal yang ada di jadwal. Terkait tata cara daftar ulang dapat dilihat pada menu
                        <a href="/user/pengumuman">Pengumuman</a>.
                    </div>
                    <a href="{{ route('pendaftar.cetakBukti', $pendaftar->id) }}" class="btn btn-success">
                        <i class="fas fa-print"></i> Cetak Bukti Pendaftaran
                    </a>
                @endif
            </div>
        </div>

        <div class="card mb-4 shadow-sm" id="test">
            <div class="card-header text-white" style="background-color: #007A3E">
                <h5 class="card-title mb-0">Informasi Tes</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row">Tanggal Tes Tertulis dan Praktek</th>
                            <td>
                                @if ($pendaftar && $pendaftar->tanggal_tes)
                                    {{ \Carbon\Carbon::parse($pendaftar->tanggal_tes)->locale('id')->translatedFormat('d F Y') }}
                                @else
                                    Belum ditentukan
                                @endif
                            </td>
                        </tr>
                        @if ($pendaftar && $pendaftar->status_tes == 'sudah')
                            <tr>
                                <th scope="row">Nilai Tes Tertulis</th>
                                <td>:
                                    @if ($pendaftar->nilai_tes_tertulis)
                                        {{ $pendaftar->nilai_tes_tertulis }}
                                    @else
                                        Belum ditentukan
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Nilai Tes Praktek</th>
                                <td>:
                                    @if ($pendaftar->nilai_tes_praktek)
                                        {{ $pendaftar->nilai_tes_praktek }}
                                    @else
                                        Belum ditentukan
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="row justify-content-center my-5">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">

                        <div class="mb-4">
                            <i class="fas fa-user-edit fa-4x text-secondary"></i>
                        </div>

                        <h4 class="mb-3">Anda Belum Melakukan Pendaftaran</h4>

                        <p class="text-muted mb-4">
                            Saat ini Anda belum mengisi formulir pendaftaran PPDB.
                            Silakan lakukan pendaftaran terlebih dahulu untuk dapat melihat
                            status verifikasi, jadwal tes, dan hasil seleksi.
                        </p>

                        <a href="/user/pendaftaran" class="btn btn-success px-4">
                            <i class="fas fa-arrow-right me-2"></i> Daftar Sekarang
                        </a>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
