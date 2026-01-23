<header class="sticky top-0 z-50 bg-white shadow-md border-b border-gray-200">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo and Mobile Menu Button -->
            <div class="flex items-center space-x-4">
                <button id="mobile-menu-button" onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-primary-500 hover:bg-primary-50">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                
                <a href="{{ route('frontend.index') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Apex Electronics Logo" class="h-10 w-auto">
                    
                </a>
            </div>
            
            <!-- Search Bar - Desktop -->
            <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
                <div class="relative w-full">
                    <input 
                        type="text" 
                        placeholder="Search products, brands, and categories..." 
                        onkeypress="handleSearch(event)"
                        class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    >
                    <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                </div>
            </div>
            
            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search Icon - Mobile -->
                <button class="lg:hidden p-2 rounded-md text-gray-600 hover:text-primary-500 hover:bg-primary-50">
                    <i data-lucide="search" class="w-6 h-6"></i>
                </button>
                
                <!-- Wishlist -->
                <a href="#" class="relative p-2 rounded-md text-gray-600 hover:text-primary-500 hover:bg-primary-50 transition-colors">
                    <i data-lucide="heart" class="w-6 h-6"></i>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-primary-500 rounded-full">3</span>
                </a>
                
                <!-- Cart -->
                <a href="#" class="relative p-2 rounded-md text-gray-600 hover:text-primary-500 hover:bg-primary-50 transition-colors">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-primary-500 rounded-full">5</span>
                </a>
                
                <!-- User Account -->
                @auth
                    <div class="relative group">
                        <button class="flex items-center space-x-2 p-2 rounded-md text-gray-600 hover:text-primary-500 hover:bg-primary-50 transition-colors">
                            <i data-lucide="user" class="w-6 h-6"></i>
                            <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->name ?? 'Account' }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">Dashboard</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">My Orders</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex items-center space-x-2 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Sign In</span>
                    </a>
                @endauth
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
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Search products..." 
                        onkeypress="handleSearch(event)"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                    <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
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
</script>
