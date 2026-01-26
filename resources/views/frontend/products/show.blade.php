@extends('frontend.layouts.app')

@section('title', 'Product Details - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <a href="#" class="text-gray-600 hover:text-primary-600">Products</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900">Product Details</span>
            </div>
        </div>
    </nav>

    <!-- Product Detail Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    @php
                        $mainImage = $product->image 
                            ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                            : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800';
                        $productImages = [$mainImage]; // You can add more images later if you have a gallery
                    @endphp
                    
                    <!-- Main Image -->
                    <div class="mb-4">
                        <img id="main-image" src="{{ $mainImage }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-xl border border-gray-200">
                    </div>
                    
                    <!-- Thumbnail Images -->
                    @if(count($productImages) > 1)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($productImages as $index => $image)
                                <button onclick="changeMainImage('{{ $image }}')" class="border-2 border-gray-200 rounded-lg overflow-hidden hover:border-primary-500 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}" class="w-full h-24 object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Product Info -->
                <div>
                    <div class="mb-4">
                        @if($product->brand)
                            <span class="inline-block bg-primary-100 text-primary-600 text-xs font-semibold px-3 py-1 rounded-full mb-2">{{ $product->brand->name }}</span>
                        @endif
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        
                        @if($product->category)
                            <p class="text-gray-600 mb-4">Category: <span class="font-semibold">{{ $product->category->name }}</span></p>
                        @endif
                        
                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex items-center">
                                @for($i = 0; $i < 5; $i++)
                                    <i data-lucide="star" class="w-5 h-5 fill-yellow-400 text-yellow-400"></i>
                                @endfor
                            </div>
                            <span class="text-gray-600">(4.8)</span>
                            <span class="text-gray-400">|</span>
                            <span class="text-gray-600">Reviews</span>
                        </div>
                        
                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-4 mb-2">
                                <span class="text-4xl font-bold text-primary-600">UGX {{ number_format($product->selling_price, 0) }}</span>
                                @php
                                    $margin = $product->cost_price > 0 ? (($product->selling_price - $product->cost_price) / $product->selling_price) * 100 : 0;
                                    $showDiscount = $margin > 20;
                                    $discount = $showDiscount ? round($margin * 0.3) : 0;
                                @endphp
                                @if($showDiscount && $product->cost_price > 0)
                                    @php
                                        $originalPrice = $product->selling_price / (1 - ($discount / 100));
                                    @endphp
                                    <span class="text-2xl text-gray-500 line-through">UGX {{ number_format($originalPrice, 0) }}</span>
                                    <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">-{{ $discount }}%</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600">Inclusive of all taxes</p>
                        </div>
                        
                        <!-- Stock Status -->
                        <div class="mb-6">
                            @if($product->quantity > 0)
                                <div class="flex items-center space-x-2 text-green-600 mb-2">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                    <span class="font-semibold">In Stock ({{ $product->quantity }} available)</span>
                                </div>
                            @else
                                <div class="flex items-center space-x-2 text-red-600 mb-2">
                                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                                    <span class="font-semibold">Out of Stock</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Details -->
                        @if($product->sku)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">SKU: <span class="font-semibold text-gray-900">{{ $product->sku }}</span></p>
                            </div>
                        @endif
                        
                        @if($product->productModel)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Model: <span class="font-semibold text-gray-900">{{ $product->productModel->name }}</span></p>
                            </div>
                        @endif
                        
                        <!-- Quantity and Add to Cart -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Quantity</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border-2 border-gray-300 rounded-lg">
                                    <button onclick="decreaseQuantity()" class="px-4 py-2 text-gray-600 hover:text-primary-600">
                                        <i data-lucide="minus" class="w-5 h-5"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" class="w-16 text-center border-0 focus:ring-0 focus:outline-none">
                                    <button onclick="increaseQuantity()" class="px-4 py-2 text-gray-600 hover:text-primary-600">
                                        <i data-lucide="plus" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mb-8">
                            <button 
                                onclick="addToCart({{ $product->id }})"
                                id="add-to-cart-btn"
                                class="flex-1 bg-primary-500 text-white py-4 rounded-lg font-semibold hover:bg-primary-600 transition-colors flex items-center justify-center">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i>
                                <span id="add-to-cart-text">Add to Cart</span>
                            </button>
                            <button class="flex-1 bg-white border-2 border-primary-500 text-primary-600 py-4 rounded-lg font-semibold hover:bg-primary-50 transition-colors flex items-center justify-center">
                                <i data-lucide="heart" class="w-5 h-5 mr-2"></i>
                                Add to Wishlist
                            </button>
                        </div>
                        
                        <!-- Features -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                                <i data-lucide="truck" class="w-6 h-6 text-primary-600"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">Free Shipping</p>
                                    <p class="text-sm text-gray-600">On orders over UGX 500K</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                                <i data-lucide="rotate-ccw" class="w-6 h-6 text-primary-600"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">Easy Returns</p>
                                    <p class="text-sm text-gray-600">30-day return policy</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                                <i data-lucide="shield-check" class="w-6 h-6 text-primary-600"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">Warranty</p>
                                    <p class="text-sm text-gray-600">1 year manufacturer</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                                <i data-lucide="headphones" class="w-6 h-6 text-primary-600"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">24/7 Support</p>
                                    <p class="text-sm text-gray-600">Always here to help</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Description & Specifications -->
            <div class="mt-16">
                <div class="border-b border-gray-200 mb-8">
                    <nav class="flex space-x-8">
                        <button onclick="showTab('description')" id="tab-description" class="py-4 px-1 border-b-2 border-primary-500 font-semibold text-primary-600">
                            Description
                        </button>
                        <button onclick="showTab('specifications')" id="tab-specifications" class="py-4 px-1 border-b-2 border-transparent font-semibold text-gray-500 hover:text-gray-700">
                            Specifications
                        </button>
                        <button onclick="showTab('reviews')" id="tab-reviews" class="py-4 px-1 border-b-2 border-transparent font-semibold text-gray-500 hover:text-gray-700">
                            Reviews
                        </button>
                    </nav>
                </div>
                
                <!-- Description Tab -->
                <div id="content-description" class="tab-content">
                    <p class="text-gray-700 leading-relaxed mb-6">{{ $product->description ?? 'No description available.' }}</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Key Features</h3>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <i data-lucide="check" class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5"></i>
                                    <span>Advanced A17 Pro chip for exceptional performance</span>
                                </li>
                                <li class="flex items-start">
                                    <i data-lucide="check" class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5"></i>
                                    <span>Professional-grade camera system</span>
                                </li>
                                <li class="flex items-start">
                                    <i data-lucide="check" class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5"></i>
                                    <span>All-day battery life</span>
                                </li>
                                <li class="flex items-start">
                                    <i data-lucide="check" class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5"></i>
                                    <span>Premium titanium design</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">What's in the Box</h3>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <i data-lucide="package" class="w-5 h-5 text-primary-500 mr-2 flex-shrink-0 mt-0.5"></i>
                                    <span>iPhone 15 Pro Max</span>
                                </li>
                                <li class="flex items-start">
                                    <i data-lucide="package" class="w-5 h-5 text-primary-500 mr-2 flex-shrink-0 mt-0.5"></i>
                                    <span>USB-C Charging Cable</span>
                                </li>
                                <li class="flex items-start">
                                    <i data-lucide="package" class="w-5 h-5 text-primary-500 mr-2 flex-shrink-0 mt-0.5"></i>
                                    <span>Documentation</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Specifications Tab -->
                <div id="content-specifications" class="tab-content hidden">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <table class="w-full">
                            <tbody class="divide-y divide-gray-200">
                                @if($product->sku)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">SKU</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $product->sku }}</td>
                                    </tr>
                                @endif
                                @if($product->barcode)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">Barcode</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $product->barcode }}</td>
                                    </tr>
                                @endif
                                @if($product->category)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">Category</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $product->category->name }}</td>
                                    </tr>
                                @endif
                                @if($product->brand)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">Brand</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $product->brand->name }}</td>
                                    </tr>
                                @endif
                                @if($product->productModel)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">Model</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $product->productModel->name }}</td>
                                    </tr>
                                @endif
                                <tr class="hover:bg-white transition-colors">
                                    <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">Price</td>
                                    <td class="py-3 px-4 text-gray-700">UGX {{ number_format($product->selling_price, 2) }}</td>
                                </tr>
                                <tr class="hover:bg-white transition-colors">
                                    <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">Quantity Available</td>
                                    <td class="py-3 px-4 text-gray-700">{{ $product->quantity }}</td>
                                </tr>
                                @if($product->warranty_months)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">Warranty</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $product->warranty_months }} months</td>
                                    </tr>
                                @endif
                                @if($product->serial_number)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="py-3 px-4 font-semibold text-gray-900 w-1/3">Serial Number</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $product->serial_number }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Reviews Tab -->
                <div id="content-reviews" class="tab-content hidden">
                    <div class="space-y-6">
                        @php
                            $reviews = [
                                ['name' => 'John Doe', 'rating' => 5, 'date' => '2024-01-15', 'comment' => 'Excellent phone! The camera quality is outstanding and the battery lasts all day. Highly recommended!'],
                                ['name' => 'Jane Smith', 'rating' => 4, 'date' => '2024-01-10', 'comment' => 'Great device overall. The display is beautiful and the performance is smooth. Only minor issue is the price.'],
                                ['name' => 'Mike Johnson', 'rating' => 5, 'date' => '2024-01-08', 'comment' => 'Best iPhone I\'ve ever owned. The titanium build feels premium and the A17 Pro chip is incredibly fast.'],
                            ];
                        @endphp
                        
                        @foreach($reviews as $review)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $review['name'] }}</h4>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <div class="flex">
                                                @for($i = 0; $i < 5; $i++)
                                                    <i data-lucide="star" class="w-4 h-4 {{ $i < $review['rating'] ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $review['date'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review['comment'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">You May Also Like</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        @foreach($relatedProducts as $related)
                            @php
                                $margin = $related->cost_price > 0 ? (($related->selling_price - $related->cost_price) / $related->selling_price) * 100 : 0;
                                $showDiscount = $margin > 20;
                                $discount = $showDiscount ? round($margin * 0.3) : 0;
                                $imageUrl = $related->image 
                                    ? (str_starts_with($related->image, 'http') ? $related->image : asset('storage/' . $related->image))
                                    : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                            @endphp
                            <a href="{{ route('frontend.products.show', $related->id) }}" class="product-card bg-white rounded-xl overflow-hidden shadow-md block">
                                <div class="relative">
                                    <img src="{{ $imageUrl }}" alt="{{ $related->name }}" class="w-full h-48 object-cover">
                                    @if($discount > 0)
                                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            -{{ $discount }}%
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 text-sm">{{ $related->name }}</h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-lg font-bold text-primary-600">UGX {{ number_format($related->selling_price, 0) }}</span>
                                        @if($showDiscount && $related->cost_price > 0)
                                            @php
                                                $originalPrice = $related->selling_price / (1 - ($discount / 100));
                                            @endphp
                                            <span class="text-sm text-gray-500 line-through">UGX {{ number_format($originalPrice, 0) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function changeMainImage(imageSrc) {
        document.getElementById('main-image').src = imageSrc;
    }
    
    function increaseQuantity() {
        const input = document.getElementById('quantity');
        input.value = parseInt(input.value) + 1;
    }
    
    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active state from all tabs
        document.querySelectorAll('[id^="tab-"]').forEach(tab => {
            tab.classList.remove('border-primary-500', 'text-primary-600');
            tab.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        document.getElementById('content-' + tabName).classList.remove('hidden');
        
        // Add active state to selected tab
        const activeTab = document.getElementById('tab-' + tabName);
        activeTab.classList.add('border-primary-500', 'text-primary-600');
        activeTab.classList.remove('border-transparent', 'text-gray-500');
    }

    function addToCart(productId) {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const btn = document.getElementById('add-to-cart-btn');
        const btnText = document.getElementById('add-to-cart-text');
        
        // Store original state
        const originalText = btnText.textContent;
        const originalClasses = btn.className;
        
        // Disable button and show loading
        btn.disabled = true;
        btnText.textContent = 'Adding...';
        
        fetch(`{{ url('/cart/add') }}/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success toast notification
                showSuccessToast('Product added to cart successfully!');
                
                // Update cart count in header
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
                
                // Reset button to original state
                btnText.textContent = originalText;
                btn.className = originalClasses;
                btn.disabled = false;
            } else {
                showErrorToast(data.message || 'Failed to add product to cart');
                btnText.textContent = originalText;
                btn.className = originalClasses;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorToast('An error occurred. Please try again.');
            btnText.textContent = originalText;
            btn.className = originalClasses;
            btn.disabled = false;
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
</script>
@endsection
