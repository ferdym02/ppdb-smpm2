<?php

namespace App\Http\Controllers;

use App\Models\User;
// use App\Models\Periode;
// use App\Models\Pendaftar;
// use App\Models\SchoolProfile;
// use App\Models\Jadwal;
// use App\Models\Pengumuman;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserContoller extends Controller
{
    public function userDashboard()
    {
        $title = "Dashboard Calon Siswa";

        return view('user.dashboard', compact('title'));
    }
}
