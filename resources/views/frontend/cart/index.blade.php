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
                                    <button onclick="showClearCartModal()" class="text-sm text-red-600 hover:text-red-700 font-medium">
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
                                            <button onclick="showRemoveItemModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="flex-shrink-0 text-red-600 hover:text-red-700 p-2">
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
                            
                            @auth
                                <a href="{{ route('frontend.checkouts.index') }}" class="block w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors mb-4 text-center">
                                    Proceed to Checkout
                                </a>
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('frontend.checkouts.index')) }}" class="block w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors mb-4 text-center">
                                    Login to Checkout
                                </a>
                            @endauth
                            
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

    <!-- Confirmation Modal for Remove Item -->
    <div id="remove-item-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg border border-gray-300 shadow-xl p-6 max-w-md w-full mx-4">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Remove Item</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to remove <span id="remove-product-name" class="font-medium text-gray-800"></span> from your cart?
                    </p>
                    <div class="mt-4 flex gap-3">
                        <button id="confirm-remove-item" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
                            Yes, Remove
                        </button>
                        <button onclick="closeRemoveItemModal()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for Clear Cart -->
    <div id="clear-cart-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg border border-gray-300 shadow-xl p-6 max-w-md w-full mx-4">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Clear Cart</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to clear your entire cart? This action cannot be undone and all items will be removed.
                    </p>
                    <div class="mt-4 flex gap-3">
                        <button id="confirm-clear-cart" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
                            Yes, Clear Cart
                        </button>
                        <button onclick="closeClearCartModal()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Toast notification functions
    function showSuccessToast(message) {
        const toast = document.createElement('div');
        toast.id = 'success-toast-' + Date.now();
        toast.className = 'fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-fade-in-up';
        toast.innerHTML = `
            <i data-lucide="check-circle" class="w-6 h-6 flex-shrink-0"></i>
            <span class="font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        `;
        document.body.appendChild(toast);
        
        // Initialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    }
    
    function showErrorToast(message) {
        const toast = document.createElement('div');
        toast.id = 'error-toast-' + Date.now();
        toast.className = 'fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-fade-in-up';
        toast.innerHTML = `
            <i data-lucide="alert-circle" class="w-6 h-6 flex-shrink-0"></i>
            <span class="font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        `;
        document.body.appendChild(toast);
        
        // Initialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 400);
            }
        }, 4000);
    }

    // Modal functions
    let currentProductIdToRemove = null;

    function showRemoveItemModal(productId, productName) {
        currentProductIdToRemove = productId;
        document.getElementById('remove-product-name').textContent = productName;
        document.getElementById('remove-item-modal').classList.remove('hidden');
    }

    function closeRemoveItemModal() {
        document.getElementById('remove-item-modal').classList.add('hidden');
        currentProductIdToRemove = null;
    }

    function showClearCartModal() {
        document.getElementById('clear-cart-modal').classList.remove('hidden');
    }

    function closeClearCartModal() {
        document.getElementById('clear-cart-modal').classList.add('hidden');
    }

    // Cart operations
    function updateQuantity(productId, newQuantity) {
        if (newQuantity < 1) {
            // Get product name for modal
            const productName = document.querySelector(`#cart-item-${productId} h3`).textContent.trim();
            showRemoveItemModal(productId, productName);
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
                showSuccessToast('Cart updated successfully!');
                // Reload to update prices and totals
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                showErrorToast(data.message || 'Failed to update quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorToast('An error occurred. Please try again.');
        });
    }
    
    function removeFromCart(productId) {
        console.log('Removing product from cart:', productId, 'Type:', typeof productId);
        
        fetch(`{{ url('/cart/remove') }}/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Remove response:', data);
            if (data.success) {
                showSuccessToast('Item removed from cart');
                
                // Remove item from DOM
                const itemElement = document.getElementById(`cart-item-${productId}`);
                if (itemElement) {
                    itemElement.style.transition = 'opacity 0.3s';
                    itemElement.style.opacity = '0';
                    setTimeout(() => {
                        itemElement.remove();
                    }, 300);
                }
                
                // Update cart count in header
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
                
                // Reload if cart is empty, otherwise update totals
                if (data.cart_count === 0) {
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    // Update totals without reload
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            } else {
                console.error('Remove failed:', data);
                showErrorToast(data.message || 'Failed to remove item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorToast('An error occurred. Please try again.');
        });
    }
    
    function clearCart() {
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
                showSuccessToast('Cart cleared successfully!');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showErrorToast(data.message || 'Failed to clear cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorToast('An error occurred. Please try again.');
        });
    }
    
    function proceedToCheckout() {
        @auth
            window.location.href = '{{ route("frontend.checkouts.index") }}';
        @else
            window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent('{{ route("frontend.checkouts.index") }}');
        @endauth
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Confirm remove item
        document.getElementById('confirm-remove-item').addEventListener('click', function() {
            if (currentProductIdToRemove) {
                // Store the productId before closing the modal (which resets it to null)
                const productIdToRemove = currentProductIdToRemove;
                closeRemoveItemModal();
                removeFromCart(productIdToRemove);
            }
        });

        // Confirm clear cart
        document.getElementById('confirm-clear-cart').addEventListener('click', function() {
            closeClearCartModal();
            clearCart();
        });

        // Close modals when clicking outside
        document.getElementById('remove-item-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRemoveItemModal();
            }
        });

        document.getElementById('clear-cart-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeClearCartModal();
            }
        });
    });
</script>
@endsection
