<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('includes/db.php'); 
include_once('includes/header.php'); 
$categorie_actuelle = isset($_GET['cat']) ? $_GET['cat'] : 'tous';
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

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
        background-size: cover; height: 300px; display: flex; align-items: center; justify-content: center; color: white; border-bottom: 5px solid var(--annor-gold);
        animation: focusIn 1.5s ease-out;
    }
    @keyframes focusIn {
        from { transform: scale(1.1); filter: blur(5px); }
        to { transform: scale(1); filter: blur(0); }
    }

    /* --- FILTRES MOBILE FRIENDLY --- */
    .filter-wrapper { position: sticky; top: 0; z-index: 1020; margin: -20px 0 30px 0; padding: 0 10px; }
    .filter-glass-nav { 
        display: inline-flex; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); 
        border-radius: 50px; padding: 5px; box-shadow: 0 8px 32px rgba(0,0,0,0.15); border: 1px solid rgba(255,255,255,0.4);
        flex-wrap: nowrap; overflow-x: auto; -webkit-overflow-scrolling: touch; max-width: 100%;
    }
    .filter-item { 
        white-space: nowrap; display: flex; align-items: center; gap: 8px; padding: 8px 15px; border-radius: 50px; 
        text-decoration: none !important; color: #666; font-size: 0.8rem; font-weight: 600; transition: 0.3s;
    }
    .filter-item.active { background: var(--annor-blue); color: #fff !important; }

    /* FIX DROPDOWN MOBILE */
    .dropdown-menu-glass {
        border-radius: 15px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        z-index: 2000 !important;
    }

    /* --- CARTES ARTICLES --- */
    .card-annor { 
        border: none; border-radius: 15px; background: #fff; box-shadow: var(--shadow-soft);
        transition: 0.3s; opacity: 0; transform: translateY(15px);
    }
    .card-annor.visible { opacity: 1; transform: translateY(0); }

    .img-container { height: 180px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .img-container img { max-width: 90%; max-height: 90%; object-fit: contain; }

    .prix-tag { position: absolute; top: 10px; left: 10px; background: var(--annor-blue); color: white; padding: 3px 10px; border-radius: 20px; font-weight: bold; font-size: 0.75rem; z-index: 5; }

    .btn-cart-add { background: white; border: 1.5px solid var(--annor-blue); color: var(--annor-blue); font-weight: 700; border-radius: 10px; padding: 8px; font-size: 0.65rem; width: 100%; }
    .btn-buy-now { background: #25D366; color: white; border-radius: 10px; font-weight: 700; padding: 8px; text-decoration: none; font-size: 0.65rem; text-align: center; width: 100%; display: block; }

    /* BOUTONS FLOTTANTS */
    .btn-flottant-panier { position: fixed; bottom: 85px; right: 20px; background: var(--annor-blue); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid var(--annor-gold); color: white; z-index: 1050; }
    .badge-flottant { position: absolute; top: 0; right: 0; background: #ff4757; color: white; width: 22px; height: 22px; border-radius: 50%; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; border: 2px solid white; }
</style>

<a href="javascript:void(0)" class="btn-flottant-panier shadow-lg" data-bs-toggle="modal" data-bs-target="#modalPanier">
    <i class="fas fa-shopping-bag fs-4"></i>
    <span class="badge-flottant sync-panier-count">0</span>
</a>

<section class="hero-annor">
    <div class="text-center px-3">
        <h1 class="display-5 fw-bold mb-0">ANNOR BOUTIQUE</h1>
        <div style="width: 60px; height: 3px; background: var(--annor-gold); margin: 10px auto;"></div>
        <p class="small text-uppercase opacity-75" style="letter-spacing: 2px;">L'élégance Traditionnelle</p>
    </div>
</section>

<div class="container mt-4">
    <div class="filter-wrapper text-center">
        <nav class="filter-glass-nav">
            <a href="index.php?cat=tous" class="filter-item <?php echo $categorie_actuelle == 'tous' ? 'active' : ''; ?>">
                <i class="fas fa-border-all"></i> Tous
            </a>
            
            <div class="dropdown">
                <div class="filter-item dropdown-toggle <?php echo (strpos($categorie_actuelle, 'chapeau') !== false) ? 'active' : ''; ?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-hat-cowboy"></i> Chapeaux
                </div>
                <ul class="dropdown-menu dropdown-menu-glass">
                    <li><a class="dropdown-item" href="index.php?cat=chapeau_adulte">👨 Adultes</a></li>
                    <li><a class="dropdown-item" href="index.php?cat=chapeau_enfant">👶 Enfants</a></li>
                </ul>
            </div>

            <a href="index.php?cat=bijoux" class="filter-item <?php echo $categorie_actuelle == 'bijoux' ? 'active' : ''; ?>">
                <i class="fas fa-gem"></i> Bijoux
            </a>
        </nav>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 mb-5">
        <?php
        $cat_safe = mysqli_real_escape_string($conn, $categorie_actuelle);
        $sql = ($categorie_actuelle == 'tous') ? "SELECT * FROM articles WHERE statut = 'disponible'" : "SELECT * FROM articles WHERE statut = 'disponible' AND categorie = '$cat_safe'";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)): ?>
            <div class="col">
                <div class="card-annor h-100 p-2">
                    <div class="img-container">
                        <div class="prix-tag"><?php echo number_format($row['prix'], 0, '', ' '); ?> F</div>
                        <img src="uploads/<?php echo $row['image']; ?>" alt="produit">
                    </div>
                    <div class="pt-2 text-center">
                        <p class="small fw-bold text-dark text-truncate mb-2"><?php echo htmlspecialchars($row['nom']); ?></p>
                        <button onclick="ajouterAuPanier('<?php echo addslashes($row['nom']); ?>', <?php echo $row['prix']; ?>, '<?php echo $row['image']; ?>')" class="btn-cart-add mb-2">PANIER</button>
                        <a href="https://wa.me/2290153727990?text=Commande:<?php echo urlencode($row['nom']); ?>" class="btn-buy-now">DIRECT</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="modal fade" id="modalPanier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header">
                <h5 class="fw-bold">🛒 Mon Panier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="zone-panier"></div>
            <div id="zone-bouton-commande" style="display:none;" class="p-3">
                <button onclick="viderPanier()" class="btn btn-sm btn-outline-danger w-100 mb-2">Vider</button>
                <a href="commander.php" class="btn btn-primary w-100 py-3 fw-bold">VALIDER LA COMMANDE</a>
            </div>
        </div>
    </div>
</div>

<script>
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
        div.innerHTML = "<p class='text-center py-4'>Votre panier est vide</p>";
        btnZone.style.display = "none";
        return;
    }
    btnZone.style.display = "block";
    let total = 0;
    let html = "";
    cart.forEach((item, i) => {
        total += (item.prix * item.qte);
        html += `
        <div class='d-flex align-items-center mb-3 border-bottom pb-2'>
            <img src='uploads/${item.img}' width='50' class='rounded me-2'>
            <div class='flex-grow-1 small'>
                <div class='fw-bold'>${item.nom}</div>
                <div class='text-primary'>${item.prix.toLocaleString()} F</div>
            </div>
            <div class='d-flex align-items-center gap-1'>
                <button onclick='changeQte(${i},-1)' class='btn btn-sm btn-light'>-</button>
                <span class='px-2'>${item.qte}</span>
                <button onclick='changeQte(${i},1)' class='btn btn-sm btn-light'>+</button>
            </div>
        </div>`;
    });
    html += `<div class='fw-bold text-end mt-2'>Total: ${total.toLocaleString()} F</div>`;
    div.innerHTML = html;
}

function changeQte(i, d) {
    cart[i].qte += d;
    if(cart[i].qte < 1) cart.splice(i, 1);
    sauvegarder();
}

function viderPanier() {
    if(confirm("Vider ?")) { cart = []; sauvegarder(); }
}

function notifier(nom) {
    let n = document.createElement('div');
    n.innerHTML = `✅ ${nom} ajouté !`;
    n.style = "position:fixed; bottom:160px; left:50%; transform:translateX(-50%); background:#1a2a44; color:white; padding:10px 20px; border-radius:30px; z-index:9999; font-size:0.8rem;";
    document.body.appendChild(n);
    setTimeout(() => n.remove(), 2000);
}

// Fix pour forcer l'ouverture des menus sur mobile
document.addEventListener('DOMContentLoaded', function() {
    sauvegarder();
    
    // Animation au défilement
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
    });
    document.querySelectorAll('.card-annor').forEach(c => obs.observe(c));

    // Forcer Bootstrap Dropdown
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
      return new bootstrap.Dropdown(dropdownToggleEl)
    });
});
</script>

<?php include_once('includes/footer.php'); ?>