@extends('frontend.layouts.app')

@section('title', 'Account Settings - Apex Electronics & Accessories')

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
                <a href="{{ route('frontend.dashboard.index') ?? route('customer-dashboard.index') }}" class="text-gray-600 hover:text-primary-600">Dashboard</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900">Account Settings</span>
            </div>
        </div>
    </nav>

    <!-- Account Settings Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Navigation -->
                <div class="lg:w-1/4">
                    <nav class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h5 class="text-xl font-semibold mb-6 text-gray-900">Navigation</h5>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('frontend.dashboard.index') ?? route('customer-dashboard.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.dashboard.index') ?? route('customer-dashboard.index') }}#order-history" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition-colors">
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
                                <a href="{{ route('customer.account-setting') ?? route('frontend.dashboard.account-settings') }}" class="flex items-center p-3 text-primary-600 bg-primary-50 rounded-lg">
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
                <div class="lg:w-3/4 space-y-6">
                    <!-- Account Settings -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h5 class="text-xl font-semibold text-gray-900 mb-6">Account Settings</h5>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <form action="{{ route('user.update') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                        <input type="text" id="first_name" name="first_name" value="{{ auth()->user()->first_name ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" value="{{ auth()->user()->last_name ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label for="mobile_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" id="mobile_number" name="mobile_number" value="{{ auth()->user()->mobile_number ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <button type="submit" class="w-full bg-primary-500 text-white py-2 rounded-lg font-medium hover:bg-primary-600 transition-colors">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="text-center">
                                <form action="{{ route('update-profile-picture.update') }}" method="POST" enctype="multipart/form-data" id="imageUploadForm">
                                    @csrf
                                    <div class="mb-4">
                                        <div id="imagePreview" class="w-40 h-40 mx-auto rounded-full bg-cover bg-center border-4 border-gray-200" style="background-image: url('{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('assets/images/default-avatar.png') }}');"></div>
                                    </div>
                                    <div class="mb-4">
                                        <input type="file" id="imageUpload" name="profile_photo" accept=".png, .jpg, .jpeg" class="hidden">
                                        <label for="imageUpload" class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-300 transition-colors">
                                            Choose Image
                                        </label>
                                    </div>
                                    <div>
                                        <button type="submit" class="w-full bg-primary-500 text-white py-2 rounded-lg font-medium hover:bg-primary-600 transition-colors">
                                            Change Image
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h5 class="text-xl font-semibold text-gray-900 mb-6">Billing Address</h5>
                        <form action="{{ isset(auth()->user()->shippingInfo) ? route('shipping-info.update', auth()->user()->shippingInfo->id) : route('shipping-store.store') }}" method="POST" class="space-y-4">
                            @csrf
                            @if(isset(auth()->user()->shippingInfo))
                                @method('PUT')
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="first-name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" name="first_name" value="{{ auth()->user()->shippingInfo->first_name ?? old('first_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="last-name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" name="last_name" value="{{ auth()->user()->shippingInfo->last_name ?? old('last_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="email-address" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" value="{{ auth()->user()->shippingInfo->email ?? old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="phone-number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="text" name="phone" value="{{ auth()->user()->shippingInfo->phone ?? old('phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="country-select" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                    <select id="country-select" name="country" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        <option value="">Select a country</option>
                                        <option value="Uganda" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                        <option value="Kenya" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                        <option value="Tanzania" {{ (auth()->user()->shippingInfo->country ?? old('country')) == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="state-region" class="block text-sm font-medium text-gray-700 mb-2">State/Region</label>
                                    <input type="text" name="state_region" value="{{ auth()->user()->shippingInfo->state_region ?? old('state_region') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="city-town" class="block text-sm font-medium text-gray-700 mb-2">City/Town</label>
                                    <input type="text" name="city" value="{{ auth()->user()->shippingInfo->city ?? old('city') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="street-address" class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                                    <input type="text" name="street_address" value="{{ auth()->user()->shippingInfo->street_address ?? old('street_address') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="additional-info" class="block text-sm font-medium text-gray-700 mb-2">Additional Information (Optional)</label>
                                    <textarea name="additional_info" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ auth()->user()->shippingInfo->additional_info ?? old('additional_info') }}</textarea>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="bg-primary-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-600 transition-colors">
                                    Save Details
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h5 class="text-xl font-semibold text-gray-900 mb-6">Change Password</h5>
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="old_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" id="old_password" name="old_password" placeholder="Enter current password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <button type="submit" class="bg-primary-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-600 transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
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
</script>
@endsection
