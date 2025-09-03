@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <section class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Nouveautés</h1>
            <a href="{{ route('products.index') }}" class="text-sm hover:underline">Voir tous les produits</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($latestProducts ?? [] as $product)
                @include('products._card', ['product' => $product])
            @empty
                <p>Aucun produit pour le moment.</p>
            @endforelse
        </div>
    </section>
@endsection
