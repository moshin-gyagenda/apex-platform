<!-- Sidebar -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 flex flex-col"
    aria-label="Sidebar">

    <!-- Sidebar Content -->
    <div class="flex-1 h-full px-3 py-4 overflow-y-auto sidebar-scrollbar bg-white">

        <!-- Main Navigation -->
        <div class="space-y-1">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase mb-2">Main</p>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="sidebar-item {{ request()->routeIs('dashboard') ? 'active border-l-3 border-primary-500 bg-primary-50' : 'border-l-3 border-transparent' }} flex items-center p-2 text-gray-600 rounded-lg hover:bg-primary-50 hover:text-primary-600 group text-sm transition-all duration-200 pl-3">
                <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-primary-500' : 'text-gray-500' }} group-hover:text-primary-500 transition-colors"></i>
                <span class="ms-3 text-sm font-medium">Dashboard</span>
            </a>

            <!-- Point of Sale -->
            <a href="{{ route('admin.pos.index') }}"
                class="sidebar-item border-l-3 {{ request()->routeIs('admin.pos.*') ? 'border-primary-500 bg-primary-50' : 'border-transparent' }} flex items-center p-2 text-gray-600 rounded-lg hover:bg-primary-50 hover:text-primary-600 group text-sm transition-all duration-200 pl-3">
                <i data-lucide="terminal" class="w-5 h-5 {{ request()->routeIs('admin.pos.*') ? 'text-primary-500' : 'text-gray-500' }} group-hover:text-primary-500 transition-colors"></i>
                <span class="flex-1 ms-3 whitespace-nowrap text-sm font-medium">Point of Sale</span>
            </a>

            <!-- Products -->
            <details class="group">
                <summary
                    class="sidebar-item border-l-3 {{ request()->routeIs('admin.products.*') ? 'border-primary-500 bg-primary-50' : 'border-transparent' }} flex items-center p-2 text-gray-600 rounded-lg cursor-pointer hover:bg-primary-50 hover:text-primary-600 group text-sm transition-all duration-200 pl-3">
                    <i data-lucide="shopping-cart" class="w-5 h-5 {{ request()->routeIs('admin.products.*') ? 'text-primary-500' : 'text-gray-500' }} group-hover:text-primary-500 transition-colors"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap text-sm font-medium">Products</span>
                    <i data-lucide="chevron-right" class="chevron-icon ml-auto w-4 h-4 text-gray-400 transition-transform duration-200"></i>
                </summary>
                <div class="collapsible-content">
                    <ul class="pl-6 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.products.index') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.products.index') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="list" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.products.index') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">All Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.create') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.products.create') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="plus" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.products.create') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">Add New Product</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </details>

            <!-- Sales -->
            <details class="group">
                <summary
                    class="sidebar-item border-l-3 {{ request()->routeIs('admin.sales.*') ? 'border-primary-500 bg-primary-50' : 'border-transparent' }} flex items-center p-2 text-gray-600 rounded-lg cursor-pointer hover:bg-primary-50 hover:text-primary-600 group text-sm transition-all duration-200 pl-3">
                    <i data-lucide="receipt" class="w-5 h-5 {{ request()->routeIs('admin.sales.*') ? 'text-primary-500' : 'text-gray-500' }} group-hover:text-primary-500 transition-colors"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap text-sm font-medium">Sales</span>
                    <i data-lucide="chevron-right" class="chevron-icon ml-auto w-4 h-4 text-gray-400 transition-transform duration-200"></i>
                </summary>
                <div class="collapsible-content">
                    <ul class="pl-6 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.sales.index') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.sales.index') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="list" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.sales.index') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">All Sales</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </details>

            <!-- Settings -->
            <details class="group">
                       <summary
                           class="sidebar-item border-l-3 border-transparent flex items-center p-2 text-gray-600 rounded-lg cursor-pointer hover:bg-gray-100 hover:text-gray-700 group text-sm transition-all duration-200 pl-3">
                           <i data-lucide="settings" class="w-5 h-5 text-gray-500 group-hover:text-primary-500 transition-colors"></i>
                           <span class="flex-1 ms-3 whitespace-nowrap text-sm font-medium">Settings</span>
                           <i data-lucide="chevron-right" class="chevron-icon ml-auto w-4 h-4 text-gray-400 transition-transform duration-200"></i>
                       </summary>
                       <div class="collapsible-content">
                           <ul class="pl-6 mt-2 space-y-1">
                               <li>
                                   <a href="{{ route('admin.categories.index') }}"
                                       class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.categories.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                                       <i data-lucide="folder" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.categories.*') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                       <span class="text-sm font-medium">Categories</span>
                                   </a>
                               </li>
                               <li>
                                   <a href="{{ route('admin.brands.index') }}"
                                       class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.brands.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                                       <i data-lucide="tag" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.brands.*') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                       <span class="text-sm font-medium">Brands</span>
                                   </a>
                               </li>
                               <li>
                                   <a href="{{ route('admin.product-models.index') }}"
                                       class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.product-models.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                                       <i data-lucide="package" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.product-models.*') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                       <span class="text-sm font-medium">Product Models</span>
                                   </a>
                               </li>
                               <li>
                                   <a href="{{ route('admin.settings.tax.edit') }}"
                                       class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.settings.tax.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                                       <i data-lucide="percent" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.settings.tax.*') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                       <span class="text-sm font-medium">Tax Settings</span>
                                   </a>
                               </li>
                           </ul>
                       </div>
                   </details>

            <!-- Suppliers -->
            <details class="group">
                <summary
                    class="sidebar-item border-l-3 {{ request()->routeIs('admin.suppliers.*') ? 'border-primary-500 bg-primary-50' : 'border-transparent' }} flex items-center p-2 text-gray-600 rounded-lg cursor-pointer hover:bg-primary-50 hover:text-primary-600 group text-sm transition-all duration-200 pl-3">
                    <i data-lucide="truck" class="w-5 h-5 {{ request()->routeIs('admin.suppliers.*') ? 'text-primary-500' : 'text-gray-500' }} group-hover:text-primary-500 transition-colors"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap text-sm font-medium">Suppliers</span>
                    <i data-lucide="chevron-right" class="chevron-icon ml-auto w-4 h-4 text-gray-400 transition-transform duration-200"></i>
                </summary>
                <div class="collapsible-content">
                    <ul class="pl-6 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.suppliers.index') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.suppliers.index') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="list" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.suppliers.index') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">All Suppliers</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.suppliers.create') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.suppliers.create') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="plus" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.suppliers.create') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">Add New Supplier</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </details>

            <!-- Purchases -->
            <details class="group">
                <summary
                    class="sidebar-item border-l-3 {{ request()->routeIs('admin.purchases.*') ? 'border-primary-500 bg-primary-50' : 'border-transparent' }} flex items-center p-2 text-gray-600 rounded-lg cursor-pointer hover:bg-primary-50 hover:text-primary-600 group text-sm transition-all duration-200 pl-3">
                    <i data-lucide="shopping-bag" class="w-5 h-5 {{ request()->routeIs('admin.purchases.*') ? 'text-primary-500' : 'text-gray-500' }} group-hover:text-primary-500 transition-colors"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap text-sm font-medium">Purchases</span>
                    <i data-lucide="chevron-right" class="chevron-icon ml-auto w-4 h-4 text-gray-400 transition-transform duration-200"></i>
                </summary>
                <div class="collapsible-content">
                    <ul class="pl-6 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.purchases.index') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.purchases.index') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="list" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.purchases.index') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">All Purchases</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.purchases.create') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.purchases.create') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="plus" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.purchases.create') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">Add New Purchase</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </details>

            <!-- Customers -->
            <details class="group">
                <summary
                    class="sidebar-item border-l-3 {{ request()->routeIs('admin.customers.*') ? 'border-primary-500 bg-primary-50' : 'border-transparent' }} flex items-center p-2 text-gray-600 rounded-lg cursor-pointer hover:bg-primary-50 hover:text-primary-600 group text-sm transition-all duration-200 pl-3">
                    <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('admin.customers.*') ? 'text-primary-500' : 'text-gray-500' }} group-hover:text-primary-500 transition-colors"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap text-sm font-medium">Customers</span>
                    <i data-lucide="chevron-right" class="chevron-icon ml-auto w-4 h-4 text-gray-400 transition-transform duration-200"></i>
                </summary>
                <div class="collapsible-content">
                    <ul class="pl-6 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.customers.index') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.customers.index') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="list" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.customers.index') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">All Customers</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.customers.create') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150 {{ request()->routeIs('admin.customers.create') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <i data-lucide="plus" class="w-4 h-4 mr-2 {{ request()->routeIs('admin.customers.create') ? 'text-primary-500' : 'text-gray-400' }} group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">Add New Customer</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </details>

            <!-- User Management -->
            <details class="group">
                <summary
                    class="sidebar-item border-l-3 border-transparent flex items-center p-2 text-gray-600 rounded-lg cursor-pointer hover:bg-gray-100 hover:text-gray-700 group text-sm transition-all duration-200 pl-3">
                    <i data-lucide="users" class="w-5 h-5 text-gray-500 group-hover:text-primary-500 transition-colors"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap text-sm font-medium">User Management</span>
                    <i data-lucide="chevron-right" class="chevron-icon ml-auto w-4 h-4 text-gray-400 transition-transform duration-200"></i>
                </summary>
                <div class="collapsible-content">
                    <ul class="pl-6 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150">
                                <i data-lucide="users" class="w-4 h-4 mr-2 text-gray-400 group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">All Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.create') }}"
                                class="sidebar-item flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-700 text-sm transition-all duration-150">
                                <i data-lucide="user-plus" class="w-4 h-4 mr-2 text-gray-400 group-hover:text-primary-500 transition-colors"></i>
                                <span class="text-sm font-medium">Add New User</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </details>

            <!-- Security Monitoring -->
            <a href="{{ route('admin.security.index') }}"
                class="sidebar-item {{ request()->routeIs('admin.security.*') ? 'active border-l-3 border-primary-500 bg-primary-50' : 'border-l-3 border-transparent' }} flex items-center p-2 text-gray-600 rounded-lg hover:bg-primary-50 hover:text-primary-600 group text-sm transition-all duration-200 pl-3">
                <i data-lucide="shield-alert" class="w-5 h-5 {{ request()->routeIs('admin.security.*') ? 'text-primary-500' : 'text-gray-500' }} group-hover:text-primary-500 transition-colors"></i>
                <span class="ms-3 text-sm font-medium">Security Monitoring</span>
            </a>
        </div>
    </div>

    <!-- User Footer Section -->
    <div class="mt-auto border-t border-gray-200">
        <div class="p-4">
            <div class="flex items-center space-x-3 mb-3">
                <div class="relative">
                    @auth
                    @if(auth()->user()->image)
                        <img src="{{ auth()->user()->image_url }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                    @else
                        <div class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100">
                            <i data-lucide="user" class="w-5 h-5 text-gray-500"></i>
                        </div>
                    @endif
                    @endauth
                    @guest
                    <div class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100">
                        <i data-lucide="user" class="w-5 h-5 text-gray-500"></i>
                    </div>
                    @endguest
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-700 truncate">
                        @auth
                            {{ auth()->user()->name ?? 'User' }}
                        @endauth
                        @guest
                            Guest User
                        @endguest
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        @auth
                            {{ auth()->user()->email ?? '' }}
                        @endauth
                        @guest
                            guest@mubs.ac.ug
                        @endguest
                    </p>
                </div>
                <div class="relative group">
                    <button class="dropdown-trigger text-gray-500 hover:text-gray-600 transition-colors">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                    <div class="dropdown-menu absolute bottom-full right-0 mb-2 w-48 bg-white rounded-lg border border-gray-200 py-1 z-10 hidden opacity-0 translate-y-1 transition-all duration-200">
                        <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors duration-150">
                            <i data-lucide="user" class="w-4 h-4 mr-2 text-gray-400"></i>
                            View Profile
                        </a>
                        <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors duration-150">
                            <i data-lucide="settings" class="w-4 h-4 mr-2 text-gray-400"></i>
                            Account Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-400 hover:bg-gray-50 transition-colors duration-150">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- User Role Badge -->
            @auth
            <div class="flex items-center justify-between px-3 py-2 bg-gradient-to-r from-primary-50 to-primary-100 rounded-lg border border-primary-200">
                <div class="flex items-center gap-2">
                    <i data-lucide="shield" class="w-4 h-4 text-primary-500"></i>
                    <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide">
                        @if(auth()->user()->roles->isNotEmpty())
                            {{ ucfirst(str_replace('-', ' ', auth()->user()->roles->first()->name)) }}
                        @else
                            User
                        @endif
                    </span>
                </div>
            </div>
            @endauth
        </div>
    </div>
</aside>

<script>
    // Toggle dropdown menu
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');

        dropdownTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const menu = this.nextElementSibling;
                menu.classList.toggle('hidden');
                menu.classList.toggle('opacity-0');
                menu.classList.toggle('translate-y-1');
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown-trigger')) {
                const menus = document.querySelectorAll('.dropdown-menu');
                menus.forEach(menu => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden', 'opacity-0', 'translate-y-1');
                    }
                });
            }
        });

        // Toggle details elements (collapsible sections)
        const summaries = document.querySelectorAll('summary');
        summaries.forEach(summary => {
            summary.addEventListener('click', function() {
                const chevron = this.querySelector('.chevron-icon');
                const details = this.closest('details');
                if (chevron && details) {
                    if (details.hasAttribute('open')) {
                        chevron.classList.add('rotate-90');
                    } else {
                        chevron.classList.remove('rotate-90');
                    }
                }
            });
            
            // Set initial chevron state based on open attribute
            const details = summary.closest('details');
            const chevron = summary.querySelector('.chevron-icon');
            if (chevron && details && details.hasAttribute('open')) {
                chevron.classList.add('rotate-90');
            }
        });
        
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

