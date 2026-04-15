<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\Pendaftar;
use App\Models\ProfilSekolah;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        session(['tests_url' => $request->fullUrl()]);
        $name = Auth::user()->name;
        $title = 'Penjadwalan Tes';
        $periodes = Periode::all();
        $profilSekolah = ProfilSekolah::first();
        $tests = Test::with('periode')->get(); // Mengambil data tes dan periode terkait
        return view('admin.tes.index', compact('title', 'name', 'periodes', 'tests', 'profilSekolah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'tanggal_buka_tes' => 'required|date',
            'tanggal_tutup_tes' => 'required|date|after_or_equal:tanggal_buka_tes',
            'kuota_per_hari' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ], [
            'tanggal_tutup_tes.after_or_equal' => 'Tanggal tutup tes harus sama atau setelah tanggal buka tes.',
            'kuota_per_hari.min' => 'Kuota per hari minimal adalah 1.',
        ]);

        // Ambil data periode berdasarkan periode_id
        $periode = Periode::findOrFail($request->periode_id);

        // Validasi tambahan untuk memastikan tanggal tes berada dalam rentang periode pendaftaran
        if ($request->tanggal_buka_tes < $periode->tanggal_buka) {
            $tanggalBukaPendaftaran = Carbon::parse($periode->tanggal_buka)->format('d-m-Y');
            return redirect()->route('tests.index')->with('error', 'Tanggal buka tes tidak boleh kurang dari tanggal buka pendaftaran (' . $tanggalBukaPendaftaran . ').');
        }

        if ($request->tanggal_tutup_tes > $periode->tanggal_tutup) {
            $tanggalTutupPendaftaran = Carbon::parse($periode->tanggal_tutup)->format('d-m-Y');
            return redirect()->route('tests.index')->with('error', 'Tanggal tutup tes tidak boleh melebihi tanggal tutup pendaftaran (' . $tanggalTutupPendaftaran . ').');
        }

        // Jika status yang diinginkan adalah aktif (1)
        if ($request->status) {
            // Cek apakah ada tes yang sudah aktif
            $activeTestExists = Test::where('status', 1)->exists();

            // Jika sudah ada tes yang aktif, tolak permintaan
            if ($activeTestExists) {
                return redirect()->back()->with('error', 'Tidak boleh ada lebih dari satu tes yang aktif');
            }
        }

        // Simpan data tes minat dan bakat
        Test::create($request->all());

        return redirect()->route('tests.index')->with('success', 'Data Penjadwalan Tes berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        // Simpan URL halaman sebelumnya di sesi
        $request->session()->put('previous_url', url()->previous());
        // Cari data Tes Minat dan Bakat berdasarkan ID
        $tests = Test::with('periode')->findOrFail($id);

        // Ambil filter dari request
        $tanggalTes = $request->get('tanggal_tes');
        $statusTes = $request->get('status_tes'); // Tambahkan status_tes

        // Filter data pendaftar
        $pendaftars = Pendaftar::query()
            ->where('test_id', $id) // Tambahkan filter untuk mencocokkan test_id
            ->when($tanggalTes, function ($query, $tanggalTes) {
                return $query->whereDate('tanggal_tes', $tanggalTes);
            })
            ->when($statusTes, function ($query, $statusTes) {
                return $query->where('status_tes', $statusTes);
            })
            ->get();

        // Judul halaman
        $title = "Detail Penjadwalan Tes";
        $profilSekolah = ProfilSekolah::first();

        // Tampilkan view dengan data
        return view('admin.tes.show', compact('tests', 'title', 'pendaftars', 'tanggalTes', 'statusTes', 'profilSekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'periode_id' => 'required|exists:periodes,id',
                'tanggal_buka_tes' => 'required|date',
                'tanggal_tutup_tes' => 'required|date|after_or_equal:tanggal_buka_tes',
                'kuota_per_hari' => 'required|integer|min:1',
                'status' => 'required|boolean',
            ], [
                'tanggal_tutup_tes.after_or_equal' => 'Tanggal tutup tes harus sama atau setelah tanggal buka tes.',
                'kuota_per_hari.min' => 'Kuota per hari minimal adalah 1.',
            ]);

            $test = Test::findOrFail($id);

            // Ambil data periode berdasarkan periode_id
            $periode = Periode::findOrFail($request->periode_id);

            if ($request->tanggal_buka_tes < $periode->tanggal_buka) {
                $tanggalBukaPendaftaran = Carbon::parse($periode->tanggal_buka)->format('d-m-Y');
                return redirect()->route('tests.index')->with('error', 'Tanggal buka tes tidak boleh kurang dari tanggal buka pendaftaran (' . $tanggalBukaPendaftaran . ').');
            }

            if ($request->tanggal_tutup_tes > $periode->tanggal_tutup) {
                $tanggalTutupPendaftaran = Carbon::parse($periode->tanggal_tutup)->format('d-m-Y');
                return redirect()->route('tests.index')->with('error', 'Tanggal tutup tes tidak boleh melebihi tanggal tutup pendaftaran (' . $tanggalTutupPendaftaran . ').');
            }

            // Jika status yang diinginkan adalah aktif (1) dan status yang sekarang belum aktif
            if ($request->status && $test->status != 1) {
                // Cek apakah ada tes lain yang sudah aktif
                $activeTestExists = Test::where('status', 1)->where('id', '!=', $id)->exists();

                // Jika sudah ada tes yang aktif, tolak permintaan
                if ($activeTestExists) {
                    return redirect()->back()->with('error', 'Tidak boleh ada lebih dari satu tes yang aktif');
                }
            }

            // Update data tes minat dan bakat
            $test->update($request->all());

            return redirect()->route('tests.index')->with('success', 'Data Penjadwalan berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('tests.update', $id)]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        if ($test->status == 1) {
            return redirect()->back()->with('error', 'Tes yang sedang aktif tidak dapat dihapus.');
        }
        $test->delete();

        return redirect()->route('tests.index')->with('success', 'Data Penjadwalan Tes berhasil dihapus');
    }
}
