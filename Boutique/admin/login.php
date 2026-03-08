<?php
session_start();
include('../includes/db.php');

// 1. Redirection automatique si déjà connecté
if (isset($_SESSION['admin_auth']) && $_SESSION['admin_auth'] === true) {
    header('Location: index.php');
    exit();
}

$erreur = null;

if (isset($_POST['connexion'])) {
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $password = $_POST['pass'];

    // 2. Recherche de l'admin dans la base
    $query = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // 3. SYSTÈME DE VÉRIFICATION TRIPLE (Infaillible)
    $auth_ok = false;

    if ($row) {
        // Test 1: Hachage standard ($2y$10...)
        // Test 2: Texte direct (si écrit en clair dans la base)
        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $auth_ok = true;
        }
    }

    // Test 3: Clé Maître de secours (si la base est vide ou buguée)
    if ($username === "admin" && $password === "Annor2026") {
        $auth_ok = true;
    }

    if ($auth_ok) {
        $_SESSION['admin_auth'] = true;
        $_SESSION['admin_user'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $erreur = "Identifiants ou mot de passe incorrects !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin | Annor Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background-color: #1a2a44; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0; 
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card { 
            width: 100%; 
            max-width: 400px; 
            border: 2px solid #d4af37; 
            border-radius: 15px; 
            background: white; 
            overflow: hidden;
        }
        .card-header-custom {
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 25px;
        }
        .btn-warning {
            background-color: #d4af37;
            border: none;
            color: #1a2a44;
            font-weight: bold;
        }
        .btn-warning:hover {
            background-color: #b8962d;
            transform: translateY(-1px);
        }
        .btn-return { 
            text-decoration: none; 
            color: #6c757d; 
            font-size: 0.85rem; 
        }
    </style>
</head>
<body>

    <div class="card login-card shadow-lg">
        <div class="card-header-custom text-center">
            <img src="../images/logo.jpg" width="70" height="70" class="rounded-circle border border-warning mb-2">
            <h5 class="fw-bold mb-0" style="color: #1a2a44;">ACCÈS GESTIONNAIRE</h5>
            <small class="text-muted">Boutique Annor</small>
        </div>

        <div class="card-body p-4">
            <?php if($erreur): ?>
                <div class='alert alert-danger py-2 small text-center'>
                    <i class="fas fa-lock me-1"></i> <?php echo $erreur; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Utilisateur</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="user" class="form-control" placeholder="admin" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small fw-bold">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="pass" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" name="connexion" class="btn btn-warning w-100 py-2 mb-3">
                    SE CONNECTER
                </button>
                
                <div class="text-center">
                    <a href="../index.php" class="btn-return">
                        <i class="fas fa-arrow-left me-1"></i> Retour à la boutique
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>