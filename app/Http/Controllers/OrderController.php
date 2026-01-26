<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'shippingInfo'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.orders.index', compact('orders'));
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
            // Retrieve the latest shipping info for the authenticated user
            $shipping_info = ShippingInfo::where('user_id', auth()->user()->id)->latest()->first();

            // Throw an exception if no shipping info is found
            if (!$shipping_info) {
                throw new \Exception('Shipping information not found. Please complete checkout first.');
            }

            // Create a new order object
            $order = new Order();

            // Set properties of the order using request values
            $order->user_id = auth()->user()->id;
            $order->shipping_info_id = $shipping_info->id;
            $order->order_number = strtoupper(substr((string) Str::uuid(), 0, 6));
            $order->payment_method = $request->input('payment_method');
            $order->transaction_id = $request->input('transaction_id');

            // Handle the transaction photo upload
            if ($request->hasFile('transaction_photo')) {
                $transactionPhotoPath = $this->storeImage($request->file('transaction_photo'), 'transaction_photos');
                $order->transaction_photo = $transactionPhotoPath;
            }

            // Retrieve cart items from session and calculate subtotal
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                throw new \Exception('Cart is empty.');
            }

            $cartItems = [];
            $subtotal = 0;
            
            foreach ($cart as $productId => $quantity) {
                $product = \App\Models\Product::find($productId);
                if ($product) {
                    $itemSubtotal = $product->selling_price * $quantity;
                    $subtotal += $itemSubtotal;
                    $cartItems[] = [
                        'id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->selling_price,
                    ];
                }
            }

            // Allow taxes to be set via request, default to 0
            $taxes = $request->input('taxes', 0);

            // Calculate total amount
            $totalAmount = $subtotal + $taxes;

            // Set the order's financial details
            $order->total_amount = $totalAmount;
            $order->subtotal = $subtotal;
            $order->taxes = $taxes;
            $order->status = 'pending'; // Initial status

            // Save the order to the database
            $order->save();

            // Store each cart item as an order item
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Clear the cart after successfully storing order items
            session()->forget('cart');

            // Commit the transaction
            DB::commit();

            // Redirect to the order confirmation page with success message
            return redirect()->route('orders.confirm')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();

            // Log the exception for debugging
            \Log::error('Order Creation Error: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'An error occurred while creating the order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'shippingInfo', 'user'])->findOrFail($id);

        return view('backend.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Begin transaction
            DB::beginTransaction();

            // Find the order by ID
            $order = Order::findOrFail($id);

            // Validate the incoming request
            $request->validate([
                'order_status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
                'comment' => 'nullable|string|max:255',
            ]);

            // Get the new status from the request
            $newStatus = $request->input('order_status');

            // Check if the current status is 'Shipped', 'Delivered', or 'Cancelled' to prevent updates
            if (in_array($order->status, ['shipped', 'delivered', 'cancelled'])) {
                return redirect()->back()->with('error', 'Cannot update order status as it is already ' . ucfirst($order->status) . '.');
            }

            // Update the order status and comment
            $order->status = $newStatus;
            $order->comment = $request->input('comment', null);
            $order->save();

            // Commit transaction
            DB::commit();

            return redirect()->back()->with('success', 'Order status updated successfully to "' . ucfirst($newStatus) . '".');
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();

            return redirect()->back()->with('error', 'Updating order status failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * Display order confirmation page
     */
    public function confirm()
    {
        $order = Order::with(['shippingInfo', 'orderItems.product', 'user'])
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('frontend.index')->with('error', 'No order found.');
        }

        return view('frontend.orders.confirm', compact('order'));
    }

    /**
     * Store image file
     */
    private function storeImage($file, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . Str::random(10) . '.' . $extension;
        $file->move(public_path('storage/transaction_photos'), $filename);
        return 'transaction_photos/' . $filename;
    }
}
