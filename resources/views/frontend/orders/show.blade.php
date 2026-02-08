@extends('frontend.layouts.app')

@section('title', 'Order #' . ($order->order_number ?? $order->id) . ' - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600">Home</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i></li>
                <li><a href="{{ route('frontend.dashboard.index') }}" class="text-gray-600 hover:text-primary-600">Dashboard</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i></li>
                <li><a href="{{ route('frontend.orders.index') }}" class="text-gray-600 hover:text-primary-600">My Orders</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i></li>
                <li class="text-gray-900 font-medium">Order #{{ $order->order_number ?? $order->id }}</li>
            </ol>
        </div>
    </nav>

    <section class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto space-y-8">
                <!-- Header + Back -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h1 class="font-bold text-gray-900 text-2xl -m -fs20 -elli flex items-center gap-2">
                        <i data-lucide="package" class="w-7 h-7 text-primary-500"></i>
                        Order #{{ $order->order_number ?? $order->id }}
                    </h1>
                    <a href="{{ route('frontend.orders.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium text-sm">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back to My Orders
                    </a>
                </div>

                <!-- Order Status Tracker -->
                @php
                    $statusFlow = ['pending', 'processing', 'shipped', 'delivered'];
                    $currentStatus = strtolower($order->status ?? 'pending');
                    $currentIndex = array_search($currentStatus, $statusFlow);
                    if ($currentIndex === false) {
                        if ($currentStatus === 'cancelled') {
                            $currentIndex = -1;
                        } else {
                            $currentIndex = 0;
                        }
                    }
                @endphp
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-5 h-5 text-primary-500"></i>
                        Order Status
                    </h2>
                    <div class="relative">
                        <div class="flex justify-between items-start">
                            @foreach($statusFlow as $index => $step)
                                @php
                                    $isDone = $currentStatus === 'cancelled' ? false : ($index <= $currentIndex);
                                    $isCurrent = $currentStatus !== 'cancelled' && $index === $currentIndex;
                                @endphp
                                <div class="flex flex-col items-center flex-1 text-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium border-2 flex-shrink-0
                                        {{ $isDone ? 'bg-primary-500 border-primary-500 text-white' : ($isCurrent ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-gray-200 bg-gray-50 text-gray-400') }}">
                                        @if($isDone && !$isCurrent)
                                            <i data-lucide="check" class="w-5 h-5"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <span class="mt-2 text-xs font-medium {{ $isCurrent ? 'text-primary-600' : ($isDone ? 'text-gray-700' : 'text-gray-400') }}">
                                        {{ ucfirst($step) }}
                                    </span>
                                </div>
                                @if($index < count($statusFlow) - 1)
                                    <div class="flex-1 h-0.5 mt-5 mx-1 {{ $index < $currentIndex ? 'bg-primary-500' : 'bg-gray-200' }}"></div>
                                @endif
                            @endforeach
                        </div>
                        @if($currentStatus === 'cancelled')
                            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-center">
                                <span class="text-sm font-medium text-red-800">This order has been cancelled.</span>
                                @if($order->comment)
                                    <p class="text-xs text-red-600 mt-1">{{ $order->comment }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order summary + items -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Items -->
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="font-semibold text-gray-900">Items ({{ $order->orderItems->count() }})</h3>
                            </div>
                            <ul class="divide-y divide-gray-100">
                                @foreach($order->orderItems as $item)
                                    @php
                                        $product = $item->product;
                                        $imageUrl = $product && $product->image
                                            ? (str_starts_with($product->image, 'http') ? $product->image : asset('assets/images/' . $product->image))
                                            : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=200';
                                    @endphp
                                    <li class="flex gap-4 p-4 hover:bg-gray-50/50">
                                        <img src="{{ $imageUrl }}" alt="{{ $product->name ?? 'Product' }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-900 truncate">{{ $product->name ?? 'Product' }}</p>
                                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × UGX {{ number_format($item->price ?? 0, 0) }}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="font-semibold text-gray-900">UGX {{ number_format(($item->quantity ?? 0) * ($item->price ?? 0), 0) }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <!-- Summary card -->
                        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                            <h3 class="font-semibold text-gray-900 mb-4">Order Summary</h3>
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Subtotal</dt>
                                    <dd class="font-medium text-gray-900">UGX {{ number_format($order->subtotal ?? 0, 0) }}</dd>
                                </div>
                                @if(($order->taxes ?? 0) > 0)
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Tax</dt>
                                        <dd class="font-medium text-gray-900">UGX {{ number_format($order->taxes, 0) }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between pt-2 border-t border-gray-200">
                                    <dt class="font-semibold text-gray-900">Total</dt>
                                    <dd class="font-bold text-primary-600">UGX {{ number_format($order->total_amount ?? 0, 0) }}</dd>
                                </div>
                            </dl>
                            <div class="mt-4 pt-4 border-t border-gray-100 space-y-2 text-xs text-gray-500">
                                <p><span class="font-medium text-gray-700">Payment:</span> {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                                <p><span class="font-medium text-gray-700">Placed:</span> {{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        <!-- Shipping -->
                        @if($order->shippingInfo)
                            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                    <i data-lucide="truck" class="w-4 h-4 text-primary-500"></i>
                                    Shipping Address
                                </h3>
                                <p class="text-sm text-gray-600">{{ $order->shippingInfo->street_address ?? '' }}</p>
                                <p class="text-sm text-gray-600">{{ $order->shippingInfo->city ?? '' }}, {{ $order->shippingInfo->state_region ?? '' }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $order->shippingInfo->phone ?? '' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('frontend.orders.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                        <i data-lucide="list" class="w-4 h-4 mr-2"></i>
                        All Orders
                    </a>
                    <a href="{{ route('frontend.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors">
                        <i data-lucide="shopping-bag" class="w-4 h-4 mr-2"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection
