@extends('layouts.app')

@section('title', 'Commande')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Livraison & Paiement</h1>

<form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    <section class="lg:col-span-2 bg-white border rounded-xl p-4 space-y-4">
        <h2 class="font-semibold">Adresse de livraison</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input class="border rounded-lg px-3 py-2" name="shipping[first_name]" placeholder="Prénom" value="{{ old('shipping.first_name', $shipping['first_name'] ?? auth()->user()->name ?? '') }}">
            <input class="border rounded-lg px-3 py-2" name="shipping[last_name]" placeholder="Nom" value="{{ old('shipping.last_name', $shipping['last_name'] ?? '') }}">
            <input class="border rounded-lg px-3 py-2 md:col-span-2" name="shipping[address]" placeholder="Adresse" value="{{ old('shipping.address', $shipping['address'] ?? '') }}">
            <input class="border rounded-lg px-3 py-2" name="shipping[city]" placeholder="Ville" value="{{ old('shipping.city', $shipping['city'] ?? '') }}">
            <input class="border rounded-lg px-3 py-2" name="shipping[zip]" placeholder="Code postal" value="{{ old('shipping.zip', $shipping['zip'] ?? '') }}">
            <input class="border rounded-lg px-3 py-2 md:col-span-2" name="shipping[email]" placeholder="Email" value="{{ old('shipping.email', auth()->user()->email ?? '') }}">
        </div>

        <h2 class="font-semibold">Mode de paiement</h2>
        <div class="space-y-2">
            <label class="flex items-center gap-2">
                <input type="radio" name="payment_method" value="cod" checked>
                <span>Paiement à la livraison</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="radio" name="payment_method" value="card">
                <span>Carte bancaire (simulation)</span>
            </label>
        </div>
    </section>

    <aside class="bg-white border rounded-xl p-4 h-fit">
        <h2 class="font-semibold mb-3">Résumé</h2>
        <dl class="text-sm space-y-1 mb-3">
            <div class="flex justify-between"><dt>Sous-total</dt><dd>{{ number_format($totals['subtotal'], 2, ',', ' ') }} €</dd></div>
            <div class="flex justify-between"><dt>TVA</dt><dd>{{ number_format($totals['tax'], 2, ',', ' ') }} €</dd></div>
            <div class="flex justify-between font-semibold"><dt>Total</dt><dd>{{ number_format($totals['total'], 2, ',', ' ') }} €</dd></div>
        </dl>
        <button class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white">Confirmer la commande</button>
    </aside>
</form>
@endsection
