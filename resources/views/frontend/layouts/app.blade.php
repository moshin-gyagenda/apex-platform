<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Apex Electronics & Accessories')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Flowbite for carousel -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.8.1/dist/flowbite.min.css" rel="stylesheet" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#ff9b50',
                            500: '#FF7839',
                            600: '#ea5a0f',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                        navy: {
                            50: '#f0f4fb',
                            100: '#d9e4f5',
                            200: '#b3c9eb',
                            300: '#7fa3dc',
                            400: '#4a7bc9',
                            500: '#0f4c9e',
                            600: '#003571',
                            700: '#002a5a',
                            800: '#001f43',
                            900: '#00152d',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #FF7839;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ea5a0f;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Product card hover effect */
        .product-card {
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #FF7839 0%, #ea5a0f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Glass morphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        /* Toast notification animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out;
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    @include('frontend.layouts.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Confirmation / Alert modal (backend-style) -->
    @include('frontend.layouts.partials.confirm-modal')
    
    @yield('scripts')
    
    <script>
        // Toast notifications (same style as index – fixed top-right, auto-dismiss)
        function showSuccessToast(message) {
            var toast = document.createElement('div');
            toast.id = 'success-toast';
            toast.className = 'fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-fade-in-up';
            toast.innerHTML = '<i data-lucide="check-circle" class="w-6 h-6 flex-shrink-0"></i><span class="font-medium">' + (message || '') + '</span><button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200"><i data-lucide="x" class="w-5 h-5"></i></button>';
            document.body.appendChild(toast);
            if (typeof lucide !== 'undefined') lucide.createIcons();
            setTimeout(function() {
                if (toast.parentElement) {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.3s';
                    setTimeout(function() { toast.remove(); }, 300);
                }
            }, 3000);
        }
        function showErrorToast(message) {
            var toast = document.createElement('div');
            toast.id = 'error-toast';
            toast.className = 'fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-fade-in-up';
            toast.innerHTML = '<i data-lucide="alert-circle" class="w-6 h-6 flex-shrink-0"></i><span class="font-medium">' + (message || '') + '</span><button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200"><i data-lucide="x" class="w-5 h-5"></i></button>';
            document.body.appendChild(toast);
            if (typeof lucide !== 'undefined') lucide.createIcons();
            setTimeout(function() {
                if (toast.parentElement) {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.3s';
                    setTimeout(function() { toast.remove(); }, 300);
                }
            }, 4000);
        }
        // Show session flash as toast on load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
            @if(session('success'))
            showSuccessToast(@json(session('success')));
            @endif
            @if(session('error'))
            showErrorToast(@json(session('error')));
            @endif
        });
        
        // Search functionality
        function handleSearch(event) {
            if (event.key === 'Enter') {
                const query = event.target.value;
                if (query.trim()) {
                    // TODO: Implement search functionality
                    console.log('Searching for:', query);
                }
            }
        }
    </script>
    
    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.8.1/dist/flowbite.min.js"></script>
</body>
</html>
