<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Periode;
use App\Models\Pendaftar;
use App\Models\ProfilSekolah;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function landingPage()
    {
        $profil = ProfilSekolah::first();
        $jadwals = Jadwal::all();
        return view('landing_page', compact('profil', 'jadwals'));
    }

    public function userDashboard()
    {
        $title = "Dashboard";
        $currentDate = now();

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();
        $isRegistrationOpen = $activePeriod ? true : false;
        $pendaftar = Pendaftar::where('user_id', auth()->id())->first();
        $profile = ProfilSekolah::first();
        $jadwals = Jadwal::all();

        return view('user.dashboard', compact('isRegistrationOpen', 'pendaftar', 'profile', 'jadwals', 'title'));
    }

    public function showProfile()
    {
        $title = "Profile";
        $currentDate = now(); // Mengambil tanggal saat ini
        $profile = ProfilSekolah::first();

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;

        $user = auth()->user();

        $pendaftar = Pendaftar::where('user_id', auth()->id())->first();
        return view('user.profile', compact('pendaftar', 'user', 'isRegistrationOpen', 'title', 'profile'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'new_password.min' => 'Password harus minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = auth()->user();
        // Update nama jika ada
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Data akun berhasil diperbarui');
    }

    public function index()
    {
        $title = "Data Pengguna";
        $name = Auth::user()->name;
        $profilSekolah = ProfilSekolah::first();
        return view('admin.users.index', compact('title', 'name', 'profilSekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required'
        ]);

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role' => $request->get('role')
        ]);

        $user->save();

        return redirect('/admin/users')->with('success', 'Data Pengguna berhasil diperbarui');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:6|confirmed',
            ]);

            $user = User::findOrFail($id);
            $user->name = $request->get('name');
            $user->email = $request->get('email');

            if ($request->get('password')) {
                $user->password = Hash::make($request->get('password'));
            }
            $user->save();

            return redirect('/admin/users')->with('success', 'Data Pengguna berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('users.update', $id)]);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/users')->with('success', 'Data Pengguna berhasil dihapus');
    }

    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'user')
                ->select(['id', 'name', 'email']) // Pilih hanya kolom yang diperlukan
                ->get()
                ->map(function ($item, $index) {
                    $item->no = $index + 1; // Tambahkan kolom 'no' untuk nomor urut
                    return $item;
                });

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-warning btn-sm btn-edit" data-id="' . $row->id . '" data-name="' . $row->name . '" data-email="' . $row->email . '">Edit</button>';
                    $btn .= ' <form action="/admin/users/' . $row->id . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
