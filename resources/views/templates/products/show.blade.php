@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div>
        <div class="bg-white border rounded-xl overflow-hidden">
            <div class="aspect-square bg-gray-100">
                @if($product->image_url ?? false)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                @endif
            </div>
            @if(($product->gallery ?? null) && count($product->gallery))
                <div class="p-3 grid grid-cols-4 gap-2">
                    @foreach($product->gallery as $img)
                        <img src="{{ $img }}" class="w-full h-20 object-cover rounded-lg border" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div>
        <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
        <p class="text-sm text-gray-600 mb-4">Réf: {{ $product->sku ?? '-' }}</p>
        <p class="prose max-w-none mb-6">{{ $product->description }}</p>

        <div class="flex items-center justify-between bg-white border rounded-xl p-4 mb-6">
            <span class="text-2xl font-extrabold">{{ number_format($product->price, 2, ',', ' ') }} €</span>
            <span class="text-sm text-gray-600">Stock: {{ $product->stock ?? '—' }}</span>
        </div>

        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center gap-3">
            @csrf
            <input type="number" name="qty" min="1" value="1" class="border rounded-lg px-3 py-2 w-24" />
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white">Ajouter au panier</button>
        </form>

        @if(($related ?? null) && count($related))
            <h2 class="text-xl font-semibold mt-10 mb-3">Produits similaires</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($related as $p)
                    @include('products._card', ['product' => $p])
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
