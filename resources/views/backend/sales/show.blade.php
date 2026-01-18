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
                        <a href="{{ route('admin.sales.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Sales</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">View Sale</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="container mx-auto py-6 px-4 sm:px-6">
            <!-- Sale Header -->
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="px-4 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg bg-primary-50 flex items-center justify-center border border-primary-200">
                            <i data-lucide="shopping-cart" class="w-8 h-8 text-primary-500"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">Sale #{{ $sale->id }}</h1>
                            <div class="flex flex-wrap items-center mt-1 gap-2">
                                <span class="text-sm text-gray-500">{{ $sale->created_at->format('M d, Y H:i') }}</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full capitalize {{ $sale->payment_status === 'completed' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                    {{ $sale->payment_status }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                            Back
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sale Details -->
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Sale Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Sale Information
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Customer</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Cashier</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $sale->creator->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Payment Method</label>
                                        <p class="mt-1 text-sm text-gray-800 capitalize">{{ str_replace('_', ' ', $sale->payment_method) }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Payment Status</label>
                                        <p class="mt-1">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $sale->payment_status === 'completed' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                                {{ ucfirst($sale->payment_status) }}
                                            </span>
                                        </p>
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
                                        <label class="text-xs font-medium text-gray-500 uppercase">Subtotal</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ number_format($sale->total_amount, 0) }} UGX</p>
                                    </div>
                                    @if($sale->discount > 0)
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Discount</label>
                                        <p class="mt-1 text-sm text-red-600">-{{ number_format($sale->discount, 0) }} UGX</p>
                                    </div>
                                    @endif
                                    @if($sale->tax > 0)
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Tax</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ number_format($sale->tax, 0) }} UGX</p>
                                    </div>
                                    @endif
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Final Amount</label>
                                        <p class="mt-1 text-xl text-gray-800 font-semibold">{{ number_format($sale->final_amount, 0) }} UGX</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Items Count</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $sale->saleItems->count() }} items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sale Items -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Sale Items</h3>
                </div>
                <div class="p-6">
                    @if($sale->saleItems->isEmpty())
                        <p class="text-sm text-gray-500">No items found for this sale.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-gray-50">
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">#</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Product</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Quantity</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Unit Price</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->saleItems as $index => $item)
                                        <tr class="border-b border-gray-100 {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                                            <td class="py-3 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                            <td class="py-3 px-4">
                                                <div>
                                                    <div class="font-medium text-sm text-gray-800">{{ $item->product->name }}</div>
                                                    <div class="text-xs text-gray-500 font-mono">{{ $item->product->sku }}</div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800">{{ $item->quantity }}</td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800">{{ number_format($item->unit_price, 0) }} UGX</td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800 font-medium">{{ number_format($item->subtotal, 0) }} UGX</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="border-t-2 border-gray-300 bg-gray-50">
                                        <td colspan="4" class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Subtotal:</td>
                                        <td class="py-3 px-4 text-right text-sm text-gray-800">{{ number_format($sale->total_amount, 0) }} UGX</td>
                                    </tr>
                                    @if($sale->discount > 0)
                                    <tr class="bg-gray-50">
                                        <td colspan="4" class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Discount:</td>
                                        <td class="py-3 px-4 text-right text-sm text-red-600">-{{ number_format($sale->discount, 0) }} UGX</td>
                                    </tr>
                                    @endif
                                    @if($sale->tax > 0)
                                    <tr class="bg-gray-50">
                                        <td colspan="4" class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Tax:</td>
                                        <td class="py-3 px-4 text-right text-sm text-gray-800">{{ number_format($sale->tax, 0) }} UGX</td>
                                    </tr>
                                    @endif
                                    <tr class="border-t-2 border-gray-300 bg-primary-50">
                                        <td colspan="4" class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Total:</td>
                                        <td class="py-3 px-4 text-right text-lg font-semibold text-primary-600">{{ number_format($sale->final_amount, 0) }} UGX</td>
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
                            <p class="mt-1 text-sm text-gray-800">{{ $sale->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-800">{{ $sale->updated_at->format('M d, Y H:i') }}</p>
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
    });
</script>
@endsection
