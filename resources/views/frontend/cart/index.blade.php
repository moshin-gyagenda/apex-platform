@extends('frontend.layouts.app')

@section('title', 'Shopping Cart - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900">Shopping Cart</span>
            </div>
        </div>
    </nav>

    <!-- Cart Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>
            
            @if(count($cartItems) > 0)
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-900">Cart Items ({{ count($cartItems) }})</h2>
                                    <button onclick="clearCart()" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                        Clear Cart
                                    </button>
                                </div>
                            </div>
                            
                            <div class="divide-y divide-gray-200">
                                @foreach($cartItems as $index => $item)
                                    @php
                                        $product = $item['product'];
                                        $quantity = $item['quantity'];
                                        $subtotal = $item['subtotal'];
                                        $imageUrl = $product->image 
                                            ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                                            : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                                    @endphp
                                    <div class="p-6" id="cart-item-{{ $product->id }}">
                                        <div class="flex items-start space-x-4">
                                            <!-- Product Image -->
                                            <a href="{{ route('frontend.products.show', $product->id) }}" class="flex-shrink-0">
                                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                                            </a>
                                            
                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('frontend.products.show', $product->id) }}" class="block">
                                                    <h3 class="text-lg font-semibold text-gray-900 hover:text-primary-600 transition-colors mb-2">{{ $product->name }}</h3>
                                                </a>
                                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>
                                                
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex items-center border-2 border-gray-300 rounded-lg">
                                                        <button onclick="updateQuantity({{ $product->id }}, {{ $quantity - 1 }})" class="px-3 py-1 text-gray-600 hover:text-primary-600">
                                                            <i data-lucide="minus" class="w-4 h-4"></i>
                                                        </button>
                                                        <span class="px-4 py-1 text-gray-900 font-medium" id="quantity-{{ $product->id }}">{{ $quantity }}</span>
                                                        <button onclick="updateQuantity({{ $product->id }}, {{ $quantity + 1 }})" class="px-3 py-1 text-gray-600 hover:text-primary-600">
                                                            <i data-lucide="plus" class="w-4 h-4"></i>
                                                        </button>
                                                    </div>
                                                    
                                                    <!-- Price -->
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-lg font-bold text-primary-600" id="price-{{ $product->id }}">UGX {{ number_format($subtotal, 0) }}</span>
                                                        <span class="text-sm text-gray-500">× {{ $quantity }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Remove Button -->
                                            <button onclick="removeFromCart({{ $product->id }})" class="flex-shrink-0 text-red-600 hover:text-red-700 p-2">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span id="cart-subtotal">UGX {{ number_format($total, 0) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span class="text-green-600 font-medium">Free</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">Total</span>
                                        <span class="text-2xl font-bold text-primary-600" id="cart-total">UGX {{ number_format($total, 0) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <button onclick="proceedToCheckout()" class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors mb-4">
                                Proceed to Checkout
                            </button>
                            
                            <a href="{{ route('frontend.index') }}" class="block w-full text-center text-gray-600 hover:text-primary-600 font-medium">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i data-lucide="shopping-cart" class="w-24 h-24 mx-auto text-gray-300 mb-6"></i>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('frontend.index') }}" class="inline-flex items-center px-8 py-3 bg-primary-500 text-white rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                        <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function updateQuantity(productId, newQuantity) {
        if (newQuantity < 1) {
            removeFromCart(productId);
            return;
        }
        
        fetch(`{{ url('/cart/update') }}/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to update prices
            } else {
                alert(data.message || 'Failed to update quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
    
    function removeFromCart(productId) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }
        
        fetch(`{{ url('/cart/remove') }}/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove item from DOM
                const itemElement = document.getElementById(`cart-item-${productId}`);
                if (itemElement) {
                    itemElement.remove();
                }
                
                // Update cart count in header
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
                
                // Reload if cart is empty
                if (data.cart_count === 0) {
                    location.reload();
                } else {
                    location.reload(); // Reload to update totals
                }
            } else {
                alert(data.message || 'Failed to remove item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
    
    function clearCart() {
        if (!confirm('Are you sure you want to clear your entire cart?')) {
            return;
        }
        
        fetch('{{ route("cart.clear") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to clear cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
    
    function proceedToCheckout() {
        // TODO: Implement checkout functionality
        alert('Checkout functionality will be implemented soon!');
    }
    
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection
