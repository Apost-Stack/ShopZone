@extends('layouts.app')

@section('title', 'Commande '.$order->number ?? $order->id)

@section('content')
<h1 class="text-2xl font-semibold mb-4">Commande #{{ $order->number ?? $order->id }}</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <section class="lg:col-span-2 bg-white border rounded-xl p-4">
        <h2 class="font-semibold mb-3">Articles</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                            @if($item->image_url ?? false)
                                <img src="{{ $item->image_url }}" class="w-full h-full object-cover"/>
                            @endif
                        </div>
                        <div>
                            <div class="font-semibold">{{ $item->name }}</div>
                            <div class="text-sm text-gray-600">x{{ $item->qty }} @ {{ number_format($item->price, 2, ',', ' ') }} €</div>
                        </div>
                    </div>
                    <div class="font-bold">{{ number_format($item->subtotal, 2, ',', ' ') }} €</div>
                </div>
            @endforeach
        </div>
    </section>

    <aside class="bg-white border rounded-xl p-4 h-fit">
        <h2 class="font-semibold mb-3">Résumé</h2>
        <dl class="text-sm space-y-1 mb-3">
            <div class="flex justify-between"><dt>Sous-total</dt><dd>{{ number_format($order->subtotal, 2, ',', ' ') }} €</dd></div>
            <div class="flex justify-between"><dt>TVA</dt><dd>{{ number_format($order->tax, 2, ',', ' ') }} €</dd></div>
            <div class="flex justify-between font-semibold"><dt>Total</dt><dd>{{ number_format($order->total, 2, ',', ' ') }} €</dd></div>
        </dl>
        <p class="text-sm text-gray-600">Statut: <strong>{{ __($order->status) }}</strong></p>
    </aside>
</div>
@endsection
