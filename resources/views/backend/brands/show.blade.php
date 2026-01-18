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
                        <a href="{{ route('admin.brands.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Brands</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">View Brand</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="container mx-auto py-6 px-4 sm:px-6">
            <!-- Brand Header -->
            <div class="bg-white rounded-lg border border-gray-200 mb-4">
                <div class="px-4 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-primary-50 flex items-center justify-center border border-primary-200">
                            <i data-lucide="tag" class="w-8 h-8 text-primary-500"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">{{ $brand->name }}</h1>
                            <div class="flex flex-wrap items-center mt-1 gap-2">
                                <span class="text-sm text-gray-500">ID: {{ $brand->id }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors">
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

            <!-- Brand Details -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Brand Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="tag" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Basic Information
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Brand Name</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $brand->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Brand ID</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $brand->id }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="clock" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Timestamps
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Created At</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $brand->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Last Updated</label>
                                        <p class="mt-1 text-sm text-gray-800">{{ $brand->updated_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
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
