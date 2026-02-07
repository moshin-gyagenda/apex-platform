@extends('frontend.layouts.app')

@section('title', 'Checkout - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li class="flex items-center text-green-600">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    <span>Billing & Shipping</span>
                </li>
                <li class="flex items-center text-gray-400">
                    <i data-lucide="chevron-right" class="w-4 h-4 mx-2"></i>
                    <span>Payment</span>
                </li>
                <li class="flex items-center text-gray-400">
                    <i data-lucide="chevron-right" class="w-4 h-4 mx-2"></i>
                    <span>Confirmation</span>
                </li>
            </ol>
        </div>
    </nav>

    <!-- Checkout Section -->
    <section class="py-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="font-bold text-gray-900 mb-2 text-3xl -m -fs20 -elli">Billing & Shipping Information</h1>
                    <p class="text-base text-gray-600 mt-1">Please provide your delivery details to continue</p>
                </div>

                <form action="{{ route('shipping-info.store') }}" method="POST">
                    @csrf
                    <div class="grid lg:grid-cols-3 gap-8">
                        <!-- Billing & Shipping Details -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Personal Information -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                                    <h3 class="font-bold text-white text-xl -m -fs20 -elli flex items-center gap-2">
                                        <i data-lucide="user" class="w-6 h-6"></i>
                                        Personal Information
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="first_name" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="user" class="w-4 h-4 text-primary-600"></i>
                                                First Name
                                            </label>
                                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition" required>
                                        </div>
                                        <div>
                                            <label for="last_name" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="user" class="w-4 h-4 text-primary-600"></i>
                                                Last Name
                                            </label>
                                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label for="other_name" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="user-plus" class="w-4 h-4 text-gray-400"></i>
                                                Other Name <span class="text-xs text-gray-500 font-normal">(Optional)</span>
                                            </label>
                                            <input type="text" id="other_name" name="other_name" value="{{ old('other_name') }}" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="mail" class="w-4 h-4 text-primary-600"></i>
                                                Email Address
                                            </label>
                                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition" required>
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="phone" class="w-4 h-4 text-primary-600"></i>
                                                Phone Number
                                            </label>
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->mobile_number ?? '') }}" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                                    <h3 class="font-bold text-white text-xl -m -fs20 -elli flex items-center gap-2">
                                        <i data-lucide="map-pin" class="w-6 h-6"></i>
                                        Shipping Address
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="country" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="globe" class="w-4 h-4 text-primary-600"></i>
                                                Country
                                            </label>
                                            <select id="country" name="country" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition bg-white" required>
                                                <option value="">Select a country</option>
                                                <option value="Uganda" {{ old('country') == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                                <option value="Kenya" {{ old('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                                <option value="Tanzania" {{ old('country') == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                                <option value="Rwanda" {{ old('country') == 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="region" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="map" class="w-4 h-4 text-primary-600"></i>
                                                State/Region
                                            </label>
                                            <select id="region" name="state_region" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition bg-white" required>
                                                <option value="">Select a region</option>
                                                <option value="Central Region" {{ old('state_region') == 'Central Region' ? 'selected' : '' }}>Central Region</option>
                                                <option value="Eastern Region" {{ old('state_region') == 'Eastern Region' ? 'selected' : '' }}>Eastern Region</option>
                                                <option value="Northern Region" {{ old('state_region') == 'Northern Region' ? 'selected' : '' }}>Northern Region</option>
                                                <option value="Western Region" {{ old('state_region') == 'Western Region' ? 'selected' : '' }}>Western Region</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="city" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="building" class="w-4 h-4 text-primary-600"></i>
                                                City/Town
                                            </label>
                                            <select id="city" name="city" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition bg-white" required>
                                                <option value="">Select a city/town</option>
                                                <option value="Kampala" {{ old('city') == 'Kampala' ? 'selected' : '' }}>Kampala</option>
                                                <option value="Entebbe" {{ old('city') == 'Entebbe' ? 'selected' : '' }}>Entebbe</option>
                                                <option value="Jinja" {{ old('city') == 'Jinja' ? 'selected' : '' }}>Jinja</option>
                                                <option value="Masaka" {{ old('city') == 'Masaka' ? 'selected' : '' }}>Masaka</option>
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label for="street_address" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="home" class="w-4 h-4 text-primary-600"></i>
                                                Street Address
                                            </label>
                                            <input type="text" id="street_address" name="street_address" value="{{ old('street_address') }}" placeholder="Enter your complete address" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label for="additional_info" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i>
                                                Additional Information <span class="text-xs text-gray-500 font-normal">(Optional)</span>
                                            </label>
                                            <textarea id="additional_info" name="additional_info" rows="3" placeholder="Delivery instructions, landmarks, or special notes..." class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition resize-none">{{ old('additional_info') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Method -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                                    <h3 class="font-bold text-white text-xl -m -fs20 -elli flex items-center gap-2">
                                        <i data-lucide="truck" class="w-6 h-6"></i>
                                        Delivery Method
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <label class="delivery-option group relative border-2 border-gray-200 rounded-xl p-5 cursor-pointer hover:border-primary-500 hover:shadow-md transition-all duration-300 bg-white">
                                            <input type="radio" name="delivery_method" value="Door Delivery" class="hidden" checked>
                                            <div class="flex items-start gap-4">
                                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-green-200 transition-colors">
                                                    <i data-lucide="truck" class="w-6 h-6 text-green-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="font-semibold text-gray-900 mb-1">Door Delivery</h5>
                                                    <p class="text-sm text-gray-600">We'll deliver to your doorstep</p>
                                                </div>
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 group-hover:border-primary-500 transition-colors flex items-center justify-center">
                                                    <div class="w-3 h-3 rounded-full bg-primary-500 hidden delivery-check"></div>
                                                </div>
                                            </div>
                                        </label>
                                        <label class="delivery-option group relative border-2 border-gray-200 rounded-xl p-5 cursor-pointer hover:border-primary-500 hover:shadow-md transition-all duration-300 bg-white">
                                            <input type="radio" name="delivery_method" value="Pick Up" class="hidden">
                                            <div class="flex items-start gap-4">
                                                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary-200 transition-colors">
                                                    <i data-lucide="store" class="w-6 h-6 text-primary-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="font-semibold text-gray-900 mb-1">Pick Up</h5>
                                                    <p class="text-sm text-gray-600">Collect from our store</p>
                                                </div>
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 group-hover:border-primary-500 transition-colors flex items-center justify-center">
                                                    <div class="w-3 h-3 rounded-full bg-primary-500 hidden delivery-check"></div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden sticky top-24">
                                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                                    <h3 class="font-bold text-white text-lg -m -fs20 -elli flex items-center gap-2">
                                        <i data-lucide="receipt" class="w-5 h-5"></i>
                                        Order Summary
                                    </h3>
                                </div>
                                
                                <div class="p-6">
                                    @php
                                        $cart = session()->get('cart', []);
                                        $cartItems = [];
                                        $subtotal = 0;
                                        $itemCount = 0;
                                        foreach ($cart as $productId => $quantity) {
                                            $product = \App\Models\Product::find($productId);
                                            if ($product) {
                                                $itemSubtotal = ($product->selling_price ?? 0) * $quantity;
                                                $subtotal += $itemSubtotal;
                                                $itemCount += $quantity;
                                                $cartItems[] = [
                                                    'id' => $product->id,
                                                    'name' => $product->name,
                                                    'price' => $product->selling_price,
                                                    'quantity' => $quantity,
                                                    'image' => $product->image,
                                                ];
                                            }
                                        }
                                        $taxes = 0;
                                        $total = $subtotal + $taxes;
                                    @endphp
                                    @if(count($cartItems) > 0)
                                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                                            @foreach ($cartItems as $item)
                                                <div class="flex items-center gap-3 pb-3 border-b border-gray-100 last:border-0">
                                                    @php
                                                        $imageUrl = $item['image'] 
                                                            ? (str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image']))
                                                            : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                                                    @endphp
                                                    <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200 flex-shrink-0">
                                                    <div class="flex-1 min-w-0">
                                                        <h5 class="font-medium text-gray-900 text-sm line-clamp-1">{{ $item['name'] }}</h5>
                                                        <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }} × UGX {{ number_format($item['price'] ?? 0, 0) }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="space-y-3 mb-6 pt-4 border-t-2 border-gray-200">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Items ({{ $itemCount }})</span>
                                                <span class="font-medium text-gray-900">UGX {{ number_format($subtotal, 0) }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Shipping</span>
                                                <span class="text-green-600 font-semibold">Free</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Tax</span>
                                                <span class="font-medium text-gray-900">UGX {{ number_format($taxes, 0) }}</span>
                                            </div>
                                            <div class="border-t-2 border-gray-200 pt-3 mt-2">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                                    <span class="text-2xl font-bold text-primary-600">UGX {{ number_format($total, 0) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-4 rounded-xl font-bold text-base hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                            <span>Proceed to Payment</span>
                                        </button>
                                    @else
                                        <div class="text-center py-8">
                                            <i data-lucide="shopping-cart" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                            <p class="text-gray-600 mb-4">Your cart is empty</p>
                                            <a href="{{ route('frontend.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 text-white rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                                                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                                                Continue Shopping
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Delivery method selection handlers
        const deliveryOptions = document.querySelectorAll('.delivery-option');
        
        deliveryOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Reset all options
                deliveryOptions.forEach(opt => {
                    opt.classList.remove('border-primary-500', 'bg-primary-50', 'shadow-md');
                    opt.classList.add('border-gray-200');
                    const check = opt.querySelector('.delivery-check');
                    if (check) check.classList.add('hidden');
                });
                
                // Update selected option
                this.classList.remove('border-gray-200');
                this.classList.add('border-primary-500', 'bg-primary-50', 'shadow-md');
                const radio = this.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
                const check = this.querySelector('.delivery-check');
                if (check) check.classList.remove('hidden');
            });
        });

        // Set initial state
        const defaultOption = document.querySelector('.delivery-option input[checked]');
        if (defaultOption) {
            defaultOption.closest('.delivery-option').click();
        }
    });
</script>
@endsection
