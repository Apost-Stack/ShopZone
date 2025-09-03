<header class="bg-white border-b">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xl font-bold hover:opacity-80">
            {{ config('app.name', 'MyShop') }}
        </a>

        <form action="{{ route('search') }}" method="GET" class="hidden md:flex items-center gap-2">
            <input name="q" value="{{ request('q') }}"
                   class="border rounded-lg px-3 py-2 w-64" placeholder="Rechercher un produit..." />
            <button class="px-3 py-2 rounded-lg bg-gray-900 text-white">OK</button>
        </form>

        <nav class="flex items-center gap-4">
            <a class="hover:underline" href="{{ route('products.index') }}">Produits</a>
            <a class="hover:underline" href="{{ route('cart.index') }}">
                Panier ({{ session('cart.count', 0) }})
            </a>

            @auth
                <a class="hover:underline" href="{{ route('orders.index') }}">Mes commandes</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="hover:underline">Déconnexion</button>
                </form>
            @else
                <a class="hover:underline" href="{{ route('login') }}">Connexion</a>
            @endauth
        </nav>
    </div>

    <div class="md:hidden px-4 py-3">
        <form action="{{ route('search') }}" method="GET" class="flex gap-2">
            <input name="q" value="{{ request('q') }}"
                   class="border rounded-lg px-3 py-2 w-full" placeholder="Rechercher..." />
            <button class="px-3 py-2 rounded-lg bg-gray-900 text-white">OK</button>
        </form>
    </div>
</header>
