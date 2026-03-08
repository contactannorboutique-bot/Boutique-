<?php include('includes/header.php'); ?>

<style>
    :root {
        --annor-blue: #1a2a44;
        --annor-gold: #d4af37;
    }
    .contact-card {
        border-top: 5px solid var(--annor-gold);
        border-radius: 15px;
    }
    .btn-send {
        background-color: var(--annor-blue);
        color: var(--annor-gold);
        font-weight: bold;
        border: 2px solid var(--annor-gold);
    }
    .btn-send:hover {
        background-color: var(--annor-gold);
        color: var(--annor-blue);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card contact-card shadow-lg p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold" style="color: var(--annor-blue);">Finaliser ma Commande</h2>
                    <p class="text-muted">Remplissez ces informations pour la livraison</p>
                </div>

                <form id="orderForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom & Prénom</label>
                        <input type="text" id="client_name" class="form-control" placeholder="Ex: Koffi Mensah" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Votre Quartier / Ville</label>
                        <input type="text" id="client_location" class="form-control" placeholder="Ex: Cotonou, Akpakpa" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mode de réception</label>
                        <select id="delivery_type" class="form-select">
                            <option value="Livraison à domicile">Livraison à domicile (Coursier)</option>
                            <option value="Retrait en boutique">Je viens chercher à la boutique</option>
                        </select>
                    </div>

                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-2"></i> 
                        En cliquant sur le bouton, vous serez redirigé vers le WhatsApp de l'oncle pour confirmer.
                    </div>

                    <button type="button" onclick="sendOrder()" class="btn btn-send w-100 py-3 shadow">
                        <i class="fab fa-whatsapp me-2"></i> Envoyer ma commande
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function sendOrder() {
    // Récupération des valeurs
    const name = document.getElementById('client_name').value;
    const location = document.getElementById('client_location').value;
    const type = document.getElementById('delivery_type').value;

    if(name === "" || location === "") {
        alert("S'il vous plaît, remplissez tous les champs.");
        return;
    }

    // Préparation du message WhatsApp
    const phone = "229XXXXXXXX"; // REMPLACE PAR LE NUMÉRO DE TON ONCLE
    const message = `*ANNOR BOUTIQUE - NOUVELLE COMMANDE*\n\n` +
                    `👤 *Client :* ${name}\n` +
                    `📍 *Lieu :* ${location}\n` +
                    `📦 *Mode :* ${type}\n\n` +
                    `_Je confirme vouloir commander les articles sélectionnés._`;

    const wa_url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);
    
    // Ouverture de WhatsApp
    window.open(wa_url, '_blank');
}
</script>

<?php include('includes/footer.php'); ?>