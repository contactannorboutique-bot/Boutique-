<?php include_once('includes/header.php'); ?>

<style>
    :root { 
        --annor-blue: #1a2a44; 
        --annor-gold: #d4af37; 
        --glass: rgba(255, 255, 255, 0.9);
    }

    /* Boule décorative animée */
    .floating-sphere {
        position: fixed;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        top: 10%;
        right: -100px;
        z-index: -1;
        animation: rotateMove 20s linear infinite;
    }
    @keyframes rotateMove {
        0% { transform: rotate(0deg) translate(20px); }
        100% { transform: rotate(360deg) translate(20px); }
    }

    .hero-banner {
        background: var(--annor-blue);
        color: white;
        padding: 50px 0;
        text-align: center;
        border-bottom: 5px solid var(--annor-gold);
    }

    /* Section Image et Texte */
    .about-container {
        background: var(--glass);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        margin-top: -40px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .shop-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-height: 300px;
        border-bottom: 5px solid var(--annor-gold);
    }

    @media (min-width: 768px) {
        .shop-image { border-bottom: none; border-right: 5px solid var(--annor-gold); }
    }

    /* Chiffres animés */
    .stat-card {
        background: #fdfbf5;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        border: 1px solid rgba(212, 175, 55, 0.3);
        transition: 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); border-color: var(--annor-blue); }

    .counter-value {
        font-size: 2.8rem;
        font-weight: 900;
        color: var(--annor-blue);
        display: block;
    }

    .counter-label {
        font-weight: bold;
        color: var(--annor-gold);
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    .map-frame {
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid var(--annor-blue);
    }
</style>

<div class="floating-sphere"></div>

<section class="hero-banner">
    <div class="container">
        <h1 class="fw-bold">NOTRE UNIVERS</h1>
        <p style="color: var(--annor-gold); letter-spacing: 3px;">QUALITÉ • TRADITION • AUTHENTICITÉ</p>
    </div>
</section>

<div class="container mb-5">
    <div class="about-container">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="images/bouique.JPG" alt="Intérieur de Annor Boutique" class="shop-image">
            </div>
            
            <div class="col-md-6 p-4 p-lg-5">
                <h2 class="fw-bold mb-4" style="color: var(--annor-blue);">L'Excellence du Chapeau Traditionnel</h2>
                <p class="text-muted" style="line-height: 1.8; text-align: justify;">
                    Bienvenue dans notre atelier. Chez <strong>Annor Boutique</strong>, nous redonnons vie aux traditions à travers la confection artisanale de chapeaux et la sélection de bijoux d'exception. 
                </p>
                <p class="text-muted" style="line-height: 1.8; text-align: justify;">
                    Chaque article que vous voyez dans notre catalogue est le résultat d'un travail minutieux. Nous croyons que porter un chapeau traditionnel est un symbole de fierté et d'élégance.
                </p>
                
                <div class="row g-3 mt-4">
                    <div class="col-6">
                        <div class="stat-card">
                            <span class="counter-value" data-target="20">0</span>
                            <span class="counter-label">Clients (K)</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <span class="counter-value" data-target="15">0</span>
                            <span class="counter-label">Ans d'Expertise</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center mb-4">
            <h3 class="fw-bold" style="color: var(--annor-blue);">PASSEZ NOUS VOIR</h3>
            <div style="width: 50px; height: 3px; background: var(--annor-gold); margin: 0 auto;"></div>
        </div>
        <div class="col-lg-8 mx-auto">
            <div class="map-frame shadow-lg">
              <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.111!2d2.41!3d6.37!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023559999999999%3A0x9999999999999999!2sAnnor%20Boutique!5e0!3m2!1sfr!2sbj!4v1710000000000!5m2!1sfr!2sbj" 
    width="100%" 
    height="350" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
</iframe>
            </div>
            <div class="text-center mt-3">
                <p class="text-muted small"><i class="fas fa-map-marker-alt me-2"></i> Situé à Cotonou, Bénin</p>
            </div>
        </div>
    </div>
</div>

<script>
// Fonction d'animation de compteurs ultra-fluide et lente
function startProgressiveCounters() {
    const counters = document.querySelectorAll('.counter-value');
    const duration = 5000; // 5 secondes pour un effet zen

    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        let startTime = null;

        function update(currentTime) {
            if (!startTime) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            
            // Calcul avec effet de ralentissement à la fin
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const currentCount = Math.floor(easeOut * target);
            
            counter.innerText = currentCount + (target === 20 ? "K+" : "");
            
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                counter.innerText = target + (target === 20 ? "K+" : "");
            }
        }
        requestAnimationFrame(update);
    });
}

document.addEventListener('DOMContentLoaded', startProgressiveCounters);
</script>


<?php include_once('includes/footer.php'); ?>


