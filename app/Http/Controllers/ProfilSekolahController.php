<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Profil Sekolah';
        $name = Auth::user()->name;
        $profilSekolah = ProfilSekolah::first();
        $callCenter = $profilSekolah?->call_center;
        return view('admin.profil_sekolah.create', compact('profilSekolah', 'name', 'title', 'callCenter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|numeric|digits_between:1,10',
            'alamat_sekolah' => 'required|string',
            'email_sekolah' => 'required|email|max:255',
            'telepon_sekolah' => 'required|string|max:15',
            'logo_sekolah' => 'nullable|image|mimes:png|max:2048',
            'call_center' => 'required|string|max:15',
        ]);

        // Ambil semua input yang diperlukan
        $data = $request->only([
            'nama_sekolah', 'npsn', 'alamat_sekolah', 'email_sekolah', 'telepon_sekolah', 'call_center'
        ]);

        // Proses logo sekolah jika ada
        if ($request->hasFile('logo_sekolah')) {
            $logo = $request->file('logo_sekolah');

            // Hapus logo lama terlebih dahulu
            $profilSekolah = ProfilSekolah::find(1);
            if ($profilSekolah && $profilSekolah->logo_sekolah) {
                Storage::disk('public')->delete($profilSekolah->logo_sekolah);
            }

            // Baru simpan logo baru
            $fileName = 'school-logo.' . $logo->getClientOriginalExtension();
            $filePath = $logo->storeAs('logos', $fileName, 'public');
            $data['logo_sekolah'] = $filePath;
        }

        // Simpan atau perbarui profil sekolah
        ProfilSekolah::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'Profil sekolah berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilSekolah $profilSekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfilSekolah $profilSekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfilSekolah $profilSekolah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilSekolah $profilSekolah)
    {
        //
    }
}
