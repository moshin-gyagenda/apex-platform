@extends('frontend.layouts.app')

@section('title', 'Checkout - Apex Electronics & Accessories')

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
            <ol class="flex items-center space-x-2 text-sm">
                <li class="flex items-center text-green-600">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    <span>Billing & Shipping Information</span>
                </li>
                <li class="flex items-center text-gray-400">
                    <i data-lucide="chevron-right" class="w-4 h-4 mx-2"></i>
                    <span>Payment Information</span>
                </li>
                <li class="flex items-center text-gray-400">
                    <i data-lucide="chevron-right" class="w-4 h-4 mx-2"></i>
                    <span>Order Confirmation</span>
                </li>
            </ol>
        </div>
    </nav>

    <!-- Checkout Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('shipping-info.store') }}" method="POST">
                @csrf
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Billing & Shipping Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Billing & Shipping Details</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="other_name" class="block text-sm font-medium text-gray-700 mb-2">Other Name (Optional)</label>
                                    <input type="text" id="other_name" name="other_name" value="{{ old('other_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->mobile_number ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                    <select id="country" name="country" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                        <option value="">Select a country</option>
                                        <option value="Uganda" {{ old('country') == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                        <option value="Kenya" {{ old('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                        <option value="Tanzania" {{ old('country') == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                        <option value="Rwanda" {{ old('country') == 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="region" class="block text-sm font-medium text-gray-700 mb-2">State/Region</label>
                                    <select id="region" name="state_region" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                        <option value="">Select a region</option>
                                        <option value="Central Region" {{ old('state_region') == 'Central Region' ? 'selected' : '' }}>Central Region</option>
                                        <option value="Eastern Region" {{ old('state_region') == 'Eastern Region' ? 'selected' : '' }}>Eastern Region</option>
                                        <option value="Northern Region" {{ old('state_region') == 'Northern Region' ? 'selected' : '' }}>Northern Region</option>
                                        <option value="Western Region" {{ old('state_region') == 'Western Region' ? 'selected' : '' }}>Western Region</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City/Town</label>
                                    <select id="city" name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                        <option value="">Select a city/town</option>
                                        <option value="Kampala" {{ old('city') == 'Kampala' ? 'selected' : '' }}>Kampala</option>
                                        <option value="Entebbe" {{ old('city') == 'Entebbe' ? 'selected' : '' }}>Entebbe</option>
                                        <option value="Jinja" {{ old('city') == 'Jinja' ? 'selected' : '' }}>Jinja</option>
                                        <option value="Masaka" {{ old('city') == 'Masaka' ? 'selected' : '' }}>Masaka</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="street_address" class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                                    <input type="text" id="street_address" name="street_address" value="{{ old('street_address') }}" placeholder="Your Address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="additional_info" class="block text-sm font-medium text-gray-700 mb-2">Additional Information (Optional)</label>
                                    <textarea id="additional_info" name="additional_info" rows="3" placeholder="Order Notes" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('additional_info') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Method -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Delivery Method</h3>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary-500 transition-colors">
                                    <input type="radio" name="delivery_method" value="Door Delivery" class="mr-3 text-primary-500 focus:ring-primary-500" checked>
                                    <div>
                                        <span class="font-medium text-gray-900">Door Delivery</span>
                                        <p class="text-sm text-gray-600">We'll deliver to your doorstep</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary-500 transition-colors">
                                    <input type="radio" name="delivery_method" value="Pick Up" class="mr-3 text-primary-500 focus:ring-primary-500">
                                    <div>
                                        <span class="font-medium text-gray-900">Pick Up</span>
                                        <p class="text-sm text-gray-600">Collect from our store</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>
                            
                            @php
                                $cart = session()->get('cart', []);
                                $cartItems = [];
                                $subtotal = 0;
                                foreach ($cart as $productId => $quantity) {
                                    $product = \App\Models\Product::find($productId);
                                    if ($product) {
                                        $itemSubtotal = $product->selling_price * $quantity;
                                        $subtotal += $itemSubtotal;
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
                                <div class="space-y-4 mb-6">
                                    @foreach ($cartItems as $item)
                                        <div class="flex items-center space-x-4 pb-4 border-b border-gray-200">
                                            @php
                                                $imageUrl = $item['image'] 
                                                    ? (str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image']))
                                                    : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400';
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg">
                                            <div class="flex-1">
                                                <h5 class="font-medium text-gray-900 text-sm">{{ $item['name'] }}</h5>
                                                <p class="text-xs text-gray-600">Qty: {{ $item['quantity'] }}</p>
                                            </div>
                                            <p class="font-semibold text-gray-900">UGX {{ number_format($item['price'] * $item['quantity'], 0) }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="space-y-2 mb-6">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Subtotal</span>
                                        <span>UGX {{ number_format($subtotal, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600">
                                        <span>Tax</span>
                                        <span>UGX {{ number_format($taxes, 0) }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-semibold text-gray-900">Total</span>
                                            <span class="text-xl font-bold text-primary-600">UGX {{ number_format($total, 0) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                                    Proceed to Payment
                                </button>
                            @else
                                <p class="text-gray-600 text-center py-8">Your cart is empty</p>
                                <a href="{{ route('frontend.index') }}" class="block w-full text-center bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                                    Continue Shopping
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
