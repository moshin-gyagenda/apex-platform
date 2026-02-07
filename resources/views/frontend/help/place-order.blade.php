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
                            <p class="text-base text-gray-600 mt-1">How to order from Apex Electronics in a few simple steps.</p>
                        </div>
                        <div class="p-6 sm:p-8 prose prose-gray max-w-none">
                            <ol class="space-y-4 list-decimal list-inside text-sm text-gray-600">
                                <li><strong class="text-gray-900">Browse</strong> — Visit our website and explore categories or use the search bar to find products.</li>
                                <li><strong class="text-gray-900">Add to cart</strong> — Click “Add to Cart” on the items you want. You can adjust quantity in the cart.</li>
                                <li><strong class="text-gray-900">Checkout</strong> — Go to your cart and click “Proceed to Checkout”. Enter your delivery details and choose a payment method.</li>
                                <li><strong class="text-gray-900">Pay</strong> — Complete payment via Pay on Delivery, MTN Mobile Money, Airtel Money, or card as per your choice.</li>
                                <li><strong class="text-gray-900">Confirmation</strong> — You’ll receive an order confirmation. We’ll notify you when your order is shipped.</li>
                            </ol>
                            <p class="mt-6 text-sm text-gray-600">You can also <a href="tel:0200804020" class="text-primary-600 font-medium">call us on 0200804020</a> or <a href="https://wa.me/256200804010" target="_blank" rel="noopener" class="text-primary-600 font-medium">WhatsApp 0200804010</a> to place an order with assistance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
