<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Annor Boutique | Chapeaux & Bijoux</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        :root {
            --annor-blue: #1a2a44;
            --annor-gold: #d4af37;
        }
        /* Navbar aux couleurs du logo */
        .navbar-annor {
            background-color: var(--annor-blue) !important;
            border-bottom: 3px solid var(--annor-gold);
            padding: 10px 0;
        }
        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: 0.3s;
            padding: 10px 15px !important;
        }
        .nav-link:hover {
            color: var(--annor-gold) !important;
        }
        /* Style du Badge Panier */
        .cart-badge-container {
            position: relative;
            display: inline-block;
        }
        #panier-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: #ff4757;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 50%;
            font-weight: bold;
            box-shadow: 0 0 10px rgba(255, 71, 87, 0.5);
        }
        /* Amélioration du menu sur mobile */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: var(--annor-blue);
                padding: 15px;
                border-radius: 10px;
                margin-top: 10px;
                border: 1px solid var(--annor-gold);
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-annor sticky-top shadow">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="accueil">
            <img src="images/logo.jpg" alt="Logo Annor" width="45" height="45" class="me-2 shadow-sm" style="border-radius: 50%; border: 1px solid var(--annor-gold);">
            <span style="letter-spacing: 1px; font-weight: bold; color: var(--annor-gold);">ANNOR <span style="color: white;">BOUTIQUE</span></span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="accueil"><i class="fas fa-home me-1"></i> Accueil</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="a-propos"><i class="fas fa-info-circle me-1"></i> À Propos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact"><i class="fas fa-envelope me-1"></i> Contact</a>
                </li>
                
                <li class="nav-item mx-lg-3">
                    <a class="nav-link cart-badge-container" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalPanier">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span id="panier-count" class="sync-panier-count">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
