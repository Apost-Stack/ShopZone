<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | ShopZone - Votre Boutique en Ligne</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @yield('css')
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #f59e0b;
            --dark-color: #1e293b;
            --light-gray: #f8fafc;
            --border-color: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        /* Top Bar */
        .top-bar {
            background: var(--dark-color);
            color: white;
            font-size: 0.875rem;
            padding: 0.5rem 0;
        }
        
        .top-bar a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .top-bar a:hover {
            color: var(--secondary-color);
        }
        
        /* Header */
        .main-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color) !important;
            text-decoration: none;
        }
        
        .search-bar {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .search-input {
            border: 2px solid var(--border-color);
            border-radius: 50px;
            padding: 0.75rem 3rem 0.75rem 1.5rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            outline: none;
        }
        
        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .search-btn:hover {
            background: #1d4ed8;
        }
        
        .header-icons {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .header-icon {
            position: relative;
            color: var(--dark-color);
            font-size: 1.25rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .header-icon:hover {
            color: var(--primary-color);
        }
        
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
        
        /* Navigation */
        .main-nav {
            background: var(--light-gray);
            border-bottom: 1px solid var(--border-color);
        }
        
        .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
            background: white;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .cta-button {
            background: var(--secondary-color);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
            color: white;
        }
        
        /* Footer */
        .main-footer {
            background: var(--dark-color);
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer-section h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer-section ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-section ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-section ul li a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-section ul li a:hover {
            color: var(--secondary-color);
        }
        
        .social-icons {
            display: flex;
            gap: 1rem;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            color: white;
        }
        
        .footer-bottom {
            border-top: 1px solid #374151;
            margin-top: 2rem;
            padding-top: 1rem;
            text-align: center;
            color: #9ca3af;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .search-bar {
                margin: 1rem 0;
            }
            
            .header-icons {
                gap: 1rem;
            }
            
            .top-bar .d-none.d-md-block {
                display: none !important;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span><i class="fas fa-shipping-fast me-2"></i>Livraison gratuite dès 50€</span>
                </div>
                <div class="col-md-6 text-end d-none d-md-block">
                    <a href="#" class="me-3"><i class="fas fa-phone me-1"></i>01 23 45 67 89</a>
                    <a href="#"><i class="fas fa-envelope me-1"></i>contact@shopstyle.fr</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="container">
            <div class="row align-items-center py-3">
                <!-- Logo -->
                <div class="col-lg-2 col-md-3 col-6">
                    <a href="{{route('welcome')}}" class="navbar-brand">
                        <i class="fas fa-store me-2"></i>ShopStyle
                    </a>
                </div>
                
                <!-- Search Bar -->
                <div class="col-lg-6 col-md-5 col-12 order-3 order-md-2 mt-3 mt-md-0">
                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Rechercher un produit...">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Header Icons -->
                <div class="col-lg-4 col-md-4 col-6 order-2 order-md-3">
                    <div class="header-icons justify-content-end">
                        <a href="#" class="header-icon">
                            <i class="fas fa-user"></i>
                        </a>
                        <a href="#" class="header-icon">
                            <i class="fas fa-heart"></i>
                            <span class="badge-counter">3</span>
                        </a>
                        <a href="#" class="header-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge-counter">2</span>
                        </a>
                        <button class="btn d-lg-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <div class="container">
            <div class="collapse navbar-collapse" id="mobileNav">
                <ul class="navbar-nav w-100 justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Femme</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Homme</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Enfant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Accessoires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Soldes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   @yield('hero')

    <!-- Main Content Area -->
    <main class="main-content">
        <div class="container my-4">
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5><i class="fas fa-store me-2"></i>ShopStyle</h5>
                        <p class="mb-3">Votre boutique en ligne de confiance pour la mode et les accessoires. Qualité garantie et livraison rapide.</p>
                        <div class="social-icons">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5>Liens Rapides</h5>
                        <ul>
                            <li><a href="#">Accueil</a></li>
                            <li><a href="#">Boutique</a></li>
                            <li><a href="#">À propos</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Categories -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5>Catégories</h5>
                        <ul>
                            <li><a href="#">Mode Femme</a></li>
                            <li><a href="#">Mode Homme</a></li>
                            <li><a href="#">Enfants</a></li>
                            <li><a href="#">Chaussures</a></li>
                            <li><a href="#">Accessoires</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Customer Service -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5>Service Client</h5>
                        <ul>
                            <li><a href="#">Mon Compte</a></li>
                            <li><a href="#">Suivi Commande</a></li>
                            <li><a href="#">Retours</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Support</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5>Contact</h5>
                        <ul>
                            <li><i class="fas fa-map-marker-alt me-2"></i>123 Rue de la Mode, Paris</li>
                            <li><i class="fas fa-phone me-2"></i>01 23 45 67 89</li>
                            <li><i class="fas fa-envelope me-2"></i>contact@shopstyle.fr</li>
                            <li><i class="fas fa-clock me-2"></i>Lun-Sam: 9h-20h</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p>&copy; 2024 ShopStyle. Tous droits réservés.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="#" class="text-muted me-3">Conditions d'utilisation</a>
                        <a href="#" class="text-muted me-3">Politique de confidentialité</a>
                        <a href="#" class="text-muted">Mentions légales</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                console.log('Recherche:', this.value);
                // Ajoutez ici votre logique de recherche
            }
        });
        
        // Cart animation on add
        function addToCart() {
            const cartIcon = document.querySelector('.fa-shopping-cart').closest('.header-icon');
            cartIcon.style.transform = 'scale(1.2)';
            setTimeout(() => {
                cartIcon.style.transform = 'scale(1)';
            }, 200);
        }
    </script>
</body>
</html>