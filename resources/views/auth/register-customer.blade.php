@extends('layout')

@section('title', 'Créer un compte client')

@section('content')
<section id="register" class="register section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="registration-form-wrapper">
          <div class="form-header text-center">
            <h2>Créer un compte client</h2>
            <p>Remplissez le formulaire ci-dessous pour finaliser votre inscription.</p>
          </div>

          <div class="row">
            <div class="col-lg-8 mx-auto">
              <form method="POST" action="{{ route('Auth.register') }}">
                @csrf

                <!-- Section User -->
                <h5 class="mb-3"><i class="fas fa-user me-2"></i>Informations de connexion</h5>

                <div class="form-floating mb-3">
                  <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror" required autocomplete="name" placeholder="Nom d'utilisateur">
                  <label for="name">Nom d'utilisateur</label>
                  @error('name')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" required autocomplete="email" placeholder="Email">
                  <label for="email">Email</label>
                  @error('email')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required minlength="8" autocomplete="new-password" placeholder="Mot de passe">
                      <label for="password">Mot de passe</label>
                      @error('password')
                        <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control" required minlength="8" autocomplete="new-password" placeholder="Confirmer le mot de passe">
                      <label for="password_confirmation">Confirmer le mot de passe</label>
                    </div>
                  </div>
                </div>

                <!-- Section Infos Client -->
                <h5 class="mt-4 mb-3"><i class="fas fa-id-card me-2"></i>Informations personnelles</h5>

                <div class="form-floating mb-3">
                  <input type="text" name="customer[first_name]" id="first_name" value="{{ old('customer.first_name') }}"
                    class="form-control @error('customer.first_name') is-invalid @enderror" required placeholder="Prénom">
                  <label for="first_name">Prénom</label>
                  @error('customer.first_name')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <input type="text" name="customer[last_name]" id="last_name" value="{{ old('customer.last_name') }}"
                    class="form-control @error('customer.last_name') is-invalid @enderror" required placeholder="Nom">
                  <label for="last_name">Nom</label>
                  @error('customer.last_name')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <input type="text" name="customer[phone]" id="phone" value="{{ old('customer.phone') }}"
                    class="form-control @error('customer.phone') is-invalid @enderror" placeholder="Téléphone">
                  <label for="phone">Téléphone</label>
                  @error('customer.phone')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <input type="date" name="customer[birthday]" id="birthday" value="{{ old('customer.birthday') }}"
                    class="form-control @error('customer.birthday') is-invalid @enderror" placeholder="Date de naissance">
                  <label for="birthday">Date de naissance</label>
                  @error('customer.birthday')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <select name="customer[civility]" id="civility"
                    class="form-select @error('customer.civility') is-invalid @enderror" aria-label="Civilité">
                    <option value="">-- Sélectionner --</option>
                    <option value="M" {{ old('customer.civility') == 'M' ? 'selected' : '' }}>Monsieur</option>
                    <option value="Mme" {{ old('customer.civility') == 'Mme' ? 'selected' : '' }}>Madame</option>
                  </select>
                  <label for="civility">Civilité</label>
                  @error('customer.civility')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <select name="customer[province_id]" id="province_id"
                    class="form-select @error('customer.province_id') is-invalid @enderror" aria-label="Province">
                    <option value="">-- Choisir une province --</option>
                    @foreach($provinces as $province)
                      <option value="{{ $province->id }}" {{ old('customer.province_id') == $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                      </option>
                    @endforeach
                  </select>
                  <label for="province_id">Province</label>
                  @error('customer.province_id')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-4">
                  <textarea name="customer[address]" id="address"
                    class="form-control @error('customer.address') is-invalid @enderror" placeholder="Adresse" style="height:100px;">{{ old('customer.address') }}</textarea>
                  <label for="address">Adresse</label>
                  @error('customer.address')
                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                  @enderror
                </div>

                <div class="d-grid mb-4">
                  <button type="submit" class="btn btn-register btn-primary">
                    <i class="fas fa-check-circle me-1"></i> S'inscrire
                  </button>
                </div>

                <div class="login-link text-center">
                  <p>Vous avez déjà un compte ? <a href="{{ route('Auth.login') }}">Se connecter</a></p>
                </div>
              </form>
            </div>
          </div>

          <!-- Social Login -->
          <div class="social-login mt-4">
            <div class="row">
              <div class="col-lg-8 mx-auto">
                <div class="divider my-3 text-center">
                  <span>ou s'inscrire avec</span>
                </div>
                <div class="social-buttons d-flex justify-content-center gap-2">
                  <a href="#" class="btn btn-social">
                    <i class="bi bi-google"></i>
                    <span class="ms-2">Google</span>
                  </a>
                  <a href="#" class="btn btn-social">
                    <i class="bi bi-facebook"></i>
                    <span class="ms-2">Facebook</span>
                  </a>
                  <a href="#" class="btn btn-social">
                    <i class="bi bi-apple"></i>
                    <span class="ms-2">Apple</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Decorative elements -->
          <div class="decorative-elements">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <div class="square square-1"></div>
            <div class="square square-2"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- /Register Section -->
@endsection
