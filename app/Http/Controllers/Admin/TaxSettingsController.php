<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class TaxSettingsController extends Controller
{
    /**
     * Show the form for editing tax settings.
     */
    public function edit()
    {
        $taxPercentage = Setting::get('tax_percentage', 0);
        
        return view('backend.settings.tax.edit', compact('taxPercentage'));
    }

    /**
     * Update the tax settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'tax_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        Setting::set(
            'tax_percentage',
            $validated['tax_percentage'],
            'number',
            'Tax percentage applied to sales'
        );

        return redirect()->route('admin.settings.tax.edit')
            ->with('success', 'Tax settings updated successfully.');
    }
}
