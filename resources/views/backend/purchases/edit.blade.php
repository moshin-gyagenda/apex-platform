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
                        <span class="text-sm font-medium text-gray-500">Create Purchase</span>
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
                <h1 class="text-xl font-semibold text-gray-800">Create New Purchase</h1>
                <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back
                </button>
            </div>

            <form action="{{ route('admin.purchases.store') }}" method="POST" id="purchase-form">
                @csrf
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">Purchase Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Enter the details for the new purchase</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6 space-y-6">
                        <!-- Purchase Details -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="file-text" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Purchase Details
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Supplier <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        name="supplier_id"
                                        id="supplier_id"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                        <option value="">Select a supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}@if($supplier->company) - {{ $supplier->company }}@endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-1">
                                        Invoice Number <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="invoice_number"
                                        id="invoice_number"
                                        value="{{ old('invoice_number') }}"
                                        placeholder="e.g., INV-2026-001"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('invoice_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Purchase Date <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="purchase_date"
                                        id="purchase_date"
                                        value="{{ old('purchase_date', date('Y-m-d')) }}"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('purchase_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Purchase Items -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i data-lucide="shopping-cart" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Purchase Items
                                </h4>
                                <button
                                    type="button"
                                    onclick="addPurchaseItemRow()"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 border border-primary-200 rounded-lg hover:bg-primary-100 transition-colors"
                                >
                                    <i data-lucide="plus" class="w-3 h-3 mr-1"></i>
                                    Add Item
                                </button>
                            </div>
                            <div id="purchase-items-container" class="space-y-3">
                                <!-- Purchase item rows will be added here dynamically -->
                            </div>
                            <div class="mt-4 flex justify-end">
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 w-full md:w-80">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-700">Total Amount:</span>
                                        <span id="total-amount-display" class="text-lg font-semibold text-gray-800">0 UGX</span>
                                    </div>
                                    <input type="hidden" id="total-amount-input" name="total_amount" value="0">
                                </div>
                            </div>
                            @error('item_product_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('item_quantity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('item_cost_price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-4 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                        <button type="button" onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                            Create Purchase
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    const products = @json($products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'sku' => $p->sku, 'cost_price' => $p->cost_price]));
    let itemIndex = 0;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();

        // Close alert messages
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.alert-message').remove();
            });
        });

        // Add initial empty row
        addPurchaseItemRow();
    });

    function addPurchaseItemRow() {
        const container = document.getElementById('purchase-items-container');
        const row = document.createElement('div');
        row.className = 'purchase-item-row bg-gray-50 rounded-lg p-4 border border-gray-200';
        row.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Product <span class="text-red-500">*</span></label>
                    <select
                        name="item_product_id[]"
                        class="item-product-select w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition text-sm"
                        required
                        onchange="updateProductInfo(this)"
                    >
                        <option value="">Select product</option>
                        ${products.map(p => `<option value="${p.id}" data-cost-price="${p.cost_price}">${p.name} (${p.sku})</option>`).join('')}
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                    <input
                        type="number"
                        name="item_quantity[]"
                        class="item-quantity w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition text-sm"
                        min="1"
                        value="1"
                        required
                        oninput="calculateItemSubtotal(this)"
                    >
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Cost Price (UGX) <span class="text-red-500">*</span></label>
                    <input
                        type="number"
                        name="item_cost_price[]"
                        class="item-cost-price w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition text-sm"
                        step="0.01"
                        min="0"
                        required
                        oninput="calculateItemSubtotal(this)"
                    >
                </div>
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Subtotal</label>
                        <div class="item-subtotal-display w-full py-2 px-3 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 font-medium">
                            0 UGX
                        </div>
                    </div>
                    <button
                        type="button"
                        onclick="removePurchaseItemRow(this)"
                        class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                        title="Remove"
                    >
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(row);
        lucide.createIcons();
        itemIndex++;
    }

    function removePurchaseItemRow(button) {
        button.closest('.purchase-item-row').remove();
        calculateTotalAmount();
    }

    function updateProductInfo(select) {
        const option = select.options[select.selectedIndex];
        const costPrice = option.getAttribute('data-cost-price');
        if (costPrice) {
            const row = select.closest('.purchase-item-row');
            const costPriceInput = row.querySelector('.item-cost-price');
            costPriceInput.value = costPrice;
            calculateItemSubtotal(costPriceInput);
        }
    }

    function calculateItemSubtotal(input) {
        const row = input.closest('.purchase-item-row');
        const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
        const costPrice = parseFloat(row.querySelector('.item-cost-price').value) || 0;
        const subtotal = quantity * costPrice;
        
        const subtotalDisplay = row.querySelector('.item-subtotal-display');
        subtotalDisplay.textContent = new Intl.NumberFormat('en-US').format(subtotal.toFixed(0)) + ' UGX';
        
        calculateTotalAmount();
    }

    function calculateTotalAmount() {
        let total = 0;
        document.querySelectorAll('.purchase-item-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
            const costPrice = parseFloat(row.querySelector('.item-cost-price').value) || 0;
            total += quantity * costPrice;
        });

        document.getElementById('total-amount-display').textContent = new Intl.NumberFormat('en-US').format(total.toFixed(0)) + ' UGX';
        document.getElementById('total-amount-input').value = total.toFixed(2);
    }
</script>
@endsection
