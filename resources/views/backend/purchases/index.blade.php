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
                        <span class="text-sm font-medium text-gray-500">Purchases</span>
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
                <h1 class="text-xl font-semibold text-gray-800">Purchase Management</h1>
                <div class="flex flex-wrap gap-2">
                    <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back
                    </button>
                    <a href="{{ route('admin.purchases.export.excel', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-green-600 transition-colors">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 mr-2"></i>
                        Export Excel
                    </a>
                    <a href="{{ route('admin.purchases.export.pdf', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-600 transition-colors">
                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                        Export PDF
                    </a>
                    <a href="{{ route('admin.purchases.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Add New Purchase
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Purchases</p>
                            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center">
                            <i data-lucide="shopping-bag" class="w-6 h-6 text-primary-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Amount</p>
                            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ number_format($stats['total_amount'], 0) }} UGX</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center">
                            <i data-lucide="tag" class="w-6 h-6 text-green-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                <form method="GET" action="{{ route('admin.purchases.index') }}" class="flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by invoice number..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                >
                            </div>
                        </div>
                        <div class="sm:w-48">
                            <select
                                name="supplier_id"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                                <option value="">All Suppliers</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:w-40">
                            <input
                                type="date"
                                name="date_from"
                                value="{{ request('date_from') }}"
                                placeholder="From Date"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                        </div>
                        <div class="sm:w-40">
                            <input
                                type="date"
                                name="date_to"
                                value="{{ request('date_to') }}"
                                placeholder="To Date"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium"
                        >
                            Filter
                        </button>
                        @if(request('search') || request('supplier_id') || request('date_from') || request('date_to'))
                            <a
                                href="{{ route('admin.purchases.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium border border-gray-300"
                            >
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Purchases Table -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div id="purchases-content">
                    @if($purchases->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12">
                            <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <i data-lucide="shopping-bag" class="w-12 h-12 text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700">No purchases found</h3>
                            <p class="mt-2 text-sm text-gray-500 text-center max-w-sm">
                                You don't have any purchases yet. Add your first purchase to get started.
                            </p>
                            <a href="{{ route('admin.purchases.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium">
                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                Add Your First Purchase
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-gray-50">
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Invoice #</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden md:table-cell">Supplier</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden lg:table-cell">Date</th>
                                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Amount</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700 w-[120px]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchases as $index => $purchase)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                                            <td class="py-3 px-4 text-sm text-gray-600">{{ $purchase->id }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center mr-3 border border-primary-100">
                                                        <i data-lucide="file-text" class="w-4 h-4 text-primary-500"></i>
                                                    </div>
                                                    <div class="font-medium text-sm text-gray-800 font-mono">{{ $purchase->invoice_number }}</div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 hidden md:table-cell">
                                                {{ $purchase->supplier->name }}
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 hidden lg:table-cell">
                                                {{ $purchase->purchase_date->format('M d, Y') }}
                                            </td>
                                            <td class="py-3 px-4 text-sm text-right text-gray-800 font-medium">
                                                {{ number_format($purchase->total_amount, 0) }} UGX
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <a href="{{ route('admin.purchases.edit', $purchase->id) }}" class="text-primary-500 hover:text-primary-600 transition-colors" title="Edit">
                                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                                    </a>
                                                    <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="text-primary-500 hover:text-primary-600 transition-colors" title="View">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                    </a>
                                                    <button
                                                        type="button"
                                                        class="delete-button text-red-500 hover:text-red-600 transition-colors"
                                                        title="Delete"
                                                        data-purchase-id="{{ $purchase->id }}"
                                                        data-purchase-invoice="{{ $purchase->invoice_number }}">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $purchase->id }}" action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST" class="hidden">
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
                            {{ $purchases->appends(request()->query())->links() }}
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
                    <h3 class="text-lg font-semibold text-gray-800">Delete Purchase</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete purchase <span id="purchase-invoice-display" class="font-medium text-gray-800"></span>? This will also revert product quantities. This action cannot be undone.
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
        const purchaseInvoiceDisplay = document.getElementById('purchase-invoice-display');
        const confirmDeleteBtn = document.getElementById('confirm-delete');
        const cancelDeleteBtn = document.getElementById('cancel-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                deleteFormId = this.getAttribute('data-purchase-id');
                const purchaseInvoice = this.getAttribute('data-purchase-invoice');
                purchaseInvoiceDisplay.textContent = purchaseInvoice;
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
