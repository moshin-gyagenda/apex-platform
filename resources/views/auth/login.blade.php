<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In - Apex Platform</title>
    
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
        body { font-family: 'Inter', sans-serif; }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: white;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #FF7839;
            box-shadow: 0 0 0 3px rgba(255, 120, 57, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Apex Platform Logo" class="h-14 w-14">
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-gray-900">Apex Platform</span>
                    <span class="text-xs text-gray-500 font-normal">Inventory Management System</span>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h1>
                <p class="text-gray-600">Sign in to access your inventory management system</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-start gap-2">
                        <i data-lucide="alert-circle" class="w-5 h-5 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="font-medium">Whoops! Something went wrong.</div>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginFormElement">
                @csrf

                <input type="hidden" name="location" id="login_location">
                <input type="hidden" name="latitude" id="login_latitude">
                <input type="hidden" name="longitude" id="login_longitude">

                @if(request()->has('intended'))
                    <input type="hidden" name="intended" value="{{ request()->input('intended') }}">
                @endif

                <!-- Email Field -->
                <div>
                    <label for="login_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="login_email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            class="form-input pl-10"
                            placeholder="you@example.com"
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="login_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="login_password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="form-input pl-10 pr-10"
                            placeholder="Enter your password"
                        >
                        <button 
                            type="button"
                            onclick="togglePassword('login_password')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <i data-lucide="eye" id="login_password-eye" class="h-5 w-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember_me" 
                            name="remember" 
                            type="checkbox" 
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-gray-300 rounded"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-500 hover:text-primary-600 transition-colors">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200"
                >
                    <i data-lucide="log-in" class="w-4 h-4 mr-2"></i>
                    Sign In
                </button>
            </form>

            <!-- Sign Up Link -->
            @if (Route::has('register'))
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-primary-500 hover:text-primary-600 transition-colors">
                        Sign up for free
                    </a>
                </p>
            </div>
            @endif
        </div>
    </div>

    <script>
        lucide.createIcons();

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(inputId + '-eye');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            
            lucide.createIcons();
        }

        // Location Detection Function
        function detectLocation() {
            let locationString = '';
            let latitude = null;
            let longitude = null;

            // Try to get location from geolocation API
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                        
                        // Set coordinates
                        document.getElementById('login_latitude').value = latitude;
                        document.getElementById('login_longitude').value = longitude;
                        
                        // Use reverse geocoding to get location name
                        fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${latitude}&longitude=${longitude}&localityLanguage=en`)
                            .then(response => response.json())
                            .then(data => {
                                locationString = `${data.city || ''}, ${data.principalSubdivision || ''}, ${data.countryName || ''}`.replace(/^,\s*|,\s*$/g, '');
                                document.getElementById('login_location').value = locationString;
                            })
                            .catch(() => {
                                // Fallback to coordinates as location string
                                locationString = `${latitude}, ${longitude}`;
                                document.getElementById('login_location').value = locationString;
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
                                    document.getElementById('login_latitude').value = latitude;
                                    document.getElementById('login_longitude').value = longitude;
                                }
                                document.getElementById('login_location').value = locationString;
                            })
                            .catch(() => {
                                // Final fallback
                                locationString = 'Unknown Location';
                                document.getElementById('login_location').value = locationString;
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
                            document.getElementById('login_latitude').value = latitude;
                            document.getElementById('login_longitude').value = longitude;
                        }
                        document.getElementById('login_location').value = locationString;
                    })
                    .catch(() => {
                        locationString = 'Unknown Location';
                        document.getElementById('login_location').value = locationString;
                    });
            }
        }

        // Detect location on page load
        document.addEventListener('DOMContentLoaded', function() {
            detectLocation();
        });
    </script>
</body>
</html>
