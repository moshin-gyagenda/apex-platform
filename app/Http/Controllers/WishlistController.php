<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Add a product to the authenticated user's wishlist.
     */
    public function add(int $productId)
    {
        $product = Product::where('status', 'active')->find($productId);
        if (!$product) {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
            }
            return back()->with('error', 'Product not found.');
        }

        Wishlist::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $productId],
            ['user_id' => auth()->id(), 'product_id' => $productId]
        );

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Added to wishlist.']);
        }
        return back()->with('success', 'Added to wishlist.');
    }

    /**
     * Remove a product from the authenticated user's wishlist.
     */
    public function remove(int $productId)
    {
        $deleted = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Removed from wishlist.', 'removed' => $deleted > 0]);
        }
        return back()->with('success', 'Removed from wishlist.');
    }

    /**
     * Clear all items from the authenticated user's wishlist.
     */
    public function clear()
    {
        Wishlist::where('user_id', auth()->id())->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Wishlist cleared.']);
        }
        return redirect()->route('frontend.wishlists.index')->with('success', 'Wishlist cleared.');
    }
}
