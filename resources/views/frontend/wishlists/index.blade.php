@extends('frontend.layouts.app')

@section('title', 'Wishlist - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gradient-to-r from-gray-50 to-white py-4 border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900 font-medium">Wishlist</span>
            </div>
        </div>
    </nav>

    <!-- Wishlist Section -->
    <section class="py-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-6">
                    <h1 class="font-bold text-white -m -fs20 -elli flex items-center gap-3">
                        <i data-lucide="heart" class="w-6 h-6"></i>
                        My Wishlist
                    </h1>
                </div>

                @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6" id="wishlist-grid">
                            @foreach ($wishlistItems as $wishlistItem)
                                @php
                                    $product = $wishlistItem->product;
                                    $imageUrl = $product && $product->image
                                        ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                                        : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                                @endphp
                                @if($product)
                                <div class="wishlist-card bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden" data-product-id="{{ $product->id }}">
                                    <a href="{{ route('frontend.products.show', $product->id) }}" class="block">
                                        <div class="relative">
                                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                            <button type="button" onclick="event.preventDefault(); removeFromWishlist({{ $product->id }}, this)" class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-colors shadow-lg">
                                                <i data-lucide="heart" class="w-5 h-5 fill-red-500 text-red-500"></i>
                                            </button>
                                        </div>
                                    </a>
                                    <div class="p-4">
                                        <a href="{{ route('frontend.products.show', $product->id) }}">
                                            <h5 class="font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-primary-600 transition-colors">{{ $product->name }}</h5>
                                        </a>
                                        <div class="mb-4">
                                            <span class="text-lg font-bold text-primary-600">UGX {{ number_format($product->selling_price ?? 0, 0) }}</span>
                                        </div>
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="redirect" value="{{ route('frontend.wishlists.index') }}">
                                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-medium rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all shadow-md hover:shadow-lg">
                                                    <i data-lucide="shopping-cart" class="w-4 h-4 mr-2"></i>
                                                    Add to Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-6 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                        <a href="{{ route('frontend.index') }}" class="inline-flex items-center px-6 py-2.5 border-2 border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors font-medium">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                            Return to Shop
                        </a>
                        <button onclick="clearWishlist()" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-medium hover:from-red-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            Clear Wishlist
                        </button>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-red-100 to-red-50 flex items-center justify-center border-2 border-red-200">
                            <i data-lucide="heart" class="w-12 h-12 text-red-400"></i>
                        </div>
                        <h2 class="font-bold text-gray-900 mb-4 -m -fs20 -elli">Your wishlist is empty</h2>
                        <p class="text-gray-600 mb-8">Looks like you haven't added any items to your wishlist yet.</p>
                        <a href="{{ route('frontend.index') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg hover:shadow-xl">
                            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function removeFromWishlist(productId, buttonEl) {
        const card = buttonEl && buttonEl.closest('.wishlist-card');
        fetch('{{ url('/frontend/wishlist/remove') }}/' + productId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && card) card.remove();
            if (document.querySelectorAll('.wishlist-card').length === 0) location.reload();
        })
        .catch(function() {
            if (typeof showAlertModal === 'function') {
                showAlertModal({ title: 'Error', message: 'Could not remove item. Please try again.', type: 'error' });
            } else {
                alert('Could not remove item.');
            }
        });
    }

    function clearWishlist() {
        if (typeof showConfirmModal !== 'function') {
            if (!confirm('Are you sure you want to clear your wishlist?')) return;
            doClearWishlist();
            return;
        }
        showConfirmModal({
            title: 'Clear wishlist',
            message: 'Are you sure you want to clear your wishlist? This cannot be undone.',
            confirmText: 'Yes, clear all',
            cancelText: 'Cancel',
            danger: true,
            onConfirm: doClearWishlist
        });
    }

    function doClearWishlist() {
        fetch('{{ route('frontend.wishlists.clear') }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(function(data) { if (data.success) location.reload(); })
        .catch(function() { location.reload(); });
    }
</script>
@endsection
