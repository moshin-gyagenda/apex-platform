<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Supplier;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index page for Apex Platform
     */
    public function index()
    {
        // Check for low stock products and create notifications
        NotificationService::checkLowStock();

        // Overview Statistics
        $stats = [
            // Products
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'low_stock_products' => Product::whereColumn('quantity', '<=', 'reorder_level')->where('quantity', '>', 0)->count(),
            'out_of_stock' => Product::where('quantity', 0)->count(),
            'total_stock_value' => Product::sum(DB::raw('quantity * cost_price')),

            // Sales
            'total_sales' => Sale::count(),
            'today_sales' => Sale::whereDate('created_at', today())->count(),
            'monthly_sales' => Sale::whereMonth('created_at', now()->month)->count(),
            'total_revenue' => Sale::sum('final_amount'),
            'today_revenue' => Sale::whereDate('created_at', today())->sum('final_amount'),
            'monthly_revenue' => Sale::whereMonth('created_at', now()->month)->sum('final_amount'),
            'last_month_revenue' => Sale::whereMonth('created_at', now()->subMonth()->month)->sum('final_amount'),

            // Purchases
            'total_purchases' => Purchase::count(),
            'monthly_purchases' => Purchase::whereMonth('created_at', now()->month)->count(),
            'total_purchase_amount' => Purchase::sum('total_amount'),
            'monthly_purchase_amount' => Purchase::whereMonth('created_at', now()->month)->sum('total_amount'),

            // Customers & Suppliers
            'total_customers' => Customer::count(),
            'total_suppliers' => Supplier::count(),

            // Categories
            'total_categories' => Category::count(),
        ];

        // Calculate revenue growth
        if ($stats['last_month_revenue'] > 0) {
            $stats['revenue_growth'] = (($stats['monthly_revenue'] - $stats['last_month_revenue']) / $stats['last_month_revenue']) * 100;
        } else {
            $stats['revenue_growth'] = $stats['monthly_revenue'] > 0 ? 100 : 0;
        }

        // Recent Activity
        $recent = [
            'sales' => Sale::with(['customer', 'creator'])->latest()->take(5)->get(),
            'purchases' => Purchase::with(['supplier', 'creator'])->latest()->take(5)->get(),
            'products' => Product::with(['category', 'brand'])->latest()->take(5)->get(),
        ];

        // Top Selling Products
        $topProducts = Sale::join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', DB::raw('SUM(sale_items.quantity) as total_sold'), DB::raw('SUM(sale_items.subtotal) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Sales by Category
        $salesByCategory = Sale::join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.name', DB::raw('SUM(sale_items.quantity) as total_sold'), DB::raw('SUM(sale_items.subtotal) as total_revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Monthly Sales Chart Data
        $monthlySales = Sale::selectRaw('MONTH(created_at) as month, SUM(final_amount) as revenue, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $salesChart = [];
        $revenueChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlySales->firstWhere('month', $i);
            $salesChart[] = $monthData ? $monthData->count : 0;
            $revenueChart[] = $monthData ? $monthData->revenue : 0;
        }

        // Daily Sales for this month
        $dailySales = Sale::selectRaw('DAY(created_at) as day, SUM(final_amount) as revenue, COUNT(*) as count')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $dailySalesChart = [];
        $dailyRevenueChart = [];
        $daysInMonth = now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dayData = $dailySales->firstWhere('day', $i);
            $dailySalesChart[] = $dayData ? $dayData->count : 0;
            $dailyRevenueChart[] = $dayData ? $dayData->revenue : 0;
        }

        return view('backend.dashboard.index', compact(
            'stats',
            'recent',
            'topProducts',
            'salesByCategory',
            'salesChart',
            'revenueChart',
            'dailySalesChart',
            'dailyRevenueChart'
        ));
    }
}
