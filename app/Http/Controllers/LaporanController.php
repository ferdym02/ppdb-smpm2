<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Jurusan;
use App\Models\Pendaftar;
use App\Models\Periode;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use App\Exports\PendaftarExport;
use App\Exports\PendaftarDiterimaExport;
use App\Models\ProfilSekolah;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $title = 'Laporan Pendaftar';
        $name = Auth::user()->name;
        // Mendapatkan semua periode dan periode terbaru (aktif)
        $periodes = Periode::orderBy('id', 'desc')->get();
        $profilSekolah = ProfilSekolah::first();
        $status_pendaftaran = ['pending', 'verified', 'rejected', 'diterima', 'gugur'];

        return view('admin.laporan.index', compact('title', 'name', 'periodes', 'status_pendaftaran', 'profilSekolah'));
    }

    public function getData(Request $request)
    {
        $query = Pendaftar::query();

        if ($request->periode) {
            $query->where('periode_id', $request->periode);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $start = Carbon::createFromFormat('d-m-Y', $request->start_date)
                        ->startOfDay();

            $end = Carbon::createFromFormat('d-m-Y', $request->end_date)
                        ->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);

        } elseif ($request->filled('start_date')) {

            $start = Carbon::createFromFormat('d-m-Y', $request->start_date)
                        ->startOfDay();

            $query->where('created_at', '>=', $start);

        } elseif ($request->filled('end_date')) {

            $end = Carbon::createFromFormat('d-m-Y', $request->end_date)
                        ->endOfDay();

            $query->where('created_at', '<=', $end);
        }

        if ($request->filled('status_pendaftaran')) {
            $query->where('status_pendaftaran', $request->status_pendaftaran);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function generatePDF(Request $request)
    {
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

        $query = Pendaftar::with('periode')->orderBy('periode_id');

        if ($request->has('periode') && $request->periode != '') {
            $query->where('periode_id', $request->periode);
        }

        // Filter berdasarkan tanggal pendaftaran
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->has('status_pendaftaran') && $request->status_pendaftaran != '') {
            $query->where('status_pendaftaran', $request->status_pendaftaran);
        }

        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $pendaftarGrouped = $query->get()->groupBy('periode_id'); // Kelompokkan berdasarkan periode_id

        $pdf = PDF::loadView('admin.laporan.pdf', [
            'pendaftarGrouped' => $pendaftarGrouped,
            'base64Left' => $base64Left,
            'base64Right' => $base64Right
        ]);
        return $pdf->download('laporan_pendaftar.pdf');
    }

    public function generateExcel(Request $request)
    {
        $filters = $request->all(); // Ambil filter dari request

        // Format nama file
        $fileName = 'laporan_pendaftar.xlsx';

        // Ekspor file Excel menggunakan PendaftarExport
        return Excel::download(new PendaftarExport($filters), $fileName);
    }

    public function generatePdfDiterima(Request $request)
    {
        // Ambil periode berdasarkan ID yang dipilih
        $periode = Periode::find($request->periode_id);

        // Jika tidak ada periode yang dipilih, fallback ke periode aktif
        if (!$periode) {
            $periode = Periode::where('status', true)->first();
        }

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

        // Mengambil data pendaftar yang diterima atau cadangan berdasarkan periode yang dipilih
        $pendaftarDiterima = Pendaftar::where('status_pendaftaran', 'diterima')
        ->where('periode_id', $periode->id)
        ->orderByDesc('nilai_akhir')
        ->get();

        // Meload view untuk PDF dengan data yang sudah diambil
        $pdf = PDF::loadView('admin.laporan.pendaftar-diterima-pdf', compact('pendaftarDiterima', 'base64Left', 'base64Right', 'periode'));

        // Mengembalikan file PDF untuk didownload atau ditampilkan
        return $pdf->download('laporan_pendaftar_diterima.pdf');
    }

    public function generateExcelDiterima(Request $request)
    {
        $periodeId = $request->periode_id;

        return Excel::download(new PendaftarDiterimaExport($periodeId), 'laporan_pendaftar_diterima.xlsx');
    }

}