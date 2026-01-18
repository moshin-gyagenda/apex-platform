@extends('backend.layouts.app')
@section('content')

<div class="p-4 sm:ml-64 mt-16 flex flex-col min-h-screen">
    <!-- Breadcrumb Section -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-md font-medium text-gray-700 hover:text-primary-500">
                    <i data-lucide="layout-dashboard" class="mr-2 w-4 h-4 text-gray-600"></i>
                    Dashboard
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
                    <span class="ml-1 text-md font-medium text-gray-500 md:ml-2">Security Monitoring</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div role="alert" class="rounded-xl mb-4 border border-green-100 bg-green-50 p-4 alert-message">
            <div class="flex items-start gap-4">
                <i data-lucide="check-circle" class="text-green-600 w-6 h-6"></i>
                <div class="flex-1">
                    <strong class="block font-medium text-green-900">{{ session('success') }}</strong>
                </div>
                <button class="text-gray-500 transition hover:text-gray-600 close-btn">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div role="alert" class="rounded-xl mb-4 border border-red-100 bg-red-50 p-4 alert-message">
            <div class="flex items-start gap-4">
                <i data-lucide="x-circle" class="text-red-600 w-6 h-6"></i>
                <div class="flex-1">
                    <strong class="block font-medium text-red-900">{{ session('error') }}</strong>
                </div>
                <button class="text-gray-500 transition hover:text-gray-600 close-btn">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="container mx-auto py-6 px-4 sm:px-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Security Monitoring</h1>
                <p class="mt-1 text-sm text-gray-500">Track and monitor security threats, attacks, and suspicious activities</p>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 hover:bg-gray-200 transition">
                    <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                    Back
                </button>
                <a href="{{ route('admin.security.export', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-lg font-semibold text-xs text-white hover:bg-primary-600 transition">
                    <i data-lucide="download" class="mr-2 h-4 w-4"></i>
                    Export Logs
                </a>
            </div>
        </div>

        <!-- Security Stats -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Events</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center">
                        <i data-lucide="file-text" class="h-6 w-6 text-gray-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Critical</p>
                        <p class="text-2xl font-semibold text-red-600">{{ $stats['critical'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">High Severity</p>
                        <p class="text-2xl font-semibold text-orange-600">{{ $stats['high'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center">
                        <i data-lucide="alert-circle" class="h-6 w-6 text-orange-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Blocked IPs</p>
                        <p class="text-2xl font-semibold text-purple-600">{{ $stats['blocked'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i data-lucide="ban" class="h-6 w-6 text-purple-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Today</p>
                        <p class="text-2xl font-semibold text-primary-600">{{ $stats['today'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                        <i data-lucide="clock" class="h-6 w-6 text-primary-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
            <form action="{{ route('admin.security.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1.5">Search</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400"></i>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="IP, email, description..."
                            class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition text-sm">
                    </div>
                </div>
                <div class="flex-shrink-0 min-w-[150px]">
                    <label for="event_type" class="block text-sm font-medium text-gray-700 mb-1.5">Event Type</label>
                    <select name="event_type" id="event_type" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition text-sm">
                        <option value="">All Types</option>
                        @foreach($eventTypes as $type)
                            <option value="{{ $type }}" {{ request('event_type') == $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-shrink-0 min-w-[120px]">
                    <label for="severity" class="block text-sm font-medium text-gray-700 mb-1.5">Severity</label>
                    <select name="severity" id="severity" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition text-sm">
                        <option value="">All</option>
                        <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.security.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium whitespace-nowrap">Clear</a>
                    <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition text-sm font-medium whitespace-nowrap">Search</button>
                </div>
            </form>
        </div>

        <!-- Security Logs Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="py-3 px-4 text-left font-medium text-sm text-gray-700">Time</th>
                            <th class="py-3 px-4 text-left font-medium text-sm text-gray-700">Event Type</th>
                            <th class="py-3 px-4 text-left font-medium text-sm text-gray-700">Severity</th>
                            <th class="py-3 px-4 text-left font-medium hidden lg:table-cell text-sm text-gray-700">IP Address</th>
                            <th class="py-3 px-4 text-left font-medium hidden lg:table-cell text-sm text-gray-700">User/Email</th>
                            <th class="py-3 px-4 text-left font-medium hidden md:table-cell text-sm text-gray-700">Description</th>
                            <th class="py-3 px-4 text-right font-medium text-sm text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-900">{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-sm font-medium text-gray-900">{{ $log->event_type_label }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $severityColors = [
                                        'low' => 'bg-primary-100 text-primary-800',
                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                        'high' => 'bg-orange-100 text-orange-800',
                                        'critical' => 'bg-red-100 text-red-800',
                                    ];
                                    $color = $severityColors[$log->severity] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst($log->severity) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 hidden lg:table-cell">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-900">{{ $log->ip_address }}</span>
                                    @if($log->country)
                                        <span class="text-xs text-gray-500">({{ $log->country }})</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 hidden lg:table-cell">
                                <div class="text-sm text-gray-900">
                                    {{ $log->user ? $log->user->name : ($log->email ?? 'N/A') }}
                                </div>
                            </td>
                            <td class="py-3 px-4 hidden md:table-cell">
                                <div class="text-sm text-gray-700 max-w-xs truncate" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.security.show', $log) }}" class="text-primary-600 hover:text-primary-900 transition-colors" title="View Details">
                                        <i data-lucide="eye" class="h-5 w-5"></i>
                                    </a>
                                    @if(!$log->blocked)
                                    <form action="{{ route('admin.security.block-ip', $log->ip_address) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Block IP" onclick="return confirm('Block IP address {{ $log->ip_address }}?');">
                                            <i data-lucide="ban" class="h-5 w-5"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('admin.security.unblock-ip', $log->ip_address) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900 transition-colors" title="Unblock IP">
                                            <i data-lucide="check-circle" class="h-5 w-5"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i data-lucide="shield-check" class="mx-auto h-12 w-12 text-gray-400"></i>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No security logs found</h3>
                                <p class="mt-1 text-sm text-gray-500">All clear! No security threats detected.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $logs->firstItem() }}</span> to <span class="font-medium">{{ $logs->lastItem() }}</span> of <span class="font-medium">{{ $logs->total() }}</span> results
                    </div>
                    <div class="flex items-center space-x-2">{{ $logs->links() }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Close alert messages
        const closeButtons = document.querySelectorAll('.close-btn');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.alert-message').remove();
            });
        });
        
        // Initialize Lucide icons
        lucide.createIcons();
    });
</script>
@endsection

