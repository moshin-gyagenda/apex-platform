@extends('frontend.layouts.app')

@section('title', $subcategory->name . ' - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gradient-to-r from-gray-50 to-white py-4 border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Category</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900 font-medium">{{ $subcategory->name }}</span>
            </div>
        </div>
    </nav>

    <!-- Main Section -->
    <section class="py-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Title and Results Count -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 mb-8 shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <h2 class="font-bold text-white mb-4 sm:mb-0 -m -fs20 -elli flex items-center gap-3">
                        <i data-lucide="layers" class="w-6 h-6"></i>
                        {{ $subcategory->name }}
                    </h2>

                <div class="flex items-center">
                    <label for="sortBy" class="text-gray-600 mr-2 text-sm">Sort By:</label>
                    <select id="sortBy" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="relevance">Popularity</option>
                        <option value="newest">Newest Arrival</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1">
                @if($subcategory->products && $subcategory->products->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        @foreach ($subcategory->products as $product)
                            @php
                                $imageUrl = $product->image 
                                    ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                                    : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                                $discount = 0;
                                if (isset($product->regular_price) && isset($product->price) && $product->regular_price > $product->price) {
                                    $discount = round((($product->regular_price - $product->price) / $product->regular_price) * 100);
                                }
                            @endphp
                            <div class="product-card bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
                                <a href="{{ route('frontend.products.show', $product->id) }}" class="block relative">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                                    @if($discount > 0)
                                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            -{{ $discount }}%
                                        </span>
                                    @endif
                                    <button class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-colors shadow-md">
                                        <i data-lucide="heart" class="w-4 h-4"></i>
                                    </button>
                                </a>
                                <div class="p-3">
                                    <a href="{{ route('frontend.products.show', $product->id) }}">
                                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 text-xs hover:text-primary-600 transition-colors">{{ $product->name }}</h3>
                                    </a>
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="text-sm font-bold text-primary-600">UGX {{ number_format($product->selling_price ?? $product->price ?? 0, 0) }}</span>
                                        @if($discount > 0 && isset($product->regular_price))
                                            <span class="text-xs text-gray-500 line-through">UGX {{ number_format($product->regular_price, 0) }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-1 mb-3">
                                        @for($i = 0; $i < 5; $i++)
                                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400 text-yellow-400"></i>
                                        @endfor
                                        <span class="text-xs text-gray-500 ml-1">(4.8)</span>
                                    </div>
                                    <button onclick="addToCart({{ $product->id }}, this)" class="w-full bg-primary-500 text-white py-2 rounded-lg text-xs font-medium hover:bg-primary-600 transition-colors">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-12 text-center">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center border-2 border-gray-200">
                            <i data-lucide="package" class="w-12 h-12 text-gray-400"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 -m -fs20 -elli">No products found</h3>
                        <p class="text-gray-600 mb-6">This sub-category doesn't have any products yet.</p>
                        <a href="{{ route('frontend.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg hover:shadow-xl">
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
    function addToCart(productId, buttonElement) {
        const btn = buttonElement || event?.target || document.querySelector(`button[onclick*="addToCart(${productId})"]`);
        
        let originalText = 'Add to Cart';
        if (btn) {
            originalText = btn.textContent.trim();
            btn.disabled = true;
            btn.textContent = 'Adding...';
        }
        
        fetch(`{{ url('/cart/add') }}/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof showSuccessToast === 'function') {
                    showSuccessToast('Product added to cart successfully!');
                }
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
                if (btn) {
                    btn.textContent = originalText;
                    btn.disabled = false;
                }
            } else {
                if (typeof showErrorToast === 'function') {
                    showErrorToast(data.message || 'Failed to add product to cart');
                }
                if (btn) {
                    btn.textContent = originalText;
                    btn.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showErrorToast === 'function') {
                showErrorToast('An error occurred. Please try again.');
            }
            if (btn) {
                btn.textContent = originalText;
                btn.disabled = false;
            }
        });
    }
</script>
@endsection
