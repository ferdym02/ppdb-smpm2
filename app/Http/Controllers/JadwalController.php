<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = Auth::user()->name;
        $title = 'Jadwal Kegiatan PPDB';
        $jadwals = Jadwal::all();
        $profilSekolah = ProfilSekolah::first();
        return view('admin.jadwal.index', compact('title', 'name', 'jadwals', 'profilSekolah'));
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
            'kegiatan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu' => 'required|string|max:255',
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        Jadwal::create([
            'kegiatan' => $request->kegiatan,
            'lokasi' => $request->lokasi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'waktu' => $request->waktu,
        ]);

        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $jadwal = Jadwal::findOrFail($id);
    //     return view('admin.jadwal.edit', [
    //         'title' => 'Edit Jadwal',
    //         'jadwal' => $jadwal,
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kegiatan' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
                'waktu' => 'required|string|max:255',
            ], [
                'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            ]);

            $jadwal = Jadwal::findOrFail($id);
            $jadwal->update([
                'kegiatan' => $request->kegiatan,
                'lokasi' => $request->lokasi,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu' => $request->waktu,
            ]);

            return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('jadwals.update', $id)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
