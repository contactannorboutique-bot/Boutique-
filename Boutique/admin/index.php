<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header('Location: login.php');
    exit();
}
include('../includes/db.php');

// --- RÉCUPÉRATION DES STATS ---
$total_art = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM articles"))['total'];
$total_vendu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM articles WHERE statut = 'livre'"))['total'];
$total_dispo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM articles WHERE statut = 'disponible'"))['total'];

// --- LOGIQUE PHP ---
if(isset($_POST['ajouter'])) {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = (int)$_POST['prix'];
    $cat = mysqli_real_escape_string($conn, $_POST['categorie']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $image = time() . "_" . $_FILES['image']['name']; // Nom unique pour éviter les doublons
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);
    
    mysqli_query($conn, "INSERT INTO articles (nom, prix, categorie, image, description, statut) VALUES ('$nom', '$prix', '$cat', '$image', '$desc', 'disponible')");
    header('Location: index.php?success=1'); exit();
}

if(isset($_POST['modifier'])) {
    $id = (int)$_POST['id_article'];
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = (int)$_POST['prix'];
    $cat = mysqli_real_escape_string($conn, $_POST['categorie']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    if(!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);
        $sql = "UPDATE articles SET nom='$nom', prix='$prix', categorie='$cat', description='$desc', image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE articles SET nom='$nom', prix='$prix', categorie='$cat', description='$desc' WHERE id=$id";
    }
    mysqli_query($conn, $sql);
    header('Location: index.php?modified=1'); exit();
}

if(isset($_GET['livre'])) {
    $id = (int)$_GET['livre'];
    mysqli_query($conn, "UPDATE articles SET statut = 'livre' WHERE id = $id");
    header('location: index.php'); exit();
}

if(isset($_GET['suppr'])) {
    $id = (int)$_GET['suppr'];
    mysqli_query($conn, "DELETE FROM articles WHERE id = $id");
    header('location: index.php'); exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annor Pro - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0d6efd; --dark: #1e293b; --light-bg: #f1f5f9; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--light-bg); color: var(--dark); }
        
        /* Navbar & Sidebar Style */
        .sidebar-brand { font-weight: 700; font-size: 1.5rem; letter-spacing: -1px; color: var(--primary); }
        .stat-card { border: none; border-radius: 16px; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        
        /* Table Style */
        .table-container { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .product-img { width: 48px; height: 48px; object-fit: cover; border-radius: 12px; shadow: inset 0 0 5px rgba(0,0,0,0.1); }
        .btn-action { border-radius: 10px; padding: 8px 12px; }
        
        /* Form Style */
        .form-control, .form-select { border-radius: 10px; padding: 10px 15px; border: 1px solid #e2e8f0; }
        .form-control:focus { box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); }
        
        .badge-cat { background: #e0e7ff; color: #4338ca; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top py-3">
    <div class="container">
        <a class="navbar-brand sidebar-brand" href="#"><i class="fas fa-gem me-2"></i>ANNOR<span class="text-dark">PRO</span></a>
        <div class="ms-auto d-flex align-items-center">
            <a href="../index.php" target="_blank" class="btn btn-outline-secondary btn-sm me-3 border-0"><i class="fas fa-external-link-alt me-1"></i> Boutique</a>
            <a href="logout.php" class="btn btn-danger btn-sm px-3 shadow-sm rounded-pill">Quitter</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card p-4 shadow-sm bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="mb-1 opacity-75">En Stock</h6><h2 class="mb-0 fw-bold"><?php echo $total_dispo; ?></h2></div>
                    <i class="fas fa-boxes fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-4 shadow-sm bg-white border">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="mb-1 text-muted">Ventes réalisées</h6><h2 class="mb-0 fw-bold text-success"><?php echo $total_vendu; ?></h2></div>
                    <i class="fas fa-shopping-cart fa-2x text-success opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-4 shadow-sm bg-white border">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="mb-1 text-muted">Total Catalogue</h6><h2 class="mb-0 fw-bold"><?php echo $total_art; ?></h2></div>
                    <i class="fas fa-layer-group fa-2x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-4"><i class="fas fa-plus-circle text-primary me-2"></i>Nouveau Produit</h5>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Désignation</label>
                        <input type="text" name="nom" class="form-control" placeholder="Nom de l'article" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Prix de vente (F CFA)</label>
                        <input type="number" name="prix" class="form-control" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Catégorie</label>
                        <select name="categorie" class="form-select">
                            <option value="chapeau_adulte">🎩 Chapeaux Adultes</option>
                            <option value="chapeau_enfant">🧒 Chapeaux Enfants</option>
                            <option value="bijoux">✨ Bijoux & Accessoires</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description courte</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Image du produit</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" name="ajouter" class="btn btn-primary w-100 fw-bold py-2 shadow">
                        <i class="fas fa-cloud-upload-alt me-2"></i> METTRE EN LIGNE
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="table-container p-0">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Inventaire Actif</h5>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Stock à jour</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4 py-3">ARTICLE</th>
                                <th>CATÉGORIE</th>
                                <th>PRIX</th>
                                <th class="text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $res = mysqli_query($conn, "SELECT * FROM articles WHERE statut = 'disponible' ORDER BY id DESC");
                            if(mysqli_num_rows($res) == 0): ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">Aucun produit en ligne.</td></tr>
                            <?php endif;
                            while($art = mysqli_fetch_assoc($res)): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="../uploads/<?php echo $art['image']; ?>" class="product-img border me-3 shadow-sm">
                                        <div>
                                            <div class="fw-bold mb-0"><?php echo $art['nom']; ?></div>
                                            <div class="text-muted small">ID: #<?php echo $art['id']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-cat"><?php echo str_replace('_', ' ', $art['categorie']); ?></span></td>
                                <td class="fw-bold text-dark"><?php echo number_format($art['prix'], 0, '.', ' '); ?> F</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary btn-action me-1" data-bs-toggle="modal" data-bs-target="#edit<?php echo $art['id']; ?>"><i class="fas fa-pen"></i></button>
                                        <a href="?livre=<?php echo $art['id']; ?>" class="btn btn-sm btn-outline-success btn-action me-1" title="Vendre"><i class="fas fa-check"></i></a>
                                        <a href="?suppr=<?php echo $art['id']; ?>" class="btn btn-sm btn-outline-danger btn-action" onclick="return confirm('Confirmer la suppression ?')"><i class="fas fa-trash"></i></a>
                                    </div>

                                    <div class="modal fade" id="edit<?php echo $art['id']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="fw-bold">Mise à jour produit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-4">
                                                    <input type="hidden" name="id_article" value="<?php echo $art['id']; ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Nom de l'article</label>
                                                        <input type="text" name="nom" class="form-control" value="<?php echo $art['nom']; ?>">
                                                    </div>
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Prix (F)</label>
                                                            <input type="number" name="prix" class="form-control" value="<?php echo $art['prix']; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Catégorie</label>
                                                            <select name="categorie" class="form-select">
                                                                <option value="chapeau_adulte" <?php if($art['categorie']=='chapeau_adulte') echo 'selected'; ?>>Chapeau Adulte</option>
                                                                <option value="chapeau_enfant" <?php if($art['categorie']=='chapeau_enfant') echo 'selected'; ?>>Chapeau Enfant</option>
                                                                <option value="bijoux" <?php if($art['categorie']=='bijoux') echo 'selected'; ?>>Bijoux</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Description</label>
                                                        <textarea name="description" class="form-control" rows="2"><?php echo $art['description']; ?></textarea>
                                                    </div>
                                                    <div class="mb-0">
                                                        <label class="form-label small fw-bold text-primary">Remplacer l'image (si besoin)</label>
                                                        <input type="file" name="image" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="submit" name="modifier" class="btn btn-primary w-100 py-2 fw-bold">ENREGISTRER</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
