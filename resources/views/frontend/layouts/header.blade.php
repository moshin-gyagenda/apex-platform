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
                    <!-- <span class="font-bold text-gray-900 -m -fs20 -elli">Apex Electronics</span> -->
                    
                </a>
            </div>
            
            <!-- Search Bar - Desktop (Center) -->
            <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
                <div class="relative w-full flex items-center" id="search-wrapper">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            id="search-input"
                            placeholder="Search products, brands and categories" 
                            autocomplete="off"
                            class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        >
                        <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                        <div id="search-autocomplete" class="hidden absolute left-0 right-0 top-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-h-80 overflow-y-auto"></div>
                    </div>
                    <button 
                        type="button"
                        id="search-btn"
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
                    <button class="flex items-center space-x-1 text-gray-700 hover:text-primary-600 transition-colors focus:outline-none">
                        <i data-lucide="user" class="w-5 h-5"></i>
                        <span class="hidden sm:block text-sm font-medium">Account</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            @auth
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                            @else
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <a href="{{ route('login') }}" class="block w-full bg-primary-500 hover:bg-primary-600 text-white text-center py-2.5 rounded-lg font-medium transition-colors">
                                        Sign In
                                    </a>
                                </div>
                            @endauth
                            
                            <a href="{{ auth()->check() ? route('frontend.dashboard.account-settings') : '#' }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                My Account
                            </a>
                            <a href="{{ route('frontend.orders.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i data-lucide="package" class="w-4 h-4 mr-2"></i>
                                Orders
                            </a>
                            <a href="{{ route('frontend.wishlists.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i data-lucide="heart" class="w-4 h-4 mr-2"></i>
                                Wishlist
                            </a>
                            
                            @auth
                                <div class="border-t border-gray-200 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Help Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-1 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg text-gray-700 hover:text-primary-600 transition-colors focus:outline-none">
                        <i data-lucide="help-circle" class="w-5 h-5"></i>
                        <span class="hidden sm:block text-sm font-medium">Help</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <a href="{{ route('frontend.help.show', 'help-center') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                Help Center
                            </a>
                            <a href="{{ route('frontend.help.show', 'place-order') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                Place an Order
                            </a>
                            <a href="{{ route('frontend.help.show', 'payment-options') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                Payments Options
                            </a>
                            <a href="{{ route('frontend.help.show', 'delivery-tracking') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                Delivery Timelines & Track your order
                            </a>
                            <a href="{{ route('frontend.help.show', 'returns-refunds') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                Returns and Refunds
                            </a>
                            <a href="{{ route('frontend.help.show', 'warranty') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                Warranty
                            </a>
                            
                            <div class="border-t border-gray-200 mt-2 pt-2 px-4 space-y-2">
                                <a href="tel:+256700000000" class="flex items-center justify-center w-full bg-primary-500 hover:bg-primary-600 text-white py-2.5 rounded-lg font-medium transition-colors">
                                    <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
                                    Live Help
                                </a>
                                <a href="https://wa.me/256700000000" target="_blank" class="flex items-center justify-center w-full bg-green-500 hover:bg-green-600 text-white py-2.5 rounded-lg font-medium transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    WhatsApp
                                </a>
                            </div>
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
        
    </nav>
</header>

<!-- Mobile off-canvas sidebar (Jumia-style) -->
<div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity" aria-hidden="true" onclick="closeMobileSidebar()"></div>
<aside id="mobile-sidebar" class="fixed top-0 left-0 h-full w-[85%] max-w-[320px] bg-white shadow-xl z-50 transform -translate-x-full transition-transform duration-300 ease-out overflow-y-auto lg:hidden" aria-label="Mobile menu">
    <div class="flex flex-col h-full">
        <!-- Sidebar header -->
        <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 flex-shrink-0">
            <button type="button" onclick="closeMobileSidebar()" class="p-2 -ml-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900" aria-label="Close menu">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            <a href="{{ route('frontend.index') }}" onclick="closeMobileSidebar()" class="flex items-center">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Apex Electronics" class="h-8 w-auto">
            </a>
            <span class="w-10"></span>
        </div>

        <!-- Sidebar search -->
        <div class="relative px-4 py-3 border-b border-gray-200">
            <div class="relative flex items-center gap-2" id="sidebar-search-wrapper">
                <input type="text" id="mobile-search-input" placeholder="Search products..." autocomplete="off"
                       class="flex-1 w-0 pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 text-sm">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                <button type="button" id="mobile-search-btn" class="flex-shrink-0 bg-primary-500 hover:bg-primary-600 text-white px-3 py-2.5 rounded-lg text-sm font-medium">Search</button>
            </div>
            <div id="mobile-search-autocomplete" class="hidden absolute left-4 right-4 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-h-60 overflow-y-auto"></div>
        </div>

        <!-- Need Help -->
        <a href="{{ route('frontend.help.show', 'help-center') }}" onclick="closeMobileSidebar()" class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-50 border-b border-gray-100">
            <span class="font-medium">NEED HELP?</span>
            <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
        </a>

        <!-- My Account -->
        <div class="border-b border-gray-100">
            <a href="{{ auth()->check() ? route('frontend.dashboard.account-settings') : route('login') }}" onclick="closeMobileSidebar()" class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-50">
                <span class="font-medium">MY ACCOUNT</span>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
            </a>
            <div class="pl-4 pb-2 space-y-0">
                <a href="{{ route('frontend.orders.index') }}" onclick="closeMobileSidebar()" class="flex items-center gap-3 py-2 text-sm text-gray-600 hover:text-primary-600">
                    <i data-lucide="package" class="w-4 h-4 text-gray-500"></i> Orders
                </a>
                <a href="{{ route('frontend.wishlists.index') }}" onclick="closeMobileSidebar()" class="flex items-center gap-3 py-2 text-sm text-gray-600 hover:text-primary-600">
                    <i data-lucide="heart" class="w-4 h-4 text-gray-500"></i> Wishlist
                </a>
            </div>
        </div>

        <!-- Our Categories -->
        <div class="flex-1 py-3 overflow-y-auto">
            <div class="flex items-center justify-between px-4 mb-2">
                <h3 class="font-semibold text-gray-900">OUR CATEGORIES</h3>
                <a href="{{ route('frontend.index') }}#categories" onclick="closeMobileSidebar()" class="text-sm font-medium text-primary-600 hover:text-primary-700">See All</a>
            </div>
            <ul class="px-2">
                @php $sidebarCats = $sidebarCategories ?? []; @endphp
                @forelse($sidebarCats as $category)
                    <li>
                        <a href="{{ route('frontend.index') }}?category={{ $category->id }}#products" onclick="closeMobileSidebar()"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                            <span class="w-9 h-9 rounded-lg bg-primary-50 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="folder" class="w-4 h-4 text-primary-500"></i>
                            </span>
                            <span class="font-medium truncate">{{ $category->name }}</span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 ml-auto flex-shrink-0"></i>
                        </a>
                    </li>
                @empty
                    <li class="px-4 py-4 text-sm text-gray-500">No categories yet</li>
                @endforelse
            </ul>
        </div>
    </div>
</aside>

<script>
    function toggleMobileMenu() {
        const sidebar = document.getElementById('mobile-sidebar');
        const backdrop = document.getElementById('mobile-sidebar-backdrop');
        if (sidebar && backdrop) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    function closeMobileSidebar() {
        const sidebar = document.getElementById('mobile-sidebar');
        const backdrop = document.getElementById('mobile-sidebar-backdrop');
        if (sidebar && backdrop) {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    (function() {
        const searchInput = document.getElementById('search-input');
        const mobileSearchInput = document.getElementById('mobile-search-input');
        const searchAutocomplete = document.getElementById('search-autocomplete');
        const mobileSearchAutocomplete = document.getElementById('mobile-search-autocomplete');
        const searchBtn = document.getElementById('search-btn');
        const mobileSearchBtn = document.getElementById('mobile-search-btn');
        let searchTimeout = null;
        const debounceMs = 300;

        function getActiveInput() {
            var sidebar = document.getElementById('mobile-sidebar');
            if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                return mobileSearchInput;
            }
            return searchInput;
        }

        function getActiveDropdown() {
            var sidebar = document.getElementById('mobile-sidebar');
            return (sidebar && !sidebar.classList.contains('-translate-x-full')) ? mobileSearchAutocomplete : searchAutocomplete;
        }

        function getQuery(inputEl) {
            return (inputEl || getActiveInput()).value.trim();
        }

        function goToSearchResults(query) {
            if (query) {
                window.location.href = '{{ route("frontend.index") }}?search=' + encodeURIComponent(query) + '#products';
            }
        }

        function performLiveSearch(query, dropdownEl, inputEl) {
            if (!query || query.length < 2) {
                dropdownEl.classList.add('hidden');
                dropdownEl.innerHTML = '';
                return;
            }
            fetch('{{ route("frontend.search.products") }}?search=' + encodeURIComponent(query), {
                method: 'GET',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (!data.products || data.products.length === 0) {
                    dropdownEl.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">No products found. Try different keywords.</div>';
                } else {
                    dropdownEl.innerHTML = data.products.map(function(p) {
                        return '<a href="' + p.url + '" class="flex items-center gap-3 px-4 py-3 hover:bg-primary-50 border-b border-gray-100 last:border-0 text-left">' +
                            '<img src="' + p.image + '" alt="" class="w-10 h-10 object-cover rounded flex-shrink-0">' +
                            '<div class="flex-1 min-w-0">' +
                            '<div class="font-medium text-gray-900 truncate">' + (p.name || '') + '</div>' +
                            '<div class="text-xs text-gray-500">' + (p.category || '') + (p.brand && p.brand !== '—' ? ' · ' + p.brand : '') + '</div>' +
                            '</div>' +
                            '<div class="text-sm font-semibold text-primary-600">UGX ' + (typeof p.selling_price === 'number' ? p.selling_price.toLocaleString() : (p.selling_price || '')) + '</div>' +
                            '</a>';
                    }).join('');
                }
                dropdownEl.classList.remove('hidden');
            })
            .catch(function() {
                dropdownEl.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">Search unavailable. Try again.</div>';
                dropdownEl.classList.remove('hidden');
            });
        }

        function onInput(inputEl, dropdownEl) {
            var q = inputEl.value.trim();
            clearTimeout(searchTimeout);
            if (q.length < 2) {
                dropdownEl.classList.add('hidden');
                dropdownEl.innerHTML = '';
                return;
            }
            searchTimeout = setTimeout(function() {
                performLiveSearch(q, dropdownEl, inputEl);
            }, debounceMs);
        }

        function onEnter(inputEl, dropdownEl) {
            var q = inputEl.value.trim();
            if (q) {
                dropdownEl.classList.add('hidden');
                dropdownEl.innerHTML = '';
                goToSearchResults(q);
            }
        }

        function closeDropdowns() {
            if (searchAutocomplete) searchAutocomplete.classList.add('hidden');
            if (mobileSearchAutocomplete) mobileSearchAutocomplete.classList.add('hidden');
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() { onInput(searchInput, searchAutocomplete); });
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') { e.preventDefault(); onEnter(searchInput, searchAutocomplete); }
            });
        }
        if (mobileSearchInput) {
            mobileSearchInput.addEventListener('input', function() { onInput(mobileSearchInput, mobileSearchAutocomplete); });
            mobileSearchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') { e.preventDefault(); onEnter(mobileSearchInput, mobileSearchAutocomplete); }
            });
        }
        if (searchBtn) searchBtn.addEventListener('click', function() { onEnter(searchInput, searchAutocomplete); });
        if (mobileSearchBtn) mobileSearchBtn.addEventListener('click', function() { onEnter(mobileSearchInput, mobileSearchAutocomplete); });

        document.addEventListener('click', function(e) {
            var w = document.getElementById('search-wrapper');
            var m = document.getElementById('sidebar-search-wrapper');
            if (w && !w.contains(e.target) && m && !m.contains(e.target)) closeDropdowns();
        });
    })();

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