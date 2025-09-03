@props(['product'])

<a href="{{ route('products.show', $product) }}"
   class="bg-white border rounded-xl overflow-hidden hover:shadow-md transition block">
    <div class="aspect-square bg-gray-100">
        @if($product->image_url ?? false)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover" />
        @endif
    </div>
    <div class="p-4">
        <h3 class="font-semibold line-clamp-1">{{ $product->name }}</h3>
        <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ $product->excerpt ?? Str::limit($product->description, 80) }}</p>
        <div class="flex items-center justify-between">
            <span class="font-bold">{{ number_format($product->price, 2, ',', ' ') }} €</span>
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <input type="hidden" name="qty" value="1">
                <button class="text-sm px-3 py-1.5 rounded-lg bg-gray-900 text-white">Ajouter</button>
            </form>
        </div>
    </div>
</a>
