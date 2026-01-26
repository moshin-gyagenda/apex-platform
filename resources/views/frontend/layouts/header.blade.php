@php
    $cart = session('cart', []);
    $cartCount = array_sum($cart);
@endphp

<header class="sticky top-0 z-50 bg-white shadow-md border-b border-gray-200">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 py-2">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3 flex-shrink-0">
                <button id="mobile-menu-button" onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-primary-500 hover:bg-primary-50">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                
                <a href="{{ route('frontend.index') }}" class="flex items-center space-x-2 group">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Apex Electronics Logo" class="h-10 w-auto">
                    <span class="text-xl font-bold text-gray-900">Apex</span>
                    <span class="text-primary-500 text-xl">★</span>
                </a>
            </div>
            
            <!-- Search Bar - Desktop (Center) -->
            <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
                <div class="relative w-full flex items-center">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            id="search-input"
                            placeholder="Search products, brands and categories" 
                            onkeypress="handleSearch(event)"
                            class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        >
                        <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                    </div>
                    <button 
                        onclick="handleSearchClick()"
                        class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2.5 rounded-r-lg font-medium transition-colors shadow-sm"
                    >
                        Search
                    </button>
                </div>
            </div>
            
            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4 lg:space-x-6">
                <!-- Account Dropdown -->
                <div class="relative group">
                    @auth
                        <button class="flex items-center space-x-1 text-gray-700 hover:text-primary-600 transition-colors focus:outline-none">
                            <i data-lucide="user" class="w-5 h-5"></i>
                            <span class="hidden sm:block text-sm font-medium">Account</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-2">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i>
                                    Dashboard
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i data-lucide="shopping-bag" class="w-4 h-4 mr-2"></i>
                                    My Orders
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4 mr-2"></i>
                                    Settings
                                </a>
                                <div class="border-t border-gray-200 mt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <button class="flex items-center space-x-1 text-gray-700 hover:text-primary-600 transition-colors focus:outline-none">
                            <i data-lucide="user" class="w-5 h-5"></i>
                            <span class="hidden sm:block text-sm font-medium">Account</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-2">
                                <a href="{{ route('login') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i data-lucide="log-in" class="w-4 h-4 mr-2"></i>
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                                    Sign Up
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Help Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-1 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg text-gray-700 hover:text-primary-600 transition-colors focus:outline-none">
                        <i data-lucide="help-circle" class="w-5 h-5"></i>
                        <span class="hidden sm:block text-sm font-medium">Help</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i data-lucide="help-circle" class="w-4 h-4 mr-2"></i>
                                Help Center
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                                Contact Us
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                FAQ
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i data-lucide="truck" class="w-4 h-4 mr-2"></i>
                                Shipping Info
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative flex items-center space-x-1 text-gray-700 hover:text-primary-600 transition-colors">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    <span class="hidden sm:block text-sm font-medium">Cart</span>
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-primary-500 rounded-full" id="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-200 py-4">
            <div class="space-y-2">
                <a href="{{ route('frontend.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md">Home</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md">Categories</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md">Products</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md">About</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md">Contact</a>
            </div>
            
            <!-- Mobile Search -->
            <div class="mt-4 px-4">
                <div class="relative flex items-center">
                    <input 
                        type="text" 
                        placeholder="Search products, brands and categories" 
                        onkeypress="handleSearch(event)"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                    <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                    <button 
                        onclick="handleSearchClick()"
                        class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2.5 rounded-r-lg font-medium transition-colors"
                    >
                        Search
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    function handleSearch(event) {
        if (event.key === 'Enter') {
            handleSearchClick();
        }
    }

    function handleSearchClick() {
        const searchInput = document.getElementById('search-input') || document.querySelector('#mobile-menu input[type="text"]');
        const query = searchInput.value.trim();
        
        if (query) {
            // Redirect to search results page or filter products
            window.location.href = '{{ route("frontend.index") }}?search=' + encodeURIComponent(query);
        }
    }

    // Update cart count dynamically
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cart-badge');
                if (data.count > 0) {
                    if (badge) {
                        badge.textContent = data.count;
                    } else {
                        const cartLink = document.querySelector('a[href="{{ route("cart.index") }}"]');
                        if (cartLink) {
                            const newBadge = document.createElement('span');
                            newBadge.id = 'cart-badge';
                            newBadge.className = 'absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-primary-500 rounded-full';
                            newBadge.textContent = data.count;
                            cartLink.appendChild(newBadge);
                        }
                    }
                } else {
                    if (badge) {
                        badge.remove();
                    }
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }

    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
    });
</script>
