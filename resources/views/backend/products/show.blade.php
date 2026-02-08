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
                        <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Products</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">View Product</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="container mx-auto py-6 px-4 sm:px-6">
            <!-- Product Header -->
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="px-4 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        @if($product->image)
                            <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-lg object-cover border-2 border-gray-200">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-primary-50 flex items-center justify-center border border-primary-200">
                                <i data-lucide="package" class="w-8 h-8 text-primary-500"></i>
                            </div>
                        @endif
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h1>
                            <div class="flex flex-wrap items-center mt-1 gap-2">
                                <span class="text-sm text-gray-500">ID: {{ $product->id }}</span>
                                <span class="text-sm text-gray-500">• SKU: {{ $product->sku }}</span>
                                @if($product->barcode)
                                    <span class="text-sm text-gray-500">• Barcode: {{ $product->barcode }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors">
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

            <!-- Product Details -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Product Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="package" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Basic Information
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Product Name</label>
                                        <p class="mt-1 text-sm text-gray-800 font-medium">{{ $product->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">SKU</label>
                                        <p class="mt-1 text-sm text-gray-800 font-mono">{{ $product->sku }}</p>
                                    </div>
                                    @if($product->barcode)
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Barcode</label>
                                        <p class="mt-1 text-sm text-gray-800 font-mono">{{ $product->barcode }}</p>
                                    </div>
                                    @endif
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Category</label>
                                        <p class="mt-1">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                                {{ $product->category->name }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Brand</label>
                                        <p class="mt-1">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-primary-100 text-primary-700 border border-primary-200">
                                                {{ $product->brand?->name ?? '—' }}
                                            </span>
                                        </p>
                                    </div>
                                    @if($product->productModel)
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Product Model</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $product->productModel->name }}</p>
                                    </div>
                                    @endif
                                    @if($product->description)
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Description</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $product->description }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Inventory -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="tag" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Pricing & Inventory
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Cost Price</label>
                                        <p class="mt-1 text-sm text-gray-800 font-medium">{{ number_format($product->cost_price, 0) }} UGX</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Selling Price</label>
                                        <p class="mt-1 text-sm text-gray-800 font-medium">{{ $product->selling_price !== null ? number_format($product->selling_price, 0) . ' UGX' : '—' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Quantity</label>
                                        <p class="mt-1">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $product->quantity <= $product->reorder_level ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-green-100 text-green-700 border border-green-200' }}">
                                                {{ $product->quantity }} {{ $product->quantity <= $product->reorder_level ? '(Low Stock)' : '' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Reorder Level</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $product->reorder_level }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                                        <p class="mt-1">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $product->status === 'active' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($product->serial_number || $product->warranty_months)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <i data-lucide="info" class="w-4 h-4 mr-2 text-primary-500"></i>
                            Additional Information
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($product->serial_number)
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Serial Number</label>
                                <p class="mt-1 text-sm text-gray-800 font-mono">{{ $product->serial_number }}</p>
                            </div>
                            @endif
                            @if($product->warranty_months)
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Warranty</label>
                                <p class="mt-1 text-sm text-gray-800">{{ $product->warranty_months }} months</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <i data-lucide="clock" class="w-4 h-4 mr-2 text-primary-500"></i>
                            Timestamps
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Created At</label>
                                <p class="mt-1 text-sm text-gray-800">{{ $product->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-800">{{ $product->updated_at->format('M d, Y H:i') }}</p>
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
        // Initialize Lucide icons
        lucide.createIcons();
    });
</script>
@endsection
