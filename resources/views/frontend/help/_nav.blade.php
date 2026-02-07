@php
    $helpPages = [
        'help-center' => ['Help Center', 'help-circle'],
        'place-order' => ['Place an Order', 'shopping-cart'],
        'payment-options' => ['Payment Options', 'credit-card'],
        'delivery-tracking' => ['Delivery & Track Order', 'truck'],
        'returns-refunds' => ['Returns and Refunds', 'rotate-ccw'],
        'warranty' => ['Warranty', 'shield-check'],
    ];
@endphp
<nav class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
    <h3 class="font-semibold text-gray-900 mb-3 text-sm -m -fs20 -elli">Help topics</h3>
    <ul class="space-y-1">
        @foreach($helpPages as $slug => $label)
            @php list($name, $icon) = is_array($label) ? $label : [$label, 'file-text']; @endphp
            <li>
                <a href="{{ route('frontend.help.show', $slug) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ (isset($page) && $page === $slug) ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-600' }} transition-colors">
                    <i data-lucide="{{ $icon }}" class="w-4 h-4 flex-shrink-0"></i>
                    {{ $name }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
