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
                        <a href="{{ route('admin.sales.receipt.download', $sale) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            Download Receipt
                        </a>
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
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->saleItems as $index => $item)
                                        @php
                                            $returnedQty = $returnedQuantities[$item->id] ?? 0;
                                            $availableToReturn = $item->quantity - $returnedQty;
                                        @endphp
                                        <tr class="border-b border-gray-100 {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                                            <td class="py-3 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                            <td class="py-3 px-4">
                                                <div>
                                                    <div class="font-medium text-sm text-gray-800">{{ $item->product->name }}</div>
                                                    <div class="text-xs text-gray-500 font-mono">{{ $item->product->sku }}</div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800">
                                                {{ $item->quantity }}
                                                @if($returnedQty > 0)
                                                    <span class="text-xs text-red-600 block">(Returned: {{ $returnedQty }})</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800">{{ number_format($item->unit_price, 0) }} UGX</td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800 font-medium">{{ number_format($item->subtotal, 0) }} UGX</td>
                                            <td class="py-3 px-4 text-center">
                                                @if($availableToReturn > 0)
                                                    <button 
                                                        onclick="openReturnModal({{ $item->id }}, '{{ $item->product->name }}', {{ $item->quantity }}, {{ $returnedQty }}, {{ $item->unit_price }})"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-orange-600 bg-orange-50 border border-orange-200 rounded-lg hover:bg-orange-100 transition-colors"
                                                    >
                                                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                                        Return
                                                    </button>
                                                @else
                                                    <span class="text-xs text-gray-400">Fully Returned</span>
                                                @endif
                                            </td>
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

            <!-- Returns History -->
            @if($sale->returns->isNotEmpty())
            <div class="bg-white rounded-lg border border-gray-200 mt-4">
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i data-lucide="rotate-ccw" class="w-5 h-5 text-orange-500"></i>
                        Return History
                    </h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Product</th>
                                    <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Qty Returned</th>
                                    <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Refund Amount</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Reason</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Date</th>
                                    <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->returns as $return)
                                <tr class="border-b border-gray-100">
                                    <td class="py-3 px-4 text-sm text-gray-800">{{ $return->product->name }}</td>
                                    <td class="py-3 px-4 text-sm text-right text-gray-800">{{ $return->quantity_returned }}</td>
                                    <td class="py-3 px-4 text-sm text-right text-gray-800 font-medium">{{ number_format($return->refund_amount, 0) }} UGX</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $return->reason ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $return->created_at->format('M d, Y H:i') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $return->status === 'approved' ? 'bg-green-100 text-green-700' : ($return->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($return->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-gray-300 bg-orange-50">
                                    <td colspan="2" class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Total Refunded:</td>
                                    <td class="py-3 px-4 text-right text-sm font-semibold text-orange-600">
                                        {{ number_format($sale->returns->where('status', 'approved')->sum('refund_amount'), 0) }} UGX
                                    </td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @endif

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

    <!-- Return Modal -->
    <div id="return-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeReturnModal()"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <form id="return-form" method="POST" action="">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                                <i data-lucide="rotate-ccw" class="w-6 h-6 text-orange-600"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Return Product</h3>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-1"><strong>Product:</strong> <span id="return-product-name"></span></p>
                                    <p class="text-sm text-gray-600 mb-1"><strong>Original Quantity:</strong> <span id="return-original-qty"></span></p>
                                    <p class="text-sm text-gray-600 mb-1"><strong>Already Returned:</strong> <span id="return-returned-qty"></span></p>
                                    <p class="text-sm text-gray-600 mb-3"><strong>Available to Return:</strong> <span id="return-available-qty" class="font-semibold text-primary-600"></span></p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity to Return</label>
                                    <input 
                                        type="number" 
                                        id="return-quantity" 
                                        name="quantity_returned" 
                                        min="1" 
                                        max="" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-200"
                                    >
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                                    <textarea 
                                        name="reason" 
                                        rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-200 text-sm"
                                        placeholder="Enter reason for return..."
                                    ></textarea>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg mb-4">
                                    <p class="text-xs text-gray-600 mb-1">Refund Amount:</p>
                                    <p class="text-lg font-semibold text-primary-600" id="return-refund-amount">0 UGX</p>
                                </div>
                                <div class="flex gap-3">
                                    <button 
                                        type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 transition-colors"
                                    >
                                        <i data-lucide="check" class="w-4 h-4 inline mr-1"></i>
                                        Process Return
                                    </button>
                                    <button 
                                        type="button" 
                                        onclick="closeReturnModal()" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });

    let returnUnitPrice = 0;

    function openReturnModal(itemId, productName, originalQty, returnedQty, unitPrice) {
        const availableQty = originalQty - returnedQty;
        returnUnitPrice = unitPrice;
        
        document.getElementById('return-product-name').textContent = productName;
        document.getElementById('return-original-qty').textContent = originalQty;
        document.getElementById('return-returned-qty').textContent = returnedQty;
        document.getElementById('return-available-qty').textContent = availableQty;
        document.getElementById('return-quantity').max = availableQty;
        document.getElementById('return-quantity').value = availableQty;
        const saleId = {{ $sale->id }};
        document.getElementById('return-form').action = '{{ route("admin.sales.return", ":id") }}'.replace(':id', saleId);
        
        // Add hidden input for sale_item_id
        let hiddenInput = document.getElementById('return-sale-item-id');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'sale_item_id';
            hiddenInput.id = 'return-sale-item-id';
            document.getElementById('return-form').appendChild(hiddenInput);
        }
        hiddenInput.value = itemId;
        
        // Update refund amount
        updateRefundAmount();
        
        document.getElementById('return-modal').classList.remove('hidden');
        lucide.createIcons();
    }

    function closeReturnModal() {
        document.getElementById('return-modal').classList.add('hidden');
    }

    function updateRefundAmount() {
        const quantity = parseInt(document.getElementById('return-quantity').value) || 0;
        const refundAmount = quantity * returnUnitPrice;
        document.getElementById('return-refund-amount').textContent = new Intl.NumberFormat('en-US').format(refundAmount) + ' UGX';
    }

    document.getElementById('return-quantity')?.addEventListener('input', updateRefundAmount);
</script>
@endsection
