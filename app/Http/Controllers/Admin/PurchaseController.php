<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'creator']);

        // Search functionality (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(invoice_number) LIKE ?', ['%' . $search . '%']);
            });
        }

        // Filter by supplier
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('purchase_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('purchase_date', '<=', $request->date_to);
        }

        $purchases = $query->latest('purchase_date')->paginate(15)->withQueryString();
        $suppliers = Supplier::all();
        
        // Get stats for all purchases (not just paginated)
        $allPurchasesQuery = Purchase::with(['supplier']);
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allPurchasesQuery->where(function($q) use ($search) {
                $q->whereRaw('LOWER(invoice_number) LIKE ?', ['%' . $search . '%']);
            });
        }
        if ($request->filled('supplier_id')) {
            $allPurchasesQuery->where('supplier_id', $request->supplier_id);
        }
        $allPurchases = $allPurchasesQuery->get();
        
        $stats = [
            'total' => $allPurchases->count(),
            'total_amount' => $allPurchases->sum('total_amount'),
        ];
        
        return view('backend.purchases.index', compact('purchases', 'suppliers', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::with(['category', 'brand'])->get();
        $productsJson = $products->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'sku' => $p->sku,
                'cost_price' => $p->cost_price
            ];
        })->toArray();
        return view('backend.purchases.create', compact('suppliers', 'products', 'productsJson'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'invoice_number' => ['required', 'string', 'max:255', 'unique:purchases,invoice_number'],
            'purchase_date' => ['required', 'date'],
            'item_product_id' => ['required', 'array'],
            'item_product_id.*' => ['required', 'exists:products,id'],
            'item_quantity' => ['required', 'array'],
            'item_quantity.*' => ['required', 'integer', 'min:1'],
            'item_cost_price' => ['required', 'array'],
            'item_cost_price.*' => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            // Calculate total amount
            $totalAmount = 0;
            $items = [];
            foreach ($validated['item_product_id'] as $index => $productId) {
                $quantity = $validated['item_quantity'][$index];
                $costPrice = $validated['item_cost_price'][$index];
                $subtotal = $quantity * $costPrice;
                $totalAmount += $subtotal;
                $items[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'cost_price' => $costPrice,
                    'subtotal' => $subtotal,
                ];
            }

            // Create purchase
            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'invoice_number' => $validated['invoice_number'],
                'total_amount' => $totalAmount,
                'purchase_date' => $validated['purchase_date'],
                'created_by' => auth()->id(),
            ]);

            // Create purchase items
            foreach ($items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update product quantity and cost price
                $product = Product::find($item['product_id']);
                $product->quantity += $item['quantity'];
                $product->cost_price = $item['cost_price'];
                $product->save();
            }

            DB::commit();

            // Check for low stock after purchase (in case some products are still low)
            NotificationService::checkLowStock();

            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create purchase: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'creator', 'purchaseItems.product']);
        return view('backend.purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all();
        $products = Product::with(['category', 'brand'])->get();
        $purchase->load(['supplier', 'purchaseItems.product']);
        return view('backend.purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'invoice_number' => ['required', 'string', 'max:255', 'unique:purchases,invoice_number,' . $purchase->id],
            'purchase_date' => ['required', 'date'],
            'item_product_id' => ['required', 'array'],
            'item_product_id.*' => ['required', 'exists:products,id'],
            'item_quantity' => ['required', 'array'],
            'item_quantity.*' => ['required', 'integer', 'min:1'],
            'item_cost_price' => ['required', 'array'],
            'item_cost_price.*' => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            // Revert old quantities
            foreach ($purchase->purchaseItems as $oldItem) {
                $product = Product::find($oldItem->product_id);
                $product->quantity -= $oldItem->quantity;
                $product->save();
            }

            // Calculate new total amount
            $totalAmount = 0;
            $items = [];
            foreach ($validated['item_product_id'] as $index => $productId) {
                $quantity = $validated['item_quantity'][$index];
                $costPrice = $validated['item_cost_price'][$index];
                $subtotal = $quantity * $costPrice;
                $totalAmount += $subtotal;
                $items[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'cost_price' => $costPrice,
                    'subtotal' => $subtotal,
                ];
            }

            // Update purchase
            $purchase->update([
                'supplier_id' => $validated['supplier_id'],
                'invoice_number' => $validated['invoice_number'],
                'total_amount' => $totalAmount,
                'purchase_date' => $validated['purchase_date'],
            ]);

            // Delete old items
            $purchase->purchaseItems()->delete();

            // Create new purchase items
            foreach ($items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update product quantity and cost price
                $product = Product::find($item['product_id']);
                $product->quantity += $item['quantity'];
                $product->cost_price = $item['cost_price'];
                $product->save();
            }

            DB::commit();

            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update purchase: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();
        try {
            // Revert product quantities
            foreach ($purchase->purchaseItems as $item) {
                $product = Product::find($item->product_id);
                $product->quantity -= $item->quantity;
                $product->save();
            }

            $purchase->delete();

            DB::commit();

            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete purchase: ' . $e->getMessage());
        }
    }
}
