<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-2 py-2 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <!-- Sidebar Toggle and Branding -->
            <div class="flex items-center justify-start">
                <!-- Sidebar Toggle -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 border border-transparent hover:border-gray-300 transition-all duration-200">
                    <span class="sr-only">Open sidebar</span>
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

                <a href="{{ route('dashboard') }}" class="flex items-center ms-2 md:me-8 hover:opacity-80 transition-opacity duration-200">
                    <!-- Logo -->
                    <img src="{{ asset('assets/images/logo.png') }}" alt="ApexDevHub Logo" class="h-12 w-auto ml-3 object-contain">
                    
                </a>
            </div>

            <!-- Right Side Icons and Actions -->
            <div class="flex items-center space-x-3">
                <!-- Notifications -->
                <div class="relative group" id="notifications-container">
                    <button type="button" id="notifications-btn"
                        class="p-2 text-gray-500 rounded-lg hover:text-gray-700 hover:bg-gray-100 relative transition-all duration-200 border border-transparent hover:border-gray-300">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span id="notification-badge"
                            class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs text-white bg-red-500 rounded-full border border-white hidden">
                            0
                        </span>
                        <span class="sr-only">View notifications</span>
                    </button>
                    <div id="notifications-dropdown"
                        class="invisible group-hover:visible opacity-0 group-hover:opacity-100 absolute right-0 mt-2 w-80 bg-white border border-gray-300 rounded-lg text-gray-700 z-50 transition-all duration-300 ease-in-out shadow-lg">
                        <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                            <p class="text-sm font-medium text-gray-800">Notifications</p>
                            <button type="button" id="mark-all-read-btn" class="text-xs text-primary-500 hover:text-primary-600 transition-colors">Mark all as read</button>
                        </div>
                        <div id="notifications-list" class="max-h-72 overflow-y-auto">
                            <div class="flex items-center justify-center py-8">
                                <div class="text-center">
                                    <i data-lucide="loader-2" class="w-6 h-6 text-gray-400 animate-spin mx-auto mb-2"></i>
                                    <p class="text-xs text-gray-500">Loading notifications...</p>
                                </div>
                            </div>
                        </div>
                        <div id="notifications-empty" class="hidden flex items-center justify-center py-8">
                            <div class="text-center">
                                <i data-lucide="bell-off" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
                                <p class="text-sm text-gray-500">No notifications</p>
                            </div>
                        </div>
                        <a href="#"
                            class="block text-center text-sm font-medium text-primary-500 bg-gray-50 hover:bg-gray-100 py-2 rounded-b-lg border-t border-gray-200 transition-colors">
                            View all notifications
                        </a>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative group">
                    <button type="button"
                        class="flex items-center gap-2 bg-white rounded-lg p-1 text-sm border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                        @auth
                        @if(auth()->user()->image)
                            <img src="{{ auth()->user()->image_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center text-gray-700 border border-primary-200">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                        @endif
                        <div class="hidden md:block text-left mr-1">
                            <div class="text-xs font-medium text-gray-800">{{ auth()->user()->name ?? 'User' }}</div>
                            <div class="text-[10px] text-gray-500">
                                @if(auth()->user()->roles->isNotEmpty())
                                    {{ ucfirst(str_replace('-', ' ', auth()->user()->roles->first()->name)) }}
                                @else
                                    User
                                @endif
                            </div>
                        </div>
                        @endauth
                        @guest
                        <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center text-gray-700 border border-primary-200">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <div class="hidden md:block text-left mr-1">
                            <div class="text-xs font-medium text-gray-800">Guest</div>
                            <div class="text-[10px] text-gray-500">User</div>
                        </div>
                        @endguest
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>

                    <div
                        class="invisible group-hover:visible opacity-0 group-hover:opacity-100 absolute right-0 mt-2 w-56 bg-white border border-gray-300 rounded-lg text-gray-700 z-50 transition-all duration-300 ease-in-out">
                        @auth
                        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-500 truncate">
                                {{ auth()->user()->email ?? '' }}
                            </p>
                        </div>
                        @endauth
                        <ul class="py-1">
                            <li>
                                <a href="{{ route('profile.show') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                    <i data-lucide="user" class="w-4 h-4 mr-2 text-gray-500"></i>
                                    My Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.show') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                    <i data-lucide="settings" class="w-4 h-4 mr-2 text-gray-500"></i>
                                    Account Settings
                                </a>
                            </li>
                            <li class="border-t border-gray-200 mt-1">
                                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="flex items-center px-4 py-2 text-sm hover:bg-gray-50 text-red-500 transition-colors duration-150">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                                        Sign out
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.querySelector('[data-drawer-toggle="logo-sidebar"]');
        const sidebar = document.getElementById('logo-sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
        
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Load notifications
        loadNotifications();
        
        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);
    });

    function loadNotifications() {
        fetch('/admin/notifications?unread_only=1&limit=5', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            updateNotificationBadge(data.unread_count || 0);
            updateNotificationsList(data.notifications || []);
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
    }

    function updateNotificationBadge(count) {
        const badge = document.getElementById('notification-badge');
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    function updateNotificationsList(notifications) {
        const list = document.getElementById('notifications-list');
        const empty = document.getElementById('notifications-empty');
        
        if (notifications.length === 0) {
            list.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }
        
        empty.classList.add('hidden');
        
        const colorClasses = {
            'primary': 'bg-primary-50 text-primary-600 border-primary-200',
            'green': 'bg-green-50 text-green-600 border-green-200',
            'yellow': 'bg-yellow-50 text-yellow-600 border-yellow-200',
            'red': 'bg-red-50 text-red-600 border-red-200',
            'purple': 'bg-purple-50 text-purple-600 border-purple-200',
        };
        
        list.innerHTML = notifications.map(notif => {
            const colorClass = colorClasses[notif.color] || colorClasses['primary'];
            const isRead = notif.read_at !== null;
            const bgClass = isRead ? 'bg-white' : 'bg-blue-50';
            
            return `
                <a href="#" class="notification-item flex px-4 py-3 hover:bg-gray-50 border-b border-gray-100 transition-colors ${bgClass}" 
                   data-notification-id="${notif.id}" onclick="markAsRead(${notif.id}); return false;">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full ${colorClass} flex items-center justify-center border">
                            <i data-lucide="${notif.icon}" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="ml-3 w-full">
                        <p class="text-sm font-medium text-gray-800">${escapeHtml(notif.title)}</p>
                        <p class="text-xs text-gray-500 truncate">${escapeHtml(notif.message)}</p>
                        <p class="text-xs text-gray-400 mt-1">${notif.time_ago}</p>
                    </div>
                </a>
            `;
        }).join('');
        
        lucide.createIcons();
    }

    function markAsRead(notificationId) {
        fetch(`/admin/notifications/${notificationId}/read`, {
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }

    function markAllAsRead() {
        fetch('/admin/notifications/mark-all-read', {
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
            }
        })
        .catch(error => {
            console.error('Error marking all as read:', error);
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Mark all as read button
    document.addEventListener('DOMContentLoaded', function() {
        const markAllBtn = document.getElementById('mark-all-read-btn');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                markAllAsRead();
            });
        }
    });
</script>

