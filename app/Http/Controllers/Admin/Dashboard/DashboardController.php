<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];
        record_created_flash('Login success');
        set_page_meta('Dashboard');
        return view('admin.dashboard.index', compact('data'));
    }
}
