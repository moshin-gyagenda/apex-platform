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
                            <p class="text-base text-gray-600 mt-1">Product warranty and quality assurance.</p>
                        </div>
                        <div class="p-6 sm:p-8 prose prose-gray max-w-none">
                            <p class="text-sm text-gray-600 mb-4">At Apex Electronics, we work with trusted suppliers. Our products come with manufacturer warranty where applicable. Warranty terms (duration and coverage) may vary by product and brand.</p>
                            <h2 class="font-semibold text-gray-900 mt-6 mb-2 text-base">What is covered</h2>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>Manufacturing defects within the warranty period.</li>
                                <li>Terms as stated on the product packaging or listing.</li>
                            </ul>
                            <h2 class="font-semibold text-gray-900 mt-6 mb-2 text-base">Claiming warranty</h2>
                            <p class="text-sm text-gray-600 mb-4">Keep your receipt and any warranty card. If you experience a defect, contact us with your order details: call <a href="tel:0200804020" class="text-primary-600 font-medium">0200804020</a> or <a href="https://wa.me/256200804010" target="_blank" rel="noopener" class="text-primary-600 font-medium">WhatsApp 0200804010</a>. We will assist you with the warranty claim process.</p>
                            <p class="text-sm text-gray-600">We are committed to product quality and authenticity. If you have any concerns, reach out and we’ll help resolve them.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
