<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'creator', 'saleItems.product']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                  })
                  ->orWhereHas('creator', function($q) use ($search) {
                      $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                  });
            });
        }
        
        // Filter by payment method
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }
        
        // Filter by payment status
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        $sales = $query->latest()->paginate(15)->withQueryString();
        
        // Get stats for all sales
        $allSalesQuery = Sale::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allSalesQuery->where(function($q) use ($search) {
                $q->where('id', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                  });
            });
        }
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $allSalesQuery->where('payment_method', $request->payment_method);
        }
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $allSalesQuery->where('payment_status', $request->payment_status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $allSalesQuery->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        $allSales = $allSalesQuery->get();
        $stats = [
            'total' => $allSales->count(),
            'total_amount' => $allSales->sum('final_amount'),
            'completed' => $allSales->where('payment_status', 'completed')->count(),
            'pending' => $allSales->where('payment_status', 'pending')->count(),
        ];
        
        return view('backend.sales.index', compact('sales', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer', 'creator', 'saleItems.product']);
        return view('backend.sales.show', compact('sale'));
    }
}
