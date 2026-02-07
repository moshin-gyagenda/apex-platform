@extends('frontend.layouts.app')

@section('title', 'Wishlist - Apex Electronics & Accessories')

@section('content')
    @if (session('success'))
        <div class="alert bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative mb-4 flex justify-between items-center mx-auto max-w-7xl" role="alert" id="success-alert">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                {{ session('success') }}
            </div>
            <button type="button" class="text-green-800 hover:text-green-600" aria-label="Close" onclick="document.getElementById('success-alert').remove()">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
    @elseif(session('error'))
        <div class="alert bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded relative mb-4 flex justify-between items-center mx-auto max-w-7xl" role="alert" id="error-alert">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-2"></i>
                {{ session('error') }}
            </div>
            <button type="button" class="text-red-800 hover:text-red-600" aria-label="Close" onclick="document.getElementById('error-alert').remove()">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
    @endif

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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($wishlistItems as $wishlistItem)
                                @php
                                    $product = $wishlistItem->product ?? $wishlistItem;
                                    $imageUrl = $product->image 
                                        ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                                        : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                                @endphp
                                <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                                    <a href="{{ route('frontend.products.show', $product->id) }}" class="block">
                                        <div class="relative">
                                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                            <button onclick="event.preventDefault(); removeFromWishlist({{ $product->id }})" class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-colors shadow-lg">
                                                <i data-lucide="heart" class="w-5 h-5 fill-red-500 text-red-500"></i>
                                            </button>
                                        </div>
                                    </a>
                                    <div class="p-4">
                                        <a href="{{ route('frontend.products.show', $product->id) }}">
                                            <h5 class="font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-primary-600 transition-colors">{{ $product->name }}</h5>
                                        </a>
                                        <div class="mb-4">
                                            <span class="text-lg font-bold text-primary-600">UGX {{ number_format($product->selling_price ?? $product->price ?? 0, 0) }}</span>
                                        </div>
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-medium rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all shadow-md hover:shadow-lg">
                                                    <i data-lucide="shopping-cart" class="w-4 h-4 mr-2"></i>
                                                    Add to Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
    function removeFromWishlist(productId) {
        // Placeholder - implement wishlist removal if you have a wishlist system
        alert('Wishlist functionality will be implemented soon!');
    }
    
    function clearWishlist() {
        // Placeholder - implement wishlist clear if you have a wishlist system
        if (confirm('Are you sure you want to clear your wishlist?')) {
            alert('Wishlist functionality will be implemented soon!');
        }
    }
</script>
@endsection
