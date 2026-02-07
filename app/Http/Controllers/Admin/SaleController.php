<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleReturn;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $sale->load(['customer', 'creator', 'saleItems.product', 'returns.product']);
        
        // Calculate returned quantities for each sale item
        $returnedQuantities = [];
        foreach ($sale->returns as $return) {
            if ($return->sale_item_id) {
                $returnedQuantities[$return->sale_item_id] = 
                    ($returnedQuantities[$return->sale_item_id] ?? 0) + $return->quantity_returned;
            }
        }
        
        return view('backend.sales.show', compact('sale', 'returnedQuantities'));
    }

    /**
     * Display receipt for the sale.
     */
    public function receipt(Sale $sale)
    {
        $sale->load(['customer', 'creator', 'saleItems.product']);
        return view('backend.sales.receipt', compact('sale'));
    }

    /**
     * Download receipt as PDF.
     */
    public function downloadReceipt(Sale $sale)
    {
        $sale->load(['customer', 'creator', 'saleItems.product']);
        
        try {
            // Use the service container to resolve the PDF instance
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.sales.receipt', compact('sale'));
            $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait'); // 80mm width in points (80mm = 226.77pt)
            
            return $pdf->download('receipt-' . $sale->id . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            // Fallback: return view if PDF generation fails
            return view('backend.sales.receipt', compact('sale'));
        }
    }

    /**
     * Process a product return/refund.
     */
    public function processReturn(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'sale_item_id' => ['required', 'exists:sale_items,id'],
            'quantity_returned' => ['required', 'integer', 'min:1'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        try {
            $saleItem = SaleItem::findOrFail($validated['sale_item_id']);
            
            // Verify the sale item belongs to this sale
            if ($saleItem->sale_id !== $sale->id) {
                throw new \Exception('Invalid sale item for this sale.');
            }

            // Check if quantity to return is valid
            $alreadyReturned = SaleReturn::where('sale_item_id', $saleItem->id)
                ->where('status', 'approved')
                ->sum('quantity_returned');
            
            $availableToReturn = $saleItem->quantity - $alreadyReturned;
            
            if ($validated['quantity_returned'] > $availableToReturn) {
                throw new \Exception("Cannot return more than available. Available: {$availableToReturn}, Requested: {$validated['quantity_returned']}");
            }

            // Calculate refund amount
            $refundAmount = $validated['quantity_returned'] * $saleItem->unit_price;

            // Create return record
            $saleReturn = SaleReturn::create([
                'sale_id' => $sale->id,
                'sale_item_id' => $saleItem->id,
                'product_id' => $saleItem->product_id,
                'quantity_returned' => $validated['quantity_returned'],
                'unit_price' => $saleItem->unit_price,
                'refund_amount' => $refundAmount,
                'reason' => $validated['reason'] ?? null,
                'status' => 'approved', // Auto-approve for now, can be changed to 'pending' if approval needed
                'processed_by' => auth()->id(),
                'processed_at' => now(),
                'created_by' => auth()->id(),
            ]);

            // Update product stock (add back the returned quantity)
            $product = Product::find($saleItem->product_id);
            $product->quantity += $validated['quantity_returned'];
            $product->save();

            // Update sale payment status if full refund
            $totalReturned = SaleReturn::where('sale_id', $sale->id)
                ->where('status', 'approved')
                ->sum('refund_amount');
            
            if ($totalReturned >= $sale->final_amount) {
                $sale->payment_status = 'refunded';
                $sale->save();
            }

            DB::commit();

            return redirect()->route('admin.sales.show', $sale)
                ->with('success', 'Product return processed successfully. Stock has been updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to process return: ' . $e->getMessage());
        }
    }

    /**
     * Export sales to Excel (CSV format).
     */
    public function exportExcel(Request $request)
    {
        $query = Sale::with(['customer', 'creator']);
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
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        $sales = $query->latest()->get();

        $filename = 'sales_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($sales) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID', 'Customer', 'Payment Method', 'Payment Status', 'Final Amount (UGX)', 'Created By', 'Date']);
            foreach ($sales as $s) {
                fputcsv($file, [
                    $s->id,
                    $s->customer?->name ?? '—',
                    $s->payment_method ?? '—',
                    $s->payment_status ?? '—',
                    $s->final_amount ? number_format($s->final_amount, 2) : '—',
                    $s->creator?->name ?? '—',
                    $s->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export sales to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Sale::with(['customer', 'creator']);
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
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        $sales = $query->latest()->get();
        $data = [
            'sales' => $sales,
            'total' => $sales->count(),
            'total_amount' => $sales->sum('final_amount'),
            'export_date' => now()->format('F d, Y H:i:s'),
        ];
        try {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.sales.export-pdf', $data);
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download('sales_' . date('Y-m-d_His') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->route('admin.sales.index')
                ->with('error', 'Failed to generate PDF. Please try again.');
        }
    }
}
