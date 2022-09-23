<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\GlobalConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->user_type == User::USER_TYPE_ADMIN){
            return redirect()->route('admin.dashboard');
        }else{
            $data = [];
            record_created_flash('Login success');
            set_page_meta('Dashboard');
            return view('home', compact('data'));
        }
    }
}
