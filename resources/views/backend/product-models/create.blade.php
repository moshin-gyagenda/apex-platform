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
                        <a href="{{ route('admin.product-models.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Product Models</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Create Product Model</span>
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
                <h1 class="text-xl font-semibold text-gray-800">Create New Product Model</h1>
                <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back
                </button>
            </div>

            <form action="{{ route('admin.product-models.store') }}" method="POST">
                @csrf
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">Product Model Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Enter the details for the new product model</p>
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
                                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Brand <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        name="brand_id"
                                        id="brand_id"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                        <option value="">Select a brand</option>
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
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Model Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        placeholder="e.g., iPhone 13, HP 840 G5"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="model_number" class="block text-sm font-medium text-gray-700 mb-1">
                                        Model Number
                                    </label>
                                    <input
                                        type="text"
                                        name="model_number"
                                        id="model_number"
                                        value="{{ old('model_number') }}"
                                        placeholder="e.g., A2482, 840 G5"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('model_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Specifications
                                </h4>
                                <button
                                    type="button"
                                    onclick="addSpecificationRow()"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 border border-primary-200 rounded-lg hover:bg-primary-100 transition-colors"
                                >
                                    <i data-lucide="plus" class="w-3 h-3 mr-1"></i>
                                    Add Specification
                                </button>
                            </div>
                            <div id="specifications-container" class="space-y-3">
                                <!-- Specification rows will be added here dynamically -->
                                @if(old('spec_key'))
                                    @foreach(old('spec_key') as $index => $key)
                                        <div class="specification-row flex gap-2 items-start">
                                            <input
                                                type="text"
                                                name="spec_key[]"
                                                value="{{ $key }}"
                                                placeholder="Key (e.g., Screen Size)"
                                                class="flex-1 py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                            >
                                            <input
                                                type="text"
                                                name="spec_value[]"
                                                value="{{ old('spec_value.' . $index) }}"
                                                placeholder="Value (e.g., 6.1 inches)"
                                                class="flex-1 py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                            >
                                            <button
                                                type="button"
                                                onclick="removeSpecificationRow(this)"
                                                class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Remove"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Click "Add Specification" to add more key-value pairs. Leave empty to skip.</p>
                            @error('specifications')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
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
                            Create Product Model
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

        // Add initial empty row if no specifications exist
        if (document.querySelectorAll('.specification-row').length === 0) {
            addSpecificationRow();
        }
    });

    function addSpecificationRow() {
        const container = document.getElementById('specifications-container');
        const row = document.createElement('div');
        row.className = 'specification-row flex gap-2 items-start';
        row.innerHTML = `
            <input
                type="text"
                name="spec_key[]"
                placeholder="Key (e.g., Screen Size)"
                class="flex-1 py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
            >
            <input
                type="text"
                name="spec_value[]"
                placeholder="Value (e.g., 6.1 inches)"
                class="flex-1 py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
            >
            <button
                type="button"
                onclick="removeSpecificationRow(this)"
                class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                title="Remove"
            >
                <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
        `;
        container.appendChild(row);
        lucide.createIcons();
    }

    function removeSpecificationRow(button) {
        button.closest('.specification-row').remove();
    }
</script>
@endsection
