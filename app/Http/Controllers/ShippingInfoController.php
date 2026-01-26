<?php

namespace App\Http\Controllers;

use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'country' => 'required|string|max:255',
                'state_region' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'street_address' => 'required|string|max:500',
                'other_name' => 'nullable|string|max:255',
                'additional_info' => 'nullable|string',
                'delivery_method' => 'nullable|string|max:255',
            ]);

            // Create a new shipping info object
            $shippingInfo = new ShippingInfo();
            $shippingInfo->user_id = auth()->user()->id;
            $shippingInfo->first_name = $validated['first_name'];
            $shippingInfo->last_name = $validated['last_name'];
            $shippingInfo->other_name = $validated['other_name'] ?? null;
            $shippingInfo->email = $validated['email'];
            $shippingInfo->phone = $validated['phone'];
            $shippingInfo->country = $validated['country'];
            $shippingInfo->state_region = $validated['state_region'];
            $shippingInfo->city = $validated['city'];
            $shippingInfo->street_address = $validated['street_address'];
            $shippingInfo->additional_info = $validated['additional_info'] ?? null;
            $shippingInfo->delivery_method = $validated['delivery_method'] ?? null;

            // Save the shipping info
            $shippingInfo->save();

            // Commit the transaction
            DB::commit();

            // Redirect to payment page with success message
            return redirect()->route('frontend.payments.index')->with('success', 'Shipping information saved successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to store shipping information: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Store shipping info from account settings
     */
    public function shippingStore(Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'country' => 'nullable|string|max:255',
                'state_region' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'street_address' => 'required|string|max:500',
                'other_name' => 'nullable|string|max:255',
                'additional_info' => 'nullable|string',
            ]);

            // Create a new shipping info object
            $shippingInfo = new ShippingInfo();
            $shippingInfo->user_id = auth()->user()->id;
            $shippingInfo->first_name = $validated['first_name'];
            $shippingInfo->last_name = $validated['last_name'];
            $shippingInfo->other_name = $validated['other_name'] ?? null;
            $shippingInfo->email = $validated['email'];
            $shippingInfo->phone = $validated['phone'];
            $shippingInfo->country = $validated['country'] ?? null;
            $shippingInfo->state_region = $validated['state_region'] ?? null;
            $shippingInfo->city = $validated['city'];
            $shippingInfo->street_address = $validated['street_address'];
            $shippingInfo->additional_info = $validated['additional_info'] ?? null;

            // Save the shipping info
            $shippingInfo->save();

            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Shipping information saved successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to store shipping information: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'country' => 'nullable|string|max:255',
                'state_region' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'street_address' => 'required|string|max:500',
                'other_name' => 'nullable|string|max:255',
                'additional_info' => 'nullable|string',
                'delivery_method' => 'nullable|string|max:255',
            ]);

            $shippingInfo = ShippingInfo::findOrFail($id);

            // Check if the shipping info belongs to the authenticated user
            if ($shippingInfo->user_id !== auth()->user()->id) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Update the shipping info fields
            $shippingInfo->first_name = $validated['first_name'];
            $shippingInfo->last_name = $validated['last_name'];
            $shippingInfo->other_name = $validated['other_name'] ?? null;
            $shippingInfo->email = $validated['email'];
            $shippingInfo->phone = $validated['phone'];
            $shippingInfo->country = $validated['country'] ?? null;
            $shippingInfo->state_region = $validated['state_region'] ?? null;
            $shippingInfo->city = $validated['city'];
            $shippingInfo->street_address = $validated['street_address'];
            $shippingInfo->additional_info = $validated['additional_info'] ?? null;
            $shippingInfo->delivery_method = $validated['delivery_method'] ?? null;

            // Save the updated shipping info
            $shippingInfo->save();

            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Shipping information updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to update shipping information: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
