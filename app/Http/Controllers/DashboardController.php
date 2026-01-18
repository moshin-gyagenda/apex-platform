<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index page for Mubs Script Marking & Tracing System
     */
    public function index()
    {
        return view('backend.dashboard.index');
    }
}

