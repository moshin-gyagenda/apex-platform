@extends('frontend.layouts.app')

@section('title', 'Apex Electronics & Accessories - Quality Electronics Store')

@section('content')
    <!-- Hero Section with Carousel -->
    <section class="relative bg-white overflow-hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 lg:py-6">
            <div class="grid md:grid-cols-3 gap-4">
                <!-- Main Carousel Section -->
                <div id="hero-carousel" class="relative w-full md:col-span-2" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-64 overflow-hidden rounded-lg md:h-96 shadow-lg">
                        @php
                            $bannerImages = [
                                ['url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=1200', 'title' => 'Latest Laptops', 'subtitle' => 'Up to 30% Off'],
                                ['url' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=1200', 'title' => 'New Smartphones', 'subtitle' => 'Premium Quality'],
                                ['url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=1200', 'title' => 'Audio Devices', 'subtitle' => 'Best Sound Experience'],
                                ['url' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=1200', 'title' => 'Tablets & iPads', 'subtitle' => 'Latest Models'],
                            ];
                        @endphp
                        
                        @foreach($bannerImages as $index => $banner)
                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                <div class="absolute inset-0">
                                    <img src="{{ $banner['url'] }}" 
                                         class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" 
                                         alt="{{ $banner['title'] }}">
                                    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
                                    <div class="absolute inset-0 flex items-center px-8">
                                        <div class="text-white">
                                            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2">{{ $banner['title'] }}</h2>
                                            <p class="text-xl md:text-2xl mb-4">{{ $banner['subtitle'] }}</p>
                                            <a href="#products" class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                                                Shop Now
                                                <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3">
                        @foreach($bannerImages as $index => $banner)
                            <button type="button" 
                                    class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" 
                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                    aria-label="Slide {{ $index + 1 }}"
                                    data-carousel-slide-to="{{ $index }}"
                                    data-carousel-target="hero-carousel"></button>
                        @endforeach
                    </div>
                    
                    <!-- Slider controls -->
                    <button type="button"
                            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-prev>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                            <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button"
                            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-next>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                            <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>
                
                <!-- Side Promo Cards -->
                <div class="flex flex-col gap-2 hidden md:flex h-32 md:h-48">
                    <!-- Flash Sales Card -->
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg p-3 text-white shadow-lg hover:shadow-xl transition-all duration-300 flex-[0.8] flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="zap" class="w-4 h-4 text-white"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold">50%</div>
                                <div class="text-xs text-white/80">OFF</div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold mb-0.5">Flash Sales</h3>
                            <p class="text-white/90 text-xs mb-1">Limited time offers!</p>
                            <a href="#flash-sales" class="inline-flex items-center text-xs font-semibold hover:underline group">
                                View All
                                <i data-lucide="arrow-right" class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Free Shipping Card -->
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg p-3 text-white shadow-lg hover:shadow-xl transition-all duration-300 flex-[0.8] flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="truck" class="w-4 h-4 text-white"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold">FREE</div>
                                <div class="text-xs text-white/80">SHIP</div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold mb-0.5">Free Delivery</h3>
                            <p class="text-white/90 text-xs mb-1">Orders over UGX 500K</p>
                            <a href="#products" class="inline-flex items-center text-xs font-semibold hover:underline group">
                                Shop Now
                                <i data-lucide="arrow-right" class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- 24/7 Support Card -->
                    <div class="bg-white rounded-lg p-3  border border-gray-200 hover:shadow-xl transition-all duration-300 flex-[0.8] flex flex-col justify-between">
                        <div class="flex items-start space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="headphones" class="w-4 h-4 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xs font-bold text-gray-900 mb-0.5">24/7 Support</h3>
                                <p class="text-xs text-gray-600">We're here to help</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            <div class="flex items-center space-x-1">
                                <i data-lucide="phone" class="w-3 h-3 text-primary-600"></i>
                                <span class="text-xs text-gray-700 font-medium">+256 700</span>
                            </div>
                            <a href="#" class="text-xs text-primary-600 font-semibold hover:underline group inline-flex items-center">
                                Contact
                                <i data-lucide="arrow-right" class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                        <div>
                           <a href="#products" class="inline-flex items-center text-xs font-semibold hover:underline group">
                                Shop Now
                                <i data-lucide="arrow-right" class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Top Categories</h2>
                <p class="text-gray-600">Browse our wide range of electronics categories</p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @php
                    // Default category images mapping
                    $categoryImages = [
                        'Smartphones' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=400',
                        'Laptops' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400',
                        'Audio' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
                        'Cameras' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=400',
                        'Gaming' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=400',
                        'Wearables' => 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=400',
                    ];
                @endphp
                
                @forelse($categories as $category)
                    @php
                        // Use category image from database if available, otherwise use default mapping
                        if ($category->image) {
                            $categoryImage = str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image);
                        } else {
                            $categoryImage = $categoryImages[$category->name] ?? 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                        }
                    @endphp
                    <a href="{{ route('frontend.index') }}?category={{ $category->id }}" class="group relative bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden" style="border-radius: 10px;">
                        <div class="relative h-40 overflow-hidden">
                            <img src="{{ $categoryImage }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                 style="border-radius: 10px 10px 0 0;">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-white font-semibold text-sm md:text-base px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full">{{ $category->name }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-6 text-center py-8">
                        <p class="text-gray-500">No categories available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Flash Sales Section -->
    <section id="flash-sales" class="py-12 bg-gradient-to-r from-primary-500 to-primary-600">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center">
                        <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white">Flash Sales</h2>
                        <p class="text-white/80 text-sm">Limited time offers - Don't miss out!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 bg-white/20 backdrop-blur-sm rounded-lg px-4 sm:px-6 py-3">
                    <span class="text-white font-semibold text-sm">Ends in:</span>
                    <div class="flex items-center space-x-2">
                        <div class="bg-white/30 rounded px-2 sm:px-3 py-1">
                            <span class="text-white font-bold text-base sm:text-lg" id="hours">00</span>
                            <span class="text-white/80 text-xs">h</span>
                        </div>
                        <span class="text-white">:</span>
                        <div class="bg-white/30 rounded px-2 sm:px-3 py-1">
                            <span class="text-white font-bold text-base sm:text-lg" id="minutes">00</span>
                            <span class="text-white/80 text-xs">m</span>
                        </div>
                        <span class="text-white">:</span>
                        <div class="bg-white/30 rounded px-2 sm:px-3 py-1">
                            <span class="text-white font-bold text-base sm:text-lg" id="seconds">00</span>
                            <span class="text-white/80 text-xs">s</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Carousel Container -->
            <div class="relative">
                <div class="overflow-hidden">
                    <div id="flash-sales-carousel" class="flex space-x-4 overflow-x-auto scrollbar-hide scroll-smooth pb-4" style="scrollbar-width: none; -ms-overflow-style: none;">
                        <div class="flex space-x-4 min-w-max">
                            @forelse($flashProducts as $product)
                                @php
                                    // Calculate discount based on margin (if cost_price is significantly lower than selling_price, show a "sale" badge)
                                    $margin = $product->cost_price > 0 ? (($product->selling_price - $product->cost_price) / $product->selling_price) * 100 : 0;
                                    $showDiscount = $margin > 20; // Show discount badge if margin is good
                                    $discount = $showDiscount ? round($margin * 0.3) : 0; // Show a percentage based on margin
                                    $imageUrl = $product->image 
                                        ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                                        : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                                @endphp
                                <div class="product-card bg-white rounded-xl overflow-hidden shadow-md flex-shrink-0" style="width: 200px;">
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
                                            <span class="text-sm font-bold text-primary-600">UGX {{ number_format($product->selling_price, 0) }}</span>
                                            @if($showDiscount && $product->cost_price > 0)
                                                @php
                                                    $originalPrice = $product->selling_price / (1 - ($discount / 100));
                                                @endphp
                                                <span class="text-xs text-gray-500 line-through">UGX {{ number_format($originalPrice, 0) }}</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-1 mb-2">
                                            @for($i = 0; $i < 5; $i++)
                                                <i data-lucide="star" class="w-3 h-3 fill-yellow-400 text-yellow-400"></i>
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-1">(4.8)</span>
                                        </div>
                                        <button onclick="addToCart({{ $product->id }}, this)" class="w-full bg-primary-500 text-white py-1.5 rounded-lg text-xs font-medium hover:bg-primary-600 transition-colors">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-6 text-center py-8 text-white">
                                    <p>No flash sale products available</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Navigation Buttons -->
                <button onclick="scrollFlashSales('left')" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg z-10 hidden md:block">
                    <i data-lucide="chevron-left" class="w-5 h-5 text-gray-700"></i>
                </button>
                <button onclick="scrollFlashSales('right')" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg z-10 hidden md:block">
                    <i data-lucide="chevron-right" class="w-5 h-5 text-gray-700"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="products" class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Featured Products</h2>
                <p class="text-gray-600">Handpicked selection of our best products</p>
            </div>
            
            <!-- Grid Container - 2 Rows -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                @forelse($featuredProducts as $product)
                    @php
                        $margin = $product->cost_price > 0 ? (($product->selling_price - $product->cost_price) / $product->selling_price) * 100 : 0;
                        $showDiscount = $margin > 20;
                        $discount = $showDiscount ? round($margin * 0.3) : 0;
                        $imageUrl = $product->image 
                            ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                            : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                    @endphp
                    <div class="product-card bg-white rounded-xl overflow-hidden shadow-md border border-gray-200 hover:shadow-lg transition-all duration-300">
                        <a href="{{ route('frontend.products.show', $product->id) }}" class="block relative">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-40 sm:h-48 object-cover">
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
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 text-xs sm:text-sm hover:text-primary-600 transition-colors">{{ $product->name }}</h3>
                            </a>
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="text-sm sm:text-base font-bold text-primary-600">UGX {{ number_format($product->selling_price, 0) }}</span>
                                @if($showDiscount && $product->cost_price > 0)
                                    @php
                                        $originalPrice = $product->selling_price / (1 - ($discount / 100));
                                    @endphp
                                    <span class="text-xs text-gray-500 line-through">UGX {{ number_format($originalPrice, 0) }}</span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-1 mb-3">
                                @for($i = 0; $i < 5; $i++)
                                    <i data-lucide="star" class="w-3 h-3 fill-yellow-400 text-yellow-400"></i>
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">(4.8)</span>
                            </div>
                            <button onclick="addToCart({{ $product->id }}, this)" class="w-full bg-primary-500 text-white py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-primary-600 transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">No featured products available</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-8">
                <a href="#" class="inline-flex items-center px-8 py-3 bg-primary-500 text-white rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                    View All Products
                    <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Why Choose Apex Electronics?</h2>
                <p class="text-gray-600 text-lg">We're committed to providing the best shopping experience</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8">
                @php
                    $features = [
                        ['icon' => 'truck', 'title' => 'Free Shipping', 'description' => 'Free delivery on orders over UGX 500,000'],
                        ['icon' => 'shield-check', 'title' => 'Warranty', 'description' => 'All products come with manufacturer warranty'],
                        ['icon' => 'headphones', 'title' => '24/7 Support', 'description' => 'Round-the-clock customer service'],
                        ['icon' => 'rotate-ccw', 'title' => 'Easy Returns', 'description' => '30-day hassle-free return policy'],
                    ];
                @endphp
                
                @foreach($features as $feature)
                    <div class="text-center p-6 rounded-xl bg-gradient-to-br from-primary-50 to-white border border-primary-100 hover:shadow-lg transition-all">
                        <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="{{ $feature['icon'] }}" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection

@section('scripts')
<script>
    // Countdown timer for flash sales
    function updateCountdown() {
        const now = new Date().getTime();
        const endTime = new Date();
        endTime.setHours(23, 59, 59, 999); // End of today
        
        const distance = endTime - now;
        
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');
        
        if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
        if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
        if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
        
        if (distance < 0) {
            clearInterval(countdownInterval);
        }
    }
    
    const countdownInterval = setInterval(updateCountdown, 1000);
    updateCountdown();
    
    // Carousel scroll functions
    function scrollFlashSales(direction) {
        const carousel = document.getElementById('flash-sales-carousel');
        const scrollAmount = 220; // Width of card + gap
        if (carousel) {
            carousel.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth'
            });
        }
    }
    
    // Add to Cart function
    function addToCart(productId, buttonElement) {
        const btn = buttonElement || event?.target || document.querySelector(`button[onclick*="addToCart(${productId})"]`);
        
        // Store original button state
        let originalText = 'Add to Cart';
        let originalClasses = '';
        if (btn) {
            originalText = btn.textContent.trim();
            originalClasses = btn.className;
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
                // Show success toast notification
                showSuccessToast('Product added to cart successfully!');
                
                // Update cart count in header (without reloading)
                updateCartCount();
                
                // Reset button to original state
                if (btn) {
                    btn.textContent = originalText;
                    btn.className = originalClasses;
                    btn.disabled = false;
                }
            } else {
                showErrorToast(data.message || 'Failed to add product to cart');
                if (btn) {
                    btn.textContent = originalText;
                    btn.className = originalClasses;
                    btn.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorToast('An error occurred. Please try again.');
            if (btn) {
                btn.textContent = originalText;
                btn.className = originalClasses;
                btn.disabled = false;
            }
        });
    }
    
    // Toast notification functions
    function showSuccessToast(message) {
        const toast = document.createElement('div');
        toast.id = 'success-toast';
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
        toast.id = 'error-toast';
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
    
    // Initialize carousel on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flowbite carousel for hero section
        if (typeof Flowbite !== 'undefined') {
            // Carousel is initialized via data attributes
        }
    });
</script>
@endsection
