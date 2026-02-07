<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Search functionality (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(company) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . $search . '%']);
            });
        }

        $suppliers = $query->latest()->paginate(15)->withQueryString();
        
        // Get stats for all suppliers (not just paginated)
        $allSuppliersQuery = Supplier::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allSuppliersQuery->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(company) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
            });
        }
        $allSuppliers = $allSuppliersQuery->get();
        
        $stats = [
            'total' => $allSuppliers->count(),
        ];
        
        return view('backend.suppliers.index', compact('suppliers', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('backend.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('backend.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }

    /**
     * Export suppliers to Excel (CSV format).
     */
    public function exportExcel(Request $request)
    {
        $query = Supplier::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(company) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . $search . '%']);
            });
        }
        $suppliers = $query->latest()->get();

        $filename = 'suppliers_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($suppliers) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Name', 'Company', 'Phone', 'Email', 'Address', 'Created At']);
            foreach ($suppliers as $s) {
                fputcsv($file, [
                    $s->name,
                    $s->company ?? '—',
                    $s->phone ?? '—',
                    $s->email ?? '—',
                    $s->address ?? '—',
                    $s->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export suppliers to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Supplier::query();
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(company) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . $search . '%']);
            });
        }
        $suppliers = $query->latest()->get();
        $data = [
            'suppliers' => $suppliers,
            'total' => $suppliers->count(),
            'export_date' => now()->format('F d, Y H:i:s'),
        ];
        try {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.suppliers.export-pdf', $data);
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download('suppliers_' . date('Y-m-d_His') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'Failed to generate PDF. Please try again.');
        }
    }
}
