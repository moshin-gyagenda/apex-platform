@extends('frontend.layouts.app')

@section('title', 'My Orders - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600">Home</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i></li>
                <li><a href="{{ route('frontend.dashboard.index') }}" class="text-gray-600 hover:text-primary-600">Dashboard</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i></li>
                <li class="text-gray-900 font-medium">My Orders</li>
            </ol>
        </div>
    </nav>

    <section class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <h1 class="font-bold text-gray-900 text-2xl -m -fs20 -elli flex items-center gap-2">
                        <i data-lucide="package" class="w-7 h-7 text-primary-500"></i>
                        My Orders
                    </h1>
                    <a href="{{ route('frontend.dashboard.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium text-sm">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>

                @if($orders->isEmpty())
                    <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center shadow-sm">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="package" class="w-10 h-10 text-gray-400"></i>
                        </div>
                        <h2 class="font-semibold text-gray-900 mb-2">No orders yet</h2>
                        <p class="text-gray-500 mb-6 max-w-sm mx-auto">When you place an order, it will appear here. You can track its status from this page.</p>
                        <a href="{{ route('frontend.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors">
                            <i data-lucide="shopping-bag" class="w-4 h-4 mr-2"></i>
                            Start Shopping
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-4 sm:p-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <span class="font-semibold text-gray-900">Order #{{ $order->order_number ?? $order->id }}</span>
                                                <span class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y \a\t H:i') }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600">
                                                {{ $order->orderItems->count() }} item(s) · UGX {{ number_format($order->total_amount ?? 0, 0) }}
                                            </p>
                                            @if($order->payment_method)
                                                <p class="text-xs text-gray-500 mt-1">Payment: {{ ucfirst($order->payment_method) }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-3 flex-shrink-0">
                                            @php
                                                $status = strtolower($order->status ?? 'pending');
                                                $statusClasses = [
                                                    'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                    'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'shipped' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                    'delivered' => 'bg-green-100 text-green-800 border-green-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                ];
                                                $statusClass = $statusClasses[$status] ?? $statusClasses['pending'];
                                            @endphp
                                            <span class="px-3 py-1.5 text-sm font-medium rounded-full border {{ $statusClass }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                            <a href="{{ route('frontend.orders.show', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-xl text-sm font-medium hover:bg-primary-600 transition-colors">
                                                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($orders->hasPages())
                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @endif
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
