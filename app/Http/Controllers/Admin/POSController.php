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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    /**
     * Display the POS dashboard.
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')->where('quantity', '>', 0)->with(['category', 'brand']);
        
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
        
        // Prepare products JSON for JavaScript (all active products with stock)
        $productsJson = Product::where('status', 'active')
            ->where('quantity', '>', 0)
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
                    'image' => $p->image ? asset('storage/' . $p->image) : null,
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
                'payment_method' => ['required', 'in:cash,card,mobile_money'],
                'payment_status' => ['required', 'in:completed,pending'],
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

            // Create sale
            $sale = Sale::create([
                'customer_id' => $validated['customer_id'] ?? null,
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'tax' => $tax,
                'final_amount' => $finalAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_status'],
                'created_by' => auth()->id(),
            ]);

            // Create sale items and update product quantities
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

                // Update product quantity
                $product->quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();

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
                    'image' => $p->image ? asset('storage/' . $p->image) : null,
                ];
            });

        return response()->json($products);
    }
}
