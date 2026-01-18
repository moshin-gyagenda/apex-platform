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
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Users</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Edit User</span>
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
                <h1 class="text-xl font-semibold text-gray-800">Edit User</h1>
                <button onclick="window.history.back(); return false;" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back
                </button>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">User Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Update the user's information</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6 space-y-6">
                        <!-- Personal Information Section -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="user" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Personal Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', $user->name) }}"
                                        placeholder="Enter full name"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email', $user->email) }}"
                                        placeholder="Enter email address"
                                        required
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="lock" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Password
                            </h4>
                            <div class="bg-primary-50 border border-primary-200 rounded-lg p-3 mb-4">
                                <p class="text-sm text-blue-800">
                                    <i data-lucide="info" class="w-4 h-4 inline mr-2"></i>
                                    Leave password fields blank to keep the current password.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        New Password
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="Enter new password"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Confirm Password
                                    </label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        placeholder="Confirm new password"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Account Settings Section -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <i data-lucide="settings" class="w-4 h-4 mr-2 text-primary-500"></i>
                                Account Settings
                            </h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                        Role <span class="text-red-500">*</span>
                                    </label>
                                    <div class="searchable-select-container relative" data-select-id="role">
                                        <div class="selected-display mt-1 py-2 px-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-primary-500 transition focus-within:border-primary-500">
                                            <div class="selected-text text-gray-500">Select a role</div>
                                            <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                        </div>
                                        <div class="dropdown-container hidden absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
                                            <div class="p-2 sticky top-0 bg-white border-b border-gray-200">
                                                <input type="text" class="search-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500" placeholder="Search roles...">
                                            </div>
                                            <div class="options-list max-h-48 overflow-y-auto">
                                                <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="">Select a role</div>
                                                @foreach($roles as $role)
                                                    <div class="option p-2.5 hover:bg-primary-50 cursor-pointer text-gray-700" data-value="{{ $role->name }}" {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'data-selected="true"' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <select id="role" name="role" class="hidden" required>
                                        <option value="" disabled>Select a role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Information (Optional) -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-primary-500"></i>
                                    Location Information (Optional)
                                </h4>
                                <button
                                    type="button"
                                    onclick="detectLocation()"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 border border-primary-200 rounded-lg hover:bg-primary-100 transition-colors"
                                >
                                    <i data-lucide="navigation" class="w-3 h-3 mr-1"></i>
                                    Auto Detect
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="last_login_location" class="block text-sm font-medium text-gray-700 mb-1">
                                        Location
                                    </label>
                                    <input
                                        type="text"
                                        name="last_login_location"
                                        id="last_login_location"
                                        value="{{ old('last_login_location', $user->last_login_location) }}"
                                        placeholder="Auto-detected location"
                                        readonly
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 focus:outline-none transition"
                                    >
                                    @error('last_login_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_login_latitude" class="block text-sm font-medium text-gray-700 mb-1">
                                        Latitude
                                    </label>
                                    <input
                                        type="number"
                                        step="any"
                                        name="last_login_latitude"
                                        id="last_login_latitude"
                                        value="{{ old('last_login_latitude', $user->last_login_latitude) }}"
                                        placeholder="Auto-detected"
                                        readonly
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 focus:outline-none transition"
                                    >
                                    @error('last_login_latitude')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_login_longitude" class="block text-sm font-medium text-gray-700 mb-1">
                                        Longitude
                                    </label>
                                    <input
                                        type="number"
                                        step="any"
                                        name="last_login_longitude"
                                        id="last_login_longitude"
                                        value="{{ old('last_login_longitude', $user->last_login_longitude) }}"
                                        placeholder="Auto-detected"
                                        readonly
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 focus:outline-none transition"
                                    >
                                    @error('last_login_longitude')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
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
                            Update User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Location Detection Function
    function detectLocation() {
        let locationString = '';
        let latitude = null;
        let longitude = null;

        // Show loading state
        const locationInput = document.getElementById('last_login_location');
        const latInput = document.getElementById('last_login_latitude');
        const lngInput = document.getElementById('last_login_longitude');
        
        const currentLocation = locationInput.value;
        const currentLat = latInput.value;
        const currentLng = lngInput.value;
        
        locationInput.value = 'Detecting location...';
        latInput.value = '';
        lngInput.value = '';

        // Try to get location from geolocation API
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    
                    // Set coordinates
                    latInput.value = latitude;
                    lngInput.value = longitude;
                    
                    // Use reverse geocoding to get location name
                    fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${latitude}&longitude=${longitude}&localityLanguage=en`)
                        .then(response => response.json())
                        .then(data => {
                            locationString = `${data.city || ''}, ${data.principalSubdivision || ''}, ${data.countryName || ''}`.replace(/^,\s*|,\s*$/g, '');
                            locationInput.value = locationString || `${latitude}, ${longitude}`;
                        })
                        .catch(() => {
                            // Fallback to coordinates as location string
                            locationString = `${latitude}, ${longitude}`;
                            locationInput.value = locationString;
                        });
                },
                function(error) {
                    // If geolocation fails, try IP-based geolocation
                    fetch('https://ipapi.co/json/')
                        .then(response => response.json())
                        .then(data => {
                            locationString = `${data.city || ''}, ${data.region || ''}, ${data.country_name || ''}`.replace(/^,\s*|,\s*$/g, '');
                            // IP-based geolocation provides approximate coordinates
                            if (data.latitude && data.longitude) {
                                latitude = data.latitude;
                                longitude = data.longitude;
                                latInput.value = latitude;
                                lngInput.value = longitude;
                            }
                            locationInput.value = locationString || 'Unknown Location';
                        })
                        .catch(() => {
                            // Restore previous values on error
                            locationInput.value = currentLocation || 'Unknown Location';
                            latInput.value = currentLat;
                            lngInput.value = currentLng;
                        });
                }
            );
        } else {
            // Browser doesn't support geolocation, use IP-based
            fetch('https://ipapi.co/json/')
                .then(response => response.json())
                .then(data => {
                    locationString = `${data.city || ''}, ${data.region || ''}, ${data.country_name || ''}`.replace(/^,\s*|,\s*$/g, '');
                    // IP-based geolocation provides approximate coordinates
                    if (data.latitude && data.longitude) {
                        latitude = data.latitude;
                        longitude = data.longitude;
                        latInput.value = latitude;
                        lngInput.value = longitude;
                    }
                    locationInput.value = locationString || 'Unknown Location';
                })
                .catch(() => {
                    // Restore previous values on error
                    locationInput.value = currentLocation || 'Unknown Location';
                    latInput.value = currentLat;
                    lngInput.value = currentLng;
                });
        }
    }

    function initializeSearchableSelects() {
        document.querySelectorAll('.searchable-select-container').forEach(container => {
            const selectId = container.getAttribute('data-select-id');
            const originalSelect = document.getElementById(selectId);
            const display = container.querySelector('.selected-display');
            const selectedText = display.querySelector('.selected-text');
            const dropdown = container.querySelector('.dropdown-container');
            const searchInput = dropdown.querySelector('.search-input');
            const options = dropdown.querySelectorAll('.option');
            const chevron = display.querySelector('i[data-lucide="chevron-down"]');

            // Set initial selected value
            const selectedOption = originalSelect.querySelector('option[selected]');
            if (selectedOption && selectedOption.value) {
                selectedText.textContent = selectedOption.textContent;
                selectedText.classList.remove('text-gray-500');
                selectedText.classList.add('text-gray-900');
            } else {
                selectedText.classList.add('text-gray-500');
            }

            // Toggle dropdown
            display.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = !dropdown.classList.contains('hidden');
                
                // Close all other dropdowns
                document.querySelectorAll('.dropdown-container').forEach(d => {
                    if (d !== dropdown) d.classList.add('hidden');
                });
                
                dropdown.classList.toggle('hidden');
                
                if (!dropdown.classList.contains('hidden')) {
                    searchInput.focus();
                    searchInput.value = '';
                    filterOptions();
                }
                
                // Rotate chevron
                if (!dropdown.classList.contains('hidden')) {
                    chevron.style.transform = 'translateY(-50%) rotate(180deg)';
                } else {
                    chevron.style.transform = 'translateY(-50%) rotate(0deg)';
                }
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                filterOptions();
            });

            function filterOptions() {
                const searchTerm = searchInput.value.toLowerCase();
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            // Select option
            options.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.textContent.trim();
                    
                    // Update original select
                    originalSelect.value = value;
                    
                    // Trigger change event
                    const changeEvent = new Event('change', { bubbles: true });
                    originalSelect.dispatchEvent(changeEvent);
                    
                    // Update display
                    selectedText.textContent = text;
                    selectedText.classList.remove('text-gray-500');
                    selectedText.classList.add('text-gray-900');
                    
                    // Update option states
                    options.forEach(opt => {
                        opt.classList.remove('bg-primary-100', 'font-medium');
                        if (opt.getAttribute('data-value') === value) {
                            opt.classList.add('bg-primary-100', 'font-medium');
                        }
                    });
                    
                    // Close dropdown
                    dropdown.classList.add('hidden');
                    chevron.style.transform = 'translateY(-50%) rotate(0deg)';
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!container.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    chevron.style.transform = 'translateY(-50%) rotate(0deg)';
                }
            });

            // Mark initially selected option
            const currentValue = originalSelect.value;
            options.forEach(opt => {
                if (opt.getAttribute('data-value') === currentValue || opt.getAttribute('data-selected') === 'true') {
                    opt.classList.add('bg-primary-100', 'font-medium');
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();

        // Close alert messages
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.alert-message').remove();
            });
        });

        // Initialize searchable selects
        initializeSearchableSelects();

        // Auto-detect location on page load if fields are empty
        const locationInput = document.getElementById('last_login_location');
        const latInput = document.getElementById('last_login_latitude');
        const lngInput = document.getElementById('last_login_longitude');
        
        if (!locationInput.value && !latInput.value && !lngInput.value) {
            detectLocation();
        }
    });
</script>
@endsection

