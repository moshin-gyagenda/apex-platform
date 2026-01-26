<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Display category page
     */
    public function category($id)
    {
        $category = Category::with('products')->findOrFail($id);
        
        // Get recently viewed products from session
        $recentlyViewedIds = session()->get('recently_viewed', []);
        $recentlyViewedProducts = Product::with(['category', 'brand'])
            ->whereIn('id', $recentlyViewedIds)
            ->where('status', 'active')
            ->limit(5)
            ->get();
        
        return view('frontend.categories.index', compact('category', 'recentlyViewedProducts'));
    }

    /**
     * Display sub-category page
     */
    public function subCategory($id)
    {
        // For now, treat sub-category same as category since we don't have sub-categories table
        // You can create a SubCategory model later if needed
        $subcategory = Category::with('products')->findOrFail($id);
        
        return view('frontend.sub-categories.index', compact('subcategory'));
    }

    /**
     * Display dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Calculate order statistics
        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'total_amount' => Order::where('user_id', $user->id)->sum('total_amount'),
            'orders_this_month' => Order::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'monthly_amount' => Order::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
            'last_month_amount' => Order::where('user_id', $user->id)
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->sum('total_amount'),
            'pending_orders' => Order::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'processing_orders' => Order::where('user_id', $user->id)
                ->where('status', 'processing')
                ->count(),
            'delivered_orders' => Order::where('user_id', $user->id)
                ->where('status', 'delivered')
                ->count(),
        ];
        
        // Calculate growth
        if ($stats['last_month_amount'] > 0) {
            $stats['amount_growth'] = (($stats['monthly_amount'] - $stats['last_month_amount']) / $stats['last_month_amount']) * 100;
        } else {
            $stats['amount_growth'] = $stats['monthly_amount'] > 0 ? 100 : 0;
        }
        
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['orderItems.product', 'shippingInfo'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get all orders for order history
        $orders = Order::where('user_id', $user->id)
            ->with(['orderItems.product', 'shippingInfo'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Monthly orders chart data
        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue, COUNT(*) as count')
            ->where('user_id', $user->id)
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $ordersChart = [];
        $revenueChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlyOrders->firstWhere('month', $i);
            $ordersChart[] = $monthData ? $monthData->count : 0;
            $revenueChart[] = $monthData ? $monthData->revenue : 0;
        }
        
        // Orders by status
        $ordersByStatus = Order::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('status')
            ->get();
        
        // Get wishlist items (if you have a wishlist table)
        $wishlistItems = collect([]); // Placeholder - implement wishlist if needed
        
        return view('frontend.dashboard.index', compact(
            'stats',
            'recentOrders',
            'orders',
            'wishlistItems',
            'ordersChart',
            'revenueChart',
            'ordersByStatus'
        ));
    }

    /**
     * Display account settings
     */
    public function accountSettings()
    {
        $user = auth()->user();
        
        return view('frontend.dashboard.account-settings', compact('user'));
    }

    /**
     * Display wishlist
     */
    public function wishlist()
    {
        // Placeholder - implement wishlist if you have a wishlist table
        $wishlistItems = collect([]);
        
        return view('frontend.wishlists.index', compact('wishlistItems'));
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        // Check if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items to your cart before checkout.');
        }

        $cartItems = [];
        
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->selling_price,
                    'quantity' => $quantity,
                    'attributes' => [
                        'image' => $product->image,
                    ],
                ];
            }
        }
        
        return view('frontend.check-outs.index', compact('cartItems'));
    }

    /**
     * Display payments page
     */
    public function payments()
    {
        // Check if cart is empty
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('frontend.payments.index');
    }

    /**
     * Update user information
     */
    public function updateUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'mobile_number' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'name' => $request->first_name . ' ' . $request->last_name, // Update name field too
        ]);

        return redirect()->back()->with('success', 'Account information updated successfully.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    /**
     * Update profile picture
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        // Delete old profile photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new profile photo
        $path = $request->file('profile_photo')->store('profiles', 'public');
        
        $user->update([
            'profile_photo' => $path,
        ]);

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }
}

