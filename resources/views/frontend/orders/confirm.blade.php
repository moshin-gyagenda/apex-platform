@extends('frontend.layouts.app')

@section('title', 'Order Confirmation - Apex Electronics & Accessories')

@section('content')
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
                <li class="flex items-center text-green-600">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    <span>Confirmation</span>
                </li>
            </ol>
        </div>
    </nav>

    <!-- Order Confirmation Section -->
    <section class="py-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Success Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-6 text-center">
                        <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="check-circle" class="w-16 h-16 text-white"></i>
                        </div>
                        <h2 class="font-bold text-white text-3xl mb-2 -m -fs20 -elli">Order Confirmed!</h2>
                        <p class="text-white/90 text-lg mt-1">Thank you for your order. We're excited to serve you!</p>
                    </div>

                    <div class="p-8">
                        @if(isset($order))
                            <!-- Order Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div class="bg-gradient-to-br from-primary-50 to-white rounded-xl p-5 border border-primary-100">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                            <i data-lucide="hash" class="w-5 h-5 text-primary-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-medium">Order Number</p>
                                            <p class="text-lg font-bold text-gray-900">#{{ $order->id }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-5 border border-green-100">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i data-lucide="calendar" class="w-5 h-5 text-green-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-medium">Order Date</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $order->created_at->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-5 border border-blue-100">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i data-lucide="credit-card" class="w-5 h-5 text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-medium">Payment Method</p>
                                            <p class="text-lg font-bold text-gray-900 capitalize">{{ $order->payment_method ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl p-5 border border-yellow-100">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                            <i data-lucide="package" class="w-5 h-5 text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-medium">Status</p>
                                            <p class="text-lg font-bold text-yellow-600 capitalize">{{ $order->status ?? 'Pending' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer & Shipping Information -->
                            <div class="bg-gray-50 rounded-xl p-6 mb-6 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-4 -m -fs20 -elli flex items-center gap-2">
                                    <i data-lucide="user" class="w-5 h-5 text-primary-600"></i>
                                    Customer & Shipping Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Full Name</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $order->shippingInfo->first_name ?? '' }} {{ $order->shippingInfo->last_name ?? '' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Email</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $order->shippingInfo->email ?? $order->user->email ?? '' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Phone</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $order->shippingInfo->phone ?? '' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Location</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $order->shippingInfo->city ?? '' }}, {{ $order->shippingInfo->state_region ?? '' }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Shipping Address</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $order->shippingInfo->street_address ?? '' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Total -->
                            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-6 mb-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-white/80 text-sm mb-1">Total Amount</p>
                                        <p class="text-3xl font-bold text-white">UGX {{ number_format($order->total_amount ?? 0, 0) }}</p>
                                    </div>
                                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                        <i data-lucide="receipt" class="w-8 h-8 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Fallback for orders without data -->
                            <div class="text-center py-8">
                                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="check-circle" class="w-12 h-12 text-green-600"></i>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2 -m -fs20 -elli">Order Placed Successfully</h3>
                                <p class="text-gray-600 mb-4">Your order has been received and is being processed.</p>
                                <div class="bg-gray-50 rounded-lg p-4 inline-block">
                                    <p class="text-sm text-gray-600"><strong>Order Date:</strong> {{ date('F d, Y') }}</p>
                                    <p class="text-sm text-gray-600"><strong>Status:</strong> <span class="text-yellow-600 font-medium">Pending</span></p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <a href="{{ route('frontend.dashboard.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i data-lucide="user" class="w-5 h-5 mr-2"></i>
                        View Order Details
                    </a>
                    <a href="{{ route('frontend.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-primary-500 text-primary-600 rounded-xl font-semibold hover:bg-primary-50 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                        Continue Shopping
                    </a>
                </div>

                <!-- What's Next Section -->
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-6 border-2 border-blue-100 shadow-md">
                    <h3 class="font-semibold text-gray-900 mb-4 -m -fs20 -elli flex items-center gap-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                        </div>
                        What's Next?
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-blue-100">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm mb-1">Email Confirmation</p>
                                <p class="text-sm text-gray-600">You will receive an email confirmation shortly with your order details.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-blue-100">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="package" class="w-4 h-4 text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm mb-1">Order Processing</p>
                                <p class="text-sm text-gray-600">We'll process your order and notify you once it's shipped.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-blue-100">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="truck" class="w-4 h-4 text-primary-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm mb-1">Delivery</p>
                                <p class="text-sm text-gray-600">Estimated delivery: 1-3 business days within Kampala.</p>
                            </div>
                        </div>
                    </div>
                </div>
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
    });
</script>
@endsection
