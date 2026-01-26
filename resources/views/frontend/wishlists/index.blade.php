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
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900">Wishlist</span>
            </div>
        </div>
    </nav>

    <!-- Wishlist Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">My Wishlist</h1>
                </div>

                @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($wishlistItems as $wishlistItem)
                                    @php
                                        $product = $wishlistItem->product ?? $wishlistItem;
                                        $imageUrl = $product->image 
                                            ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                                            : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <a href="{{ route('frontend.products.show', $product->id) }}" class="flex items-center space-x-4">
                                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded-lg">
                                                    <h5 class="font-medium text-gray-900 hover:text-primary-600 transition-colors">{{ $product->name }}</h5>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-semibold text-primary-600">UGX {{ number_format($product->selling_price ?? $product->price ?? 0, 0) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition-colors">
                                                        <i data-lucide="shopping-cart" class="w-4 h-4 mr-2"></i>
                                                        <span class="hidden sm:inline">Move to Cart</span>
                                                    </button>
                                                </form>
                                                <button onclick="removeFromWishlist({{ $product->id }})" class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition-colors">
                                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                                                    <span class="hidden sm:inline">Remove</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                        <a href="{{ route('frontend.index') }}" class="inline-flex items-center px-6 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                            Return to Shop
                        </a>
                        <button onclick="clearWishlist()" class="inline-flex items-center px-6 py-2 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            Clear Wishlist
                        </button>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <i data-lucide="heart" class="w-24 h-24 mx-auto text-gray-300 mb-6"></i>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Your wishlist is empty</h2>
                        <p class="text-gray-600 mb-8">Looks like you haven't added any items to your wishlist yet.</p>
                        <a href="{{ route('frontend.index') }}" class="inline-flex items-center px-8 py-3 bg-primary-500 text-white rounded-lg font-semibold hover:bg-primary-600 transition-colors">
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
