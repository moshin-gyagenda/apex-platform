<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->selling_price * $quantity,
                ];
                $total += $product->selling_price * $quantity;
            }
        }

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // Get quantity from request, default to 1
        $quantityToAdd = $request->input('quantity', 1);
        
        // Check if product is in stock
        if ($product->quantity <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock'
            ], 400);
        }

        $cart = Session::get('cart', []);
        
        // Check if adding this quantity would exceed stock
        $currentQuantity = $cart[$productId] ?? 0;
        if ($currentQuantity + $quantityToAdd > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        // Add or update quantity
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantityToAdd;
        } else {
            $cart[$productId] = $quantityToAdd;
        }

        Session::put('cart', $cart);

        $cartCount = array_sum($cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($productId);
        
        if ($request->quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        $cart = Session::get('cart', []);
        
        if ($request->quantity == 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $request->quantity;
        }

        Session::put('cart', $cart);

        $cartCount = array_sum($cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Remove product from cart
     */
    public function remove($productId)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        $cartCount = array_sum($cart);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Session::forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared'
        ]);
    }

    /**
     * Get cart count (for AJAX requests)
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $cartCount = array_sum($cart);
        
        return response()->json([
            'count' => $cartCount
        ]);
    }
}
