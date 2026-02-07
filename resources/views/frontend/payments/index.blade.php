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
                    <span>Billing & Shipping</span>
                </li>
                <li class="flex items-center text-green-600">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    <span>Payment</span>
                </li>
                <li class="flex items-center text-gray-400">
                    <i data-lucide="chevron-right" class="w-4 h-4 mx-2"></i>
                    <span>Confirmation</span>
                </li>
            </ol>
        </div>
    </nav>

    <!-- Payment Section -->
    <section class="py-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="font-bold text-gray-900 mb-2 text-3xl -m -fs20 -elli">Complete Your Payment</h1>
                    <p class="text-base text-gray-600 mt-1">Choose your preferred payment method to proceed</p>
                </div>

                <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid lg:grid-cols-3 gap-8">
                        <!-- Payment Options -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                                <!-- Header -->
                                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                                    <h2 class="font-bold text-white text-xl -m -fs20 -elli flex items-center gap-2">
                                        <i data-lucide="credit-card" class="w-6 h-6"></i>
                                        Payment Method
                                    </h2>
                                </div>

                                <div class="p-6">
                                    <!-- Payment Options Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                                        <!-- Cash on Delivery -->
                                        <label class="payment-option group relative border-2 border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-primary-500 hover:shadow-lg transition-all duration-300 bg-white" id="cash-label">
                                            <input type="radio" name="payment_method" value="cash on delivery" id="cash" class="hidden" checked>
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gradient-to-br from-green-50 to-green-100 rounded-xl mb-4 flex items-center justify-center group-hover:from-green-100 group-hover:to-green-200 transition-all duration-300 shadow-sm">
                                                    <i data-lucide="truck" class="w-10 h-10 text-green-600"></i>
                                                </div>
                                                <h5 class="font-semibold text-gray-900 mb-1">Cash on Delivery</h5>
                                                <p class="text-xs text-gray-500">Pay when delivered</p>
                                                <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 group-hover:border-primary-500 transition-colors flex items-center justify-center">
                                                    <div class="w-3 h-3 rounded-full bg-primary-500 hidden payment-check"></div>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- Airtel Money -->
                                        <label class="payment-option group relative border-2 border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-red-500 hover:shadow-lg transition-all duration-300 bg-white" id="airtel-label">
                                            <input type="radio" value="airtel money" name="payment_method" id="airtel_money" class="hidden">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-white rounded-xl mb-4 flex items-center justify-center p-2 group-hover:bg-red-50 transition-all duration-300 shadow-sm border border-gray-100">
                                                    <img src="{{ asset('assets/images/airtellogowide-new.png') }}" alt="Airtel Money" class="w-full h-full object-contain">
                                                </div>
                                                <h5 class="font-semibold text-gray-900 mb-1">Airtel Money</h5>
                                                <p class="text-xs text-gray-500">Mobile payment</p>
                                                <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 group-hover:border-red-500 transition-colors flex items-center justify-center">
                                                    <div class="w-3 h-3 rounded-full bg-red-500 hidden payment-check"></div>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- MTN Mobile Money -->
                                        <label class="payment-option group relative border-2 border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-yellow-500 hover:shadow-lg transition-all duration-300 bg-white" id="mtn-label">
                                            <input type="radio" value="mtn mobile money" name="payment_method" id="mtn_money" class="hidden">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-white rounded-xl mb-4 flex items-center justify-center p-2 group-hover:bg-yellow-50 transition-all duration-300 shadow-sm border border-gray-100">
                                                    <img src="{{ asset('assets/images/mtnlogo.png') }}" alt="MTN Mobile Money" class="w-full h-full object-contain">
                                                </div>
                                                <h5 class="font-semibold text-gray-900 mb-1">MTN Mobile Money</h5>
                                                <p class="text-xs text-gray-500">Mobile payment</p>
                                                <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 group-hover:border-yellow-500 transition-colors flex items-center justify-center">
                                                    <div class="w-3 h-3 rounded-full bg-yellow-500 hidden payment-check"></div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Payment Details Sections -->
                                    <!-- Airtel Money Details -->
                                    <div class="payment-details hidden bg-gradient-to-br from-red-50 to-white rounded-xl p-6 border-2 border-red-100 mb-6 transition-all duration-300" id="airtel-details">
                                        <div class="flex items-start gap-4 mb-4">
                                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <img src="{{ asset('assets/images/airtellogowide-new.png') }}" alt="Airtel" class="w-10 h-10 object-contain">
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 mb-1">Pay with Airtel Money</h4>
                                                <p class="text-sm text-gray-600">Send payment to the details below and upload your transaction receipt</p>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-white rounded-lg p-4 mb-4 border border-red-200">
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                                    <span class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                                        <i data-lucide="phone" class="w-4 h-4 text-red-600"></i>
                                                        Phone Number
                                                    </span>
                                                    <span class="text-sm font-semibold text-gray-900 font-mono">0701861283</span>
                                                </div>
                                                <div class="flex items-center justify-between py-2">
                                                    <span class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                                        <i data-lucide="user" class="w-4 h-4 text-red-600"></i>
                                                        Account Name
                                                    </span>
                                                    <span class="text-sm font-semibold text-gray-900">Apex Electronics</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            <div>
                                                <label for="transaction_id_airtel" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                    <i data-lucide="hash" class="w-4 h-4 text-red-600"></i>
                                                    Transaction ID
                                                </label>
                                                <input type="text" name="transaction_id" id="transaction_id_airtel" placeholder="Enter your Airtel transaction ID" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500 transition text-sm">
                                                <p class="mt-1 text-xs text-gray-500">Enter the transaction ID from your Airtel Money payment</p>
                                            </div>
                                            <div>
                                                <label for="transaction_photo_airtel" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                    <i data-lucide="image" class="w-4 h-4 text-red-600"></i>
                                                    Upload Receipt (Optional)
                                                </label>
                                                <div class="relative">
                                                    <input type="file" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500 transition text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" name="transaction_photo" id="transaction_photo_airtel" accept="image/*">
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">Upload a screenshot of your payment confirmation</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MTN Mobile Money Details -->
                                    <div class="payment-details hidden bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 border-2 border-yellow-100 mb-6 transition-all duration-300" id="mtn-details">
                                        <div class="flex items-start gap-4 mb-4">
                                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <img src="{{ asset('assets/images/mtnlogo.png') }}" alt="MTN" class="w-10 h-10 object-contain">
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 mb-1">Pay with MTN Mobile Money</h4>
                                                <p class="text-sm text-gray-600">Send payment to the details below and upload your transaction receipt</p>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-white rounded-lg p-4 mb-4 border border-yellow-200">
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                                    <span class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                                        <i data-lucide="phone" class="w-4 h-4 text-yellow-600"></i>
                                                        Phone Number
                                                    </span>
                                                    <span class="text-sm font-semibold text-gray-900 font-mono">0778777809</span>
                                                </div>
                                                <div class="flex items-center justify-between py-2">
                                                    <span class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                                        <i data-lucide="user" class="w-4 h-4 text-yellow-600"></i>
                                                        Account Name
                                                    </span>
                                                    <span class="text-sm font-semibold text-gray-900">Apex Electronics</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            <div>
                                                <label for="transaction_id_mtn" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                    <i data-lucide="hash" class="w-4 h-4 text-yellow-600"></i>
                                                    Transaction ID
                                                </label>
                                                <input type="text" id="transaction_id_mtn" name="transaction_id" placeholder="Enter your MTN transaction ID" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500 transition text-sm">
                                                <p class="mt-1 text-xs text-gray-500">Enter the transaction ID from your MTN Mobile Money payment</p>
                                            </div>
                                            <div>
                                                <label for="transaction_photo_mtn" class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                    <i data-lucide="image" class="w-4 h-4 text-yellow-600"></i>
                                                    Upload Receipt (Optional)
                                                </label>
                                                <div class="relative">
                                                    <input type="file" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500 transition text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" id="transaction_photo_mtn" name="transaction_photo" accept="image/*">
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">Upload a screenshot of your payment confirmation</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cash on Delivery Info -->
                                    <div class="payment-details bg-gradient-to-br from-green-50 to-white rounded-xl p-6 border-2 border-green-100 mb-6" id="cash-details">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i data-lucide="truck" class="w-6 h-6 text-green-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 mb-2">Pay on Delivery</h4>
                                                <p class="text-sm text-gray-600 mb-3">You'll pay with cash or mobile money when your order arrives. Our delivery agent will collect payment at your doorstep.</p>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <i data-lucide="shield-check" class="w-4 h-4 text-green-600"></i>
                                                    <span>Secure and convenient payment method</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Agreement Terms -->
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                        <label class="flex items-start cursor-pointer">
                                            <input type="checkbox" id="agree_terms" required class="mt-1 mr-3 w-5 h-5 text-primary-500 focus:ring-primary-500 border-gray-300 rounded cursor-pointer">
                                            <span class="text-sm text-gray-700">
                                                I agree to the <a href="{{ route('frontend.help.show', 'returns-refunds') }}" target="_blank" class="text-primary-600 hover:underline font-medium">terms and conditions</a>, <a href="{{ route('frontend.help.show', 'returns-refunds') }}" target="_blank" class="text-primary-600 hover:underline font-medium">return policy</a> & <a href="#" class="text-primary-600 hover:underline font-medium">privacy policy</a>
                                            </span>
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
                                        $subtotal = 0;
                                        $itemCount = 0;
                                        foreach ($cart as $productId => $quantity) {
                                            $product = \App\Models\Product::find($productId);
                                            if ($product) {
                                                $subtotal += ($product->selling_price ?? 0) * $quantity;
                                                $itemCount += $quantity;
                                            }
                                        }
                                        $taxes = 0;
                                        $total = $subtotal + $taxes;
                                    @endphp
                                    
                                    <div class="space-y-3 mb-6">
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

                                    <button type="submit" id="submit-btn" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-4 rounded-xl font-bold text-base hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <i data-lucide="lock" class="w-5 h-5"></i>
                                        <span>Confirm & Place Order</span>
                                    </button>
                                    
                                    <p class="text-xs text-center text-gray-500 mt-4 flex items-center justify-center gap-1">
                                        <i data-lucide="shield-check" class="w-3 h-3 text-green-600"></i>
                                        Secure payment • Protected by SSL
                                    </p>
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

        // Payment method selection handlers
        const cashRadio = document.getElementById('cash');
        const airtelRadio = document.getElementById('airtel_money');
        const mtnRadio = document.getElementById('mtn_money');
        
        const airtelDetails = document.getElementById('airtel-details');
        const mtnDetails = document.getElementById('mtn-details');
        const cashDetails = document.getElementById('cash-details');
        
        const airtelLabel = document.getElementById('airtel-label');
        const mtnLabel = document.getElementById('mtn-label');
        const cashLabel = document.getElementById('cash-label');

        function updatePaymentUI() {
            // Reset all labels
            [cashLabel, airtelLabel, mtnLabel].forEach(label => {
                label.classList.remove('border-primary-500', 'border-red-500', 'border-yellow-500', 'bg-primary-50', 'bg-red-50', 'bg-yellow-50', 'shadow-lg');
                label.classList.add('border-gray-200');
                const check = label.querySelector('.payment-check');
                if (check) check.classList.add('hidden');
            });
            
            // Hide all details
            airtelDetails.classList.add('hidden');
            mtnDetails.classList.add('hidden');
            cashDetails.classList.add('hidden');
            
            // Show selected payment details and update styling
            if (airtelRadio.checked) {
                airtelLabel.classList.remove('border-gray-200');
                airtelLabel.classList.add('border-red-500', 'bg-red-50', 'shadow-lg');
                airtelDetails.classList.remove('hidden');
                const check = airtelLabel.querySelector('.payment-check');
                if (check) check.classList.remove('hidden');
            } else if (mtnRadio.checked) {
                mtnLabel.classList.remove('border-gray-200');
                mtnLabel.classList.add('border-yellow-500', 'bg-yellow-50', 'shadow-lg');
                mtnDetails.classList.remove('hidden');
                const check = mtnLabel.querySelector('.payment-check');
                if (check) check.classList.remove('hidden');
            } else if (cashRadio.checked) {
                cashLabel.classList.remove('border-gray-200');
                cashLabel.classList.add('border-primary-500', 'bg-primary-50', 'shadow-lg');
                cashDetails.classList.remove('hidden');
                const check = cashLabel.querySelector('.payment-check');
                if (check) check.classList.remove('hidden');
            }
        }

        cashRadio.addEventListener('change', updatePaymentUI);
        airtelRadio.addEventListener('change', updatePaymentUI);
        mtnRadio.addEventListener('change', updatePaymentUI);
        
        // Label click handlers
        cashLabel.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                cashRadio.checked = true;
                updatePaymentUI();
            }
        });
        
        airtelLabel.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                airtelRadio.checked = true;
                updatePaymentUI();
            }
        });
        
        mtnLabel.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                mtnRadio.checked = true;
                updatePaymentUI();
            }
        });
        
        // Form validation
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submit-btn');
        
        form.addEventListener('submit', function(e) {
            const agreeTerms = document.getElementById('agree_terms');
            if (!agreeTerms.checked) {
                e.preventDefault();
                alert('Please agree to the terms and conditions to proceed.');
                agreeTerms.focus();
                return false;
            }
            
            // Validate mobile money fields if selected
            if (airtelRadio.checked) {
                const transactionId = document.getElementById('transaction_id_airtel').value.trim();
                if (!transactionId) {
                    e.preventDefault();
                    alert('Please enter your Airtel transaction ID.');
                    document.getElementById('transaction_id_airtel').focus();
                    return false;
                }
            } else if (mtnRadio.checked) {
                const transactionId = document.getElementById('transaction_id_mtn').value.trim();
                if (!transactionId) {
                    e.preventDefault();
                    alert('Please enter your MTN transaction ID.');
                    document.getElementById('transaction_id_mtn').focus();
                    return false;
                }
            }
            
            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Processing...';
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
        
        // Initial update
        updatePaymentUI();
    });
</script>
@endsection
