<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductModel::with('brand');

        // Search functionality (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(model_number) LIKE ?', ['%' . $search . '%']);
            });
        }

        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $productModels = $query->latest()->paginate(15)->withQueryString();
        $brands = Brand::all();
        
        // Get stats for all product models (not just paginated)
        $allProductModelsQuery = ProductModel::with('brand');
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allProductModelsQuery->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(model_number) LIKE ?', ['%' . $search . '%']);
            });
        }
        if ($request->filled('brand_id')) {
            $allProductModelsQuery->where('brand_id', $request->brand_id);
        }
        $allProductModels = $allProductModelsQuery->get();
        
        $stats = [
            'total' => $allProductModels->count(),
        ];
        
        return view('backend.product-models.index', compact('productModels', 'brands', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        return view('backend.product-models.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'model_number' => ['nullable', 'string', 'max:255'],
            'spec_key' => ['nullable', 'array'],
            'spec_value' => ['nullable', 'array'],
        ]);

        // Convert key-value pairs to array
        $specifications = null;
        if ($request->has('spec_key') && $request->has('spec_value')) {
            $specs = [];
            $keys = $request->spec_key ?? [];
            $values = $request->spec_value ?? [];
            
            foreach ($keys as $index => $key) {
                if (!empty($key) && isset($values[$index]) && !empty($values[$index])) {
                    $specs[$key] = $values[$index];
                }
            }
            
            $specifications = !empty($specs) ? $specs : null;
        }

        ProductModel::create([
            'brand_id' => $validated['brand_id'],
            'name' => $validated['name'],
            'model_number' => $validated['model_number'] ?? null,
            'specifications' => $specifications,
        ]);

        return redirect()->route('admin.product-models.index')
            ->with('success', 'Product model created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductModel $productModel)
    {
        $productModel->load('brand');
        return view('backend.product-models.show', compact('productModel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductModel $productModel)
    {
        $brands = Brand::all();
        $productModel->load('brand');
        return view('backend.product-models.edit', compact('productModel', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductModel $productModel)
    {
        $validated = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'model_number' => ['nullable', 'string', 'max:255'],
            'spec_key' => ['nullable', 'array'],
            'spec_value' => ['nullable', 'array'],
        ]);

        // Convert key-value pairs to array
        $specifications = null;
        if ($request->has('spec_key') && $request->has('spec_value')) {
            $specs = [];
            $keys = $request->spec_key ?? [];
            $values = $request->spec_value ?? [];
            
            foreach ($keys as $index => $key) {
                if (!empty($key) && isset($values[$index]) && !empty($values[$index])) {
                    $specs[$key] = $values[$index];
                }
            }
            
            $specifications = !empty($specs) ? $specs : null;
        }

        $productModel->update([
            'brand_id' => $validated['brand_id'],
            'name' => $validated['name'],
            'model_number' => $validated['model_number'] ?? null,
            'specifications' => $specifications,
        ]);

        return redirect()->route('admin.product-models.index')
            ->with('success', 'Product model updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductModel $productModel)
    {
        $productModel->delete();

        return redirect()->route('admin.product-models.index')
            ->with('success', 'Product model deleted successfully.');
    }
}
