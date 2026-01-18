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
            <li>
                <div class="flex items-center">
                    <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
                    <a href="{{ route('admin.security.index') }}" class="ml-1 text-md font-medium text-gray-500 md:ml-2 hover:text-primary-500">Security Monitoring</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
                    <span class="ml-1 text-md font-medium text-gray-500 md:ml-2">Security Event Details</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="container mx-auto py-6 px-4 sm:px-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Security Event Details</h1>
                <p class="mt-1 text-sm text-gray-500">Detailed information about the security event</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 hover:bg-gray-200 transition">
                    <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                    Back
                </button>
            </div>
        </div>

        <!-- Security Event Card -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-8 bg-gradient-to-r from-blue-50 to-purple-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">{{ $securityLog->event_type_label }}</h2>
                        @php
                            $severityColors = [
                                'low' => 'bg-primary-100 text-primary-800',
                                'medium' => 'bg-yellow-100 text-yellow-800',
                                'high' => 'bg-orange-100 text-orange-800',
                                'critical' => 'bg-red-100 text-red-800',
                            ];
                            $color = $severityColors[$securityLog->severity] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $color }}">{{ ucfirst($securityLog->severity) }}</span>
                    </div>
                    <div>
                        @if($securityLog->blocked)
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Blocked</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Active</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="px-6 py-6 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i data-lucide="info" class="w-5 h-5 mr-2 text-primary-600"></i>
                        Event Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <span class="font-medium text-gray-500">Event Type:</span>
                            <p class="mt-1 text-gray-900 font-semibold">{{ $securityLog->event_type_label }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Severity:</span>
                            <p class="mt-1">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucfirst($securityLog->severity) }}</span>
                            </p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Date & Time:</span>
                            <p class="mt-1 text-gray-900">{{ $securityLog->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <span class="font-medium text-gray-500">Description:</span>
                            <p class="mt-1 text-gray-900">{{ $securityLog->description }}</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i data-lucide="globe" class="w-5 h-5 mr-2 text-primary-600"></i>
                        Network Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <span class="font-medium text-gray-500">IP Address:</span>
                            <p class="mt-1 text-gray-900 font-mono">{{ $securityLog->ip_address }}</p>
                        </div>
                        @if($securityLog->country)
                        <div>
                            <span class="font-medium text-gray-500">Location:</span>
                            <p class="mt-1 text-gray-900">{{ $securityLog->city ? $securityLog->city . ', ' : '' }}{{ $securityLog->country }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="font-medium text-gray-500">Route:</span>
                            <p class="mt-1 text-gray-900 font-mono">{{ $securityLog->method }} {{ $securityLog->route ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Status:</span>
                            <p class="mt-1">
                                @if($securityLog->blocked)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Blocked</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                @endif
                            </p>
                        </div>
                        @if($securityLog->user_agent)
                        <div class="md:col-span-2">
                            <span class="font-medium text-gray-500">User Agent:</span>
                            <p class="mt-1 text-gray-900 break-all text-xs">{{ $securityLog->user_agent }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($securityLog->user)
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i data-lucide="user" class="w-5 h-5 mr-2 text-primary-600"></i>
                        Associated User
                    </h3>
                    <div class="text-sm">
                        <span class="font-medium text-gray-500">Name:</span>
                        <p class="mt-1 text-gray-900">{{ $securityLog->user->name }}</p>
                        <span class="font-medium text-gray-500 mt-3 block">Email:</span>
                        <p class="mt-1 text-gray-900">{{ $securityLog->user->email }}</p>
                    </div>
                </div>
                @endif

                @if($securityLog->request_data && count($securityLog->request_data) > 0)
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i data-lucide="file-text" class="w-5 h-5 mr-2 text-primary-600"></i>
                        Request Data
                    </h3>
                    <pre class="bg-gray-50 p-4 rounded-lg text-xs overflow-x-auto border border-gray-200">{{ json_encode($securityLog->request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection

