@extends('frontend.layouts.app')

@section('title', 'Order Confirmation - Apex Electronics & Accessories')

@section('content')
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
                <li class="flex items-center text-green-600">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    <span>Order Confirmation</span>
                </li>
            </ol>
        </div>
    </nav>

    <!-- Order Confirmation Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Order Confirmation Details -->
                <div class="bg-white rounded-lg shadow-md p-8 text-center mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="check-circle" class="w-12 h-12 text-green-600"></i>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Order Confirmation</h2>
                    <p class="text-lg font-semibold text-gray-600 mb-6">Thank you for your order!</p>
                    <p class="text-gray-700 mb-8">We're excited to let you know that your order has been successfully placed. Here are the details of your order:</p>
                    
                    <div class="bg-gray-50 rounded-lg p-6 text-left">
                        <ul class="space-y-4">
                            @if(isset($order))
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Full Name:</strong>
                                    <span class="text-gray-600 flex-1">{{ $order->shippingInfo->first_name ?? '' }} {{ $order->shippingInfo->last_name ?? '' }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Email:</strong>
                                    <span class="text-gray-600 flex-1">{{ $order->shippingInfo->email ?? $order->user->email ?? '' }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Phone:</strong>
                                    <span class="text-gray-600 flex-1">{{ $order->shippingInfo->phone ?? '' }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Order Number:</strong>
                                    <span class="text-gray-600 flex-1">#{{ $order->id ?? 'N/A' }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Order Date:</strong>
                                    <span class="text-gray-600 flex-1">{{ $order->created_at->format('F d, Y') ?? date('F d, Y') }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Shipping Address:</strong>
                                    <span class="text-gray-600 flex-1">{{ $order->shippingInfo->street_address ?? '' }}, {{ $order->shippingInfo->city ?? '' }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Total Amount:</strong>
                                    <span class="text-primary-600 font-bold flex-1">UGX {{ number_format($order->total_amount ?? 0, 0) }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Payment Method:</strong>
                                    <span class="text-gray-600 flex-1 capitalize">{{ $order->payment_method ?? 'N/A' }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Current Status:</strong>
                                    <span class="text-yellow-600 font-medium flex-1 capitalize">{{ $order->status ?? 'Pending' }}</span>
                                </li>
                            @else
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Order Number:</strong>
                                    <span class="text-gray-600 flex-1">Order placed successfully</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Order Date:</strong>
                                    <span class="text-gray-600 flex-1">{{ date('F d, Y') }}</span>
                                </li>
                                <li class="flex justify-between items-start">
                                    <strong class="text-gray-800 w-1/3">Current Status:</strong>
                                    <span class="text-yellow-600 font-medium flex-1">Pending</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('dashboard.index') ?? route('frontend.dashboard.index') ?? '#' }}" class="inline-flex items-center justify-center px-8 py-3 bg-primary-500 text-white rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                        <i data-lucide="user" class="w-5 h-5 mr-2"></i>
                        View Order Details
                    </a>
                    <a href="{{ route('frontend.index') }}" class="inline-flex items-center justify-center px-8 py-3 bg-white border-2 border-primary-500 text-primary-600 rounded-lg font-semibold hover:bg-primary-50 transition-colors">
                        <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                        Continue Shopping
                    </a>
                </div>

                <!-- Additional Information -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i data-lucide="info" class="w-5 h-5 mr-2 text-blue-600"></i>
                        What's Next?
                    </h3>
                    <ul class="space-y-2 text-gray-700 text-sm">
                        <li class="flex items-start">
                            <i data-lucide="check" class="w-4 h-4 mr-2 text-blue-600 mt-0.5 flex-shrink-0"></i>
                            <span>You will receive an email confirmation shortly with your order details.</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="w-4 h-4 mr-2 text-blue-600 mt-0.5 flex-shrink-0"></i>
                            <span>We'll process your order and notify you once it's shipped.</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="w-4 h-4 mr-2 text-blue-600 mt-0.5 flex-shrink-0"></i>
                            <span>Estimated delivery: 3-5 business days.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
