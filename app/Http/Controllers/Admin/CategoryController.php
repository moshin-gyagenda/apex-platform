<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        // Search functionality (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            });
        }

        $categories = $query->latest()->paginate(15)->withQueryString();
        
        // Get stats for all categories (not just paginated)
        $allCategoriesQuery = Category::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allCategoriesQuery->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            });
        }
        $allCategories = $allCategoriesQuery->get();
        
        $stats = [
            'total' => $allCategories->count(),
        ];
        
        return view('backend.categories.index', compact('categories', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        // Handle image upload (public/assets/images/categories)
        if ($request->hasFile('image')) {
            $dir = public_path('assets/images/categories');
            File::ensureDirectoryExists($dir);
            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug(pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . time() . '.' . $ext;
            $request->file('image')->move($dir, $filename);
            $validated['image'] = 'categories/' . $filename;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Quick store for AJAX (e.g. from product form). Expects JSON response.
     */
    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $category = Category::create($validated);
        return response()->json(['id' => $category->id, 'name' => $category->name]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('backend.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        // Handle image upload (public/assets/images/categories)
        if ($request->hasFile('image')) {
            if ($category->image) {
                $oldPath = public_path('assets/images/' . $category->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $dir = public_path('assets/images/categories');
            File::ensureDirectoryExists($dir);
            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug(pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . time() . '.' . $ext;
            $request->file('image')->move($dir, $filename);
            $validated['image'] = 'categories/' . $filename;
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            $path = public_path('assets/images/' . $category->image);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Export categories to Excel (CSV format).
     */
    public function exportExcel(Request $request)
    {
        $query = Category::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            });
        }
        $categories = $query->latest()->get();

        $filename = 'categories_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Name', 'Created At']);
            foreach ($categories as $cat) {
                fputcsv($file, [$cat->name, $cat->created_at->format('Y-m-d H:i:s')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export categories to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Category::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            });
        }
        $categories = $query->latest()->get();
        $data = [
            'categories' => $categories,
            'total' => $categories->count(),
            'export_date' => now()->format('F d, Y H:i:s'),
        ];
        try {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.categories.export-pdf', $data);
            $pdf->setPaper('a4', 'portrait');
            return $pdf->download('categories_' . date('Y-m-d_His') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')
                ->with('error', 'Failed to generate PDF. Please try again.');
        }
    }
}
