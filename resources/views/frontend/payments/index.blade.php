@extends('frontend.layouts.app')

@section('title', 'Payment - Apex Electronics & Accessories')

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
                <li class="flex items-center text-green-600">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    <span>Payment Information</span>
                </li>
                <li class="flex items-center text-gray-400">
                    <i data-lucide="chevron-right" class="w-4 h-4 mx-2"></i>
                    <span>Order Confirmation</span>
                </li>
            </ol>
        </div>
    </nav>

    <!-- Payment Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Payment Options -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Select a Payment Option</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <!-- Cash on Delivery -->
                                <label class="payment-option border-2 border-gray-200 rounded-lg p-4 text-center cursor-pointer hover:border-primary-500 transition-colors" id="cash-label">
                                    <input type="radio" name="payment_method" value="cash on delivery" id="cash" class="hidden" checked>
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-16 bg-gray-100 rounded-lg mb-3 flex items-center justify-center">
                                            <i data-lucide="dollar-sign" class="w-8 h-8 text-gray-600"></i>
                                        </div>
                                        <h5 class="font-medium text-gray-900">Cash on Delivery</h5>
                                    </div>
                                </label>

                                <!-- Airtel Money -->
                                <label class="payment-option border-2 border-gray-200 rounded-lg p-4 text-center cursor-pointer hover:border-primary-500 transition-colors" id="airtel-label">
                                    <input type="radio" value="airtel money" name="payment_method" id="airtel_money" class="hidden">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-16 bg-red-100 rounded-lg mb-3 flex items-center justify-center">
                                            <i data-lucide="smartphone" class="w-8 h-8 text-red-600"></i>
                                        </div>
                                        <h5 class="font-medium text-gray-900">Airtel Money</h5>
                                    </div>
                                </label>

                                <!-- MTN Mobile Money -->
                                <label class="payment-option border-2 border-gray-200 rounded-lg p-4 text-center cursor-pointer hover:border-primary-500 transition-colors" id="mtn-label">
                                    <input type="radio" value="mtn mobile money" name="payment_method" id="mtn_money" class="hidden">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-16 bg-yellow-100 rounded-lg mb-3 flex items-center justify-center">
                                            <i data-lucide="smartphone" class="w-8 h-8 text-yellow-600"></i>
                                        </div>
                                        <h5 class="font-medium text-gray-900">MTN Mobile Money</h5>
                                    </div>
                                </label>
                            </div>

                            <!-- Airtel Money Details -->
                            <div class="payment-details hidden bg-gray-50 rounded-lg p-4 mb-4" id="airtel-details">
                                <p class="text-sm text-gray-700 mb-3">Use the information below to pay via Airtel Money:</p>
                                <ul class="list-disc list-inside text-sm text-gray-600 mb-4 space-y-1">
                                    <li><strong>Phone Number:</strong> 0701861283</li>
                                    <li><strong>Account Name:</strong> Apex Electronics</li>
                                </ul>
                                <div class="space-y-3">
                                    <div>
                                        <label for="transaction_id_airtel" class="block text-sm font-medium text-gray-700 mb-1">Transaction ID</label>
                                        <input type="text" name="transaction_id" id="transaction_id_airtel" placeholder="Enter Airtel transaction ID" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="transaction_photo_airtel" class="block text-sm font-medium text-gray-700 mb-1">Upload Photo</label>
                                        <input type="file" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" name="transaction_photo" id="transaction_photo_airtel" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <!-- MTN Mobile Money Details -->
                            <div class="payment-details hidden bg-gray-50 rounded-lg p-4 mb-4" id="mtn-details">
                                <p class="text-sm text-gray-700 mb-3">Use the information below to pay via MTN Mobile Money:</p>
                                <ul class="list-disc list-inside text-sm text-gray-600 mb-4 space-y-1">
                                    <li><strong>Phone Number:</strong> 0778777809</li>
                                    <li><strong>Account Name:</strong> Apex Electronics</li>
                                </ul>
                                <div class="space-y-3">
                                    <div>
                                        <label for="transaction_id_mtn" class="block text-sm font-medium text-gray-700 mb-1">Transaction ID</label>
                                        <input type="text" id="transaction_id_mtn" name="transaction_id" placeholder="Enter MTN transaction ID" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="transaction_photo_mtn" class="block text-sm font-medium text-gray-700 mb-1">Upload Photo</label>
                                        <input type="file" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" id="transaction_photo_mtn" name="transaction_photo" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <!-- Agreement Terms -->
                            <div class="mt-6">
                                <label class="flex items-start">
                                    <input type="checkbox" id="agree_terms" required class="mt-1 mr-3 text-primary-500 focus:ring-primary-500">
                                    <span class="text-sm text-gray-700">I agree to the <a href="#" class="text-primary-600 hover:underline">terms and conditions</a>, <a href="#" class="text-primary-600 hover:underline">return policy</a> & <a href="#" class="text-primary-600 hover:underline">privacy policy</a></span>
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
                                $subtotal = 0;
                                foreach ($cart as $productId => $quantity) {
                                    $product = \App\Models\Product::find($productId);
                                    if ($product) {
                                        $subtotal += $product->selling_price * $quantity;
                                    }
                                }
                                $taxes = 0;
                                $total = $subtotal + $taxes;
                            @endphp
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
                                Confirm Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection handlers
        const cashRadio = document.getElementById('cash');
        const airtelRadio = document.getElementById('airtel_money');
        const mtnRadio = document.getElementById('mtn_money');
        
        const airtelDetails = document.getElementById('airtel-details');
        const mtnDetails = document.getElementById('mtn-details');
        
        const airtelLabel = document.getElementById('airtel-label');
        const mtnLabel = document.getElementById('mtn-label');
        const cashLabel = document.getElementById('cash-label');

        function updatePaymentUI() {
            // Reset all labels
            [cashLabel, airtelLabel, mtnLabel].forEach(label => {
                label.classList.remove('border-primary-500', 'bg-primary-50');
                label.classList.add('border-gray-200');
            });
            
            // Hide all details
            airtelDetails.classList.add('hidden');
            mtnDetails.classList.add('hidden');
            
            // Show selected payment details
            if (airtelRadio.checked) {
                airtelLabel.classList.remove('border-gray-200');
                airtelLabel.classList.add('border-primary-500', 'bg-primary-50');
                airtelDetails.classList.remove('hidden');
            } else if (mtnRadio.checked) {
                mtnLabel.classList.remove('border-gray-200');
                mtnLabel.classList.add('border-primary-500', 'bg-primary-50');
                mtnDetails.classList.remove('hidden');
            } else if (cashRadio.checked) {
                cashLabel.classList.remove('border-gray-200');
                cashLabel.classList.add('border-primary-500', 'bg-primary-50');
            }
        }

        cashRadio.addEventListener('change', updatePaymentUI);
        airtelRadio.addEventListener('change', updatePaymentUI);
        mtnRadio.addEventListener('change', updatePaymentUI);
        
        // Label click handlers
        cashLabel.addEventListener('click', function() {
            cashRadio.checked = true;
            updatePaymentUI();
        });
        
        airtelLabel.addEventListener('click', function() {
            airtelRadio.checked = true;
            updatePaymentUI();
        });
        
        mtnLabel.addEventListener('click', function() {
            mtnRadio.checked = true;
            updatePaymentUI();
        });
        
        // Initial update
        updatePaymentUI();
    });
</script>
@endsection
