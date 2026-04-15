@extends('user.layouts.app')

@section('css')
    <style>
        .data-item {
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
    </style>
@endsection

@section('content')
    @if (!$isRegistrationOpen)
        <div class="row mt-3">
            <div class="col-md-6 mx-auto">
                <div class="card mb-4 shadow-sm" id="info">
                    <div class="card-header text-white">
                        <h5 class="card-title mb-0">Info Penting</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            Saat ini belum ada periode pendaftaran yang dibuka.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if (!$pendaftar)
            <h5 class="mt-3">Silakan isi formulir untuk melakukan pendaftaran</h5>
            <div class="alert alert-info mt-3">
                <strong>Catatan:</strong> Field yang ditandai dengan <span class="text-danger">*</span> wajib diisi.
            </div>
        @endif
        <div class="card card-info card-outline mt-3 mb-3">
            <div class="card-header text-white" style="background-color: #007A3E">
                <h5 class="card-title mb-0">
                    @if ($pendaftar)
                        Data Pendaftar
                    @else
                        Formulir Pendaftaran
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @if ($pendaftar)
                    <!-- Bagian Data Diri -->
                    @if ($pendaftar->status_pendaftaran == 'pending' || $pendaftar->status_pendaftaran == 'rejected')
                        <div class="d-flex justify-content-between">
                            <h3>Data Diri</h3>
                            <a href="{{ route('pendaftaran.edit', $pendaftar->id) }}" class="btn btn-warning">Edit Data</a>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th style="width: 40%;">Nomor Pendaftaran</th>
                                    <td>: {{ $pendaftar->nomor_pendaftaran }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>: {{ $pendaftar->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir</th>
                                    <td>: {{ $pendaftar->tempat_lahir }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>: {{ \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>: {{ $pendaftar->agama }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>: {{ $pendaftar->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Asal Sekolah</th>
                                    <td>: {{ $pendaftar->asal_sekolah }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>NISN</th>
                                    <td>: {{ $pendaftar->nisn }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: {{ $pendaftar->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Orang Tua/Wali</th>
                                    <td>: {{ $pendaftar->nama_ortu }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Orang Tua/Wali</th>
                                    <td>: {{ $pendaftar->pekerjaan_ortu }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Orang Tua/Wali</th>
                                    <td>: {{ $pendaftar->alamat_ortu }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor WA</th>
                                    <td>: {{ $pendaftar->nomor_wa }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr class="border border-warning border-1 opacity-75">

                    <h3>Dokumen Pendukung</h3>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>Foto Calon Siswa</th>
                                    <td>: <a href="{{ route('dokumen.lihat', basename($pendaftar->foto_calon_siswa)) }}"
                                            target="_blank">
                                            Lihat Foto
                                        </a></td>
                                </tr>
                                <tr>
                                    <th>Kartu Keluarga</th>
                                    <td>: <a href="{{ route('dokumen.lihat', basename($pendaftar->kartu_keluarga)) }}"
                                            target="_blank">Lihat Dokumen</a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>Ijazah</th>
                                    <td>: <a href="{{ route('dokumen.lihat', basename($pendaftar->ijazah)) }}"
                                            target="_blank">
                                            Lihat Dokumen
                                        </a></td>
                                </tr>
                                <tr>
                                    <th>KTP Orang Tua/Wali</th>
                                    <td>: <a href="{{ route('dokumen.lihat', basename($pendaftar->ktp_orang_tua)) }}"
                                            target="_blank">
                                            Lihat Dokumen
                                        </a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @else
                    <form method="POST" action="/user/pendaftaran" enctype="multipart/form-data" id="pendaftaranForm">
                        @csrf
                        <p class="mb-4 mt-1"><strong>Data Diri</strong></p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                        placeholder="Masukkan nama lengkap" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                        placeholder="Masukkan tempat lahir" required>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span>:</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                        required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span>:</label>
                                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>
                                            Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="agama">Agama <span class="text-danger">*</span>:</label>
                                    <select class="form-control @error('agama') is-invalid @enderror" id="agama"
                                        name="agama" required>
                                        <option value="" disabled {{ old('agama') ? '' : 'selected' }}>
                                            Pilih Agama</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam
                                        </option>
                                        <option value="Kristen Protestan"
                                            {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen
                                            Protestan
                                        </option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>
                                            Katolik
                                        </option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu
                                        </option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha
                                        </option>
                                        <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>
                                            Khonghucu
                                        </option>
                                    </select>
                                    @error('agama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="alamat">Alamat <span class="text-danger">*</span>:</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                        placeholder="Masukkan alamat" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nisn">NISN <span class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                        id="nisn" name="nisn" value="{{ old('nisn') }}"
                                        placeholder="Masukkan NISN" required>
                                    @error('nisn')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="asal_sekolah">Asal Sekolah <span class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror"
                                        id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}"
                                        placeholder="Masukkan asal sekolah" required>
                                    @error('asal_sekolah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nama_ortu">Nama Orang Tua/Wali <span class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control @error('nama_ortu') is-invalid @enderror"
                                        id="nama_ortu" name="nama_ortu" value="{{ old('nama_ortu') }}"
                                        placeholder="Masukkan nama orang tua/wali" required>
                                    @error('nama_ortu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pekerjaan_ortu">Pekerjaan Orang Tua/Wali <span
                                            class="text-danger">*</span>:</label>
                                    <input type="text"
                                        class="form-control @error('pekerjaan_ortu') is-invalid @enderror"
                                        id="pekerjaan_ortu" name="pekerjaan_ortu" value="{{ old('pekerjaan_ortu') }}"
                                        placeholder="Masukkan pekerjaan orang tua/wali" required>
                                    @error('pekerjaan_ortu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nomor_wa">Nomor WA <span class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control @error('nomor_wa') is-invalid @enderror"
                                        id="nomor_wa" name="nomor_wa" value="{{ old('nomor_wa') }}"
                                        placeholder="Masukkan nomor WhatsApp" required>
                                    @error('nomor_wa')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="alamat_ortu">Alamat Orang Tua/Wali<span
                                            class="text-danger">*</span>:</label>
                                    <textarea class="form-control @error('alamat_ortu') is-invalid @enderror" id="alamat_ortu" name="alamat_ortu"
                                        rows="3" placeholder="Masukkan alamat orang tua/wali" required>{{ old('alamat_ortu') }}</textarea>
                                    @error('alamat_ortu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr class="border border-warning border-1 opacity-75">
                        <p class="mb-4 mt-1"><strong>Dokumen Pendukung</strong></p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kartu_keluarga">Kartu Keluarga <span class="text-danger">*</span>:</label>
                                    <input type="file" accept=".jpg, .jpeg, .pdf"
                                        class="form-control @error('kartu_keluarga') is-invalid @enderror"
                                        id="kartu_keluarga" name="kartu_keluarga" required>
                                    @error('kartu_keluarga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf | Maksimal 2MB</small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ktp_orang_tua">KTP Orang Tua/Wali <span
                                            class="text-danger">*</span>:</label>
                                    <input type="file" accept=".jpg, .jpeg, .pdf"
                                        class="form-control @error('ktp_orang_tua') is-invalid @enderror"
                                        id="ktp_orang_tua" name="ktp_orang_tua" required>
                                    @error('kartu_keluarga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf | Maksimal 2MB</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="foto">Foto Calon Siswa Ukuran 3x4 <span
                                            class="text-danger">*</span>:</label>
                                    <input type="file" accept=".jpg, .jpeg"
                                        class="form-control @error('foto_calon_siswa') is-invalid @enderror"
                                        id="foto" name="foto_calon_siswa" required>
                                    @error('foto_calon_siswa')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Tipe file: jpg/jpeg | Maksimal 2MB</small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ijazah">Ijazah/STTB <span class="text-danger">*</span>:</label>
                                    <input type="file" accept=".jpg, .jpeg, .pdf"
                                        class="form-control @error('ijazah') is-invalid @enderror" id="ijazah"
                                        name="ijazah" required>
                                    @error('ijazah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf | Maksimal 2MB</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div style="text-align: right;">
                                <button type="button" id="btnSubmitPendaftaran" class="btn btn-success responsive-btn">
                                    Daftar
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
            <div id="backToTop" class="back-to-top d-none">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div> {{-- Tampilkan form pendaftaran --}}
    @endif
@endsection

@section('scripts')
    {{-- SA --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- SweetAlert Session Notification --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#4CAF50',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
        document.getElementById('btnSubmitPendaftaran')?.addEventListener('click', function() {
            Swal.fire({
                title: 'Pastikan Data Sudah Benar!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Daftar',
                cancelButtonText: 'Periksa Kembali',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('pendaftaranForm').submit();
                }
            });
        });
    </script>
@endsection
