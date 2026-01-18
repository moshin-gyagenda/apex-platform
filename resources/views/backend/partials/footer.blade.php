<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:ml-64">
        <div class="border-t border-gray-200 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-6">
                    <p class="text-sm text-gray-600">
                        © {{ date('Y') }} <span class="font-semibold text-gray-900">Mubs Script Marking & Tracing System</span>. All rights reserved.
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Made with</span>
                    <i data-lucide="heart" class="w-4 h-4 text-red-500"></i>
                    <span class="text-sm text-gray-600">for MUBS</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>

