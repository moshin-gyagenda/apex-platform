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
                        <a href="{{ route('admin.purchases.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Purchases</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">View Purchase</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="container mx-auto py-6 px-4 sm:px-6">
            <!-- Purchase Header -->
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="px-4 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg bg-primary-50 flex items-center justify-center border border-primary-200">
                            <i data-lucide="shopping-bag" class="w-8 h-8 text-primary-500"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">Invoice: {{ $purchase->invoice_number }}</h1>
                            <div class="flex flex-wrap items-center mt-1 gap-2">
                                <span class="text-sm text-gray-500">ID: {{ $purchase->id }}</span>
                                <span class="text-sm text-gray-500">• {{ $purchase->purchase_date->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.purchases.edit', $purchase->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors">
                            <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                            Edit
                        </a>
                        <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                            Back
                        </button>
                    </div>
                </div>
            </div>

            <!-- Purchase Details -->
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Purchase Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Purchase Information
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Invoice Number</label>
                                        <p class="mt-1 text-sm text-gray-800 font-mono font-medium">{{ $purchase->invoice_number }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Supplier</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $purchase->supplier->name }}@if($purchase->supplier->company) - {{ $purchase->supplier->company }}@endif</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Purchase Date</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $purchase->purchase_date->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Created By</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $purchase->creator->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Information -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="tag" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Amount Information
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Total Amount</label>
                                        <p class="mt-1 text-xl text-gray-800 font-semibold">{{ number_format($purchase->total_amount, 0) }} UGX</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Items Count</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $purchase->purchaseItems->count() }} items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Items -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Purchase Items</h3>
                </div>
                <div class="p-6">
                    @if($purchase->purchaseItems->isEmpty())
                        <p class="text-sm text-gray-500">No items found for this purchase.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-gray-50">
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">#</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Product</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Quantity</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Cost Price</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->purchaseItems as $index => $item)
                                        <tr class="border-b border-gray-100 {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                                            <td class="py-3 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                            <td class="py-3 px-4">
                                                <div>
                                                    <div class="font-medium text-sm text-gray-800">{{ $item->product->name }}</div>
                                                    <div class="text-xs text-gray-500 font-mono">{{ $item->product->sku }}</div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800">{{ $item->quantity }}</td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800">{{ number_format($item->cost_price, 0) }} UGX</td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800 font-medium">{{ number_format($item->subtotal, 0) }} UGX</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="border-t-2 border-gray-300 bg-gray-50">
                                        <td colspan="4" class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Total:</td>
                                        <td class="py-3 px-4 text-right text-lg font-semibold text-gray-800">{{ number_format($purchase->total_amount, 0) }} UGX</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timestamps -->
            <div class="bg-white rounded-lg border border-gray-200 mt-4">
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Timestamps</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Created At</label>
                            <p class="mt-1 text-sm text-gray-800">{{ $purchase->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-800">{{ $purchase->updated_at->format('M d, Y H:i') }}</p>
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
        // Initialize Lucide icons
        lucide.createIcons();
    });
</script>
@endsection
