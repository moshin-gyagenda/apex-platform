@extends('backend.layouts.app')
@section('content')

<div class="p-4 sm:ml-64 mt-16 flex flex-col min-h-screen">
            <!-- POS Header -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm mb-4 px-4 sm:px-6 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 flex-shrink-0">
        <div class="flex items-center gap-3 sm:gap-4 flex-wrap">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center gap-2 sm:gap-3">
                    <i data-lucide="shopping-cart" class="w-5 h-5 sm:w-6 sm:h-6 text-primary-500"></i>
                    Point of Sale
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Cashier: <span class="font-medium text-gray-700">{{ auth()->user()->name }}</span></p>
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full border border-green-200 flex items-center gap-1">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Online
            </span>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shrink-0">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Dashboard
        </a>
    </div>

    <div class="flex flex-col lg:flex-row flex-1 overflow-hidden min-h-0">
        <!-- Left Panel: Products -->
        <div class="w-full lg:w-2/3 flex flex-col border-r-0 lg:border-r border-gray-200 bg-white overflow-hidden min-h-[50vh] lg:min-h-0">
            <!-- Search and Filters -->
            <div class="p-4 border-b border-gray-200 bg-white flex-shrink-0 space-y-3">
                <!-- Search Bar -->
                <div class="flex gap-2">
                    <div class="flex-1 relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input
                            type="text"
                            id="product-search"
                            placeholder="Search by Product Name, SKU, Barcode, Category, or Brand..."
                            autofocus
                            autocomplete="off"
                            class="w-full pl-9 pr-10 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-200 transition"
                        >
                        <div id="search-loading" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                            <i data-lucide="loader-2" class="w-4 h-4 text-primary-500 animate-spin"></i>
                        </div>
                    </div>
                    <button 
                        type="button"
                        onclick="clearAllFilters()"
                        class="px-4 py-2.5 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2"
                        id="clear-all-btn"
                        style="display: none;"
                    >
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Clear All
                    </button>
                </div>
                
                <!-- Filter Row -->
                <div class="grid grid-cols-2 gap-3">
                    <!-- Category Filter -->
                    <div class="searchable-select-container relative" data-select-id="category-filter">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            <i data-lucide="tag" class="w-3 h-3 inline mr-1"></i>
                            Category
                        </label>
                        <div class="selected-display relative mt-1 py-2.5 px-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-primary-500 transition focus-within:border-primary-500">
                            <div class="selected-text text-sm text-gray-500 pr-6">All Categories</div>
                            <i data-lucide="chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none flex-shrink-0"></i>
                        </div>
                        <div class="dropdown-container hidden absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
                            <div class="p-2 sticky top-0 bg-white border-b border-gray-200">
                                <input type="text" class="search-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500" placeholder="Search categories...">
                            </div>
                            <div class="options-list max-h-48 overflow-y-auto">
                                <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="">All Categories</div>
                                @foreach($categories as $category)
                                    <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <select id="category-filter" class="hidden">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand Filter -->
                    <div class="searchable-select-container relative" data-select-id="brand-filter">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            <i data-lucide="award" class="w-3 h-3 inline mr-1"></i>
                            Brand
                        </label>
                        <div class="selected-display relative mt-1 py-2.5 px-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-primary-500 transition focus-within:border-primary-500">
                            <div class="selected-text text-sm text-gray-500 pr-6">All Brands</div>
                            <i data-lucide="chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none flex-shrink-0"></i>
                        </div>
                        <div class="dropdown-container hidden absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
                            <div class="p-2 sticky top-0 bg-white border-b border-gray-200">
                                <input type="text" class="search-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500" placeholder="Search brands...">
                            </div>
                            <div class="options-list max-h-48 overflow-y-auto">
                                <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="">All Brands</div>
                                <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="null">
                                    <span class="text-gray-500 italic">No Brand</span>
                                </div>
                                @foreach($brands as $brand)
                                    <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <select id="brand-filter" class="hidden">
                            <option value="">All Brands</option>
                            <option value="null">No Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1 overflow-y-auto p-3 sm:p-4">
                <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4" data-initial-loaded="true">
                    @foreach($products as $product)
                        @php
                            $productData = [
                                'id' => $product->id,
                                'name' => $product->name,
                                'sku' => $product->sku,
                                'barcode' => $product->barcode,
                                'description' => $product->description,
                                'cost_price' => $product->cost_price,
                                'selling_price' => $product->selling_price,
                                'quantity' => $product->quantity,
                                'reorder_level' => $product->reorder_level,
                                'serial_number' => $product->serial_number,
                                'warranty_months' => $product->warranty_months,
                                'status' => $product->status,
                                'image' => $product->image ? asset('storage/' . $product->image) : null,
                                'category' => $product->category->name ?? null,
                                'brand' => $product->brand->name ?? null,
                                'model' => $product->productModel->name ?? null,
                            ];
                        @endphp
                        <div 
                            class="product-card bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-primary-300 hover:shadow-md transition-all group"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ strtolower($product->name) }}"
                            data-product-sku="{{ strtolower($product->sku) }}"
                            data-product-barcode="{{ strtolower($product->barcode ?? '') }}"
                            data-category-id="{{ $product->category_id ?? '' }}"
                            data-brand-id="{{ $product->brand_id ?? '' }}"
                            data-model-id="{{ $product->product_model_id ?? '' }}"
                            data-product-data='{{ json_encode($productData) }}'
                        >
                            <!-- Product Image -->
                            <div class="relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                                        <i data-lucide="package" class="w-12 h-12 text-gray-300"></i>
                                    </div>
                                @endif
                                @if($product->quantity <= 0)
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <span class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded">Out of Stock</span>
                                    </div>
                                @elseif($product->quantity <= $product->reorder_level)
                                    <div class="absolute top-2 right-2">
                                        <span class="px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded">Low Stock</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 mb-1 text-sm line-clamp-2 min-h-[2.5rem]">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-gray-500 mb-2 font-mono">{{ $product->sku }}</p>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-base font-bold text-primary-600">
                                        {{ number_format($product->selling_price, 0) }} UGX
                                    </span>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <button
                                        onclick="showProductInfo({{ $product->id }}); event.stopPropagation()"
                                        class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 transition-colors flex items-center justify-center gap-1"
                                    >
                                        <i data-lucide="info" class="w-3 h-3"></i>
                                        Info
                                    </button>
                                    <button
                                        onclick="addToCart({{ $product->id }}); event.stopPropagation()"
                                        class="flex-1 px-3 py-1.5 text-xs font-medium text-white bg-primary-500 rounded hover:bg-primary-600 transition-colors flex items-center justify-center gap-1"
                                        {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                    >
                                        <i data-lucide="shopping-cart" class="w-3 h-3"></i>
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div id="no-products" class="hidden flex flex-col items-center justify-center py-12 text-gray-500">
                    <i data-lucide="package" class="w-16 h-16 mb-4 text-gray-300"></i>
                    <p class="text-lg">No products found</p>
                    <p class="text-sm">Try adjusting your search</p>
                </div>
            </div>
        </div>

        <!-- Right Panel: Cart & Checkout -->
        <div class="w-full lg:w-1/3 flex flex-col bg-gray-50 overflow-hidden min-h-0 border-t lg:border-t-0 border-gray-200">
            <!-- Customer Selection -->
            <div class="p-4 bg-white border-b border-gray-200 flex-shrink-0">
                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-primary-500"></i>
                    Customer (Optional)
                </label>
                <div class="searchable-select-container relative" data-select-id="customer-select">
                    <div class="selected-display relative mt-1 py-2.5 px-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-primary-500 transition focus-within:border-primary-500">
                        <div class="selected-text text-sm text-gray-500 pr-6">Walk-in Customer</div>
                        <i data-lucide="chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none flex-shrink-0"></i>
                    </div>
                    <div class="dropdown-container hidden absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
                        <div class="p-2 sticky top-0 bg-white border-b border-gray-200">
                            <input type="text" class="search-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500" placeholder="Search customers by name, email or phone...">
                        </div>
                        <div class="options-list max-h-48 overflow-y-auto">
                            <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="">
                                <div class="font-medium">Walk-in Customer</div>
                                <div class="text-xs text-gray-500">No customer selected</div>
                            </div>
                            @foreach($customers as $customer)
                                <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="{{ $customer->id }}" 
                                     data-search-text="{{ strtolower($customer->name . ' ' . ($customer->email ?? '') . ' ' . ($customer->phone ?? '')) }}">
                                    <div class="font-medium">{{ $customer->name }}</div>
                                    @if($customer->email || $customer->phone)
                                        <div class="text-xs text-gray-500">
                                            {{ $customer->email ?? '' }}{{ $customer->email && $customer->phone ? ' • ' : '' }}{{ $customer->phone ?? '' }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <select id="customer-select" class="hidden">
                        <option value="">Walk-in Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Cart -->
            <div class="flex-1 overflow-y-auto p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Shopping Cart</h2>
                    <button 
                        onclick="clearCart()" 
                        class="text-sm text-red-600 hover:text-red-700 font-medium"
                        id="clear-cart-btn"
                        style="display: none;"
                    >
                        Clear All
                    </button>
                </div>
                <div id="cart-container">
                    <div id="empty-cart" class="text-center py-12">
                        <i data-lucide="shopping-cart" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Cart is empty</p>
                        <p class="text-sm text-gray-400 mt-1">Add products to start a sale</p>
                    </div>
                    <div id="cart-items" class="space-y-3" style="display: none;"></div>
                </div>
            </div>

            <!-- Checkout Summary -->
            <div class="p-4 bg-white border-t border-gray-200 space-y-3 flex-shrink-0">
                <div class="space-y-2 pb-3 border-b border-gray-200">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium text-gray-800" id="cart-subtotal">0 UGX</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Discount:</span>
                        <input 
                            type="number" 
                            id="discount-input" 
                            value="0" 
                            min="0"
                            step="0.01"
                            class="w-24 text-right border border-gray-300 rounded px-2 py-1 text-sm"
                            oninput="calculateTotal()"
                        >
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax ({{ number_format($taxPercentage, 2) }}%):</span>
                        <span class="font-medium text-gray-800" id="cart-tax">0 UGX</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-2 pb-2 border-b border-gray-200">
                    <span class="text-lg font-semibold text-gray-800">Total:</span>
                    <span class="text-2xl font-bold text-primary-600" id="cart-total">0 UGX</span>
                </div>

                <!-- Payment Amount Section -->
                <div class="pt-2 space-y-2">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-medium text-gray-700">
                                Amount Paid
                            </label>
                            <button 
                                type="button"
                                onclick="payFullAmount()"
                                class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1"
                                id="pay-full-btn"
                                style="display: none;"
                            >
                                <i data-lucide="zap" class="w-3 h-3"></i>
                                Pay Full
                            </button>
                        </div>
                        <div class="relative">
                            <input 
                                type="number" 
                                id="amount-paid-input" 
                                value="0" 
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full py-1.5 px-3 pr-16 border border-gray-300 rounded-lg text-right text-base font-semibold focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-200 transition"
                                oninput="calculatePaymentDetails()"
                            >
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 pointer-events-none">UGX</span>
                        </div>
                    </div>

                    <!-- Balance Display -->
                    <div id="balance-section" class="hidden">
                        <div class="flex justify-between items-center p-2 rounded-lg" id="balance-container">
                            <div class="flex items-center gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4" id="balance-icon"></i>
                                <span class="text-sm font-medium" id="balance-label">Balance:</span>
                            </div>
                            <span class="text-base font-bold" id="balance-amount">0 UGX</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="pt-2 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-4 h-4 text-primary-500"></i>
                        Payment Method
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <button 
                            onclick="setPaymentMethod('cash')" 
                            class="payment-method-btn py-1.5 px-2 border-2 border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors text-sm font-medium"
                            data-method="cash"
                        >
                            Cash
                        </button>
                        <button 
                            onclick="setPaymentMethod('mobile_money')" 
                            class="payment-method-btn py-1.5 px-2 border-2 border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors text-sm font-medium"
                            data-method="mobile_money"
                        >
                            Mobile Money
                        </button>
                    </div>
                    <input type="hidden" id="payment-method" value="cash">
                </div>

                <!-- Complete Sale Button -->
                <button 
                    onclick="completeSale()" 
                    id="complete-sale-btn"
                    class="w-full mt-3 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold text-base shadow-lg disabled:bg-gray-300 disabled:cursor-not-allowed"
                    disabled
                >
                    <i data-lucide="check-circle" class="w-4 h-4 inline mr-2"></i>
                    <span id="complete-sale-text">Complete Sale</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Product Info Modal -->
<div id="product-info-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeProductModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800" id="modal-product-name">Product Information</h3>
                    <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-500">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <!-- Product Image -->
                    <div id="modal-product-image" class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden mb-4">
                        <i data-lucide="package" class="w-20 h-20 text-gray-300"></i>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Product Name</label>
                                <p class="mt-1 text-sm font-medium text-gray-800" id="modal-name"></p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">SKU</label>
                                <p class="mt-1 text-sm text-gray-800 font-mono" id="modal-sku"></p>
                            </div>
                            <div id="modal-barcode-section">
                                <label class="text-xs font-medium text-gray-500 uppercase">Barcode</label>
                                <p class="mt-1 text-sm text-gray-800 font-mono" id="modal-barcode"></p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Category</label>
                                <p class="mt-1 text-sm text-gray-800" id="modal-category"></p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Brand</label>
                                <p class="mt-1 text-sm text-gray-800" id="modal-brand"></p>
                            </div>
                            <div id="modal-model-section">
                                <label class="text-xs font-medium text-gray-500 uppercase">Model</label>
                                <p class="mt-1 text-sm text-gray-800" id="modal-model"></p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Cost Price</label>
                                <p class="mt-1 text-sm text-gray-800" id="modal-cost-price"></p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Selling Price</label>
                                <p class="mt-1 text-sm font-semibold text-primary-600" id="modal-selling-price"></p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Quantity in Stock</label>
                                <p class="mt-1">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full" id="modal-quantity-badge"></span>
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Reorder Level</label>
                                <p class="mt-1 text-sm text-gray-800" id="modal-reorder-level"></p>
                            </div>
                            <div id="modal-warranty-section">
                                <label class="text-xs font-medium text-gray-500 uppercase">Warranty</label>
                                <p class="mt-1 text-sm text-gray-800" id="modal-warranty"></p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                                <p class="mt-1" id="modal-status"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div id="modal-description-section" class="pt-3 border-t border-gray-200">
                        <label class="text-xs font-medium text-gray-500 uppercase">Description</label>
                        <p class="mt-1 text-sm text-gray-700" id="modal-description"></p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 border-t border-gray-200 flex gap-3">
                        <button
                            onclick="addToCartFromModal(); closeProductModal();"
                            id="modal-add-to-cart-btn"
                            class="flex-1 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium flex items-center justify-center gap-2"
                        >
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            Add to Cart
                        </button>
                        <button
                            onclick="closeProductModal()"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirm-sale-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeConfirmModal()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="w-6 h-6 text-primary-600"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Complete Sale</h3>
                        <p class="text-sm text-gray-600 mb-4">Are you sure you want to complete this sale?</p>
                        <div class="bg-gray-50 rounded-lg p-3 mb-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Items:</span>
                                <span class="font-medium text-gray-800" id="confirm-items-count"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Amount:</span>
                                <span class="font-semibold text-primary-600" id="confirm-total-amount"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Amount Paid:</span>
                                <span class="font-medium text-gray-800" id="confirm-amount-paid"></span>
                            </div>
                            <div class="flex justify-between text-sm" id="confirm-balance-row" style="display: none;">
                                <span class="text-gray-600">Balance:</span>
                                <span class="font-medium" id="confirm-balance"></span>
                            </div>
                            <div class="flex justify-between text-sm pt-2 border-t border-gray-200">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="font-medium text-gray-800 capitalize" id="confirm-payment-method"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Payment Status:</span>
                                <span class="font-medium capitalize" id="confirm-payment-status"></span>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button onclick="proceedWithSale()" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition-colors">
                                <i data-lucide="check" class="w-4 h-4 inline mr-1"></i>
                                Confirm
                            </button>
                            <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeSuccessModal()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                        <i data-lucide="check-circle" class="w-10 h-10 text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Sale Completed Successfully!</h3>
                    <p class="text-sm text-gray-600 mb-1">Sale ID: <span class="font-medium text-primary-600" id="success-sale-id"></span></p>
                    <p class="text-sm text-gray-500 mb-6">The sale has been processed and items have been updated in stock.</p>
                    <div class="flex gap-2 w-full">
                        <a id="download-receipt-btn" href="#" target="_blank" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            Download Receipt
                        </a>
                        <button onclick="closeSuccessModal()" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition-colors">
                            Continue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="error-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeErrorModal()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                        <i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Error</h3>
                        <p class="text-sm text-gray-600 mb-4" id="error-message"></p>
                        <button onclick="closeErrorModal()" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const products = @json($productsJson);
    const taxPercentage = {{ $taxPercentage }} / 100; // Convert percentage to decimal
    let cart = [];
    let paymentMethod = 'cash';
    let amountPaid = 0;
    let balance = 0;
    let paymentStatus = 'pending';

    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        
        // Set default payment method
        setPaymentMethod('cash');
        
        // Initialize payment amount input
        const amountPaidInput = document.getElementById('amount-paid-input');
        amountPaidInput.addEventListener('focus', function() {
            // Select all text for easy replacement
            this.select();
        });
        
        // Allow Enter key to pay full amount
        amountPaidInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const total = parseFloat(document.getElementById('cart-total').textContent.replace(/[^\d.]/g, '')) || 0;
                if (total > 0 && (this.value === '0' || this.value === '')) {
                    payFullAmount();
                } else {
                    calculatePaymentDetails();
                }
            }
        });
        
        // Initialize searchable selects
        initializeSearchableSelects();
        
        // Auto-search functionality with AJAX - declare variables first
        const searchInput = document.getElementById('product-search');
        const searchLoading = document.getElementById('search-loading');
        const clearAllBtn = document.getElementById('clear-all-btn');
        const productsGrid = document.getElementById('products-grid');
        const noProducts = document.getElementById('no-products');
        let searchTimeout;

        function performSearch() {
            const searchTerm = searchInput.value.trim();
            const categoryId = document.getElementById('category-filter').value;
            const brandId = document.getElementById('brand-filter').value;

            // Mark that we've performed a search
            productsGrid.setAttribute('data-searched', 'true');

            // Show loading indicator
            if (searchLoading) searchLoading.classList.remove('hidden');
            if (searchInput) searchInput.classList.add('opacity-50');

            // Build query parameters
            const params = new URLSearchParams();
            if (searchTerm) params.append('search', searchTerm);
            if (categoryId) params.append('category_id', categoryId);
            if (brandId) params.append('brand_id', brandId);

            // Fetch search results
            fetch(`{{ route('admin.pos.search') }}?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('HTTP error response:', text);
                        throw new Error(`HTTP error! status: ${response.status} - ${text.substring(0, 200)}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                // Hide loading indicator
                if (searchLoading) searchLoading.classList.add('hidden');
                if (searchInput) searchInput.classList.remove('opacity-50');

                // Check if data and products exist
                if (!data || !Array.isArray(data.products)) {
                    showNoProducts();
                    return;
                }

                // Update products grid
                updateProductsGrid(data.products, data.total || data.products.length);
                updateClearButton();
            })
            .catch(error => {
                console.error('Search error:', error);
                if (searchLoading) searchLoading.classList.add('hidden');
                if (searchInput) searchInput.classList.remove('opacity-50');
                showNoProducts();
            });
        }

        function updateProductsGrid(productsData, total) {
            if (productsData.length === 0) {
                showNoProducts();
                return;
            }

            // Update the products array for cart functionality (merge with initial products if needed)
            const updatedProducts = productsData.map(p => ({
                id: p.id,
                name: p.name,
                sku: p.sku,
                barcode: p.barcode,
                selling_price: p.selling_price,
                quantity: p.quantity,
                image: p.image,
                category_id: p.category_id,
                category_name: p.category_name,
                brand_id: p.brand_id,
                brand_name: p.brand_name,
                model_id: p.model_id,
                model_name: p.model_name,
            }));
            
            // Update window.products for cart functionality
            window.products = updatedProducts;
            
            // Also update the original products array if it exists
            if (typeof products !== 'undefined') {
                products.length = 0;
                products.push(...updatedProducts);
            }

            let gridHTML = '';
            productsData.forEach(product => {
                const productData = {
                    id: product.id,
                    name: product.name,
                    sku: product.sku,
                    barcode: product.barcode,
                    description: product.description,
                    cost_price: product.cost_price,
                    selling_price: product.selling_price,
                    quantity: product.quantity,
                    reorder_level: product.reorder_level,
                    serial_number: product.serial_number,
                    warranty_months: product.warranty_months,
                    status: product.status,
                    image: product.image,
                    category: product.category_name,
                    brand: product.brand_name,
                    model: product.model_name,
                };

                const stockBadge = product.quantity <= 0 
                    ? '<div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><span class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded">Out of Stock</span></div>'
                    : product.quantity <= product.reorder_level 
                        ? '<div class="absolute top-2 right-2"><span class="px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded">Low Stock</span></div>'
                        : '';

                const imageHTML = product.image 
                    ? `<img src="${product.image}" alt="${product.name}" class="w-full h-40 object-cover">`
                    : '<div class="w-full h-40 bg-gray-100 flex items-center justify-center"><i data-lucide="package" class="w-12 h-12 text-gray-300"></i></div>';

                const costPriceStr = product.cost_price != null 
                    ? `${parseFloat(product.cost_price).toLocaleString('en-US', {maximumFractionDigits: 0})} UGX`
                    : '—';
                const sellingPriceStr = product.selling_price !== null 
                    ? `${parseFloat(product.selling_price).toLocaleString('en-US', {maximumFractionDigits: 0})} UGX`
                    : '—';

                gridHTML += `
                    <div 
                        class="product-card bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-primary-300 hover:shadow-md transition-all group"
                        data-product-id="${product.id}"
                        data-product-name="${product.name.toLowerCase()}"
                        data-product-sku="${product.sku.toLowerCase()}"
                        data-product-barcode="${(product.barcode || '').toLowerCase()}"
                        data-category-id="${product.category_id || ''}"
                        data-brand-id="${product.brand_id || ''}"
                        data-model-id="${product.model_id || ''}"
                        data-product-data='${JSON.stringify(productData).replace(/'/g, "&#39;")}'
                    >
                        <div class="relative">
                            ${imageHTML}
                            ${stockBadge}
                        </div>
                        <div class="p-3">
                            <h3 class="font-medium text-gray-800 mb-1 text-sm line-clamp-2 min-h-[2.5rem]">
                                ${product.name}
                            </h3>
                            <p class="text-xs text-gray-500 mb-1.5 font-mono">${product.sku}</p>
                            <div class="space-y-0.5 mb-3 text-sm">
                                <div class="text-gray-600">Cost: <span class="font-semibold text-gray-800">${costPriceStr}</span></div>
                                <div class="text-gray-600">Sell: <span class="font-bold text-primary-600">${sellingPriceStr}</span></div>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    onclick="showProductInfo(${product.id}); event.stopPropagation()"
                                    class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 transition-colors flex items-center justify-center gap-1"
                                >
                                    <i data-lucide="info" class="w-3 h-3"></i>
                                    Info
                                </button>
                                <button
                                    onclick="addToCart(${product.id}); event.stopPropagation()"
                                    class="flex-1 px-3 py-1.5 text-xs font-medium text-white bg-primary-500 rounded hover:bg-primary-600 transition-colors flex items-center justify-center gap-1"
                                    ${product.quantity <= 0 ? 'disabled' : ''}
                                >
                                    <i data-lucide="shopping-cart" class="w-3 h-3"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            productsGrid.innerHTML = gridHTML;
            productsGrid.style.display = 'grid';
            noProducts.classList.add('hidden');
            lucide.createIcons();
        }

        function showNoProducts() {
            // Only show "no products" if we've actually searched
            // Don't hide initial server-side products if AJAX hasn't loaded yet
            const hasSearched = productsGrid.getAttribute('data-searched') === 'true';
            if (hasSearched) {
                productsGrid.style.display = 'none';
                noProducts.classList.remove('hidden');
            }
        }

        // Real-time search with debouncing
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch();
            }, 300); // Wait 300ms after user stops typing
        });

        // Prevent form submission on Enter key in search input
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                performSearch();
            }
        });
        
        // Filter change handlers
        document.getElementById('category-filter').addEventListener('change', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch();
            }, 300);
        });
        document.getElementById('brand-filter').addEventListener('change', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch();
            }, 300);
        });
        
        // Load initial products on page load (after all functions are defined)
        // Use a small delay to ensure all elements are ready
        setTimeout(() => {
            performSearch();
        }, 100);
        
        // Barcode scanner auto-add to cart
        let barcodeTimeout;
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && this.value.length >= 3) {
                e.preventDefault();
                clearTimeout(barcodeTimeout);
                barcodeTimeout = setTimeout(() => {
                    // Search for product by barcode or SKU
                    const searchValue = this.value.trim();
                    fetch(`{{ route('admin.pos.search') }}?search=${encodeURIComponent(searchValue)}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.products && data.products.length > 0) {
                            // Find exact match by barcode or SKU
                            const product = data.products.find(p => 
                                (p.barcode && p.barcode.toLowerCase() === searchValue.toLowerCase()) || 
                                (p.sku && p.sku.toLowerCase() === searchValue.toLowerCase())
                            ) || data.products[0]; // Fallback to first result
                            
                            if (product) {
                                addToCart(product.id);
                                this.value = '';
                                performSearch();
                                updateClearButton();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Barcode search error:', error);
                    });
                }, 100);
            }
        });
    });

    // Legacy function kept for compatibility but now uses AJAX search
    function applyFilters() {
        performSearch();
    }

    function updateClearButton() {
        const searchTerm = document.getElementById('product-search').value.trim();
        const categoryId = document.getElementById('category-filter').value;
        const brandId = document.getElementById('brand-filter').value;
        const clearAllBtn = document.getElementById('clear-all-btn');
        
        if (searchTerm !== '' || categoryId !== '' || brandId !== '') {
            clearAllBtn.style.display = 'flex';
        } else {
            clearAllBtn.style.display = 'none';
        }
    }

    function clearAllFilters() {
        document.getElementById('product-search').value = '';
        document.getElementById('category-filter').value = '';
        document.getElementById('brand-filter').value = '';
        
        // Update searchable select displays
        document.querySelectorAll('.searchable-select-container').forEach(container => {
            const selectedText = container.querySelector('.selected-text');
            const selectId = container.getAttribute('data-select-id');
            const originalSelect = document.getElementById(selectId);
            
            if (selectId === 'category-filter') {
                selectedText.textContent = 'All Categories';
            } else if (selectId === 'brand-filter') {
                selectedText.textContent = 'All Brands';
                selectedText.innerHTML = 'All Brands';
            } else if (selectId === 'customer-select') {
                selectedText.textContent = 'Walk-in Customer';
            }
            
            selectedText.classList.remove('text-gray-900');
            selectedText.classList.add('text-gray-500');
        });
        
        // Trigger search to reload all products
        clearTimeout(searchTimeout);
        performSearch();
        document.getElementById('product-search').focus();
    }

    function addToCart(productId) {
        // Use window.products if available (from AJAX search), otherwise fallback to initial products
        const productsArray = window.products || products;
        const product = productsArray.find(p => p.id === productId);
        if (!product) {
            console.error('Product not found:', productId);
            return;
        }

        const existingItem = cart.find(item => item.product_id === productId);
        if (existingItem) {
            if (existingItem.quantity < product.quantity) {
                existingItem.quantity++;
                existingItem.subtotal = existingItem.quantity * existingItem.unit_price;
            } else {
                showErrorModal(`Only ${product.quantity} units available in stock for ${product.name}.`);
                return;
            }
        } else {
            cart.push({
                product_id: productId,
                name: product.name,
                sku: product.sku,
                unit_price: product.selling_price,
                quantity: 1,
                subtotal: product.selling_price,
            });
        }

        updateCartDisplay();
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCartDisplay();
    }

    function updateQuantity(index, change) {
        const item = cart[index];
        const productsArray = window.products || products;
        const product = productsArray.find(p => p.id === item.product_id);
        
        const newQuantity = item.quantity + change;
        if (newQuantity < 1) {
            removeFromCart(index);
            return;
        }
        if (newQuantity > product.quantity) {
            showErrorModal(`Only ${product.quantity} units available in stock.`);
            return;
        }
        
        item.quantity = newQuantity;
        item.subtotal = item.quantity * item.unit_price;
        updateCartDisplay();
    }

    function clearCart() {
        if (confirm('Are you sure you want to clear the cart?')) {
            cart = [];
            updateCartDisplay();
        }
    }

    function showConfirmModal() {
        const itemsCount = cart.reduce((sum, item) => sum + item.quantity, 0);
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const discount = parseFloat(document.getElementById('discount-input').value) || 0;
        const taxableAmount = Math.max(0, subtotal - discount);
        const tax = taxableAmount * taxPercentage;
        const finalAmount = subtotal - discount + tax;
        
        // Recalculate payment details
        calculatePaymentDetails();

        document.getElementById('confirm-items-count').textContent = itemsCount + ' items';
        document.getElementById('confirm-total-amount').textContent = formatCurrency(finalAmount);
        document.getElementById('confirm-payment-method').textContent = paymentMethod.replace('_', ' ');
        document.getElementById('confirm-amount-paid').textContent = formatCurrency(amountPaid);
        
        // Show/hide balance row and style it
        const balanceRow = document.getElementById('confirm-balance-row');
        const balanceElement = document.getElementById('confirm-balance');
        if (balance > 0) {
            balanceRow.style.display = 'flex';
            balanceElement.textContent = formatCurrency(balance);
            balanceElement.className = 'font-medium text-orange-600';
        } else if (amountPaid > 0) {
            balanceRow.style.display = 'flex';
            balanceElement.textContent = formatCurrency(0);
            balanceElement.className = 'font-medium text-green-600';
        } else {
            balanceRow.style.display = 'none';
        }
        
        // Set payment status with appropriate styling
        const statusElement = document.getElementById('confirm-payment-status');
        statusElement.textContent = paymentStatus.charAt(0).toUpperCase() + paymentStatus.slice(1);
        if (paymentStatus === 'completed') {
            statusElement.className = 'font-medium capitalize text-green-600';
        } else if (paymentStatus === 'partial') {
            statusElement.className = 'font-medium capitalize text-orange-600';
        } else {
            statusElement.className = 'font-medium capitalize text-yellow-600';
        }
        
        document.getElementById('confirm-sale-modal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirm-sale-modal').classList.add('hidden');
    }

    function proceedWithSale() {
        // Safety check
        if (!cart || cart.length === 0) {
            showErrorModal('Cart is empty. Please add items before completing the sale.');
            return;
        }

        const customerSelect = document.getElementById('customer-select');
        const customerId = customerSelect ? customerSelect.value || null : null;
        const discount = parseFloat(document.getElementById('discount-input').value) || 0;
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const taxableAmount = Math.max(0, subtotal - discount);
        const tax = taxableAmount * taxPercentage;
        const finalAmount = subtotal - discount + tax;

        // Ensure cart items have the correct structure
        const items = cart.map(item => {
            if (!item.product_id || !item.quantity || !item.unit_price) {
                console.error('Invalid cart item:', item);
                return null;
            }
            return {
                product_id: parseInt(item.product_id),
                quantity: parseInt(item.quantity),
                unit_price: parseFloat(item.unit_price),
                subtotal: parseFloat(item.subtotal)
            };
        }).filter(item => item !== null);

        if (items.length === 0) {
            showErrorModal('No valid items in cart. Please check your cart.');
            return;
        }

        // Get current payment values from input
        const currentAmountPaid = parseFloat(document.getElementById('amount-paid-input').value) || 0;
        const currentBalance = Math.max(0, finalAmount - currentAmountPaid);
        
        // Determine payment status based on amount paid
        let status = 'pending';
        if (currentAmountPaid === 0) {
            status = 'pending';
        } else if (currentBalance > 0) {
            status = 'partial';
        } else {
            status = 'completed';
        }

        // Build sale data object
        const saleData = {
            customer_id: customerId || null,
            items: items,
            total_amount: subtotal,
            discount: discount,
            tax: tax,
            final_amount: finalAmount,
            amount_paid: parseFloat(currentAmountPaid.toFixed(2)),
            balance: parseFloat(currentBalance.toFixed(2)),
            payment_method: paymentMethod,
            payment_status: status
        };

        console.log('Sending sale data:', saleData);
        console.log('Cart:', cart);
        console.log('Items:', items);

        closeConfirmModal();

        // Stringify the data right before sending
        const jsonBody = JSON.stringify(saleData);
        console.log('JSON body:', jsonBody);

        fetch('{{ route("admin.pos.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: jsonBody
        })
        .then(response => {
            // Check if response is actually JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                return response.text().then(text => {
                    console.error('Non-JSON response:', text);
                    throw new Error('Server returned an error page instead of JSON. Please check the console for details.');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('success-sale-id').textContent = '#' + data.sale_id;
                // Set receipt download link
                const receiptUrl = '{{ route("admin.sales.receipt.download", ":id") }}'.replace(':id', data.sale_id);
                document.getElementById('download-receipt-btn').href = receiptUrl;
                document.getElementById('success-modal').classList.remove('hidden');
                
                cart = [];
                updateCartDisplay();
                if (customerSelect) customerSelect.value = '';
                document.getElementById('discount-input').value = '0';
                document.getElementById('amount-paid-input').value = '0';
                amountPaid = 0;
                balance = 0;
                paymentStatus = 'pending';
                calculateTotal();
                calculatePaymentDetails();
                setPaymentMethod('cash');
                document.getElementById('product-search').focus();
            } else {
                showErrorModal(data.message || 'An error occurred while processing the sale.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorModal(error.message || 'An error occurred. Please try again.');
        });
    }

    function closeSuccessModal() {
        document.getElementById('success-modal').classList.add('hidden');
    }

    function showErrorModal(message) {
        document.getElementById('error-message').textContent = message;
        document.getElementById('error-modal').classList.remove('hidden');
    }

    function closeErrorModal() {
        document.getElementById('error-modal').classList.add('hidden');
    }

    function updateCartDisplay() {
        const emptyCart = document.getElementById('empty-cart');
        const cartItems = document.getElementById('cart-items');
        const clearBtn = document.getElementById('clear-cart-btn');
        const completeBtn = document.getElementById('complete-sale-btn');

        if (cart.length === 0) {
            emptyCart.style.display = 'block';
            cartItems.style.display = 'none';
            clearBtn.style.display = 'none';
            completeBtn.disabled = true;
            // Reset payment fields when cart is empty
            document.getElementById('amount-paid-input').value = '0';
            calculatePaymentDetails();
        } else {
            emptyCart.style.display = 'none';
            cartItems.style.display = 'block';
            clearBtn.style.display = 'block';
            completeBtn.disabled = false;

            cartItems.innerHTML = cart.map((item, index) => `
                <div class="bg-white border border-gray-200 rounded-lg p-3">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 text-sm">${item.name}</h4>
                            <p class="text-xs text-gray-500 font-mono">${item.sku}</p>
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-600">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <button onclick="updateQuantity(${index}, -1)" class="w-6 h-6 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100">
                                <i data-lucide="minus" class="w-3 h-3"></i>
                            </button>
                            <span class="w-8 text-center text-sm font-medium">${item.quantity}</span>
                            <button onclick="updateQuantity(${index}, 1)" class="w-6 h-6 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100">
                                <i data-lucide="plus" class="w-3 h-3"></i>
                            </button>
                        </div>
                        <span class="font-semibold text-gray-800">${formatCurrency(item.subtotal)}</span>
                    </div>
                </div>
            `).join('');

            lucide.createIcons();
        }

        calculateTotal();
    }

    function calculateTotal() {
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const discount = parseFloat(document.getElementById('discount-input').value) || 0;
        const taxableAmount = Math.max(0, subtotal - discount);
        const tax = taxableAmount * taxPercentage;
        const total = subtotal - discount + tax;

        document.getElementById('cart-subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('cart-tax').textContent = formatCurrency(tax);
        document.getElementById('cart-total').textContent = formatCurrency(total);
        
        // Recalculate payment details when total changes
        calculatePaymentDetails();
    }

    function calculatePaymentDetails() {
        const total = parseFloat(document.getElementById('cart-total').textContent.replace(/[^\d.]/g, '')) || 0;
        amountPaid = parseFloat(document.getElementById('amount-paid-input').value) || 0;
        balance = Math.max(0, total - amountPaid);
        
        const balanceSection = document.getElementById('balance-section');
        const balanceContainer = document.getElementById('balance-container');
        const balanceAmount = document.getElementById('balance-amount');
        const balanceLabel = document.getElementById('balance-label');
        const balanceIcon = document.getElementById('balance-icon');
        const completeSaleText = document.getElementById('complete-sale-text');
        
        // Determine payment status
        if (amountPaid === 0) {
            paymentStatus = 'pending';
            balanceSection.classList.add('hidden');
            completeSaleText.textContent = 'Create Order (Pending Payment)';
        } else if (balance > 0) {
            paymentStatus = 'partial';
            balanceSection.classList.remove('hidden');
            balanceContainer.className = 'flex justify-between items-center p-2 rounded-lg bg-orange-50 border border-orange-200';
            balanceAmount.textContent = formatCurrency(balance);
            balanceAmount.className = 'text-base font-bold text-orange-700';
            balanceLabel.textContent = 'Balance:';
            balanceLabel.className = 'text-sm font-medium text-orange-700';
            balanceIcon.setAttribute('data-lucide', 'alert-triangle');
            balanceIcon.className = 'w-4 h-4 text-orange-600';
            completeSaleText.textContent = 'Create Order (Partial Payment)';
        } else {
            paymentStatus = 'completed';
            balanceSection.classList.remove('hidden');
            balanceContainer.className = 'flex justify-between items-center p-2 rounded-lg bg-green-50 border border-green-200';
            balanceAmount.textContent = formatCurrency(0);
            balanceAmount.className = 'text-base font-bold text-green-700';
            balanceLabel.textContent = 'Balance:';
            balanceLabel.className = 'text-sm font-medium text-green-700';
            balanceIcon.setAttribute('data-lucide', 'check-circle');
            balanceIcon.className = 'w-4 h-4 text-green-600';
            completeSaleText.textContent = 'Complete Sale';
        }
        
        // Auto-fill amount paid with total if user types more than total
        if (amountPaid > total && total > 0) {
            document.getElementById('amount-paid-input').value = total.toFixed(2);
            calculatePaymentDetails();
            return;
        }
        
        // Show/hide "Pay Full" button
        const payFullBtn = document.getElementById('pay-full-btn');
        if (total > 0 && amountPaid < total) {
            payFullBtn.style.display = 'flex';
        } else {
            payFullBtn.style.display = 'none';
        }
        
        lucide.createIcons();
    }

    function payFullAmount() {
        const total = parseFloat(document.getElementById('cart-total').textContent.replace(/[^\d.]/g, '')) || 0;
        if (total > 0) {
            document.getElementById('amount-paid-input').value = total.toFixed(2);
            calculatePaymentDetails();
            document.getElementById('amount-paid-input').focus();
        }
    }

    function setPaymentMethod(method) {
        paymentMethod = method;
        document.getElementById('payment-method').value = method;
        document.querySelectorAll('.payment-method-btn').forEach(btn => {
            if (btn.getAttribute('data-method') === method) {
                btn.classList.add('border-primary-500', 'bg-primary-50', 'text-primary-700');
                btn.classList.remove('border-gray-300');
            } else {
                btn.classList.remove('border-primary-500', 'bg-primary-50', 'text-primary-700');
                btn.classList.add('border-gray-300');
            }
        });
    }

    function completeSale() {
        if (cart.length === 0) {
            showErrorModal('Cart is empty. Please add items before completing the sale.');
            return;
        }

        showConfirmModal();
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-US').format(Math.round(amount)) + ' UGX';
    }

    let currentProductId = null;

    function showProductInfo(productId) {
        currentProductId = productId;
        const productCard = document.querySelector(`.product-card[data-product-id="${productId}"]`);
        if (!productCard) return;

        const productData = JSON.parse(productCard.getAttribute('data-product-data'));
        const modal = document.getElementById('product-info-modal');

        // Populate modal with product data
        document.getElementById('modal-product-name').textContent = productData.name;
        document.getElementById('modal-name').textContent = productData.name;
        document.getElementById('modal-sku').textContent = productData.sku || 'N/A';
        
        // Barcode
        const barcodeSection = document.getElementById('modal-barcode-section');
        if (productData.barcode) {
            document.getElementById('modal-barcode').textContent = productData.barcode;
            barcodeSection.style.display = 'block';
        } else {
            barcodeSection.style.display = 'none';
        }
        
        document.getElementById('modal-category').textContent = productData.category || 'N/A';
        document.getElementById('modal-brand').textContent = productData.brand || 'N/A';
        
        // Model
        const modelSection = document.getElementById('modal-model-section');
        if (productData.model) {
            document.getElementById('modal-model').textContent = productData.model;
            modelSection.style.display = 'block';
        } else {
            modelSection.style.display = 'none';
        }
        document.getElementById('modal-cost-price').textContent = formatCurrency(productData.cost_price || 0);
        document.getElementById('modal-selling-price').textContent = formatCurrency(productData.selling_price || 0);
        document.getElementById('modal-reorder-level').textContent = productData.reorder_level || '0';
        
        // Quantity badge
        const quantityBadge = document.getElementById('modal-quantity-badge');
        const quantity = productData.quantity || 0;
        const reorderLevel = productData.reorder_level || 0;
        quantityBadge.textContent = quantity;
        if (quantity === 0) {
            quantityBadge.className = 'px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700 border border-red-200';
        } else if (quantity <= reorderLevel) {
            quantityBadge.className = 'px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200';
        } else {
            quantityBadge.className = 'px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700 border border-green-200';
        }

        // Warranty
        const warrantySection = document.getElementById('modal-warranty-section');
        const warrantyDiv = document.getElementById('modal-warranty');
        if (productData.warranty_months) {
            warrantyDiv.textContent = `${productData.warranty_months} months`;
            warrantySection.style.display = 'block';
        } else {
            warrantySection.style.display = 'none';
        }

        // Status
        const statusDiv = document.getElementById('modal-status');
        const status = productData.status || 'active';
        statusDiv.innerHTML = `<span class="px-2 py-1 text-xs font-medium rounded-full ${status === 'active' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-700 border border-gray-200'}">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;

        // Description
        const descSection = document.getElementById('modal-description-section');
        const descDiv = document.getElementById('modal-description');
        if (productData.description) {
            descDiv.textContent = productData.description;
            descSection.style.display = 'block';
        } else {
            descSection.style.display = 'none';
        }

        // Product Image
        const imageDiv = document.getElementById('modal-product-image');
        if (productData.image) {
            imageDiv.innerHTML = `<img src="${productData.image}" alt="${productData.name}" class="w-full h-full object-cover">`;
        } else {
            imageDiv.innerHTML = '<i data-lucide="package" class="w-20 h-20 text-gray-300"></i>';
        }

        // Add to cart button state
        const addBtn = document.getElementById('modal-add-to-cart-btn');
        if (quantity <= 0) {
            addBtn.disabled = true;
            addBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
            addBtn.classList.remove('bg-primary-500', 'hover:bg-primary-600');
        } else {
            addBtn.disabled = false;
            addBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
            addBtn.classList.add('bg-primary-500', 'hover:bg-primary-600');
        }

        // Show modal
        modal.classList.remove('hidden');
        lucide.createIcons();
    }

    function closeProductModal() {
        document.getElementById('product-info-modal').classList.add('hidden');
        currentProductId = null;
    }

    function addToCartFromModal() {
        if (currentProductId) {
            addToCart(currentProductId);
        }
    }

    // Close modals on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (!document.getElementById('product-info-modal').classList.contains('hidden')) {
                closeProductModal();
            }
            if (!document.getElementById('confirm-sale-modal').classList.contains('hidden')) {
                closeConfirmModal();
            }
            if (!document.getElementById('success-modal').classList.contains('hidden')) {
                closeSuccessModal();
            }
            if (!document.getElementById('error-modal').classList.contains('hidden')) {
                closeErrorModal();
            }
        }
    });

    // Initialize Searchable Selects (similar to users/create.blade.php)
    function initializeSearchableSelects() {
        document.querySelectorAll('.searchable-select-container').forEach(container => {
            const selectId = container.getAttribute('data-select-id');
            const originalSelect = document.getElementById(selectId);
            const display = container.querySelector('.selected-display');
            const selectedText = display.querySelector('.selected-text');
            const dropdown = container.querySelector('.dropdown-container');
            const searchInput = dropdown.querySelector('.search-input');
            const options = dropdown.querySelectorAll('.option');
            const chevron = display.querySelector('i[data-lucide="chevron-down"]');

            // Set initial selected value
            const selectedOption = originalSelect.querySelector('option[selected]');
            if (selectedOption && selectedOption.value) {
                selectedText.textContent = selectedOption.textContent;
                selectedText.classList.remove('text-gray-500');
                selectedText.classList.add('text-gray-900');
            } else {
                selectedText.classList.add('text-gray-500');
            }

            // Toggle dropdown
            display.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = !dropdown.classList.contains('hidden');
                
                // Close all other dropdowns
                document.querySelectorAll('.dropdown-container').forEach(d => {
                    if (d !== dropdown) d.classList.add('hidden');
                });
                
                dropdown.classList.toggle('hidden');
                
                if (!dropdown.classList.contains('hidden')) {
                    searchInput.focus();
                    searchInput.value = '';
                    filterOptions();
                }
                
                // Rotate chevron - maintain vertical centering while rotating
                if (!dropdown.classList.contains('hidden')) {
                    chevron.style.transform = 'translateY(-50%) rotate(180deg)';
                } else {
                    chevron.style.transform = 'translateY(-50%) rotate(0deg)';
                }
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                filterOptions();
            });

            function filterOptions() {
                const searchTerm = searchInput.value.toLowerCase();
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    const searchText = option.getAttribute('data-search-text') || text;
                    
                    if (searchText.includes(searchTerm) || text.includes(searchTerm)) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            // Select option
            options.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    let text = this.querySelector('.font-medium') ? this.querySelector('.font-medium').textContent : this.textContent.trim();
                    
                    // Handle "No Brand" option specially
                    if (selectId === 'brand-filter' && value === 'null') {
                        text = 'No Brand';
                    }
                    
                    // Update original select
                    originalSelect.value = value;
                    
                    // Trigger change event
                    const changeEvent = new Event('change', { bubbles: true });
                    originalSelect.dispatchEvent(changeEvent);
                    
                    // Update display
                    if (selectId === 'customer-select' && value === '') {
                        selectedText.innerHTML = 'Walk-in Customer';
                    } else if (selectId === 'brand-filter' && value === 'null') {
                        selectedText.innerHTML = '<span class="text-gray-500 italic">No Brand</span>';
                    } else {
                        selectedText.textContent = text;
                    }
                    selectedText.classList.remove('text-gray-500');
                    selectedText.classList.add('text-gray-900');
                    
                    // Update option states
                    options.forEach(opt => {
                        opt.classList.remove('bg-primary-100', 'font-medium');
                        if (opt.getAttribute('data-value') === value) {
                            opt.classList.add('bg-primary-100');
                        }
                    });
                    
                    // Close dropdown
                    dropdown.classList.add('hidden');
                    chevron.style.transform = 'translateY(-50%) rotate(0deg)';
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!container.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    chevron.style.transform = 'translateY(-50%) rotate(0deg)';
                }
            });
        });
    }
</script>
@endsection
