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
    
    /**
     * Display product detail page
     */
    public function showProduct($id)
    {
        return view('frontend.products.show', compact('id'));
    }
}

