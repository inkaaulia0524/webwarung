<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Tambahkan fungsi ini
    public function index()
    {
        return view('kasir.dashboard');
    }
}