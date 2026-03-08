<?php include('includes/header.php'); ?>

<style>
    :root {
        --annor-blue: #1a2a44;
        --annor-gold: #d4af37;
    }

    body {
        background-color: #f4f7f6;
    }

    /* Animation d'apparition */
    .contact-card {
        border-top: 5px solid var(--annor-gold);
        border-radius: 15px;
        animation: fadeIn 0.8s ease-in-out;
        background: #ffffff;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Input styling */
    .form-control:focus, .form-select:focus {
        border-color: var(--annor-gold);
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.15);
    }

    .btn-send {
        background-color: var(--annor-blue);
        color: var(--annor-gold);
        font-weight: bold;
        border: 2px solid var(--annor-gold);
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-send:hover {
        background-color: var(--annor-gold);
        color: var(--annor-blue);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .alert-info {
        background-color: rgba(26, 42, 68, 0.05);
        border-left: 4px solid var(--annor-blue);
        color: var(--annor-blue);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card contact-card shadow-lg p-4 border-0">
                <div class="text-center mb-4">
                    <h2 class="fw-bold" style="color: var(--annor-blue);">Finaliser ma Commande</h2>
                    <div style="width: 50px; height: 3px; background: var(--annor-gold); margin: 10px auto;"></div>
                    <p class="text-muted small">Qualité & Tradition • Annor Boutique</p>
                </div>

                <form id="orderForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="color: var(--annor-blue);">Nom & Prénom</label>
                        <input type="text" id="client_name" class="form-control form-control-lg" placeholder="Ex: Koffi Mensah" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" style="color: var(--annor-blue);">Votre Quartier / Ville</label>
                        <input type="text" id="client_location" class="form-control form-control-lg" placeholder="Ex: Cotonou, Akpakpa" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: var(--annor-blue);">Mode de réception</label>
                        <select id="delivery_type" class="form-select form-select-lg">
                            <option value="Livraison à domicile">Livraison à domicile (Coursier)</option>
                            <option value="Retrait en boutique">Je viens chercher à la boutique</option>
                        </select>
                    </div>

                    <div class="alert alert-info small d-flex align-items-center">
                        <i class="fas fa-info-circle me-3 fs-4"></i> 
                        <span>En cliquant sur le bouton, votre panier sera envoyé sur le WhatsApp de la boutique pour confirmation.</span>
                    </div>

                    <button type="button" onclick="sendOrder()" class="btn btn-send w-100 py-3 mt-2 shadow">
                        <i class="fab fa-whatsapp me-2 fs-5"></i> ENVOYER MA COMMANDE
                    </button>
                </form>
            </div>
            
            <div class="text-center mt-4">
                <a href="index.php" class="text-decoration-none small" style="color: var(--annor-blue);">
                    <i class="fas fa-arrow-left me-1"></i> Retourner aux articles
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function sendOrder() {
    // Récupération du panier depuis le localStorage
    let cart = JSON.parse(localStorage.getItem('annor_cart')) || [];
    
    // Récupération des valeurs du formulaire
    const name = document.getElementById('client_name').value;
    const location = document.getElementById('client_location').value;
    const type = document.getElementById('delivery_type').value;

    if(name.trim() === "" || location.trim() === "") {
        alert("S'il vous plaît, remplissez tous les champs pour votre oncle.");
        return;
    }

    if(cart.length === 0) {
        alert("Votre panier est vide. Ajoutez des articles avant de commander !");
        return;
    }

    // Préparation du message WhatsApp avec les détails du panier
    const phone = "2290153727990"; // Le numéro de ton oncle
    
    let message = `*ANNOR BOUTIQUE - NOUVELLE COMMANDE*\n`;
    message += `--------------------------------\n`;
    message += `👤 *Client :* ${name}\n`;
    message += `📍 *Lieu :* ${location}\n`;
    message += `📦 *Mode :* ${type}\n\n`;
    message += `*ARTICLES COMMANDÉS :*\n`;
    
    let total = 0;
    cart.forEach(item => {
        message += `• ${item.nom} (x${item.qte}) - ${item.prix * item.qte} F\n`;
        total += (item.prix * item.qte);
    });
    
    message += `\n💰 *TOTAL : ${total} FCFA*\n`;
    message += `--------------------------------\n`;
    message += `_Commande générée via le catalogue en ligne._`;

    const wa_url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);
    
    // Vider le panier après commande (optionnel)
    // localStorage.removeItem('annor_cart');
    
    // Ouverture de WhatsApp
    window.open(wa_url, '_blank');
}
</script>

<?php include('includes/footer.php'); ?>