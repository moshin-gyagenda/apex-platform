<footer class="bg-gray-900 text-gray-300 mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Apex Electronics Logo" class="h-10 w-auto">
                    <span class="text-xl font-bold text-white">Apex Electronics</span>
                </div>
                <p class="text-sm text-gray-400 mb-4">
                    Your trusted source for quality electronics and accessories. We offer the latest products at competitive prices.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-500 transition-colors">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-500 transition-colors">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-500 transition-colors">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-500 transition-colors">
                        <i data-lucide="linkedin" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('frontend.index') }}" class="text-sm hover:text-primary-400 transition-colors">Home</a></li>
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">Products</a></li>
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">Categories</a></li>
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">About Us</a></li>
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">Contact</a></li>
                </ul>
            </div>
            
            <!-- Customer Service -->
            <div>
                <h3 class="text-white font-semibold mb-4">Customer Service</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">My Account</a></li>
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">Order Tracking</a></li>
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">Returns & Exchanges</a></li>
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">Shipping Info</a></li>
                    <li><a href="#" class="text-sm hover:text-primary-400 transition-colors">FAQs</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h3 class="text-white font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-3">
                    <li class="flex items-start space-x-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-primary-400 flex-shrink-0 mt-0.5"></i>
                        <span class="text-sm">123 Electronics Street, Kampala, Uganda</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i data-lucide="phone" class="w-5 h-5 text-primary-400 flex-shrink-0"></i>
                        <span class="text-sm">+256 700 000 000</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i data-lucide="mail" class="w-5 h-5 text-primary-400 flex-shrink-0"></i>
                        <span class="text-sm">info@apexelectronics.com</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} Apex Electronics & Accessories. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">Terms of Service</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-primary-400 transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
