<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Tambahkan fungsi ini
    public function index()
    {
        // Ini akan memanggil file: 
        // resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }
}