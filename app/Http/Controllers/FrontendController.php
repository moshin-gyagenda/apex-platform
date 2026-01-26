<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class FrontendController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        // Fetch categories from database
        $categories = Category::orderBy('name', 'asc')->get();
        
        // Fetch featured products (sorted by price - cheapest first)
        $featuredProducts = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->orderBy('selling_price', 'asc')
            ->limit(10)
            ->get();
        
        // Fetch flash sale products (sorted by price - cheapest first)
        $flashProducts = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->orderBy('selling_price', 'asc')
            ->limit(6)
            ->get();
        
        // Get recently viewed products from session
        $recentlyViewedIds = session()->get('recently_viewed', []);
        $recentlyViewedProducts = Product::with(['category', 'brand'])
            ->whereIn('id', $recentlyViewedIds)
            ->where('status', 'active')
            ->limit(6)
            ->get();
        
        return view('frontend.index', compact('categories', 'featuredProducts', 'flashProducts', 'recentlyViewedProducts'));
    }
    
    /**
     * Display product detail page
     */
    public function showProduct($id)
    {
        $product = Product::with(['category', 'brand', 'productModel'])
            ->findOrFail($id);
        
        // Store recently viewed product
        $recentlyViewed = session()->get('recently_viewed', []);
        if (!in_array($product->id, $recentlyViewed)) {
            array_unshift($recentlyViewed, $product->id);
            $recentlyViewed = array_slice($recentlyViewed, 0, 6);
            session()->put('recently_viewed', $recentlyViewed);
        }
        
        // Get related products from same category (sorted by price - cheapest first)
        $relatedProducts = Product::with(['category', 'brand'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->orderBy('selling_price', 'asc')
            ->limit(5)
            ->get();
        
        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}

