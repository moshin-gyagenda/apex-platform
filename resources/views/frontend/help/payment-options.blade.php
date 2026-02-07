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
                            <p class="text-base text-gray-600 mt-1">Pay the way that suits you.</p>
                        </div>
                        <div class="p-6 sm:p-8 prose prose-gray max-w-none">
                            <p class="text-sm text-gray-600 mb-4">We accept the following payment methods for your convenience:</p>
                            <ul class="space-y-3 text-sm text-gray-600">
                                <li class="flex items-start gap-2"><span class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5"><i data-lucide="banknote" class="w-3.5 h-3.5 text-primary-600"></i></span><strong class="text-gray-900">Pay on Delivery</strong> — Pay with cash or mobile money when your order is delivered.</li>
                                <li class="flex items-start gap-2"><span class="w-6 h-6 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0 mt-0.5"><i data-lucide="smartphone" class="w-3.5 h-3.5 text-yellow-700"></i></span><strong class="text-gray-900">MTN Mobile Money</strong> — Pre-pay or pay on delivery using your MTN MoMo number.</li>
                                <li class="flex items-start gap-2"><span class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5"><i data-lucide="smartphone" class="w-3.5 h-3.5 text-red-700"></i></span><strong class="text-gray-900">Airtel Money</strong> — Pre-pay or pay on delivery using Airtel Money.</li>
                                <li class="flex items-start gap-2"><span class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5"><i data-lucide="credit-card" class="w-3.5 h-3.5 text-primary-600"></i></span><strong class="text-gray-900">Debit / Credit cards</strong> — Pay securely online with Visa or Mastercard.</li>
                            </ul>
                            <p class="mt-6 text-sm text-gray-600">All transactions are secure. If you have issues with payment, contact us on <a href="tel:0200804020" class="text-primary-600 font-medium">0200804020</a> or <a href="https://wa.me/256200804010" target="_blank" rel="noopener" class="text-primary-600 font-medium">WhatsApp</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
