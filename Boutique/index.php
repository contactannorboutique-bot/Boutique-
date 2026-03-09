<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('includes/db.php');
include_once('includes/header.php');
$categorie_actuelle = isset($_GET['cat']) ? $_GET['cat'] : 'tous';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --annor-blue: #1a2a44;
        --annor-gold: #d4af37;
        --annor-light: #f4f7f6;
    }

    body {
        background-color: var(--annor-light);
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    /* --- HERO SECTION --- */
    .hero-annor {
        position: relative;
        background: linear-gradient(rgba(26, 42, 68, 0.7), rgba(26, 42, 68, 0.7)),
            url('images/ahousa.jpg') no-repeat center center;
        background-size: cover;
        height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    /* --- EFFET ZOOM IMAGE (Nouveau) --- */
    .img-box {
        height: 180px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 15px;
        overflow: hidden; /* Important pour que le zoom ne dépasse pas */
    }

    .img-box img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); /* Animation fluide */
    }

    /* Zoom au survol (PC) et quand on touche (Mobile) */
    .product-card:hover .img-box img, 
    .product-card:active .img-box img {
        transform: scale(1.15);
    }

    /* --- BOUTONS --- */
    .btn-add {
        background: var(--annor-blue);
        color: white;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-add:hover {
        background: var(--annor-gold);
        transform: translateY(-2px);
    }

    /* --- GRILLE & CARDS --- */
    .product-card {
        background: white;
        border-radius: 20px;
        border: none;
        overflow: hidden;
        transition: 0.4s;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        opacity: 0;
        transform: translateY(30px);
    }

    .product-card.show {
        opacity: 1;
        transform: translateY(0);
    }

    .price-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 10;
        background: var(--annor-blue);
        color: white;
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    /* Panier flottant */
    .cart-float {
        position: fixed;
        bottom: 30px;
        right: 20px;
        background: var(--annor-blue);
        width: 65px;
        height: 65px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 1000;
        box-shadow: 0 10px 25px rgba(26, 42, 68, 0.4);
        border: 2px solid var(--annor-gold);
        cursor: pointer;
    }

    .cart-count {
        position: absolute;
        top: 0;
        right: 0;
        background: #ff4757;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        font-size: 0.7rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
    }

    /* Filtres Sticky */
    .filter-sticky {
        position: sticky;
        top: 0;
        z-index: 1030;
        background: rgba(244, 247, 246, 0.9);
        backdrop-filter: blur(15px);
        padding: 15px 0;
    }

    .filter-container {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn-filter {
        background: white;
        border: 1.5px solid #eee;
        border-radius: 30px;
        padding: 8px 18px;
        color: #555;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-filter.active {
        background: var(--annor-blue);
        color: white;
    }
</style>

<div class="cart-float" onclick="ouvrirPanier()">
    <i class="fas fa-shopping-bag fs-3"></i>
    <span class="cart-count sync-panier-count">0</span>
</div>

<section class="hero-annor">
    <div class="hero-content text-center">
        <h1 class="animate__animated animate__fadeInDown">ANNOR BOUTIQUE</h1>
        <div style="width: 80px; height: 4px; background: var(--annor-gold); margin: 0 auto 15px;"></div>
        <p class="text-uppercase small fw-bold" style="letter-spacing: 3px; color: rgba(255,255,255,0.8);">Luxury Heritage</p>
    </div>
</section>

<div class="filter-sticky">
    <div class="filter-container">
        <a href="accueil?cat=tous" class="btn-filter <?php echo $categorie_actuelle == 'tous' ? 'active' : ''; ?>">Tous</a>
        <a href="accueil?cat=bijoux" class="btn-filter <?php echo $categorie_actuelle == 'bijoux' ? 'active' : ''; ?>">Bijoux</a>
        <a href="accueil?cat=chapeau_adulte" class="btn-filter <?php echo $categorie_actuelle == 'chapeau_adulte' ? 'active' : ''; ?>">Chapeaux</a>
    </div>
</div>

<div class="container mt-4">
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 mb-5">
        <?php
        $cat_safe = mysqli_real_escape_string($conn, $categorie_actuelle);
        $sql = ($categorie_actuelle == 'tous') ?
            "SELECT * FROM articles WHERE statut = 'disponible' ORDER BY id DESC" :
            "SELECT * FROM articles WHERE statut = 'disponible' AND categorie = '$cat_safe' ORDER BY id DESC";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0):
            while ($row = mysqli_fetch_assoc($res)): ?>
                <div class="col">
                    <div class="product-card h-100">
                        <div class="img-box">
                            <span class="price-badge"><?php echo number_format($row['prix'], 0, '', ' '); ?> F</span>
                            <img src="uploads/<?php echo $row['image']; ?>" alt="produit">
                        </div>
                        <div class="p-3 text-center">
                            <h6 class="text-truncate mb-3 fw-bold" style="color: #333; font-size: 0.85rem;"><?php echo htmlspecialchars($row['nom']); ?></h6>
                            
                            <button onclick="ajouterAuPanier('<?php echo addslashes($row['nom']); ?>', <?php echo $row['prix']; ?>, '<?php echo $row['image']; ?>')" class="btn-add">
                                <i class="fas fa-shopping-cart me-2"></i> ACHETER
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        endif; ?>
    </div>
</div>

<div class="modal fade" id="modalPanier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 25px;">
            <div class="modal-header bg-dark text-white border-0 py-4">
                <h5 class="modal-title fw-bold">VOTRE PANIER</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="zone-panier"></div>
            <div id="zone-bouton-commande" style="display:none;" class="p-4 bg-light">
                <div class="d-flex justify-content-between mb-3">
                    <span class="h5 fw-bold">TOTAL :</span>
                    <span class="h5 fw-bold text-primary" id="total-panier">0 F</span>
                </div>
                <a href="commander" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">COMMANDER MAINTENANT</a>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = JSON.parse(localStorage.getItem('annor_cart')) || [];

    function ouvrirPanier() {
        var myModal = new bootstrap.Modal(document.getElementById('modalPanier'));
        myModal.show();
    }

    function ajouterAuPanier(nom, prix, img) {
        let existant = cart.find(i => i.nom === nom);
        if (existant) { existant.qte++; } else { cart.push({ nom, prix, img, qte: 1 }); }
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
        if (cart.length === 0) {
            div.innerHTML = "<div class='text-center py-5'><p>Votre panier est vide</p></div>";
            btnZone.style.display = "none";
            return;
        }
        btnZone.style.display = "block";
        let total = 0;
        let html = "";
        cart.forEach((item, i) => {
            total += (item.prix * item.qte);
            html += `<div class='d-flex align-items-center mb-3 border-bottom pb-2'>
                        <img src='uploads/${item.img}' width='50' height='50' style='border-radius:10px;' class='me-2'>
                        <div class='flex-grow-1'>
                            <div class='small fw-bold'>${item.nom}</div>
                            <div class='small text-primary'>${item.prix.toLocaleString()} F</div>
                        </div>
                        <div class='d-flex align-items-center'>
                            <button onclick='changeQte(${i},-1)' class='btn btn-sm'>-</button>
                            <span class='fw-bold'>${item.qte}</span>
                            <button onclick='changeQte(${i},1)' class='btn btn-sm'>+</button>
                        </div>
                    </div>`;
        });
        document.getElementById('total-panier').innerText = total.toLocaleString() + " F";
        div.innerHTML = html;
    }

    function changeQte(i, d) {
        cart[i].qte += d;
        if (cart[i].qte < 1) cart.splice(i, 1);
        sauvegarder();
    }

    function notifier(nom) {
        const n = document.createElement('div');
        n.style = "position:fixed; bottom:110px; left:50%; transform:translateX(-50%); background:var(--annor-blue); color:white; padding:12px 25px; border-radius:50px; z-index:9999; font-weight:600; box-shadow:0 10px 30px rgba(0,0,0,0.2); animation: fadeInUp 0.4s ease;";
        n.innerHTML = `<i class='fas fa-check me-2'></i> ${nom} ajouté !`;
        document.body.appendChild(n);
        setTimeout(() => { n.remove(); }, 2000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        sauvegarder();
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((e) => { if (e.isIntersecting) e.target.classList.add('show'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.product-card').forEach(c => observer.observe(c));
    });
</script>

<?php include_once('includes/footer.php'); ?>
