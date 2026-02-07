@extends('frontend.layouts.app')

@section('title', 'Account Settings - Apex Electronics & Accessories')

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gradient-to-r from-gray-50 to-white py-4 border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <a href="{{ route('frontend.dashboard.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors">Dashboard</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900 font-medium">Account Settings</span>
            </div>
        </div>
    </nav>

    <!-- Account Settings Section -->
    <section class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 mb-8 shadow-lg">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h1 class="font-semibold tracking-tight text-white -m -fs20 -elli flex items-center gap-3">
                        <i data-lucide="settings" class="w-6 h-6"></i>
                        Account Settings
                    </h1>
                    <a href="{{ route('frontend.dashboard.index') }}" class="px-4 py-2 bg-white text-primary-600 rounded-xl hover:bg-gray-50 transition-colors text-sm font-medium shadow-md">
                        <i data-lucide="arrow-left" class="w-4 h-4 inline mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <div class="grid gap-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mb-6">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                    <i data-lucide="user" class="w-5 h-5"></i>
                                    Personal Information
                                </h3>
                                <p class="text-primary-100 text-sm mt-1">Update your personal details</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Profile Picture Section -->
                        <div class="lg:col-span-1">
                            <div class="text-center">
                                <form action="{{ route('update-profile-picture.update') }}" method="POST" enctype="multipart/form-data" id="imageUploadForm">
                                    @csrf
                                    <div class="mb-4">
                                        <div id="imagePreview" class="w-32 h-32 mx-auto rounded-full bg-cover bg-center border-4 border-gray-200 shadow-sm" style="background-image: url('{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('assets/images/default-avatar.png') }}');"></div>
                                    </div>
                                    <div class="mb-4">
                                        <input type="file" id="imageUpload" name="profile_photo" accept=".png, .jpg, .jpeg" class="hidden">
                                        <label for="imageUpload" class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-200 transition-colors text-sm font-medium">
                                            <i data-lucide="upload" class="w-4 h-4 inline mr-2"></i>
                                            Choose Image
                                        </label>
                                    </div>
                                    <div>
                                        <button type="submit" class="w-full bg-primary-500 text-white py-2 rounded-lg font-medium hover:bg-primary-600 transition-colors text-sm">
                                            Update Photo
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Form Section -->
                        <div class="lg:col-span-2">
                            <form action="{{ route('user.update') }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            First Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="first_name" name="first_name" value="{{ auth()->user()->first_name ?? '' }}" 
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition" 
                                            required>
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Last Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="last_name" name="last_name" value="{{ auth()->user()->last_name ?? '' }}" 
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition" 
                                            required>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" 
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition" 
                                            required>
                                    </div>
                                    <div>
                                        <label for="mobile_number" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number
                                        </label>
                                        <input type="tel" id="mobile_number" name="mobile_number" value="{{ auth()->user()->mobile_number ?? '' }}" 
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition"
                                            placeholder="+256 700 000 000">
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-medium hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg hover:shadow-xl">
                                        <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Billing & Shipping Address -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mb-6">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-white -m -fs20 -elli flex items-center gap-2">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                    Billing & Shipping Address
                                </h3>
                                <p class="text-primary-100 text-sm mt-1">Manage your delivery address</p>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ isset(auth()->user()->shippingInfo) ? route('shipping-info.update', auth()->user()->shippingInfo->id) : route('shipping-store.store') }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset(auth()->user()->shippingInfo))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700 mb-2">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" id="first-name" value="{{ auth()->user()->shippingInfo->first_name ?? old('first_name') }}" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" 
                                    required>
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" id="last-name" value="{{ auth()->user()->shippingInfo->last_name ?? old('last_name') }}" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" 
                                    required>
                            </div>
                            <div>
                                <label for="email-address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email-address" value="{{ auth()->user()->shippingInfo->email ?? old('email') }}" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" 
                                    required>
                            </div>
                            <div>
                                <label for="phone-number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="phone" id="phone-number" value="{{ auth()->user()->shippingInfo->phone ?? old('phone') }}" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" 
                                    required placeholder="+256 700 000 000">
                            </div>
                            <div>
                                <label for="country-select" class="block text-sm font-medium text-gray-700 mb-2">
                                    Country <span class="text-red-500">*</span>
                                </label>
                                <select id="country-select" name="country" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                                    <option value="">Select a country</option>
                                    <option value="Uganda" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                    <option value="Kenya" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                    <option value="Tanzania" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                    <option value="Rwanda" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
                                    <option value="Burundi" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                                    <option value="South Sudan" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'South Sudan' ? 'selected' : '' }}>South Sudan</option>
                                </select>
                            </div>
                            <div>
                                <label for="state-region" class="block text-sm font-medium text-gray-700 mb-2">
                                    State/Region
                                </label>
                                <input type="text" name="state_region" id="state-region" value="{{ auth()->user()->shippingInfo->state_region ?? old('state_region') }}" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                    placeholder="e.g., Central Region">
                            </div>
                            <div>
                                <label for="city-town" class="block text-sm font-medium text-gray-700 mb-2">
                                    City/Town <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="city" id="city-town" value="{{ auth()->user()->shippingInfo->city ?? old('city') }}" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" 
                                    required placeholder="e.g., Kampala">
                            </div>
                            <div>
                                <label for="street-address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Street Address <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="street_address" id="street-address" value="{{ auth()->user()->shippingInfo->street_address ?? old('street_address') }}" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" 
                                    required placeholder="e.g., Plot 123, Main Street">
                            </div>
                            <div class="md:col-span-2">
                                <label for="additional-info" class="block text-sm font-medium text-gray-700 mb-2">
                                    Additional Information (Optional)
                                </label>
                                <textarea name="additional_info" id="additional-info" rows="4" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                    placeholder="Apartment, suite, unit, building, floor, etc.">{{ auth()->user()->shippingInfo->additional_info ?? old('additional_info') }}</textarea>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-medium hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg hover:shadow-xl">
                                <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                                Save Address
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mb-6">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                    <i data-lucide="lock" class="w-5 h-5"></i>
                                    Change Password
                                </h3>
                                <p class="text-primary-100 text-sm mt-1">Update your account password</p>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="old_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="old_password" name="old_password" placeholder="Enter current password" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" 
                                    required>
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    New Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" 
                                    required>
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" 
                                    required>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-medium hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg hover:shadow-xl">
                                <i data-lucide="key" class="w-4 h-4 inline mr-2"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Actions -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-4 mb-6">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-white -m -fs20 -elli flex items-center gap-2">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                    Account Actions
                                </h3>
                                <p class="text-primary-100 text-sm mt-1">Manage your account</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-xl hover:bg-gradient-to-r hover:from-red-50 hover:to-white transition-all shadow-sm hover:shadow-md">
                            <div>
                                <p class="font-medium text-gray-900">Delete Account</p>
                                <p class="text-sm text-gray-500">Permanently delete your account and all data</p>
                            </div>
                            <button type="button" class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all text-sm font-medium shadow-md hover:shadow-lg" disabled>
                                <i data-lucide="trash-2" class="w-4 h-4 inline mr-2"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Image preview functionality
    document.getElementById('imageUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('imagePreview').style.backgroundImage = 'url(' + e.target.result + ')';
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    // Re-initialize icons after form interactions
    setTimeout(() => {
        lucide.createIcons();
    }, 100);
</script>
@endsection
