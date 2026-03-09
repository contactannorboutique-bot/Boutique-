<?php include('includes/header.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --annor-blue: #1a2a44;
        --annor-gold: #d4af37;
    }
    body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; overflow-x: hidden; }
    
    /* Hero Section avec animation */
    .contact-hero {
        background: var(--annor-blue);
        color: white;
        padding: 80px 0;
        text-align: center;
        border-bottom: 5px solid var(--annor-gold);
        position: relative;
    }
    
    /* Cartes d'info */
    .info-card {
        background: white;
        border: none;
        border-radius: 20px;
        padding: 35px;
        text-align: center;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        height: 100%;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        opacity: 0; /* Pour l'animation d'entrée JS */
    }
    
    .info-card.show { opacity: 1; }

    .info-card:hover { 
        transform: translateY(-12px); 
        box-shadow: 0 20px 40px rgba(26, 42, 68, 0.1);
        border-bottom: 4px solid var(--annor-gold); 
    }

    .info-icon {
        width: 70px; height: 70px;
        background: rgba(212, 175, 55, 0.1);
        color: var(--annor-gold);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 20px;
        transition: 0.3s;
    }
    
    .info-card:hover .info-icon {
        background: var(--annor-gold);
        color: white;
        transform: rotateY(360deg);
    }

    /* Formulaire */
    .contact-card-main {
        border-radius: 25px;
        overflow: hidden;
        border: none;
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
    }

    .form-control, .form-select { 
        border-radius: 12px; 
        padding: 15px; 
        border: 1px solid #eee;
        background-color: #fdfdfd;
    }
    
    .form-control:focus { 
        border-color: var(--annor-gold); 
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.1); 
        background-color: #fff;
    }

    .btn-submit { 
        background: var(--annor-blue); 
        color: white; 
        border-radius: 15px; 
        font-weight: 700; 
        letter-spacing: 1px;
        transition: 0.4s;
        border: none;
    }

    .btn-submit:hover { 
        background: var(--annor-gold); 
        color: white; 
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
    }
</style>

<section class="contact-hero animate__animated animate__fadeIn">
    <div class="container animate__animated animate__zoomIn">
        <h1 class="fw-bold display-4">CONTACTEZ-NOUS</h1>
        <div style="width: 80px; height: 4px; background: var(--annor-gold); margin: 20px auto;"></div>
        <p class="lead opacity-75">Une question ou une demande spéciale ?<br>L'équipe ANNOR est à votre entière disposition.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="info-card animate__animated" id="card-1">
                <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                <h5 class="fw-bold" style="color: var(--annor-blue);">WhatsApp</h5>
                <p class="text-muted mb-0">+229 01 97 60 98 13</p>
                <p class="small text-muted">Réponse rapide garantie</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card animate__animated" id="card-2">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h5 class="fw-bold" style="color: var(--annor-blue);">Notre Boutique</h5>
                <p class="text-muted mb-0">Cotonou, Bénin</p>
                <p class="small text-muted">Disponible pour essayages</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card animate__animated" id="card-3">
                <div class="info-icon"><i class="fas fa-envelope"></i></div>
                <h5 class="fw-bold" style="color: var(--annor-blue);">Email</h5>
                <p class="text-muted mb-0">contact@annorboutique.com</p>
                <p class="small text-muted">Support technique 24h/7j</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
            <div class="card contact-card-main">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold text-center mb-4" style="color: var(--annor-blue);">Laissez-nous un message</h3>
                    
                    <form id="contactSupportForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="fw-bold small text-muted mb-2">Votre Nom</label>
                                <input type="text" id="sup_nom" class="form-control" placeholder="Ex: Jean Dupont" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold small text-muted mb-2">Sujet de la demande</label>
                                <select id="sup_sujet" class="form-select">
                                    <option>Question sur un produit</option>
                                    <option>Problème avec une commande</option>
                                    <option>Demande de partenariat</option>
                                    <option>Autre</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="fw-bold small text-muted mb-2">Votre Message</label>
                                <textarea id="sup_msg" class="form-control" rows="5" placeholder="Décrivez votre besoin..." required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="button" onclick="sendSupportMsg()" class="btn btn-submit w-100 py-3">
                                    <i class="fab fa-whatsapp me-2 fs-5"></i> ENVOYER VIA WHATSAPP
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Animation des cartes au défilement
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.info-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('show', 'animate__backInUp');
        }, index * 200);
    });
});

function sendSupportMsg() {
    const nom = document.getElementById('sup_nom').value.trim();
    const sujet = document.getElementById('sup_sujet').value;
    const msg = document.getElementById('sup_msg').value.trim();

    if(nom === "" || msg === "") {
        Swal.fire({
            icon: 'error',
            title: 'Oups...',
            text: 'Merci de remplir tous les champs obligatoires.',
            confirmButtonColor: '#1a2a44'
        });
        return;
    }

    let messageWA = `*✉️ NOUVEAU MESSAGE SUPPORT*\n`;
    messageWA += `--------------------------------\n`;
    messageWA += `👤 *De :* ${nom}\n`;
    messageWA += `📌 *Sujet :* ${sujet}\n`;
    messageWA += `💬 *Message :*\n_${msg}_\n`;
    messageWA += `--------------------------------`;

    const phone = "2290197609813";
    const wa_url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(messageWA);
    
    Swal.fire({
        icon: 'success',
        title: 'Prêt à envoyer !',
        text: 'Votre message va être ouvert sur WhatsApp.',
        showConfirmButton: false,
        timer: 1500
    });

    setTimeout(() => {
        window.open(wa_url, '_blank');
    }, 1500);
}
</script>

<?php include('includes/footer.php'); ?>