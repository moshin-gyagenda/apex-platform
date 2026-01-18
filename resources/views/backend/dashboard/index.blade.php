@extends('backend.layouts.app')

@section('content')
<div class="p-4 sm:ml-64 flex flex-col min-h-screen">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mt-16 mb-6">
        <h1 class="text-lg tracking-tight text-gray-900">Inventory Management Dashboard</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.pos.index') }}" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors text-sm font-medium">
                <i data-lucide="terminal" class="w-4 h-4 inline mr-2"></i>
                Open POS
            </a>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
        <!-- Total Revenue -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-row items-center justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                <i data-lucide="dollar-sign" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="text-lg font-semibold text-gray-900">{{ number_format($stats['total_revenue'], 0) }} UGX</div>
            <div class="flex items-center pt-1 text-xs {{ $stats['revenue_growth'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                <i data-lucide="{{ $stats['revenue_growth'] >= 0 ? 'trending-up' : 'trending-down' }}" class="mr-1 w-4 h-4"></i>
                <span>{{ number_format(abs($stats['revenue_growth']), 1) }}% from last month</span>
            </div>
        </div>

        <!-- Today's Sales -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-row items-center justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-500">Today's Sales</h3>
                <i data-lucide="shopping-cart" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="text-lg font-semibold text-gray-900">{{ $stats['today_sales'] }}</div>
            <div class="flex items-center pt-1 text-xs text-gray-500">
                <i data-lucide="calendar" class="mr-1 w-4 h-4"></i>
                <span>{{ number_format($stats['today_revenue'], 0) }} UGX revenue</span>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-row items-center justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-500">Total Products</h3>
                <i data-lucide="package" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="text-lg font-semibold text-gray-900">{{ $stats['total_products'] }}</div>
            <div class="flex items-center pt-1 text-xs {{ $stats['low_stock_products'] > 0 ? 'text-yellow-500' : 'text-green-500' }}">
                <i data-lucide="{{ $stats['low_stock_products'] > 0 ? 'alert-triangle' : 'check-circle' }}" class="mr-1 w-4 h-4"></i>
                <span>{{ $stats['low_stock_products'] }} low stock</span>
            </div>
        </div>

        <!-- Stock Value -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-row items-center justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-500">Stock Value</h3>
                <i data-lucide="trending-up" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="text-lg font-semibold text-gray-900">{{ number_format($stats['total_stock_value'], 0) }} UGX</div>
            <div class="flex items-center pt-1 text-xs text-gray-500">
                <i data-lucide="bar-chart" class="mr-1 w-4 h-4"></i>
                <span>{{ $stats['active_products'] }} active products</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid gap-6 md:grid-cols-2 mb-6">
        <!-- Sales by Month Chart -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Sales This Year</h3>
                    <p class="text-sm text-gray-500">Monthly sales trend</p>
                </div>
            </div>
            <div class="h-80">
                <canvas id="salesByMonthChart"></canvas>
            </div>
        </div>

        <!-- Sales by Category Chart -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Sales by Category</h3>
                    <p class="text-sm text-gray-500">Revenue distribution</p>
                </div>
            </div>
            <div class="h-80">
                <canvas id="salesByCategoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Sales and Top Products -->
    <div class="grid gap-6 md:grid-cols-7 mb-6">
        <!-- Recent Sales -->
        <div class="md:col-span-4 bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Recent Sales</h3>
                    <p class="text-sm text-gray-500">Latest transactions</p>
                </div>
                <a href="{{ route('admin.sales.index') }}" class="px-3 py-1.5 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-100 transition-colors">
                    View All
                </a>
            </div>
            <div class="space-y-4">
                @forelse($recent['sales'] as $sale)
                <div class="flex items-center justify-between rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="space-y-1">
                        <p class="font-medium text-gray-900">Sale #{{ $sale->id }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }} • {{ $sale->creator->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="font-medium text-gray-900">{{ number_format($sale->final_amount, 0) }} UGX</p>
                            <p class="text-sm text-gray-500">
                                {{ $sale->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            @if($sale->payment_status == 'completed') bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-gray-500">
                    No recent sales found.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Top Products -->
        <div class="md:col-span-3 bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Top Selling Products</h3>
                    <p class="text-sm text-gray-500">Best performers</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="px-3 py-1.5 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-100 transition-colors">
                    View All
                </a>
            </div>
            <div class="space-y-4">
                @forelse($topProducts as $product)
                <div class="flex items-center gap-4 rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">
                        {{ substr($product->name, 0, 2) }}
                    </div>
                    <div class="flex-1 space-y-1">
                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500">{{ $product->total_sold }} units sold</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">{{ number_format($product->total_revenue, 0) }} UGX</p>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-gray-500">
                    No sales data found.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid gap-6 md:grid-cols-3 mb-6">
        <!-- Purchases This Month -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Purchases</h3>
                <i data-lucide="shopping-bag" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">This Month</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['monthly_purchases'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Total Amount</span>
                    <span class="text-sm font-medium text-gray-900">{{ number_format($stats['monthly_purchase_amount'], 0) }} UGX</span>
                </div>
            </div>
        </div>

        <!-- Customers & Suppliers -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Customers & Suppliers</h3>
                <i data-lucide="users" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Total Customers</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['total_customers'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Total Suppliers</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['total_suppliers'] }}</span>
                </div>
            </div>
        </div>

        <!-- Inventory Status -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Inventory Status</h3>
                <i data-lucide="package" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Out of Stock</span>
                    <span class="text-sm font-medium text-red-600">{{ $stats['out_of_stock'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Low Stock</span>
                    <span class="text-sm font-medium text-yellow-600">{{ $stats['low_stock_products'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Categories</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['total_categories'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
        'rgba(20, 184, 166, 0.7)',    // Teal-500
        'rgba(236, 72, 153, 0.7)'     // Pink-500
    ];

    // Sales by Month Chart
    const salesByMonthData = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const salesChartData = @json($salesChart);
    const revenueChartData = @json($revenueChart);
    
    const salesByMonthCtx = document.getElementById('salesByMonthChart').getContext('2d');
    new Chart(salesByMonthCtx, {
        type: 'line',
        data: {
            labels: salesByMonthData,
            datasets: [{
                label: 'Sales Count',
                data: salesChartData,
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

    // Sales by Category Chart
    const salesByCategoryData = @json($salesByCategory);
    const categoryLabels = salesByCategoryData.map(item => item.name);
    const categoryRevenue = salesByCategoryData.map(item => parseFloat(item.total_revenue));
    
    const salesByCategoryCtx = document.getElementById('salesByCategoryChart').getContext('2d');
    new Chart(salesByCategoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryRevenue,
                backgroundColor: colors.slice(0, categoryLabels.length),
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
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + new Intl.NumberFormat('en-US').format(value) + ' UGX (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Re-initialize icons after charts are created
    setTimeout(() => {
        lucide.createIcons();
    }, 100);
</script>
@endsection
