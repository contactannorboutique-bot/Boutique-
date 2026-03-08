<?php
// 1. Tes identifiants InfinityFree
$host = "sql100.byetcluster.com"; 
$dbname = "if0_41339234_boutique"; 
$user = "if0_41339234"; 

/* REMPLACE BIEN 'TON_MOT_DE_PASSE' par celui caché derrière les étoiles sur InfinityFree */
$pass = "TON_MOT_DE_PASSE"; 

// 2. Connexion pour la partie BOUTIQUE (PDO)
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    // On ne bloque pas tout ici, on laisse mysqli tenter sa chance aussi
}

// 3. Connexion pour la partie ADMIN (MySQLi) - C'est celle que ton login.php utilise ($conn)
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Erreur de connexion base de données : " . mysqli_connect_error());
}

// Gestion des accents
mysqli_set_charset($conn, "utf8");
?>