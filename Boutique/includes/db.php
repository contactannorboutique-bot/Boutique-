<?php
// Identifiants InfinityFree (Mis à jour selon tes captures)
$host = "sql100.byetcluster.com"; 
$dbname = "if0_41339234_boutique"; 
$user = "if0_41339234"; 

/* ATTENTION : Remplace 'TON_MOT_DE_PASSE' par le mot de passe 
   que tu trouveras dans ton interface InfinityFree 
   sous l'onglet "FTP Details" -> "FTP Password"
*/
$pass = "TON_MOT_DE_PASSE"; 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>