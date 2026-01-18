<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mubs Script Marking & Tracing System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <!-- Hero Section -->
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="MUBS Logo" class="h-10 w-10 mr-3">
                        <div>
                            <span class="text-lg font-semibold text-gray-900">MUBS</span>
                            <p class="text-xs text-gray-500">Script Marking & Tracing</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">About</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                        <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors">Login</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Mubs Script Marking & Tracing System
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Efficient script management, marking, and tracing system for Makerere University Business School
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="bg-blue-500 text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-blue-600 transition-colors">
                        Get Started
                    </a>
                    <a href="#" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg text-lg font-medium hover:bg-gray-50 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Key Features</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="file-text" class="w-6 h-6 text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Script Management</h3>
                        <p class="text-gray-600">Efficiently manage and organize all examination scripts in one centralized system.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Script Marking</h3>
                        <p class="text-gray-600">Streamlined marking process with real-time updates and progress tracking.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="search" class="w-6 h-6 text-purple-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Script Tracing</h3>
                        <p class="text-gray-600">Track and trace scripts throughout the entire examination process.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-gray-600">
                    <p>&copy; {{ date('Y') }} Mubs Script Marking & Tracing System. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>

