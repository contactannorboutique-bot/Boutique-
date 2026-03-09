<?php 
include('includes/header.php'); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --annor-blue: #1a2a44;
        --annor-gold: #d4af37;
        --annor-light: #f8f9fa;
        --annor-dark: #111111;
    }
    body { background-color: var(--annor-light); font-family: 'Poppins', sans-serif; }
    
    .checkout-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
    .card-header-custom { background: var(--annor-blue); color: white; padding: 20px; border: none; }
    
    .form-control, .form-select { border-radius: 12px; padding: 12px; border: 1px solid #ddd; transition: 0.3s; }
    .form-control:focus, .form-select:focus { border-color: var(--annor-gold); box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.1); }
    
    /* Boutons */
    .btn-send { background-color: #25D366; color: white; font-weight: bold; border-radius: 15px; transition: 0.3s; border: none; }
    .btn-send:hover { background-color: #20b958; transform: translateY(-2px); color: white; box-shadow: 0 10px 20px rgba(37, 211, 102, 0.2); }
    
    .btn-outline-annor { border: 2px solid var(--annor-blue); color: var(--annor-blue); font-weight: 600; border-radius: 12px; transition: 0.3s; }
    .btn-outline-annor:hover { background: var(--annor-blue); color: white; }

    .cart-summary-item { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px; animation: fadeInRight 0.5s ease; }
    
    .badge-qte { background: var(--annor-gold); color: var(--annor-blue); font-weight: bold; padding: 2px 8px; border-radius: 5px; font-size: 0.75rem; }
</style>

<div class="container py-5 animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="index.php" class="btn btn-sm btn-outline-annor">
            <i class="fas fa-arrow-left me-2"></i> Boutique
        </a>
        <div class="text-center flex-grow-1">
            <h2 class="fw-bold mb-0" style="color: var(--annor-blue);">LIVRAISON</h2>
        </div>
        <div style="width: 100px;"></div> </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card checkout-card animate__animated animate__fadeInLeft">
                <div class="card-header-custom">
                    <h5 class="mb-0"><i class="fas fa-truck me-2"></i> Vos Coordonnées</h5>
                </div>
                <div class="card-body p-4">
                    <form id="orderForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Nom & Prénom complet</label>
                            <input type="text" id="client_name" class="form-control" placeholder="Ex: Koffi Mensah" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Ville & Quartier (Précis)</label>
                            <input type="text" id="client_location" class="form-control" placeholder="Ex: Cotonou, Fidjrossè, Rue 12" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Mode de réception</label>
                            <select id="delivery_type" class="form-select">
                                <option value="Livraison à domicile">Livraison à domicile (Frais selon zone)</option>
                                <option value="Retrait en boutique">Retrait en boutique (Gratuit)</option>
                            </select>
                        </div>
                        <div class="p-3 rounded-3" style="background: rgba(212, 175, 55, 0.1); border-left: 4px solid var(--annor-gold);">
                            <small class="text-dark"><i class="fas fa-info-circle me-2"></i> Une fois validée, la commande s'ouvrira sur WhatsApp pour confirmer les détails avec notre équipe.</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card checkout-card animate__animated animate__fadeInRight">
                <div class="card-header-custom" style="background: var(--annor-dark);">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Votre Commande</h5>
                </div>
                <div class="card-body p-4">
                    <div id="summary-content" style="max-height: 400px; overflow-y: auto;">
                        </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <span class="fw-bold text-muted">TOTAL À PAYER</span>
                        <span class="fs-3 fw-bold" style="color: var(--annor-blue);" id="summary-total">0 F</span>
                    </div>

                    <div class="mt-4">
                        <button type="button" onclick="sendOrder()" class="btn btn-send w-100 py-3 shadow mb-3">
                            <i class="fab fa-whatsapp fs-5 me-2"></i> CONFIRMER SUR WHATSAPP
                        </button>
                        
                        <div class="d-flex gap-2">
                            <a href="index.php" class="btn btn-light w-50 py-2 border small fw-bold text-muted">
                                <i class="fas fa-plus me-1"></i> AJOUTER PLUS
                            </a>
                            <button onclick="annulerTout()" class="btn btn-light w-50 py-2 border small fw-bold text-danger">
                                <i class="fas fa-trash-alt me-1"></i> VIDER / ANNULER
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let cart = JSON.parse(localStorage.getItem('annor_cart')) || [];

function chargerResume() {
    const summaryDiv = document.getElementById('summary-content');
    const totalDiv = document.getElementById('summary-total');
    
    if(cart.length === 0) {
        summaryDiv.innerHTML = `
            <div class="text-center py-5 animate__animated animate__fadeIn">
                <i class="fas fa-shopping-basket fa-3x mb-3 text-muted opacity-25"></i>
                <p class="text-muted">Votre panier est vide.</p>
                <a href="index.php" class="btn btn-sm btn-primary rounded-pill px-4">Aller faire du shopping</a>
            </div>`;
        document.querySelector('.btn-send').style.display = 'none';
        document.getElementById('summary-total').innerText = "0 F";
        return;
    }

    let html = "";
    let total = 0;

    cart.forEach((item, index) => {
        let sousTotal = item.prix * item.qte;
        total += sousTotal;
        html += `
        <div class="cart-summary-item d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="uploads/${item.img}" width="45" height="45" class="rounded-3 me-3 border" style="object-fit:cover">
                <div>
                    <span class="fw-bold d-block" style="font-size: 0.85rem;">${item.nom}</span>
                    <span class="badge-qte">x${item.qte}</span>
                </div>
            </div>
            <span class="fw-bold text-dark" style="font-size: 0.9rem;">${sousTotal.toLocaleString()} F</span>
        </div>`;
    });

    summaryDiv.innerHTML = html;
    totalDiv.innerText = total.toLocaleString() + " F";
}

// Fonction pour ANNULER et VIDER le panier
function annulerTout() {
    Swal.fire({
        title: 'Annuler la commande ?',
        text: "Votre panier sera vidé et vous reviendrez à l'accueil.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1a2a44',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, annuler tout',
        cancelButtonText: 'Non, rester',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            localStorage.removeItem('annor_cart');
            window.location.href = "index.php";
        }
    })
}

function sendOrder() {
    const name = document.getElementById('client_name').value.trim();
    const location = document.getElementById('client_location').value.trim();
    const type = document.getElementById('delivery_type').value;

    if(name === "" || location === "") {
        Swal.fire({
            icon: 'error',
            title: 'Champs manquants',
            text: 'Merci de renseigner votre nom et adresse de livraison.',
            confirmButtonColor: '#1a2a44'
        });
        return;
    }

    let message = `*🛍️ NOUVELLE COMMANDE - ANNOR BOUTIQUE*\n`;
    message += `--------------------------------\n`;
    message += `👤 *Client :* ${name}\n`;
    message += `📍 *Lieu :* ${location}\n`;
    message += `🚚 *Mode :* ${type}\n\n`;
    message += `*📋 DÉTAILS :*\n`;

    let total = 0;
    cart.forEach(item => {
        let sousTotal = item.prix * item.qte;
        total += sousTotal;
        message += `▪️ ${item.nom} (x${item.qte}) : *${sousTotal.toLocaleString()} F*\n`;
    });

    message += `\n💰 *TOTAL À PAYER : ${total.toLocaleString()} FCFA*\n`;
    message += `--------------------------------\n`;
    message += `_Commande générée depuis le site Annor Boutique_`;

    const phone = "2290197609813"; 
    const wa_url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);
    
    // Succès avant redirection
    Swal.fire({
        icon: 'success',
        title: 'Commande prête !',
        text: 'Vous allez être redirigé vers WhatsApp pour finaliser.',
        showConfirmButton: false,
        timer: 2000
    });

    setTimeout(() => {
        localStorage.removeItem('annor_cart');
        window.open(wa_url, '_blank');
        window.location.href = "index.php";
    }, 2000);
}

document.addEventListener('DOMContentLoaded', chargerResume);
</script>

<?php include('includes/footer.php'); ?>