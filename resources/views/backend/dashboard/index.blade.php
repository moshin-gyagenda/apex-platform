@extends('backend.layouts.app')

@section('content')
<div class="p-4 sm:ml-64 flex flex-col min-h-screen">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mt-16 mb-6">
        <h1 class="text-lg tracking-tight text-gray-900">Mubs Script Marking & Tracing System Dashboard</h1>
        <div class="flex items-center gap-2">
            <button class="p-2.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="filter" class="w-5 h-5 text-gray-500"></i>
            </button>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
        <!-- Total Scripts -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-row items-center justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-500">Total Scripts</h3>
                <i data-lucide="file-text" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="text-lg font-semibold text-gray-900">1,247</div>
            <div class="flex items-center pt-1 text-xs text-green-500">
                <i data-lucide="trending-up" class="mr-1 w-4 h-4"></i>
                <span>12% from last period</span>
            </div>
        </div>

        <!-- Marked Scripts -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-row items-center justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-500">Marked Scripts</h3>
                <i data-lucide="check-circle" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="text-lg font-semibold text-gray-900">856</div>
            <div class="flex items-center pt-1 text-xs text-green-500">
                <i data-lucide="trending-up" class="mr-1 w-4 h-4"></i>
                <span>8% from last period</span>
            </div>
        </div>

        <!-- Pending Marking -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-row items-center justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-500">Pending Marking</h3>
                <i data-lucide="clock" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="text-lg font-semibold text-gray-900">391</div>
            <div class="flex items-center pt-1 text-xs text-yellow-500">
                <i data-lucide="alert-circle" class="mr-1 w-4 h-4"></i>
                <span>Requires attention</span>
            </div>
        </div>

        <!-- Traced Scripts -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-row items-center justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-500">Traced Scripts</h3>
                <i data-lucide="search" class="w-5 h-5 text-primary-500"></i>
            </div>
            <div class="text-lg font-semibold text-gray-900">623</div>
            <div class="flex items-center pt-1 text-xs text-green-500">
                <i data-lucide="trending-up" class="mr-1 w-4 h-4"></i>
                <span>15% from last period</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid gap-6 md:grid-cols-2 mb-6">
        <!-- Scripts by Department Chart -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Scripts by Department</h3>
                    <p class="text-sm text-gray-500">Distribution across different departments</p>
                </div>
            </div>
            <div class="h-80">
                <canvas id="scriptsByDepartmentChart"></canvas>
            </div>
        </div>

        <!-- Scripts by Month Chart -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Scripts by Month</h3>
                    <p class="text-sm text-gray-500">Trend of scripts this year</p>
                </div>
            </div>
            <div class="h-80">
                <canvas id="scriptsByMonthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Scripts and Top Markers -->
    <div class="grid gap-6 md:grid-cols-7 mb-6">
        <!-- Recent Scripts -->
        <div class="md:col-span-4 bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Recent Scripts</h3>
                    <p class="text-sm text-gray-500">Latest script entries</p>
                </div>
                <a href="#" class="px-3 py-1.5 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-100 transition-colors">
                    View All
                </a>
            </div>
            <div class="space-y-4">
                @php
                    $recentScripts = [
                        ['script_number' => 'SCR-2024-001', 'student' => 'John Doe', 'department' => 'Business Administration', 'date' => '2024-01-15', 'status' => 'marked'],
                        ['script_number' => 'SCR-2024-002', 'student' => 'Jane Smith', 'department' => 'Computer Science', 'date' => '2024-01-15', 'status' => 'pending'],
                        ['script_number' => 'SCR-2024-003', 'student' => 'Michael Brown', 'department' => 'Economics', 'date' => '2024-01-14', 'status' => 'marked'],
                        ['script_number' => 'SCR-2024-004', 'student' => 'Emily Davis', 'department' => 'Accounting', 'date' => '2024-01-14', 'status' => 'traced'],
                    ];
                @endphp
                @forelse($recentScripts as $script)
                <div class="flex items-center justify-between rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="space-y-1">
                        <p class="font-medium text-gray-900">{{ $script['script_number'] }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $script['student'] }} - {{ $script['department'] }}
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="font-medium text-gray-900">{{ $script['department'] }}</p>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($script['date'])->format('M d, Y') }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            @if($script['status'] == 'marked') bg-green-100 text-green-800
                            @elseif($script['status'] == 'traced') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($script['status']) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-gray-500">
                    No recent scripts found.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Top Markers -->
        <div class="md:col-span-3 bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex flex-row items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Top Markers</h3>
                    <p class="text-sm text-gray-500">Most active markers</p>
                </div>
                <a href="#" class="px-3 py-1.5 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-100 transition-colors">
                    View All
                </a>
            </div>
            <div class="space-y-4">
                @php
                    $topMarkers = [
                        ['name' => 'Dr. Sarah Johnson', 'department' => 'Business', 'scripts_marked' => 145],
                        ['name' => 'Prof. Michael Williams', 'department' => 'Computer Science', 'scripts_marked' => 132],
                        ['name' => 'Dr. David Anderson', 'department' => 'Economics', 'scripts_marked' => 98],
                    ];
                @endphp
                @forelse($topMarkers as $marker)
                <div class="flex items-center gap-4 rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium">
                        {{ substr($marker['name'], 0, 2) }}
                    </div>
                    <div class="flex-1 space-y-1">
                        <p class="font-medium text-gray-900">{{ $marker['name'] }}</p>
                        <p class="text-sm text-gray-500">{{ $marker['scripts_marked'] }} scripts marked</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">{{ $marker['department'] }}</p>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-gray-500">
                    No markers found.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Marking Status by Department Chart -->
    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm mb-6">
        <div class="flex flex-row items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Marking Status by Department</h3>
                <p class="text-sm text-gray-500">Distribution of marking status across departments</p>
            </div>
        </div>
        <div class="h-80">
            <canvas id="markingStatusByDepartmentChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Set up color palette with primary-500 theme
    const colors = [
        'rgba(59, 130, 246, 0.7)',   // Blue-500
        'rgba(16, 185, 129, 0.7)',   // Green
        'rgba(249, 115, 22, 0.7)',    // Orange
        'rgba(139, 92, 246, 0.7)',    // Purple
        'rgba(239, 68, 68, 0.7)',     // Red
        'rgba(245, 158, 11, 0.7)',    // Amber
        'rgba(20, 184, 166, 0.7)',    // Teal
        'rgba(236, 72, 153, 0.7)'     // Pink
    ];

    // Scripts by Department Chart
    const scriptsByDepartmentData = [
        { category: 'Business Administration', count: 245 },
        { category: 'Computer Science', count: 198 },
        { category: 'Economics', count: 176 },
        { category: 'Accounting', count: 152 },
        { category: 'Finance', count: 128 }
    ];
    
    const scriptsByDepartmentCtx = document.getElementById('scriptsByDepartmentChart').getContext('2d');
    new Chart(scriptsByDepartmentCtx, {
        type: 'pie',
        data: {
            labels: scriptsByDepartmentData.map(item => item.category),
            datasets: [{
                data: scriptsByDepartmentData.map(item => item.count),
                backgroundColor: colors,
                borderWidth: 1,
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
                        color: 'black',
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Scripts by Month Chart
    const scriptsByMonthData = [
        { month_name: 'Jan', count: 120 },
        { month_name: 'Feb', count: 135 },
        { month_name: 'Mar', count: 142 },
        { month_name: 'Apr', count: 158 },
        { month_name: 'May', count: 169 },
        { month_name: 'Jun', count: 180 },
        { month_name: 'Jul', count: 185 },
        { month_name: 'Aug', count: 178 },
        { month_name: 'Sep', count: 192 },
        { month_name: 'Oct', count: 205 },
        { month_name: 'Nov', count: 218 },
        { month_name: 'Dec', count: 230 }
    ];
    
    const scriptsByMonthCtx = document.getElementById('scriptsByMonthChart').getContext('2d');
    new Chart(scriptsByMonthCtx, {
        type: 'bar',
        data: {
            labels: scriptsByMonthData.map(item => item.month_name),
            datasets: [{
                label: 'Scripts',
                data: scriptsByMonthData.map(item => item.count),
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'black'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: 'black'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'black'
                    }
                }
            }
        }
    });

    // Marking Status by Department Chart
    const markingStatusByDepartmentData = [
        { category: 'Marked', count: 856 },
        { category: 'Pending', count: 391 },
        { category: 'Traced', count: 623 },
        { category: 'In Review', count: 128 }
    ];
    
    const markingStatusByDepartmentCtx = document.getElementById('markingStatusByDepartmentChart').getContext('2d');
    new Chart(markingStatusByDepartmentCtx, {
        type: 'doughnut',
        data: {
            labels: markingStatusByDepartmentData.map(item => item.category),
            datasets: [{
                data: markingStatusByDepartmentData.map(item => item.count),
                backgroundColor: colors,
                borderWidth: 1,
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
                        color: 'black',
                        padding: 15,
                        usePointStyle: true
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

