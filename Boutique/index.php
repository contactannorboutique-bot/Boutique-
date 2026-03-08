<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('includes/db.php'); 
include_once('includes/header.php'); 
$categorie_actuelle = isset($_GET['cat']) ? $_GET['cat'] : 'tous';
?>

<style>
    :root { 
        --annor-blue: #1a2a44; 
        --annor-gold: #d4af37; 
        --annor-light: #f8f9fa;
        --shadow-soft: 0 10px 30px rgba(0,0,0,0.08);
    }
    
    body { background-color: var(--annor-light); font-family: 'Poppins', 'Segoe UI', sans-serif; scroll-behavior: smooth; overflow-x: hidden; }

    /* --- HERO ANIMÉ --- */
    .hero-annor { 
        background: linear-gradient(rgba(26, 42, 68, 0.5), rgba(26, 42, 68, 0.5)), 
                    url('images/ahousa.jpg') no-repeat center center; 
        background-size: cover; height: 400px; display: flex; align-items: center; justify-content: center; color: white; border-bottom: 5px solid var(--annor-gold);
        animation: focusIn 1.5s ease-out;
    }
    @keyframes focusIn {
        from { transform: scale(1.1); filter: blur(5px); }
        to { transform: scale(1); filter: blur(0); }
    }

    /* --- FILTRES PRO (GLASSMORPHISM) --- */
    .filter-wrapper { position: sticky; top: 10px; z-index: 1050; margin: -30px 0 40px 0; padding: 0 15px; }
    .filter-glass-nav { 
        display: inline-flex; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); 
        border-radius: 100px; padding: 6px; box-shadow: 0 8px 32px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.4);
        flex-wrap: wrap; justify-content: center; gap: 5px;
    }
    .filter-item { 
        display: flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 100px; 
        text-decoration: none !important; color: #666; font-size: 0.85rem; font-weight: 600; transition: 0.3s; cursor: pointer;
    }
    .filter-item.active { background: var(--annor-blue); color: #fff !important; box-shadow: 0 4px 12px rgba(26, 42, 68, 0.25); }
    .filter-item.active i { color: var(--annor-gold); }
    .filter-item:not(.active):hover { background: rgba(26, 42, 68, 0.05); color: var(--annor-blue); transform: translateY(-1px); }

    /* --- MENU DÉROULANT CUSTOM --- */
    .dropdown-menu-glass {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.5);
        border-radius: 15px;
        padding: 8px;
        min-width: 160px;
        margin-top: 10px !important;
    }
    .dropdown-menu-glass .dropdown-item {
        border-radius: 10px;
        transition: 0.2s;
        font-size: 0.85rem;
        font-weight: 600;
        color: #555;
        padding: 10px 15px;
    }
    .dropdown-menu-glass .dropdown-item:hover, .dropdown-menu-glass .dropdown-item:focus {
        background: rgba(26, 42, 68, 0.08);
        color: var(--annor-blue);
    }
    .dropdown-menu-glass .dropdown-item.active-sub {
        background: rgba(212, 175, 55, 0.15);
        color: var(--annor-blue);
    }

    /* --- CARTES ARTICLES --- */
    .card-annor { 
        border: none; border-radius: 20px; background: #fff; box-shadow: var(--shadow-soft);
        transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); opacity: 0; transform: translateY(20px);
    }
    .card-annor.visible { opacity: 1; transform: translateY(0); }
    .card-annor:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }

    .img-container { height: 220px; border-radius: 20px 20px 0 0; padding: 15px; display: flex; align-items: center; justify-content: center; position: relative; background: #fff; }
    .img-container img { max-width: 100%; max-height: 100%; object-fit: contain; transition: 0.5s; }
    .card-annor:hover .img-container img { transform: scale(1.1); }

    .prix-tag { position: absolute; top: 15px; left: 15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(5px); padding: 5px 12px; border-radius: 50px; font-weight: 800; color: var(--annor-blue); font-size: 0.8rem; border: 1px solid rgba(212, 175, 55, 0.3); z-index: 2; }

    .btn-cart-add { background: transparent; border: 2px solid var(--annor-blue); color: var(--annor-blue); font-weight: 700; border-radius: 12px; padding: 10px; font-size: 0.7rem; transition: 0.3s; width: 100%; }
    .btn-cart-add:hover { background: var(--annor-blue); color: white; }
    .btn-buy-now { background: #25D366; color: white; border-radius: 12px; font-weight: 700; padding: 10px; text-decoration: none; font-size: 0.7rem; text-align: center; width: 100%; box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3); transition: 0.3s;}
    .btn-buy-now:hover { transform: scale(1.05); color: white; background: #1eb956; }

    /* BOUTONS FLOTTANTS */
    .btn-flottant-panier { position: fixed; bottom: 90px; right: 25px; background: var(--annor-blue); width: 65px; height: 65px; border-radius: 20px; display: flex; align-items: center; justify-content: center; border: 2px solid var(--annor-gold); color: white; z-index: 1000; transition: 0.3s; }
    .btn-flottant-panier:hover { transform: scale(1.05); color: white; }
    #btn-retour-haut { position: fixed; bottom: 25px; right: 25px; background: var(--annor-gold); width: 50px; height: 50px; border-radius: 15px; border: none; display: none; z-index: 1000; color: var(--annor-blue); transition: 0.3s; }
    #btn-retour-haut:hover { transform: translateY(-3px); }
    
    .badge-flottant { position: absolute; top: -5px; right: -5px; background: #ff4757; color: white; width: 24px; height: 24px; border-radius: 50%; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; border: 2px solid white; font-weight: bold; }
</style>

<a href="#" class="btn-flottant-panier shadow-lg" data-bs-toggle="modal" data-bs-target="#modalPanier">
    <i class="fas fa-shopping-bag fs-4"></i>
    <span class="badge-flottant sync-panier-count">0</span>
</a>
<button onclick="remonterEnHaut()" id="btn-retour-haut" class="shadow-lg"><i class="fas fa-chevron-up"></i></button>

<section class="hero-annor">
    <div class="text-center" style="z-index: 2;">
        <h1 class="display-4 fw-bold mb-0" style="letter-spacing: -1px;">ANNOR BOUTIQUE</h1>
        <div style="width: 80px; height: 4px; background: var(--annor-gold); margin: 15px auto;"></div>
        <p class="h5 text-uppercase opacity-75" style="letter-spacing: 4px;">L'élégance Traditionnelle</p>
    </div>
</section>

<div class="container mt-4">
    <div class="filter-wrapper text-center">
        <nav class="filter-glass-nav">
            <a href="index.php?cat=tous" class="filter-item <?php echo $categorie_actuelle == 'tous' ? 'active' : ''; ?>">
                <i class="fas fa-border-all"></i> Tous
            </a>
            
            <div class="dropdown d-inline-block">
                <div class="filter-item dropdown-toggle <?php echo ($categorie_actuelle == 'chapeau_adulte' || $categorie_actuelle == 'chapeau_enfant') ? 'active' : ''; ?>" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                    <i class="fas fa-hat-cowboy"></i> Chapeaux
                </div>
                <ul class="dropdown-menu dropdown-menu-glass shadow-lg">
                    <li>
                        <a class="dropdown-item <?php echo $categorie_actuelle == 'chapeau_adulte' ? 'active-sub' : ''; ?>" href="index.php?cat=chapeau_adulte">
                            <i class="fas fa-user-tie me-2"></i> Adultes
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo $categorie_actuelle == 'chapeau_enfant' ? 'active-sub' : ''; ?>" href="index.php?cat=chapeau_enfant">
                            <i class="fas fa-child me-2"></i> Enfants
                        </a>
                    </li>
                </ul>
            </div>

            <a href="index.php?cat=bijoux" class="filter-item <?php echo $categorie_actuelle == 'bijoux' ? 'active' : ''; ?>">
                <i class="fas fa-gem"></i> Bijoux
            </a>
        </nav>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
        <?php
        $sql = ($categorie_actuelle == 'tous') ? "SELECT * FROM articles WHERE statut = 'disponible'" : "SELECT * FROM articles WHERE statut = 'disponible' AND categorie = '".mysqli_real_escape_string($conn, $categorie_actuelle)."'";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)): ?>
            <div class="col">
                <div class="card-annor h-100">
                    <div class="img-container">
                        <div class="prix-tag"><?php echo number_format($row['prix'], 0, '', ' '); ?> F</div>
                        <img src="uploads/<?php echo $row['image']; ?>" loading="lazy" alt="<?php echo htmlspecialchars($row['nom']); ?>">
                    </div>
                    <div class="p-3">
                        <h6 class="fw-bold text-dark text-truncate mb-3"><?php echo strtoupper($row['nom']); ?></h6>
                        <div class="d-grid gap-2">
                            <button onclick="ajouterAuPanier('<?php echo addslashes($row['nom']); ?>', <?php echo $row['prix']; ?>, '<?php echo $row['image']; ?>')" class="btn-cart-add">AJOUTER AU PANIER</button>
                            <a href="https://wa.me/2290153727990?text=<?php echo urlencode("Bonjour, je souhaite commander l'article : ".$row['nom']); ?>" class="btn-buy-now text-white">ACHETER</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="modal fade" id="modalPanier" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="fw-bold mb-0">🛒 Mon Panier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="zone-panier"></div>
            <div id="zone-bouton-commande" style="display:none;" class="p-4 pt-0">
                <button onclick="viderPanier()" class="btn btn-sm btn-outline-danger w-100 mb-3">Vider le panier</button>
                <a href="commander.php" class="btn btn-primary w-100 py-3 fw-bold rounded-3 text-white">VALIDER LA COMMANDE</a>
            </div>
        </div>
    </div>
</div>

<script>
// --- LOGIQUE PANIER ---
let cart = JSON.parse(localStorage.getItem('annor_cart')) || [];

function ajouterAuPanier(nom, prix, img) {
    let existant = cart.find(i => i.nom === nom);
    if(existant) { existant.qte++; } else { cart.push({nom, prix, img, qte: 1}); }
    sauvegarder();
    notifier(nom);
}

function sauvegarder() {
    localStorage.setItem('annor_cart', JSON.stringify(cart));
    let totalItems = cart.reduce((acc, item) => acc + item.qte, 0);
    document.querySelectorAll('.sync-panier-count').forEach(el => el.innerText = totalItems);
    dessinerPanier();
}

function dessinerPanier() {
    const div = document.getElementById('zone-panier');
    const btnZone = document.getElementById('zone-bouton-commande');
    if(cart.length === 0) {
        div.innerHTML = "<p class='text-center my-3 text-muted'>Votre panier est vide</p>";
        btnZone.style.display = "none";
        return;
    }
    btnZone.style.display = "block";
    let total = 0;
    let html = "";
    cart.forEach((item, i) => {
        total += (item.prix * item.qte);
        html += `
        <div class='d-flex align-items-center mb-3 border-bottom pb-3'>
            <img src='uploads/${item.img}' width='60' height='60' class='rounded me-3' style='object-fit:cover; border: 1px solid #ddd;'>
            <div class='flex-grow-1'>
                <div class='fw-bold small text-dark'>${item.nom}</div>
                <div class='text-primary small fw-bold'>${item.prix.toLocaleString()} F</div>
            </div>
            <div class='d-flex align-items-center gap-2'>
                <button onclick='changeQte(${i},-1)' class='btn btn-sm btn-light border'>-</button>
                <span class='fw-bold'>${item.qte}</span>
                <button onclick='changeQte(${i},1)' class='btn btn-sm btn-light border'>+</button>
            </div>
        </div>`;
    });
    html += `<div class='fw-bold text-end fs-5 mt-3' style='color: var(--annor-blue);'>Total: ${total.toLocaleString()} FCFA</div>`;
    div.innerHTML = html;
}

function changeQte(i, d) {
    cart[i].qte += d;
    if(cart[i].qte < 1) cart.splice(i, 1);
    sauvegarder();
}

function viderPanier() {
    if(confirm("Voulez-vous vraiment vider tout le panier ?")) { 
        cart = []; 
        sauvegarder(); 
    }
}

function notifier(nom) {
    let n = document.createElement('div');
    n.innerHTML = `<i class="fas fa-check-circle me-2"></i> ${nom} ajouté !`;
    n.style = "position:fixed; top:20px; right:20px; background:var(--annor-blue); color:white; padding:15px 25px; border-radius:12px; z-index:9999; font-weight:bold; box-shadow:0 10px 30px rgba(0,0,0,0.3); transition: opacity 0.5s ease-in-out;";
    document.body.appendChild(n);
    setTimeout(() => { n.style.opacity = '0'; setTimeout(() => n.remove(), 500); }, 2500);
}

// --- ANIMATIONS SCROLL REVEAL ---
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => { 
        if (entry.isIntersecting) entry.target.classList.add('visible'); 
    });
}, { threshold: 0.1 });
document.querySelectorAll('.card-annor').forEach(card => observer.observe(card));

// --- BOUTON RETOUR EN HAUT ---
window.onscroll = function() {
    let btn = document.getElementById("btn-retour-haut");
    btn.style.display = (window.scrollY > 400) ? "block" : "none";
};
function remonterEnHaut() { window.scrollTo({ top: 0, behavior: 'smooth' }); }

// --- INITIALISATION AU CHARGEMENT ---
window.onload = sauvegarder;
</script>

<?php include_once('includes/footer.php'); ?>