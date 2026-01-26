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
                        <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Categories</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Edit Category</span>
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
                <h1 class="text-xl font-semibold text-gray-800">Edit Category</h1>
                <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back
                </button>
            </div>

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">Category Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Update the category's information</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6 space-y-6">
                        <!-- Category Name -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="folder" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Category Details
                            </h4>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $category->name) }}"
                                    placeholder="Enter category name"
                                    required
                                    class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                >
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Category Image -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="image" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Category Image <span class="text-gray-500 text-xs font-normal">(Optional)</span>
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
                                    <!-- Current Image Preview -->
                                    @if($category->image)
                                        <div id="current-image-container" class="mb-4">
                                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                            <div class="relative inline-block">
                                                <img src="{{ str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image) }}" alt="Current Image" class="w-48 h-48 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Image Preview (for new upload) -->
                                    <div id="image-preview-container" class="mb-4 hidden">
                                        <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
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
                                                PNG, JPG, GIF, WEBP up to 2MB
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
                            Update Category
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
        const currentImageContainer = document.getElementById('current-image-container');

        // Handle file selection
        function handleFileSelect(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imageName.textContent = file.name;
                    imagePreviewContainer.classList.remove('hidden');
                    if (currentImageContainer) {
                        currentImageContainer.classList.add('hidden');
                    }
                    uploadPlaceholder.classList.add('hidden');
                    uploadChangeText.classList.remove('hidden');
                    lucide.createIcons();
                };
                reader.readAsDataURL(file);
            } else {
                alert('Please select a valid image file.');
            }
        }

        // Click to upload
        uploadArea.addEventListener('click', function() {
            imageInput.click();
        });

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleFileSelect(this.files[0]);
            }
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary-500', 'bg-primary-50');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary-500', 'bg-primary-50');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary-500', 'bg-primary-50');
            
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(e.dataTransfer.files[0]);
                imageInput.files = dataTransfer.files;
                handleFileSelect(e.dataTransfer.files[0]);
            }
        });

        // Remove image
        if (removeImageBtn) {
            removeImageBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                imageInput.value = '';
                imagePreviewContainer.classList.add('hidden');
                if (currentImageContainer) {
                    currentImageContainer.classList.remove('hidden');
                }
                uploadPlaceholder.classList.remove('hidden');
                uploadChangeText.classList.add('hidden');
                imagePreview.src = '';
                imageName.textContent = '';
            });
        }
    });
</script>
@endsection
