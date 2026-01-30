<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftar;
use App\Models\SchoolProfile;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $title = "Dashboard Admin";
        $user = Auth::user();
        return view('admin.dashboard', compact('title', 'user'));
    }
}
