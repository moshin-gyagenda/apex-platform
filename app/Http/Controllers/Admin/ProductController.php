<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductModel;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'productModel']);

        // Search functionality (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(sku) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(barcode) LIKE ?', ['%' . $search . '%']);
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();
        $brands = Brand::all();
        
        // Get stats for all products (not just paginated)
        $allProductsQuery = Product::with(['category', 'brand']);
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allProductsQuery->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(sku) LIKE ?', ['%' . $search . '%']);
            });
        }
        if ($request->filled('category_id')) {
            $allProductsQuery->where('category_id', $request->category_id);
        }
        if ($request->filled('brand_id')) {
            $allProductsQuery->where('brand_id', $request->brand_id);
        }
        if ($request->filled('status')) {
            $allProductsQuery->where('status', $request->status);
        }
        $allProducts = $allProductsQuery->get();
        
        $stats = [
            'total' => $allProducts->count(),
            'active' => $allProducts->where('status', 'active')->count(),
            'inactive' => $allProducts->where('status', 'inactive')->count(),
            'low_stock' => $allProducts->filter(function($product) {
                return $product->quantity <= $product->reorder_level;
            })->count(),
        ];
        
        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ],
                'stats' => $stats,
            ]);
        }

        return view('backend.products.index', compact('products', 'categories', 'brands', 'stats'));
    }

    /**
     * Search products via AJAX (searches all products, not just paginated).
     */
    public function search(Request $request)
    {
        $query = Product::with(['category', 'brand', 'productModel']);

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

        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get all matching products (no pagination for search)
        $products = $query->latest()->get();

        return response()->json([
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category->name,
                    'brand' => $product->brand?->name ?? '—',
                    'quantity' => $product->quantity,
                    'reorder_level' => $product->reorder_level,
                    'cost_price' => $product->cost_price,
                    'selling_price' => $product->selling_price,
                    'status' => $product->status,
                    'edit_url' => route('admin.products.edit', $product->id),
                    'show_url' => route('admin.products.show', $product->id),
                    'delete_url' => route('admin.products.destroy', $product->id),
                ];
            }),
            'total' => $products->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $productModels = ProductModel::all();
        return view('backend.products.create', compact('categories', 'brands', 'productModels'));
    }

    /**
     * Generate a unique SKU for new products.
     */
    protected function generateUniqueSku(): string
    {
        do {
            $numeric = (int) Product::max('id') + 1;
            $sku = 'APEX-' . str_pad($numeric, 6, '0', STR_PAD_LEFT);
            if (Product::where('sku', $sku)->exists()) {
                $sku = 'APEX-' . strtoupper(Str::random(6)) . '-' . time();
            }
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['brand_id' => $request->input('brand_id') ?: null]);
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'model_id' => ['nullable', 'exists:product_models,id'],
            'name' => ['required', 'string', 'max:255'],
            'barcode' => ['nullable', 'string', 'max:255', 'unique:products,barcode'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg,bmp,ico,avif', 'max:2048'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'reorder_level' => ['nullable', 'integer', 'min:0'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'warranty_months' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $validated['sku'] = $this->generateUniqueSku();
        $validated['quantity'] = $validated['quantity'] ?? 0;
        $validated['reorder_level'] = $validated['reorder_level'] ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        // Check for low stock after creating product
        NotificationService::checkLowStock();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'productModel']);
        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $productModels = ProductModel::all();
        $product->load(['category', 'brand', 'productModel']);
        return view('backend.products.edit', compact('product', 'categories', 'brands', 'productModels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->merge(['brand_id' => $request->input('brand_id') ?: null]);
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'model_id' => ['nullable', 'exists:product_models,id'],
            'name' => ['required', 'string', 'max:255'],
            'barcode' => ['nullable', 'string', 'max:255', 'unique:products,barcode,' . $product->id],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg,bmp,ico,avif', 'max:2048'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'reorder_level' => ['nullable', 'integer', 'min:0'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'warranty_months' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);
        $validated['quantity'] = $validated['quantity'] ?? $product->quantity;
        $validated['reorder_level'] = $validated['reorder_level'] ?? $product->reorder_level;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        // Check for low stock after update
        NotificationService::checkLowStock();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Export products to Excel (CSV format).
     */
    public function exportExcel(Request $request)
    {
        $query = Product::with(['category', 'brand', 'productModel']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(sku) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(barcode) LIKE ?', ['%' . $search . '%']);
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->get();

        $filename = 'products_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 to ensure Excel displays correctly
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'SKU',
                'Product Name',
                'Category',
                'Brand',
                'Barcode',
                'Cost Price (UGX)',
                'Selling Price (UGX)',
                'Quantity',
                'Reorder Level',
                'Status',
                'Created At',
            ]);

            // Data rows
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->sku,
                    $product->name,
                    $product->category?->name ?? '—',
                    $product->brand?->name ?? '—',
                    $product->barcode ?? '—',
                    $product->cost_price ? number_format($product->cost_price, 2) : '—',
                    $product->selling_price ? number_format($product->selling_price, 2) : '—',
                    $product->quantity ?? 0,
                    $product->reorder_level ?? 0,
                    ucfirst($product->status),
                    $product->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export products to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Product::with(['category', 'brand', 'productModel']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(sku) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(barcode) LIKE ?', ['%' . $search . '%']);
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->get();
        
        $data = [
            'products' => $products,
            'total' => $products->count(),
            'export_date' => now()->format('F d, Y H:i:s'),
        ];

        try {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.products.export-pdf', $data);
            $pdf->setPaper('a4', 'landscape');
            
            return $pdf->download('products_' . date('Y-m-d_His') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->route('admin.products.index')
                ->with('error', 'Failed to generate PDF. Please try again.');
        }
    }
}
