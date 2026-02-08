@extends('frontend.layouts.app')

@section('title', 'Dashboard - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gradient-to-r from-gray-50 to-white py-4 border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900 font-medium">Dashboard</span>
            </div>
        </div>
    </nav>

    <!-- Dashboard Section -->
    <section class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 mb-8 shadow-lg">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h1 class="font-semibold tracking-tight text-white -m -fs20 -elli flex items-center gap-3">
                        <i data-lucide="layout-dashboard" class="w-6 h-6"></i>
                        My Dashboard
                    </h1>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('frontend.index') }}" class="px-4 py-2 bg-white text-primary-600 rounded-xl hover:bg-gray-50 transition-colors text-sm font-medium shadow-md">
                            <i data-lucide="shopping-bag" class="w-4 h-4 inline mr-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
                <!-- Total Orders -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex flex-row items-center justify-between pb-3">
                        <h3 class="text-sm font-medium text-gray-500">Total Orders</h3>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                            <i data-lucide="package" class="w-6 h-6 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-2">{{ $stats['total_orders'] ?? 0 }}</div>
                    <div class="flex items-center pt-1 text-xs text-gray-500">
                        <i data-lucide="info" class="mr-1 w-4 h-4"></i>
                        <span>All your orders</span>
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex flex-row items-center justify-between pb-3">
                        <h3 class="text-sm font-medium text-gray-500">Total Spent</h3>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                            <i data-lucide="dollar-sign" class="w-6 h-6 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-2">{{ number_format($stats['total_amount'] ?? 0, 0) }} UGX</div>
                    <div class="flex items-center pt-1 text-xs {{ ($stats['amount_growth'] ?? 0) >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        <i data-lucide="{{ ($stats['amount_growth'] ?? 0) >= 0 ? 'trending-up' : 'trending-down' }}" class="mr-1 w-4 h-4"></i>
                        <span>{{ number_format(abs($stats['amount_growth'] ?? 0), 1) }}% from last month</span>
                    </div>
                </div>

                <!-- Orders This Month -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex flex-row items-center justify-between pb-3">
                        <h3 class="text-sm font-medium text-gray-500">Orders This Month</h3>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <i data-lucide="calendar" class="w-6 h-6 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-2">{{ $stats['orders_this_month'] ?? 0 }}</div>
                    <div class="flex items-center pt-1 text-xs text-gray-500">
                        <i data-lucide="calendar" class="mr-1 w-4 h-4"></i>
                        <span>{{ number_format($stats['monthly_amount'] ?? 0, 0) }} UGX spent</span>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex flex-row items-center justify-between pb-3">
                        <h3 class="text-sm font-medium text-gray-500">Pending Orders</h3>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center">
                            <i data-lucide="clock" class="w-6 h-6 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-2">{{ $stats['pending_orders'] ?? 0 }}</div>
                    <div class="flex items-center pt-1 text-xs {{ ($stats['pending_orders'] ?? 0) > 0 ? 'text-yellow-500' : 'text-green-500' }}">
                        <i data-lucide="{{ ($stats['pending_orders'] ?? 0) > 0 ? 'alert-triangle' : 'check-circle' }}" class="mr-1 w-4 h-4"></i>
                        <span>{{ ($stats['pending_orders'] ?? 0) > 0 ? 'Awaiting processing' : 'All processed' }}</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid gap-6 md:grid-cols-2 mb-6">
                <!-- Orders by Month Chart -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mb-4">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-white -m -fs20 -elli flex items-center gap-2">
                                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                                    Orders This Year
                                </h3>
                                <p class="text-primary-100 text-sm mt-1">Monthly order trend</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="ordersByMonthChart"></canvas>
                    </div>
                </div>

                <!-- Orders by Status Chart -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mb-4">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-white -m -fs20 -elli flex items-center gap-2">
                                    <i data-lucide="pie-chart" class="w-5 h-5"></i>
                                    Orders by Status
                                </h3>
                                <p class="text-primary-100 text-sm mt-1">Status distribution</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="ordersByStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders and Profile -->
            <div class="grid gap-6 md:grid-cols-7 mb-6">
                <!-- Recent Orders -->
                <div class="md:col-span-4 bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                    <div class="flex flex-row items-center justify-between mb-4">
                        <div>
                            <h3 class="font-semibold text-gray-900 -m -fs20 -elli">Recent Orders</h3>
                            <p class="text-base text-gray-500 mt-1">Latest transactions</p>
                        </div>
                        <a href="{{ route('frontend.orders.index') }}" class="px-3 py-1.5 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-100 transition-colors">
                            View All
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentOrders as $order)
                        <div class="flex items-center justify-between rounded-xl border border-gray-200 p-4 hover:bg-gradient-to-r hover:from-gray-50 hover:to-white transition-all shadow-sm hover:shadow-md">
                            <div class="space-y-1">
                                <p class="font-medium text-gray-900">Order #{{ $order->order_number ?? $order->id }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $order->orderItems->count() }} item(s) • {{ $order->created_at->format('M d, Y H:i') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">{{ number_format($order->total_amount ?? 0, 0) }} UGX</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($order->status == 'delivered') bg-green-100 text-green-800
                                    @elseif($order->status == 'processing') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status ?? 'Pending') }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-gray-500">
                            No recent orders found.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Profile & Address -->
                <div class="md:col-span-3 bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mb-4">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-white -m -fs20 -elli flex items-center gap-2">
                                    <i data-lucide="user" class="w-5 h-5"></i>
                                    Profile
                                </h3>
                                <p class="text-primary-100 text-sm mt-1">Your information</p>
                            </div>
                            <a href="{{ route('frontend.dashboard.account-settings') }}" class="px-3 py-1.5 bg-white text-primary-600 text-sm rounded-lg hover:bg-gray-50 transition-colors font-medium shadow-md">
                                Edit
                            </a>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ auth()->user()->profile_photo ? asset('assets/images/' . auth()->user()->profile_photo) : asset('assets/images/default-avatar.png') }}" 
                                 alt="Profile" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                            <div>
                                <p class="font-medium text-gray-900">{{ auth()->user()->first_name ?? '' }} {{ auth()->user()->last_name ?? '' }}</p>
                                <p class="text-sm text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                                <p class="text-xs text-gray-400">Customer</p>
                            </div>
                        </div>
                        @if(auth()->user()->shippingInfo)
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-900 mb-2">Shipping Address</p>
                            <p class="text-xs text-gray-600">{{ auth()->user()->shippingInfo->street_address }}</p>
                            <p class="text-xs text-gray-600">{{ auth()->user()->shippingInfo->city }}, {{ auth()->user()->shippingInfo->state_region }}</p>
                            <p class="text-xs text-gray-600">{{ auth()->user()->shippingInfo->phone }}</p>
                        </div>
                        @else
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-red-600 mb-2">No shipping address</p>
                            <a href="{{ route('frontend.dashboard.account-settings') }}" class="text-xs text-primary-600 hover:text-primary-700">
                                Add Address →
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Status Summary -->
            <div class="grid gap-6 md:grid-cols-3 mb-6">
                <!-- Processing Orders -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                    <div class="flex flex-row items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900 -m -fs20 -elli">Processing</h3>
                        <i data-lucide="refresh-cw" class="w-5 h-5 text-yellow-500"></i>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Orders</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['processing_orders'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delivered Orders -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                    <div class="flex flex-row items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900 -m -fs20 -elli">Delivered</h3>
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Orders</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['delivered_orders'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                    <div class="flex flex-row items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900 -m -fs20 -elli">Quick Actions</h3>
                        <i data-lucide="zap" class="w-5 h-5 text-primary-500"></i>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('frontend.wishlists.index') }}" class="block text-sm text-gray-700 hover:text-primary-600 transition-colors">
                            <i data-lucide="heart" class="w-4 h-4 inline mr-2"></i>
                            View Wishlist
                        </a>
                        <a href="{{ route('frontend.dashboard.account-settings') }}" class="block text-sm text-gray-700 hover:text-primary-600 transition-colors">
                            <i data-lucide="settings" class="w-4 h-4 inline mr-2"></i>
                            Account Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order History Tab (Hidden by default, shown when tab is clicked) -->
            <div id="order-history-tab" class="hidden">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mb-6">
                        <h2 class="font-semibold text-white -m -fs20 -elli flex items-center gap-2">
                            <i data-lucide="history" class="w-5 h-5"></i>
                            Order History
                        </h2>
                    </div>
                    
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->order_number ?? $order->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">UGX {{ number_format($order->total_amount ?? 0, 0) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($order->status ?? 'Pending') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('frontend.orders.show', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                                                    <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                                    View
                                                </a>
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
    </section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Set up color palette with primary theme
    const colors = [
        'rgba(59, 130, 246, 0.7)',   // Blue-500 (Primary)
        'rgba(16, 185, 129, 0.7)',   // Green-500
        'rgba(249, 115, 22, 0.7)',    // Orange-500
        'rgba(139, 92, 246, 0.7)',    // Purple-500
        'rgba(239, 68, 68, 0.7)',     // Red-500
        'rgba(245, 158, 11, 0.7)',    // Amber-500
    ];

    // Orders by Month Chart
    const ordersByMonthData = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const ordersChartData = @json($ordersChart ?? []);
    const revenueChartData = @json($revenueChart ?? []);
    
    const ordersByMonthCtx = document.getElementById('ordersByMonthChart');
    if (ordersByMonthCtx) {
        new Chart(ordersByMonthCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ordersByMonthData,
                datasets: [{
                    label: 'Orders Count',
                    data: ordersChartData,
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Revenue (UGX)',
                    data: revenueChartData,
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        ticks: {
                            color: '#10b981',
                            callback: function(value) {
                                return new Intl.NumberFormat('en-US', { notation: 'compact' }).format(value);
                            }
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                    x: {
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#374151'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 1) {
                                    return 'Revenue: ' + new Intl.NumberFormat('en-US').format(context.parsed.y) + ' UGX';
                                }
                                return context.dataset.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                }
            }
        });
    }

    // Orders by Status Chart
    const ordersByStatusData = @json($ordersByStatus ?? []);
    const statusLabels = ordersByStatusData.map(item => item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) : 'Unknown');
    const statusCounts = ordersByStatusData.map(item => parseInt(item.count));
    
    const ordersByStatusCtx = document.getElementById('ordersByStatusChart');
    if (ordersByStatusCtx) {
        new Chart(ordersByStatusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusCounts,
                    backgroundColor: colors.slice(0, statusLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#374151',
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' orders (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Show selected tab
        const selectedTab = document.getElementById(tabName + '-tab');
        if (selectedTab) {
            selectedTab.classList.remove('hidden');
            // Scroll to the tab
            selectedTab.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Re-initialize icons after charts are created
    setTimeout(() => {
        lucide.createIcons();
    }, 100);
</script>
@endsection
