@extends('layouts.app')

@section('title', 'Résultats de recherche')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Résultats pour “{{ request('q') }}”</h1>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse($products as $product)
        @include('products._card', ['product' => $product])
    @empty
        <p>Aucun résultat.</p>
    @endforelse
</div>

@if(method_exists($products, 'links'))
    <div class="mt-6">{{ $products->withQueryString()->links() }}</div>
@endif
@endsection
