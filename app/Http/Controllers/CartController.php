<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Normalize cart keys to integers
     * This ensures consistency when session stores keys as strings
     */
    private function normalizeCart(array $cart): array
    {
        $normalizedCart = [];
        foreach ($cart as $key => $value) {
            $normalizedKey = (int) $key;
            // Handle duplicate keys by merging quantities
            if (isset($normalizedCart[$normalizedKey])) {
                $normalizedCart[$normalizedKey] += (int) $value;
            } else {
                $normalizedCart[$normalizedKey] = (int) $value;
            }
        }
        return $normalizedCart;
    }

    /**
     * Display the cart page
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        
        // Normalize cart keys to integers
        $cart = $this->normalizeCart($cart);
        
        $cartItems = [];
        $total = 0;

        $cartProductIds = [];
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->selling_price * $quantity,
                ];
                $total += $product->selling_price * $quantity;
                $cartProductIds[] = $productId;
            }
        }

        // Get recently viewed products from session
        $recentlyViewedIds = $request->session()->get('recently_viewed', []);
        $recentlyViewedProducts = Product::with(['category', 'brand'])
            ->whereIn('id', $recentlyViewedIds)
            ->where('status', 'active')
            ->whereNotIn('id', $cartProductIds) // Exclude items already in cart
            ->limit(8)
            ->get();

        // Get "Customers also bought" - products frequently bought together with cart items
        $customersAlsoBought = collect();
        if (!empty($cartProductIds)) {
            // Find orders that contain any of the cart products
            $orderIds = OrderItem::whereIn('product_id', $cartProductIds)
                ->distinct()
                ->pluck('order_id')
                ->toArray();

            if (!empty($orderIds)) {
                // Get products from those orders that are NOT in the cart
                $alsoBoughtProductIds = OrderItem::whereIn('order_id', $orderIds)
                    ->whereNotIn('product_id', $cartProductIds)
                    ->select('product_id', DB::raw('COUNT(*) as purchase_count'))
                    ->groupBy('product_id')
                    ->orderByDesc('purchase_count')
                    ->limit(8)
                    ->pluck('product_id')
                    ->toArray();

                if (!empty($alsoBoughtProductIds)) {
                    $customersAlsoBought = Product::with(['category', 'brand'])
                        ->whereIn('id', $alsoBoughtProductIds)
                        ->where('status', 'active')
                        ->limit(8)
                        ->get();
                }
            }
        }

        // Get "Customers who viewed this also viewed" - products from same categories as cart items
        $alsoViewedProducts = collect();
        if (!empty($cartProductIds)) {
            // Get categories of products in cart
            $cartCategories = Product::whereIn('id', $cartProductIds)
                ->distinct()
                ->pluck('category_id')
                ->toArray();

            if (!empty($cartCategories)) {
                $alsoViewedProducts = Product::with(['category', 'brand'])
                    ->whereIn('category_id', $cartCategories)
                    ->whereNotIn('id', $cartProductIds) // Exclude items already in cart
                    ->where('status', 'active')
                    ->limit(8)
                    ->get();
            }
        }

        return view('frontend.cart.index', compact(
            'cartItems', 
            'total', 
            'recentlyViewedProducts', 
            'customersAlsoBought', 
            'alsoViewedProducts'
        ));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // Get quantity from request, default to 1
        $quantityToAdd = $request->input('quantity', 1);
        
        $wantsJson = $request->wantsJson() || $request->ajax();

        // Check if product is in stock
        if ($product->quantity <= 0) {
            if ($wantsJson) {
                return response()->json(['success' => false, 'message' => 'Product is out of stock'], 400);
            }
            return redirect()->back()->with('error', 'Product is out of stock');
        }

        $cart = $request->session()->get('cart', []);
        
        // Normalize cart keys to integers
        $cart = $this->normalizeCart($cart);
        
        // Ensure productId is treated as integer for consistency
        $productId = (int) $productId;
        
        // Check if adding this quantity would exceed stock
        $currentQuantity = $cart[$productId] ?? 0;
        if ($currentQuantity + $quantityToAdd > $product->quantity) {
            if ($wantsJson) {
                return response()->json(['success' => false, 'message' => 'Insufficient stock available'], 400);
            }
            return redirect()->back()->with('error', 'Insufficient stock available');
        }
        
        // Add or update quantity
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantityToAdd;
        } else {
            $cart[$productId] = $quantityToAdd;
        }

        // Save the updated cart to session
        $request->session()->put('cart', $cart);
        $request->session()->save();

        $cartCount = array_sum($cart);

        if ($wantsJson) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $cartCount
            ]);
        }

        $redirectTo = $request->input('redirect', route('cart.index'));
        return redirect()->to($redirectTo)->with('success', 'Product added to cart.');
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

        $cart = $request->session()->get('cart', []);
        
        // Normalize cart keys to integers
        $cart = $this->normalizeCart($cart);
        
        // Ensure productId is treated as integer for consistency
        $productId = (int) $productId;
        
        if ($request->quantity == 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $request->quantity;
        }

        // Save the updated cart to session
        $request->session()->put('cart', $cart);
        $request->session()->save();

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
    public function remove(Request $request, $productId)
    {
        // Get cart from session
        $cart = $request->session()->get('cart', []);
        
        // Ensure cart is an array
        if (!is_array($cart)) {
            $cart = [];
        }
        
        // Normalize cart keys to integers
        $cart = $this->normalizeCart($cart);
        
        // Convert productId to integer
        $productId = (int) $productId;
        
        // Remove the item from cart
        $removed = false;
        if (isset($cart[$productId]) && $cart[$productId] > 0) {
            unset($cart[$productId]);
            $removed = true;
            
            // Save the updated cart to session
            $request->session()->put('cart', $cart);
            $request->session()->save();
        }

        $cartCount = array_sum($cart);

        return response()->json([
            'success' => $removed,
            'message' => $removed ? 'Product removed from cart' : 'Product not found in cart',
            'cart_count' => $cartCount,
            'debug' => [
                'productId' => $productId,
                'cartKeys' => array_keys($cart),
                'cartSize' => count($cart)
            ]
        ]);
    }

    /**
     * Clear cart
     */
    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        $request->session()->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared'
        ]);
    }

    /**
     * Get cart count (for AJAX requests)
     */
    public function count(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        
        // Normalize cart keys to integers
        $cart = $this->normalizeCart($cart);
        
        $cartCount = array_sum($cart);
        
        return response()->json([
            'count' => $cartCount
        ]);
    }
}
