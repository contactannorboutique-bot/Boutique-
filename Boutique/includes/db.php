<?php
$host = "sql100.byetcluster.com"; 
$dbname = "if0_41339234_boutique"; 
$user = "if0_41339234"; 
$pass = "TON_VRAI_MOT_DE_PASSE_ICI"; // Le mot de passe de ton compte InfinityFree

// Connexion pour la boutique (PDO)
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {}

// Connexion pour l'admin (MySQLi)
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
?>