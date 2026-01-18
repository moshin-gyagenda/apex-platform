<?php

namespace App\Http\Controllers;

class FrontendController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        return view('frontend.index');
    }
}

