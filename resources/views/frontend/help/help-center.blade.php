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
                <aside class="lg:col-span-1">
                    @include('frontend.help._nav')
                </aside>
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                        <div class="p-6 sm:p-8 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-white">
                            <h1 class="font-bold text-gray-900 -m -fs20 -elli">{{ $title }}</h1>
                            <p class="text-base text-gray-600 mt-1">Find answers and get support for shopping at Apex Electronics.</p>
                        </div>
                        <div class="p-6 sm:p-8 prose prose-gray max-w-none">
                            <p class="text-sm text-gray-600 leading-relaxed mb-4">Welcome to the Apex Electronics Help Center. Here you can learn how to place orders, choose payment methods, track delivery, request returns, and understand our warranty.</p>
                            <div class="grid sm:grid-cols-2 gap-4 mt-6">
                                <a href="{{ route('frontend.help.show', 'place-order') }}" class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-colors">
                                    <span class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center"><i data-lucide="shopping-cart" class="w-5 h-5 text-primary-600"></i></span>
                                    <div><span class="font-medium text-gray-900">Place an Order</span><br><span class="text-xs text-gray-500">Step-by-step guide</span></div>
                                </a>
                                <a href="{{ route('frontend.help.show', 'payment-options') }}" class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-colors">
                                    <span class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center"><i data-lucide="credit-card" class="w-5 h-5 text-primary-600"></i></span>
                                    <div><span class="font-medium text-gray-900">Payment Options</span><br><span class="text-xs text-gray-500">MTN, Airtel, cards</span></div>
                                </a>
                                <a href="{{ route('frontend.help.show', 'delivery-tracking') }}" class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-colors">
                                    <span class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center"><i data-lucide="truck" class="w-5 h-5 text-primary-600"></i></span>
                                    <div><span class="font-medium text-gray-900">Delivery & Tracking</span><br><span class="text-xs text-gray-500">Timelines and tracking</span></div>
                                </a>
                                <a href="{{ route('frontend.help.show', 'returns-refunds') }}" class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-colors">
                                    <span class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center"><i data-lucide="rotate-ccw" class="w-5 h-5 text-primary-600"></i></span>
                                    <div><span class="font-medium text-gray-900">Returns & Refunds</span><br><span class="text-xs text-gray-500">7-day return policy</span></div>
                                </a>
                            </div>
                            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600"><strong>Need more help?</strong> Call us on <a href="tel:0200804020" class="text-primary-600 font-medium">0200804020</a> or <a href="https://wa.me/256200804010" target="_blank" rel="noopener" class="text-primary-600 font-medium">WhatsApp 0200804010</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
