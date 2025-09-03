@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Connexion</h1>
<form method="POST" action="{{ route('login') }}" class="bg-white border rounded-xl p-4 max-w-md space-y-3">
    @csrf
    <div>
        <label class="text-sm">Email</label>
        <input name="email" type="email" required class="border rounded-lg w-full px-3 py-2" value="{{ old('email') }}">
        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm">Mot de passe</label>
        <input name="password" type="password" required class="border rounded-lg w-full px-3 py-2">
        @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white w-full">Se connecter</button>
</form>
@endsection
