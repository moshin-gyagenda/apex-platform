@extends('frontend.layouts.app')

@section('title', $title . ' - Apex Electronics & Accessories')

@section('content')
    <nav class="bg-gray-100 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('frontend.index') }}" class="text-gray-600 hover:text-primary-600">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <a href="{{ route('frontend.help.show', 'help-center') }}" class="text-gray-600 hover:text-primary-600">Help</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-900">{{ $title }}</span>
            </div>
        </div>
    </nav>

    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">@include('frontend.help._nav')</aside>
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                        <div class="p-6 sm:p-8 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-white">
                            <h1 class="font-bold text-gray-900 -m -fs20 -elli">{{ $title }}</h1>
                            <p class="text-base text-gray-600 mt-1">Delivery timelines and how to track your order.</p>
                        </div>
                        <div class="p-6 sm:p-8 prose prose-gray max-w-none">
                            <h2 class="font-semibold text-gray-900 mt-6 mb-2 text-base">Delivery timelines</h2>
                            <p class="text-sm text-gray-600 mb-4">Delivery time varies by location. Most orders within <strong>Kampala</strong> are delivered within <strong>1–3 business days</strong>. For areas outside Kampala, delivery may take a few more days depending on your location.</p>
                            <h2 class="font-semibold text-gray-900 mt-6 mb-2 text-base">Track your order</h2>
                            <p class="text-sm text-gray-600 mb-4">After your order is confirmed and shipped, we will send you updates via SMS or phone. You can also contact us to check the status of your order:</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>Call <a href="tel:0200804020" class="text-primary-600 font-medium">0200804020</a> with your order number.</li>
                                <li>WhatsApp <a href="https://wa.me/256200804010" target="_blank" rel="noopener" class="text-primary-600 font-medium">0200804010</a> for quick updates.</li>
                            </ul>
                            <p class="mt-6 text-sm text-gray-600">Free delivery is available on orders over UGX 500,000. Otherwise, delivery fees may apply based on your area.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
