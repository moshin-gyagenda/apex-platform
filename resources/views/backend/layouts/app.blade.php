<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Apex Platform - Dashboard</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
        
        .sidebar-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: #f9fafb;
        }
        
        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        
        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        .border-l-3 {
            border-left-width: 3px;
        }
        
        .sidebar-item:hover {
            background-color: #fff7ed;
            color: #FF7839;
        }
        
        .sidebar-item.active {
            background-color: #fff7ed;
            color: #FF7839;
        }
        
        .chevron-icon {
            transition: transform 0.2s ease;
        }
        
        details[open] .chevron-icon {
            transform: rotate(90deg);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    @include('backend.partials.header')

    <!-- Sidebar -->
    @include('backend.partials.sidebar')

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('backend.partials.footer')

    @yield('scripts')
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>

