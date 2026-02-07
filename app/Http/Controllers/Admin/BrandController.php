<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Brand::query();

        // Search functionality (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            });
        }

        $brands = $query->latest()->paginate(15)->withQueryString();
        
        // Get stats for all brands (not just paginated)
        $allBrandsQuery = Brand::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allBrandsQuery->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            });
        }
        $allBrands = $allBrandsQuery->get();
        
        $stats = [
            'total' => $allBrands->count(),
        ];
        
        return view('backend.brands.index', compact('brands', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands,name'],
        ]);

        Brand::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    /**
     * Quick store for AJAX (e.g. from product form). Expects JSON response.
     */
    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands,name'],
        ]);

        $brand = Brand::create($validated);
        return response()->json(['id' => $brand->id, 'name' => $brand->name]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('backend.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('backend.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands,name,' . $brand->id],
        ]);

        $brand->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }

    /**
     * Export brands to Excel (CSV format).
     */
    public function exportExcel(Request $request)
    {
        $query = Brand::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            });
        }
        $brands = $query->latest()->get();

        $filename = 'brands_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($brands) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Name', 'Created At']);
            foreach ($brands as $brand) {
                fputcsv($file, [$brand->name, $brand->created_at->format('Y-m-d H:i:s')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export brands to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Brand::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            });
        }
        $brands = $query->latest()->get();
        $data = [
            'brands' => $brands,
            'total' => $brands->count(),
            'export_date' => now()->format('F d, Y H:i:s'),
        ];
        try {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.brands.export-pdf', $data);
            $pdf->setPaper('a4', 'portrait');
            return $pdf->download('brands_' . date('Y-m-d_His') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->route('admin.brands.index')
                ->with('error', 'Failed to generate PDF. Please try again.');
        }
    }
}
