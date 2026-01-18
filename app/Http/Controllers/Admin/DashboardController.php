<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index page for Apex Platform
     */
    public function index()
    {
        return view('backend.dashboard.index');
    }
}
