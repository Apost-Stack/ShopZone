@extends('layout')
@section('css')
<style>
     .badge-counter {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--secondary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Login Container */
        .login-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            padding: 3rem 0;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: white;
            text-align: center;
            padding: 2.5rem 2rem 2rem;
        }
        
        .login-header h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .login-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .login-form {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
            background: white;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 2;
        }
        
        .input-group .form-control {
            padding-left: 3rem;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            z-index: 2;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .form-check-input {
            margin-right: 0.75rem;
            width: 18px;
            height: 18px;
        }
        
        .form-check-label {
            font-size: 0.95rem;
            color: #6b7280;
            cursor: pointer;
        }
        
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
            color: #9ca3af;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
            z-index: 1;
        }
        
        .divider span {
            background: white;
            padding: 0 1rem;
            position: relative;
            z-index: 2;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        
        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .register-link a:hover {
            color: #1d4ed8;
        }
        
        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: var(--error-color);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 0.5rem;
        }
        
        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .social-btn {
            flex: 1;
            padding: 0.875rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: white;
            color: #6b7280;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-1px);
        }
        
        .social-btn i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
</style>
@endsection
@section('title', 'Login')

@section('content')
<div class="login-container">
        <div class="container">
            <div class="login-card">
                <!-- Login Header -->
                <div class="login-header">
                    <div class="login-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2>Connexion</h2>
                    <p>Accédez à votre espace personnel</p>
                </div>

                <!-- Login Form -->
                <div class="login-form">
                    <!-- Social Login -->
                    <div class="social-login">
                        <a href="#" class="social-btn">
                            <i class="fab fa-google" style="color: #db4437;"></i>
                            Google
                        </a>
                        <a href="#" class="social-btn">
                            <i class="fab fa-facebook-f" style="color: #4267B2;"></i>
                            Facebook
                        </a>
                    </div>

                    <div class="divider">
                        <span>ou</span>
                    </div>

                    <form method="POST" action="{{ route('Auth.login') }}">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label">Adresse Email</label>
                            <div class="input-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control" 
                                       placeholder="votre@email.com"
                                       value="{{ old('email') }}"
                                       required>
                            </div>
                            @error('email')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control" 
                                       placeholder="••••••••"
                                       required>
                                <button type="button" class="password-toggle" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check">
                            <input type="checkbox" 
                                   name="remember" 
                                   id="remember" 
                                   class="form-check-input">
                            <label for="remember" class="form-check-label">
                                Se souvenir de moi
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Se connecter
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="register-link">
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
                </div>
            </div>
        </div>
    </div>
@endsection

