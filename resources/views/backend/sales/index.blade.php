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
                        <span class="text-sm font-medium text-gray-500">Sales</span>
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
                <h1 class="text-xl font-semibold text-gray-800">Sales Management</h1>
                <div class="flex space-x-2">
                    <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back
                    </button>
                    <a href="{{ route('admin.pos.index') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        New Sale
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Sales</p>
                            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center">
                            <i data-lucide="shopping-cart" class="w-6 h-6 text-primary-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ number_format($stats['total_amount'], 0) }} UGX</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center">
                            <i data-lucide="dollar-sign" class="w-6 h-6 text-green-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Completed</p>
                            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stats['completed'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending</p>
                            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-yellow-50 flex items-center justify-center">
                            <i data-lucide="clock" class="w-6 h-6 text-yellow-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                <form method="GET" action="{{ route('admin.sales.index') }}" class="flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by Sale ID, Customer, or Cashier..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                >
                            </div>
                        </div>
                        <div class="sm:w-48">
                            <select
                                name="payment_method"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                                <option value="all">All Payment Methods</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                            </select>
                        </div>
                        <div class="sm:w-48">
                            <select
                                name="payment_status"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                                <option value="all">All Statuses</option>
                                <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="sm:w-40">
                            <button
                                type="submit"
                                class="w-full px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium"
                            >
                                Filter
                            </button>
                        </div>
                        @if(request()->hasAny(['search', 'payment_method', 'payment_status', 'start_date', 'end_date']))
                            <a
                                href="{{ route('admin.sales.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium border border-gray-300"
                            >
                                Clear
                            </a>
                        @endif
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="sm:w-48">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Start Date</label>
                            <input
                                type="date"
                                name="start_date"
                                value="{{ request('start_date') }}"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                        </div>
                        <div class="sm:w-48">
                            <label class="block text-xs font-medium text-gray-700 mb-1">End Date</label>
                            <input
                                type="date"
                                name="end_date"
                                value="{{ request('end_date') }}"
                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                            >
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sales Table -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                @if($sales->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                            <i data-lucide="shopping-cart" class="w-12 h-12 text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700">No sales found</h3>
                        <p class="mt-2 text-sm text-gray-500 text-center max-w-sm">
                            You don't have any sales yet. Create your first sale from the Point of Sale.
                        </p>
                        <a href="{{ route('admin.pos.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Create First Sale
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden md:table-cell">Customer</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden lg:table-cell">Cashier</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Date</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 hidden md:table-cell">Payment</th>
                                    <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Total</th>
                                    <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700 w-[120px]">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $index => $sale)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                                        <td class="py-3 px-4 text-sm text-gray-600">#{{ $sale->id }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 hidden md:table-cell">
                                            {{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-600 hidden lg:table-cell">
                                            {{ $sale->creator->name }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-600">
                                            {{ $sale->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="py-3 px-4 hidden md:table-cell">
                                            <div class="flex flex-col gap-1">
                                                <span class="text-xs text-gray-600 capitalize">{{ str_replace('_', ' ', $sale->payment_method) }}</span>
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full inline-block w-fit {{ $sale->payment_status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                    {{ ucfirst($sale->payment_status) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-sm text-right text-gray-800 font-semibold">
                                            {{ number_format($sale->final_amount, 0) }} UGX
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('admin.sales.show', $sale->id) }}" class="text-primary-500 hover:text-primary-600 transition-colors" title="View">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 px-4 py-3 border-t border-gray-200">
                        {{ $sales->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.alert-message').remove();
            });
        });
    });
</script>
@endsection
