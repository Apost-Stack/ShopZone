@extends('layout')

@section('title', 'Login')

@section('content')
{{-- Start login --}}
<section id="login" class="login section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10">
            <div class="auth-container" data-aos="fade-in" data-aos-delay="200">

              <!-- Login Form -->
              <div class="auth-form login-form active">
                <div class="form-header">
                  <h3>Welcome Back</h3>
                  <p>Sign in to your account</p>
                </div>

                <form class="auth-form-content" action="{{ route('Auth.login') }}" method="POST">
                    @csrf
                  <div class="input-group mb-3">
                    <span class="input-icon">
                      <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control" 
                                       placeholder="votre@email.com"
                                       value="{{ old('email') }}"
                                       required>
                                        @error('email')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                  </div>

                  <div class="input-group mb-3">
                    <span class="input-icon">
                      <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control" 
                                       placeholder="••••••••"
                                       required>
                    <span class="password-toggle">
                      <i class="bi bi-eye"></i>
                    </span>
                  </div>

                  <div class="form-options mb-4">
                    <div class="remember-me">
                      <input type="checkbox" 
                                   name="remember" 
                                   id="remember" 
                                   class="form-check-input">
                            <label for="remember" class="form-check-label">
                                Se souvenir de moi
                            </label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                  </div>

                  <button type="submit" class="auth-btn primary-btn mb-3">
                    Sign In
                    <i class="bi bi-arrow-right"></i>
                  </button>

                  <div class="divider">
                    <span>or</span>
                  </div>

                  <button type="button" class="auth-btn social-btn">
                    <i class="bi bi-google"></i>
                    Continue with Google
                  </button>

                  <div class="switch-form">
                     <p class="mb-2">Vous n'avez pas de compte ?</p>
                        <a href="{{ route('Auth.register') }}">
                            <i class="fas fa-user-plus me-1"></i>
                            Créer un compte
                        </a>
                        <br>
                        <a href="#" class="text-muted small mt-2 d-inline-block">
                            Mot de passe oublié ?
                        </a>
                  </div>
                </form>

            </div>
          </div>
        </div>

      </div>

    </section><!-- /Login Section -->

{{-- End login --}}

@endsection

