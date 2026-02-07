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
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Client Orders</span>
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
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <h1 class="text-xl font-semibold text-gray-800">Client Orders</h1>
                <div class="flex flex-wrap gap-2">
                    <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back
                    </button>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                @if($orders->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                            <i data-lucide="package" class="w-12 h-12 text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700">No orders found</h3>
                        <p class="mt-2 text-sm text-gray-500 text-center max-w-sm">
                            Client orders from the frontend store will appear here.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Order #</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Customer</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden md:table-cell">Date</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden lg:table-cell">Payment</th>
                                    <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Total</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                    <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $index => $order)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                                        <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $order->order_number }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600">
                                            {{ $order->user->name ?? 'N/A' }}
                                            <span class="block text-xs text-gray-500">{{ $order->user->email ?? '' }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-600 hidden md:table-cell">
                                            {{ $order->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-600 hidden lg:table-cell capitalize">
                                            {{ str_replace('_', ' ', $order->payment_method ?? 'N/A') }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-right text-gray-800 font-semibold">
                                            {{ number_format($order->total_amount, 0) }} UGX
                                        </td>
                                        <td class="py-3 px-4">
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
                                            <span class="px-2 py-1 text-xs font-medium rounded-full border capitalize {{ $statusClass }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 border border-primary-200 rounded-lg hover:bg-primary-100 hover:text-primary-700 transition-colors" title="View & Update Status">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 px-4 py-3 border-t border-gray-200">
                        {{ $orders->links() }}
                    </div>
                @endif
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
