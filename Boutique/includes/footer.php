<style>
    /* 1. ANIMATIONS */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .footer-animated {
        animation: fadeInUp 0.8s ease-out;
    }

    /* 2. EFFETS SUR LES LIENS */
    .footer-link {
        position: relative;
        transition: all 0.3s ease;
        display: inline-block;
    }
    .footer-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 1px;
        bottom: -2px;
        left: 0;
        background-color: #d4af37;
        transition: width 0.3s ease;
    }
    .footer-link:hover {
        color: #d4af37 !important;
        transform: translateX(5px);
    }
    .footer-link:hover::after {
        width: 100%;
    }

    /* 3. ANIMATION DU LOGO */
    .footer-logo {
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .footer-logo:hover {
        transform: scale(1.1) rotate(5deg);
    }

    /* 4. ANIMATION DES ICÔNES */
    .contact-icon {
        transition: all 0.3s ease;
    }
    .footer-link:hover .contact-icon {
        transform: scale(1.2);
        color: white !important;
    }
</style>

<footer class="footer-animated mt-5 py-4 py-md-5" style="background-color: #1a2a44; border-top: 3px solid #d4af37; color: white; overflow: hidden;">
    <div class="container">
        <div class="row text-center text-md-start row-gap-4">
            
            <div class="col-12 col-md-4 col-lg-4">
                <div class="mb-3">
                    <img src="images/logo.jpg" alt="Annor Boutique" width="70" class="footer-logo shadow-sm" style="border-radius: 50%; border: 2px solid #d4af37;">
                </div>
                <h6 class="text-uppercase fw-bold" style="color: #d4af37; letter-spacing: 1px;">Annor Boutique</h6>
                <p class="small opacity-75">L'élégance traditionnelle à votre portée. Chapeaux et bijoux artisanaux de haute qualité au Bénin.</p>
            </div>

            <div class="col-12 col-md-4 col-lg-3 mx-auto">
                <h6 class="text-uppercase fw-bold mb-3 mb-md-4" style="color: #d4af37;">Produits</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="index.php?cat=chapeau_adulte" class="footer-link text-white text-decoration-none">Chapeaux Adultes</a>
                    </li>
                    <li class="mb-2">
                        <a href="index.php?cat=chapeau_enfant" class="footer-link text-white text-decoration-none">Chapeaux Enfants</a>
                    </li>
                    <li class="mb-2">
                        <a href="index.php?cat=bijoux" class="footer-link text-white text-decoration-none">Bijoux</a>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-4 col-lg-3">
                <h6 class="text-uppercase fw-bold mb-3 mb-md-4" style="color: #d4af37;">Contact</h6>
                <div class="small">
                    <p class="mb-2">
                        <a href="https://maps.app.goo.gl/7qTbANDkpb9JUNr46" class="footer-link text-white text-decoration-none" target="_blank">
                            <i class="fas fa-map-marker-alt me-2 contact-icon" style="color: #d4af37;"></i> Cotonou, Bénin
                        </a>
                    </p>
                    
                    <p class="mb-2">
                        <a href="https://wa.me/2290197609813" class="footer-link text-white text-decoration-none" target="_blank">
                            <i class="fab fa-whatsapp me-2 contact-icon" style="color: #d4af37;"></i> +229 01 97 60 98 13
                        </a>
                    </p>

                    <p class="mb-2">
                        <a href="https://wa.me/2290141795959" class="footer-link text-white text-decoration-none" target="_blank">
                            <i class="fab fa-whatsapp me-2 contact-icon" style="color: #d4af37;"></i> +229 01 41 79 59 59
                        </a>
                    </p>

                    <p class="mb-0">
                        <a href="mailto:contact.annorboutique@gmail.com" class="footer-link text-white text-decoration-none">
                            <i class="fas fa-envelope me-2 contact-icon" style="color: #d4af37;"></i> contact.annorboutique@gmail.com
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center p-3 mt-4" style="background-color: rgba(0, 0, 0, 0.2); font-size: 0.75rem;">
        <div class="container">
            © 2026 Copyright : 
            <a class="text-white fw-bold text-decoration-none" href="#">Annor Boutique</a>
            <div class="d-block d-md-inline ms-md-2 mt-1 mt-md-0">
                <span style="color: #d4af37;">| Développé par Seydou Saibou</span>
            </div>
        </div>
    </div>

</footer>
