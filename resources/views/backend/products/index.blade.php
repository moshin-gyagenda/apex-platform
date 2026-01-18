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
                        <span class="text-sm font-medium text-gray-500">Products</span>
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
                <h1 class="text-xl font-semibold text-gray-800">Product Management</h1>
                <div class="flex space-x-2">
                    <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back
                    </button>
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Add New Product
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Products</p>
                            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center">
                            <i data-lucide="package" class="w-6 h-6 text-primary-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active</p>
                            <p class="text-2xl font-semibold text-green-600 mt-1">{{ $stats['active'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Inactive</p>
                            <p class="text-2xl font-semibold text-gray-600 mt-1">{{ $stats['inactive'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-gray-50 flex items-center justify-center">
                            <i data-lucide="x-circle" class="w-6 h-6 text-gray-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Low Stock</p>
                            <p class="text-2xl font-semibold text-red-600 mt-1">{{ $stats['low_stock'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-red-50 flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-red-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by name, SKU, or barcode..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                >
                            </div>
                        </div>
                        <div class="sm:w-48">
                            <select
                                name="category_id"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:w-48">
                            <select
                                name="brand_id"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:w-40">
                            <select
                                name="status"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium"
                        >
                            Filter
                        </button>
                        @if(request('search') || request('category_id') || request('brand_id') || request('status'))
                            <a
                                href="{{ route('admin.products.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium border border-gray-300"
                            >
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div id="products-content">
                    @if($products->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12">
                            <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <i data-lucide="package" class="w-12 h-12 text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700">No products found</h3>
                            <p class="mt-2 text-sm text-gray-500 text-center max-w-sm">
                                You don't have any products yet. Add your first product to get started.
                            </p>
                            <a href="{{ route('admin.products.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium">
                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                Add Your First Product
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-gray-50">
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Name</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden lg:table-cell">SKU</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden md:table-cell">Category</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden md:table-cell">Brand</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700 hidden lg:table-cell">Quantity</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700 hidden xl:table-cell">Price</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700">Status</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700 w-[120px]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $index => $product)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                                            <td class="py-3 px-4 text-sm text-gray-600">{{ $product->id }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center mr-3 border border-primary-100">
                                                        <i data-lucide="package" class="w-4 h-4 text-primary-500"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-sm text-gray-800">{{ $product->name }}</div>
                                                        <div class="text-xs text-gray-500 lg:hidden">{{ $product->sku }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 hidden lg:table-cell">
                                                <span class="font-mono text-xs">{{ $product->sku }}</span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 hidden md:table-cell">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                                    {{ $product->category->name }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 hidden md:table-cell">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-primary-100 text-primary-700 border border-primary-200">
                                                    {{ $product->brand->name }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-right hidden lg:table-cell">
                                                <span class="{{ $product->quantity <= $product->reorder_level ? 'text-red-600 font-semibold' : 'text-gray-800' }}">
                                                    {{ $product->quantity }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800 hidden xl:table-cell">
                                                {{ number_format($product->selling_price, 0) }} UGX
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $product->status === 'active' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-primary-500 hover:text-primary-600 transition-colors" title="Edit">
                                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.show', $product->id) }}" class="text-primary-500 hover:text-primary-600 transition-colors" title="View">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                    </a>
                                                    <button
                                                        type="button"
                                                        class="delete-button text-red-500 hover:text-red-600 transition-colors"
                                                        title="Delete"
                                                        data-product-id="{{ $product->id }}"
                                                        data-product-name="{{ $product->name }}">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 px-4 py-3 border-t border-gray-200">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Popup -->
    <div id="confirmation-popup" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg border border-gray-300 shadow-xl p-6 max-w-md w-full mx-4">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Delete Product</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete <span id="product-name-display" class="font-medium text-gray-800"></span>? This action cannot be undone.
                    </p>
                    <div class="mt-4 flex gap-3">
                        <button id="confirm-delete" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
                            Yes, Delete
                        </button>
                        <button id="cancel-delete" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
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

        // Close alert messages
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.alert-message').remove();
            });
        });

        // Delete confirmation popup
        let deleteFormId = null;
        const deleteButtons = document.querySelectorAll('.delete-button');
        const popup = document.getElementById('confirmation-popup');
        const productNameDisplay = document.getElementById('product-name-display');
        const confirmDeleteBtn = document.getElementById('confirm-delete');
        const cancelDeleteBtn = document.getElementById('cancel-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                deleteFormId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                productNameDisplay.textContent = productName;
                popup.classList.remove('hidden');
            });
        });

        confirmDeleteBtn.addEventListener('click', function() {
            if (deleteFormId) {
                document.getElementById('delete-form-' + deleteFormId).submit();
            }
        });

        cancelDeleteBtn.addEventListener('click', function() {
            popup.classList.add('hidden');
            deleteFormId = null;
        });

        // Close popup when clicking outside
        popup.addEventListener('click', function(e) {
            if (e.target === popup) {
                popup.classList.add('hidden');
                deleteFormId = null;
            }
        });
    });
</script>
@endsection
