@extends('backend.layouts.app')
@section('content')

<div class="p-4 sm:ml-64 mt-16 flex flex-col min-h-screen">
<!-- POS Header -->
    <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Point of Sale</h1>
            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full border border-green-200">
                Online
            </span>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs text-gray-500">Cashier</p>
                <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                <i data-lucide="arrow-left" class="w-4 h-4 inline mr-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="flex flex-1 overflow-hidden">
        <!-- Left Panel: Products -->
        <div class="w-2/3 flex flex-col border-r border-gray-200 bg-white overflow-hidden">
            <!-- Search and Filters -->
            <div class="p-3 border-b border-gray-200 bg-gray-50 flex-shrink-0">
                <div class="flex gap-2">
                    <div class="flex-1 relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input
                            type="text"
                            id="product-search"
                            placeholder="Product Name, SKU or Barcode..."
                            autofocus
                            class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-200"
                        >
                    </div>
                    <button 
                        type="button"
                        onclick="clearSearch()"
                        class="px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                        id="clear-search-btn"
                        style="display: none;"
                    >
                        Clear
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1 overflow-y-auto p-4">
                <div id="products-grid" class="grid grid-cols-4 gap-4">
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
        <div class="w-1/3 flex flex-col bg-gray-50 overflow-hidden">
            <!-- Customer Selection -->
            <div class="p-4 bg-white border-b border-gray-200 flex-shrink-0">
                <label class="block text-sm font-medium text-gray-700 mb-2">Customer (Optional)</label>
                <select id="customer-select" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
                    <option value="">Walk-in Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
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
                <div class="flex justify-between items-center pt-2">
                    <span class="text-lg font-semibold text-gray-800">Total:</span>
                    <span class="text-2xl font-bold text-primary-600" id="cart-total">0 UGX</span>
                </div>

                <!-- Payment Method -->
                <div class="pt-3 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button 
                            onclick="setPaymentMethod('cash')" 
                            class="payment-method-btn py-2 px-3 border-2 border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors text-sm font-medium"
                            data-method="cash"
                        >
                            Cash
                        </button>
                        <button 
                            onclick="setPaymentMethod('card')" 
                            class="payment-method-btn py-2 px-3 border-2 border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors text-sm font-medium"
                            data-method="card"
                        >
                            Card
                        </button>
                        <button 
                            onclick="setPaymentMethod('mobile_money')" 
                            class="payment-method-btn py-2 px-3 border-2 border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors text-sm font-medium"
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
                    class="w-full mt-4 py-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold text-lg shadow-lg disabled:bg-gray-300 disabled:cursor-not-allowed"
                    disabled
                >
                    <i data-lucide="check-circle" class="w-5 h-5 inline mr-2"></i>
                    Complete Sale
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
                        <div class="bg-gray-50 rounded-lg p-3 mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Items:</span>
                                <span class="font-medium text-gray-800" id="confirm-items-count"></span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Total:</span>
                                <span class="font-semibold text-primary-600" id="confirm-total-amount"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Payment:</span>
                                <span class="font-medium text-gray-800 capitalize" id="confirm-payment-method"></span>
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
                    <button onclick="closeSuccessModal()" class="w-full px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition-colors">
                        Continue
                    </button>
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

    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        
        // Set default payment method
        setPaymentMethod('cash');
        
        // Auto-search functionality
        const searchInput = document.getElementById('product-search');
        const clearBtn = document.getElementById('clear-search-btn');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            filterProducts(searchTerm);
            
            if (searchTerm.length > 0) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }
        });
        
        // Barcode scanner auto-add to cart
        let barcodeTimeout;
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && this.value.length >= 3) {
                e.preventDefault();
                clearTimeout(barcodeTimeout);
                barcodeTimeout = setTimeout(() => {
                    const product = products.find(p => 
                        p.barcode === this.value || 
                        p.sku === this.value
                    );
                    if (product) {
                        addToCart(product.id);
                        this.value = '';
                        filterProducts('');
                        clearBtn.style.display = 'none';
                    }
                }, 100);
            }
        });
    });

    function filterProducts(searchTerm) {
        const productCards = document.querySelectorAll('.product-card');
        const productsGrid = document.getElementById('products-grid');
        const noProducts = document.getElementById('no-products');
        let visibleCount = 0;

        productCards.forEach(card => {
            const name = card.getAttribute('data-product-name');
            const sku = card.getAttribute('data-product-sku');
            const barcode = card.getAttribute('data-product-barcode');
            
            if (searchTerm === '' || 
                name.includes(searchTerm) || 
                sku.includes(searchTerm) || 
                barcode.includes(searchTerm)) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0 && searchTerm !== '') {
            productsGrid.style.display = 'none';
            noProducts.classList.remove('hidden');
        } else {
            productsGrid.style.display = 'grid';
            noProducts.classList.add('hidden');
        }
    }

    function clearSearch() {
        const searchInput = document.getElementById('product-search');
        searchInput.value = '';
        filterProducts('');
        document.getElementById('clear-search-btn').style.display = 'none';
        searchInput.focus();
    }

    function addToCart(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

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
        const product = products.find(p => p.id === item.product_id);
        
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

    let pendingSaleData = null;

    function showConfirmModal() {
        const itemsCount = cart.reduce((sum, item) => sum + item.quantity, 0);
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const discount = parseFloat(document.getElementById('discount-input').value) || 0;
        const taxableAmount = Math.max(0, subtotal - discount);
        const tax = taxableAmount * taxPercentage;
        const finalAmount = subtotal - discount + tax;

        document.getElementById('confirm-items-count').textContent = itemsCount + ' items';
        document.getElementById('confirm-total-amount').textContent = formatCurrency(finalAmount);
        document.getElementById('confirm-payment-method').textContent = paymentMethod.replace('_', ' ');
        
        document.getElementById('confirm-sale-modal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirm-sale-modal').classList.add('hidden');
        pendingSaleData = null;
    }

    function proceedWithSale() {
        const customerId = document.getElementById('customer-select').value || null;
        const discount = parseFloat(document.getElementById('discount-input').value) || 0;
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const taxableAmount = Math.max(0, subtotal - discount);
        const tax = taxableAmount * taxPercentage;
        const finalAmount = subtotal - discount + tax;

        pendingSaleData = {
            customer_id: customerId,
            items: cart,
            total_amount: subtotal,
            discount: discount,
            tax: tax,
            final_amount: finalAmount,
            payment_method: paymentMethod,
            payment_status: 'completed',
            _token: '{{ csrf_token() }}'
        };

        closeConfirmModal();

        fetch('{{ route("admin.pos.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(pendingSaleData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('success-sale-id').textContent = '#' + data.sale_id;
                document.getElementById('success-modal').classList.remove('hidden');
                
                cart = [];
                updateCartDisplay();
                document.getElementById('customer-select').value = '';
                document.getElementById('discount-input').value = '0';
                calculateTotal();
                setPaymentMethod('cash');
                document.getElementById('product-search').focus();
            } else {
                showErrorModal(data.message || 'An error occurred while processing the sale.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorModal('An error occurred. Please try again.');
        });
    }

    function closeSuccessModal() {
        document.getElementById('success-modal').classList.add('hidden');
        pendingSaleData = null;
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
</script>
@endsection
