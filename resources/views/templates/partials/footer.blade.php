<footer class="bg-white border-t">
    <div class="container mx-auto px-4 py-6 text-sm text-gray-600 flex flex-col md:flex-row gap-2 md:gap-6 justify-between">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'MyShop') }}. Tous droits réservés.</p>
        <p><a href="{{ route('legal') }}" class="hover:underline">Mentions légales</a></p>
    </div>
</footer>
