<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Account - Apex Electronics & Accessories</title>
    
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
                        navy: {
                            50: '#f0f4fb',
                            100: '#d9e4f5',
                            200: '#b3c9eb',
                            300: '#8daee1',
                            400: '#6793d7',
                            500: '#0f4c9e',
                            600: '#0c3d7e',
                            700: '#092e5f',
                            800: '#061f3f',
                            900: '#031020',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    navy: {
                        50: '#f0f4fb',
                        100: '#d9e4f5',
                        200: '#b3c9eb',
                        300: '#8daee1',
                        400: '#6793d7',
                        500: '#0f4c9e',
                        600: '#0c3d7e',
                        700: '#092e5f',
                        800: '#061f3f',
                        900: '#031020',
                    },
                },
            },
        }
    </script>
    
    <style>
        html, body {
            height: 100%;
            overflow: hidden;
        }
        
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background-color: #F9FAFB;
        }
        
        .custom-shadow {
            box-shadow: inset 0px 0px 0px 1px rgba(0, 0, 0, 0.1);
        }
        
        .custom-shadow-sm {
            box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.03), 0px 1px 2px 0px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center p-4 lg:p-6 overflow-hidden">
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-300">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row h-full max-h-[90vh]">
            <!-- Left Column: Registration Form -->
            <div class="text-sm leading-5 flex-1 p-4 lg:p-8 bg-white custom-shadow rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none overflow-y-auto">
                <!-- Logo -->
                <div class="flex items-center gap-2 mb-4">
                    <a href="{{ route('frontend.index') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Apex Electronics Logo" class="h-10 w-10">
                        <div class="flex flex-col">
                            <span class="text-base font-semibold text-gray-900">Apex Electronics</span>
                            
                        </div>
                    </a>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-3 bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-lg text-sm">
                        <div class="flex items-start gap-2">
                            <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <div class="font-medium text-xs">Whoops! Something went wrong.</div>
                                <ul class="mt-1 list-disc list-inside text-xs">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2 text-gray-900">
                            Full Name
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="user" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                required 
                                autofocus
                                autocomplete="name"
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-sm"
                                placeholder="John Doe"
                            >
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2 text-gray-900">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                autocomplete="username"
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-sm"
                                placeholder="you@example.com"
                            >
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium mb-2 text-gray-900">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-sm"
                                placeholder="Create a strong password"
                            >
                            <button 
                                type="button"
                                onclick="togglePassword('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                <i data-lucide="eye" id="password-eye" class="h-5 w-5"></i>
                            </button>
                        </div>
                        
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium mb-2 text-gray-900">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-sm"
                                placeholder="Confirm your password"
                            >
                            <button 
                                type="button"
                                onclick="togglePassword('password_confirmation')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                <i data-lucide="eye" id="password_confirmation-eye" class="h-5 w-5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div>
                        <div class="flex items-start">
                            <input 
                                id="terms" 
                                name="terms" 
                                type="checkbox" 
                                required
                                class="h-4 w-4 mt-1 rounded border-gray-300 text-primary-500 focus:ring-primary-500"
                            >
                            <label for="terms" class="ml-2 block text-xs text-gray-700">
                                I agree to the 
                                <a href="{{ route('terms.show') }}" target="_blank" class="text-primary-600 hover:text-primary-500 font-medium">Terms of Service</a>
                                and 
                                <a href="{{ route('policy.show') }}" target="_blank" class="text-primary-600 hover:text-primary-500 font-medium">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center py-2.5 px-5 rounded-lg text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors"
                    >
                        <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                        Create Account
                    </button>
                </form>

                <!-- Sign In Link -->
                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500 transition-colors">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>

            <!-- Right Column: Visual/Branding -->
            <div class="relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg w-full lg:w-[438px] shrink-0 overflow-hidden flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100">
                <!-- Branding Content -->
                <div class="p-4 lg:p-8 text-center">
                    <div class="mb-4">
                        <a href="{{ route('frontend.index') }}" class="inline-flex items-center space-x-2 mb-4">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="Apex Electronics" class="h-16 w-16">
                            <div class="text-left">
                                <div class="flex items-center space-x-1">
                                    <span class="text-xl font-bold text-gray-900">Apex</span>
                                    <span class="text-primary-500 text-xl">★</span>
                                </div>
                                <span class="text-xs text-gray-600">Electronics & Accessories</span>
                            </div>
                        </a>
                        <h2 class="text-xl font-semibold mb-2 text-gray-900">Join Apex Today</h2>
                        <p class="text-xs leading-relaxed max-w-xs mx-auto text-gray-600">
                            Create your account and unlock exclusive benefits, faster checkout, and personalized shopping experience.
                        </p>
                    </div>
                    
                    <!-- Feature List -->
                    <div class="space-y-3 mt-4">
                        <div class="flex items-center gap-2 text-left">
                            <div class="flex items-center justify-center rounded-full w-6 h-6 border flex-shrink-0 custom-shadow-sm bg-white border-gray-200">
                                <i data-lucide="gift" class="w-3 h-3 text-primary-500"></i>
                            </div>
                            <span class="text-xs text-gray-900">Exclusive member-only deals</span>
                        </div>
                        <div class="flex items-center gap-2 text-left">
                            <div class="flex items-center justify-center rounded-full w-6 h-6 border flex-shrink-0 custom-shadow-sm bg-white border-gray-200">
                                <i data-lucide="truck" class="w-3 h-3 text-primary-500"></i>
                            </div>
                            <span class="text-xs text-gray-900">Free delivery on orders over UGX 100,000</span>
                        </div>
                        <div class="flex items-center gap-2 text-left">
                            <div class="flex items-center justify-center rounded-full w-6 h-6 border flex-shrink-0 custom-shadow-sm bg-white border-gray-200">
                                <i data-lucide="shield-check" class="w-3 h-3 text-primary-500"></i>
                            </div>
                            <span class="text-xs text-gray-900">Secure & protected shopping</span>
                        </div>
                    </div>
                </div>
                
                <div class="absolute inset-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg custom-shadow pointer-events-none"></div>
            </div>
        </main>
    </div>

    <script>
        // Initialize Lucide icons
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
    </script>
</body>
</html>
