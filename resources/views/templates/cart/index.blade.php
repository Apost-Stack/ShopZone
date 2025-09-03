@extends('layouts.app')

@section('title', 'Votre panier')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Votre panier</h1>

@if(empty($items) || count($items) === 0)
    <x-alert type="info">Votre panier est vide.</x-alert>
    <a href="{{ route('products.index') }}" class="inline-block mt-2 text-sm hover:underline">Commencer mes achats →</a>
@else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2 bg-white border rounded-xl p-4">
            <div class="space-y-4">
                @foreach($items as $rowId => $line)
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                            @if($line['image_url'] ?? false)
                                <img src="{{ $line['image_url'] }}" class="w-full h-full object-cover" />
                            @endif
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('products.show', $line['product']) }}" class="font-semibold hover:underline">
                                {{ $line['name'] }}
                            </a>
                            <p class="text-sm text-gray-600">Prix: {{ number_format($line['price'], 2, ',', ' ') }} €</p>
                            <form action="{{ route('cart.update', $rowId) }}" method="POST" class="mt-2 flex items-center gap-2">
                                @csrf @method('PUT')
                                <input type="number" name="qty" min="1" value="{{ $line['qty'] }}" class="border rounded-lg px-3 py-1 w-24" />
                                <button class="px-3 py-1 rounded-lg bg-gray-900 text-white text-sm">Mettre à jour</button>
                            </form>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">{{ number_format($line['subtotal'], 2, ',', ' ') }} €</p>
                            <form action="{{ route('cart.remove', $rowId) }}" method="POST" class="mt-2">
                                @csrf @method('DELETE')
                                <button class="text-sm text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <aside class="bg-white border rounded-xl p-4 h-fit">
            <h2 class="font-semibold mb-3">Résumé</h2>
            <dl class="text-sm space-y-1 mb-3">
                <div class="flex justify-between"><dt>Sous-total</dt><dd>{{ number_format($totals['subtotal'], 2, ',', ' ') }} €</dd></div>
                <div class="flex justify-between"><dt>TVA</dt><dd>{{ number_format($totals['tax'], 2, ',', ' ') }} €</dd></div>
                <div class="flex justify-between font-semibold"><dt>Total</dt><dd>{{ number_format($totals['total'], 2, ',', ' ') }} €</dd></div>
            </dl>
            <a href="{{ route('checkout.index') }}" class="block text-center px-4 py-2 rounded-lg bg-gray-900 text-white">Passer à la caisse</a>
        </aside>
    </div>
@endif
@endsection
