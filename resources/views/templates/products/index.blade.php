@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')
<div class="flex flex-col md:flex-row gap-6">
    <aside class="md:w-64">
        <div class="bg-white border rounded-xl p-4">
            <h2 class="font-semibold mb-3">Filtres</h2>
            <form method="GET" action="{{ route('products.index') }}" class="space-y-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher..."
                       class="border rounded-lg w-full px-3 py-2" />
                <select name="category" class="border rounded-lg w-full px-3 py-2">
                    <option value="">Toutes catégories</option>
                    @foreach(($categories ?? []) as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <input type="number" name="min" min="0" step="0.01" value="{{ request('min') }}" placeholder="Min €"
                           class="border rounded-lg w-1/2 px-3 py-2" />
                    <input type="number" name="max" min="0" step="0.01" value="{{ request('max') }}" placeholder="Max €"
                           class="border rounded-lg w-1/2 px-3 py-2" />
                </div>

                <select name="sort" class="border rounded-lg w-full px-3 py-2">
                    <option value="">Tri par défaut</option>
                    <option value="price_asc" @selected(request('sort')=='price_asc')>Prix croissant</option>
                    <option value="price_desc" @selected(request('sort')=='price_desc')>Prix décroissant</option>
                    <option value="new" @selected(request('sort')=='new')>Nouveautés</option>
                    <option value="popular" @selected(request('sort')=='popular')>Populaires</option>
                </select>
                <button class="w-full bg-gray-900 text-white py-2 rounded-lg">Appliquer</button>
            </form>
        </div>
    </aside>

    <section class="flex-1">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Catalogue</h1>
            <p class="text-sm text-gray-600">{{ $products->total() ?? count($products ?? []) }} résultat(s)</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($products as $product)
                @include('products._card', ['product' => $product])
            @empty
                <p>Aucun produit trouvé.</p>
            @endforelse
        </div>

        @if(method_exists($products, 'links'))
            <div class="mt-6">{{ $products->withQueryString()->links() }}</div>
        @endif
    </section>
</div>
@endsection
