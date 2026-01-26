@extends('frontend.layouts.app')

@section('title', 'Dashboard - Apex Electronics & Accessories')

@section('content')
    @if (session('success'))
        <div class="alert bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative mb-4 flex justify-between items-center mx-auto max-w-7xl" role="alert" id="success-alert">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                {{ session('success') }}
            </div>
            <button type="button" class="text-green-800 hover:text-green-600" aria-label="Close" onclick="document.getElementById('success-alert').remove()">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
    @elseif(session('error'))
        <div class="alert bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded relative mb-4 flex justify-between items-center mx-auto max-w-7xl" role="alert" id="error-alert">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-2"></i>
                {{ session('error') }}
            </div>
            <button type="button" class="text-red-800 hover:text-red-600" aria-label="Close" onclick="document.getElementById('error-alert').remove()">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900">Dashboard</span>
            </div>
        </div>
    </nav>

    <!-- Dashboard Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Navigation -->
                <div class="lg:w-1/4">
                    <nav class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h5 class="text-xl font-semibold mb-6 text-gray-900">Navigation</h5>
                        <ul class="space-y-2">
                            <li>
                                <a href="#dashboard" onclick="showTab('dashboard')" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors tab-link active">
                                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="#order-history" onclick="showTab('order-history')" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors tab-link">
                                    <i data-lucide="package" class="w-5 h-5 mr-3"></i>
                                    <span class="font-medium">Order History</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.wishlists.index') ?? route('wishlist.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i data-lucide="heart" class="w-5 h-5 mr-3"></i>
                                    <span class="font-medium">Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.account-setting') ?? route('frontend.dashboard.account-settings') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                                    <span class="font-medium">Settings</span>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="inline w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center p-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                                        <span class="font-medium">Sign Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="lg:w-3/4">
                    <!-- Dashboard Tab -->
                    <div id="dashboard-tab" class="tab-content">
                        <!-- Order Statistics -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div class="bg-white rounded-lg shadow-md p-6 text-center transition transform hover:shadow-lg">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="package" class="w-6 h-6 text-primary-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Orders</h3>
                                <p class="text-2xl font-bold text-primary-600 mb-1">{{ $totalOrders ?? 0 }}</p>
                                <p class="text-sm text-gray-500">All your total orders</p>
                            </div>
                            
                            <div class="bg-white rounded-lg shadow-md p-6 text-center transition transform hover:shadow-lg">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="dollar-sign" class="w-6 h-6 text-green-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Amount</h3>
                                <p class="text-2xl font-bold text-green-600 mb-1">UGX {{ number_format($totalAmount ?? 0, 0) }}</p>
                                <p class="text-sm text-gray-500">Total amount of your orders</p>
                            </div>
                            
                            <div class="bg-white rounded-lg shadow-md p-6 text-center transition transform hover:shadow-lg">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="calendar" class="w-6 h-6 text-blue-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Orders This Month</h3>
                                <p class="text-2xl font-bold text-blue-600 mb-1">{{ $ordersThisMonth ?? 0 }}</p>
                                <p class="text-sm text-gray-500">Orders made this month</p>
                            </div>
                            
                            <div class="bg-white rounded-lg shadow-md p-6 text-center transition transform hover:shadow-lg">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Pending Orders</h3>
                                <p class="text-2xl font-bold text-yellow-600 mb-1">{{ $pendingOrders ?? 0 }}</p>
                                <p class="text-sm text-gray-500">Orders with status pending</p>
                            </div>
                        </div>

                        <!-- User Profile and Billing -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- User Profile -->
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile</h3>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('assets/images/default-avatar.png') }}" alt="Profile" class="w-16 h-16 rounded-full object-cover">
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-900">{{ auth()->user()->first_name ?? '' }} {{ auth()->user()->last_name ?? '' }}</h5>
                                        <p class="text-sm text-gray-600">{{ auth()->user()->email ?? '' }}</p>
                                        <p class="text-sm text-gray-500">Customer</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Billing Address -->
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Billing and Shipping Address</h3>
                                @if(auth()->user()->shippingInfo)
                                    <div class="space-y-2 text-sm">
                                        <p class="font-medium text-gray-900">{{ auth()->user()->shippingInfo->first_name }} {{ auth()->user()->shippingInfo->last_name }}</p>
                                        <p class="text-gray-600">{{ auth()->user()->shippingInfo->street_address }}</p>
                                        <p class="text-gray-600">{{ auth()->user()->shippingInfo->city }}, {{ auth()->user()->shippingInfo->state_region }}</p>
                                        <p class="text-gray-600">{{ auth()->user()->shippingInfo->email }}</p>
                                        <p class="text-gray-600">{{ auth()->user()->shippingInfo->phone }}</p>
                                    </div>
                                @else
                                    <p class="text-sm text-red-600 mb-4">No shipping information available.</p>
                                    <a href="{{ route('customer.account-setting') ?? route('frontend.dashboard.account-settings') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors">
                                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                        Add Address
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order History Tab -->
                    <div id="order-history-tab" class="tab-content hidden">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Order History</h2>
                            
                            @if(isset($orders) && $orders->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->created_at->format('Y-m-d') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">UGX {{ number_format($order->total_amount ?? 0, 0) }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                            {{ ucfirst($order->status ?? 'Pending') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        <button class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                                                            <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                                                            Reorder
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <i data-lucide="package" class="w-24 h-24 mx-auto text-gray-300 mb-4"></i>
                                    <p class="text-gray-600">No orders found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Remove active class from all links
        document.querySelectorAll('.tab-link').forEach(link => {
            link.classList.remove('active', 'bg-primary-50', 'text-primary-600');
            link.classList.add('text-gray-700');
        });
        
        // Show selected tab
        const selectedTab = document.getElementById(tabName + '-tab');
        if (selectedTab) {
            selectedTab.classList.remove('hidden');
        }
        
        // Add active class to clicked link
        event.target.closest('.tab-link').classList.add('active', 'bg-primary-50', 'text-primary-600');
        event.target.closest('.tab-link').classList.remove('text-gray-700');
    }
</script>
@endsection
