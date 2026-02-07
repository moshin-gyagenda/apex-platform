@extends('backend.layouts.app')
@section('content')

    <div class="p-4 sm:ml-64 mt-16 flex flex-col min-h-screen">
        <!-- Breadcrumb Section -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2 text-gray-500"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Client Orders</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Order #{{ $order->order_number }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if (session('success'))
            <div role="alert" class="rounded-lg mb-4 border border-green-200 bg-green-50 p-4 alert-message">
                <div class="flex items-start gap-4">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <strong class="block font-medium text-green-800">{{ session('success') }}</strong>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 transition-colors close-btn">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div role="alert" class="rounded-lg mb-4 border border-red-200 bg-red-50 p-4 alert-message">
                <div class="flex items-start gap-4">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <strong class="block font-medium text-red-800">{{ session('error') }}</strong>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 transition-colors close-btn">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        @endif

        <div class="container mx-auto py-6 px-4 sm:px-6">
            <!-- Order Header -->
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="px-4 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg bg-primary-50 flex items-center justify-center border border-primary-200">
                            <i data-lucide="package" class="w-8 h-8 text-primary-500"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">Order #{{ $order->order_number }}</h1>
                            <div class="flex flex-wrap items-center mt-1 gap-2">
                                <span class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</span>
                                @php
                                    $statusClass = match($order->status) {
                                        'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'shipped' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                        'delivered' => 'bg-green-100 text-green-800 border-green-200',
                                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200',
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full border capitalize {{ $statusClass }}">{{ $order->status }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                            Back to Orders
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Order details + items -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer & Shipping -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-800">Customer & Shipping</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                        <i data-lucide="user" class="w-4 h-4 mr-2 text-primary-500"></i>
                                        Customer
                                    </h4>
                                    <p class="text-sm text-gray-800">{{ $order->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->email ?? '' }}</p>
                                </div>
                                @if($order->shippingInfo)
                                    <div class="space-y-3">
                                        <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                            <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-primary-500"></i>
                                            Shipping Address
                                        </h4>
                                        <p class="text-sm text-gray-800">
                                            {{ $order->shippingInfo->first_name }} {{ $order->shippingInfo->last_name }}
                                            @if($order->shippingInfo->other_name) {{ $order->shippingInfo->other_name }} @endif
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $order->shippingInfo->street_address }}, {{ $order->shippingInfo->city }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->shippingInfo->state_region }}, {{ $order->shippingInfo->country }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->shippingInfo->phone }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-800">Order Items</h3>
                        </div>
                        <div class="p-6">
                            @if($order->orderItems->isEmpty())
                                <p class="text-sm text-gray-500">No items in this order.</p>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="border-b border-gray-200 bg-gray-50">
                                                <th class="py-2 px-3 text-left text-sm font-semibold text-gray-700">Product</th>
                                                <th class="py-2 px-3 text-right text-sm font-semibold text-gray-700">Qty</th>
                                                <th class="py-2 px-3 text-right text-sm font-semibold text-gray-700">Price</th>
                                                <th class="py-2 px-3 text-right text-sm font-semibold text-gray-700">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->orderItems as $item)
                                                <tr class="border-b border-gray-100">
                                                    <td class="py-3 px-3 text-sm text-gray-800">{{ $item->product->name ?? 'Product #' . $item->product_id }}</td>
                                                    <td class="py-3 px-3 text-sm text-right text-gray-600">{{ $item->quantity }}</td>
                                                    <td class="py-3 px-3 text-sm text-right text-gray-600">{{ number_format($item->price, 0) }} UGX</td>
                                                    <td class="py-3 px-3 text-sm text-right text-gray-800 font-medium">{{ number_format($item->quantity * $item->price, 0) }} UGX</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right: Update status + totals -->
                <div class="space-y-6">
                    <!-- Update Order Status -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-800">Update Order Status</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $canUpdate = !in_array($order->status, ['shipped', 'delivered', 'cancelled']);
                            @endphp
                            @if($canUpdate)
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label for="order_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select name="order_status" id="order_status" required class="w-full py-2 px-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-200 bg-white">
                                            <option value="pending" {{ old('order_status', $order->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ old('order_status', $order->status) === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ old('order_status', $order->status) === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ old('order_status', $order->status) === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ old('order_status', $order->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment (optional)</label>
                                        <textarea name="comment" id="comment" rows="2" maxlength="255" class="w-full py-2 px-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-200" placeholder="e.g. Tracking number or note for customer">{{ old('comment', $order->comment) }}</textarea>
                                    </div>
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors">
                                        <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                                        Update Status
                                    </button>
                                </form>
                            @else
                                <p class="text-sm text-gray-600 mb-2">This order is <span class="font-medium capitalize">{{ $order->status }}</span>. Status can no longer be changed.</p>
                                @if($order->comment)
                                    <p class="text-sm text-gray-500 mt-2 p-2 bg-gray-50 rounded border border-gray-200">{{ $order->comment }}</p>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Order Totals -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-800">Order Summary</h3>
                        </div>
                        <div class="p-6 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-800">{{ number_format($order->subtotal, 0) }} UGX</span>
                            </div>
                            @if(($order->taxes ?? 0) > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="text-gray-800">{{ number_format($order->taxes, 0) }} UGX</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-base font-semibold pt-2 border-t border-gray-200">
                                <span class="text-gray-800">Total</span>
                                <span class="text-gray-900">{{ number_format($order->total_amount, 0) }} UGX</span>
                            </div>
                            <div class="pt-2">
                                <span class="text-xs text-gray-500">Payment: </span>
                                <span class="text-sm text-gray-700 capitalize">{{ str_replace('_', ' ', $order->payment_method ?? 'N/A') }}</span>
                                @if($order->transaction_id)
                                    <span class="text-xs text-gray-500 block mt-1">Transaction: {{ $order->transaction_id }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.alert-message').remove();
            });
        });
    });
</script>
@endsection
