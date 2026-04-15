<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\ProfilSekolah;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        // Simpan URL saat ini ke session sebelum render halaman
        session(['index_url' => $request->fullUrl()]);
        $title = 'Data Pendaftar';
        $name = Auth::user()->name;
        $profilSekolah = ProfilSekolah::first();

        // Ambil semua periode untuk dropdown
        $periodes = Periode::all();

        // Periksa apakah ada periode aktif
        $activePeriod = Periode::where('status', 1)->first();

        // Cek jika ada request untuk memilih periode
        $selectedPeriodId = $request->input('periode_id', $activePeriod ? $activePeriod->id : null);

        // Jika tidak ada periode aktif dan tidak ada yang dipilih
        if (!$selectedPeriodId) {
            $totalPending = 0;
            $totalVerified = 0;
            $totalRejected = 0;
            $totalDiterima = 0;
            $totalGugur = 0;
            $totalCadangan = 0;
        } else {
            // Hitung jumlah pendaftar berdasarkan status dan periode terpilih/aktif
            $totalPending = Pendaftar::where('status_pendaftaran', 'pending')
                ->where('periode_id', $selectedPeriodId)
                ->count();
            $totalVerified = Pendaftar::where('status_pendaftaran', 'verified')
                ->where('periode_id', $selectedPeriodId)
                ->count();
            $totalRejected = Pendaftar::where('status_pendaftaran', 'rejected')
                ->where('periode_id', $selectedPeriodId)
                ->count();
            $totalDiterima = Pendaftar::where('status_pendaftaran', 'diterima')
                ->where('periode_id', $selectedPeriodId)
                ->count();
            $totalGugur = Pendaftar::where('status_pendaftaran', 'gugur')
                ->where('periode_id', $selectedPeriodId)
                ->count();
        }

        return view('admin.pendaftar.index', compact(
            'profilSekolah',
            'totalPending',
            'totalVerified',
            'totalRejected',
            'totalDiterima',
            'totalGugur',
            'title',
            'name',
            'periodes',
            'selectedPeriodId'
        ));
    }

    public function indexByStatus(Request $request, $status)
    {
        session(['index_by_status_url' => $request->fullUrl()]);
        $title = 'Data Pendaftar';
        $name = Auth::user()->name;
        $periodeId = $request->input('periode_id');
        $profilSekolah = ProfilSekolah::first();

        // Ambil data tahun pelajaran dari model Periode
        $periode = $periodeId ? Periode::find($periodeId) : null;

        return view('admin.pendaftar.index_by_status', compact('title', 'name', 'status', 'periode', 'profilSekolah'));
    }

    public function getPendaftarByStatus($status, Request $request)
    {
        // Filter hanya untuk status 'diterima'
        $pendaftars = Pendaftar::where('status_pendaftaran', $status);

        // Filter berdasarkan periode_id
        if ($request->has('periode_id') && $request->periode_id != '') {
            $pendaftars->where('periode_id', $request->periode_id);
        }

        // Tambahkan filter daftar ulang
        if ($request->has('daftar_ulang') && $request->daftar_ulang !== '') {
            if ($request->daftar_ulang === 'null') {
                $pendaftars->whereNull('daftar_ulang');
            } elseif ($request->daftar_ulang === 'ya') {
                $pendaftars->where('daftar_ulang', 'ya');
            }
            // Abaikan 'tidak', tidak perlu disertakan karena status otomatis 'gugur'
        }

        return DataTables::eloquent($pendaftars)
            ->addIndexColumn()
            ->addColumn('jenis_kelamin', function ($row) {
                return $row->jenis_kelamin === 'Laki-laki' ? 'L' : 'P';
            })
            ->addColumn('tanggal_pendaftaran', function ($pendaftar) {
                return $pendaftar->created_at->format('d-m-Y');
            })
            ->make(true);
    }

    public function create()
    {
        $title = 'Pendaftaran';
        // Asumsikan Anda memiliki autentikasi dan dapatkan user_id dari pengguna yang sedang login
        $userId = Auth::id();

        // Cek apakah pendaftar sudah ada
        $pendaftar = Pendaftar::where('user_id', $userId)->first();

        $currentDate = now(); // Mengambil tanggal saat ini
        $profile = ProfilSekolah::first();

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;


        return view('user.pendaftaran', compact('pendaftar', 'isRegistrationOpen', 'title', 'profile'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        if (Pendaftar::where('user_id', $userId)->exists()) {
            return back()->with('error', 'Anda sudah mendaftar.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:pendaftars,nisn',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nama_ortu' => 'required|string|max:255',
            'pekerjaan_ortu' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:15',
            'agama' => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Khonghucu',
            'alamat' => 'required|string|max:255',
            'alamat_ortu' => 'required|string|max:255',
            'kartu_keluarga' => 'required|file|mimes:jpg,jpeg,pdf|max:2048',
            'ktp_orang_tua' => 'required|file|mimes:jpg,jpeg,pdf|max:2048',
            'ijazah' => 'required|file|mimes:jpg,jpeg,pdf|max:2048',
            'foto_calon_siswa' => 'required|file|mimes:jpg,jpeg|max:2048',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar, silakan periksa kembali.',
            '*.required' => 'Wajib diisi.',
        ]);

        $currentDate = now();
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        if (!$activePeriod) {
            return redirect()->back()->withErrors(['periode' => 'Tidak ada periode yang aktif saat ini.'])->withInput();
        }

        DB::beginTransaction();

        try {
            $pendaftarData = $request->only([
                'nama_lengkap',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'asal_sekolah',
                'nisn',
                'jenis_kelamin',
                'nama_ortu',
                'pekerjaan_ortu',
                'alamat_ortu',
                'nomor_wa'
            ]) + [
                'user_id' => $userId,
                'status_pendaftaran' => 'pending',
                'daftar_ulang' => null,
                'catatan_penolakan' => null,
                'periode_id' => $activePeriod->id,
            ];

            // Simpan data pendaftar
            $pendaftar = Pendaftar::create($pendaftarData);

            $tahun = Carbon::now()->year; // atau dari periode

            // Ambil nomor terakhir di tahun tersebut (LOCK biar aman)
            $lastNumber = Pendaftar::whereYear('created_at', $tahun)
                ->lockForUpdate()
                ->max(DB::raw("CAST(SUBSTRING(nomor_pendaftaran, -3) AS UNSIGNED)"));

            $urut = $lastNumber ? $lastNumber + 1 : 1;

            // Format 3 digit
            $nomorPendaftaran = 'PPDB-' . $tahun . '-' . str_pad($urut, 3, '0', STR_PAD_LEFT);

            $pendaftar->update(['nomor_pendaftaran' => $nomorPendaftaran]);

            // Upload file setelah nomor_pendaftaran tersedia
            $fileFields = ['kartu_keluarga', 'ktp_orang_tua', 'ijazah', 'foto_calon_siswa'];
            $fileUpdates = [];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = "{$nomorPendaftaran}_{$field}_" . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('file_pendaftaran', $filename);
                    $fileUpdates[$field] = $path;
                }
            }

            // Update kolom file di tabel pendaftar
            $pendaftar->update($fileUpdates);

            DB::commit();
            return redirect()->route('user.pendaftaran')->with('success', 'Pendaftaran berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTrace());
        }
    }

    public function show($id, Request $request)
    {
        $name = Auth::user()->name;
        $pendaftar = Pendaftar::with(['user'])->findOrFail($id);
        $title = "Detail Pendaftar";
        $status = $request->query('status');
        $profilSekolah = ProfilSekolah::first();

        // Simpan URL halaman sebelumnya di sesi
        $request->session()->put('previous_url', url()->previous());

        $currentDate = now();
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        return view('admin.pendaftar.show', compact('pendaftar', 'title', 'name', 'status', 'profilSekolah'));
    }

    public function edit($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $title = "Edit Pendaftar";
        $name = Auth::user()->name;
        return view('admin.pendaftar.edit', compact('pendaftar', 'title', 'name'));
    }

    public function editPendaftaran()
    {
        $title = "Edit Data Pendaftaran";
        // Asumsikan Anda memiliki autentikasi dan dapatkan user_id dari pengguna yang sedang login
        $userId = Auth::id();

        $currentDate = now(); // Mengambil tanggal saat ini

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;
        $profile = ProfilSekolah::first();

        // Cek apakah pendaftar sudah ada
        $pendaftar = Pendaftar::where('user_id', $userId)->first();
        return view('user.pendaftaran_edit', compact('pendaftar', 'isRegistrationOpen', 'title', 'profile'));
    }

    public function updatePendaftaran(Request $request, $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);

        // Pastikan hanya pemilik data yang bisa update
        if ($pendaftar->user_id !== Auth::id()) {
            return back()->with('error', 'Akses tidak diizinkan.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pendaftars', 'nisn')->ignore($pendaftar->id), // Abaikan validasi unik untuk NISN milik pendaftar ini
            ],
            'agama' => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Khonghucu',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nama_ortu' => 'required|string|max:255',
            'pekerjaan_ortu' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'alamat_ortu' => 'required|string|max:255',

            // File tidak wajib saat update
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'ktp_orang_tua' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'foto_calon_siswa' => 'nullable|file|mimes:jpg,jpeg|max:2048',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar.',
            '*.required' => 'Wajib diisi.',
        ]);

        // Update data utama
        $pendaftar->update(array_merge(
            $request->only([
                'nama_lengkap',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'alamat_ortu',
                'asal_sekolah',
                'agama',
                'nisn',
                'jenis_kelamin',
                'nama_ortu',
                'pekerjaan_ortu',
                'nomor_wa',
            ]),
            [
                'status_pendaftaran' => 'pending',
                'catatan_perbaikan'   => null,
                'daftar_ulang'        => null,
            ]
        ));

        // Handle upload file
        $fileFields = ['kartu_keluarga', 'ktp_orang_tua', 'ijazah', 'foto_calon_siswa'];
        $fileUpdates = [];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {

                // Hapus file lama jika ada
                if ($pendaftar->$field && Storage::exists($pendaftar->$field)) {
                    Storage::delete($pendaftar->$field);
                }

                $file = $request->file($field);
                $filename = "{$pendaftar->nomor_pendaftaran}_{$field}_" . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('file_pendaftaran', $filename);

                $fileUpdates[$field] = $path;
            }
        }

        if (!empty($fileUpdates)) {
            $pendaftar->update($fileUpdates);
        }

        return redirect()->route('user.pendaftaran')->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    public function update(Request $request, $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);

        // Pastikan hanya pemilik data yang bisa update
        if ($pendaftar->user_id !== Auth::id()) {
            return back()->with('error', 'Akses tidak diizinkan.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pendaftars', 'nisn')->ignore($pendaftar->id), // Abaikan validasi unik untuk NISN milik pendaftar ini
            ],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nama_ortu' => 'required|string|max:255',
            'pekerjaan_ortu' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',

            // File tidak wajib saat update
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'ktp_orang_tua' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'foto_calon_siswa' => 'nullable|file|mimes:jpg,jpeg|max:2048',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar.',
            '*.required' => 'Wajib diisi.',
        ]);

        // Update data utama
        $pendaftar->update($request->only([
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'asal_sekolah',
            'nisn',
            'jenis_kelamin',
            'nama_ortu',
            'pekerjaan_ortu',
            'nomor_wa',
        ]));

        // Handle upload file
        $fileFields = ['kartu_keluarga', 'ktp_orang_tua', 'ijazah', 'foto_calon_siswa'];
        $fileUpdates = [];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {

                // Hapus file lama jika ada
                if ($pendaftar->$field && Storage::exists($pendaftar->$field)) {
                    Storage::delete($pendaftar->$field);
                }

                $file = $request->file($field);
                $filename = "{$pendaftar->nomor_pendaftaran}_{$field}_" . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('file_pendaftaran', $filename);

                $fileUpdates[$field] = $path;
            }
        }

        if (!empty($fileUpdates)) {
            $pendaftar->update($fileUpdates);
        }

        return redirect()->route('admin.pendaftar.show')->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    public function destroy($id, Request $request)
    {
        // Temukan data pendaftar berdasarkan ID
        $pendaftar = Pendaftar::find($id);

        if ($pendaftar) {
            // Daftar atribut file yang perlu dihapus
            $fileAttributes = [
                'kartu_keluarga',
                'ktp_orang_tua',
                'ijazah',
                'foto_calon_siswa',
            ];

            // Hapus setiap file jika ada
            foreach ($fileAttributes as $attribute) {
                if ($pendaftar->$attribute && Storage::exists($pendaftar->$attribute)) {
                    Storage::delete($pendaftar->$attribute);
                }
            }

            // Hapus data pendaftar
            $pendaftar->delete();

            // Redirect ke halaman index_by_status yang tersimpan di session
            $redirectUrl = session('index_by_status_url', route('admin.pendaftar.index')); // Fallback ke daftar utama jika URL tidak ditemukan
            return redirect($redirectUrl)->with('success', 'Pendaftar berhasil dihapus.');
        }

        // Redirect ke halaman index_by_status dengan pesan error jika data tidak ditemukan
        $redirectUrl = session('index_by_status_url', route('admin.pendaftar.index')); // Fallback ke daftar utama jika URL tidak ditemukan
        return redirect($redirectUrl)->with('error', 'Pendaftar tidak ditemukan.');
    }

    public function verifikasi(Request $request, $id)
    {
        // Ambil data pendaftar berdasarkan ID, akan gagal jika tidak ditemukan
        $pendaftar = Pendaftar::findOrFail($id);

        if ($request->status == 'verifikasi') {
            // Set status pendaftaran menjadi "verified" dan kosongkan catatan penolakan jika sebelumnya pernah ditolak
            $pendaftar->status_pendaftaran = 'verified';
            $pendaftar->catatan_penolakan = null;

            // Ambil periode aktif (status = true)
            $periodeAktif = Periode::where('status', true)->first();

            if (!$periodeAktif) {
                // Jika tidak ada periode aktif, kembalikan pesan error
                return redirect()->back()->with('error', 'Tidak ada periode aktif saat ini.');
            }

            // Ambil tes minat bakat aktif yang masih dibuka dan sesuai dengan periode aktif
            $tesAktif = Test::where('status', true)
                ->where('tanggal_tutup_tes', '>=', now()->toDateString()) // Belum melewati tanggal tutup
                ->where('periode_id', $periodeAktif->id)
                ->orderBy('tanggal_buka_tes')
                ->first();

            if (!$tesAktif) {
                return redirect()->back()->with('error', 'Tidak ada tes tersedia saat ini.');
            }

            // Hubungkan pendaftar dengan tes minat bakat
            $pendaftar->test_id = $tesAktif->id;

            try {

                DB::beginTransaction(); // Mulai transaksi untuk penjadwalan tes

                // Tentukan tanggal mulai penjadwalan tes: hari ini + 1 jika tes sudah dimulai, atau pakai tanggal mulai tes
                $startDate = Carbon::parse($tesAktif->tanggal_buka_tes)->greaterThan(now())
                    ? Carbon::parse($tesAktif->tanggal_buka_tes)
                    : now()->addDay();
                $endDate = Carbon::parse($tesAktif->tanggal_tutup_tes);

                // Batasi tanggal akhir tes maksimal 1 hari setelah periode pendaftaran tutup
                $maxEndDate = Carbon::parse($periodeAktif->tanggal_tutup)->addDay();

                if (
                    $startDate->lt(Carbon::parse($periodeAktif->tanggal_buka)) ||
                    $endDate->gt($maxEndDate)
                ) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Tanggal tes minat bakat di luar rentang periode pendaftaran.');
                }

                // Loop dari tanggal mulai sampai akhir untuk mencari tanggal yang masih tersedia kuota
                while ($startDate <= $endDate) {
                    if ($startDate->isSunday()) {
                        $startDate->addDay(); // Lewati hari Minggu
                        continue;
                    }

                    // Cek jumlah pendaftar di tanggal tersebut menggunakan lock untuk mencegah race condition
                    $count = Pendaftar::where('tanggal_tes', $startDate->toDateString())
                        ->lockForUpdate()
                        ->count();

                    if ($count < $tesAktif->kuota_per_hari) {
                        // Jika kuota masih tersedia, tetapkan tanggal tes ke pendaftar
                        $pendaftar->tanggal_tes = $startDate->toDateString();
                        break;
                    }

                    $startDate->addDay(); // Lanjut ke tanggal berikutnya
                }

                if (!$pendaftar->tanggal_tes) {
                    // Jika tidak mendapatkan tanggal tes, rollback dan beri pesan error
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Tanggal tes sudah lewat atau semua kuota sudah penuh.');
                }

                $pendaftar->save(); // Simpan data pendaftar yang sudah diperbarui
                DB::commit(); // Selesaikan transaksi jika semua proses berhasil
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback jika terjadi error saat proses
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menentukan tanggal tes.');
            }
        } elseif ($request->status == 'tolak') {
            // Proses penolakan pendaftaran
            if (empty($request->catatan_penolakan)) {
                return redirect()->back()->with('error', 'Catatan perbaikan wajib diisi.');
            }
            $pendaftar->status_pendaftaran = 'rejected';
            $pendaftar->catatan_penolakan = $request->catatan_penolakan;
            $pendaftar->save();
        }

        return redirect()->back()->with('success', 'Status verifikasi telah diperbarui.');
    }

    public function inputNilaiTes(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $pendaftar = Pendaftar::with('periode')->findOrFail($id);

        if ($pendaftar->status_pendaftaran !== 'verified' || !$pendaftar->tanggal_tes) {
            return redirect()->back()->with('error', 'Pendaftar belum bisa dinilai.');
        }

        $request->validate([
            'nilai_tes_tertulis' => 'required|numeric|min:0|max:100',
            'nilai_tes_praktek'  => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {

            $nilaiTertulis = $request->nilai_tes_tertulis;
            $nilaiPraktek  = $request->nilai_tes_praktek;

            $nilaiAkhir = ($nilaiTertulis * 0.7) + ($nilaiPraktek * 0.3);
            $statusKelulusan = $nilaiAkhir >= 60 ? 'diterima' : 'gugur';

            $periode = $pendaftar->periode;

            // =========================
            // LOGIKA UPDATE KUOTA
            // =========================
            if ($statusKelulusan === 'diterima') {

                // Cek apakah kuota masih tersedia
                if ($periode->kuota_penerimaan <= 0) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Kuota penerimaan sudah habis.');
                }

                $periode->kuota_penerimaan -= 1;
                $periode->kuota_penerimaan_used += 1;
                $periode->save();
            }

            // =========================
            // SIMPAN DATA PENDAFTAR
            // =========================
            $pendaftar->nilai_tes_tertulis = $nilaiTertulis;
            $pendaftar->nilai_tes_praktek  = $nilaiPraktek;
            $pendaftar->nilai_akhir        = round($nilaiAkhir, 2);
            $pendaftar->status_tes         = 'sudah';
            $pendaftar->status_pendaftaran = $statusKelulusan;

            $pendaftar->save();

            DB::commit();

            return redirect()->back()->with('success', 'Nilai tes berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function cetakBukti($id)
    {
        \Carbon\Carbon::setLocale('id');
        $pendaftar = Pendaftar::findOrFail($id);

        // Periksa otorisasi
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin' || auth()->id() === $pendaftar->user_id) {
            // Path ke gambar logo kiri
            $pathLeft = storage_path('app/public/lampung.png');
            $typeLeft = pathinfo($pathLeft, PATHINFO_EXTENSION);
            $dataLeft = file_get_contents($pathLeft);
            $base64Left = 'data:image/' . $typeLeft . ';base64,' . base64_encode($dataLeft);

            // Path ke gambar logo kanan (gambar baru)
            $pathRight = storage_path('app/public/logo.png');
            $typeRight = pathinfo($pathRight, PATHINFO_EXTENSION);
            $dataRight = file_get_contents($pathRight);
            $base64Right = 'data:image/' . $typeRight . ';base64,' . base64_encode($dataRight);

            $periode = Periode::where('status', true)->first();  // Ambil periode yang aktif

            // Ambil foto calon siswa dan konversi ke base64
            $pathFotoCalonSiswa = storage_path('app/' . $pendaftar->foto_calon_siswa);
            $pathFotoCalonSiswa = str_replace('\\', '/', $pathFotoCalonSiswa);

            if (file_exists($pathFotoCalonSiswa)) {
                $typeFoto = pathinfo($pathFotoCalonSiswa, PATHINFO_EXTENSION);
                $dataFoto = file_get_contents($pathFotoCalonSiswa);
                $base64FotoCalonSiswa = 'data:image/' . $typeFoto . ';base64,' . base64_encode($dataFoto);
            } else {
                $base64FotoCalonSiswa = null; // Foto tidak ada
            }

            $data = [
                'nomor_pendaftaran' => $pendaftar->nomor_pendaftaran,
                'waktu_pendaftaran' => $pendaftar->created_at,
                'nisn' => $pendaftar->nisn,
                'nama_lengkap' => $pendaftar->nama_lengkap,
                'tempat_tanggal_lahir' => $pendaftar->tempat_lahir . ', ' . $pendaftar->tanggal_lahir,
                'alamat' => $pendaftar->alamat,
                'asal_sekolah' => $pendaftar->asal_sekolah,
                'jenis_kelamin' => $pendaftar->jenis_kelamin,
                'nomor_wa' => $pendaftar->nomor_wa,
                'nama_ortu' => $pendaftar->nama_ortu,
                'pekerjaan_ortu' => $pendaftar->pekerjaan_ortu,
                'alamat_ortu' => $pendaftar->alamat_ortu,
                'tanggal_tes' => $pendaftar->tanggal_tes,
                'base64FotoCalonSiswa' => $base64FotoCalonSiswa,
            ];

            $pdf = Pdf::loadView('pdf.bukti_pendaftaran', $data, compact('base64Left', 'base64Right', 'periode'));
            return $pdf->download($pendaftar->nomor_pendaftaran . '_Bukti_Pendaftaran.pdf');
        }

        // Jika tidak berhak, tampilkan error
        abort(403, 'Unauthorized action.');
    }

    public function updateDaftarUlang(Request $request, $id)
    {
        try {
            // Memulai transaksi database agar proses di dalamnya berjalan atomik (semuanya berhasil atau semuanya gagal)
            DB::transaction(function () use ($request, $id) {
                // Cari data pendaftar berdasarkan ID
                $pendaftar = Pendaftar::findOrFail($id);

                // Validasi input daftar ulang (hanya boleh 'ya' atau 'tidak')
                $request->validate([
                    'daftar_ulang' => 'required|in:ya,tidak',
                ]);

                // Simpan status daftar ulang ke dalam model
                $pendaftar->daftar_ulang = $request->daftar_ulang;

                if ($request->daftar_ulang === 'tidak') {
                    // Jika pendaftar tidak melakukan daftar ulang, statusnya menjadi 'gugur'
                    $pendaftar->status_pendaftaran = 'gugur';
                }

                // Simpan perubahan ke dalam database
                $pendaftar->save();
            });

            return redirect()->back()->with('success', 'Status daftar ulang berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi, tanpa membocorkan detail teknis ke pengguna
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status daftar ulang.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $pendaftar = Pendaftar::findOrFail($id);
                // Ubah status pendaftar menjadi 'diterima'
                $pendaftar->status_pendaftaran = 'diterima';
                $pendaftar->save();
            });

            return redirect()->back()->with('success', 'Status pendaftaran berhasil diubah menjadi lulus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status pendaftaran.');
        }
    }

    public function informasiPendaftaran()
    {
        $title = 'Informasi Pendaftaran';
        // Asumsikan Anda memiliki autentikasi dan dapatkan user_id dari pengguna yang sedang login
        $userId = Auth::id();

        // Cek apakah pendaftar sudah ada
        $pendaftar = Pendaftar::where('user_id', $userId)->first();

        $currentDate = now(); // Mengambil tanggal saat ini

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;
        $profile = ProfilSekolah::first();


        return view('user.informasi', compact('pendaftar', 'isRegistrationOpen', 'title', 'profile'));
    }

    public function lihatDokumen($filename)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            abort(403, 'Anda harus login untuk mengakses file.');
        }

        $path = 'file_pendaftaran/' . $filename;

        if (!Storage::exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file(storage_path('app/' . $path));
    }

    public function lihatFoto($filename)
    {
        $path = 'file_pendaftaran/' . $filename;

        if (!Storage::exists($path)) {
            abort(404, 'Foto tidak ditemukan.');
        }

        return response()->file(storage_path('app/' . $path));
    }
}
