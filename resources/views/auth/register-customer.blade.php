@extends('layout')

@section('title', 'Créer un compte client')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm rounded-4">
                <!-- Header -->
                <div class="card-header text-center bg-primary text-white rounded-top-4">
                    <div class="mb-2">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h3 class="card-title mb-1">Créer un compte client</h3>
                    <p class="mb-0 small">Remplissez le formulaire ci-dessous pour finaliser votre inscription.</p>
                </div>

                <!-- Formulaire -->
                <div class="card-body">
                    <form method="POST" action="{{ route('Auth.register') }}">
                        @csrf

                        <!-- Section User -->
                        <h5 class="mb-3"><i class="fas fa-user me-2"></i>Informations de connexion</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom d'utilisateur</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            @error('name') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" required>
                            </div>
                            @error('email') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-eye"></i></button>
                            </div>
                            @error('password') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required>
                            </div>
                        </div>

                        <!-- Section Infos Client -->
                        <h5 class="mt-4 mb-3"><i class="fas fa-id-card me-2"></i>Informations personnelles</h5>

                        <div class="mb-3">
                            <label for="first_name" class="form-label">Prénom</label>
                            <input type="text" name="customer[first_name]" id="first_name" value="{{ old('customer.first_name') }}"
                                class="form-control @error('customer.first_name') is-invalid @enderror" required>
                            @error('customer.first_name') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Nom</label>
                            <input type="text" name="customer[last_name]" id="last_name" value="{{ old('customer.last_name') }}"
                                class="form-control @error('customer.last_name') is-invalid @enderror" required>
                            @error('customer.last_name') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="text" name="customer[phone]" id="phone" value="{{ old('customer.phone') }}"
                                class="form-control @error('customer.phone') is-invalid @enderror">
                            @error('customer.phone') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="birthday" class="form-label">Date de naissance</label>
                            <input type="date" name="customer[birthday]" id="birthday" value="{{ old('customer.birthday') }}"
                                class="form-control @error('customer.birthday') is-invalid @enderror">
                            @error('customer.birthday') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="civility" class="form-label">Civilité</label>
                            <select name="customer[civility]" id="civility"
                                class="form-select @error('customer.civility') is-invalid @enderror">
                                <option value="">-- Sélectionner --</option>
                                <option value="M" {{ old('customer.civility') == 'M' ? 'selected' : '' }}>Monsieur</option>
                                <option value="Mme" {{ old('customer.civility') == 'Mme' ? 'selected' : '' }}>Madame</option>
                            </select>
                            @error('customer.civility') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="province_id" class="form-label">Province</label>
                            <select name="customer[province_id]" id="province_id"
                                class="form-select @error('customer.province_id') is-invalid @enderror">
                                <option value="">-- Choisir une province --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ old('customer.province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer.province_id') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea name="customer[address]" id="address"
                                class="form-control @error('customer.address') is-invalid @enderror">{{ old('customer.address') }}</textarea>
                            @error('customer.address') 
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle me-1"></i> S'inscrire
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p class="mb-0">Vous avez déjà un compte ? <a href="{{ route('Auth.login') }}">Se connecter</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
