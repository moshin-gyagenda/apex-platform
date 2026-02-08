<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductModel;
use App\Models\Setting;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    /**
     * Display the POS dashboard.
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')->with(['category', 'brand']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(sku) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(barcode) LIKE ?', ['%' . $search . '%']);
            });
        }

        $products = $query->paginate(20)->withQueryString();
        $customers = Customer::all();
        $categories = Category::all();
        $brands = Brand::all();
        $productModels = ProductModel::all();
        
        // Prepare products JSON for JavaScript (all active products)
        $productsJson = Product::where('status', 'active')
            ->with(['category', 'brand', 'productModel'])
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'barcode' => $p->barcode,
                    'selling_price' => (float) $p->selling_price,
                    'quantity' => $p->quantity,
                    'image' => $p->image ? asset('assets/images/' . $p->image) : null,
                    'category_id' => $p->category_id,
                    'category_name' => $p->category->name ?? null,
                    'brand_id' => $p->brand_id,
                    'brand_name' => $p->brand->name ?? null,
                    'model_id' => $p->product_model_id,
                    'model_name' => $p->productModel->name ?? null,
                ];
            })
            ->toArray();
        
        // Get tax percentage from settings (default to 0%)
        $taxPercentage = Setting::get('tax_rate', 0);
        
        return view('backend.pos.index', compact('products', 'customers', 'categories', 'brands', 'productModels', 'productsJson', 'taxPercentage'));
    }

    /**
     * Process and complete a sale.
     */
    public function store(Request $request)
    {
        // Handle JSON requests - parse and replace request data
        $contentType = $request->header('Content-Type', '');
        if (strpos($contentType, 'application/json') !== false || $request->isJson()) {
            $jsonContent = $request->getContent();
            if (!empty($jsonContent)) {
                $jsonData = json_decode($jsonContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($jsonData)) {
                    // Replace all request data with JSON data
                    $request->replace($jsonData);
                }
            }
        }

        try {
            $validated = $request->validate([
                'customer_id' => ['nullable', 'exists:customers,id'],
                'items' => ['required', 'array', 'min:1'],
                'items.*.product_id' => ['required', 'exists:products,id'],
                'items.*.quantity' => ['required', 'integer', 'min:1'],
                'items.*.unit_price' => ['required', 'numeric', 'min:0'],
                'items.*.subtotal' => ['required', 'numeric', 'min:0'],
                'total_amount' => ['required', 'numeric', 'min:0'],
                'discount' => ['nullable', 'numeric', 'min:0'],
                'tax' => ['nullable', 'numeric', 'min:0'],
                'final_amount' => ['required', 'numeric', 'min:0'],
                'amount_paid' => ['required', 'numeric', 'min:0'],
                'balance' => ['required', 'numeric', 'min:0'],
                'payment_method' => ['required', 'in:cash,mobile_money'],
                'payment_status' => ['required', 'in:completed,pending,partial'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            \Log::error('POS Validation Error', [
                'errors' => $errors,
                'request_all' => $request->all(),
                'content_type' => $request->header('Content-Type'),
                'is_json' => $request->isJson(),
                'raw_content' => substr($request->getContent(), 0, 500)
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $errors),
                'errors' => $e->validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Calculate final amounts
            $totalAmount = $validated['total_amount'];
            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;
            $finalAmount = $validated['final_amount'];
            $amountPaid = $validated['amount_paid'] ?? 0;
            $balance = $validated['balance'] ?? 0;
            $paymentStatus = $validated['payment_status'];

            // Create sale
            $sale = Sale::create([
                'customer_id' => $validated['customer_id'] ?? null,
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'tax' => $tax,
                'final_amount' => $finalAmount,
                'amount_paid' => $amountPaid,
                'balance' => $balance,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
                'created_by' => auth()->id(),
            ]);

            // Create sale items and update product quantities
            // Note: For pending/partial payments, we still reduce stock as the order is created
            // You may want to adjust this behavior based on your business logic
            foreach ($validated['items'] as $item) {
                // Check product availability
                $product = Product::find($item['product_id']);
                if (!$product || $product->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->quantity}, Requested: {$item['quantity']}");
                }

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update product quantity (reduce stock)
                $product->quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            // Create notification for new sale
            NotificationService::notifyNewSale($sale);

            // Check for low stock after sale
            NotificationService::checkLowStock();

            return response()->json([
                'success' => true,
                'message' => 'Sale completed successfully!',
                'sale_id' => $sale->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Search products by barcode or SKU (for barcode scanner).
     */
    public function searchProduct(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $products = Product::where('status', 'active')
            ->where('quantity', '>', 0)
            ->where(function($q) use ($query) {
                $q->where('barcode', $query)
                  ->orWhere('sku', $query)
                  ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($query) . '%']);
            })
            ->with(['category', 'brand'])
            ->limit(10)
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'barcode' => $p->barcode,
                    'selling_price' => $p->selling_price,
                    'quantity' => $p->quantity,
                    'image' => $p->image ? asset('assets/images/' . $p->image) : null,
                ];
            });

        return response()->json($products);
    }

    /**
     * Search all products for POS (AJAX - searches all products, not just paginated).
     */
    public function search(Request $request)
    {
        // Show active products (including those with 0 quantity - they just can't be added to cart)
        $query = Product::where('status', 'active')
            ->with(['category', 'brand', 'productModel']);

        // Search functionality (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(sku) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(barcode) LIKE ?', ['%' . $search . '%'])
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                  })
                  ->orWhereHas('brand', function($q) use ($search) {
                      $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                  });
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by brand - handle "no brand" (null) products
        if ($request->filled('brand_id')) {
            if ($request->brand_id === 'null' || $request->brand_id === 'none') {
                // Show only products without brands
                $query->whereNull('brand_id');
            } else {
                // Show products with specific brand
                $query->where('brand_id', $request->brand_id);
            }
        }


        // Get all matching products (no pagination for search)
        $products = $query->latest()->get();

        return response()->json([
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'barcode' => $product->barcode,
                    'description' => $product->description,
                    'cost_price' => (float) $product->cost_price,
                    'selling_price' => $product->selling_price !== null ? (float) $product->selling_price : null,
                    'quantity' => $product->quantity,
                    'reorder_level' => $product->reorder_level,
                    'serial_number' => $product->serial_number,
                    'warranty_months' => $product->warranty_months,
                    'status' => $product->status,
                    'image' => $product->image ? asset('assets/images/' . $product->image) : null,
                    'category_id' => $product->category_id,
                    'category_name' => $product->category ? $product->category->name : null,
                    'brand_id' => $product->brand_id,
                    'brand_name' => $product->brand ? $product->brand->name : null,
                    'model_id' => $product->model_id,
                    'model_name' => $product->productModel ? $product->productModel->name : null,
                ];
            }),
            'total' => $products->count(),
        ]);
    }
}
