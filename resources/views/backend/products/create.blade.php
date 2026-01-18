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
                        <span class="text-sm font-medium text-gray-500">Create Product</span>
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
                <h1 class="text-xl font-semibold text-gray-800">Create New Product</h1>
                <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back
                </button>
            </div>

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">Product Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Enter the details for the new product</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6 space-y-6">
                        <!-- Basic Information -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="package" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Basic Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <div class="searchable-select-container relative" data-select-id="category_id">
                                        <div class="selected-display mt-1 py-2 px-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-primary-500 transition focus-within:border-primary-500">
                                            <div class="selected-text text-gray-500">Select a category</div>
                                            <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                        </div>
                                        <div class="dropdown-container hidden absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
                                            <div class="p-2 sticky top-0 bg-white border-b border-gray-200">
                                                <input type="text" class="search-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500" placeholder="Search categories...">
                                            </div>
                                            <div class="options-list max-h-48 overflow-y-auto">
                                                <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="">Select a category</div>
                                                @foreach($categories as $category)
                                                    <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'data-selected="true"' : '' }}>
                                                        {{ $category->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <select id="category_id" name="category_id" class="hidden" required>
                                        <option value="" disabled selected>Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Brand <span class="text-red-500">*</span>
                                    </label>
                                    <div class="searchable-select-container relative" data-select-id="brand_id">
                                        <div class="selected-display mt-1 py-2 px-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-primary-500 transition focus-within:border-primary-500">
                                            <div class="selected-text text-gray-500">Select a brand</div>
                                            <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                        </div>
                                        <div class="dropdown-container hidden absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
                                            <div class="p-2 sticky top-0 bg-white border-b border-gray-200">
                                                <input type="text" class="search-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500" placeholder="Search brands...">
                                            </div>
                                            <div class="options-list max-h-48 overflow-y-auto">
                                                <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="">Select a brand</div>
                                                @foreach($brands as $brand)
                                                    <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'data-selected="true"' : '' }}>
                                                        {{ $brand->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <select id="brand_id" name="brand_id" class="hidden" required>
                                        <option value="" disabled selected>Select a brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="model_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Product Model
                                    </label>
                                    <div class="searchable-select-container relative" data-select-id="model_id">
                                        <div class="selected-display mt-1 py-2 px-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-primary-500 transition focus-within:border-primary-500">
                                            <div class="selected-text text-gray-500">Select a model (optional)</div>
                                            <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                        </div>
                                        <div class="dropdown-container hidden absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
                                            <div class="p-2 sticky top-0 bg-white border-b border-gray-200">
                                                <input type="text" class="search-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500" placeholder="Search models...">
                                            </div>
                                            <div class="options-list max-h-48 overflow-y-auto">
                                                <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="">Select a model (optional)</div>
                                                @foreach($productModels as $model)
                                                    <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="{{ $model->id }}" {{ old('model_id') == $model->id ? 'data-selected="true"' : '' }}>
                                                        {{ $model->name }} ({{ $model->brand->name }})
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <select id="model_id" name="model_id" class="hidden">
                                        <option value="" selected>Select a model (optional)</option>
                                        @foreach($productModels as $model)
                                            <option value="{{ $model->id }}" {{ old('model_id') == $model->id ? 'selected' : '' }}>
                                                {{ $model->name }} ({{ $model->brand->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('model_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Product Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        placeholder="e.g., Apple iPhone 13 128GB"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">
                                        SKU <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="sku"
                                        id="sku"
                                        value="{{ old('sku') }}"
                                        placeholder="e.g., IPH13-128GB-BLK"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('sku')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">
                                        Barcode
                                    </label>
                                    <input
                                        type="text"
                                        name="barcode"
                                        id="barcode"
                                        value="{{ old('barcode') }}"
                                        placeholder="e.g., 1234567890123"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('barcode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Description
                                </label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="3"
                                    placeholder="Enter product description..."
                                    class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Pricing Information -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="tag" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Pricing Information (UGX)
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cost Price <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="cost_price"
                                        id="cost_price"
                                        value="{{ old('cost_price') }}"
                                        step="0.01"
                                        min="0"
                                        placeholder="0"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('cost_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">
                                        Selling Price <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="selling_price"
                                        id="selling_price"
                                        value="{{ old('selling_price') }}"
                                        step="0.01"
                                        min="0"
                                        placeholder="0"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('selling_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Inventory Information -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="package" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Inventory Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                        Quantity <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="quantity"
                                        id="quantity"
                                        value="{{ old('quantity', 0) }}"
                                        min="0"
                                        placeholder="0"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-1">
                                        Reorder Level <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="reorder_level"
                                        id="reorder_level"
                                        value="{{ old('reorder_level', 0) }}"
                                        min="0"
                                        placeholder="0"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('reorder_level')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-1">
                                        Serial Number
                                    </label>
                                    <input
                                        type="text"
                                        name="serial_number"
                                        id="serial_number"
                                        value="{{ old('serial_number') }}"
                                        placeholder="e.g., SN-001"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('serial_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="info" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Additional Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="warranty_months" class="block text-sm font-medium text-gray-700 mb-1">
                                        Warranty (Months)
                                    </label>
                                    <input
                                        type="number"
                                        name="warranty_months"
                                        id="warranty_months"
                                        value="{{ old('warranty_months') }}"
                                        min="0"
                                        placeholder="e.g., 12"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('warranty_months')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        name="status"
                                        id="status"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="image" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Product Image <span class="text-gray-500 text-xs font-normal">(Optional)</span>
                            </h4>
                            <div>
                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    accept="image/*"
                                    class="hidden"
                                >
                                
                                <div class="relative">
                                    <!-- Image Preview -->
                                    <div id="image-preview-container" class="mb-4 hidden">
                                        <div class="relative inline-block">
                                            <img id="image-preview" alt="Preview" class="w-48 h-48 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                            <button
                                                type="button"
                                                id="remove-image-btn"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors"
                                            >
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                        <p id="image-name" class="mt-2 text-sm text-gray-600"></p>
                                    </div>

                                    <!-- Drag and Drop Area -->
                                    <div
                                        id="image-upload-area"
                                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-primary-400 hover:bg-gray-50 transition-colors"
                                    >
                                        <div id="upload-placeholder">
                                            <i data-lucide="upload-cloud" class="w-12 h-12 mx-auto text-gray-400 mb-3"></i>
                                            <p class="text-sm font-medium text-gray-700 mb-1">
                                                Click to upload or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF up to 2MB
                                            </p>
                                        </div>
                                        <div id="upload-change-text" class="hidden text-sm text-gray-600">
                                            <p class="mb-2">Click to change image</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                        <button type="button" onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                            Create Product
                        </button>
                    </div>
                </div>
            </form>
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

        // Modern Image Upload with Drag & Drop
        const imageInput = document.getElementById('image');
        const uploadArea = document.getElementById('image-upload-area');
        const imagePreview = document.getElementById('image-preview');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const imageName = document.getElementById('image-name');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const uploadChangeText = document.getElementById('upload-change-text');
        const removeImageBtn = document.getElementById('remove-image-btn');

        // Handle file selection
        function handleFileSelect(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imageName.textContent = file.name;
                    imagePreviewContainer.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                    uploadChangeText.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                lucide.createIcons();
            }
        }

        // Click to upload
        uploadArea.addEventListener('click', function() {
            imageInput.click();
        });

        // File input change
        imageInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFileSelect(this.files[0]);
            }
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary-500', 'bg-primary-50');
            e.dataTransfer.dropEffect = 'copy';
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary-500', 'bg-primary-50');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary-500', 'bg-primary-50');
            
            if (e.dataTransfer.files.length > 0) {
                handleFileSelect(e.dataTransfer.files[0]);
                // Update the file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(e.dataTransfer.files[0]);
                imageInput.files = dataTransfer.files;
            }
        });

        // Remove image
        removeImageBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            imageInput.value = '';
            imagePreviewContainer.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            uploadChangeText.classList.add('hidden');
            imagePreview.src = '';
            imageName.textContent = '';
        });

        // Initialize searchable selects
        initializeSearchableSelects();
    });

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
                
                // Rotate chevron
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
                    if (text.includes(searchTerm)) {
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
                    const text = this.textContent.trim();
                    
                    // Update original select
                    originalSelect.value = value;
                    
                    // Trigger change event
                    const changeEvent = new Event('change', { bubbles: true });
                    originalSelect.dispatchEvent(changeEvent);
                    
                    // Update display
                    selectedText.textContent = text;
                    selectedText.classList.remove('text-gray-500');
                    selectedText.classList.add('text-gray-900');
                    
                    // Update option states
                    options.forEach(opt => {
                        opt.classList.remove('bg-primary-100', 'font-medium');
                        if (opt.getAttribute('data-value') === value) {
                            opt.classList.add('bg-primary-100', 'font-medium');
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

            // Mark initially selected option
            const currentValue = originalSelect.value;
            options.forEach(opt => {
                if (opt.getAttribute('data-value') === currentValue || opt.getAttribute('data-selected') === 'true') {
                    opt.classList.add('bg-primary-100', 'font-medium');
                }
            });
        });
    }
</script>
@endsection
